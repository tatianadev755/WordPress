<#

var output = '', element_attributes = [], el_classes = ['or_box_wrap'],
	atts = ( data.atts !== undefined ) ? data.atts : {};

if( atts['custom_class'] !== undefined && atts['custom_class'] !== '' )
	el_classes.push( atts['custom_class'] );

if( atts['css'] !== undefined && atts['css'] !== '' )
	el_classes.push( atts['css'].split('|')[0] );

element_attributes.push( 'class="'+el_classes.join(' ')+'"' );

#>

<div class="{{el_classes.join(' ')}}"><#

data = or.tools.base64.decode( atts['data'] );
data = data.replace( /\%SITE\_URL\%/g, site_url );

if( data = JSON.parse( data ) )
{
	#>{{{or.front.loop_box( data )}}}<#
	if( atts['css'] !== undefined ){
		#><style type="text/css">{{{atts['css']}}}</style><#
	}
}
else
{
	#>or Box: Error content structure<#
}

if( atts['css_code'] !== undefined ){
	#><style type="text/css">{{{atts['css_code']}}}</style><# 
}
#></div>