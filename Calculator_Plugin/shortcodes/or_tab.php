<?php
/**
 * or_tab shortcode
 **/
 
$tab_id = $title = '';
extract( $atts );

$css_class = array( 'or_tab', 'ui-tabs-panel', 'or_ui-tabs-hide', 'or_clearfix' );

if( empty( $tab_id ) || (strpos( $tab_id,'%time%' ))){
	$tab_id = sanitize_title( $title );
}else{
	$tab_id = esc_attr( $tab_id );
}

if( isset( $class ) )
	array_push( $css_class, $class );

$output = '<div id="' . $tab_id . '" class="' . esc_attr( implode( ' ', $css_class ) ) . '"><div class="or_tab_content">'.
		( ( '' === trim( $content ) ) 
		? __( 'Empty tab. Edit page to add content here.', 'MiniPageBuider' ) 
		: do_shortcode( str_replace('or_tab#', 'or_tab', $content ) ) ).
	'</div></div>';

echo $output;