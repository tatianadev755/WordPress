<?php

$output = $align = $before = $after = $animateeffect = $output = '';
$animateswitch = 'no';
$type = 'h1';
extract( $atts );

$attributes = array();
$wrap_class = array();
$classes = array(
	'or_title',
	$atts['class']
);

if( !empty( $atts['type'] ) )
	$type = esc_attr( $atts['type'] );
else $type = 'h1';

if( !empty( $atts['css'] ) ){
	if( isset( $atts['title_wrap'] ) && $atts['title_wrap'] == 'yes' )
		$wrap_class[] = $atts['css'];
	else $classes[] = $atts['css'];
}

if( !empty( $align ) )
	$classes[] = 'align-'.$align;

$attributes[] = 'class="' . esc_attr( implode(' ', $classes) ) . '"';  
$f=strpos($atts['css_data'],"font-family");
$newf=substr($atts['css_data'],$f);
 
$till=strpos($newf,";");
 $font_family=substr($newf,0,$till);
 
 if(trim($font_family)==''){
$output = '<'.$type.' '.implode( ' ', $attributes ) . '>'.$atts['text'].'</'.$type.'>';
 }
 else{
	 $output = '<'.$type.' '.implode( ' ', $attributes ) . ' style="'.$font_family.';">'.$atts['text'].'</'.$type.'>';
 }
if( isset( $atts['title_wrap'] ) && $atts['title_wrap'] == 'yes' )
{

	if( !empty( $before ) )
		$output = $before.$output;
	if( !empty( $after ) )
		$output .= $after;
	
	if( isset( $atts['title_wrap_class'] ) && !empty( $atts['title_wrap_class'] ) )
		$wrap_class[] = $atts['title_wrap_class'];
	
	if( !empty( $align ) )
		$wrap_class[] = 'align-'.$align;
		
	$output = '<div class="'.esc_attr( implode(' ', $wrap_class ) ).'">'.$output.'</div>';
	
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

