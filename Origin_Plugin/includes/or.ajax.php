<?php
/**
*
*	Origin Builder
*	(c) originbuilder.com
*
*/

	 add_action('wp_ajax_ajax_request', 'ajax_request');
add_action('wp_ajax_nopriv_ajax_request', 'ajax_request'); // Allow front-end submission
 
	 function ajax_request(){
	   $c=$_REQUEST['content'];
	   $id=$_REQUEST['id'];
		$data = array(
			'ID' => $id,
		 
			'post_content' => $c
		);
		 
	$data['post_status']  = 'publish';
		
    wp_update_post( $data );
 
die();
}

add_action( 'wp_ajax_or_responder_subscribes', 'or_responder_subscribes' );
add_action( 'wp_ajax_nopriv_or_responder_subscribes', 'or_responder_subscribes' );
function or_responder_subscribes(){	
	if(empty($_POST['responder'])){
		echo json_encode(array( 'error' => 'Error occur may be something wrong.'));
		die();
	}
	
	$data = get_option('or_subscriber_settings');
	
	if(empty($data[$_POST['responder']])){
		//print_r($data[$_POST['responder']]);
		echo json_encode(array('error'=>'please check settings.'));
		die();
	}
	
	$api = $data[$_POST['responder']];
	
	$objlist = new or_subscriber();
	$list = $objlist->switch_responder($api, 'subsCribe', $_POST['responder']);
	
	echo json_encode($list);
	
	die();
}

