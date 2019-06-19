<#
	
	if( data === undefined )
		data = {};
	var attributes = [], classes = ['or_row'], action = false, container_class = '', css_data = '', output = '', 
		atts = ( data.atts !== undefined ) ? data.atts : {};

if( atts['row_class'] !== undefined && atts['row_class'] !== '' )
	classes.push( atts['row_class'] );

if( atts['full_height'] !== undefined && atts['full_height'] !== '' ){
	
	if( atts['content_placement'] !== undefined && atts['content_placement'] == 'middle' )
		attributes.push( 'data-or-fullheight="middle-content"' );
	else attributes.push( 'data-or-fullheight="true"' );
	
	action = true;
}

if( atts['equal_height'] !== undefined && atts['equal_height'] !== '' ){
	
	attributes.push( 'data-or-equalheight="true"' );
	action = true;
}

if( atts['use_container'] !== undefined && atts['use_container'] == 'yes' )
	container_class = ' container';

if( atts['container_class'] !== undefined && atts['container_class'] !== '' )
	container_class += ' '+atts['container_class'];

if( atts['css'] !== undefined && atts['css'] !== '' )
	classes .push( atts['css'].split('|')[0] );

if( atts['video_bg'] !== undefined && atts['video_bg'] === 'yes' )
{
	var video_bg_url = atts['video_bg_url'];

	if( atts['video_bg_url'] !== undefined )
	{
		classes.push('or-video-bg');
		attributes.push('data-or-video-bg="'+atts['video_bg_url']+'"');
		css_data += 'position: relative;';
	}
} 

if( atts['row_id'] !== undefined && atts['row_id'] !== '' )
	attributes.push( 'id="'+atts['row_id']+'"' );

if( atts['full_width_option'] !== undefined && atts['full_width_option'] == 'yes' )
{
	if( atts['full_width'] !== undefined )
	{
		if( atts['full_width'] == 'stretch_row_content' )
			attributes.push( 'data-or-fullwidth="content"' );
		else
			attributes.push( 'data-or-fullwidth="row"' );
			
		action = true;
		
	}
}

if( action === true )
{
	data.callback = function(){
		or_row_action(true);
	}
}


if( atts['video_bg_url'] === undefined )
{
	if( atts['parallax'] !== undefined )
	{

		attributes.push( 'data-or-parallax="true"' ); 

		if( atts['parallax_speed'] !== undefined )
			atts['parallax_speed'] = 1;

		attributes.push( 'data-speed="'+atts['parallax_speed']+'"' );

		if( atts['parallax'] == 'yes-new' )
		{
			var bg_image = '<?php echo admin_url('/admin-ajax.php?action=or_get_thumbn&size=full&id='); ?>'+atts['parallax_image'];
			css_data += "background-image:url('"+bg_image+"');";
		}

		if( atts['parallax_background_size'] == 'yes' )
			attributes.push( 'data-or-bgfull="true"' );
	}
}

attributes.push( 'class="'+classes.join(' ')+'"' );

if( css_data !== '' )
	attributes.push( 'style="'+css_data+'"' );

output += '<div '+attributes.join(' ')+'>';

if( container_class !== '' )
	output += '<div class="or-row-container'+container_class+'">';

output += data.content;

if( container_class !== '' )
	output += '</div>';

output += '</div>';

#>

{{{output}}}
