<#

if( data === undefined )
	data = {};

var atts = ( data.atts !== undefined ) ? data.atts : {},
	number_color = '#393939',
	label_color = '#393939',
	icon_color = '#393939',
	box_bg_color = 'transparent',
	label = '',
	icon = '',
	style = 1,
	number = 0,
	label_above = '',
	before_number = '',
	after_number = '',
	custom_class = '',
	element_atttribute = [],
	el_classess = [ 'or_shortcode', 'or_counter_box', 'or-box-counter' ];

if( atts['css'] !== undefined && atts['css'] !== '' )
	el_classess .push( atts['css'].split('|')[0] );

if( atts['number'] !== undefined && atts['number'] !== '' )
	number = atts['number'];

if( atts['number_color'] !== undefined && atts['number_color'] !== '' )
	number_color = atts['number_color'];

if( atts['label_color'] !== undefined && atts['label_color'] !== '' )
	label_color = atts['label_color'];

if( atts['icon_color'] !== undefined && atts['icon_color'] !== '' )
	icon_color = atts['icon_color'];

if( atts['style'] !== undefined && atts['style'] !== '' )
	style = atts['style'];

el_classess.push( 'or-box-counter-'+style );

if( atts['wrap_class'] !== undefined && atts['wrap_class'] !== '' )
	el_classess.push( atts['wrap_class'] );

if( atts['label'] !== undefined && atts['label'] !== '' )
	label = '<h4>'+atts['label']+'</h4>';

if( style !== undefined && style != 1){
	if( atts['icon'] !== undefined && atts['icon'] !== '' )
		icon = '<i class="'+atts['icon']+' element-icon"></i>';
}


if( atts['label_above'] !== undefined && atts['label_above'] !== '' )
	label_above = atts['label_above'];

if( label_above == 'yes' ){
	before_number = icon+label;
}else{
	before_number = icon;
	after_number = label;
}

if( atts['box_bg_color'] !== undefined && atts['box_bg_color'] !== '' )
	box_bg_color = atts['box_bg_color'];

if( box_bg_color === '' && '2' == style){
	box_bg_color = '#d9d9d9';
}

if( style == '1' ){
	box_bg_color = 'transparent';	
}

custom_class = 'counter_box_'+parseInt(Math.random()*1000000);

el_classess.push( custom_class );
element_atttribute.push('class="'+el_classess.join(' ')+'"' );

var custom_style = '.'+custom_class+'{ background: '+box_bg_color+';}.'+custom_class+' span.counterup{color: '+number_color+';}'+
	'.'+custom_class+' h4{ color: '+label_color+'; } .'+custom_class+' i{ color: '+icon_color+';}';

before_number = '<style type="text/css">'+custom_style+'</style>'+before_number;

#><div {{{element_atttribute.join(' ')}}}>{{{before_number}}}<span class="counterup">{{number}}</span>{{{after_number}}}</div>