if(!defined('or_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}


class or_ajax{

	public function __construct(){

		$ajax_events = array(
			'get_welcome' 		=> false,
			'get_thumbn' 		=> true,
			'load_profile'		=> false,
			'download_profile'	=> false,
			'create_profile'	=> false,
			'rename_profile'	=> false,
			'delete_profile'	=> false,
			'upload_image'		=> false,
			'delete_section'	=> false,
			'update_section'	=> false,
			'instant_save'		=> false,
			'suggestion'		=> false,
			'tmpl_storage'		=> false,
			'verify_license'		=> false,
			'load_element_via_ajax'		=> false,
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {

			add_action( 'wp_ajax_or_' . $ajax_event, array( $this, esc_attr( $ajax_event ) ) );

			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_or_' . $ajax_event, array( $this, esc_attr( $ajax_event ) ) );
			}
		}
	}

	public function get_welcome(){

		$data = array(
			'message' => __('Hello, I\'m Origin Builder!', 'originbuilder')
		);

		wp_send_json( $data );
	}
	
	public function fpHandleUpload($url,$name) {
		require_once(ABSPATH . 'wp-admin' . '/includes/image.php');
		require_once(ABSPATH . 'wp-admin' . '/includes/file.php');
		require_once(ABSPATH . 'wp-admin' . '/includes/media.php');
		require_once(ABSPATH . 'wp-includes' . '/pluggable.php');
		// build up array like PHP file upload
		$file = array();
		$file['name'] = $name;
		$file['tmp_name'] = download_url($url);

		if (is_wp_error($file['tmp_name'])) {
			@unlink($file['tmp_name']);
			return new WP_Error('grabfromurl', 'Could not download image from remote source');
		}

		$attachmentId = media_handle_sideload($file, 0);

		// create the thumbnails
		$attach_data = wp_generate_attachment_metadata( $attachmentId,  get_attached_file($attachmentId));

		wp_update_attachment_metadata( $attachmentId,  $attach_data );

		return $attachmentId;	
	}
	
	public function upload_image(){
		
		$key = '';
		
		if( get_option( 'or-profile-origin-builder' ) !== false ){
				
			$getDB =  get_option( 'or-profile-origin-builder', true );
			
			if( isset( $getDB[1] ) && !empty( $getDB[1] ) && $getDB[1] !== null )
				$Mdata = $getDB[1];
			else $Mdata = base64_encode('');
			
			$Mdata = json_decode( base64_decode( $Mdata ) );
			
			for($i=0;$i<count($Mdata);$i++){
				if($_POST['sid'] == $Mdata[$i]->id){
					$rdata = $Mdata[$i]->data;
					$key = $i;
					break;
				}
			}
			
			$image = explode(',',$_POST['images']);
			$data = array();
			for($j=0;$j<count($image);$j++){
				$attachmentId = $this->fpHandleUpload('https://s3.amazonaws.com/originbuilder/img/' . $image[$j], 'or-'.$image[$j]);
				$repid = explode('.',$image[$j]);
				$rdata = str_replace( $repid[0], $attachmentId, $rdata);
			}
			
			$Mdata[$key]->data = $rdata;
			$Mdata[$key]->status = 1;
		}
		
		$Mdata = base64_encode( json_encode( $Mdata ) );
		
		update_option( 'or-profile-origin-builder', array( 'origin builder', $Mdata ) );
		
		$result = array(
			'status' => 'success',
			'data' => $Mdata
		);
				
		wp_send_json( $result );
	}

	public function get_thumbn( $abc ){

		$imid = !empty( $_GET['id'] ) ? $_GET['id'] : '';

		if( $imid == '' || $imid == 'undefined' )
		{
			header( 'location: '.or_URL.'/assets/images/get_logo.png' );
			exit;
		}

		if( $imid == 'featured_image' )
		{

		}

		$img = wp_get_attachment_image_src( esc_attr( $_GET['id'] ), (!empty( $_GET['size'] )?esc_attr( $_GET['size'] ):'medium') );

		if( !empty( $img[0] ) )
		{
			header( 'location: '.$img[0] );
		}
		else
		{
			header( 'location: '.or_URL.'/assets/images/default.jpg' );
		}
	}
	
	public function download_profile(){
		
		$name = isset( $_GET['name'] ) ? $_GET['name'] : '';
		
		if( empty( $name ) ){
			echo '[]';
			exit;
		}
		
		$name = sanitize_title( esc_attr( $name ) );
		
		if( get_option( 'or-profile-'.$name ) !== false ){
			
			$data = get_option( 'or-profile-'.$name, true );
			
			if( isset( $data[1] ) && !empty( $data[1] ) )
				echo base64_decode( $data[1] );
			else echo '[]';
			
		}else echo '[]';
		
		exit;
		
	}
		
	public function load_profile(){

		$or = originbuilder::globe();
		$profile_section_paths = $or->get_profile_sections();
		
		$name =  !empty( $_POST['name'] ) ? $_POST['name'] : '';
		$name = str_replace( array('..'), array( '' ), esc_attr( $name )  );
		
		$data = '';
		$slug = sanitize_title( $name );
		
		if( $name == '' ){
			
			$result = array(
				'message' =>  esc_html__('Error #623! The name must not be empty', 'originbuilder'),
				'status' => 'fail'
			);
			
		}
		else{
			
			if( isset( $profile_section_paths[ $name ] ) && is_file( untrailingslashit( ABSPATH ).$profile_section_paths[ $name ] ) ){
				
				$profile = $or->get_data_profile( $name );
			
				if( $profile !== false ){
					
					if( isset( $profile[0] ) && !empty( $profile[0] ) && $profile[0] !== null )
						$name = $profile[0];
					if( isset( $profile[1] ) && !empty( $profile[1] ) && $profile[1] !== null )
						$slug = $profile[1];
					if( isset( $profile[2] ) && !empty( $profile[2] ) && $profile[2] !== null )
						$data = $profile[2];
					
				}else{
					
					$message = esc_html__('Error #795! opening file Permission denied', 'originbuilder').': '.
								$profile_section_paths[ $name ];
					wp_send_json(
						array( 'message' => $message, 'status' => 'fail' )
					);
					
					return;
					
				}
				
			} 
			else if( get_option( 'or-profile-'.$name ) !== false ){
				
				$getDB =  get_option( 'or-profile-'.$name, true );
				
				$slug = $name;
				if( isset( $getDB[0] ) && !empty( $getDB[0] ) && $getDB[0] !== null )
					$name = $getDB[0];
				else $name = '';
				
				if( isset( $getDB[1] ) && !empty( $getDB[1] ) && $getDB[1] !== null )
					$data = $getDB[1];
				else $data = base64_encode('');
				
			}
			else{
				
				$message = esc_html__('Error #528! profile not found', 'originbuilder').': '.$name;
				wp_send_json(
					array( 'message' => $message, 'status' => 'fail' )
				);
				return;
			
			}

		}
		
		$result = array(

			'message' => '<div class="mgs-c-status"><i class="et-happy"></i></div><h1 class="mgs-t02">'.
						 esc_html__('Your sections profile has been downloaded successful', 'originbuilder').'</h1>'.
						 '<h2>'.esc_html__('Now you can use sections from new profile', 'originbuilder').'</h2>',
			'status' => 'success',
			'name' => $name,
			'slug' => $slug,
			'data' => $data

		);
			
		wp_send_json( $result );

		exit;

	}
	
	public function create_profile(){
		
		$name =  !empty( $_POST['name'] ) ? $_POST['name'] : '';
		
		if( $name == '' ){
			
			$result = array(
				'message' =>  esc_html__('Error #140! The name must not be empty', 'originbuilder'),
				'status' => 'fail'
			);
			
		}else{
		
			$slug =  !empty( $_POST['slug'] ) ? $_POST['slug'] : sanitize_title( $name );
			$data =  !empty( $_POST['data'] ) ? $_POST['data'] : '';
			
			if( get_option( 'or-profile-'.$slug ) === false ){
				
				add_option( 'or-profile-'.$slug, array( $name, $data ), null, 'no' );
				
				$result = array(
					'message' => __('Your sections profile has been created successful', 'originbuilder'),
					'status' => 'success',
					'name' => $name,
					'slug' => $slug
				);
				
			}else{
				
				$result = array(
					'message' =>  esc_html__('Error #101! The name must not be empty', 'originbuilder'),
					'status' => 'fail',
					'name' => $name,
					'slug' => $slug
				);
			}
		
		}
			
		wp_send_json( $result );

		exit;
		
	}
	
	public function rename_profile(){
		
		
		$name =  !empty( $_POST['name'] ) ? $_POST['name'] : '';
		
		if( $name == '' ){
			
			$result = array(
				'message' =>  esc_html__('Error #197! The name must not be empty', 'originbuilder'),
				'status' => 'fail'
			);
			
		}else{
		
			$slug =  !empty( $_POST['slug'] ) ? $_POST['slug'] : sanitize_title( $name );
			$data =  !empty( $_POST['data'] ) ? $_POST['data'] : '';
				
			if( get_option( 'or-profile-'.$slug ) === false ){
					
				$result = array(
					'message' => __('Error #501! could not find profile', 'originbuilder'),
					'status' => 'fail',
					'name' => $name,
					'slug' => $slug
				);
				
			}else{
				
				$data_db = get_option( 'or-profile-'.$slug, true );
				
				$data_db[0] = $name;
				
				update_option( 'or-profile-'.$slug, $data_db );
				
				
				$result = array(
					'message' =>  esc_html__('The profile has been changed', 'originbuilder'),
					'status' => 'success',
					'name' => $name,
					'slug' => $slug
				);
				
			}
		
		}
			
		wp_send_json( $result );

		exit;
		
	}
		
	public function delete_profile(){
		
		
		$slug =  !empty( $_POST['slug'] ) ? $_POST['slug'] : '';
		
		if( $slug == '' ){
			
			$result = array(
				'message' =>  esc_html__('Error #167! The slug must not be empty', 'originbuilder'),
				'status' => 'fail'
			);
			
		}else{
				
			if( get_option( 'or-profile-'.$slug ) === false ){
			
				$result = array(
					'message' => __('Error #723! could not find profile', 'originbuilder'),
					'status' => 'fail',
					'slug' => $slug
				);
			}else{
				
				delete_option( 'or-profile-'.$slug );
				
				$result = array(
					'message' =>  esc_html__('The profile has been deleted', 'originbuilder'),
					'status' => 'success',
					'slug' => $slug
				);
			}
			
		
		}
			
		wp_send_json( $result );

		exit;
		
	}
	
	public function update_section(){
		
		$slug =  !empty( $_POST['slug'] ) ? $_POST['slug'] : '';
		
		if( $slug == '' ){
			
			$result = array(
				'message' =>  esc_html__('Error #193! The slug must not be empty', 'originbuilder'),
				'status' => 'fail'
			);
			
		}else{
			
			$id =  !empty( $_POST['id'] ) ? $_POST['id'] : '';
			$name =  !empty( $_POST['name'] ) ? $_POST['name'] : '';
			$data =  !empty( $_POST['data'] ) ? $_POST['data'] : '';
			
			if( !empty( $data ) )
				$data = json_decode( base64_decode( $data ) );
				
			if( get_option( 'or-profile-'.$slug ) === false ){
				
				$or = originbuilder::globe();
				$profile = $or->get_data_profile( $slug );
				
				if( $profile !== false ){
					
					$profile_data = json_decode( base64_decode( $profile[2] ) );
					$found = false;
					
					foreach( $profile_data as $key => $value ){
						if( $value->id == $id ){
							$profile_data[ $key ] = $data;
							$found = true;
						}
					}
					
					if( $found === false )
						array_push( $profile_data, $data );
					
					$data = base64_encode( json_encode( $profile_data ) );
				
				}else{
				
					$data = base64_encode( json_encode( array( $data ) ) );
				
				}
				
				add_option( 'or-profile-'.$slug, array( $name, $data ) , null, 'no' );
				
				$result = array(
					'message' =>  esc_html__('The section has been updated', 'originbuilder'),
					'status' => 'success',
					'name' => $name,
					'data' => $data,
					'slug' => $slug
				);
				
				
			}
			else
			{
				
				$data_db = get_option( 'or-profile-'.$slug, true );
				
				$from_db = json_decode( base64_decode( $data_db[1] ) );
				
				if( is_array( $from_db ) ){
				
					$found = false;
					
					if( is_array( $from_db ) ){
						foreach( $from_db as $key => $val ){
							
							if( $val->id == $id ){
								$from_db[ $key ] = $data;
								$found = true;
							}
							
						}
					}
					
					if( !$found )
						array_push( $from_db, $data );
				
				}else{
					$from_db = array( $data );
				}
					
				$from_db = base64_encode( json_encode( $from_db ) );
				
				update_option( 'or-profile-'.$slug, array( $data_db[0], $from_db ) );
				
				
				$result = array(
					'message' =>  esc_html__('The section has been updated', 'originbuilder'),
					'status' => 'success',
					'name' => $data_db[0],
					'data' => $from_db,
					'slug' => $slug
				);
				
			}
		
		}
			
		wp_send_json( $result );

		exit;
		

	}
	
	public function delete_section(){ 
		
		$name =  isset( $_POST['name'] ) ? $_POST['name'] : '';
		$id =  isset( $_POST['id'] ) ? $_POST['id'] : '';
		$slug =  !empty( $_POST['slug'] ) ? $_POST['slug'] : sanitize_title( $name );
		$data =  !empty( $_POST['data'] ) ? $_POST['data'] : '';
			
		if( get_option( 'or-profile-'.$slug ) === false ){
			
			$sections = json_decode( base64_decode( $data ) );
			
			if( is_array( $sections ) ){
				
				$data = array();
				
				foreach( $sections as $key => $value ){
					
					if( !isset( $value->id ) )
						$value->id = rand( 100000, 1000000 );
					
					if( $value->id != $id )
						array_push( $data, $value );
				}
				
				$data = base64_encode( json_encode( $data ) );
				
				add_option( 'or-profile-'.$slug, array( $name, $data ) , null, 'no' );
			
				$result = array(
					'message' =>  esc_html__('The section has been removed', 'originbuilder'),
					'status' => 'success',
					'name' => $name,
					'data' => $data,
					'slug' => $slug
				);
				
			}else{
				
				$result = array(
					'message' =>  esc_html__('Error profile data structure #416', 'originbuilder'),
					'status' => 'fail',
					'name' => $name,
					'slug' => $slug
				);
				
			}
			
		}else{
			
			$data_db = get_option( 'or-profile-'.$slug, true );
			
			$sections = @json_decode( base64_decode( $data_db[1] ) );
			
			if( is_array( $sections ) ){
				
				$data = array();
				
				foreach( $sections as $key => $value ){
					
					if( !isset( $value->id ) )
						$value->id = rand( 100000, 1000000 );
					
					if( $value->id != $id )
						array_push( $data, $value );
						
				}
				
				$data_db[1] = base64_encode( json_encode( $data ) );
				
				update_option( 'or-profile-'.$slug, $data_db );
			
			
				$result = array(
					'message' =>  esc_html__('The section has been removed', 'originbuilder'),
					'status' => 'success',
					'name' => $data_db[0],
					'data' => $data_db[1],
					'slug' => $slug
				);
				
			}else{
				
				$result = array(
					'message' =>  esc_html__('Error profile data structure #426', 'originbuilder'),
					'status' => 'fail',
					'name' => $data_db[0],
					'slug' => $slug
				);
				
			}
			
		}
		
		wp_send_json( $result );

		exit;
	
	}

	public function instant_save(){
		
		check_ajax_referer( 'or-nonce', 'security' );
		
		if( !isset( $_POST['id'] ) || !isset( $_POST['title'] ) || !isset( $_POST['content'] ) ){
			echo $this->msg( __('Error: Invalid Post ID', 'originbuilder'), 0 );
			exit;
		}
		
		$id = esc_attr( $_POST['id'] );
		if( get_post_status( $id ) === false ){
			echo $this->msg( __('Error: Post not exist', 'originbuilder'), 0 );
			exit;
		}
		
		$or = originbuilder::globe();
		$get_post = get_post( $id );
		
		if( !isset( $get_post ) || $or->user_can_edit( $get_post ) === false ){
			echo $this->msg( __('Error: You do not have permission to edit this post', 'originbuilder'), 0 );
			exit;
		}
		
		$args = sanitize_post( array(
			
			'ID'           => $_POST['id'],
			'post_title'   => $_POST['title'],
			'post_content' => $_POST['content'],
			'css' => $_POST['css'],
			'classes' => $_POST['classes'],
			
		), 'db' );

		$data = array(
			'ID' => $args['ID'],
			'post_title'   => $args['post_title'],
			'post_content' => $args['post_content']
		);
		
		if( current_user_can( 'publish_pages' ) ){
			$data['post_status']  = 'publish';
		}
		
		if( isset( $_POST['task'] ) && $_POST['task'] == 'frontend' ){
			
			unset( $data['post_title'] );
			if( wp_update_post( $data ) )
				echo $this->msg( __('Your content has been saved Successful', 'originbuilder'), 1 );
			else echo $this->msg( __('Error: could not save the content', 'originbuilder'), 0 );
			
			exit;
			
		}
		
		echo wp_update_post( $data );
		
		$param = get_post_meta( $id, 'or_data' );
		if( $param === false ){
			
			add_post_meta( $id, 'or_data', array( 'mode' => 'or', 'css' => $args['css'], 'classes' => $args['classes'] ) );
		
		}else{
			
			$param['mode'] = 'or';
			$param['css'] = $args['css'];
			$param['classes'] = $args['classes'];
			
			update_post_meta( $id, 'or_data', $param );
			
		}
		
		exit;
		
	}

	public function suggestion(){
		
		check_ajax_referer( 'or-nonce', 'security' );
		
		$data = array( '__session' => isset($_POST['session'])?$_POST['session']:'' );
		$args = array( 's' => isset($_POST['s'])?$_POST['s']:'', 
					   'post_type' => !empty($_POST['post_type'])?esc_attr($_POST['post_type']):'any',
					   'category' => isset($_POST['category'])?esc_attr($_POST['category']):'',
					   'category_name' => isset($_POST['category_name'])?esc_attr($_POST['category_name']):'',
					   'numberposts' => !empty($_POST['numberposts'])?esc_attr($_POST['numberposts']):120,
					);
		if( isset($_POST['taxonomy']) && !empty($_POST['taxonomy']) ){
			
			if( !isset($_POST['terms']) || empty($_POST['terms']) ){
				
				$taxonomyObj = get_taxonomy(esc_attr($_POST['taxonomy']));
				
				if( isset( $taxonomyObj ) && isset( $taxonomyObj->object_type ) && isset( $taxonomyObj->object_type[0] ) )
					$args['post_type'] = $taxonomyObj->object_type[0];

				$terms = get_terms( array(
				    'taxonomy' => esc_attr($_POST['taxonomy']),
				    'hide_empty' => true,
				));
				$list_terms = array();
				foreach( $terms as $k => $term ){
					$list_terms[] = $term->slug;
				}
				$args['tax_query'] = array(
		            'taxonomy' => esc_attr($_POST['taxonomy']),
		            'field' => 'slug',
			        'terms' => $list_terms[0],
			        'operator' => 'AND'
			    );
		    }else{
				$args['tax_query'] = array(
			        array(
			            'taxonomy' => esc_attr($_POST['taxonomy']),
			            'field' => 'slug',
			            'terms' => explode( ',', esc_attr($_POST['terms']) ),
			            'operator' => 'AND'
			        )
			    );
		    }
	    }
	    
		if ( 0 === strlen( $args['s'] ) ) {
			unset( $args['s'] );
		}
		add_filter( 'posts_search', 'or_filter_search', 500, 2 );
		$posts = get_posts( $args );
		//print_r($args);
		if ( is_array( $posts ) && ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				if( !isset( $data[ $post->post_type ] ) )
					$data[ $post->post_type ] = array();	
				$data[ $post->post_type ][] = $post->ID.':'.esc_html(str_replace( array(':',','), array('',''), $post->post_title));
			}
		}
	
		wp_send_json( $data );

	}
	
	public function tmpl_storage(){
		
		check_ajax_referer( 'or-nonce', 'security' );
		
		$or = originbuilder::globe();
		$or->convert_paramTypes_cache();
		require_once or_PATH.'/includes/or.templates.php';
		
		exit;
		
	}
	
	public function verify_license(){
		
		check_ajax_referer( 'or-verify-nonce', 'security' );
		
		$license = isset( $_POST['license'] ) ? esc_html( $_POST['license'] ) : '';
		
		if( strlen( $license ) != 41 )
		{
			echo '-2';
			exit;
		}
		
		$theme = esc_html( wp_get_theme() );
		$domain = str_replace( '=', '-d', base64_encode( site_url() ) );
		$url = 'https://originbuilder.com/?or_store_action=verify_license&domain='.$domain.'&theme='.$theme.'&license='.$license;
	
		$request = wp_remote_get( $url );
		$response = wp_remote_retrieve_body( $request );
		
		$response = json_decode( $response );
		
		$data = array(
			'code' => '',
			'theme' => $theme,
			'domain' => $domain,
			'date' => date('Y-m-d H:i:s'),
			'stt' => 0
		);
		
		if( isset( $response->stt ) )
			$data['stt'] = $response->stt;
		
		if( isset( $response->code ) )
			$data['code'] = $response->code;
		
		if( isset( $response->date ) )
			$data['date'] = $response->date;
		
		if( $data['stt'] == 1 ){
			
			if( get_option( 'or_tkl_cc' ) === false ){			
				add_option( 'or_tkl_cc', $data['code'] , null, 'no' );
			}else{
				update_option( 'or_tkl_cc', $data['code'] );
			}
			if( get_option( 'or_tkl_dd' ) === false ){			
				add_option( 'or_tkl_dd', $data['date'] , null, 'no' );
			}else{
				update_option( 'or_tkl_dd', $data['date'] );
			}
			
		}
			
		wp_send_json( $data );
		
		exit;
		
	}
	
	public function load_element_via_ajax(){
		
		if( !isset( $_POST['model'] ) || !isset( $_POST['code'] ) ){
			wp_send_json( array( 'status' => '-1' ) );
			exit;
		}
		
		if( isset( $_POST['ID'] ) && get_post_status( $_POST['ID'] ) !== false ){
			global $post;
			$post = get_post( $_POST['ID'] );
		}
		
		include 'or.front.php';
		
		global $or, $or_front, $shortcode_tags;
		
		$code = isset( $_POST['code'] ) ? $_POST['code'] : '';
		
		$code = $or_front->do_filter_shortcode( base64_decode( $code ) );

		wp_send_json( array( 
			'status' => '1',
			'model' => $_POST['model'],
			'html' => '<!--or s '.$_POST['model'].'-->'.trim( do_shortcode( $code ) ).'<!--or e '.$_POST['model'].'-->',
			'css' => $or_front->get_global_css(),
			'callback' => $or->live_js_callback
		));
		
		exit;
		
	}

	public function msg( $s = '', $t = 1 ){
		if( $t == 1 )
			return '<h3 class="mesg success"><i class="et-happy"></i><br />'.$s.'</h3>';
		else return '<h3 class="mesg error"><i class="et-sad"></i><br />'.$s.'</h3>';
	}

}

#Start or_Ajax
new or_ajax();

add_action('wp_ajax_or_getGoogleShareCount', 'or_getGoogleShareCount');
add_action('wp_ajax_nopriv_or_getGoogleShareCount', 'or_getGoogleShareCount');