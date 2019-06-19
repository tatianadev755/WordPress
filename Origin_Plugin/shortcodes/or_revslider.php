<?php

$output = $title = $slider_id = $css = '';

extract( $atts );

$attributes = array();
$classes = array(
	'or_revslider',
	$atts['class']
);

if( $css != '' )$classes[] = $css;

$attributes[] = 'class="' . esc_attr( implode(' ', $classes) ) . '"';

if ( !empty( $atts['title'] ) )
	$output .= '<h3>' . $atts['title'] . '</h3>';

if ( !empty( $atts['slider_id'] ) ) {
	$output .= '<div '.implode( ' ', $attributes ) . '>';
		$output .= do_shortcode( '[rev_slider alias="' . $atts['slider_id'] . '"]' );
	$output .= '</div>';
} else {
	$output .= __( 'Please create and select slider.', 'originbuilder' );
}

echo $output;
