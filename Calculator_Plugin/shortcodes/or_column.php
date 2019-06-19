<?php

$width = $css = $output = $col_class = '';

extract( $atts );

$attributes = array();
$classes = array(
	'or_column',
	$col_class,
	$css,
	@or_ColDecimalToClass( $width )
);

if( strpos( $width, '%' ) !== false ){
	$attributes[] = 'style="width:'.esc_attr($width).'"';
	$classes[] = 'or_col-sm-%';
}

$attributes[] = 'class="' . esc_attr( trim( implode(' ', $classes) ) ) . '"';

$col_container_class = !empty( $atts['col_container_class'] ) ? ' '.$atts['col_container_class'] : '';

$output = '<div ' . implode( ' ', $attributes ) . '>'
		. '<div class="or-col-container'.esc_attr( $col_container_class ).'">'
		. do_shortcode( str_replace('or_column#', 'or_column', $content ) )
		. '</div>'
		. '</div>';

echo $output;
