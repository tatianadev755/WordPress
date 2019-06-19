<?php

$class = $css = $animateevent = $animateeffect = $output = '';
$animateswitch = 'no';

extract( $atts );

$output = '';

$el_class = array('or_text_block');

if( $class != '' )$el_class[] = $class;
if( $css != '' )$el_class[] = $css;
	
$content = apply_filters('or_column_text', $content );

$output .= '<div class="'.esc_attr( implode(' ', $el_class) ).'">';
$output .= wpautop( do_shortcode( $content ) );
$output .= '</div>';

$effect = 'animated '.$animateeffect;

if($animateswitch == 'yes'){
	if($animateevent == 'onload'){
		$output = "<div class='wow ".$effect."' data-wow-duration='1s' data-wow-delay='0.5s'>".$output."</div>";
	}else{
		$output = "<div ".($animateevent == 'onclick' ? "onClick='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '')." ".($animateevent == 'onhover' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '').">".$output."</div>";
	}
}

echo $output;
