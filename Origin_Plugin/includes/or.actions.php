<?php
/**
*
*	Origin Builder
*	(c) originbuilder.com
*
*/
if(!defined('or_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}



/*
*	admin init
*/



add_action('admin_init', 'or_admin_init');
function or_admin_init() {

	if (get_option('or_do_activation_redirect', false)) {

	    delete_option('or_do_activation_redirect');

	    if( !isset($_GET['activate-multi']) )
	    	wp_redirect("options-general.php?page=originbuilder");
	}
	/* register or options */
	register_setting( 'origincomposer_group', 'or_options', 'or_validate_options' );
	
	$roles = array( 'administrator', 'admin', 'editor' );

	foreach ( $roles as $role ) {
		if( ! $role = get_role( $role ) ) 
			continue;
		$role->add_cap( 'access_origincomposer'  );
	}
		

}


register_activation_hook( or_FILE, 'or_plugin_activate' );
function or_plugin_activate() {
	require dirname(__FILE__) . '/or.predefinedtemplate.php';
	add_option('or_do_activation_redirect', true);
}



/*
*	Load languages
*/



add_action('plugins_loaded', 'or_load_lang');
function or_load_lang() {
	load_plugin_textdomain( 'originbuilder', false, or_SLUG . '/locales/' );
}



/*
*	Register assets ( js, css, font icons )
*/
 if(!is_admin()){
wp_enqueue_style('or-3', or_URL.'/includes/frontend/builder/assets/or.front.builder.css', false );
 }

add_action('admin_enqueue_scripts', 'or_assets', 1 );
function or_assets(){
	
	global $or;
	
	wp_enqueue_style('or-global', or_URL.'/assets/css/or.global.css', false, or_VERSION );
	
	wp_enqueue_style('animate', trailingslashit(or_URL) . 'assets/css/animate.css');
	
	wp_enqueue_style('themify.min.css', trailingslashit(or_URL) . 'assets/fonts/themify/themify.min.css');

	// Stop loading assets from admin if not in allows content type
	if( is_admin() && !or_admin_enable() )
		return;
	
	wp_enqueue_script( 'wp-util' );
	
	$p = or_URL.'/assets/css/';
	
	$args = array( 
		'builder' => $p.'or.builder.css', 
		'params' => $p.'or.params.css', 
		/*'jssor-slider-css' => $p.'jssor-slider.css', */
		//'icons' => $p.'icons.css'
	);
	
	$icon_sources = $or->get_icon_sources();
	if(  is_array( $icon_sources ) && count( $icon_sources ) > 0 ){
		$i = 1;
		foreach( $icon_sources as $icon_source ){
			$args['sys-icon-'.$i++] = $icon_source;
		}
	}
	
	$args = apply_filters( 'or-core-styles', $args );
	
	if( originbuilder::is_live() ){
		$args['live'] = or_URL.'/includes/frontend/builder/assets/or.live.builder.css';
	}
	
	foreach( $args as $k => $v ){
		wp_enqueue_style('or-'.$k, $v, false, or_VERSION );
	}

	wp_register_script( 'or-builder-backend-js', or_URL.'/assets/js/or.builder.js', array('jquery','wp-util'), or_VERSION, true );
	wp_enqueue_script( 'or-builder-backend-js' );

	$p = '/assets/js/or.';
	$args = apply_filters( 'or-core-scripts', array( 
		'tools' => $p.'tools.js', 
		'views' => $p.'views.js', 
		'params' => $p.'params.js', 
		'jscolor' => $p.'vendors/jscolor.js', 
		'moment' => $p.'vendors/moment.js', 
		'pikaday' => $p.'vendors/pikaday.js', 
		'jssor_slider_js' => $p.'vendors/jssor.slider.mini.js',  
		'freshslider' => $p.'vendors/freshslider.min.js') 
	);
	
	if( originbuilder::is_live() ){
		$args['front-builder'] = '/includes/frontend/builder/assets/or.front.js';
		$args['front-detect'] = '/includes/frontend/builder/assets/or.detect.js';
	}
	
	foreach( $args as $k => $v ){
		wp_register_script( 'or-'.$k, or_URL.$v, null, or_VERSION, true );
		wp_enqueue_script( 'or-'.$k );
	}

	wp_enqueue_media();
	wp_enqueue_style( 'wp-pointer' );
		wp_enqueue_style('or-global1', or_URL.'/assets/css/or.custom.css', false, or_VERSION );
		//wp_enqueue_style('custom-editor-style.css', or_URL.'/assets/css/custom-editor-style.css', false, or_VERSION );
}



/**
*	Register filter for menu title
*/


function or_filter_admin_menu_title( $menu_title ){

	$current = get_site_transient( 'update_plugins' );

    if ( ! isset( $current->response[ or_BASE ] ) )
		return $menu_title;

	return $menu_title . '&nbsp;<span class="update-plugins"><span class="plugin-count">1</span></span>';
}

add_filter( 'or_admin_menu_title', 'or_filter_admin_menu_title');


/*
*	Add Menu Page in Backend
*/

add_action('admin_bar_menu', 'or_admin_bar', 999 );
function or_admin_bar( $wp_admin_bar ) {
	
	if( !is_admin() ){
		
		$or = originbuilder::globe();
		if( $or->user_can_edit() !== false ){
			$wp_admin_bar->add_node(array(
				'id'    => 'or-edit',
				'title' => 'Live Edit<style>#wpadminbar #wp-admin-bar-or-edit>.ab-item:before {content: "\f464";top: 2px;}</style>',
				'href'  => admin_url('options-general.php?page=originbuilder&or_action=live-editor&id='.get_the_id())
			));
		}
	}
}

/*
*	Register settings page
*/


add_action('admin_menu', 'or_settings_menu');
function or_settings_menu() {
	
	$capability = apply_filters( 'access_origincomposer_capability', 'access_origincomposer' );
	$icon = or_URL.'/assets/images/logo100.png';
	$menu_title = apply_filters( 'or_admin_menu_title', __( 'Origin Builder' , 'originbuilder' ) );

	 

	remove_submenu_page( 'originbuilder', 'originbuilder' );

	add_submenu_page(
		'options-general.php',
		esc_html__('Origin Builder WP', 'originbuilder'),
		esc_html__('Origin Builder', 'originbuilder'),
		$capability,
		'originbuilder',
		'or_main_page'
	);
	
/*	add_submenu_page(
		'options-general.php',
		esc_html__('origin subscriber', 'wpleadpages'),
		esc_html__('origin subscriber', 'wpleadpages'),
		$capability,
		'or-lead-subscriber',
		'or_lead_subscriber'
	);
   
 add_submenu_page(
		'options-general.php',
		esc_html__('Sections Manager - Origin Builder', 'originbuilder'),
		esc_html__('Sections Manager', 'originbuilder'),
		$capability,
		'or-sections-manager',
		'or_sections_manager'
	);*/
}



add_action( 'admin_head', 'or_admin_header' );
add_action( 'edit_form_after_editor', 'or_after_editor' );
add_action( 'admin_footer', 'or_admin_footer' );

 

/*
*	Header init
*/



function or_admin_header(){

	if( is_admin() && !or_admin_enable() )
		return;
	
	$or = originbuilder::globe();
	
?>
<script type="text/javascript">

	var site_url = '<?php echo site_url(); ?>',
		plugin_url = '<?php echo or_URL; ?>',
		shortcode_tags = '<?php

			global $shortcode_tags;

			$arrg = array();
			$maps = $or->get_maps();

			foreach( $maps as $key => $val ){
				array_push( $arrg, $key );
			}

			foreach( $shortcode_tags as $key => $val ){
				if( !in_array( $key, $arrg ) )
					array_push( $arrg, $key );
			}

			echo implode( '|', $arrg );
		
		?>',
		<?php 
			
			if( isset( $_GET['id'] ) )
				echo 'or_post_ID = "'.$_GET['id'].'",'; 
		?>
		or_version = '<?php echo or_VERSION; ?>',
		or_ajax_url = "<?php echo site_url('/wp-admin/admin-ajax.php'); ?>",
		or_profiles = <?php echo $or->get_profiles_db( false ); ?>,
		or_profiles_external = <?php echo json_encode( (object)$or->get_profile_sections() ); ?>,
		or_ajax_nonce = '<?php echo wp_create_nonce( "or-nonce" ); ?>';

		<?php 
			if( get_option('or_tkl_cc') ){
				echo get_option('or_tkl_cc', true);
			}
		?>
		
</script>
<?php
}

/*
*	Put post settings forms after editor
*/


function or_after_editor( $post ) {

	if( !is_admin() || !or_admin_enable() )
		return;
		
	?>
	<div style="display:none;" id="or-post-settings">
		
		<?php
			
			$data = array( "mode" => "", "classes" => "", "css" => "" );
			
			if( isset( $post ) && isset( $post->ID ) && !empty( $post->ID ) ){
				$data = get_post_meta( $post->ID , 'or_data', true );
				if( empty( $data ) ){
					$data = array( "mode" => "", "classes" => "", "css" => "" );
				}
			}

		?>
		
		<input type="hidden" name="origincomposer_meta[mode]" id="or-post-mode" value="<?php echo esc_attr( $data['mode'] ); ?>" />
		<input type="hidden" name="origincomposer_meta[classes]" id="or-page-body-classes" value="<?php echo esc_attr( $data['classes'] ); ?>" />
		<textarea id="or-page-css-code" name="origincomposer_meta[css]" ><?php echo esc_attr( $data['css'] ); ?></textarea>
		
		<?php 
			
			if( $data['mode'] == 'or' ){
				echo '<style type="text/css">#postdivrich{visibility: hidden;position:relative;}</style>';
			}			
		?>
		
		 <script tyle="text/javascript">
			var or_editor_tabs = document.querySelectorAll('#wp-content-editor-tools .wp-editor-tabs');
			if( or_editor_tabs[0] !== undefined ){
				var or_btn = document.createElement('button');
				or_btn.type = 'button'; or_btn.id = 'or-switch-builder';
				or_btn.innerHTML = '<img src="<?php echo or_URL; ?>/assets/images/get_logo_w.png" width="20" /><span> Origin Builder</span>';
				or_editor_tabs[0].appendChild( or_btn );
				<?php /*if( $data['mode'] == 'or' ){ ?>document.getElementById('postdivrich').className += ' first-load';<?php } */ ?>
			}
		</script> 
		
	</div>
	<?php

}



/*
*	Load builder template at footer
*/

function or_admin_footer(){

	if( is_admin() && !or_admin_enable() )
		return;

	do_action('or_before_footer');
	
	require_once or_PATH.'/includes/or.js_languages.php';
	require_once or_PATH.'/includes/or.nocache_templates.php';
	
	if( originbuilder::is_live() ){
		
		require_once or_PATH.'/includes/frontend/builder/or.templates.php';
	
	}
	
	do_action('or_after_footer');
	
}


/*
*	Save post settings
*/


add_action( 'save_post', 'or_process_save', 10, 2 );
function or_process_save( $post_id, $post ) {

	if( !empty( $_POST['origincomposer_meta'] ) ){
		if( !add_post_meta( $post->ID , 'or_data' , $_POST['origincomposer_meta'], true ) ){
			update_post_meta( $post->ID , 'or_data' , $_POST['origincomposer_meta'] );
		}
	}else if( !isset( $_POST['action'] ) || ( isset( $_POST['action'] ) && $_POST['action'] != 'or_instant_save' ) ){
		//delete_post_meta( $post->ID , 'or_data' );
	}

}

/*
*	Include admin pages' file
*/


function or_main_page() {
	
	wp_enqueue_style('or.subscriber',  or_URL.'/assets/css/or.subscriber.css');
	
	if( originbuilder::is_live() )
		require_once or_PATH.KDS.'includes'.KDS.'or.live.builder.php';
	else require_once or_PATH.KDS.'includes'.KDS.'or.settings.php';

}

function or_sections_manager() {

	require_once or_PATH.KDS.'includes'.KDS.'or.sections.php';

}


function or_admin_notice_error() {
	
	echo '<style type="text/css">#postdivrich{visibility: visible !important;position:relative;}</style>';
	
	
	if(isset($_GET['page']) && $_GET['page'] == 'originbuilder'){
		 //remove_action( 'admin_notices', 'update_nag', 3 );
		return;
	}
	$class = 'notice notice-error';
	$message1 = 'Origin Builder is pending domain authorization.';
	$message2 = 'Activate Origin Builder';

	printf( '<div class="%1$s"><p>%2$s</p><p><strong><a href="'.admin_url().'options-general.php?page=originbuilder">%3$s</a></strong></p></div>', $class, $message1, $message2 ); 
}
//add_action( 'admin_notices', 'or_admin_notice_error' );

function or_lead_subscriber() {
	
	
	require_once or_PATH.KDS.'includes'.KDS.'or.lead.subscriber.php';
}


add_action( 'wp_ajax_or_save_subscriber_setting', 'or_save_subscriber_setting' );
add_action( 'wp_ajax_nopriv_or_save_subscriber_setting', 'or_save_subscriber_setting' );
function or_save_subscriber_setting(){
	//print_r($_POST);
	
	$data = get_option('or_subscriber_settings');
	
	if(empty($_POST['responder'])){
		echo json_encode(array( 'error' => 'Error occur may be something wrong.'));
		return;
	}
	
	$data[$_POST['responder']] = $_POST['apikey'];
	
	if(isset($_POST['eraser']) && $_POST['eraser'] == 1){
		update_option('or_subscriber_settings', $data);	
		die();
	}
	
	$objlist = new or_subscriber();
	$list = $objlist->switch_responder($_POST['apikey'], 'getList', $_POST['responder']);
	
	if(!isset($list['error'])){
		update_option('or_subscriber_settings', $data);	
		//echo json_encode($list);
		echo json_encode(array('success'=>true));
	}else{
		echo json_encode(array( 'error' => 'An error occurred while getting your list.'));
	}
	
	die();
}

add_action( 'wp_ajax_or_get_subscriber_setting', 'or_get_subscriber_setting' );
add_action( 'wp_ajax_nopriv_or_get_subscriber_setting', 'or_get_subscriber_setting' );
function or_get_subscriber_setting(){	
	if(empty($_POST['responder'])){
		echo json_encode(array( 'error' => 'Error occur may be something wrong.'));
		return;
	}
	
	$data = get_option('or_subscriber_settings');
	
	if(empty($data[$_POST['responder']])){
		echo json_encode(array('error'=>'please check settings.'));
		die();
	}
	
	$api = $data[$_POST['responder']];
	
	$objlist = new or_subscriber();
	$list = $objlist->switch_responder($api, 'getList', $_POST['responder']);
	
	echo json_encode($list);
	
	die();
}

add_action( 'wp_ajax_or_save_social_setting', 'or_save_social_setting' );
add_action( 'wp_ajax_nopriv_or_save_social_setting', 'or_save_social_setting' );
function or_save_social_setting(){
	
	$data = get_option('or_social_settings');
	
	if(empty($_POST['social'])){
		echo json_encode(array( 'error' => 'Error occur may be something wrong.'));
		return;
	}
	
	$data[$_POST['social']] = $_POST['apikey'];
	$result = update_option('or_social_settings', $data);			
	if($result){
		echo json_encode(array('success' => true));
	}else{
		echo json_encode(array( 'error' => true));
	}
	
	die();
}