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

if( !function_exists('wp_list_widgets') )
	require_once(ABSPATH . '/wp-admin/includes/widgets.php');

function or_admin_enable( $force = false ){

	if( $force === true )
		return true;

	global $post, $or;

	$type = !empty( $post->post_type ) ? $post->post_type:'';
	$page = !empty( $_GET['page'] ) ? $_GET['page'] : '';

	$settings = $or->settings();
	if( !isset( $settings['content_types'] ) )
		$settings['content_types'] = array();

	$allows_types = array_merge( (array)$settings['content_types'], (array)$or->get_required_content_types() );

	if( is_admin() && ( in_array( $type, $allows_types ) || $page == 'or-sections-manager' || originbuilder::is_live() ) )
		return true;
	else return false;

}

function or_add_map( $map = array() ){

	$or = originbuilder::globe();

	if( !is_array( $map ) )
		return;
	if( empty( $map['name'] ) )
		return;

	$or->add_map( $map );

}

function or_add_param_type( $name = '', $func = '' ){

	$or = originbuilder::globe();

	if( empty( $name ) || empty( $func ) )
		return;

	$or->add_param_type( $name, $func );
	
}

function or_add_icon( $source = '' ){
	
	if( !empty( $source ) ){
		originbuilder::globe()->add_icon_source( $source );	
	}
}

function or_remove_wpautop( $content, $autop = false ) {

	if ( $autop ) {
		$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
	}

	return do_shortcode( shortcode_unautop( $content ) );
}

function or_validate_options( $plugin_options ){

	if( !empty( $_POST['or_options'] ) ){
		return $plugin_options;
	}

}

function or_youtube_id_from_url( $url = '' ) {

    parse_str( parse_url( $url, PHP_URL_QUERY ), $vars );
    
	return isset( $vars['v'] ) ? $vars['v'] : '';   

}

function or_loop_box( $items ){

	if( empty( $items ) )
		return '';

	$output = '';

	foreach( $items as $item ){
			
		if( is_object( $item ) && $item->tag != 'text' ){
			

			if( !isset( $item->attributes ) || !is_object( $item->attributes ) )
				$item->attributes = new stdClass();

			if( !isset( $item->attributes->class ) )
				$item->attributes->class = '';
			
			if( $item->tag == 'image' )
				$item->tag = 'img';
			if( $item->tag == 'icon' )
				$item->tag = 'i';
			if( $item->tag == 'column' ){
				$item->tag = 'div';
				$item->attributes->class .= ' '.$item->attributes->cols;
				unset( $item->attributes->cols );
			}
			
			$output .= '<'.$item->tag;
			
			if( $item->tag == 'img' ){
				if( empty( $item->attributes->src ) )
					$item->attributes->src = or_URL.'/assets/images/get_logo.png';
				
				if( $item->tag == 'img' && !isset( $item->attributes->alt ) )
					$item->attributes->alt = '';
			}
			
			foreach( $item->attributes as $k => $v ){
				if( !empty($v) )$output .= ' '.$k.'="'.trim($v).'"';
			}

			if( $item->tag == 'img' )
				$output .= '/';

			$output .= '>';

			if( is_array( $item->children ) )
				$output .= or_loop_box( $item->children );

			if( $item->tag != 'img' )
				$output .= '</'.$item->tag.'>';

		}else $output .= $item->content;

	}

	return $output;

}

function or_get_terms( $tax = 'category', $key = 'id', $type = '', $default = '' ){

	$get_terms = (array) get_terms( $tax, array( 'hide_empty' => false ) );

	if( $type != '' ){
		$get_terms = or_get_terms_by_post_type( array($tax), array($type) );
	}

	$terms = array();

	if( $default != '' ){
		$terms[] = $default;
	}

	if ( $key == 'id' ){
		foreach ( $get_terms as $term ){
			if( isset( $term->term_id ) && isset( $term->name ) ){
				$terms[$term->term_id] = $term->name;
			}
		}
	}else if ( $key == 'slug' ){
		foreach ( $get_terms as $term ){
			if( !empty($term->name) ){
				if( isset( $term->slug ) && isset( $term->name ) ){
					$terms[$term->slug] = $term->name;
				}
			}
		}
	}

	return $terms;

}

