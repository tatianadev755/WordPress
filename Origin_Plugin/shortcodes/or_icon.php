<?php

$output = $style = $class = $align = $css = $animateevent = $animateeffect = '';
$animateswitch = 'no';
$attributes = array();
$icon_align = 'none';

extract( $atts );

if( isset( $atts['icon_size'] ) && !empty( $atts['icon_size'] ) ){
	$style .= 'font-size: '.$atts['icon_size'];
	if( is_numeric( $atts['icon_size'] ) )
		$style .= 'px;';
	else $style .= ';';
}

if( !empty( $atts['icon_color'] ) )
	$style .= 'color: '.$atts['icon_color'].';';

if( !empty( $atts['icon'] ) )
	$class .= ' '.$atts['icon'];
else $class .= ' fa-leaf';

if( $css != '' )
	$class .= ' '.$css;
	
$attributes[] = 'style="'.esc_attr($style).'"';
$attributes[] = 'class="'.esc_attr($class).'"';

$output = '<i '.implode( ' ', $attributes ).'></i>';

if( !empty($icon_align) && $icon_align != 'none' ){
	$align = 'style="text-align: '. esc_attr($icon_align) .';"';
}

if( $atts['icon_wrap'] == 'yes' || !empty($align) )
{
	if( !empty( $atts['icon_wrap_class'] ) )
		$output = '<div class="or-icon-wrapper '.esc_attr($atts['icon_wrap_class']).'" '. $align .'>'.$output.'</div>';
	else $output = '<div class="or-icon-wrapper" '. $align .'>'.$output.'</div>';
}

$effect = 'animated '.$animateeffect;

if($animateswitch == 'yes'){
	if($animateevent == 'onload'){
		$output = "<div class='wow ".$effect."' data-wow-duration='1s' data-wow-delay='0.5s'>".$output."</div>";
	}else{
		$output = "<div ".($animateevent == 'onclick' ? "onClick='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '')." ".($animateevent == 'onhover' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '').">".$output."</div>";
	}
}

echo $output;
