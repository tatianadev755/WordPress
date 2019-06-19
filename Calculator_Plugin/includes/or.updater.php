<?php
/**
*
*	Origin Builder
*	(c) originbuilder.com
*
*/

if(!defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}


class or_updater{
	
	/*
	* get newest version
	*/
	public $version;
	/*
	*	the slug of primary file
	*/
	
	private $buy_link = 'http://bit.ly/originbuilder';
	
	function __construct(){
		
		add_filter( 'pre_set_site_transient_update_plugins', array( &$this, 'check_update' ) );

		add_filter( 'plugins_api', array( &$this, 'view_detail' ), 10, 3 );

		add_action( 'in_plugin_update_message-' .or_BASE, array( &$this, 'message_link' ) );
		
	}

	public function check_update ( $transient ){
		
		if( isset( $transient->response[ or_BASE ] ) )
			unset( $transient->response[ or_BASE ] );
			
		$response = $this->get_response();
		//$this->get_response();
		$plugin_info = get_plugin_data( or_FILE );
		
		if( isset( $response ) && !empty( $response ) && isset( $response['new_version'] ) ) {
			if( isset( $plugin_info['Version'] ) && !version_compare( $plugin_info['Version'], $response['new_version'], '<' ) )
				return $transient;
		}else return $transient;
			
		$response = array_merge( array( 'new_version' => '', 'url' => '', 'package' => '', 'name' => '' ), $response );
		
		if( $response === false )
			return $transient;
		
	    $obj = new stdClass();
	    
	    $obj->slug = or_SLUG;
	    $obj->new_version = $response['new_version'];
	    $obj->url = $response['url'];
	    $obj->name = $response['name'];
	    $obj->package = $response['package'];

	    $transient->response[ or_BASE ] = $obj;

	    return $transient;
	    
	}
	
	private function get_response( $detail = false ){

		$or = originbuilder::globe();
		
		$settings = $or->settings();
		
		$code = isset( $settings['license_key'] ) ? $settings['license_key'] : '';

		$url = str_replace( '=', '-d', base64_encode( site_url() ) );
		$url = 'http://originbuilder.net/originupdater/?verify='.base64_encode( $code );
		
		if( $detail !== false )
			$url .= '&view_details=1';
	
		$request = wp_remote_get( $url );
		$response = wp_remote_retrieve_body( $request );

		$response = (array)json_decode( $response );
				
		return $response;
	
	}
		
	public function view_detail( $a, $b, $arg ) {
		
		if ( isset( $arg->slug ) && strtolower( $arg->slug ) === strtolower( or_SLUG ) ) {
			
			$update_plugin = get_site_transient( 'update_plugins' );
			
			$response = $this->get_response( true );
			
			$info = array( 'name' => 'originbuilder', 'banners' => array( 'low' => 'http://server529.services.originbuilder.com/updates/banner-1140x500.png', 'high' => 'http://server529.services.originbuilder.com/updates/banner-1140x500.png' ), 'sections' => array( 'Error' => 'Sorry! Could not get details from server this moment.' ) );

			if ( isset( $response ) && is_array( $response ) )
				$info = array_merge( $info, $response );

			$detail = array();
			
			foreach( $info as $key => $value  ){
				if( is_object( $value ) )
					$value = (array)$value;
				
				$detail[ $key ] = $value;
			}
			
			$detail['slug'] = or_SLUG;
			$detail['author'] = ' ';
			$detail['homepage'] = 'http://originbuilder.com';
			
			return (object)$detail;
			
		}

		return false;
	}
	
	public function message_link(){

		if ( 1 !== 1 ) {
		/* Verify to upgrade */
			?><script>
				var viewdetails = document.querySelectorAll("tr#originbuilder-update .update-message a.thickbox")[0];
				while( viewdetails.nextSibling ){
					viewdetails.parentNode.removeChild( viewdetails.nextSibling );
				}
		   </script><?php
			echo '<br />Sorry! Plugin update has been disabled because you have not submitted License Key.';
			echo '<br />Please submit License Key via <a href="'.admin_url('/?page=origincomposer#or_product_license').'">Settings Page</a> to update';
		} else {
			//echo ' or <a href="' . wp_nonce_url( admin_url( 'update.php?action=upgrade-plugin&plugin=' .or_BASE ), 'upgrade-plugin_' .or_SLUG.'.php' ) . '">' . __( 'Update originbuilder Now.', 'originbuilder' ) . '</a>';
		}
		
	}
	
}
/**
*	Run
*/
new or_updater();