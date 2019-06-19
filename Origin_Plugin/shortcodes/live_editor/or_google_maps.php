<#

if( data === undefined )
	data = {};


var output = '', contact_form = '', map_location = '',
	map_height = '250px',
	contact_area_position = 'left',
	custom_class = 'or-map_'+parseInt( Math.random()*100000 ),
	element_attributes = [], map_attributes = [],
	atts = ( data.atts !== undefined ) ? data.atts : {};


var css_classes = [ 'or_google_maps', 'or_shortcode', custom_class ];

if( atts['contact_area_position'] !== undefined && atts['contact_area_position'] != '' )
	contact_area_position = atts['contact_area_position'];


if( atts['wrap_class'] !== undefined && atts['wrap_class'] !== '' )
	css_classes.push( atts['wrap_class'] );

if( atts['custom_class'] !== undefined && atts['custom_class'] !== '' )
	css_classes.push( atts['custom_class'] );

element_attributes.push( 'class="'+ css_classes.join(' ') +'"' );

if( atts['title'] !== undefined && atts['title'] !== '' ){
    output += '<h3 class="map_title">'+ atts['title'] +'</h3>';
}

//Contact form on maps
if( atts['show_ocf'] !== undefined && 'yes' == atts['show_ocf'] ){
    if( atts['contact_form_sc'] !== undefined && atts['contact_form_sc'] != '' ){
        contact_form += '<div class="map_popup_contact_form '+ contact_area_position +'">';
        contact_form += '<a class="close" href="javascript:;"><i class="sl-close"></i></a>';
        contact_form += or.tools.base64.decode(atts['contact_form_sc']);
        contact_form += '</div>';
        contact_form += '<a class="show_contact_form" href="javascript:;"><i class="fa fa-bars"></i></a>';
    }
}

map_attributes.push( 'class="or-google-maps"' );
map_attributes.push( 'style="height: '+ parseInt(atts['map_height']) +'px"' );

map_location = '<div style="width: 100%;height:'+atts['map_height']+';" class="disable-view-element"><h3>For best perfomance, the map has been disabled in this editing mode.</h3></div>';

	
var contact_area_bg = ( atts['contact_area_bg'] !== undefined )? atts['contact_area_bg'] : 'rgba(42,42,48,0.95)',
contact_form_color	= ( atts['contact_form_color'] !== undefined )? atts['contact_form_color'] : '#FFFFFF',
submit_button_color = ( atts['submit_button_color'] !== undefined )? atts['submit_button_color']: '#393939',
submit_button_hover_color = ( atts['submit_button_hover_color'] !== undefined )? atts['submit_button_hover_color'] : '#575757',
submit_button_text_color = ( atts['submit_button_text_color'] !== undefined )? atts['submit_button_text_color'] : '#FFFFFF',
submit_button_text_hover_color = ( atts['submit_button_text_hover_color'] !== undefined )? atts['submit_button_text_hover_color'] : '#FFFFFF',
contact_area_width = ( atts['contact_area_width'] !== undefined )? atts['contact_area_width'] : '#FFFFFF';

	
	output += '<div '+ element_attributes.join(' ') +'>'+ contact_form +'<div '+ map_attributes.join(' ') +'>'+ map_location +'</div></div>';


#>

<div {{{element_attributes.join(' ')}}}>
	{{{contact_form}}}
	<div {{{map_attributes.join(' ')}}}>{{{map_location}}}</div>
	<style type="text/css">
		.{{custom_class}} .map_popup_contact_form{
			background	: {{contact_area_bg}};
			color		: {{contact_form_color}};
			width		: {{contact_area_width}};
		}
		.{{custom_class}} .show_contact_form{
			background	: {{contact_area_bg}};
			color		: #fff;
		}
		.{{custom_class}} .map_popup_contact_form .wpcf7-submit{
			background	: {{submit_button_color}};
		    border		: 1px solid $submit_button_color;
			color		: {{submit_button_text_color}};
		}
		.{{custom_class}} .map_popup_contact_form .wpcf7-submit:hover{
			background	: {{submit_button_hover_color}};
		    border		: 1px solid {{submit_button_hover_color}};
			color		: {{submit_button_text_hover_color}};
		}
	</style>
</div>
<#
	data.callback = function( wrp, $ ){
		or_front.google_maps( wrp.parent() );	
	}
#>