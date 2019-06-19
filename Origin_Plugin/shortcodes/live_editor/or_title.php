<#

var output = '', classes = ['or_title'], wrp_class = [], attributes = [], type = 'h1', atts = ( data.atts !== undefined ) ? data.atts : {};

if( atts['class'] !== undefined && atts['class'] !== '' )
	classes.push( atts['class'] );

if( atts['type'] !== undefined && atts['type'] !== '' )
	type = atts['type'];

if( atts['css'] !== undefined && atts['css'] !== '' ){
	if( atts['title_wrap'] !== undefined && atts['title_wrap'] == 'yes' )
		wrp_class.push( atts['css'].split('|')[0] );
	else classes.push( atts['css'].split('|')[0] );
}
	
if( atts['align'] !== undefined && atts['align'] !== '' )
	classes.push( 'align-'+atts['align'] );

attributes.push( 'class="'+classes.join(' ')+'"' );

output = '<'+type+' '+attributes.join(' ')+'>'+or.tools.base64.decode(atts['text'])+'</'+type+'>';

if( atts['title_wrap'] !== undefined && atts['title_wrap'] == 'yes' )
{
	if( atts['before'] !== undefined && atts['before'] !== '' )
		output = or.tools.base64.decode( atts['before'])+output;
	if( atts['after'] !== undefined && atts['after'] !== '' )
		output += or.tools.base64.decode( atts['after']);
		
	if( atts['title_wrap_class'] !== undefined && atts['title_wrap_class'] !== '' )
		wrp_class.push( atts['title_wrap_class'] );
	
	if( atts['align'] !== undefined && atts['align'] !== '' )
		wrp_class.push( 'align-'+atts['align'] );
		
	output = '<div class="'+wrp_class.join(' ')+'">'+output+'</div>';
}

#>

{{{output}}}