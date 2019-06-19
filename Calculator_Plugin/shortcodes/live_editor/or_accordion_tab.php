<#

if( data === undefined )
	data = {};

var element_attributes = [], title = 'Title', css_class = [ 'or_accordion_section', 'group' ], 
	atts = ( data.atts !== undefined ) ? data.atts : {};


if( atts['title'] !== undefined && atts['title'] !== '' )
	title = atts['title'];

if( atts['icon'] !== undefined && atts['icon'] !== '' )
	title = '<i class="'+atts['icon']+'"></i> '+title;
	
if( atts['class'] !== undefined && atts['class'] !== '' )
	css_class.push( atts['class'] );

if( data.content === undefined )
	data.content = '';
data.content += '<div class="or-element drag-helper" data-model="-1" droppable="true" draggable="true"><a href="javascript:void(0)" class="or-add-elements-inner">Add Elements</a></div>';	

#>
<div class="{{css_class.join(' ')}}">
	<h3 class="or_accordion_header ui-accordion-header">
		<span class="ui-accordion-header-icon ui-icon"></span>
		<a href="#{{or.tools.esc_slug(title)}}">{{{title}}}</a>
	</h3>
	<div class="or_accordion_content ui-accordion-content or_clearfix">
		<div class="or-panel-body">{{{data.content}}}</div>
	</div>
</div>