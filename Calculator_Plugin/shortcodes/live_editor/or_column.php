<#
	if( data === undefined )data = {};
	var width = '', output = '', attributes = [], classes = [], atts = ( data.atts !== undefined ) ? data.atts : {};

classes.push('or_column');

if( atts['col_class'] !== undefined )
	classes.push( atts['col_class'] );

if( atts['css'] !== undefined )
	classes.push( atts['css'].split('|')[0] );

if( atts['width'] !== undefined ){
	if( atts['width'].indexOf('%') === -1 )
		classes.push( or.front.ui.column.width_class( atts['width'] ) );
	else attributes.push('style="width:'+atts['width']+'"');
}

attributes.push( 'class="'+classes.join(' ')+'"' );

var col_container_class = ( atts['col_container_class'] !== undefined ) ? ' '+atts['col_container_class'] : '';

if( data.content === undefined )
	data.content = '';
	
data.content += '<div class="or-element drag-helper" data-model="-1" droppable="true" draggable="true"><a href="javascript:void(0)" class="or-add-elements-inner"> Add Elements</a></div>';

#><div {{{attributes.join(' ')}}}>
	<div class="or-col-container{{col_container_class}}">{{{data.content}}}</div>
	<#
		if( atts[ 'css' ] !== undefined && atts[ 'responsive' ] !== undefined &&  atts[ 'responsive' ] !== '' ){
			#><style type="text/css">{{{or.front.ui.style.responsive(atts['responsive'],atts['css'].split('|')[0])}}}</style><#
		}
	#>
</div>