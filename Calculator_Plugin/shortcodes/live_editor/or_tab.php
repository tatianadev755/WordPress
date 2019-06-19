<#

var output = '', css_class = [ 'or_tab', tab_id = '', 'ui-tabs-panel', 'or_ui-tabs-hide', 'or_clearfix' ], 
	atts = ( data.atts !== undefined ) ? data.atts : {};

if ( atts['tab_id'] !== undefined && atts['tab_id'] !== '' ){
	tab_id = or.tools.esc_slug( atts['title'] );
}else{
	tab_id = atts['tab_id'];
}

if ( atts['class'] !== undefined && atts['class'] !== '' )
	css_class.push( atts['class'] );

if( data.content === undefined )
	data.content = '';
	
data.content += '<div class="or-element drag-helper" data-model="-1" droppable="true" draggable="true"><a href="javascript:void(0)" class="or-add-elements-inner"> Add Elements</a></div>';

#><div id="{{tab_id}}" class="{{{css_class.join(' ')}}}"><div class="or_tab_content">{{{data.content}}}</div></div>