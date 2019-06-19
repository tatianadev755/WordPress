<?php
/*
Plugin Name: Origin Builder
Plugin URI: http://originbuilder.com
Description: The simplest and most powerful WordPress visual editor for everyone 
Version: 1.0.9
Author: Origin Builder
Author URI: http://originbuilder.com
*/

if( defined('or_VERSION') || isset( $GLOBALS['or'] ) ) {
	die('ERROR: the plugin has been loaded before.');
}
/**
*	unorthodox
*/
if(!defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

/**
*	Start originbuilder here
*/
class originbuilder{
	/**
	*	Global Settings
	*/
	private $settings = array();
	/**
	* Definde where to load shortcode template
	*/
	private $template_path = null;
	/**
	* re-definde where to load shortcode template such as in theme or 3rd party plugin
	*/
	private $template_path_extend = array();
	/**
	* register list of external sections
	*/
	private $profile_section_paths = array();
	/**
	* Maps of core & extended
	*/
	private $maps = array();
	/**
	* list of views
	*/
	public $maps_views = array();
	/**
	* list of views
	*/
	public $maps_view = array();
	/**
	* Param types
	*/
	private $param_types = array();
	/**
	*	support content types
	*/
	private $param_types_cache = array();
	/** 
	*	Support icons
	*/
	private $icon_sources = array();
	/**
	*	support content types
	*/
	private $content_types = array();
	/**
	*	required content types
	*/
	private $required_content_types = array( 'page' );
	/**
	*	All filters of shortcodes
	*/
	public $filters = array();
	/**
	*	register callback for live view on front-end editor
	*/
	public $live_js_callback = array();
	/**
	*	status of premium version
	*/
	public $verify = false;

	public function __construct() {

		// Constants
		$version = get_file_data( __FILE__, array('Version') );
		define('or_VERSION', $version[0] );
		define('KDS', DIRECTORY_SEPARATOR );
		define('or_FILE', __FILE__);
		define('or_PATH', dirname(__FILE__));
		define('or_URL', plugins_url('', __FILE__));
		define('or_SLUG', basename(dirname(__FILE__)));
		define('or_BASE', plugin_basename(__FILE__));
		define('or_TEXTDOMAIN', 'originbuilder');

		$this->template_path = or_PATH.KDS.'shortcodes'.KDS;
		array_push( $this->template_path_extend, get_template_directory().KDS.'originbuilder'.KDS );

		$this->settings = get_option( 'or_options' );
		if( empty( $this->settings ) )
			$this->settings = array();
		
		require_once or_PATH.'/includes/or.actions.php';
		
		if( get_option('or_tkl_cc') && get_option('or_tkl_dd') )
			$this->verify = true;
		
		add_action( 'init', array( &$this, 'init' ), 9999 );

	}
	
	
	public static function globe(){
		
		global $or;
		
		if( isset( $or ) )
			return $or;
		else wp_die('originbuilder Error: Global varible could not be loaded.');
		
	}
	
	public function init(){
		
		add_action( 'or_before_footer', array( &$this, 'convert_maps' ) );
		add_action( 'or_after_footer', array( &$this, 'convert_paramTypes' ) );
		
		$this->add_icon_source( or_URL.'/assets/css/icons.css' );
		
		$this->register_shortcodes();
		
	}

	public function load(){
		
		require_once or_PATH.'/includes/or.functions.php';
		
		// Shared
		require_once or_PATH.'/includes/or.maps.php';
		require_once or_PATH.'/includes/or.param.types.php';
		require_once or_PATH.'/includes/or.ajax.php';
		require_once or_PATH.'/includes/or-hide-title.php';
		require_once or_PATH.'/includes/or.subscriber.php';
				
		//$this->register_shortcodes();

		// Back-end only
		if( is_admin() ) {
			require_once or_PATH.'/includes/frontend/helpers/or.ajax.php';	
			require_once or_PATH.'/includes/or.updater.php';	
		// Front-end only
		} else {
			require_once or_PATH.'/includes/or.front.php';			
		}

	}

	public function add_map( $map = array() ){
		/*
			Add to global maps
		*/
		foreach( $map as $base => $atts )
		{
			if( is_array( $atts ) ){

				$this->maps[ $base ] = $atts;
				if( isset( $atts['filter'] ) && !empty( $atts['filter'] ) )
					$this->filters[ $base ] = $atts['filter'];
				if( isset( $atts['views'] ) && !empty( $atts['views']['sections'] ) ){
					array_push( $this->maps_views, $base );
					array_push( $this->maps_view, $atts['views']['sections'] );
				}
			}
		}
	}

	public function remove_map( $map = '' ){
		/*
			Add to global maps
		*/

		if( isset( $this->maps[ $map ] ) )
			unset( $this->maps[ $map ] );

	}

	public function add_param_type( $name = '', $func = '' ){
		/*
			Add to global params
		*/
		if( !empty( $name ) && !empty( $func ) )
		{
			$this->param_types[ $name ] = $func;
		}

	}
	
	public function add_param_type_cache( $name = '', $func = '' ){
		/*
			Add to global params
		*/
		if( !empty( $name ) && !empty( $func ) )
		{
			$this->param_types_cache[ $name ] = $func;
		}

	}

	public function get_maps(){

		return $this->maps;

	}

	public function convert_maps(){
		/*
			Convert maps from php to js
		*/
		echo '<script type="text/javascript">';
		echo 'var or_maps = '.json_encode( (object)$this->maps ).';';
		echo 'var or_maps_views = '.json_encode( $this->maps_views ).';';
		echo 'var or_maps_view = '.json_encode( $this->maps_view ).';';
		echo '</script>';

	}

	public function convert_paramTypes(){
		/*
			Convert param types to js
		*/
		$type_support = array();
		foreach( $this->param_types as $name => $func )
		{
			if( function_exists( $func ) )
			{
				echo '<script type="text/html" id="tmpl-or-field-type-'.esc_attr($name).'-template">';
				$func();
				echo "</script>\n";
				if( !in_array( $name, $type_support ) )
					array_push( $type_support, $name );
			}
		}
		
		foreach( $this->param_types_cache as $name => $func )
		{
			if( !in_array( $name, $type_support ) )
				array_push( $type_support, $name );
		}
		
		echo '<script type="text/html" id="tmpl-or-field-type-undefined-template"><input name="{{data.name}}" class="or-param" value="{{data.value}}" type="text" /></script>';
		
		echo '<script type="text/javascript">var or_param_types_support = '.json_encode( $type_support ).'</script>';


	}
	
	public function convert_paramTypes_cache(){
		/*
			Convert param types to js
		*/
		foreach( $this->param_types_cache as $name => $func )
		{
			if( function_exists( $func ) )
			{
				echo '<script type="text/html" id="tmpl-or-field-type-'.esc_attr($name).'-template">';
				$func();
				echo "</script>";
			}
		}

	}

	public function add_map_param( $map = '', $param = '', $index = null ){

		if( isset( $this->maps[ $map ] ) )
		{
			if( is_array( $param ) )
			{
				if( $index == null )
				{
					array_push( $this->maps[ $map ][ 'params' ], $param );
				}
				else if( empty( $this->maps[ $map ][ 'params' ][ $index-1 ] ) )
				{
					array_push( $this->maps[ $map ][ 'params' ], $param );
				}
				else
				{

					$new_array = array();
					$done = false;
					$j = 0;

					for( $i = 0; $i <= count( $this->maps[ $map ][ 'params' ] ); $i++ )
					{
						if( $i != $index-1 )
						{
							if( isset( $this->maps[ $map ][ 'params' ][$j] ) )
								$new_array[ $i ] = $this->maps[ $map ][ 'params' ][$j];
							$j++;
						}
						else
						{
							$new_array[ $i ] = $param;
							$done = true;
						}
					}

					if( $done == false )
						array_push( $new_array, $param );

					$this->maps[ $map ][ 'params' ] = $new_array;

				}

			}
		}
	}

	public function remove_map_param( $map = '', $name = '' ){

		if( isset( $this->maps[ $map ] ) )
		{
			if( $name != '' )
			{
				$new_array = array();
				$i = 0;

				foreach( $this->maps[ $map ][ 'params' ] as $key => $param )
				{
					if( $param['name'] != $name )
					{
						$new_array[ $i++ ] = $param;
					}
				}
				$this->maps[ $map ][ 'params' ] = $new_array;
			}
		}
	}
	
	public function add_icon_source( $source ){
		
		$source = esc_url($source);
		
		$path = str_replace( site_url(), untrailingslashit( ABSPATH ), $source );
		if( is_file( $path ) ){
			$this->icon_sources[] = $source;
		}
		
	}
	
	public function get_icon_sources(){
		
		return $this->icon_sources;
		
	}
	
	public function set_template_path( $path ){

		if( is_dir( $path ) )
		{
			array_push( $this->template_path_extend, $path );
		}
	}

	public function locate_profile_sections( $profiles = array() ){
		
		if( !is_array( $profiles ) )
			$profiles = array( $profiles );
		
		foreach( $profiles as $path ){
			if( file_exists( $path ) ){
				
				$path_info = pathinfo( $path );
				$path = str_replace( untrailingslashit( ABSPATH ), '', $path );
				
				if( !in_array( $path, $this->profile_section_paths ) && $path_info['extension'] == 'or' ){
					array_push( $this->profile_section_paths, $path );
				}
				
			}
		}

	}
	
	public function get_profile_sections(){
		
		$list = array();
		$from_db = $this->get_profiles_db();
		$slug = '';
		
		if( !is_array( $this->profile_section_paths ) )
			return $list;
		
		foreach( $this->profile_section_paths as $path ){
			
			$slug = sanitize_title( basename( $path, '.or' ) );
			
			if( !isset( $from_db[ $slug ] ) )
				$list[ $slug ] = $path;
		}
		
		return $list;

	}
	
	public function get_data_profile( $name = '' ){
		
		$profile_section_paths = $this->get_profile_sections();
		
		if( isset( $profile_section_paths[ $name ] ) && is_file( untrailingslashit( ABSPATH ).$profile_section_paths[ $name ] ) ){
		
			$file = untrailingslashit( ABSPATH ).$profile_section_paths[ $name ];
					
			$path_info = pathinfo( $file );
	
			if( $path_info['extension'] != 'or' )
				return false;
			
			$fp = @fopen( $file, 'r' );
			$data = '';
			
			if( !empty( $fp ) ){
				
				$data = @fread( $fp, filesize( $file ) );
				$data = base64_encode( $data );
				$name = str_replace( array( '-', '_' ), array( ' ', ' ' ), basename( $name, '.or' ) );
				$slug = sanitize_title( basename( $name, '.or' ) );
				
				@fclose( $fp );
				
				return array( $name, $slug, $data );
					
			} return false;
			
			
		}else return false;
		
	}

	public function get_template_path_extend( $base = '' ){

		$path = '';

		foreach( $this->template_path_extend as $tmpl )
		{
			if( file_exists( $tmpl.$base ) )
				$path = $tmpl.$base;
		}

		return $path;

	}

	public function get_template_path( $base = '' ){
		return $this->template_path.$base;
	}

	public function register_shortcodes(){
		
		global $shortcode_tags;
		
		$shortcode = new or_load_shortcodes();

		foreach( $this->maps as $name => $atts ){
			if( !isset( $shortcode_tags[$name] ) )
				add_shortcode( $name, array( &$shortcode, 'or_'.$name ) );
		}

	}

	public function do_shortcode( $content = '', $tag = '' ){

		if( empty( $tag ) )
			return do_shortcode( $content );
		else
			return do_shortcode( preg_replace('/'.$tag.'#/', $tag, $content) );

	}

	public function get_default_atts( $params ){

		$sc = $params[2];

		if( isset( $this->maps[$sc] ) ){
			
			$pairs = $params[0];
			$reparams = $params[0];
			
			foreach( $this->params_merge( $sc ) as $param ){
				
				if( isset( $reparams[$param['name']] ) && $reparams[$param['name']] === '__empty__' ){
					$param['value'] = '';
					$reparams[ $param['name'] ] = '';
				}
				
				$pairs[ $param['name'] ] = isset( $param['value'] ) ? $param['value'] : '';
				
				if( $param['type'] == 'editor' || $param['type'] == 'textarea' || $param['type'] == 'group' ){
					
					if( !empty( $pairs[ $param['name'] ] ) )
						$pairs[ $param['name'] ] = str_replace( '%SITE_URL%', site_url(), base64_decode( $pairs[ $param['name'] ] ) );
					if( isset( $reparams[ $param['name'] ]) && !empty( $reparams[ $param['name'] ] ) ){
						$reparams[ $param['name'] ] = str_replace( "\n", '', $reparams[ $param['name'] ] );
						$reparams[ $param['name'] ] = str_replace( '%SITE_URL%', site_url(), base64_decode( $reparams[ $param['name'] ] ) );
					}
				}
				
			}

			$atts = shortcode_atts( $pairs, $reparams, $sc );
			
			return $atts;

		}else return array();

	}

	public function get_profiles_db( $_return = true ){
		
		global $wpdb;
		
		$list = array();
		$query = "SELECT * FROM `".$wpdb->prefix."options` WHERE `".$wpdb->prefix."options`.`option_name` LIKE 'or-profile%'";
		$item = '';
		$name = '';
		
		$fromDB = $wpdb->get_results( $query );
		
		if( isset( $fromDB ) ){
			foreach( $fromDB as $profile ){
				
				$name = substr( $profile->option_name, 11 );
				
				if( !in_array( $name, $list ) ){
					$item = @unserialize( $profile->option_value );
					$list[ $name ] = isset( $item[0] ) ? $item[0] : str_replace( array( '-', '_' ), array( ' ', ' ' ), $name );
				}
			}
		}
		
		if( $_return === false ){
			
			return json_encode( (object)$list );
			
		}
		
		return $list;

	}

	public function settings(){

		return array_merge( array(

			'content_types' => '',
			'load_icon' => '',
			'css_code' => '',
			'envato_username' => '',
			'api_key' => '',
			'license_key' => '',
			'theme_key' => ''

		), $this->settings );
	}

	public function get_content_types(){

		$default = $this->required_content_types;
		$settings = $this->settings();
		$types = $settings['content_types'];

		if( empty( $types ) ){
			return $default;
		}else if( !is_array( $types ) ){
			$types = explode( ',', $types );
		}

		return array_merge( $default, $types );

	}

	public function add_content_type( $type ){

		if( is_string( $type ) )
		{

			if( !in_array( $type, $this->required_content_types ) )
				array_push( $this->required_content_types, $type );

		}

	}

	public function get_required_content_types(){

		return $this->required_content_types;

	}
	
	public function params_merge( $name ){
		
		if( !isset( $name ) || empty( $name ) || !isset( $this->maps[ $name ] ) )
			return array();
				
		$params = $this->maps[ $name ]['params'];
		$merge = array();
		
		if( isset( $params[0] ) ){
			
			return $params;
		
		}else{
			
			foreach( $params as $k => $v ){
				if( isset( $v[0] ) ){
					
					foreach( $v as $prm )
						array_push( $merge, $prm );
				}
			}
			
		}
		
		return $merge;
		
	}

	public function js_callback( $func ){
		
		array_push( $this->live_js_callback,  array( 'callback' => $func ) );
		
	}
	
	public function esc( $str ) {
		
		if( empty( $str ) )
			return '';
		
	    return str_replace( array('<','>','[',']','"','\''), array( ':lt:', ':gt:', ':lsqb:', ':rsqb:', ':quot:', ':apos:' ) );
	}

	public function unesc( $str ){

		if( empty( $str ) )
			return '';
		
		return str_replace( array( ':lt:', ':gt:', ':lsqb:', ':rsqb:', ':quot:', ':apos:' ), array('<','>','[',']','"','\''), $str );
		
	}
	
	public function user_can_edit( $post = null ){

		if( !isset( $post ) || empty( $post ) || $post === null )
			global $post;
			
		global $current_user;
		wp_get_current_user();

		if( isset( $post ) && is_object( $post ) &&
			isset( $current_user ) && is_object( $current_user ) &&
			( current_user_can( 'edit_others_posts', $post->ID ) || ($post->post_author == $current_user->ID) ) 
		){
			return true;
		}
		return false;
		
	}
	
	public static function is_live(){
		
		if( isset( $_GET['or_action'] ) && $_GET['or_action'] == 'live-editor' )
			return true;
		else return false;
		
	}
	
}

class or_load_shortcodes{

	public function __call( $func, $params ){

		global $or;

		$shortcode = $params[2];
        $content = str_replace( array('&#8221;', '&#8243;' ), array( '"', '"' ), $params[1] );
        $base = $shortcode.'.php';
        $atts = $or->get_default_atts( $params );
        $path = $or->get_template_path_extend( $base );

		if( isset( $atts['content'] ) && !empty( $content ) )
			$atts['content'] = $content;
		
		if( isset( $atts['content'] ) && isset( $content ) )
			$atts['content'] = $content;

        if( empty( $path ) )
	        $path = $or->get_template_path( $base );

        if( !file_exists( $path ) )
        	return 'originbuilder Error: could not find shortcode template: '.$path;

        ob_start();
	        include $path;
	        $content = ob_get_contents();
	    ob_end_clean();

        return $content;

    }

}
add_action( 'init', 'st' );

function st(){
		return '<style> *[data-model] ~ .empty_guide {
    display: none !important;
}<style>';
	
}

/************************/
global $or;
$or = new originbuilder();
// Load originbuilder core
$or->load();
/************************/
