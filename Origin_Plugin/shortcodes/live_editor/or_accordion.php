<#

if( data === undefined )
	data = {};

var element_attributes = [], css_classes = ['or_accordion_wrapper'], 
	atts = ( data.atts !== undefined ) ? data.atts : {};

if( atts['class'] !== undefined && atts['class'] !== '' )
	css_classes.push( atts['class'] );

if( atts['css'] !== undefined )
	css_classes.push( atts['css'].split('|')[0] );

if( atts['open_all'] !== undefined && atts['open_all'] == 'yes' )
	element_attributes.push( 'data-allowOpenAll="true"' );

element_attributes.push( 'class="'+css_classes.join(' ')+'"' );

data.callback =  function( wrp ){ or_front.accordion( wrp ) };

#>
<div {{{element_attributes.join(' ')}}}>{{{data.content}}}</div>