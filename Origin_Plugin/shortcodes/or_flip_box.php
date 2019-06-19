<?php

$output = $back_data = $custom_class = $css = '';
$text_align = 'center';
$link = '#';

extract( $atts );

$element_atttribute = array();

$el_classess = array(
	'or-flipbox',
	'or-flip-container',
	$wrap_class,
	$custom_class
);

if( $css != '' )$el_classes[] = $css;

if( isset( $direction ) && $direction == 'vertical' )
	$el_classess[] = 'flip-vertical';
	
$element_atttribute[] = 'class="'. esc_attr( implode(' ', $el_classess) ) .'"';
$element_atttribute[] = 'ontouchstart="this.classList.toggle(\'hover\');"';

if(empty($image_size))
	$image_size = 'full';

if(!empty($image)){
	$image_data = wp_get_attachment_image_src( $image, $image_size );
}

if(!empty($title))
	$back_data .= '<h3>'. esc_html($title) .'</h3>';

if(!empty($description))
	$back_data .= '<p>'. do_shortcode( $description ) .'</p>';

if(!empty($show_button) && 'yes' === $show_button){
	$text_on_button = (!empty($text_on_button)) ? $text_on_button : __('Read more', 'originbuilder');
	$back_data .= '<a class="button" href="'.esc_url( $link ).'">'.html_entity_decode($text_on_button).'</a>';
}

?>
<div <?php echo implode(' ', $element_atttribute); ?>>
	<div class="flipper">
		<div class="front">
			<?php if(!empty($image_data)){ ?>
				<img src="<?php echo esc_url($image_data[0]); ?>" />
			<?php } ?>
		</div>
		<div class="back">
			<div class="des" style="text-align:<?php echo $text_align; ?>">
				<?php echo $back_data; ?>
			</div>
		</div>
	</div>
</div>
