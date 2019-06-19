<?php
/**
 * or_accordion shortcode
 **/

$css = ''; 
extract( $atts );

$output = '';

$element_attributes = array();

$css_classes = array(
	'or_accordion_wrapper'
);

if( $css != '' )$css_classes[] = $css;

if( isset( $class ) )
	array_push( $css_classes, $class );

if( $atts['open_all'] == 'yes' )
	$element_attributes[] = 'data-allowOpenAll="true"';
	
$css_class = implode(' ', $css_classes);
$element_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<div ' . implode( ' ', $element_attributes ) . '>';
$output .= do_shortcode( str_replace( 'or_accordion#', 'or_accordion', $content ) );
$output .= '</div>';

echo $output;