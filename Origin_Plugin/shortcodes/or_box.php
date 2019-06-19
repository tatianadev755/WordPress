<?php

$custom_class = $css = '';

extract($atts);

$element_attributes = array();
$el_classes = array(
	'or_box_wrap',
	$custom_class
);

if( $css != '' )
	$el_classes[] = $css;

$element_attributes[] = 'class="'. esc_attr(implode(' ', $el_classes)) .'"';

echo '<div '. implode(' ', $element_attributes ) .'>';

$data = base64_decode( $atts['data'] );
$data = str_replace( '%SITE_URL%', site_url(), $data );

if( $data = json_decode( $data ) )
{
	echo or_loop_box( $data );
	if( isset( $atts['css'] ) ){
		echo '<style type="text/css">'.$atts['css'].'</style>';
	}
}
else
{
	echo 'or Box: Error content structure';
}

echo '</div>';
