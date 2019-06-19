<#

var output = '', atts = ( data.atts !== undefined ) ? data.atts : {},
	css_classes = [ 'or_row', 'or_row_inner' ], attributes = [];

if( undefined !== atts['row_class'] && atts['row_class'] !== '' )
	css_classes.push( atts['row_class'] );

if( atts['css'] !== undefined && atts['css'] !== '' )
	css_classes.push( atts['css'].split('|')[0] );
	
if( undefined !== atts['row_id'] && atts['row_id'] !== '' )
	attributes.push( 'id="'+atts['row_id']+'"' );

attributes.push( 'class="'+css_classes.join(' ')+'"' );

if( undefined !== atts['equal_height'] && atts['equal_height'] !== '' )
{
	attributes.push( 'data-or-equalheight="true"' );
	attributes.push( 'data-or-row-action="true"' );
	data.callback = function(){
		or_row_action(true);
	}
}

output += '<div '+attributes.join(' ')+'>';

if( undefined !== atts['row_class_container'] && atts['row_class_container'] !== '' )
	output += '<div class="'+atts['row_class_container']+'">';

output += data.content;

if( undefined !== atts['row_class_container'] && atts['row_class_container'] !== '' )
	output += '</div>';

output += '</div>';

#>

{{{output}}}