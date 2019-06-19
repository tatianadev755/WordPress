<?php

$output = $container_class = $css_data = $after_row_full_action = $css = '';

$row_action = false;

$element_attributes = array();

$css_classes = array( 'or_row' );

if( $css != '' )
	$css_classes[] = $css;
	
if( !empty( $atts['row_class'] ) )
	$css_classes[] = $atts['row_class'];

if( !empty( $atts['full_height'] ) )
{
	if( $atts['content_placement'] == 'middle' )
		$element_attributes[] = 'data-or-fullheight="middle-content"';
	else $element_attributes[] = 'data-or-fullheight="true"';
	
	$row_action = true;
	
}

if( !empty( $atts['equal_height'] ) )
{
	$element_attributes[] = 'data-or-equalheight="true"';
	$row_action = true;
}


if( isset( $atts['use_container'] ) && $atts['use_container'] == 'yes' )
	$container_class = ' container';

if( !empty( $atts['container_class'] ) )
	$container_class .= ' '.$atts['container_class'];

if( !empty( $atts['css'] ) )
	$css_classes[] = $atts['css'];

/**
*Check video background
*/

if( $atts['video_bg'] === 'yes' )
{
	$video_bg_url = $atts['video_bg_url'];

	$has_video_bg = or_youtube_id_from_url( $video_bg_url );

	if( !empty( $has_video_bg ) )
	{
		$css_classes[] = 'or-video-bg';
		$element_attributes[] = 'data-or-video-bg="' . esc_attr( $video_bg_url ) . '"';
		$css_data .= 'position: relative;';
	}
}


if( !empty( $atts['row_id'] ) )
	$element_attributes[] = 'id="' . esc_attr( $atts['row_id'] ) . '"';


if( $atts['full_width_option'] == 'yes' )
{
	if( !empty( $atts['full_width'] ) )
	{
		if( $atts['full_width'] == 'stretch_row_content' )
			$element_attributes[] = 'data-or-fullwidth="content"';
		else
			$element_attributes[] = 'data-or-fullwidth="row"';
			
		$row_action = true;
		
	}
}

if( $row_action === true )
{
	$after_row_full_action .= '<script>or_row_action(true);</script>';
}


if( empty( $has_video_bg ) )
{
	if( !empty( $atts['parallax'] ) )
	{

		$element_attributes[] = 'data-or-parallax="true"';

		if( empty( $atts['parallax_speed'] ) )
			$atts['parallax_speed'] = 1;

		$element_attributes[] = 'data-speed="'.esc_attr( $atts['parallax_speed'] ).'"';

		if( $atts['parallax'] == 'yes-new' )
		{
			$bg_image_id = $atts['parallax_image'];
			$bg_image = wp_get_attachment_image_src( $bg_image_id, 'full' );
			$css_data .= "background-image:url('".$bg_image[0]."');";
		}

		if( $atts['parallax_background_size'] == 'yes' )
			$element_attributes[] = 'data-or-bgfull="true"';
	}
}


$css_class = implode(' ', $css_classes);
$element_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

if( !empty( $css_data ) )
	$element_attributes[] = 'style="' . esc_attr( trim( $css_data ) ) . '"';

$output .= '<div ' . implode( ' ', $element_attributes ) . '>';

if( !empty( $container_class ) )
	$output .= '<div class="or-row-container' . esc_attr($container_class) . '">';

$output .= do_shortcode( str_replace( 'or_row#', 'or_row', $content ) );

if( !empty( $container_class ) )
	$output .= '</div>';

$output .= '</div>';
$output .= $after_row_full_action;

echo $output;
