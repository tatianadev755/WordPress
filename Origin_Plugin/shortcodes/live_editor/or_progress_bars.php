<#


var output = '', element_attributes = [], el_classes = [ 'or_shortcode', 'or_progress_bars' ], 
	atts = ( data.atts !== undefined ) ? data.atts : {},
	radius = '',
	speed = 2000,
	margin = 20,
	progress_bar_color_default = '#999999',
	progress_bar_track_color_default = '#e0e0e0',
	value_color_style = ' style="color: #333333;"',
	label_color_style = ' style="color: #333333;"';

if( atts['wrap_class'] !== undefined && atts['wrap_class'] !== '' )
	el_classes.push( atts['wrap_class'] );	

if( atts['custom_class'] !== undefined && atts['custom_class'] !== '' )
	el_classes.push( atts['custom_class'] );	

if( atts['css'] !== undefined && atts['css'] !== '' )
	el_classes.push( atts['css'].split('|')[0] );	

if( atts['radius'] !== undefined && atts['radius'] !== '' )
	radius = atts['radius'];

if( atts['speed'] !== undefined && atts['speed'] !== '' )
	speed = atts['speed'];
	
if( atts['margin'] !== undefined && atts['margin'] !== '' )
	margin = atts['margin'];

var style = ( atts['style'] !== undefined ) ? atts['style'] : 1;

try{
	var options = JSON.parse( or.tools.base64.decode( atts['options'] ).toString().replace( /\%SITE\_URL\%/g, site_url ) );
}catch(ex){
	var options = null;
}
element_attributes.push( 'class="'+el_classes.join(' ')+'"' );
element_attributes.push( 'data-style="'+style+'"' );

output += '<div '+element_attributes.join(' ')+'>';

if( atts['title'] !== undefined && atts['title'] !== '' )
	output += '<h3>'+atts['title']+'</h3>';

if( options !== null ){
	for( var n in options ){

		var value = ( options[n]['value'] !== undefined && options[n]['value'] !== '' ) ? options[n]['value'] : 50,
			label = ( options[n]['label'] !== undefined && options[n]['label'] !== '' ) ? options[n]['label'] : 'Label default',
			prob_color = ( options[n]['prob_color'] !== undefined && options[n]['prob_color'] !== '' ) ? options[n]['prob_color'] : progress_bar_color_default,
			prob_style = 'background-color: '+prob_color+';',
			prob_bg_color =   ( options[n]['prob_bg_color'] !== undefined && options[n]['prob_bg_color'] !== '' ) ? options[n]['prob_bg_color'] : progress_bar_track_color_default,
			prob_track_style = 'background-color: '+prob_bg_color+';';

		if( style == 4 )
		{
			prob_style += 'background-color: '+prob_color+';';
			prob_track_style += 'background-color: '+prob_bg_color+';';
		}

		if( atts['weight'] !== undefined && atts['weight'] !== '' ){
			prob_style += 'height: '+atts['weight']+'px;';

			if( style == 1 || style == 2 ){
				prob_track_style += 'height: '+atts['weight']+'px;';
			}
		}

		prob_style += 'width: '+atts['progress_animate']+'%';
		
		if( options[n]['value_color'] !== undefined && options[n]['value_color'] !== '' ){
			value_color_style = ' style="color: '+options[n]['value_color']+'"';
		}
		
		if( options[n]['label_color'] !== undefined && options[n]['label_color'] !== '' ){
			label_color_style = ' style="color: '+options[n]['label_color']+'"';
		}


		prob_track_attributes = [];
		prob_attributes = [];

		//Progress bars track attributes
		prob_track_css_classes = [
			'or-ui-progress-bar',
			'or-ui-progress-bar'+style,
			'or-progress-bar',
			'or-ui-container',
		];
		
		if( radius == 'yes' )
			prob_track_css_classes.push( 'or-progress-radius' );
		
		prob_track_attributes.push( 'class="'+prob_track_css_classes.join(' ')+'"' );
		prob_track_attributes.push( 'style="'+prob_track_style+'"' );

		//Progress bars attributes
		prob_css_classes = [ 'or-ui-progress', 'or-ui-progress'+style ];

		var prob_css_class = prob_css_classes.join(' ');
		prob_attributes.push( 'class="'+prob_css_class+'"' );
		prob_attributes.push( 'style="'+prob_style+'"' );

		output +='<div class="progress-item" style="margin-top:'+(margin/2)+'px;margin-bottom:'+(margin/2)+'px;">';

		output += '<span class="label" '+label_color_style+'>'+label+'</span>';
		output += '<div '+prob_track_attributes.join(' ')+'>';
			output += '<div '+prob_attributes.join(' ')+' data-value="'+value+'" data-speed="'+speed+'">';
				output += '<div class="ui-label"><span class="value" '+value_color_style+'>'+value+'%</span></div>';
			output += '</div>';
		output += '</div>';

		output += '</div>';

	}
}

output += '</div>';

data.callback = function( wrp, $ ){
	or_front.refresh( wrp );
} 

#>

{{{output}}}
