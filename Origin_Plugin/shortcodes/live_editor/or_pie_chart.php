<#

if( data === undefined )
	data = {};

var atts = ( data.atts !== undefined ) ? data.atts : {},
	custom_class = 'piechart_'+parseInt( Math.random()*1000000 ),
	custom_size = 120,
	barcolor = '#39c14f',
	trackcolor = '#e4e4e4',
	percent = 85,
	rounded_corners_bar = '',
	title = '',
	description = '',
	wrap_class = '',
	element_attributes = [],
	size = 120,
	auto_width = 'no',
	linewidth  = 10,
	css_classes = [ 'or_shortcode', 'or_piechart', custom_class ];

if( atts['title'] !== undefined && atts['title'] !== '' )
	title = '<h3>'+atts['title']+'</h3>';

if( atts['description'] !== undefined && atts['description'] !== '' )
	description = '<p>'+or.tools.base64.decode( atts['description'] )+'</p>';

if( atts['percent'] !== undefined && atts['percent'] !== '' )
	percent = atts['percent'];

if( atts['linewidth'] !== undefined && atts['linewidth'] !== '' )
	linewidth = atts['linewidth'];

if( atts['rounded_corners_bar'] !== undefined && atts['rounded_corners_bar'] !== '' )
	rounded_corners_bar = atts['rounded_corners_bar'];

if( atts['custom_size'] !== undefined && atts['custom_size'] !== '' )
	custom_size = atts['custom_size'];

if( atts['barcolor'] !== undefined && atts['barcolor'] !== '' )
	barcolor = atts['barcolor'];

if( atts['trackcolor'] !== undefined && atts['trackcolor'] !== '' )
	trackcolor = atts['trackcolor'];

if( atts['custom_class'] !== undefined && atts['custom_class'] !== '' )
	css_classes.push( atts['css_classes'] );

if( atts['wrap_class'] !== undefined && atts['wrap_class'] !== '' )
	wrap_class = atts['wrap_class'];

if( atts['css'] !== undefined && atts['css'] !== '' )
	wrap_class += ' '+atts['css'].split('|')[0];

if( atts['size'] !== undefined && atts['size'] !== '' && atts['size'] !== 'custom' )
	size = atts['size'];
else size = custom_size;

if( 'auto' === size)
{
	auto_width    = 'yes';
	css_classes.push( 'auto_width' );
}


element_attributes.push( 'data-size="'+size+'"' );
element_attributes.push( 'data-percent="'+percent+'"' );
element_attributes.push( 'data-linecap="'+rounded_corners_bar+'"' );
element_attributes.push( 'data-barcolor="'+barcolor+'"' );
element_attributes.push( 'data-trackcolor="'+trackcolor+'"' );
element_attributes.push( 'data-autowidth="'+auto_width+'"' );
element_attributes.push( 'data-linewidth="'+linewidth+'"' );

element_attributes.push( 'class="'+css_classes.join(' ')+'"' );

var lineHeight = parseInt(size)+(parseInt(linewidth)*2);

#><div class="or-pie-chart-wrapper {{wrap_class}}">
	<div class="or-pie-chart-holder">
		<span {{{element_attributes.join(' ')}}}>
			<span class="percent"></span>
		</span>
	</div>

	<div class="pie_chart_text">
		{{{title}}}{{{description}}}
		<style type="text/css"><#
			var label_color = or.std( atts, 'label_color', '#FF5252' ),
				label_font_size = parseInt( or.std( atts, 'label_font_size', 20 ) );
		#>.{{custom_class}} span.percent{ font-size	: {{label_font_size}}px; color : {{label_color}};";</style>
	</div>
	
</div><#

	data.callback = function( wrp, $ ){
		or_front.piechar.update( wrp );	
	}
#>