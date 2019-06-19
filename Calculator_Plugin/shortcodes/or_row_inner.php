<?php

$output = $row_class_container = $row_class = $row_id = $after_row_full_action = $css = '';

extract( $atts );

$css_classes = array(
	'or_row',
	'or_row_inner',
	$row_class
);

if( $css != '' )
	$css_classes[] = $css;
	
$attributes = array();

if ( ! empty( $row_id ) ) {
	$attributes[] = 'id="' . esc_attr( $row_id ) . '"';
}

$attributes[] = 'class="' . esc_attr( trim( implode(' ', $css_classes) ) ) . '"';

if( !empty( $atts['equal_height'] ) )
{
	$attributes[] = 'data-or-equalheight="true"';
	$attributes[] = 'data-or-row-action="true"';
	$after_row_full_action = '<script>or_row_action(true);</script>';
}

$output .= '<div ' . implode( ' ', $attributes ) . '>';

if( !empty( $row_class_container ) )
	$output .= '<div class="'.esc_attr( $row_class_container ).'">';

$output .= do_shortcode( str_replace('or_row_inner#', 'or_row_inner', $content ) );

if( !empty( $row_class_container ) )
	$output .= '</div>';

$output .= '</div>';
$output .= $after_row_full_action;

echo $output;
