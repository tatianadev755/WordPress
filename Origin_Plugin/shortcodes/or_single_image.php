<?php
/*----------------------------------
 * Single image shortcode
 *--------------------------------*/

$output = $image = $image_title = $image_source = $image_external_link = $image_size = $image_size_el = $caption = $image_align = $on_click_action = $custom_link = $class = $ieclass = $image_full = $html = $css = $animateevent = $animateeffect = '';

$image_wrap = 'yes';
$animateswitch = 'no';

extract( $atts );

$default_src = or_asset_url('images/get_logo.png');

$image_source = $atts['image_source'];

$element_attributes = array();
$image_attributes = array();
$image_classes = array();

$css_classes = array(
	'or_shortcode',
	'or_single_image',
	$atts['class']
);

if( $css != '' )
	$css_classes[] = $css;

$image_url = '';
$image_id = $atts['image'];
$image_size = $atts['image_size'];
$on_click_action = $atts['on_click_action'];
$data_lightbox = '';

if( !empty( $ieclass ) ){
	$image_classes[] = $ieclass;
}

if( $image_source == 'external_link' )
{

	$image_full = $atts['image_external_link'];
	$image_url = $image_full;
	$size = $atts['image_size_el'];

	if( !empty( $image_url ) )
		$image_attributes[] = 'src="'.$image_url.'"';
	else
		$image_attributes[] = 'src="'.$default_src.'"';

	if( empty( $image_full ) )
		$image_full = $default_src;

	if ( preg_match( '/(\d+)x(\d+)/', $size, $matches ) ) {
		$width = $matches[1];
		$height = $matches[2];
		$image_attributes[] = 'width="'.$width.'"';
		$image_attributes[] = 'height="'.$height.'"';
	}
}
else
{

	if( $image_source == 'media_library' )
	{
		$image_id = preg_replace( '/[^\d]/', '', $image_id );
	}
	else
	{
		$post_id = get_the_ID();
		if ( $post_id && has_post_thumbnail( $post_id ) ) {
			$image_id = get_post_thumbnail_id( $post_id );
		} else {
			$image_id = 0;
		}
	}

	$image_full_width = wp_get_attachment_image_src( $image_id, 'full' );
	$image_full = $image_full_width[0];
	$image_data = wp_get_attachment_image_src( $image_id, $image_size );
	$image_url = $image_data[0];

	if( !empty( $image_url ) )
	{
		$image_attributes[] = 'src="'.$image_url.'"';
	}
	else
	{
		$image_attributes[] = 'src="'.$default_src.'"';
		$image_classes[] = 'or_image_empty';
	}


	if( empty( $image_full ) )
		$image_full = $default_src;

}

$image_attributes[] = 'class="'.implode( ' ', $image_classes ).'"';

if(!empty($caption)){
	$image_attributes[] = 'alt="'. trim(esc_attr($caption)) .'"';
}else{
	$image_attributes[] = 'alt=""';
}

if( $on_click_action == 'lightbox' )
{
	$data_lightbox = 'rel="prettyPhoto"';
	wp_enqueue_script('prettyPhoto');
	wp_enqueue_style( 'prettyPhoto' );
}
else if( $on_click_action == 'open_custom_link' )
{
	$image_full = $atts['custom_link'];
}


$css_class = implode(' ', $css_classes);
$element_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
if(!empty($image_align)){
	$element_attributes[] = 'style="text-align: ' . esc_attr( $image_align ) . ';"';
}

if( !empty($on_click_action) ){
	$html .= '<a '.$data_lightbox.' href="'.esc_attr($image_full).'" title="'. strip_tags($caption) .'"><img '. implode( ' ', $image_attributes ) .' /></a>';
}else{
	$html .= '<img '. implode( ' ', $image_attributes ) .' />';
}

if(!empty($caption)){
	$html .= '<p class="scapt">'.html_entity_decode( $caption ).'</p>';
}

if( $image_wrap === 'yes' )
	$output .= '<div ' . implode( ' ', $element_attributes ) . '>'.$html.'</div>';
else $output .= $html;

$effect = 'animated '.$animateeffect;

if($animateswitch == 'yes'){
	if($animateevent == 'onload'){
		$output = "<div class='wow ".$effect."' data-wow-duration='1s' data-wow-delay='0.5s'>".$output."</div>";
	}else{
		$output = "<div ".($animateevent == 'onclick' ? "onClick='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '')." ".($animateevent == 'onhover' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '').">".$output."</div>";
	}
}

echo $output;