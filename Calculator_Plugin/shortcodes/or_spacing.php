<?php

$class = $css = '';
$height = 0;

extract($atts);

if( $css != '' )
	$class .= ' '.esc_attr( $css );

echo '<div class="'. esc_attr( $class ) .'" style="height: '. esc_attr(intval($height)) .'px; clear: both; width:100%;"></div>';

