<#

if( data === undefined )
	data = {};

var atts = ( data.atts !== undefined ) ? data.atts : {},
	custom_class = 'flipbox_'+parseInt(Math.random()*100000),
	text_align = 'center',
	image_size = 'full',
	back_data = '',
	link = '#',
	image_data = '<?php echo or_URL.'/assets/images/get_logo.png'; ?>',
	element_atttribute = [],
	el_classess = [ 'or-flipbox', 'or-flip-container', custom_class ];

if( atts['wrap_class'] !== undefined && atts['wrap_class'] !== '' )
	el_classess.push( atts['wrap_class'] );

if( atts['css'] !== undefined && atts['css'] !== '' )
	el_classess.push( atts['css'].split('|')[0] );

if( atts['direction'] !== undefined && atts['direction'] == 'vertical' )
	el_classess.push( 'flip-vertical' );

if( atts['link'] !== undefined && atts['link'] !== '' )
	link = atts['link'];

if( atts['text_align'] !== undefined && atts['text_align'] !== '' )
	text_align = atts['text_align'];

element_atttribute.push( 'class="'+el_classess.join(' ')+'"' );
element_atttribute.push( 'ontouchstart="this.classList.toggle(\'hover\');"' );

if( atts['image_size'] !== undefined && atts['image_size'] !== '' )
	image_size = atts['image_size'];

if( atts['image'] !== undefined && atts['image'] !== '' )
	image_data = '<?php echo admin_url('/admin-ajax.php?action=or_get_thumbn&id='); ?>'+atts['image']+'&size='+image_size;

if( atts['title'] !== undefined && atts['title'] !== '' )
	back_data += '<h3>'+atts['title']+'</h3>';

if( atts['description'] !== undefined && atts['description'] !== '' )
	back_data += '<p>'+or.tools.base64.decode( atts['description'] )+'</p>';

if( atts['show_button'] !== undefined && atts['show_button'] == 'yes' ){
	
	text_on_button = '<?php _e('Read more', 'originbuilder'); ?>';
	if( atts['text_on_button'] !== undefined && atts['text_on_button'] !== '' )
		text_on_button = atts['text_on_button'];
		
	back_data += '<a class="button" href="'+link+'">'+atts['text_on_button']+'</a>';
}

#>
<div {{{element_atttribute.join(' ')}}}>
	<div class="flipper">
		<div class="front">
			<img src="{{image_data}}" />
		</div>
		<div class="back">
			<div class="des" style="text-align:{{text_align}}">
				{{{back_data}}}
			</div>
		</div>
	</div>
	<style type="text/css">
	<#
		var bg_backside = or.std( atts, 'bg_backside', '#86c724' ),
			text_color = or.std( atts, 'text_color', '#FFFFFF'),
			button_bg_color = or.std( atts, 'button_bg_color', 'transparent'),
			text_button_color = or.std( atts, 'text_button_color', '#FFFFFF'),
			button_bg_hover_color = or.std( atts, 'button_bg_hover_color', '#FFFFFF'),
			text_button_color_hover = or.std( atts, 'text_button_color_hover', '#86c724');
	#>
	.{{custom_class}} .back{ background-color: {{bg_backside}};color: {{text_color}};text-align: {{text_align}};}
	.{{custom_class}} .back *{ color: {{text_color}};text-align: {{text_align}};}
	<#	
		if('transparent' == button_bg_color){
	#>
	.{{custom_class}} .des a.button{ background-color: {{button_bg_color}};color : {{text_button_color}};border : 2px solid {{text_button_color}}; }
	<#	
		}else{
	#>
		.{{custom_class}} .des a.button{ background-color: {{button_bg_color}}; color : {{text_button_color}}; border : 2px solid {{button_bg_color}};
		}
	<# } #>
		.{{custom_class}} .des a.button:hover{ background-color: {{button_bg_hover_color}}; color : {{text_button_color_hover}}; border : 2px solid {{button_bg_hover_color}}; }
		.{{custom_class}} .des a.button:hover *{ color : {{text_button_color_hover}}; }
	</style>
</div>