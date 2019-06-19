<#

if( data === undefined )
	data = {};

var el_class = '', height = 0, 
	atts = ( data.atts !== undefined ) ? data.atts : {};

if( atts['class'] !== undefined )
	el_class = atts['class'];

if( atts['css'] !== undefined )
	el_class += ' '+atts['css'].split('|')[0];

if( atts['height'] !== undefined )
	height = parseInt( atts['height'] );

#>

<div class="{{el_class}}" style="height: {{height}}px; clear: both; width:100%;"></div>