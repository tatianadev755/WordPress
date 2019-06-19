<#

if( typeof( data ) == 'undefined' )
	data = {};

var output = '', style = '', el_class = '', attributes = [], atts = jQuery().extend( { icon : '', icon_size : '', icon_color : '', icon_align : 'none', icon_wrap : 'no', icon_wrap_class : '' }, ( ( data.atts !== undefined ) ? data.atts : {} ) );


if( atts['icon_size'] != '' ){
	style += 'font-size: '+atts['icon_size'];
	if( /^\d+$/.test( atts['icon_size'] ) )
		style += 'px;';
	else style += ';';
}

if( atts['icon_color'] )
	style += 'color: '+atts['icon_color']+';';

if( atts['icon'] != '' )
	el_class += ' '+atts['icon'];
else el_class += ' fa-leaf';

if( atts['css'] !== undefined )
	el_class += ' '+atts['css'].split('|')[0];
	
attributes.push( 'style="'+style+'"' );
attributes.push( 'class="'+el_class+'"' );


output = '<i '+attributes.join(' ')+'></i>';

if( atts['icon_align'] != 'none' ){
	atts['icon_align'] = 'style="text-align: '+atts['icon_align']+';"';
}

if( atts['icon_wrap'] == 'yes' || atts['icon_align'] != 'none' )
{
	if( atts['icon_wrap_class'] !== '' )
		output = '<div class="or-icon-wrapper '+atts['icon_wrap_class']+'" '+atts['icon_align']+'>'+output+'</div>';
	else output = '<div class="or-icon-wrapper" '+atts['icon_align']+'>'+output+'</div>';
}

#>

{{{output}}}