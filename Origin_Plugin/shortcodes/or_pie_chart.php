<?php
$output = $_class = $wrap_class = $custom_class = $auto_width =  $percent = $size = $linewidth = $css = '';

extract( $atts );

$custom_size = !empty($custom_size) ? $custom_size : 120;
$custom_size = intval($custom_size);
$barcolor    = (!empty($barcolor)) ? $barcolor     : '#39c14f';
$trackcolor  = (!empty($trackcolor)) ? $trackcolor : '#e4e4e4';
$linewidth  = (!empty($linewidth)) ? $linewidth : '10';

$element_attributes = array();

$css_classes = array(
	'or_shortcode',
	'or_piechart',
	$custom_class,
);

if( $css != '' )$css_classes[] = $css;

$size = ('custom' === $size && !empty( $size )) ? $custom_size : $size;
if( empty( $size ) )	$size = $custom_size;

if( 'auto' === $size)
{
	$auto_width    = 'yes';
	$css_classes[] = 'auto_width';
}


$element_attributes[] = 'data-size="' .esc_attr(intval($size)). '"';
$element_attributes[] = 'data-percent="' .esc_attr( $percent ). '"';
$element_attributes[] = 'data-linecap="' .esc_attr( $rounded_corners_bar ). '"';
$element_attributes[] = 'data-barcolor="' .esc_attr( $barcolor ). '"';
$element_attributes[] = 'data-trackcolor="' .esc_attr( $trackcolor ). '"';
$element_attributes[] = 'data-autowidth="' .esc_attr( $auto_width ). '"';
$element_attributes[] = 'data-linewidth="' .esc_attr( $linewidth ). '"';

$css_class            = implode(' ', $css_classes);
$element_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$_title               = (empty($atts['title'])) ? ' ' : '<h3>'. $atts['title'] .'</h3>';
$_description         = (empty($atts['description'])) ? ' ' : '<p>'.$atts['description'].'</p>';


if( isset( $atts['css'] ) && !empty( $atts['css'] ) ){
	$wrap_class .= ' '.$atts['css'];
}

?><div class="or-pie-chart-wrapper <?php echo esc_attr( $wrap_class ); ?>">
	<div class="or-pie-chart-holder">
		<span <?php echo implode( ' ', $element_attributes ); ?>>
			<span class="percent"></span>
		</span>
	</div>
	<div class="pie_chart_text">
		<?php echo $_title . $_description; ?>
	</div>
</div>
