<?php

$output = $template = $custom_css = $css = $bgcolor_group = $animateevent = $animateeffect = '';
$animateswitch = 'no';
$timer_style = 1;

extract($atts);

wp_enqueue_script('or-countdown-timer');

$element_attribute = array();

switch ($timer_style) {
	case '1':
	case '2':
		$template = '<span class="countdown-style'. esc_attr($timer_style) .'" >
			<span class="group" style="background-color:'.esc_attr($bgcolor_group).'">
				<span class="timer days" style="background-color:'.esc_attr($bgcolor_digit).';color:'.esc_attr($text_color).';font-size:'.esc_attr($digit_text_size).'px;">%D</span>
				<span class="unit" style="color:'.esc_attr($unit_color).';font-size:'.esc_attr($unit_text_size).'px;">days</span>
			</span>
			<span class="group" style="background-color:'.esc_attr($bgcolor_group).'">
				<span class="timer seconds" style="background-color:'.esc_attr($bgcolor_digit).';color:'.esc_attr($text_color).';font-size:'.esc_attr($digit_text_size).'px;">%H</span>
				<span class="unit" style="color:'.esc_attr($unit_color).';font-size:'.esc_attr($unit_text_size).'px;">hours</span>
			</span>
			<span class="group" style="background-color:'.esc_attr($bgcolor_group).'">
				<span class="timer seconds" style="background-color:'.esc_attr($bgcolor_digit).';color:'.esc_attr($text_color).';font-size:'.esc_attr($digit_text_size).'px;">%M</span>
				<span class="unit" style="color:'.esc_attr($unit_color).';font-size:'.esc_attr($unit_text_size).'px;">minutes</span>
			</span>
			<span class="group" style="background-color:'.esc_attr($bgcolor_group).'">
				<span class="timer seconds" style="background-color:'.esc_attr($bgcolor_digit).';color:'.esc_attr($text_color).';font-size:'.esc_attr($digit_text_size).'px;">%S</span>
				<span class="unit" style="color:'.esc_attr($unit_color).';font-size:'.esc_attr($unit_text_size).'px;">seconds</span>
			</span>
		</span>';
		break;

	case '3':
		if(!empty($custom_template)){
			$template = $custom_template;
		}else{
			$template = '%D days %H:%M:%S';
		}

		break;
}

$el_class = array(
	'or-countdown-timer',
	$wrap_class,
	$custom_css
);

if( $css != '' )$el_class[] = $css;

$datetime = !empty($datetime)?$datetime:date("D M d Y", strtotime("+1 week"));
$datetime = date("Y/m/d H:i:s", strtotime($datetime));

$countdown_data = array(
	'date' => $datetime,
	'template' => trim(preg_replace('/\s\s+/', ' ', $template))
);

$element_attribute[] = 'class="'. esc_attr( implode(' ', $el_class ) ) .'"';
$element_attribute[] = 'data-countdown="'.esc_attr(json_encode($countdown_data)).'"';

if(!empty($title)){
	$output .= '<h3>'. esc_attr($title) .'</h3>';
}

$output .= '<div '. implode(' ', $element_attribute) .'></div>';

$effect = 'animated '.$animateeffect;

if($animateswitch == 'yes'){
	if($animateevent == 'onload'){
		$output = "<div class='wow ".$effect."' data-wow-duration='1s' data-wow-delay='0.5s'>".$output."</div>";
	}else{
		$output = "<div ".($animateevent == 'onclick' ? "onClick='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '')." ".($animateevent == 'onhover' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '').">".$output."</div>";
	}
}

echo $output;
