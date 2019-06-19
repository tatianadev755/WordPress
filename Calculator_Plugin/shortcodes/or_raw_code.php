<?php
	
$code = $css = '';

extract($atts);

$classes = array('or-raw-code');
if( $css != '' )
	$classes[] = $css;
	
echo '<div class="'.esc_attr( implode( ' ', $classes ) ).'">'.do_shortcode( $code ).'</div>';
