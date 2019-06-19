<?php

$output = $class = $title = $css = '';

extract( $atts );

$element_attribute = array();

if( $css != '' )$class .= ' '.$css;

$element_attribute[] = 'class="'. esc_attr( $class ) .'"';

if ( !empty( $title ) )
	$output .= '<h3>' . $title . '</h3>';

if(isset($contact_form_id) && $contact_form_id > 0){
	$output .= '<div '. implode( ' ', $element_attribute) .'>';
	$output .= do_shortcode('[contact-form-7 id="'. $contact_form_id .'"]');
	$output .= '</div>';
}else{
	$output .= __( 'Please create new and select contact form 7.', 'originbuilder' );
}

echo $output;
