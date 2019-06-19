<?php
if(!defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

// Add Origin Builder specific CSS class by filter
add_filter( 'body_class', 'or_add_body_class' );
function or_add_body_class( $classes ) {
	
	global $post;
	
	if ( isset($post) && has_shortcode( $post->post_content, 'or_row' ) ){
		$classes[] = 'originbuilder';
	}

	return $classes;
}

//define var or_script_data
function or_header_js_var(){
	echo '<script type="text/javascript">var or_script_data={ajax_url:"'. admin_url( 'admin-ajax.php' ) .'"}</script>';
}
add_action('wp_head', 'or_header_js_var');


//Convert col decimal format to class
function or_ColDecimalToClass( $width ) {

	$matches = explode( '/', $width ); $width_class = ''; $n = 12; $m = 12;

	if( isset( $matches[0] ) && !empty( $matches[0] ) )
		$n = $matches[0];
	if( isset( $matches[1] ) && !empty( $matches[1] ) )
		$m = $matches[1];

	if( $n == 2.4){
		$width_class = 'or_col-of-5';
	}else{
		if ( $n > 0 && $m > 0 ) {
			$value = ceil( $n / $m * 12 );
			if ( $value > 0 && $value <= 12 ) {
				$width_class = 'or_col-sm-' . $value;
			}
		}
	}

	return $width_class;
}

//Return file assets url
function or_asset_url($file){
	$file = or_URL.'/assets/'.$file;
	return esc_url($file);
}

//Check external link
function or_check_image_external_link($external_link){
	if (@GetImageSize($external_link)) {
		return true;
	} else {
		return false;
	}
}

/*
 * Validate Color to RGBA
 * Takes the user's input color value and returns it only if it's a valid color.
 */
function or_validate_color_rgba($color) {
	if ($color == "transparent") {
		return $color;
	}
	$color = str_replace('#','', $color);
	if (strlen($color) == 3) {
		$color = $color.$color;
	}
	if (preg_match('/^[a-f0-9]{6}$/i', $color)) {
		$color = '#' . $color;
	}

	return array('hex'=>$color, 'rgba'=> or_hex2rgba($color));
}

/*
 * Takes the color hex value and converts to a rgba.
 */
function or_hex2rgba($color, $opacity = false) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color))
          return $default;

	//Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
}


function or_parse_link( $link, $default = array( 'url' => '', 'title' => '', 'target' => '' ) ){

	$result = $default;
	$params_link = explode('|', $link);

	if( !empty($params_link) ){
		$result['url'] = rawurldecode(isset($params_link[0])?$params_link[0]:'#');
		$result['title'] = isset($params_link[1])?$params_link[1]:'';
		$result['target'] = isset($params_link[2])?$params_link[2]:'';
	}

	return $result;
}


 