function or_filter_search( $s, &$w ) {
	
	global $wpdb;
	
	if ( empty( $s ) )return '';
	
	$q = $w->query_vars;
	
	$n = ! empty( $q['exact'] ) ? '' : '%';
	$s = $sa = '';
	
	foreach ( (array) $q['search_terms'] as $t ) {
		$t = $wpdb->esc_like( $t );
		$l = $n . $t . $n;
		$s .= $wpdb->prepare( "{$sa}($wpdb->posts.post_title LIKE %s)", $l );
		$sa = ' AND ';
	}
	
	if ( ! empty( $s ) )
		$s = " AND ({$s}) ";

	return $s;
}

function or_get_submit_button( $text = '', $type = 'primary large', $name = 'submit', $wrap = true, $other_attributes = '' ) {
	
	if ( ! is_array( $type ) )
		$type = explode( ' ', $type );

	$button_shorthand = array( 'primary', 'small', 'large' );
	$classes = array( 'button' );
	foreach ( $type as $t ) {
		if ( 'secondary' === $t || 'button-secondary' === $t )
			continue;
		$classes[] = in_array( $t, $button_shorthand ) ? 'button-' . $t : $t;
	}
	$class = implode( ' ', array_unique( $classes ) );

	if ( 'delete' === $type )
		$class = 'button-secondary delete';

	$text = $text ? $text : __( 'Save Changes' );

	// Default the id attribute to $name unless an id was specifically provided in $other_attributes
	$id = $name;
	if ( is_array( $other_attributes ) && isset( $other_attributes['id'] ) ) {
		$id = $other_attributes['id'];
		unset( $other_attributes['id'] );
	}

	$attributes = '';
	if ( is_array( $other_attributes ) ) {
		foreach ( $other_attributes as $attribute => $value ) {
			$attributes .= $attribute . '="' . esc_attr( $value ) . '" '; // Trailing space is important
		}
	} elseif ( ! empty( $other_attributes ) ) { // Attributes provided as a string
		$attributes = $other_attributes;
	}

	// Don't output empty name and id attributes.
	$name_attr = $name ? ' name="' . esc_attr( $name ) . '"' : '';
	$id_attr = $id ? ' id="' . esc_attr( $id ) . '"' : '';

	$button = '<input type="submit"' . $name_attr . $id_attr . ' class="' . esc_attr( $class );
	$button	.= '" value="' . esc_attr( $text ) . '" ' . $attributes . ' />';

	if ( $wrap ) {
		$button = '<p class="submit">' . $button . '</p>';
	}

	return $button;
}

