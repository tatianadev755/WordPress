<?php
$output = $custom_css = $_before_number = $_after_number = $custom_class = $css = $animateevent = $animateeffect = '';
$animateswitch = 'no';

$number_color = $label_color = $icon_color = '#393939';
$box_bg_color = 'transparent';

$atts = or_remove_empty_code( $atts );
extract( $atts );

$style = (!empty($atts['style'])) ? $atts['style'] : 1;

$element_atttribute = array();

$el_classess = array(
	'or_shortcode',
	'or_counter_box',
	'or-box-counter',
	'or-box-counter-'.$style,
	$custom_class,
	$wrap_class
);

if( $css != '' )$el_classes[] = $css;

$label = (!empty($label)) ? '<h4>'. esc_html($label) .'</h4>' : '';
$icon = !empty($icon)? $icon: 'fa-leaf';

if(isset($style) && $style != 1){
	$icon = (!empty($icon)) ? '<i class="'. esc_html($icon).' element-icon"></i>' : '';
}else{
	$icon = '';
}

if(!empty($label_above) && 'yes' === $label_above){
	$_before_number = $icon . $label;
}else{
	$_before_number = $icon;
	$_after_number = $label;
}

if( $style == '1' ){
	$box_bg_color = 'transparent';	
}

if( empty($box_bg_color) && '2' === $style){
	$box_bg_color = '#d9d9d9';
}

$custom_class = 'counter_box_'.or_random_string(10);

array_push( $el_classess, $custom_class );
$element_atttribute[] = 'class="'. esc_attr( implode(' ', $el_classess ) ) .'"';

$custom_style = "
	.$custom_class{
		background: $box_bg_color;
	}

	.$custom_class span.counterup{
		color: $number_color;
	}

	.$custom_class h4{
		color: $label_color;
	}

	.$custom_class i{
		color: $icon_color;
	}
";

$_before_number = '<style type="text/css">'.$custom_style.'</style>'.$_before_number;

$output .= '<div '. implode(' ', $element_atttribute) .'>
		'. $_before_number .'
		<span class="counterup">'. esc_html($number) .'</span>
		'. $_after_number .'
	</div>
';
	
$effect = 'animated '.$animateeffect;

if($animateswitch == 'yes'){
	if($animateevent == 'onload'){
		$output = "<div class='wow ".$effect."' data-wow-duration='1s' data-wow-delay='0.5s'>".$output."</div>";
	}else{
		$output = "<div ".($animateevent == 'onclick' ? "onClick='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '')." ".($animateevent == 'onhover' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '').">".$output."</div>";
	}
}
	
echo $output;
