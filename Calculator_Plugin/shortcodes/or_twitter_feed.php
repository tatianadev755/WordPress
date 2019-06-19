<?php

$output = $output_title = $show_navigation = $show_pagination = $auto_height = '';

extract( $atts );

$attributes = array();

$el_classes = array(
	'or_shortcode',
	'or_wrap_twitter',
	'or_twitter_feed',
	'or_twitter_style-' . $display_style,
	$wrap_class,
	$custom_class,
	isset( $atts[ 'css' ] )? $atts[ 'css' ] : ''
);

$atts_data = array(
	'show_navigation' => $show_navigation,
	'show_pagination' => $show_pagination,
	'auto_height' => $auto_height
);

$attributes[] = 'class="'. esc_attr( implode( ' ', $el_classes ) ) .'"';
$attributes[] = 'data-cfg="'. base64_encode( json_encode( $atts ) ) .'"';
$attributes[] = 'data-owl_option="'. esc_attr( json_encode( $atts_data ) ) .'"';
$attributes[] = 'data-display_style="'. esc_attr( $display_style ) .'"';

if( !empty( $title ) ){
	$output_title = '<h3 class="or-widget-title">'. esc_html( $title ) .'</h3>';
}

$max_height = !empty($max_height) ? intval($max_height) . 'px;': 'none;';

$output .= '<div '. trim( implode(' ', $attributes ) ) .'>'. $output_title .'<div class="result_twitter_feed" style="max-height: '. intval($max_height) .'px"><span>Loading...</span></div></div>';

echo $output;

or_js_callback( 'or_front.ajax_action' );