<?php

$output = $width = $col_in_class_container = $css = '';
$attributes = array();

extract( $atts );

$classes = array(
	'or_column_inner',
	$col_in_class,
	@or_ColDecimalToClass( $width )
);

if( $css != '' )$classes[] = $css;

if( strpos( $width, '%' ) !== false ){
	$attributes[] = 'style="width:'.esc_attr($width).'"';
	$classes[] = 'or_col-sm-%';
}

$col_in_class_container .= ' or_wrapper';

$attributes[] = 'class="' . esc_attr( trim( implode(' ', $classes) ) ) . '"';

$output .= '<div ' . implode( ' ', $attributes ) . '>'
		. '<div class="'.trim( esc_attr( $col_in_class_container ) ).'">'
		. do_shortcode( str_replace('or_column_inner#', 'or_column_inner', $content ) )
		. '</div>'
		. '</div>';

echo $output;
