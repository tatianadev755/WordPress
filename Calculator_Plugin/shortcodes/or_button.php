<?php
$output = $textbutton = $text_title = $custom_style_pz = $custom_class = $css = $animateevent = $animateeffect = '';
$animateswitch = 'no';

extract( $atts );

$textbutton  = $text_title;
$link = ( '||' === $link ) ? '' : $link;
$link = or_parse_link($link);

if ( strlen( $link['url'] ) > 0 ) {
	$a_href = $link['url'];
	$a_title = $link['title'];
	$a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
}

if(!isset($a_href)) $a_href = "#";

$el_class = array(
	'or_button',
	$wrap_class,
	$custom_class
);

if( $css != '' ){
	$el_class[] = $css;
}

if(empty($size)) $size = 'small';
$el_class[] = 'button_size_'.$size;

$button_attributes = array();

if( isset($el_class) ){
	$button_attributes[] = 'class="'. esc_attr( implode(' ', $el_class) ) .'"';
}

if(isset($a_href)){
	$button_attributes[] = 'href="'. esc_attr($a_href) .'"';
}

if(isset($a_target)){
	$button_attributes[] = 'target="'. esc_attr($a_target) .'"';
}

if(isset($a_title)){
	$button_attributes[] = 'title="'. esc_attr($a_title) .'"';
}

if('custom' === $size){
	if(!empty($padding_button)) $custom_style_pz .= 'padding:'. $padding_button .';';
	if(!empty($font_size_button)) $custom_style_pz .= 'font-size:'. $font_size_button .';';
	$button_attributes[] = 'style="'. esc_attr($custom_style_pz) .'"';
}

if('yes' === $show_icon){
	if($icon_position == 'left'){
		$textbutton = '<i class="'. esc_attr($icon).'"></i> '. esc_html($text_title) ;
	}else if($icon_position == 'right'){
		$textbutton = esc_html($text_title) . ' <i class="'. esc_attr($icon) .'"></i>';
	}else{
		$textbutton = '<i class="'. esc_attr($icon) .'"></i>';
	}
}

$output .= '<a '.implode(' ', $button_attributes).'>'. $textbutton .'</a>';

$effect = 'animated '.$animateeffect;

if($animateswitch == 'yes'){
	if($animateevent == 'onload'){
		$output = "<div class='wow ".$effect."' data-wow-duration='1s' data-wow-delay='0.5s'>".$output."</div>";
	}else{
		$output = "<div ".($animateevent == 'onclick' ? "onClick='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '')." ".($animateevent == 'onhover' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '').">".$output."</div>";
	}
}

echo $output;
