<?php
/**
 * or_accordion_tab shortcode
 **/

$css_class = array( 'or_accordion_section', 'group' );
$title = 'Title';

if( isset( $atts['title'] ) )
	$title = $atts['title'];
if( isset( $atts['icon'] ) )
	$title = '<i class="'.esc_attr( $atts['icon'] ).'"></i> '.$title;

if( isset( $atts['class'] ) )
	array_push( $css_class, $atts['class'] );

$output  =  '<div class="'.esc_attr( implode(' ',$css_class) ).'"><h3 class="or_accordion_header ui-accordion-header">'.
					'<span class="ui-accordion-header-icon ui-icon"></span>'.
		  			'<a href="#' . sanitize_title( $title ) . '">' . $title . '</a>'.
		  		'</h3>'.
			  	'<div class="or_accordion_content ui-accordion-content or_clearfix">'.
					'<div class="or-panel-body">'.
						( ( '' === trim( $content ) )
						? __( 'Empty section. Edit page to add content here.', 'origincomposer' )
						: do_shortcode( str_replace('or_accordion_tab#', 'or_accordion_tab', $content ) ) ).
					'</div>'.
				'</div>'.
			'</div>';

echo $output;
