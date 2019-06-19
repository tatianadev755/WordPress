<?php
/*
 * Google maps shortcode template
 */

$output = $title = $wrap_class = $contact_form = $disable_wheel_mouse = $custom_class = $css = $animateevent = $animateeffect = '';
$animateswitch = 'no';
$map_width = '100%';
$map_height = '250px';

$contact_area_position = 'left';
$google_maps_info = array();

extract( $atts );

$element_attributes = array();
$map_attributes     = array();

$css_classes = array(
    'or_google_maps',
    'or_shortcode',
    $wrap_class,
    $custom_class
);

if( $css != '' )$css_classes[] = $css;

$element_attributes[] = 'class="'. esc_attr( implode( ' ', $css_classes ) ) .'"';

if( !empty( $title ) ){
    $output .= '<h3 class="map_title">'. esc_html( $title ) .'</h3>';
}

//Contact form on maps
if( !empty($show_ocf) && 'yes' === $show_ocf ){
    if(!empty( $contact_form_sc )){
        $contact_form = '<div class="map_popup_contact_form '. $contact_area_position .'">';
        $contact_form .= '<a class="close" href="javascript:;"><i class="sl-close"></i></a>';
        $contact_form .= do_shortcode( $contact_form_sc );
        $contact_form .= '</div>';
        $contact_form .= '<a class="show_contact_form" href="javascript:;"><i class="fa fa-bars"></i></a>';
    }
}

$map_attributes[] = 'id="'. esc_attr( $custom_class ) .'"';
$map_attributes[] = 'style="height: '. esc_attr( $map_height ) .'"';
$map_attributes[] = 'class="or-google-maps"';

$map_location = preg_replace( array('/width="\d+"/i', '/height="\d+"/i'), array(
        sprintf('width="%s"', $map_width ),
        sprintf('height="%d"', intval( $map_height ))
    ),
   $map_location );

if( isset( $_GET['or_action'] ) && $_GET['or_action'] === 'live-editor' ){
	
	$map_location = '<div style="width: 100%;height:'.$map_height.';" class="disable-view-element"><h3>For best perfomance, the map has been disabled in this editing mode.</h3></div>';
   
}

$output .= '<div '. implode( ' ', $element_attributes ) .'>'. $contact_form .'<div '. implode( ' ', $map_attributes ) .'>'. $map_location .'</div></div>';

$effect = 'animated '.$animateeffect;

if($animateswitch == 'yes'){
	if($animateevent == 'onload'){
		$output = "<div class='wow ".$effect."' data-wow-duration='1s' data-wow-delay='0.5s'>".$output."</div>";
	}else{
		$output = "<div ".($animateevent == 'onclick' ? "onClick='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '')." ".($animateevent == 'onhover' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '').">".$output."</div>";
	}
}

echo $output;
