<#

var output = '', attributes = [], col_in_class_container = 'or_wrapper', 
	classes = [ 'or_column_inner' ], atts = ( data.atts !== undefined ) ? data.atts : {};

if( undefined !== atts['col_in_class'] && atts['col_in_class'] !== '' )
	classes.push( atts['col_in_class'] );

if( undefined !== atts['css'] && atts['css'] !== '' )
	classes .push( atts['css'].split('|')[0] );

if( atts['width'] !== undefined ){
	if( atts['width'].indexOf('%') === -1 )
		classes.push( or.front.ui.column.width_class( atts['width'] ) );
	else attributes.push('style="width:'+atts['width']+'"');
}

if( undefined !== atts['col_in_class_container'] && atts['col_in_class_container'] !== '' )
	col_in_class_container += ' '+atts['col_in_class_container'];

attributes.push( 'class="'+classes.join(' ')+'"' );

if( data.content === undefined )
	data.content = '';
	
data.content += '<div class="or-element drag-helper" data-model="-1" droppable="true" draggable="true"><a href="javascript:void(0)" class="or-add-elements-inner"> Add Elements</a></div>';


#><div {{{attributes.join(' ')}}}>
	<div class="{{col_in_class_container}}'">{{{data.content}}}</div>
	<#
		if( atts[ 'css' ] !== undefined && atts[ 'responsive' ] !== undefined &&  atts[ 'responsive' ] !== '' ){
			#><style type="text/css">{{{or.front.ui.style.responsive(atts['responsive'],atts['css'].split('|')[0])}}}</style><#
		}
	#>
</div>