function or_process_tab_title( $matches ){

	if( !empty( $matches[0] ) ){

		$tab_atts = shortcode_parse_atts( $matches[0] );

		$title = ''; $adv_title = '';
		if ( isset( $tab_atts['title'] ) )
			$title = $tab_atts['title'];
		
		if( isset( $tab_atts['advanced'] ) && $tab_atts['advanced'] === 'yes' ){
			
			if( isset( $tab_atts['adv_title'] ) && !empty( $tab_atts['adv_title'] ) )
				$adv_title = base64_decode( $tab_atts['adv_title'] );
				
			$icon=$icon_class=$image=$image_id=$image_url=$image_thumbnail=$image_medium=$image_large=$image_full='';
			
			if( isset( $tab_atts['adv_icon'] ) && !empty( $tab_atts['adv_icon'] ) ){
				$icon_class = $tab_atts['adv_icon'];
				$icon = '<i class="'.$tab_atts['adv_icon'].'"></i>';
			}
			
			if( isset( $tab_atts['adv_image'] ) && !empty( $tab_atts['adv_image'] ) ){
				$image_id = $tab_atts['adv_image'];
				$image_url = wp_get_attachment_image_src( $image_id, 'full' );
				$image_medium = wp_get_attachment_image_src( $image_id, 'medium' );
				$image_large = wp_get_attachment_image_src( $image_id, 'large' );
				$image_thumbnail = wp_get_attachment_image_src( $image_id, 'thumbnail' );
				
				if( !empty( $image_url ) && isset( $image_url[0] ) ){
					$image_url = $image_url[0];
					$image_full = $image_url;
				}
				if( !empty( $image_medium ) && isset( $image_medium[0] ) )
					$image_medium = $image_medium[0];
				
				if( !empty( $image_large ) && isset( $image_large[0] ) )
					$image_large = $image_large[0];
					
				if( !empty( $image_thumbnail ) && isset( $image_thumbnail[0] ) )
					$image_thumbnail = $image_thumbnail[0];
				if( !empty( $image_url ) )
					$image = '<img src="'.$image_url.'" alt="" />';
			}
			
			$adv_title = str_replace( array( '{title}', '{icon}', '{icon_class}', '{image}', '{image_id}', '{image_url}', '{image_thumbnail}', '{image_medium}', '{image_large}', '{image_full}', '{tab_id}' ), array( $title, $icon, $icon_class, $image, $image_id, $image_url, $image_thumbnail, $image_medium, $image_large, $image_full, $tab_atts['tab_id'] ), $adv_title );
			
			echo '<li>'.$adv_title.'</li>';
				
		}else{
			if( isset( $tab_atts['icon'] ) )
				$title = '<i class="'.$tab_atts['icon'].'"></i> '.$title;
			echo '<li><a href="#'.$tab_atts['tab_id'].'">'.$title.'</a></li>';
		}

	}

	return $matches[0];

}

function or_js_callback( $callback ){
	
	$or = originbuilder::globe();
	$or->js_callback( $callback );
	
}

/*
 * Return a random string with length
 */
function or_random_string( $length = 10 ){
	$str = "";
	$allow_characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
	$_max_length = count($allow_characters) - 1;

	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $_max_length);
		$str .= $allow_characters[$rand];
	}

	return $str;
}

function wp_editor_fontsize_filter( $options ) {
	array_shift( $options );
	array_unshift( $options, 'fontsizeselect');
	array_unshift( $options, 'formatselect');
	array_unshift( $options, 'fontselect');
	return $options;
}
add_filter('mce_buttons_2', 'wp_editor_fontsize_filter');


// Customize mce editor font sizes
if ( ! function_exists( 'wpex_mce_text_sizes' ) ) {
	function wpex_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 15px 16px 18px 21px 24px 28px 32px 36px";
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_text_sizes' );

// Add custom Fonts to the Fonts list
if ( ! function_exists( 'wpex_mce_google_fonts_array' ) ) {
	function wpex_mce_google_fonts_array( $initArray ) {
	    $initArray['font_formats'] = 'Arial=Arial;Anke=Anke;Comic Sans MS=comic sans ms,sans-serif;caliban=caliban;Courier New=courier new,courier;DroidSans=DroidSans;DroidSerif=DroidSerif;Georgia=georgia,palatino;Impact=impact,chicago;Lato=Lato;Lora=Lora;Montserrat=Montserrat;NotoSans=NotoSans;Open Sans=Open Sans;Oswald=Oswald;Raleway=Raleway;Roboto=Roboto;Slabo=Slabo;SourceSansPro=SourceSansPro;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;TitilliumWeb=TitilliumWeb;Trebuchet MS=trebuchet ms,geneva;Ubuntu=Ubuntu;Verdana=verdana,geneva;';
            return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_google_fonts_array' );

 
// Add Google Scripts for use with the editor
if ( ! function_exists( 'wpex_mce_google_fonts_styles' ) ) {
	function wpex_mce_google_fonts_styles() {
	   $font_url = 'http://fonts.googleapis.com/css?family=Lato:300,400,700';
           add_editor_style( str_replace( ',', '%2C', $font_url ) );
		    add_editor_style( or_URL.'/assets/css/icons.css' );
	} 
          
	 
}
add_action( 'init', 'wpex_mce_google_fonts_styles' );


