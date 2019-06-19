<#

var atts = ( data.atts !== undefined ) ? data.atts : {}, el_class = 'or_text_block';

if( atts['class'] !== undefined && atts['class'] !== '' )
	el_class += ' '+atts['class'];

if( atts['css'] !== undefined && atts['css'] !== '' )
	el_class += ' '+atts['css'].split('|')[0];

#>

<div class="{{el_class}}">{{{top.switchEditors.wpautop(data._content)}}}</div>