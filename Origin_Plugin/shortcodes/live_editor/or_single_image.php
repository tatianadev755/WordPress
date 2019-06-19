<#

var output = '', atts = ( data.atts !== undefined ) ? data.atts : {},
	default_src = '<?php echo or_URL.'/assest/images/get_logo.png'; ?>',
	image_source = ( atts['image_source'] !== undefined ) ? atts['image_source'] : '',
	element_attributes = [],
	image_attributes = [],
	css_classes = [ 'or_shortcode', 'or_single_image' ],
	image_url = '';
	caption = '',
	image_id = ( atts['image'] !== undefined ) ?  atts['image'] : '',
	image_size = ( atts['image_size'] !== undefined ) ?  atts['image_size'] : '',
	on_click_action = ( atts['on_click_action'] !== undefined ) ?  atts['on_click_action'] : '',
	image_wrap = 'yes',
	data_lightbox = '';
	
	
if( atts['class'] !== undefined && atts['class'] !== '' )
	css_classes.push( atts['class'] );	

if( atts['image_wrap'] !== undefined && atts['image_wrap'] !== '' )
	image_wrap = atts['image_wrap'];

if( atts['css'] !== undefined && atts['css'] !== '' )
	css_classes.push( atts['css'].split('|')[0] );	


if( image_source == 'external_link' )
{

	var image_full = ( atts['image_external_link'] !== undefined ) ? atts['image_external_link'] : '',
		image_url = image_full,
		size = ( atts['image_size_el'] !== undefined ) ? atts['image_size_el'] : 'full';

	if( image_url !== '' )
		image_attributes.push( 'src="'+image_url+'"' );
	else
		image_attributes.push( 'src="'+default_src+'"' );

	if( image_full == '' )
		image_full = default_src;
	
	var regx = /(\d+)x(\d+)/;
	if (  result = regx.exec( size ) ) {
		var width = result[1],
			height = result[2];
		image_attributes.push( 'width="'+width+'"' );
		image_attributes.push( 'height="'+height+'"' );
	}
}
else
{

	if( image_source == 'media_library' )
	{
		image_id = image_id.replace( /[^\d]/, '' );
		image_full = '<?php echo admin_url('/admin-ajax.php?action=or_get_thumbn&size=full&id='); ?>'+image_id;
	}
	else
	{
		<?php
		$post_id = get_the_ID();
		if ( $post_id && has_post_thumbnail( $post_id ) ) {
			$image_id = get_post_thumbnail_id( $post_id );
		} else {
			$image_id = 0;
		}
		echo 'image_id = '.$image_id.';';
		?>
	}
	image_full = '<?php echo admin_url('/admin-ajax.php?action=or_get_thumbn&size=full&id='); ?>'+image_id;
	image_attributes.push( 'src="<?php echo admin_url('/admin-ajax.php?action=or_get_thumbn&id='); ?>'+image_id+'&size='+image_size+'"' );

}

if( atts['ieclass'] !== undefined && atts['ieclass'] !== '' )
	image_attributes.push( 'class="'+atts['ieclass']+'"' );

if( atts['caption'] !== undefined && atts['caption'] !== '' )
	caption = atts['caption'];
	
image_attributes.push( 'alt="'+caption+'"' );

if( on_click_action == 'lightbox' )
	data_lightbox = 'rel="prettyPhoto"';
else if( on_click_action == 'open_custom_link' )
	image_full = atts['custom_link'];

element_attributes.push( 'class="'+css_classes.join(' ')+'"' );

if( atts['image_align'] !== undefined && atts['image_align'] !== '' )
	element_attributes.push( 'style="text-align: '+atts['image_align']+';"' );

if( on_click_action !== '' ){
	output += '<a '+data_lightbox+' href="'+image_full+'" title="'+caption+'"><img '+image_attributes.join(' ')+' /></a>';
	data.callback = function( wrp, $ ){
		$(wrp.find("a[rel^='prettyPhoto']")).prettyPhoto({ social_tools: false });
	}
}else{
	output += '<img '+image_attributes.join(' ')+' />';
}

if( caption !== '' ){
	output += '<p>'+atts['caption']+'</p>';
}

if( image_wrap == 'yes' )
	output = '<div '+element_attributes.join(' ')+'>'+output+'</div>';

#>

{{{output}}}