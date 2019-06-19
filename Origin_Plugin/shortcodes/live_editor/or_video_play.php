<#

if( data === undefined )
	data = {};

var atts = ( data.atts !== undefined ) ? data.atts : {},
	video_height = 250,
	video_width = '100%',
	video_info = '',
	el_classess = [ 'or_shortcode', 'or_video_play', 'or_video_wrapper' ];

if( atts['wrap_class'] !== undefined && atts['wrap_class'] !== '' )
	el_classess.push( atts['wrap_class'] );

if( atts['css'] !== undefined && atts['css'] !== '' )
	el_classess.push( atts['css'].split('|')[0] );

if( atts['video_height'] !== undefined && atts['video_height'] !== '' )
	video_height = parseInt( atts['video_height'] );

if( atts['video_width'] !== undefined && atts['video_width'] !== '' )
	video_width = parseInt( atts['video_width'] )+'px';

if( atts['title'] !== undefined && atts['title'] !== '' )
	video_info += '<h3>'+atts['title']+'</h3>';

if( atts['description'] !== undefined && atts['description'] !== '' )
	video_info += '<p>'+or.tools.base64.decode( atts['description'] )+'</p>';


#>
<div class="{{{el_classess.join(' ')}}}">
	<div style="height:{{video_height}}px;width:{{video_width}};" class="disable-view-element">
		<h3>For best perfomance, the video map has been disabled in this editing mode.</h3>
	</div>
	<div class="video-info">{{{video_info}}}</div>
</div>