<?php

$output = $_class = $css = $wrap_class = $value_color_style = $label_color_style = $custom_class = $radius = $weight = $speed ='';

extract($atts);

$progress_bar_color_default = '#999999';
$progress_bar_track_color_default = '#e0e0e0';

$element_attributes = array();

$el_classes = array(
	'or_shortcode',
	'or_progress_bars',
	$wrap_class,
    $custom_class
);

if( $css != '' )
	$el_classes[] = $css;
	
$style = isset($atts['style']) ? $atts['style'] : 1;

if( isset( $atts['weight'] ) && !empty( $atts['weight'] ) )
	$weight = $atts['weight'];
else $weight = 12;

if( isset( $atts['speed'] ) && !empty( $atts['speed'] ) )
	$speed = $atts['speed'];
else $speed = 2000;

if( isset( $atts['margin'] ) )
	$margin = $atts['margin'];
else $margin = 20;

$options = json_decode( $options );

$element_attributes[] = 'class="'. esc_attr( implode(' ', $el_classes ) ) .'"';
$element_attributes[] = 'data-style="'. esc_attr($style) .'"';

$output .= '<div '. implode(' ', $element_attributes) .'>';

if(!empty($title)) $output .= '<h3>'. esc_html($title) .'</h3>';


if( isset( $options ) ){

	foreach( $options as $option ){

		$value = !empty($option->value) ? $option->value : 50;
		$label = !empty($option->label) ? $option->label : 'Label default';

		$prob_color = !empty($option->prob_color) ? $option->prob_color : $progress_bar_color_default;
		$prob_style = 'background-color: '.$prob_color.';';

		$prob_bg_color = !empty($option->prob_bg_color) ? $option->prob_bg_color : $progress_bar_track_color_default;
		$prob_track_style = 'background-color: '.$prob_bg_color.';';


		if(isset($weight)){
			$prob_style .= 'height: '. intval($weight).'px;';

			if(in_array($style, array(1,2))){
				$prob_track_style .= 'height: '. intval($weight).'px;';
			}
		}

		$prob_style .= 'width: '.$value.'%';

		if( !empty($option->value_color) ){
			$value_color_style = ' style="color: '. esc_attr($option->value_color) .'"';
		}else{
			$value_color_style = ' style="color: #333333;"';
		}

		if( !empty($option->label_color) ){
			$label_color_style = ' style="color: '. esc_attr($option->label_color) .'"';
		}else{
			$label_color_style = ' style="color: #333333;"';
		}



		$prob_track_attributes = array();
		$prob_attributes = array();

		//Progress bars track attributes
		$prob_track_css_classes = array(
			'or-ui-progress-bar',
			'or-ui-progress-bar'.$style,
			'or-progress-bar',
			'or-ui-container',
		);
		
		if( $radius == 'yes' )
			$prob_track_css_classes[] = 'or-progress-radius';
			
		$prob_track_css_class = implode(' ', $prob_track_css_classes);
		$prob_track_attributes[] = 'class="' . esc_attr( trim( $prob_track_css_class ) ) . '"';
		$prob_track_attributes[] = 'style="'. esc_attr($prob_track_style) .'"';
		
		//Progress bars attributes
		$prob_css_classes = array(
			'or-ui-progress',
			'or-ui-progress'.$style
		);

		$prob_css_class = implode(' ', $prob_css_classes);
		$prob_attributes[] = 'class="' . esc_attr( trim( $prob_css_class ) ) . '"';
		$prob_attributes[] = 'style="'. esc_attr($prob_style) .'"';

		$output .= '<div class="progress-item" style="margin-top:'.($margin/2).'px;margin-bottom:'.($margin/2).'px;">';

		$output .= '<span class="label" '. $label_color_style .'>'. esc_html( $label ) .'</span>';
		$output .= '<div '. implode( ' ', $prob_track_attributes ) .'>';
			$output .= '<div '. implode( ' ', $prob_attributes ) .' data-value="'. esc_html( $value ) .'" data-speed="'. esc_html( $speed ) .'">';
				$output .= '<div class="ui-label">
					<span class="value" '. $value_color_style .'>'. esc_html( $value ) .'%</span>
				</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '</div>';

	}
}

$output .= '</div>';


echo $output;
