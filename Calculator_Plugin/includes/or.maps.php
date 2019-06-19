<?php
/**
*
*	Origin Builder
*	(c) originbuilder.com
*
*/
if(!defined('or_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$or = originbuilder::globe();
$live_tmpl = or_PATH.KDS.'shortcodes'.KDS.'live_editor'.KDS;

$animate_arr = array(
	'Attention Seekers' => array(
		'bounce' => 'bounce',
		'flash' => 'flash',
		'pulse' => 'pulse',
		'rubberBand' => 'rubberBand',
		'shake' => 'shake',
		'swing' => 'swing',
		'tada' => 'tada',
		'wobble' => 'wobble',
	),
	'Bouncing Entrances' => array(
		'bounceIn' => 'bounceIn',
		'bounceInDown' => 'bounceInDown',
		'bounceInLeft' => 'bounceInLeft',
		'bounceInRight' => 'bounceInRight',
		'bounceInUp' => 'bounceInUp',
	),
	/*'Bouncing Exits' => array(
		'bounceOut' => 'bounceOut',
		'bounceOutDown' => 'bounceOutDown',
		'bounceOutLeft' => 'bounceOutLeft',
		'bounceOutRight' => 'bounceOutRight',
		'bounceOutUp' =>'bounceOutUp',
	),*/
	'Fading Entrances' => array(
		'fadeIn' => 'fadeIn',
		'fadeInDown' => 'fadeInDown',
		'fadeInDownBig' => 'fadeInDownBig',
		'fadeInLeft' => 'fadeInLeft',
		'fadeInLeftBig' => 'fadeInLeftBig',
		'fadeInRight' => 'fadeInRight',
		'fadeInRightBig' => 'fadeInRightBig',
		'fadeInUp' => 'fadeInUp',
		'fadeInUpBig' => 'fadeInUpBig',
	),
	/*'Fading Exits' => array(
		'fadeOut' => 'fadeOut',
		'fadeOutDown' => 'fadeOutDown',
		'fadeOutDownBig' => 'fadeOutDownBig',
		'fadeOutLeft' => 'fadeOutLeft',
		'fadeOutLeftBig' => 'fadeOutLeftBig',
		'fadeOutRight' => 'fadeOutRight',
		'fadeOutRightBig' => 'fadeOutRightBig',
		'fadeOutUp' => 'fadeOutUp',
		'fadeOutUpBig' => 'fadeOutUpBig',
	),*/
	'Flippers' => array(
		'flip' => 'flip',
		'flipInX' => 'flipInX',
		'flipInY' => 'flipInY',
		/*'flipOutX' => 'flipOutX',
		'flipOutY' => 'flipOutY',*/
	),
	'Lightspeed' => array(
		'lightSpeedIn' => 'lightSpeedIn',
		'lightSpeedOut' => 'lightSpeedOut',
	),
	'Rotating Entrances' => array(
		'rotateIn' => 'rotateIn',
		'rotateInDownLeft' => 'rotateInDownLeft',
		'rotateInDownRight' => 'rotateInDownRight',
		'rotateInUpLeft' => 'rotateInUpLeft',
		'rotateInUpRight' => 'rotateInUpRight',
	),
	/*'Rotating Exits' => array(
		'rotateOut' => 'rotateOut',
		'rotateOutDownLeft' => 'rotateOutDownLeft',
		'rotateOutDownRight' => 'rotateOutDownRight',
		'rotateOutUpLeft' => 'rotateOutUpLeft',
		'rotateOutUpRight' => 'rotateOutUpRight',
	),*/
	'Sliders' => array(
		'slideInDown' => 'slideInDown',
		'slideInLeft' => 'slideInLeft',
		'slideInRight' => 'slideInRight',
		/*'slideOutLeft' => 'slideOutLeft',
		'slideOutRight' => 'slideOutRight',
		'slideOutUp' => 'slideOutUp',*/
	),
	/*'Cute' => array(
		'hinge' => 'hinge',
		'rollIn' => 'rollIn',
		'rollOut' => 'rollOut',
	)*/
);

$slideranimate = array(
	'Fade',	
	'Fade in L',	
	'Fade in R',	
	'Fade in B',	
	'Zoom+ in',	
	'Zoom- in L',	
	'Zoom+ in R',	
	'Zoom+ in T',	
	'Zoom- in T',	
	'Zoom+ in B',	
	'Zoom- in B',		
	'Fade Twins',	
	'Switch',	
	'Shift TB',	
	'Shift LR',	
	'Extrude replace',	
	'Rotate relay',	
	'Rotate overlap'
);

$responsive = array(

	array(
		'name' => 'responsive',
		'label' => __( 'Responsive Options', 'originbuilder' ).
				   '<button onclick="or.views.column.apply_all(this,\'responsive\')" class="float-right button button-primary" style="margin: -5px 0 20px -10px;">'.__( 'Apply for all same level columns', 'originbuilder' ).'</button>',
		'type' => 'group',
		'params' => array(
			array(
				'name' => 'screen',
				'label' => __( 'Screen width', 'originbuilder' ),
				'type' => 'select',
				'options' => array(
					'(max-width: 479px)' => 'Max 479px (smartphone)',
					'(min-width: 480px) and (max-width: 639px)' => '480px to 639px (phablet)',
					'(min-width: 640px) and (max-width: 767px)' => '640px to 767px (tablet mini)',
					'(min-width: 768px) and (max-width: 999px)' => '768px to 999px (tablet)',
					'(min-width: 1000px) and (max-width: 1169px)' => '1000px to 1169px (13 inch)',
					'(min-width: 1170px)' => 'Min 1170px (desktop)',
					'custom' => 'Custom',
				),
				'description' => __( 'Select screen size', 'originbuilder' ),
			),
			array(
				'name' => 'range',
				'label' => 'Custom Screen',
				'type' => 'number_slider',
				'value' => '768|999',
				'options' => array(
					'min' => 240,
					'max' => 1920,
					'unit' => 'px',
					'range' => true
				),
				'admin_label' => true,
				'description' => __('Set Min width and Max width of screen', 'originbuilder'),
				'relation' => array(
					'parent' => 'responsive-screen',
					'show_when' => array('custom')
				),
			),
			array(
				'name' => 'offset',
				'label' => __( 'Offset', 'originbuilder' ),
				'type' => 'select',
				'options' => array(
					'0' => 'Inherit',
					'1' => '1 column 1/12',
					'2' => '2 columns 2/12',
					'3' => '3 columns 3/12',
					'4' => '4 columns 4/12',
					'5' => '5 columns 5/12',
					'6' => '6 columns 6/12',
					'7' => '7 columns 7/12',
					'8' => '8 columns 8/12',
					'9' => '9 columns 9/12',
					'10' => '10 columns 10/12'
				),
				'description' => __( 'Move columns to the right by increase the left margin', 'originbuilder' )
			),
			array(
				'name' => 'columns',
				'label' => __( 'Width', 'originbuilder' ),
				'type' => 'select',
				'options' => array(
					'0' => 'Inherit',
					'1' => '1 column 1/12',
					'2' => '2 columns 2/12',
					'3' => '3 columns 3/12',
					'4' => '4 columns 4/12',
					'5' => '5 columns 5/12',
					'6' => '6 columns 6/12',
					'7' => '7 columns 7/12',
					'8' => '8 columns 8/12',
					'9' => '9 columns 9/12',
					'10' => '10 columns 10/12',
					'11' => '11 columns 11/12',
					'12' => '12 columns 12/12'
				),
				'description' => __( 'width of column in this screen size', 'originbuilder' )
			),
			array(
				'name' => 'important',
				//'label' => __( 'Important', 'originbuilder' ),
				'type' => 'checkbox',
				'options' => array(
					'yes' =>  __( 'Important', 'originbuilder' ),
				),
				'description' => __( 'Make this option as important and have a higher priority than other places', 'originbuilder' )
			),
			array(
				'name' => 'display',
				//'label' => __( 'Hide Column', 'originbuilder' ),
				'type' => 'checkbox',
				'options' => array(
					'hide' =>  __( 'Hide Column', 'originbuilder' ),
				),
				'description' => __( 'Hide this column in this screen size', 'originbuilder' )
			),
		),
		'description' => __( 'Adjust column for different screen sizes.', 'originbuilder' )
	)

);

$res_data = get_option('or_subscriber_settings');
$responder = array();
if(!empty($res_data)){
	foreach($res_data as $k=>$v){
		if(!empty($v)) $responder[$k] = $k;
	}
}

$animate = array(
	array(
		'name' => 'animateswitch',
		'label' => __( 'Animate Element', 'originbuilder' ),
		'type' => 'animate_radio',
		'options' => array(
			'yes' => 'ON',
			'no' => 'OFF'
		),
		'value' => 'no',
		'description' => __( '', 'originbuilder' )
	),
	array(
		'name' => 'animateevent',
		'label' => __( 'Event', 'originbuilder' ),
		'type' => 'select',
		'options' => array(
			'onload' => 'On-view',
			'onclick' => 'On-click',
			'onhover' => 'On-hover',
		),
		'value' => 'onhover',
		'description' => __( '', 'originbuilder' )
	),
	array(
		'name' => 'animateeffect',
		'label' => __( 'Effect', 'originbuilder' ),
		'type' => 'animate_preview',
		'options' => $animate_arr,
		'description' => __( '', 'originbuilder' )
	),
);

$or->add_map(

	array(

		'_value' => array(
			'name' => 'or Element',
			'description' => 'or Element',
			'icon' => 'sl-info',	   /* Class name of icon show on "Add Elements" */
			'category' => '',	  /* Category to group elements when "Add Elements" */
			'is_container' => false, /* Container has begin + end [name]...[/name] -  Single has only [name param=""] */
			'pop_width' => 580,		/* width of the popup will be open when clicking on the edit  */
			'system_only' => true, /* Use for system only and dont show up to Add Elements */
			'params' => array()
		),

		'or_undefined' => array(
			'name' => 'Undefined Element',
			'icon' => 'sl-flag',
			'category' => '',
			'is_container' => true,
			'pop_width' => 440,
			'system_only' => true,
			'params' => array(
				array(
					'name' => 'content',
					'label' => 'Content',
					'type' => 'textarea_html',
					'value' => 'Sample Text',
					'admin_label' => true,
				)
			)
		),

		'or_wp_widget' => array(
			'name' => 'Wordpress Widget',
			'icon' => 'or-icon-wordpress',
			'category' => '',
			'pop_width' => 450,
			'system_only' => true,
			'params' => array(
				array(
					'name' => 'data',
					'label' => 'Data',
					'type' => 'wp_widget',
					'admin_label' => true,
				)
			)
		),

		'or_css_box' => array(

			'name' => 'CSS Box',
			'system_only' => true,
			'params' => array(

				array(
					'name' => 'margin',
					'label' => 'Margin',
					'type' => 'css_box_tbtl'
				),
				array(
					'name' => 'padding',
					'label' => 'Padding',
					'type' => 'css_box_tbtl',
				),
				array(
					'name' => 'border',
					'label' => 'Border',
					'type' => 'css_box_border',
				),
				array(
					'name' => 'color',
					'label' => 'Text Color',
					'type' => 'color_picker',
					'description' => 'Color of the text.'
				),
				
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Font style', 'originbuilder' ),
					'name'			=> 'font-family',
					'options'		=> array(
						'' => __( 'Select', 'originbuilder' ),
						 
						'AllertaStencil' => __( 'AllertaStencil', 'originbuilder' ),
						 
						'Anton' => __( 'Anton', 'originbuilder' ),
						'Anke' => __( 'Anke', 'originbuilder' ),
						'ArchitectsDaughter' => __( 'ArchitectsDaughter', 'originbuilder' ),
						'Arvo' => __( 'Arvo', 'originbuilder' ),
					 
						'Caliban' => __( 'Caliban', 'originbuilder' ),
						 
						'book antiqua,palatino,serif' => __( 'Book Antiqua', 'originbuilder' ),
						'comic sans ms,sans-serif' => __( 'Comic Sans MS', 'originbuilder' ),
						'DroidSans' => __( 'DroidSans', 'originbuilder' ),
						'DroidSerif' => __( 'DroidSerif', 'originbuilder' ),
						'bcourier new,courier,monospace' => __( 'Courier New', 'originbuilder' ),
						'georgia,palatino,serif' => __( 'Georgia', 'originbuilder' ),
						'impact,sans-serif' => __( 'Impact', 'originbuilder' ),
						'Lato' => __( 'Lato', 'originbuilder' ),
						'Limelight' => __( 'Limelight', 'originbuilder' ),
						'Lora' => __( 'Lora', 'originbuilder' ),
						'Monda' => __( 'Monda', 'originbuilder' ),
						'Montez' => __( 'Montez', 'originbuilder' ),
						'Montserrat' => __( 'Montserrat', 'originbuilder' ),
						'NotoSans' => __( 'NotoSans', 'originbuilder' ),
						 
						'Open Sans' => __( 'Open Sans', 'originbuilder' ),
						'Orbitron' => __( 'Orbitron', 'originbuilder' ),
						'Oswald' => __( 'Oswlad', 'originbuilder' ),
						'PT Sans Caption Web' => __( 'PT Sans Caption Web', 'originbuilder' ),
						'Raleway' => __( 'Raleway', 'originbuilder' ),
						'Rancho' => __( 'Rancho', 'originbuilder' ),
						'Righteous' => __( 'Righteous', 'originbuilder' ),
						'ShadowsIntoLight' => __( 'ShadowsIntoLight', 'originbuilder' ),
						'Slabo 27px' => __( 'Slabo', 'originbuilder' ),
						'SourceSansPro' => __( 'SourceSansPro', 'originbuilder' ),
						 
						'tahoma,arial,helvetica,sans-serif' => __( 'Tahoma', 'originbuilder' ),
						'terminal,monaco,monospace' => __( 'Terminal', 'originbuilder' ),
						'times new roman,times,serif' => __( 'Times New Roman', 'originbuilder' ),
						'trebuchet ms,geneva,sans-serif' => __( 'Trebuchet MS', 'originbuilder' ),
						'TitilliumWeb' => __( 'TitilliumWeb', 'originbuilder' ),
						 
						'Ubuntu' => __( 'Ubuntu', 'originbuilder' ),
						'verdana,geneva,sans-serif' => __( 'Verdana', 'originbuilder' ),
						 
						 
					),
					'description'	=> __( 'Set font style', 'originbuilder' ),
				),
				array(
					'name' => 'background-color',
					'label' => 'Background Color',
					'type' => 'color_picker',
					'description' => 'Background color of the element.'
				),
				array(
					'name' => 'background-image-option',
					//'label' => 'Background Image',
					'type' => 'checkbox',
					'description' => 'Use a background image instead of a plain color.',
					'options' => array( 'yes' => 'Background Image' )
				),
				array(
					'name' => 'background-image',
					'label' => 'Upload Image',
					'type' => 'attach_image_url',
					'value' =>  or_URL.'/assets/images/get_logo.png',
					'relation' => array(
						'parent' => 'background-image-option',
						'show_when' => 'yes'
					)
				),
				array(
					'name' => 'background-repeat',
					'label' => 'BG Repeat',
					'type' => 'select',
					'options' => array(
						'' => 'Yes',
						'no-repeat' => 'No Repeat',
						'repeat-x' => 'Repeat Horizontal',
						'repeat-y' => 'Repeat Vertical'
					),
					'relation' => array(
						'parent' => 'background-image-option',
						'show_when' => 'yes'
					)
				),
				array(
					'name' => 'background-position',
					'label' => 'BG Position',
					'type' => 'select',
					'options' => array(
						'center center' => 'center center',
						'0px 0px' => '0px 0px',
						'50% 50%' => '50% 50%'
					),
					'relation' => array(
						'parent' => 'background-image-option',
						'show_when' => 'yes'
					)
				),
				array(
					'name' => 'background-attachment',
					'label' => 'BG Attachment',
					//'type' => 'text',
					//'description' => 'scroll | fixed | local | initial | inherit',
					'type' => 'select',
					'options' => array(
						'scroll' => 'scroll',
						'fixed' => 'fixed',
						'local' => 'local',
						'initial' => 'initial',
						'inherit' => 'inherit'
					),
					'relation' => array(
						'parent' => 'background-image-option',
						'show_when' => 'yes'
					)
				),
				array(
					'name' => 'background-size',
					'label' => 'BG Size',
					//'type' => 'text',
					//'description' => 'auto | length | cover | contain | initial | inherit',
					'type' => 'select',
					'options' => array(
						'auto' => 'auto',
						'length' => 'length',
						'cover' => 'cover',
						'contain' => 'contain',
						'initial' => 'initial',
						'inherit' => 'inherit',
					),
					'relation' => array(
						'parent' => 'background-image-option',
						'show_when' => 'yes'
					)
				),
				array(
					'name' => 'text-align',
					'label' => 'Text Align',
					'type' => 'select',
					'options' => array(
						'' => 'Default',
						'center' => 'Center',
						'left' => 'Left',
						'right' => 'Right',
						'justify' => 'Justify',
						'start' => 'Start',
						'inherit' => 'Inherit',
						'initial' => 'Initial',
					),
				),
				array(
					'name' => 'float',
					'label' => 'Float',
					'type' => 'select',
					'options' => array(
						'' => 'Default',
						'left' => 'Left',
						'right' => 'Right',
						'none' => 'None',
					),
				),
				array(
					'name' => 'display',
					'label' => 'Display',
					'type' => 'select',
					'options' => array(
						'' => 'Default',
						'block' => 'Block',
						'inline-block' => 'Inline Block',
						'none' => 'None',
					),
				),
				
			)

		),

		'or_row' => array(
			'name' => 'Row',
			'description' => __( 'Place content elements inside the row', 'originbuilder' ),
			'category' => '',
			'title' => 'Row Settings',
			'is_container' => true,
			'css_box' => true,
			'system_only' => true,
			'live_editor' => $live_tmpl.'or_row.php',
			'params' => array(
			
				/*array(
					'name' => 'row_id',
					'label' => 'Row ID',
					'type' => 'text',
					'description' => __('The unique identifier of the row.', 'originbuilder'),
				),*/
				array(
					'name' => 'full_width_option',
					//'label' => 'Full width?',
					'type' => 'checkbox',
					'description' => __('Set the 100% width of the row and content.', 'originbuilder'),
					'options' => array(
		 			 
						'yes' => 'Full width'
					),
				),
				array(
					'name' => 'full_width',
					'label' => 'Stretch Option',
					'type' => 'radio',
					'value' => 'stretch_row',
					'description' => __('Please select stretch options.', 'originbuilder'),
					'options' => array(
						'stretch_row' => 'Only Row',
						'stretch_row_content' => 'Row & Content'
					),
					'relation' => array(
						'parent' => 'full_width_option',
						'show_when' => 'yes'
					),
				),
				array(
					'name' => 'full_height',
					//'label' => __( 'Full height?', 'originbuilder' ),
					'type' => 'checkbox',
					'description' => __( 'Set the 100% height of the row.', 'originbuilder' ),
					'options' => array(
						'yes' => __( 'Full height', 'originbuilder' )
					)
				),
				array(
					'name' => 'equal_height',
					//'label' => __( 'Equal height?', 'originbuilder' ),
					'type' => 'checkbox',
					'description' => __( 'If checked, all columns will be set to equal height(not of row inner).', 'originbuilder' ),
					'options' => array(
						'yes' => __( 'Equal height', 'originbuilder' )
					)
				),
				array(
					'name' => 'content_placement',
					'label' => __( 'Content position', 'originbuilder' ),
					'type' => 'select',
					'options' => array(
						'middle' => __( 'Middle', 'originbuilder' ),
						'top' => __( 'Top', 'originbuilder' ),
					),
					'description' => __( 'Select content position within row when full-height.', 'originbuilder' ),
					'relation' => array(
						'parent' => 'full_height',
						'show_when' => 'yes'
					),
				),
				array(
					'name' => 'video_bg',
					//'label' => __( 'Use video background?', 'originbuilder' ),
					'type' => 'checkbox',
					'description' => __( 'Add a Background video to this row.', 'originbuilder' ),
					'options' => array( 'yes' => __( 'Video background', 'originbuilder' ) )
				),
				array(
					'name' => 'video_bg_url',
					'label' => __( 'YouTube link', 'originbuilder' ),
					'type' => 'text',
					'value' => 'https://www.youtube.com/watch?v=dOWFVKb2JqM',
					'description' => __( 'Add YouTube link.', 'originbuilder' ),
					'relation' => array(
						'parent' => 'video_bg',
						'show_when' => 'yes'
					),
				),
				array(
					'name' => 'parallax',
					'label' => __( 'Parallax', 'originbuilder' ),
					'type' => 'select',
					'options' => array(
						'' => __( 'None', 'originbuilder' ),
						'yes' => __( 'Use Background Image', 'originbuilder' ),
						'yes-new' => __( 'Upload New Image', 'originbuilder' ),
					),
					'description' => __( 'Add a parallax scrolling to the row.', 'originbuilder' ),
					'relation' => array(
						'parent' => 'video_bg',
						'hide_when' => 'yes',
					),
				),
				array(
					'name' => 'parallax_image',
					'label' => __( 'Image', 'originbuilder' ),
					'type' => 'attach_images',
					'value' => '',
					'description' => __( 'Select image from media library.', 'originbuilder' ),
					'relation' => array(
						'parent' => 'parallax',
						'show_when' => 'yes-new',
					),
				),
				array(
					'name' => 'parallax_speed',
					'label' => __( 'Parallax Speed', 'originbuilder' ),
					'type' => 'select',
					'description' => __( 'Set speed of parallax when scroll.', 'originbuilder' ),
					'options' => array(
						'1' => '1',
						'0.7' => '0.7',
						'0.4' => '0.4',
						'0.1' => '0.1',
					),
					'value' => '1',
					'relation' => array(
						'parent' => 'parallax',
						'show_when' => 'yes,yes-new',
					),
				),
				array(
					'name' => 'parallax_background_size',
					//'label' => __( 'Full background?', 'originbuilder' ),
					'type' => 'checkbox',
					'description' => __( 'Make background size full width & height and prevent repeat', 'originbuilder' ),
					'options' => array(
						'yes' => __( 'Full background', 'originbuilder' ),
					),
					'value' => 'yes',
					'relation' => array(
						'parent' => 'parallax',
						'show_when' => 'yes,yes-new',
					),
				),
				/*array(
					'name' => 'use_container',
					//'label' => __( 'Row container', 'originbuilder' ),
					'type' => 'checkbox',
					'options' => array(
						'yes' => __( 'Row container', 'originbuilder' ),
					),
					'description' => __( 'Enable container for this row.', 'originbuilder' )
				),
				array(
					'name' => 'container_class',
					'label' => __( 'Container extra classes name', 'originbuilder' ),
					'type' => 'text',
					'description' => __( 'Add classes custom to the Container.', 'originbuilder' ),
					'relation' => array(
						'parent' => 'use_container',
						'show_when' => 'yes',
					),
				),
				array(
					'name' => 'row_class',
					'label' => __( 'Row extra classes name', 'originbuilder' ),
					'type' => 'text',
					'description' => __( 'Add additional custom classes to the Row.', 'originbuilder' ),
				)*/
			)
		),


		'or_row_inner' => array(
			'name' => 'Inner row',
			'description' => 'Inner nested rows',
			'icon' => 'or-icon-row',
			'category' => '',
			'title' => 'Row Inner Settings',
			'is_container' => true,
			'css_box' => true,
			'live_editor' => $live_tmpl.'or_row_inner.php',
			'params' => array(
				/*array(
					'name' => 'row_id',
					'label' => 'Row ID',
					'type' => 'text',
					'value' => __('', 'originbuilder'),
					'description' => 'The unique identifier of the row'
				),*/
				array(
					'name' => 'equal_height',
					//'label' => __( 'Equal height?', 'originbuilder' ),
					'type' => 'checkbox',
					'description' => __( 'If checked, all columns will be set to equal height.', 'originbuilder' ),
					'options' => array(
						'yes' => __( 'Equal height', 'originbuilder' )
					)
				),
				/*array(
					'name' => 'row_class',
					'label' => __( 'Extra classes name', 'originbuilder' ),
					'type' => 'text',
					'description' => __( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS.', 'originbuilder' ),
				),
				array(
					'name' => 'row_class_container',
					'label' => __( 'Extra container classes', 'originbuilder' ),
					'type' => 'text',
					'description' => __( 'Add additional classes name to the container in a row.', 'originbuilder' ),
				),*/
			)
		),

		'or_column' => array(
			'name' => 'Column',
			'category' => '',
			'title' => 'Column Settings',
			'is_container' => true,
			'system_only' => true,
			'css_box' => true,
			'tab_icons' => array(
				'general' => 'et-tools',
				'responsive' => 'et-mobile'
			),
			'live_editor' => $live_tmpl.'or_column.php',
			'params' => array(
				'responsive' => $responsive,
			)
		),

		'or_column_inner' => array(
			'name' => 'Column Inner',
			'category' => '',
			'title' => 'Column Inner Settings',
			'is_container' => true,
			'system_only' => true,
			'css_box' => true,
			'tab_icons' => array(
				'general' => 'et-tools',
				'responsive' => 'et-mobile'
			),
			'live_editor' => $live_tmpl.'or_column_inner.php',
			'params' => array(
				/*'general' => array(

					array(
						'name' => 'col_in_class',
						'label' => __( 'Extra class name', 'originbuilder' ),
						'type' => 'text',
						'description' => __( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'originbuilder' )
					),
					array(
						'name' => 'col_in_class_container',
						'label' => __( 'Extra container Class', 'originbuilder' ),
						'type' => 'text',
						'description' => __( 'Add class name for container into column.', 'originbuilder' ),
					),
				),*/
				'responsive' => $responsive
			)
		),

		 /*'or_box' => array(
			'name' => 'or Box',
			'category' => '',
			'title' => 'or Box Design',
			'icon' => 'or-icon-box',
			'pop_width' => 900,
			'description' => __( 'Helping design static block', 'originbuilder' ),
			'live_editor' => $live_tmpl.'or_box.php',
			'params' => array(
				array(
					'name' => 'css_code',
					'type' => 'hidden',
				),
				array(
					'name' => 'data',
					'type' => 'or_box',
					'admin_label' => true,
					'value' => 'W3sidGFnIjoiZGl2IiwiY2hpbGRyZW4iOlt7InRhZyI6InRleHQiLCJjb250ZW50IjoiU2FtcGxlIFRleHQuIn1dfV0='
					/*This is special element, All will be built in template 
				),
			)
		),*/

		'or_tabs' => array(
			'name' => 'Tabs',
			'description' => __( 'Tabbed content section', 'originbuilder' ),
			'category' => '',
			'icon' => 'or-icon-tabs',
			'title' => 'Tabs - Sliders Settings',
			'is_container' => true,
			'views' => array(
				'type' => 'views_sections',
				'sections' => 'or_tab'
			),
			'live_editor' => $live_tmpl.'or_tabs.php',
			'params' => array(
				/*array(
					'name' => 'class',
					'label' => 'Extra Class',
					'type' => 'text'
				),*/
				array(
					'name' => 'type',
					'label' => __('Layout style', 'originbuilder'),
					'type' => 'select',
					'options' => array(
						'horizontal_tabs' => __('Horizontal Tabs', 'originbuilder'),
						'vertical_tabs' => __('Vertical Tabs', 'originbuilder'),
						'slider_tabs' => __('Owl Sliders', 'originbuilder')
					),
					'description' => __('Set the design layout style of the tab.', 'originbuilder')
				),
				array(
					'name' => 'title_slider',
					//'label' => 'Display Titles?',
					'type' => 'checkbox',
					'options' => array(
						'yes' => __('Display Titles', 'originbuilder')
					),
					'relation' => array(
						'parent' => 'type',
						'show_when' => 'slider_tabs'
					),
					'description' => __('Display tabs title above of the slider', 'originbuilder')
				),
				array(
					'name' => 'items',
					'label' => 'Number Items?',
					'type' => 'select',
					'options' => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					),
					'relation' => array(
						'parent' => 'type',
						'show_when' => 'slider_tabs'
					),
					'description' => __('Display number of items per each slide (Desktop Screen)', 'originbuilder')
				),
				array(
					'name' => 'tablet',
					'label' => 'Items on tablet?',
					'type' => 'select',
					'options' => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					),
					'relation' => array(
						'parent' => 'type',
						'show_when' => 'slider_tabs'
					),
					'description' => __('Display number of items per each slide (Tablet Screen)', 'originbuilder')
				),
				array(
					'name' => 'mobile',
					'label' => 'Items on smartphone?',
					'type' => 'select',
					'options' => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
					),
					'relation' => array(
						'parent' => 'type',
						'show_when' => 'slider_tabs'
					),
					'description' => __('Display number of items per each slide (Smartphone Screen)', 'originbuilder')
				),
				array(
					'name' => 'speed',
					'label' => 'Speed of slider',
					'type' => 'number_slider',
					'options' => array(
						'min' => 100,
						'max' => 1000,
						'show_input' => true
					),
					'value' => 450,
					'relation' => array(
						'parent' => 'type',
						'show_when' => 'slider_tabs'
					),
					'description' => __('The speed of sliders in millisecond', 'originbuilder')
				),
				array(
					'name' => 'navigation',
					//'label' => 'Navigation',
					'type' => 'checkbox',
					'options' => array(
						'yes' => __('Navigation', 'originbuilder')
					),
					'relation' => array(
						'parent' => 'type',
						'show_when' => 'slider_tabs'
					),
					'description' => __('Display the "Next" and "Prev" buttons.', 'originbuilder')
				),
				array(
					'name' => 'pagination',
					//'label' => 'Pagination',
					'type' => 'checkbox',
					'options' => array(
						'yes' => __('Pagination', 'originbuilder')
					),
					'relation' => array(
						'parent' => 'type',
						'show_when' => 'slider_tabs'
					),
					'value' => 'yes',
					'description' => __('Show the pagination.', 'originbuilder')
				),
				array(
					'name' => 'autoplay',
					//'label' => 'Auto Play',
					'type' => 'checkbox',
					'options' => array(
						'yes' => __('Auto Play', 'originbuilder')
					),
					'relation' => array(
						'parent' => 'type',
						'show_when' => 'slider_tabs'
					),
					'description' => __('The slider automatically plays when site loaded', 'originbuilder')
				),
				array(
					'name' => 'autoheight',
					//'label' => 'Auto Height',
					'type' => 'checkbox',
					'options' => array(
						'yes' => __('Auto Height', 'originbuilder')
					),
					'relation' => array(
						'parent' => 'type',
						'show_when' => 'slider_tabs'
					),
					'description' => __('The slider height will change automatically', 'originbuilder')
				),
				array(
					'name' => 'effect_option',
					//'label' => 'Enable fadein effect?',
					'type' => 'checkbox',
					'options' => array(
						'yes' => __('Fadein effect', 'originbuilder')
					),
					'relation' => array(
						'parent' => 'type',
						'hide_when' => 'slider_tabs'
					),
					'description' => __('Apply Fade in and out effects when tabs are clicked.', 'originbuilder')
				),
				array(
					'name' => 'vertical_tabs_position',
					'label' => __('Position', 'originbuilder'),
					'type' => 'select',
					'options' => array(
						'left' => __('Left', 'originbuilder'),
						'right' => __('Right', 'originbuilder')
					),
					'relation' => array(
						'parent' => 'type',
						'show_when' => array('vertical_tabs')
					),
					'description' => __('View tabs with at top or bottom', 'originbuilder')
				),
				array(
					'name' => 'open_mouseover',
					//'label' => __('Open on mouseover', 'originbuilder'),
					'type' => 'checkbox',
					'options' => array(
						'yes' => __( 'Show tab content on mouse over', 'originbuilder' )
					),
					'relation' => array(
						'parent' => 'type',
						'hide_when' => 'slider_tabs'
					),
				),
				array(
					'name' => 'active_section',
					'label' => __('Default active section', 'originbuilder'),
					'type' => 'text',
					'value' => '1',
					'relation' => array(
						'parent' => 'type',
						'hide_when' => 'slider_tabs'
					),
					'description' => __('Set default active tab section number.', 'originbuilder')
				)
			),
			'content' => '[or_tab title="New Tab"][/or_tab]'
		),

		'or_tab' => array(
			'name' => 'Tab',
			'category' => '',
			'title' => 'Tab Settings',
			'is_container' => true,
			'system_only' => true,
			'live_editor' => $live_tmpl.'or_tab.php',
			'params' => array(
				array(
					'name' => 'title',
					'label' => 'Title',
					'type' => 'text',
					'value' => __('New Tab', 'originbuilder'),
				),
				array(
					'name' => 'advanced',
					//'label' => 'Advance Title?',
					'type' => 'checkbox',
					'options' => array(
						'yes' => __('Advance Title', 'originbuilder')
					),
					'description' => __('If you want more flexible options to display tab title', 'originbuilder')
				),
				
				array(
					'name' => 'adv_title',
					'label' => 'Title Format',
					'type' => 'textarea',
					'value' => base64_encode( __('<p>New Tab<p>', 'originbuilder') ),
					'relation' => array(
						'parent' => 'advanced',
						'show_when' => 'yes'
					),
					'description' => __('You can use short varibles {title}, {icon} , {icon_class}, {image}, {image_id}, {image_url}, {image_thumbnail}, {image_medium}, {image_large}, {image_full}, {tab_id}', 'originbuilder')
				),
				array(
					'name' => 'adv_icon',
					'label' => 'Icon Title',
					'type' => 'icon_picker',
					'value' => '',
					'relation' => array(
						'parent' => 'advanced',
						'show_when' => 'yes'
					)
				),
				array(
					'name' => 'adv_image',
					'label' => 'Image Title',
					'type' => 'attach_image',
					'value' => '',
					'relation' => array(
						'parent' => 'advanced',
						'show_when' => 'yes'
					)
				),
				array(
					'name' => 'icon_option',
					//'label' => 'Use Icon?',
					'type' => 'checkbox',
					'options' => array(
						'yes' => __('Use Icon', 'originbuilder')
					),
					'description' => __('If you want to display an icon beside title, Tick to choose an icon', 'originbuilder'),
					'relation' => array(
						'parent' => 'advanced',
						'hide_when' => 'yes'
					)
				),
				array(
					'name' => 'icon',
					'label' => 'Icon Title',
					'type' => 'icon_picker',
					'value' => '',
					'description' => __('Choose an icon to display with title', 'originbuilder'),
					'relation' => array(
						'parent' => 'icon_option',
						'show_when' => 'yes'
					)
				),
				/*array(
					'name' => 'class',
					'label' => 'Extra Class',
					'type' => 'text'
				)*/
			)
		),

		'or_accordion' => array(
			'name' => 'Accordion',
			'description' => __( 'Expandable content section', 'originbuilder' ),
			'category' => '',
			'icon' => 'or-icon-accordion',
			'title' => 'Accordion Settings',
			'is_container' => true,
			'views' => array(
				'type' => 'views_sections',
				'sections' => 'or_accordion_tab',
				'display' => 'vertical'
			),
			'live_editor' => $live_tmpl.'or_accordion.php',
			'params' => array(
				array(
					'name' => 'title',
					'label' => 'Title',
					'type' => 'text',
					'description' => __('nter accordion title. The title appears on top of the contents.', 'originbuilder')
				),
				array(
					'name' => 'open_all',
					//'label' => 'Collapse all?',
					'type' => 'checkbox',
					'options' => array(
						'yes' => __('Allow section collapse', 'originbuilder')
					),
					'description' => __('Allow all accordion tabs to open', 'originbuilder')
				),
				/*array(
					'name' => 'class',
					'label' => 'Extra class name',
					'type' => 'text',
					'description' => __('If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'originbuilder')
				)*/
			),
			'content' => '[or_accordion_tab title="Accordion Tab"][/or_accordion_tab]'
		),

		'or_accordion_tab' => array(
			'name' => 'Accordion Tab',
			'category' => '',
			'title' => 'Accordion Tab Settings',
			'is_container' => true,
			'system_only' => true,
			'live_editor' => $live_tmpl.'or_accordion_tab.php',
			'params' => array(
				array(
					'name' => 'title',
					'label' => __('Title', 'originbuilder'),
					'value' => __('New Accordion Tab', 'originbuilder'),
					'type' => 'text'
				),
				array(
					'name' => 'icon_option',
					//'label' => 'Use Icon?',
					'type' => 'checkbox',
					'options' => array(
						'yes' => __('Use Icon', 'originbuilder')
					),
					'description' => __('If you want to display an icon beside title, Tick to choose an icon', 'originbuilder')
				),
				array(
					'name' => 'icon',
					'label' => 'Icon Title',
					'type' => 'icon_picker',
					'value' => '',
					'description' => __('Choose an icon to display with title', 'originbuilder'),
					'relation' => array(
						'parent' => 'icon_option',
						'show_when' => 'yes'
					)
				),
				/*array(
					'name' => 'class',
					'label' => 'Extra class name',
					'type' => 'text',
					'description' => __('', 'originbuilder')
				)*/
			)
		),

		'or_column_text' => array(
			'name' => 'Text',
			'description' => __('Editable Text Block', 'originbuilder'),
			'icon' => 'or-icon-text',
			'category' => '',
			'is_container' => true,
			'pop_width' => 440,
			'admin_view'	=> 'text',
			'preview_editable' => true,
			'tab_icons' => array(
				'general' => 'et-tools',
				'animate' => 'et-mobile'
			),
			'live_editor' => $live_tmpl.'or_column_text.php',
			'params' => array(
				'general' => array(
					array(
						'name' => 'content',
						'label' => 'Content',
						'type' => 'textarea_html',
						'value' => 'Sample Text',
					)
					/*array(
						'name' => 'class',
						'label' => 'Extra Class',
						'type' => 'text',
					)*/
				),
				'animate' => $animate				
			)
		),

		'or_spacing' => array(
			'name' => 'Space',
			'description' => __('Empty space separator', 'originbuilder'),
			'icon' => 'or-icon-spacing',
			'category' => '',
			'live_editor' => $live_tmpl.'or_spacing.php',
			'params' => array(
				array(
					'name' => 'height',
					'label' => 'Height',
					'type' => 'number_slider',
					'value' => '20',
					'options' => array(
						'min' => 0,
						'max' => 500,
						'unit' => 'px',
						'show_input' => true
					),
					'admin_label' => true,
					'description' => __('Set the size for spacing height', 'originbuilder'),
				),
				/*array(
					'name' => 'class',
					'label' => __('Extra class name', 'originbuilder'),
					'type' => 'text',
					'admin_label' => true,
					'description' => __('If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'originbuilder')
				)*/
			)
		),

		'or_raw_code' => array(
			'name' => 'Custom Code',
			'description' => __('Custom HTML, CSS and Js Code', 'originbuilder'),
			'icon' => 'or-icon-code',
			'category' => '',
			'pop_width' =>440,
			'live_editor' => $live_tmpl.'or_raw_code.php',
			'params' => array(
				array(
					'name' => 'code',
					'label' => 'Code',
					'type' => 'textarea',
					'value' => 'U2FtcGxlIENvZGU=',
					'admin_label' => true,
				)
			)
		),

		'or_single_image' => array(
			'name' => 'Single Image',
			'description' => __('Single image', 'originbuilder'),
			'icon' => 'or-icon-image',
			'category' => '',
			'admin_view' => 'image',
			'preview_editable' => true,
			'css_box'	=> true,
			'tab_icons' => array(
				'general' => 'et-tools',
				'animate' => 'et-mobile'
			),
			'live_editor' => $live_tmpl.'or_single_image.php',
			'params' => array(
				'general' => array(
					array(
						'name'    => 'image_source',
						'label'   => __('Image Source', 'originbuilder'),
						'type'    => 'select',
						'options' => array(
							'media_library'  => __('Media library', 'originbuilder'),
							'external_link'  => __('External link', 'originbuilder'),
							'featured_image' => __('Featured Image', 'originbuilder'),
						),
						'description' => __('Select image source.', 'originbuilder')
					),
					array(
						'name'        => 'image',
						'label'       => 'Upload Image',
						'type'        => 'attach_image',
						'admin_label' => true,
						'relation'    => array(
							'parent'    => 'image_source',
							'show_when' => 'media_library'
						)
					),
					array(
						'name'     => 'image_external_link',
						'label'    => 'Image external link',
						'type'     => 'text',
						'relation' => array(
							'parent'    => 'image_source',
							'show_when' => 'external_link'
						),
						'description' => __('Enter external link.', 'originbuilder')
					),
					array(
						'name'          => 'image_size',
						'label'         => 'Image Size',
						'type'          => 'select',
						'value'         => 'thumbnail',
						'relation'      => array(
							'parent'    => 'image_source',
							'show_when' => array('media_library', 'featured_image')
						),
						'options' => array(
							'thumbnail'  => __('Thumbnail', 'originbuilder'),
							'medium'  => __('Medium', 'originbuilder'),
							'large' => __('Large', 'originbuilder'),
						),
						'description'   => __('Select image size', 'originbuilder'),
						'value'         => 'large'
					),
					array(
						'name'          => 'image_size_el',
						'label'         => 'Image Size',
						'type'          => 'text',
						'relation'      => array(
							'parent'    => 'image_source',
							'show_when' => 'external_link'
						),
						'description'   => __('Enter the image size in pixels. Example: 200x100 (Width x Height).', 'originbuilder')
					),
					array(
						'name'        => 'caption',
						'label'       => 'Caption',
						'type'        => 'text',
						'description' => __('Enter image caption.', 'originbuilder')
					),
					array(
						'name'    => 'image_align',
						'label'   => 'Image alignment',
						'type'    => 'select',
						'options' => array(
							'left'   => __('Left', 'originbuilder'),
							'right'  => __('Right', 'originbuilder'),
							'center' => __('Center', 'originbuilder')
						),
						'description' => __('Select image alignment.', 'originbuilder')
					),
					array(
						'name'    => 'on_click_action',
						'label'   => __('On-click event', 'originbuilder'),
						'type'    => 'select',
						'options' => array(
							''                 => __('None', 'originbuilder'),
							'op_large_image'   => __('Link to large image', 'originbuilder'),
							'lightbox'         => __('Open Image In Lightbox', 'originbuilder'),
							'open_custom_link' => __('Open Custom Link', 'originbuilder')
						),
						'description' => __('Set a click event when the image clicked.', 'originbuilder')
					),
					array(
						'name'     => 'custom_link',
						'label'    => __('Custom Link', 'originbuilder'),
						'type'     => 'text',
						'value'    => 'http://',
						'relation' => array(
							'parent'    => 'on_click_action',
							'show_when' => 'open_custom_link'
						),
						'description' => __('Enter URL if you want this image to have a link (Note: parameters like "mailto:" are also accepted).', 'originbuilder')
					)
				),
				/*array(
					'name'        => 'ieclass',
					'label'       => __('Image extra class', 'originbuilder'),
					'type'        => 'text',
					'description' => __('Add class name for img tag.', 'originbuilder')
				),
				array(
					'name'    => 'image_wrap',
					'label'   => 'Div Wrapper',
					'type'    => 'select',
					'options' => array(
						'yes'   => __('Yes, Please!', 'originbuilder'),
						'no'   => __('No, Thanks!', 'originbuilder')
					),
					'description' => __('Put the image into a div warpper', 'originbuilder'),
					'value' => 'yes'
				),
				array(
					'name'        => 'class',
					'label'       => __('Wrapper extra class', 'originbuilder'),
					'type'        => 'text',
					'description' => __('If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'originbuilder'),
					'relation' => array(
						'parent' => 'image_wrap',
						'show_when' => 'yes'
					)
				)*/
				'animate' => $animate
			)
		),

		'or_icon' => array(
			'name'		  => 'Icon',
			'description' => __('Icon from Collections', 'originbuilder'),
			'icon'		  => 'or-icon-icon',
			'category'	  => '',
			'live_editor' => $live_tmpl.'or_icon.php',
			'tab_icons' => array(
				'general' => 'et-tools',
				'animate' => 'et-mobile'
			),
			'params'	  => array(
				'general' => array(
					array(
						'name'	      => 'icon',
						'label'	      => 'Select Icon',
						'type'	      => 'icon_picker',
						'admin_label' => true,
					),
					array(
						'name'	      => 'icon_align',
						'label'	      => 'Icon alignment',
						'type'	      => 'dropdown',
						'description' => __('', 'originbuilder'),
						'options'     => array(
							'none'    => __('None', 'originbuilder'),
							'left'    => __('Left', 'originbuilder'),
							'right'   => __('Right', 'originbuilder'),
							'center'  => __('Center', 'originbuilder'),
						)
					),
					array(
					
						'type'			=> 'number_slider',
						'label'			=>  __( 'Icon Size', 'originbuilder' ),
						'name'			=> 'icon_size',
						'description'	=> __('Enter icon font size. Example: 15px, 1em.', 'originbuilder'),
						'value'			=> '10',
						'options' => array(
							'min' => 0,
							'max' => 100,
							'unit' => 'px',
							'show_input' => true
						)
					),
					array(
						'name'	      => 'icon_color',
						'label'	      => 'Icon Color',
						'type'	      => 'color_picker',
						'admin_label' => true,
						'description' => __('Color of the icon.', 'originbuilder')
					),
					/*array(
						'name'	      => 'class',
						'label'	      => __('Extra class name', 'originbuilder'),
						'type'	      => 'text',
						'admin_label' => true,
						'description' => __('If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'originbuilder')
					),
					array(
						'name'	      => 'icon_wrap',
						//'label'	      => 'Icon Wrapper?',
						'type'	      => 'checkbox',
						'options'	  => array(
							'yes'     => __('Icon Wrapper', 'originbuilder')
						),
						'description' => __('Add a <div> tag around the icon.', 'originbuilder')
					),
					array(
						'name'	        => 'icon_wrap_class',
						'label'	        => 'Wrapper class name',
						'type'	        => 'text',
						'description'   => __('Enter class name for wrapper', 'originbuilder'),
						'relation'      => array(
							'parent'    => 'icon_wrap',
							'show_when' => 'yes'
						)
					),*/
				),
				'animate' => $animate
			)
		),

		'or_title' => array(
			'name'		  => 'Title',
			'description' => __('Heading Text Blocks', 'originbuilder'),
			'icon'		  => 'or-icon-title',
			'category'	  => '',
			'css_box'	  => true,
			'tab_icons' => array(
				'general' => 'et-tools',
				'animate' => 'et-mobile'
			),
			'live_editor' => $live_tmpl.'or_title.php',
			'params'	  => array(
				'general' => array(
					array(
						'name'	      => 'text',
						'label'       => 'Text',
						'type'	      => 'textarea',
						'value'		  => base64_encode('The Title'),
						'admin_label' => true
					),
					array(
						'name'	  => 'type',
						'label'   => 'Type',
						'type'	  => 'select',
						'options' => array(
							'h1'  => 'H1',
							'h2'  => 'H2',
							'h3'  => 'H3',
							'h4'  => 'H4',
							'h5'  => 'H5',
							'h6'  => 'H6'
						)
					),
					array(
						'name'	  => 'align',
						'label'   => 'Align',
						'type'	  => 'select',
						'options' => array(
							''  => 'Normal',
							'left'  => 'Left',
							'center'  => 'Center',
							'right'  => 'Right'
						)
					),
					/*array(
						'name'	=> 'class',
						'label' => 'Extra Class',
						'type'	=> 'text'
					),*/
					/*array(
						'name'	      => 'title_wrap',
						//'label'       => 'Advanced',
						'type'	      => 'checkbox',
						'options'     => array(
							'yes'     => __('Advanced', 'originbuilder')
						),
						'description' => __('Add a &lt;div&gt; tag around the head tag, more code before or after the head tag.', 'originbuilder')
					),
					array(
						'name'	      => 'before',
						'label'       => 'Before Head Tag',
						'type'	      => 'textarea',
						'description' => __('Add HTML text before the head tag.', 'originbuilder'),
						'relation'      => array(
							'parent'    => 'title_wrap',
							'show_when' => 'yes'
						)
					),
					array(
						'name'	      => 'after',
						'label'       => 'After Head Tag',
						'type'	      => 'textarea',
						'description' => __('Add HTML text after the head tag.', 'originbuilder'),
						'relation'      => array(
							'parent'    => 'title_wrap',
							'show_when' => 'yes'
						)
					),
					 array(
						'name'	        => 'title_wrap_class',
						'label'         => 'Wrapper class name',
						'type'	        => 'text',
						'description'   => __('Enter class name for wrapper', 'originbuilder'),
						'relation'      => array(
							'parent'    => 'title_wrap',
							'show_when' => 'yes'
						)
					)*/
				),
				'animate' => $animate
			)
		),

		'or_google_maps' => array(

			'name'			   => __('Google Maps', 'originbuilder'),
			'description'	   => __('Google Map Address Block', 'originbuilder'),
			'icon'			   => 'or-icon-map',
			'category'		   => '',
			'admin_view'	   => 'gmaps',
			'tab_icons' => array(
				'general' => 'et-tools',
				'animate' => 'et-mobile'
			),
			'live_editor' => $live_tmpl.'or_google_maps.php',
			'params'		   => array(
				'general' => array(
					array(
						'name'        => 'random_id',
						'label'       => '',
						'type'        => 'random',
						'description' => '',
					),
					array(
						'type'			=>  'text',
						'label'			=> __( 'Title', 'originbuilder' ),
						'name'			=> 'title',
						'description'	=> __( "Map title. You can leave it blank if it's not needed", 'originbuilder' ),
					),
					array(
						'type'			=> 'textarea',
						'label'			=> __( 'Map location iframe embed code:', 'originbuilder' ),
						'name'			=> 'map_location',
						'value'			=> base64_encode( '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387190.2798864717!2d-74.25986673512958!3d40.69767006847739!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2sin!4v1466170833439" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>'),
						'description'	=> __( 'Instruction: Go to Google Maps and search the for your location. Then click on the "Share" button, on the pop up that appears, click the "Embed map" tab and copy the iframe code.' )
					),
					array(
						'type'			 => 'number_slider',
						'label'			 => __( 'Map Height', 'originbuilder' ),
						'name'			 => 'map_height',
						'description'	 => __( 'Set map height. Example: 300 px', 'originbuilder' ),
						'value'			 => '350',
						'options'        => array(
							'min'        => 50,
							'max'        => 1000,
							'unit'       => 'px',
							'show_input' => true
						)
					),
					array(
						'type'			     => 'checkbox',
						//'label'			     => __( 'Show overlap contact form', 'originbuilder' ),
						'name'			     => 'show_ocf',
						'description'	     => __( 'Display a contact form on the map', 'originbuilder' ),
						'options'			 => array( 'yes' => __( 'Overlap contact form on the map', 'originbuilder' ) )
					),
					array(
						'type'			     => 'textarea',
						'label'			     => __( 'Contact form shortcode', 'originbuilder' ),
						'name'			     => 'contact_form_sc',
						'description'	     => __( 'Shortcode content which generated by contact form 7. For example: [contact-form-7 id="4" title="Contact form 1"]', 'originbuilder' ),
						'relation'		     => array(
							'parent'         => 'show_ocf',
							'show_when'      => 'yes'
						)
					),
					array(
						'type'			 => 'text',
						'label'			 => __( 'Contact area width', 'originbuilder' ),
						'name'			 => 'contact_area_width',
						'description'	 => __( 'Width of wrapper form. Ex: 45% or 400px', 'originbuilder' ),
						'relation'		 => array(
							'parent'     => 'show_ocf',
							'show_when'  => 'yes'
						),
						'value'			 => '45%'
					),
					array(
						'type'			 => 'select',
						'label'			 => __( 'Contact area position', 'originbuilder' ),
						'name'			 => 'contact_area_position',
						'options'		 => array(
							'left'  => __( 'Left', 'originbuilder' ),
							'right' => __( 'Right', 'originbuilder' ),
						),
						'description'	=> __( 'Set position for the contact form box', 'originbuilder' ),
						'relation'		=> array(
							'parent' => 'show_ocf',
							'show_when' => 'yes'
						),
						'value'			=> 'left'
					),
					/*array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Contact area background', 'originbuilder' ),
						'name'			=> 'contact_area_bg',
						'description'	=> __( 'Set background color for the contact form', 'originbuilder' ),
						'relation'		=> array(
							'parent' => 'show_ocf',
							'show_when' => 'yes'
						),
						'value' 		=> '#a1aee2'
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Contact form color', 'originbuilder' ),
						'name'			=> 'contact_form_color',
						'description'	=> __( 'Set color for text in contact form', 'originbuilder' ),
						'relation'		=> array(
							'parent' => 'show_ocf',
							'show_when' => 'yes'
						),
						'value' 		=> '#3c3c3c'
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Submit button color', 'originbuilder' ),
						'name'			=> 'submit_button_color',
						'description'	=> __( '', 'originbuilder' ),
						'relation'		=> array(
							'parent' => 'show_ocf',
							'show_when' => 'yes'
						),
						'value' 		=> '#393939'
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Submit button hover color', 'originbuilder' ),
						'name'			=> 'submit_button_hover_color',
						'description'	=> __( '', 'originbuilder' ),
						'relation'		=> array(
							'parent' => 'show_ocf',
							'show_when' => 'yes'
						),
						'value' 		=> '#575757'
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Submit button text color', 'originbuilder' ),
						'name'			=> 'submit_button_text_color',
						'description'	=> __( '', 'originbuilder' ),
						'relation'		=> array(
							'parent' => 'show_ocf',
							'show_when' => 'yes'
						),
						'value' 		=> '#FFFFFF'
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Submit button text hover color', 'originbuilder' ),
						'name'			=> 'submit_button_text_hover_color',
						'description'	=> __( '', 'originbuilder' ),
						'relation'		=> array(
							'parent' => 'show_ocf',
							'show_when' => 'yes'
						),
						'value' 		=> '#FFFFFF'
					),
					array(
						'type'			=>  'text',
						'label'			=> __( 'Wrapper class name', 'originbuilder' ),
						'name'			=> 'wrap_class',
						'description'	=> __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' ),
					),*/
				),
				'animate' => $animate
			)
		),

		'or_twitter_feed' => array(
			'name'			=> __('Twitter Feed', 'originbuilder'),
			'description'	=> __('Twitter News Feed', 'originbuilder'),
			'icon' => 'or-icon-twitter',
			'category' => '',
			'css_box' => true,
			'params' => array(
				array(
					'type'			=>  'text',
					'label'			=> __( 'Title', 'originbuilder' ),
					'name'			=> 'title',
					'description'	=> __( "Widget title. You can leave it blank if it's not needed.", 'originbuilder' ),
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Twitter username', 'originbuilder' ),
					'name'			=> 'username',
					'value'			=> 'OriginBuilder',
					'admin_label'	=> true
				),
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Layout style', 'originbuilder' ),
					'name'			=> 'display_style',
					'options'			=> array(
						'1' => __( 'List View', 'originbuilder' ),
						'2' => __( 'Slider tweets', 'originbuilder' ),
					),
					'admin_label'	=> true
				),
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Twitter box height', 'originbuilder' ),
					'name'			=> 'max_height',
					//'description'	=> __( 'Set the height of the Twitter feed box, from 100px to 800px. Scroll bar will appear if the Twitter feed box height is bigger than the one you set. Enter “0” to show all tweets you set without scroll bar. Min:100px, max: 800px', 'originbuilder' ),
					'value'			=> '350',
					'options'		=> array(
						'min' => 100,
						'max' => 800,
						'unit' => 'px',
						'show_input' => true
					),
					'relation' 		=> array(
						'parent'	=> 'display_style',
						'show_when' => '1'
					)
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show navigation', 'originbuilder' ),
					'name'			=> 'show_navigation',
					'options'		=> array( 'yes' => __( 'Show navigation', 'originbuilder' ) ),
					'value'			=> 'yes',
					'relation'		=> array(
						'parent'	=> 'display_style',
						'show_when'	=> '2'
					)
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show pagination', 'originbuilder' ),
					'name'			=> 'show_pagination',
					'options'		=> array( 'yes' => __( 'Show pagination', 'originbuilder' ) ),
					'value'			=> 'yes',
					'relation'		=> array(
						'parent'	=> 'display_style',
						'show_when'	=> '2'
					)
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Auto height', 'originbuilder' ),
					'name'			=> 'auto_height',
					'options'		=> array( 'yes' => __( 'Auto height', 'originbuilder' ) ),
					'relation'		=> array(
						'parent'	=> 'display_style',
						'show_when'	=> '2'
					)
				),
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Number of Tweets to display', 'originbuilder' ),
					'name'			=> 'number_tweet',
					'admin_label'	=> true,
					'value'			=> '5',
					'options' 		=> array(
						'min' => 1,
						'max' => 20,
						'show_input' => true
					)
				),
				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Link color', 'originbuilder' ),
					'name'			=> 'link_color',
					'description'	=> __( 'Color for the links on box.', 'originbuilder' ),
					'value'			=> '#f7d377'
				),
				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Link hover color:', 'originbuilder' ),
					'name'			=> 'link_color_hover',
					'description'	=> __( 'Hover color for links on box.', 'originbuilder' ),
					 
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show Time', 'originbuilder' ),
					'name'			=> 'show_time',
					'description'	=> __( 'Show how much time has elapsed since a tweet was posted: Example: "10m ago"', 'originbuilder' ),
					'options'		=> array( 'yes' => __( 'Show Time', 'originbuilder' ) ),
					'value'			=> 'yes'
				),
				array(
					'type'			=> 'checkbox',
				//	'label'			=> __( 'Show reply link', 'originbuilder' ),
					'name'			=> 'show_reply',
					'description'	=> __( 'Show Reply link to each tweet.', 'originbuilder' ),
					'options'		=> array( 'yes' => __( 'Show reply link', 'originbuilder' ) ),
					'value'			=> 'yes'
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Allow Retweet', 'originbuilder' ),
					'name'			=> 'show_retweet',
					'description'	=> __( 'Show Retweet link to each tweet.', 'originbuilder' ),
					'options'		=> array( 'yes' => __( 'Allow Retweet', 'originbuilder' ) ),
					'value'			=> 'yes'
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show Twitter avatar', 'originbuilder' ),
					'name'			=> 'show_avatar',
					'description'	=> __( 'Show avatar of Twitter account beside each tweet.', 'originbuilder' ),
					'options'		=> array( 'yes' => __( 'Show Twitter avatar', 'originbuilder' ) ),
					'relation' 		=> array(
						'parent'	=> 'display_style',
						'show_when' => '1'
					),
					'value'			=> 'yes'
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show Follow button', 'originbuilder' ),
					'name'			=> 'show_follow_button',
					'options'		=> array( 'yes' => __( 'Show Follow button', 'originbuilder' ) ),
					'value'			=> 'yes'
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Use Own API Key', 'originbuilder' ),
					'name'			=> 'use_api_key',
					'options'		=> array( 'yes' => __( 'Use Own API Key', 'originbuilder' ) )
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Consumer Key (API Key)', 'originbuilder' ),
					'name'			=> 'consumer_key',
					'value'			=> '',
					'relation'		=> array(
						'parent' => 'use_api_key',
						'show_when' => 'yes'
					)
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Consumer Secret (API Secret)', 'originbuilder' ),
					'name'			=> 'consumer_secret',
					'value'			=> '',
					'relation'		=> array(
						'parent' => 'use_api_key',
						'show_when' => 'yes'
					)
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Access Token', 'originbuilder' ),
					'name'			=> 'access_token',
					'value'			=> '',
					'relation'		=> array(
						'parent' => 'use_api_key',
						'show_when' => 'yes'
					)
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Access Token Secret', 'originbuilder' ),
					'name'			=> 'access_token_secrect',
					'value'			=> '',
					'relation'		=> array(
						'parent' => 'use_api_key',
						'show_when' => 'yes'
					)
				),
				/*array(
					'type'			=> 'text',
					'label'			=> __( 'Wrapper class name', 'originbuilder' ),
					'name'			=> 'wrap_class',
					'description'	=> __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' ),
					'value'			=> ''
				)*/
			)
		),

		/* Just for test icon
		---------------------------------------------------------- */

		'or_instagram_feed' => array(

			'name' => __('Instagram Feed', 'originbuilder'),
			'description' => __('Instagram Feed', 'originbuilder'),
			'icon' => 'or-icon-instagram',
			'category' => '',
			'css_box' => true,
			'params' => array(
				array(
					'type'			=> 'text',
					'label'			=> __( 'Title', 'originbuilder' ),
					'name'			=> 'title',
					'description'	=> __( "Widget title. You can leave it blank if it's not needed", 'originbuilder' ),
					'admin_label'	=> true
				),
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Number of photos', 'originbuilder' ),
					'name'			=> 'number_show',
					'description'	=> __( 'Set the number of photos to display.', 'originbuilder' ),
					'value'			=> '8',
					'options' => array(
						'min' => 1,
						'max' => 16,
						'show_input' => true
					),
					'admin_label'	=> true,
				),
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Number of Columns', 'originbuilder' ),
					'name'			=> 'columns_style',
					'options'			=> array(
						'1' => __( '1 Columns', 'originbuilder' ),
						'2' => __( '2 Columns', 'originbuilder' ),
						'3' => __( '3 Columns', 'originbuilder' ),
						'4' => __( '4 Columns', 'originbuilder' ),
						'5' => __( '5 Columns', 'originbuilder' ),
						'6' => __( '6 Columns', 'originbuilder' )
					),
					'description'	=> __( 'Set the photo columns.', 'originbuilder' ),
					'value'			=> '4'
				),
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Image Size', 'originbuilder' ),
					'name'			=> 'image_size',
					'description'	=> __( '', 'originbuilder' ),
					'options'		=> array(
						'low_resolution' => 'Low resolution',
						'thumbnail' => 'Thumbnail',
						'standard_resolution' => 'Standard resolution',
					)
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Instagram username:', 'originbuilder' ),
					'name'			=> 'username',
					'description'	=> __( 'Enter your Instagram username.', 'originbuilder' ),
					'admin_label'	=> true
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Access token', 'originbuilder' ),
					'name'			=> 'access_token',
					'description'	=> __( 'You can generate your Access Token at http://instagram.pixelunion.net/', 'originbuilder' ),
					'value'			=> ''
				),
				/*array(
					'type'			=> 'text',
					'label'			=> __( 'Custom class name', 'originbuilder' ),
					'name'			=> 'wrap_class',
					'description'	=> __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' ),
				)*/
			)

		),

		'or_fb_recent_post' => array(

			'name' => __('FaceBook Post', 'originbuilder'),
			'description' => __('Facebook Newsfeed Post', 'originbuilder'),
			'icon' => 'or-icon-facebook',
			'category' => '',
			//'css_box' => true,
			'params' => array(
				array(
					'type'			=> 'text',
					'label'			=> __( 'Title', 'originbuilder' ),
					'name'			=> 'title',
					'description'	=> __( "Widget title. You can leave it blank if it's not needed", 'originbuilder' ),
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Facebook Page slug', 'originbuilder' ),
					'name'			=> 'fb_page_id',
					'description'	=> __( 'Facebook page ID or slug. For example: wordpress', 'originbuilder' ),
					'admin_label'	=> true
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Facebook App ID', 'originbuilder' ),
					'name'			=> 'fb_app_id',
					'description'	=> __( 'Create and get your App ID at https://developers.facebook.com/apps', 'originbuilder' ),
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Facebook App Secret', 'originbuilder' ),
					'name'			=> 'fb_app_secret',
					'description'	=> __( 'Get your App Secret from https://developers.facebook.com/apps', 'originbuilder' ),
				),
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Facebook feed height', 'originbuilder' ),
					'name'			=> 'max_height',
					'description'	=> __( 'Set the height of Facebook feed box.' ),
					'value'			=> '350',
					'options' => array(
						'min' => 50,
						'max' => 1000,
						'unit' => 'px',
						'show_input' => true
					)
				),
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Number of posts to display', 'originbuilder' ),
					'name'			=> 'number_post_show',
					'description'	=> __( 'The number of posts displayed', 'originbuilder' ),
					'value'			=> '5',
					'admin_label'	=> true,
					'options' => array(
						'min' => 1,
						'max' => 10,
						'show_input' => true
					)
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Number of words per post', 'originbuilder' ),
					'name'			=> 'number_of_des',
					'description'	=> __( 'The number of words in each facebook post, for example: 25.' ),
					'value'			=> '25'
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show Image?', 'originbuilder' ),
					'name'			=> 'show_image',
					'description'	=> __( 'Show the featured image of the Facebook post.', 'originbuilder' ),
					'options'		=> array( 'yes' => __( 'Show Image', 'originbuilder' ) ),
					'value'			=> 'yes'
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show Like Count?', 'originbuilder' ),
					'name'			=> 'show_like_count',
					'description'	=> __( 'Show the Like count link in the Facebook post.', 'originbuilder' ),
					'options'		=> array( 'yes' => __( 'Show Like Count', 'originbuilder' ) ),
					'value'			=> 'yes'
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show Comment Count?', 'originbuilder' ),
					'name'			=> 'show_comment_count',
					'description'	=> __( 'Show Comment count link in the Facebook post.', 'originbuilder' ),
					'options'		=> array( 'yes' => __( 'Show Comment Count', 'originbuilder' ) ),
					'value'			=> 'yes'
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show Time', 'originbuilder' ),
					'name'			=> 'show_time',
					'description'	=> __( 'Show how long it was since a post was published.', 'originbuilder' ),
					'options'		=> array( 'yes' => __( 'Show Time', 'originbuilder' ) ),
					'value'			=> 'yes'
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Open URL in a new tab', 'originbuilder' ),
					'name'			=> 'open_link_new_window',
					'description'	=> __( 'All Facebook URLs will open in a new tab.', 'originbuilder' ),
					'options'		=> array( 'yes' => __( 'Open URL in a new tab', 'originbuilder' ) ),
					'value'			=> 'yes'
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show profile button', 'originbuilder' ),
					'name'			=> 'show_profile_button',
					'description'	=> __( 'Show the profile button underneath the Facebook post box.', 'originbuilder' ),
					'options'		=> array( 'yes' => __( 'Show profile button', 'originbuilder' ) ),
				),
				/*array(
					'type'			=> 'text',
					'label'			=> __( 'Custom class name', 'originbuilder' ),
					'name'			=> 'wrap_class',
					'description'	=> __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' ),
				)*/
			)

		),

		/*'or_flip_box' => array(
			'name' => __('Flip Box', 'originbuilder'),
			'description' => __('', 'originbuilder'),
			'icon' => 'or-icon-flip',
			'category' => '',
			'css_box' => true,
			'live_editor' => $live_tmpl.'or_flip_box.php',
			'params' => array(

				array(
					'type'			=> 'attach_image',
					'label'			=> __( 'Front Image', 'originbuilder' ),
					'name'			=> 'image',
					'description'	=> __( 'Upload image for the front side.', 'originbuilder' ),
					'admin_label'	=> true
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Image size', 'originbuilder' ),
					'name'			=> 'image_size',
					'description'	=> __( 'Set the image size (For example: thumbnail, medium, large or full).', 'originbuilder' ),
					'admin_label'	=> true,
					'value'			=> 'full'
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Title', 'originbuilder' ),
					'name'			=> 'title',
					'description'	=> __( 'Title of the FlipBox. Leave blank if no title is needed.', 'originbuilder' ),
					'admin_label'	=> true
				),
				array(
					'type'			=> 'textarea',
					'label'			=> __( 'Description', 'originbuilder' ),
					'name'			=> 'description',
					'description'	=> __( 'Enter description for the back side, Shortcode are supported in this field.', 'originbuilder' )
				),
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Direction', 'originbuilder' ),
					'name'			=> 'direction',
					'options'		=> array(
						'horizontal' => __( 'Horizontal', 'originbuilder' ),
						'vertical' => __( 'Vertical', 'originbuilder' ),
					),
					'description'	=> __( 'Direction of flip', 'originbuilder' ),
				),
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Text align', 'originbuilder' ),
					'name'			=> 'text_align',
					'options'		=> array(
						'center' => __( 'Center', 'originbuilder' ),
						'left' => __( 'Left', 'originbuilder' ),
						'right' => __( 'Right', 'originbuilder' ),
						'justtify' => __( 'Justtify', 'originbuilder' ),
					),
					'description'	=> __( 'Set the text align: Center, left, right or justtify', 'originbuilder' ),
				),
				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Text Color', 'originbuilder' ),
					'name'			=> 'text_color',
					'description'	=> __( 'Color of the text.', 'originbuilder' ),
					'value'			=> '#FFFFFF'
				),
				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Background Back side', 'originbuilder' ),
					'name'			=> 'bg_backside',
					'description'	=> __( 'Background color of the back side.', 'originbuilder' ),
					'value'			=> '#393939'
				),
				array(
					'type'			=> 'checkbox',
					'label'			=> __( 'Show button', 'originbuilder' ),
					'name'			=> 'show_button',
					'description'	=> __( 'Show the button in the back side.', 'originbuilder' ),
					'options'			=> array( 'yes' => __( 'Yes, Please', 'originbuilder' ) ),
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Text on button', 'originbuilder' ),
					'name'			=> 'text_on_button',
					'description'	=> __( 'Set the text displayed on the button.', 'originbuilder' ),
					'relation'	=> array(
						'parent' => 'show_button',
						'show_when' => 'yes'
					),
					'value'			=> 'Read more'
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'URL', 'originbuilder' ),
					'name'			=> 'link',
					'description'	=> __( 'URL of the button in the back side.', 'originbuilder' ),
					'value'			=> '#',
					'relation'	=> array(
						'parent' => 'show_button',
						'show_when' => 'yes'
					)
				),
				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Button text color', 'originbuilder' ),
					'name'			=> 'text_button_color',
					'description'	=> __( 'Color of the button text.', 'originbuilder' ),
					'relation'	=> array(
						'parent' => 'show_button',
						'show_when' => 'yes'
					),
					'value'			=> '#FFFFFF'
				),
				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Button background color', 'originbuilder' ),
					'name'			=> 'button_bg_color',
					'description'	=> __( 'Background color of the button. (Default values is: transparent)', 'originbuilder' ),
					'relation'	=> array(
						'parent' => 'show_button',
						'show_when' => 'yes'
					),
					'value'			=> 'transparent'
				),
				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Button background color on hover', 'originbuilder' ),
					'name'			=> 'button_bg_hover_color',
					'description'	=> __( 'Button\'s background color that changes when the mouse cursor hovers over it.', 'originbuilder' ),
					'relation'	=> array(
						'parent' => 'show_button',
						'show_when' => 'yes'
					),
					'value'			=> '#FFFFFF'
				),
				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Button text color on hover', 'originbuilder' ),
					'name'			=> 'text_button_color_hover',
					'description'	=> __( 'Button text color that changes when the mouse cursor hovers over it.', 'originbuilder' ),
					'relation'	=> array(
						'parent' => 'show_button',
						'show_when' => 'yes'
					),
					'value'			=> '#86c724'
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Wrapper class name', 'originbuilder' ),
					'name'			=> 'wrap_class',
					'description'	=> __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' ),
					'value'			=> ''
				)
			)

		),*/

		'or_pie_chart' => array(
			'name' => __('Pie Chart', 'originbuilder'),
			'description' => __('Animated pie chart', 'originbuilder'),
			'icon' => 'or-icon-pie',
			'category' => '',
			'css_box' => true,
			'live_editor' => $live_tmpl.'or_pie_chart.php',
			'params'		=> array(
                	array(
					'type'			=> 'text',
					'label'			=> __( 'Title', 'originbuilder' ),
					'name'			=> 'title',
					'description'	=> __( 'Title of the Pie chart.', 'originbuilder' ),
					'admin_label'	=> true
				),
				array(
					'type'			=> 'textarea',
					'label'			=> __( 'Description', 'originbuilder' ),
					'name'			=> 'description',
					'description'	=> __( 'Enter the chart description.', 'originbuilder' ),
				),
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Percentage Value', 'originbuilder' ),
					'name'			=> 'percent',
					'description'	=> __( 'Enter the chart description.', 'originbuilder' ),
					'admin_label'	=> true,
					'value' 		=> '50',
					'options'		=> array(
						'unit'		=> '%',
						'show_input'=> true
					)
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Rounded corners', 'originbuilder' ),
					'name'			=> 'rounded_corners_bar',
					'description'	=> __( 'Have the percentage bar withrounded edges.', 'originbuilder' ),
					'options'		=> array( 'yes' => __( 'Rounded corners', 'originbuilder' ) ),
				),
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Pie Size', 'originbuilder' ),
					'name'			=> 'size',
					'description'	=> __( 'Pie size (diameter).', 'originbuilder' ),
					'options'			=> array(
						'100' 		=> __('100 px', 'originbuilder'),
						'150' 		=> __('150 px', 'originbuilder'),
						'200' 		=> __('200 px', 'originbuilder'),
						'custom' 	=> __('Custom', 'originbuilder'),
						'auto'		=> __( 'Auto width', 'originbuilder' )
					)
				),
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Custom size', 'originbuilder' ),
					'name'			=> 'custom_size',
					'description'	=> __( 'It is width and height of pie chart, unit (px).', 'originbuilder' ),
					'admin_label'	=> true,
					'relation' 	=> array(
						'parent' 	=> 'size',
						'show_when' => 'custom'
					),
					'options'		=> array(
						'show_input'=> true,
						'min'	=> 50,
						'max'	=> 500
					),
					'value'			=> '120'
				),
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Line Width', 'originbuilder' ),
					'name'			=> 'linewidth',
					'description'	=> __( 'Drag slider to change the Width of the line in px.', 'originbuilder' ),
					'admin_label'	=> true,
					'value' 		=> '10',
					'options'		=> array(
						'show_input'=> false,
						'min'	=> 1,
						'max'	=> 30,
						'show_input' => true
					)
				),
			

				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Bar Color', 'originbuilder' ),
					'name'			=> 'barcolor',
					'description'	=> __( 'Color of the percentage bar.', 'originbuilder' ),
					'value'			=> '#39c14f'
				),
				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Track Color', 'originbuilder' ),
					'name'			=> 'trackcolor',
					'description'	=> __( 'Color of the track pie.', 'originbuilder' ),
					'value'			=> '#e4e4e4'
				),
				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Label color', 'originbuilder' ),
					'name'			=> 'label_color',
					'description'	=> __( 'Color of the percentage bar number.', 'originbuilder' ),
					'value'			=> '#FF5252'
				),
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Label front size', 'originbuilder' ),
					'name'			=> 'label_font_size',
					'description'	=> __( 'Font size of the percentage value', 'originbuilder' ),
					'value'			=> '20',
					'options'		=> array(
						'unit'		=> 'px',
						'show_input'=> true
					)
				),
				/*array(
					'type'			=> 'text',
					'label'			=> __( 'Wrapper class name', 'originbuilder' ),
					'name'			=> 'wrap_class',
					'description'	=> __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' ),
				)*/
			)

		),
		'or_progress_bars' => array(

			'name' => __('Progress Bar', 'originbuilder'),
			'description' => __('Animated progress bar', 'originbuilder'),
			'icon' => 'or-icon-progress',
			'category' => '',
			'css_box' => true,
			'live_editor' => $live_tmpl.'or_progress_bars.php',
			'params' => array(

				array(
					'type'			=> 'text',
					'label'			=> __( 'Title', 'originbuilder' ),
					'name'			=> 'title',
					'description'	=> __( 'Enter the title of the progress bar. If no title is required, leave blank.', 'originbuilder' ),
					'admin_label'	=> true,
				),
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Style', 'originbuilder' ),
					'name'			=> 'style',
					'description'	=> __( 'Select the style of progress bars.', 'originbuilder' ),
					'options'		=> array(
						'1' => __('Style 1', 'originbuilder'),
						'2' => __('Style 2 (Value in tooltip)', 'originbuilder'),
						'3' => __('Style 3 (Value in progress bar)', 'originbuilder')
					),
					'admin_label'	=> true,
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Border radius', 'originbuilder' ),
					'name'			=> 'radius',
					'description'	=> __( 'Set Border radius for bars', 'originbuilder' ),
					'options'			=> array( 'yes' => __( 'Border radius', 'originbuilder' ) ),
					'value' 			=> 'no'
				),
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Processbar Weight', 'originbuilder' ),
					'name'			=> 'weight',
					'description'	=> __( 'Height weight of progress bar: Ex 12, unit (px)', 'originbuilder' ),
					'value'			=> '12',
					'options' 		=> array(
						'min'		=> 2,
						'max'		=> 40,
						'show_input'=> true,
					)
				),
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Spacing', 'originbuilder' ),
					'name'			=> 'margin',
					'description'	=> __( 'The spacing between items', 'originbuilder' ),
					'value'			=> '20',
					'options' 		=> array(
						'min'		=> 0,
						'max'		=> 100,
						'show_input'=> true,
					),
				),
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Animate Speed', 'originbuilder' ),
					'name'			=> 'speed',
					'description'	=> __( 'Select animation speed.', 'originbuilder' ),
					'options'		=> array(
						'2000' => __('Normal', 'originbuilder'),
						'1600' => __('Fast', 'originbuilder'),
						'1200' => __('Very Fast', 'originbuilder'),
						'2400' => __('Slow', 'originbuilder'),
						'2800' => __('Very Slow', 'originbuilder'),
					),
					'value'			=> '2000',
					'admin_label'	=> true,
				),
				array(
					'type'			=> 'group',
					'label'			=> __('Options', 'originbuilder'),
					'name'			=> 'options',
					//'description'	=> __( 'Repeat this fields with each item created, Each item corresponding processbar element.', 'originbuilder' ),
					'value' => base64_encode( json_encode(array(
						"1" => array(
							"value" => "90",
							"value_color" => "#999999",
							"label" => "Development",
							"label_color" => "#0d6347",
							"prob_color" => "#1a6c9c",
							"prob_bg_color" => "#dbdbdb"
						),
						"2" => array(
							"value" => "80",
							"value_color" => "#626a0d",
							"label" => "Design",
							"label_color" => "#0d6347",
							"prob_color" => "#1a6c9c",
							"prob_bg_color" => "#dbdbdb"
						),
						"3" => array(
							"value" => "70",
							"value_color" => "#6b1807",
							"label" => "Marketing",
							"label_color" => "#0d6347",
							"prob_color" => "#1a6c9c",
							"prob_bg_color" => "#dbdbdb"
						)
					) ) ),
					'params' => array(
						array(
							'type' => 'number_slider',
							'label' => __( 'Value', 'originbuilder' ),
							'name' => 'value',
							'description' => __( 'Enter display value of the bar.', 'originbuilder' ),
							'admin_label' => true,
							'options' 		=> array(
								'min'		=> 1,
								'max'		=> 100,
								'show_input'=> true,
							),
							'value' => '80'
						),
							array(
							'type' => 'text',
							'label' => __( 'Label', 'originbuilder' ),
							'name' => 'label',
							'description' => __( 'Enter bar text title.', 'originbuilder' ),
							'admin_label' => true,
						),
						array(
							'type' => 'color_picker',
							'label' => __( 'Value Color', 'originbuilder' ),
							'name' => 'value_color',
							'description' => __( 'Color of targeted value text.', 'originbuilder' ),
						),
					
						array(
							'type' => 'color_picker',
							'label' => __( 'Label Color', 'originbuilder' ),
							'name' => 'label_color',
							'description' => __( 'Label text color', 'originbuilder' ),
						),
						array(
							'type' => 'color_picker',
							'label' => __( 'Progressbar Color', 'originbuilder' ),
							'name' => 'prob_color',
							'description' => __( 'Customized progress bar color.', 'originbuilder' ),
						),
						array(
							'type' => 'color_picker',
							'label' => __( 'Progressbar background color', 'originbuilder' ),
							'name' => 'prob_bg_color',
							'description' => __( 'Customized progress background bar color.', 'originbuilder' ),
						),
					),
				),
				/*array(
					'type'			=> 'text',
					'label'			=> __( 'Wrapper class name', 'originbuilder' ),
					'name'			=> 'wrap_class',
					'description'	=> __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' ),
				)*/
			)

		),

		'or_button' => array(

			'name' => __('Button', 'originbuilder'),
			'description' => __('Clickable CTA button', 'originbuilder'),
			'icon' => 'or-icon-button',
			'category' => '',
			'css_box' => true,
			'live_editor' => $live_tmpl.'or_button.php',
			'tab_icons' => array(
				'general' => 'et-tools',
				'animate' => 'et-mobile'
			),
			'params' => array(
				'general' => array(
					array(
						'type'			=> 'text',
						'label'			=> __( 'Title', 'originbuilder' ),
						'name'			=> 'text_title',
						'description'	=> __( 'Enter button text.', 'originbuilder' ),
						'value' 			=> 'Text title',
						'admin_label'	=> true
					),
					array(
						'type'			=> 'link',
						'label'			=> __( 'Link', 'originbuilder' ),
						'name'			=> 'link',
						'description'	=> __( 'Add button target URL.', 'originbuilder' ),
					),
					array(
						'type'			=> 'dropdown',
						'label'			=> __( 'Button size', 'originbuilder' ),
						'name'			=> 'size',
						'description'	=> __( 'Select button size.', 'originbuilder' ),
						'options'		=> array(
							'small' => __('Small', 'originbuilder'),
							'normal' => __('Normal', 'originbuilder'),
							'large' => __('Large', 'originbuilder'),
							'custom' => __('Custom padding, front-size', 'originbuilder'),
						),
					),
					array(
						'type'			=> 'text',
						'label'			=> __( 'Padding', 'originbuilder' ),
						'name'			=> 'padding_button',
						'description'	=> __( 'The CSS padding properties are used to generate space around content, (top, right, bottom, and left) . For example: "10px 25px" or "10px 25px 10px 25px"', 'originbuilder' ),
						'relation'	=> array(
							'parent'	=> 'size',
							'show_when'	=> 'custom'
						),
						'value'			=> '10px 25px 10px 25px'
					),
					array(
						'type'			=> 'text',
						'label'			=> __( 'Front size', 'originbuilder' ),
						'name'			=> 'font_size_button',
						'description'	=> __( 'Font size for text in the button. For example: 14px', 'originbuilder' ),
						'relation'	=> array(
							'parent'	=> 'size',
							'show_when'	=> 'custom'
						),
						'value'			=> '14px'
					),
					array(
						'type' 			=> 'checkbox',
						//'label'			=> __( 'Custom style', 'originbuilder' ),
						'name'			=> 'custom_style',
						'description'	=> __('Show all related parameters.', 'originbuilder'),
						'options'			=> array( 'yes' => __( 'Custom style', 'originbuilder' ) ),
						'value'			=> 'yes'
					),
					array(
						'type'			=> 'number_slider',
						'label'			=> __( 'Border radius', 'originbuilder' ),
						'name'			=> 'border_radius',
						'description'	=> __( 'Slide left or right to change the button corner radius.', 'originbuilder' ),
						'value'			=> 3,
						'options' => array(
							'min' => 0,
							'max' => 1000,
							'unit' => 'px',
							'show_input' => true,
						),
						'relation'	=> array(
							'parent'	=> 'custom_style',
							'show_when'	=> 'yes'
						),
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Shape color', 'originbuilder' ),
						'name'			=> 'bg_color',
						'description'	=> __( 'Shape color that changes when the mouse cursor hovers over the button.', 'originbuilder' ),
						'relation'	=> array(
							'parent'	=> 'custom_style',
							'show_when'	=> 'yes'
						),
						'value'			=> '#fff'
						 
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Shape color hover', 'originbuilder' ),
						'name'			=> 'bg_color_hover',
						'description'	=> __( 'Button Shape color hover', 'originbuilder' ),
						'relation'	=> array(
							'parent'	=> 'custom_style',
							'show_when'	=> 'yes'
						),
						 
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Text color', 'originbuilder' ),
						'name'			=> 'text_color',
						'description'	=> __( 'Set color of the button text.', 'originbuilder' ),
						'relation'	=> array(
							'parent'	=> 'custom_style',
							'show_when'	=> 'yes'
						),
						'value'			=> '#000'
						 
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Text color hover', 'originbuilder' ),
						'name'			=> 'text_color_hover',
						'description'	=> __( 'Set color of the button when mouse cursor hovers over it.', 'originbuilder' ),
						'relation'	=> array(
							'parent'	=> 'custom_style',
							'show_when'	=> 'yes'
						),
						 
					),
					array(
						'type' 			=> 'checkbox',
						'name' 			=> 'show_icon',
						//'label' 		=> __( 'Show Icon?', 'originbuilder' ),
						'description' 	=> '',
						'options' 		=> array(
							'yes' => __('Add icon to button', 'originbuilder'),
						)
					),
					array(
						'type' 			=> 'icon_picker',
						'name'		 	=> 'icon',
						'label' 		=> __( 'Icon', 'originbuilder' ),
						'admin_label' 	=> true,
						'description' 	=> __( 'Select icon for button', 'originbuilder' ),
						'relation'		=> array(
							'parent'	=> 'show_icon',
							'show_when'	=> 'yes'
						)
					),
					array(
						'type' => 'dropdown',
						'name' => 'icon_position',
						'label' => __( 'Icon position', 'originbuilder' ),
						'description' => '',
						'options' => array(
							'left' => __('Left', 'originbuilder'),
							'center' => __('Center without text', 'originbuilder'),
							'right' => __('Right', 'originbuilder'),
						),
						'relation'		=> array(
							'parent'	=> 'show_icon',
							'show_when'	=> 'yes'
						)
					),
					/*array(
						'type'			=> 'text',
						'label'			=> __( 'Wrapper class name', 'originbuilder' ),
						'name'			=> 'wrap_class',
						'description'	=> __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' ),
					),*/
				),
				'animate' => $animate
			)
		),

		'or_video_play' => array(

			'name' => __('Video', 'originbuilder'),
			'description' => __('YouTube, Vimeo or MP4 video', 'originbuilder'),
			'icon' => 'or-icon-play',
			'category' => '',
			'css_box' => true,
			'live_editor' => $live_tmpl.'or_video_play.php',
			'tab_icons' => array(
				'general' => 'et-tools',
				'animate' => 'et-mobile'
			),
			'params' => array(
				'general' => array(
					array(
						'type' 			=> 'select',
						'name' 			=> 'source',
						'label' 		=> __( 'Source', 'originbuilder' ),
						'description' 	=> __('Select video source', 'originbuilder'),
						'options' 		=> array(
						'youtube' => __('Youtube or vimeo', 'originbuilder'),
							'upload' => __('Media library', 'originbuilder'),
							
						)
					),
					array(
						'type'			=> 'attach_media',
						'label'			=> __( 'Video upload', 'originbuilder' ),
						'name'			=> 'video_upload',
						'description'	=> __( 'Select video from media library', 'originbuilder' ),
						'admin_label'	=> true,
						'relation'		=> array(
							'parent'	=> 'source',
							'show_when' => 'upload'
						)
					),
					array(
						'type'			=> 'text',
						'label'			=> __( 'Video link', 'originbuilder' ),
						'name'			=> 'video_link',
						'description'	=> __( 'Enter the Youtube or Vimeo URL. For example: https://www.youtube.com/watch?v=VZAnXO0Y1Tg', 'originbuilder' ),
						'admin_label'	=> true,
						'value'			=> 'https://www.youtube.com/watch?v=VZAnXO0Y1Tg',
						'relation'		=> array(
							'parent'	=> 'source',
							'show_when' => 'youtube'
						)
					),
					array(
						'type'			=> 'text',
						'label'			=> __( 'Title', 'originbuilder' ),
						'name'			=> 'title',
						'description'	=> __( "Enter the video title. You can leave it blank if it's not needed", 'originbuilder' ),
					),
					array(
						'type'			=> 'textarea',
						'label'			=> __( 'Description', 'originbuilder' ),
						'name'			=> 'description',
						'description'	=> __( 'Enter video description.', 'originbuilder' ),
					),
					array(
						'type' 			=> 'checkbox',
						'name' 	=> 'full_width',
						//'label' 		=> __( 'Video Fullwidth', 'originbuilder' ),
						'description' 	=> __('Stretch the video to fit the content width.', 'originbuilder'),
						'options' 		=> array(
							'yes' => __('Full width video', 'originbuilder'),
						)
					),
					array(
						'type'			=> 'text',
						'label'			=> __( 'Video Width', 'originbuilder' ),
						'name'			=> 'video_width',
						'description'	=> __( 'Set video width.', 'originbuilder' ),
						'value'			=> 600,
						'relation'		=> array(
							'parent'	=> 'full_width',
							'hide_when' => 'yes'
						)
					),
					array(
						'type'			=> 'text',
						'label'			=> __( 'Video Height', 'originbuilder' ),
						'name'			=> 'video_height',
						'description'	=> __( 'Set video height.', 'originbuilder' ),
						'value'			=> 250,
					),
					array(
						'type' 			=> 'checkbox',
						'name' 	=> 'auto_play',
						//'label' 		=> __( 'Auto Play', 'originbuilder' ),
						'description' 	=> __('Automatically play the video on page load.', 'originbuilder'),
						'options' 		=> array(
							'yes' => __('Auto Play', 'originbuilder'),
						)
					),
					/*array(
						'type'			=> 'text',
						'label'			=> __( 'Wrapper class name', 'originbuilder' ),
						'name'			=> 'wrap_class',
						'description'	=> __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' ),
					),*/
				),
				'animate' => $animate
			)

		),
		'or_counter_box' => array(

			'name' => __('Counter Box', 'originbuilder'),
			'description' => __('Animated counter box', 'originbuilder'),
			'icon' => 'or-icon-counter',
			'category' => '',
			'live_editor' => $live_tmpl.'or_counter_box.php',
			'tab_icons' => array(
				'general' => 'et-tools',
				'animate' => 'et-mobile'
			),	
			'params'		=> array(
				'general' => array(
					array(
						'type'			=> 'text',
						'label'			=> __( 'Targeted number', 'originbuilder' ),
						'name'			=> 'number',
						'description'	=> __( 'The targeted number to count up to (From zero).', 'originbuilder' ),
						'admin_label'	=> true,
						'value'			=> '100'
					),
					array(
						'type'			=> 'text',
						'label'			=> __( 'Label', 'originbuilder' ),
						'name'			=> 'label',
						'description'	=> __( 'The text description of the counter.', 'originbuilder' ),
						'admin_label'	=> true,
						'value'			=> 'Percent number'
					),
					array(
						'type' 			=> 'checkbox',
						'name' 			=> 'label_above',
						//'label' 		=> __( 'Label above number', 'originbuilder' ),
						'description' 	=> __('Place the label above the number counting.', 'originbuilder'),
						'options' 		=> array(
							'yes' => __('Label above number', 'originbuilder'),
						)
					),
					array(
						'type'			=> 'dropdown',
						'label'			=> __( 'Style', 'originbuilder' ),
						'name'			=> 'style',
						'description'	=> __( 'Select the style to display the counter box', 'originbuilder' ),
						'options' => array(
							'1' => __( 'Style 1 (No icon)', 'originbuilder' ),
							'2' => __( 'Style 2 (Box and icon)', 'originbuilder' ),
							'3' => __( 'Style 3 (Icon & title)', 'originbuilder' )
						),
					),
					array(
						'type'			=> 'icon_picker',
						'label'			=> __( 'Icon', 'originbuilder' ),
						'name'			=> 'icon',
						'description'	=> __( 'Icon in counter box', 'originbuilder' ),
						'relation'		=> array(
							'parent'	=> 'style',
							'show_when'	=> array( '2', '3' )
						)
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Number color', 'originbuilder' ),
						'name'			=> 'number_color',
						'description'	=> __( '', 'originbuilder' ),
						 
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Label color', 'originbuilder' ),
						'name'			=> 'label_color',
						'description'	=> __( '', 'originbuilder' ),
						 
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Icon color', 'originbuilder' ),
						'name'			=> 'icon_color',
						'description'	=> __( '', 'originbuilder' ),
						 
						'relation'		=> array(
							'parent'	=> 'style',
							'show_when'	=> array( '2', '3')
						)
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Box background color', 'originbuilder' ),
						'name'			=> 'box_bg_color',
						'description'	=> __( '', 'originbuilder' ),
						'value'			=> '#d9d9d9',
						'relation'		=> array(
							'parent'	=> 'style',
							'show_when' => '2'
						)
					),
					/*array(
						'type'			=> 'text',
						'label'			=> __( 'Wrapper class name', 'originbuilder' ),
						'name'			=> 'wrap_class',
						'description'	=> __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' ),
					),*/
				),
				'animate' => $animate
			)

		),

		'or_post_type_list' => array(

			'name' => __('Post Type List', 'originbuilder'),
			'description' => __('Posts you want to show', 'originbuilder'),
			'icon' => 'or-icon-post',
			'category' => '',
			'params'		=> array(

				array(
					'type'			=> 'text',
					'label'			=> __( 'Title', 'originbuilder' ),
					'name'			=> 'title',
					'description'	=> __( 'The title of the Post Type List. Leave blank if no title is needed.', 'originbuilder' ),
					'value'			=> __( 'Recent post title', 'originbuilder' ),
					'admin_label'	=> true
				),
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Number of posts displayed', 'originbuilder' ),
					'name'			=> 'number_post',
					'description'	=> __( 'The number of posts you want to show.', 'originbuilder' ),
					'value'			=> '5',
					'admin_label'	=> true,
					'options' => array(
						'min' => 1,
						'max' => 12
					)
				),
				array(
					'type'			=> 'post_taxonomy',
					'label'			=> __( 'Content Type', 'originbuilder' ),
					'name'			=> 'post_taxonomy',
					'description'	=> __( '', 'originbuilder' ),
					'admin_label'	=> true
				),
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Order by', 'originbuilder' ),
					'name'			=> 'order_by',
					'description'	=> __( '', 'originbuilder' ),
					'admin_label'	=> true,
					'options' 		=> array(
						'ID'		=> __('Post ID', 'originbuilder'),
						'author'	=> __('Author', 'originbuilder'),
						'title'		=> __('Title', 'originbuilder'),
						'name'		=> __('Post name (post slug)', 'originbuilder'),
						'type'		=> __('Post type (available since Version 4.0)', 'originbuilder'),
						'date'		=> __('Date', 'originbuilder'),
						'modified'	=> __('Last modified date', 'originbuilder'),
						'rand'		=> __('Random order', 'originbuilder'),
						'comment_count'	=> __('Number of comments', 'originbuilder')
					)
				),
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Order post', 'originbuilder' ),
					'name'			=> 'order_list',
					'description'	=> __( '', 'originbuilder' ),
					'admin_label'	=> true,
					'options' 		=> array(
						'ASC'		=> __('ASC', 'originbuilder'),
						'DESC'		=> __('DESC', 'originbuilder'),
					)
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show thumbnail', 'originbuilder' ),
					'name'			=> 'thumbnail',
					'description'	=> __( 'Show the post thumbnail.', 'originbuilder' ),
					'options' 		=> array(
						 'yes' => __('Show thumbnail', 'originbuilder'),
					)
				),
				array(
					'type'			=> 'select',
					'label'			=> __( 'Image size', 'originbuilder' ),
					'name'			=> 'image_size',
						'options' => array(
						'thumbnail'  => __('Thumbnail', 'originbuilder'),
						'medium'  => __('Medium', 'originbuilder'),
						'large' => __('Large', 'originbuilder'),
					),
					'description'	=> __( 'Add your image size, For example: thumbnail, medium, large or full).', 'originbuilder' ),
					'value'			=> 'thumbnail',
					'relation' 	=> array(
						'parent'	=> 'thumbnail',
						'show_when'		=> 'yes'
					)
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show date', 'originbuilder' ),
					'name'			=> 'show_date',
					'description'	=> __( 'Show the date of the post.', 'originbuilder' ),
					'options' 		=> array(
						'yes' => __('Show date', 'originbuilder'),
					)
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show author', 'originbuilder' ),
					'name'			=> 'show_author',
					'description'	=> __( 'Show the author of the post.', 'originbuilder' ),
					'options' 		=> array(
						'yes' => __('Show author', 'originbuilder'),
					)
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show tags', 'originbuilder' ),
					'name'			=> 'show_tags',
					'description'	=> __( 'Show the tags of the post.', 'originbuilder' ),
					'options' 		=> array(
						'yes' => __('Show tags', 'originbuilder'),
					)
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show categories', 'originbuilder' ),
					'name'			=> 'show_category',
					'description'	=> __( 'Show the categories of the post.', 'originbuilder' ),
					'options' 		=> array(
						'yes' => __('Show categories', 'originbuilder'),
					)
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Number of words', 'originbuilder' ),
					'name'			=> 'number_word',
					'description'	=> __( 'Show a certain number of words in each post.', 'originbuilder' ),
					'value'			=> '30'
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show "Read more" button', 'originbuilder' ),
					'name'			=> 'show_button',
					'description'	=> __( 'Show the "Read more" button in the post.', 'originbuilder' ),
					'options' 		=> array(
						'yes' => __('Show "Read more" button', 'originbuilder'),
					),
					'value'			=> 'yes'
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Read more text', 'originbuilder' ),
					'name'			=> 'readmore_text',
					'description'	=> __( 'Edit the text that appears on the "Read more" button.', 'originbuilder' ),
					'relation'		=> array(
						'parent'	=> 'show_button',
						'show_when' => 'yes'
					),
					'value'			=> 'Read more'
				),
				/*array(
					'type'			=> 'text',
					'label'			=> __( 'Wrapper class name', 'originbuilder' ),
					'name'			=> 'wrap_class',
					'description'	=> __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' ),
				)*/
			)
		),
		'or_carousel_images' => array(

			'name' => __('Image Slider', 'originbuilder'),
			'description' => __('Animated Image Slider', 'originbuilder'),
			'icon' => 'or-icon-icarousel',
			'category' => '',
			'tab_icons' => array(
				'general' => 'et-tools',
				'animate' => 'et-mobile'
			),
			/*'live_editor' => $live_tmpl . 'or_carousel_images.php';*/
			'params' => array(
				'general' => array(	
					array(
						'type'			=> 'text',
						'label'			=> __( 'Title', 'originbuilder' ),
						'name'			=> 'title',
						'description'	=> __( 'The title of the Image Carousel. Leave blank if no title is needed.', 'originbuilder' ),
						'admin_label'	=> true
					),
					array(
						'type' 			=> 'attach_images',
						'label' 		=> __( 'Images', 'originbuilder' ),
						'name'			=> 'images',
						'description' 	=> __( 'Select images from media library.', 'originbuilder' ),
						'admin_label'	=> true
					),
					/*array(
						'type'        	=> 'select',
						'label'     	=> __( 'Image size', 'originbuilder' ),
						'name' 		 	=> 'img_size',
							'options' => array(
							'thumbnail'  => __('Thumbnail', 'originbuilder'),
							'medium'  => __('Medium', 'originbuilder'),
							'large' => __('Large', 'originbuilder'),
						),
						'description' 	=> __( 'Set the image size : thumbnail, medium, large or full.', 'originbuilder' ),
						'value'       	=> 'large',
					),*/
					array(
						'type'     		=> 'dropdown',
						'label'  	 	=> __( 'Onclick event', 'originbuilder' ),
						'name'			=> 'onclick',
						'options' 		=> array(
							'none' => __( 'None', 'originbuilder' ),
							'lightbox' => __( 'Open on lightbox', 'originbuilder' ),
							'custom_link' => __( 'Open custom links', 'originbuilder' )
						),
						'description'	=> __( 'Select the click event when users click on an image.', 'originbuilder' )
					),
					/*array(
						'type' 			=> 'number_slider',
						'label' 		=> __( 'Items per slide', 'originbuilder' ),
						'name' 			=> 'items_number',
						'description' 	=> __( 'The number of items displayed per slide.', 'originbuilder' ),
						'admin_label'	=> true,
						'value'			=> '3',
						'options' => array(
							'min' => 1,
							'max' => 10,
							'show_input' => true
						)
					),
					array(
						'type' 			=> 'number_slider',
						'label' 		=> __( 'Slide Width', 'originbuilder' ),
						'name' 			=> 'slidewidth',
						'description' 	=> __( 'Set slider width (in px).', 'originbuilder' ),						 
						'admin_label'	=> true,
						'options' => array(
							'min' => 200,
							'max' => 1200,
							'show_input' => true
						),
						'value' => 200
					),
					array(
						'type' 			=> 'number_slider',
						'label' 		=> __( 'Slide Height', 'originbuilder' ),
						'name' 			=> 'slideheight',
						'description' 	=> __( 'Set slider heigth (in px).', 'originbuilder' ),
						 
						'admin_label'	=> true,
						'options' => array(
							'min' => 150,
							'max' => 800,
							'show_input' => true
						),
						'value' => 150
					),*/
					array(
						'type'        	=> 'textarea',
						'label'     	=> __( 'Custom links', 'originbuilder' ),
						'name'  		=> 'custom_links1',
						'description' 	=> __( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'originbuilder' ),
						'relation'  	=> array(
							'parent'	=> 'onclick',
							'show_when' => 'custom_link1'
						)
					),
					array(
						'type'     		=> 'animate_image_preview',
						'label'  	 	=> __( 'Transition Effect', 'originbuilder' ),
						'name'			=> 'transition',
						'options' 		=> $slideranimate,
						'description'	=> __( '', 'originbuilder' )
					),
					array(
						'type' 			=> 'number_slider',
						'label' 		=> __( 'Slide Interval', 'originbuilder' ),
						'name' 			=> 'speed',
						'description' 	=> __( 'Set the speed at which auto playing sliders will transition (in second).', 'originbuilder' ),
						 
						'admin_label'	=> true,
						'options' => array(
							'min' => 1,
							'max' => 30,
							'show_input' => true
						),
						'value' => 3
					),
					array(
						'type' 			=> 'number_slider',
						'label' 		=> __( 'Slider Width', 'originbuilder' ),
						'name' 			=> 'swidth',
						'description' 	=> __( 'Set slider width (in px).', 'originbuilder' ),						 
						'admin_label'	=> true,
						'options' => array(
							'min' => 500,
							'max' => 1200,
							'show_input' => true
						),
						'value' => 600
					),
					array(
						'type' 			=> 'number_slider',
						'label' 		=> __( 'Slider Height', 'originbuilder' ),
						'name' 			=> 'sheight',
						'description' 	=> __( 'Set slider heigth (in px).', 'originbuilder' ),
						 
						'admin_label'	=> true,
						'options' => array(
							'min' => 200,
							'max' => 800,
							'show_input' => true
						),
						'value' => 300
					),
					array(
						'type'        	=> 'textarea',
						'label'     	=> __( 'Custom links', 'originbuilder' ),
						'name'  	=> 'custom_links',
						'description' 	=> __( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'originbuilder' ),
						'relation'  	=> array(
							'parent'	=> 'onclick',
							'show_when' => 'custom_link'
						)
					),
					array(
						'type'        	=> 'dropdown',
						'label'     	=> __( 'Custom link target', 'originbuilder' ),
						'name'  		=> 'custom_links_target',
						'description' 	=> __( 'Select how to open custom links.', 'originbuilder' ),
						'options'       	=> array(
							'_self' => __( 'Same window', 'originbuilder' ),
							'_blank' => __( 'New window', 'originbuilder' )
						),
						'relation'  	=> array(
							'parent'	=> 'onclick',
							'show_when' => 'custom_link'
						)
					),
					array(
						'type'			=> 'checkbox',
						//'label'			=> __( 'Show thumbnail', 'originbuilder' ),
						'name'			=> 'aspect_ratio',
						'description'	=> __( 'Aspect ratio of images', 'originbuilder' ),
						'options' 		=> array(
							'1' => __('Aspect Ratio', 'originbuilder'),
						)
					),
					array(
						'type'			=> 'checkbox',
						//'label'			=> __( 'Navigation', 'originbuilder' ),
						'name'			=> 'navigation',
						'description'	=> __( 'Display the "Next" and "Prev" buttons.', 'originbuilder' ),
						'options' 		=> array(
							'yes' => __('Navigation', 'originbuilder'),
						)
					),
					array(
						'type'			=> 'checkbox',
						//'label'			=> __( 'Pagination', 'originbuilder' ),
						'name'			=> 'pagination',
						'description'	=> __( 'Show the pagination.', 'originbuilder' ),
						'options' 		=> array(
							'yes' => __('Pagination', 'originbuilder'),
						),
						 
					),
					/*array(
						'type'			=> 'checkbox',
						//'label'			=> __( 'Auto height', 'originbuilder' ),
						'name'			=> 'auto_height',
						'description'	=> __( 'Add height to div "owl-wrapper-outer" so you can use diffrent heights on slides. Use it only for one item per page setting.', 'originbuilder' ),
						'options' 		=> array(
							'yes' => __('Auto height', 'originbuilder'),
						)
					),*/
					array(
						'type'			=> 'checkbox',
						//'label'			=> __( 'Auto Play', 'originbuilder' ),
						'name'			=> 'auto_play',
						'description'	=> __( 'The carousel automatically plays when site loaded.', 'originbuilder' ),
						'options' 		=> array(
							'yes' 		=> __('Auto Play', 'originbuilder'),
						),
						'value'			=> 'yes'
						 
					),
					/*array(
						'type'			=> 'checkbox',
						//'label'			=> __( 'Progress Bar', 'originbuilder' ),
						'name'			=> 'progress_bar',
						'description'	=> __( 'Visualize the progression of displaying photos.', 'originbuilder' ),
						'options' 		=> array(
							'yes' => __('Progress Bar', 'originbuilder'),
						)
					),*/
					array(
						'type'			=> 'checkbox',
						//'label'			=> __( 'Show thumbnail', 'originbuilder' ),
						'name'			=> 'show_thumb',
						'description'	=> __( 'Show the thumbnails in carousel.', 'originbuilder' ),
						'options' 		=> array(
							'yes' => __('Show thumbnail', 'originbuilder'),
						)
					),
					/*array(
						'type' => 'text',
						'label' => __( 'Wrapper class name', 'originbuilder' ),
						'name' => 'wrap_class',
						'description' => __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' )
					),*/
				),
				'animate' => $animate
			)

		),

		'or_carousel_post' => array(

			'name' => __('Post Slider', 'originbuilder'),
			'description' => __('Animated post slider', 'originbuilder'),
			'icon' => 'or-icon-pcarousel',
			'category' => '',
			'params' => array(

				array(
					'type'			=> 'text',
					'label'			=> __( 'Title', 'originbuilder' ),
					'name'			=> 'title',
					'description'	=> __( 'The title of the Post Carousel. Leave blank if no title is needed.', 'originbuilder' ),
					'admin_label'	=> true
				),
				array(
					'type'			=> 'post_taxonomy',
					'label'			=> __( 'Content Type', 'originbuilder' ),
					'name'			=> 'post_taxonomy',
					'description'	=> __( 'Choose supported content type such as post, custom post type, etc.', 'originbuilder' ),
				),
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Order by', 'originbuilder' ),
					'name'			=> 'order_by',
					'description'	=> __( '', 'originbuilder' ),
					'admin_label'	=> true,
					'options' 		=> array(
						'ID'		=> __('Post ID', 'originbuilder'),
						'author'	=> __('Author', 'originbuilder'),
						'title'		=> __('Title', 'originbuilder'),
						'name'		=> __('Post name (post slug)', 'originbuilder'),
						'type'		=> __('Post type (available since Version 4.0)', 'originbuilder'),
						'date'		=> __('Date', 'originbuilder'),
						'modified'	=> __('Last modified date', 'originbuilder'),
						'rand'		=> __('Random order', 'originbuilder'),
						'comment_count'	=> __('Number of comments', 'originbuilder')
					)
				),
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Order post', 'originbuilder' ),
					'name'			=> 'order_list',
					'description'	=> __( '', 'originbuilder' ),
					'admin_label'	=> true,
					'options' 		=> array(
						'ASC'		=> __('ASC', 'originbuilder'),
						'DESC'		=> __('DESC', 'originbuilder'),
					)
				),
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Number of posts displayed', 'originbuilder' ),
					'name'			=> 'number_post',
					'description'	=> __( 'The number of posts you want to show.', 'originbuilder' ),
					'value'			=> '5',
					'admin_label'	=> true,
					'options' => array(
						'min' => 1,
						'max' => 20
					)
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show thumbnail', 'originbuilder' ),
					'name'			=> 'thumbnail',
					'description'	=> __( 'Show the post thumbnail.', 'originbuilder' ),
					'options' 		=> array(
						'yes'		=> __('Show thumbnail', 'originbuilder'),
					)
				),
				array(
					'type'			=> 'select',
					'label'			=> __( 'Image size', 'originbuilder' ),
					'name'			=> 'image_size',
						'options' => array(
						'thumbnail'  => __('Thumbnail', 'originbuilder'),
						'medium'  => __('Medium', 'originbuilder'),
						'large' => __('Large', 'originbuilder'),
					),
					'description'	=> __( 'Set the image size : thumbnail, medium, large or full.', 'originbuilder' ),
					'value'			=> 'thumbnail',
					'relation' 	=> array(
						'parent'	=> 'thumbnail',
						'show_when'		=> 'yes'
					)
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show date', 'originbuilder' ),
					'name'			=> 'show_date',
					'description'	=> __( 'Show the post date.', 'originbuilder' ),
					'options' 		=> array(
						'yes' 		=> __('Show date', 'originbuilder'),
					)
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Show "Read more" button', 'originbuilder' ),
					'name'			=> 'show_button',
					'description'	=> __( 'Show "Read more" button in the post.', 'originbuilder' ),
					'options' 		=> array(
						'yes'		=> __('Show "Read more" button', 'originbuilder'),
					),
					'value'			=> 'yes'
				),
				array(
					'type' 			=> 'number_slider',
					'label' 		=> __( 'Items per slide', 'originbuilder' ),
					'name' 	=> 'items_number',
					'description' 	=> __( 'The number of items displayed per slide.', 'originbuilder' ),
					'value'			=> '3',
					'options' => array(
						'min' => 1,
						'max' => 10
					)
				),
				array(
					'type' 			=> 'number_slider',
					'label' 		=> __( 'Speed', 'originbuilder' ),
					'name' 			=> 'speed',
					'description' 	=> __( 'Set the speed at which autoplaying sliders will transition in second.', 'originbuilder' ),
					'value'			=> 500,
					'options' => array(
						'min' => 100,
						'max' => 1500,
						'show_input' => true
					)
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Navigation', 'originbuilder' ),
					'name'			=> 'navigation',
					'description'	=> __( 'Display the "Next" and "Prev" buttons.', 'originbuilder' ),
					'options' 		=> array(
						'yes'		=> __('Navigation', 'originbuilder'),
					)
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Pagination', 'originbuilder' ),
					'name'			=> 'pagination',
					'description'	=> __( 'Show the pagination.', 'originbuilder' ),
					'options' 		=> array(
						'yes' 		=> __('Pagination', 'originbuilder'),
					),
					'value'			=> 'yes'
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Auto height', 'originbuilder' ),
					'name'			=> 'auto_height',
					'description'	=> __( 'Add height to owl-wrapper-outer so you can use diffrent heights on slides. Use it only for one item per page setting.', 'originbuilder' ),
					'options' 		=> array(
						'yes' 		=> __('Auto height', 'originbuilder'),
					),
				),
				array(
					'type'			=> 'checkbox',
					//'label'			=> __( 'Auto Play', 'originbuilder' ),
					'name'			=> 'auto_play',
					'description'	=> __( 'The carousel automatically plays when site loaded.', 'originbuilder' ),
					'options' 		=> array(
						'yes' 		=> __('Auto Play', 'originbuilder'),
					),
					'value'			=> 'yes'
				),
				/*array(
					'type' => 'text',
					'label' => __( 'Wrapper class name', 'originbuilder' ),
					'name' => 'wrap_class',
					'description' => __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' )
				),*/

			)
		),

		'or_image_gallery' => array(

			'name' => __('Image Gallery', 'originbuilder'),
			'description' => __('Beautiful Image Gallery', 'originbuilder'),
			'icon' => 'or-icon-gallery',
			'category' => '',
			'tab_icons' => array(
				'general' => 'et-tools',
				'animate' => 'et-mobile'
			),	
			'params' => array(
				'general' => array(
					array(
						'type'			=> 'text',
						'label'			=> __( 'Title', 'originbuilder' ),
						'name'			=> 'title',
						'description'	=> __( 'The title of the Image Gallery. Leave blank if no title is needed.', 'originbuilder' ),
						'admin_label'	=> true
					),
					array(
						'type'			=> 'attach_images',
						'label'			=> __( 'Images', 'originbuilder' ),
						'name'			=> 'images',
						'description'	=> __( 'Upload multiple image to the carousel with the SHIFT key holding.', 'originbuilder' ),
						'admin_label'	=> true
					),
					array(
						'type'			=> 'dropdown',
						'label'			=> __( 'Gallery type', 'originbuilder' ),
						'name'			=> 'type',
						'description'	=> __( 'Select the gallery presentation type.', 'originbuilder' ),
						'options' 		=> array(
							'grid' 		=> __( 'Images grid', 'originbuilder' ),
							'slider' 	=> __( 'Slider', 'originbuilder' ),
						),
					),
					array(
						'type'			=> 'checkbox',
						//'label'			=> __( 'Image masonry', 'originbuilder' ),
						'name'			=> 'image_masonry',
						'description'	=> __( 'Masonry is a JavaScript grid layout library.', 'originbuilder' ),
						'options' 		=> array(
							'yes' 		=> __('Image masonry', 'originbuilder'),
						),
						'relation' 	=> array(
							'parent'	=> 'type',
							'show_when' => array('grid')
						)
					),
					array(
						'type'			=> 'checkbox',
						//'label'			=> __( 'Auto Play', 'originbuilder' ),
						'name'			=> 'auto_rotate',
						'description'	=> __( 'Slider automatically plays when site loaded.', 'originbuilder' ),
						'options' 		=> array(
							'yes' 		=> __('Auto Play', 'originbuilder'),
						),
						'relation' 	=> array(
							'parent'	=> 'type',
							'show_when' => array('slider')
						)
					),
					array(
						'type'			=> 'checkbox',
						//'label'			=> __( 'Navigation', 'originbuilder' ),
						'name'			=> 'navigation',
						'description'	=> __( 'Display the "Next" and "Prev" buttons.', 'originbuilder' ),
						'options' 		=> array(
							'yes' 		=> __('Navigation', 'originbuilder'),
						),
						'relation' 	=> array(
							'parent'	=> 'type',
							'show_when' => array('slider')
						)
					),
					array(
						'type'			=> 'checkbox',
						//'label'			=> __( 'Pagination', 'originbuilder' ),
						'name'			=> 'pagination',
						'description'	=> __( 'Show the pagination.', 'originbuilder' ),
						'options' 		=> array(
							'yes' 		=> __('Pagination', 'originbuilder'),
						),
						'relation' 	=> array(
							'parent'	=> 'type',
							'show_when' => array('slider')
						)
					),
					array(
						'type'			=> 'text',
						'label'			=> __( 'Slider width', 'originbuilder' ),
						'name'			=> 'slider_width',
						'description'	=> __( 'Wrapper slider width, unit (px) or (%)', 'originbuilder' ),
						'relation' 	=> array(
							'parent'	=> 'type',
							'show_when' => array('slider')
						),
						'value'			=> '400'
					),
					array(
						'type'			=> 'select',
						'label'			=> __( 'Image size', 'originbuilder' ),
						'name'			=> 'image_size',
							'options' => array(
							'thumbnail'  => __('Thumbnail', 'originbuilder'),
							'medium'  => __('Medium', 'originbuilder'),
							'large' => __('Large', 'originbuilder'),
						),
						'description'	=> __( 'Set the image size : thumbnail, medium, large or full.', 'originbuilder' ),
						'value'			=> 'full'
					),
					array(
						'type'			=> 'dropdown',
						'label'			=> __( 'Onclick event', 'originbuilder' ),
						'name'			=> 'click_action',
						'description'	=> __( 'Select the click event when users click on an image.', 'originbuilder' ),
						'options' 		=> array(
							'none' 			=> __( 'No action', 'originbuilder' ),
							'large_image' 	=> __( 'Open large image', 'originbuilder' ),
							'lightbox' 		=> __( 'Open on lightbox', 'originbuilder' ),
							'custom_link' 	=> __( 'Open on custom link', 'originbuilder' )
						),
						'relation' 	=> array(
							'parent'	=> 'type',
							'show_when' => 'grid'
						)
					),
					array(
						'type'			=> 'textarea',
						'label'			=> __( 'Custom links', 'originbuilder' ),
						'name'			=> 'custom_links',
						'description'	=> __( 'Each custom link per new line and corresponding to each image uploaded', 'originbuilder' ),
						'relation'	=> array(
							'parent'	=> 'click_action',
							'show_when'	=> 'custom_link'
						)
					),
					/*array(
						'type'			=> 'text',
						'label'			=> __( 'Wrapper class name', 'originbuilder' ),
						'name'			=> 'wrap_class',
						'description'	=> __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' ),
					),*/
				),
				'animate' => $animate
			)
		),

		'or_coundown_timer' => array(
			'name' => __('Countdown Timer', 'originbuilder'),
			'description' => __('Countdown/Scarcity Timer', 'originbuilder'),
			'icon' => 'or-icon-coundown',
			'category' => '',
			'css_box' => true,
			'tab_icons' => array(
				'general' => 'et-tools',
				'animate' => 'et-mobile'
			),	
			'params' => array(
				'general' => array(
					array(
						'type'			=> 'text',
						'label'			=> __( 'Title', 'originbuilder' ),
						'name'			=> 'title',
						'description'	=> __( 'The title of Countdown Timer. Leave blank if no title is needed.', 'originbuilder' ),
						'admin_label'	=> true
					),
					array(
						'type'			=> 'dropdown',
						'label'			=> __( 'Timer Style', 'originbuilder' ),
						'name'			=> 'timer_style',
						'options'		=> array(
							'1' => __( 'Digit and Unit Side by Side', 'originbuilder' ),
							'2' => __( 'Digit and Unit Up and Down', 'originbuilder' ),
							'3' => __( 'Custom style template', 'originbuilder' )
						),
						'description'	=> __( 'Select presentation style of the countdown timer.', 'originbuilder' ),
					),
					array(
						'type'			=> 'textarea',
						'label'			=> __( 'Custom template', 'originbuilder' ),
						'name'			=> 'custom_template',
						'description'	=> __( "For example: %D days %H:%M:%S.\n --- %Y: \"years\", %m: \"months\", %n: \"daysToMonth\", %w: \"weeks\", %d: \"daysToWeek\", %D: \"totalDays\", %H: \"hours\", %M: \"minutes\", %S: \"seconds\"", 'originbuilder' ),
						'relation'	=> array(
							'parent'	=> 'timer_style',
							'show_when'	=> '3'
						)
					),
					array(
						'type'			=> 'date_picker',
						'label'			=> __( 'Date time', 'originbuilder' ),
						'name'			=> 'datetime',
						'description'	=> __( 'Target date For Countdown.', 'originbuilder' ),
						'admin_label'	=> true
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Background color group', 'originbuilder' ),
						'name'			=> 'bgcolor_group',
						'description'	=> __( 'Set background color for each group (days, hours, minutes, seconds)', 'originbuilder' )
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Background color digit', 'originbuilder' ),
						'name'			=> 'bgcolor_digit',
						'description'	=> __( 'Set background color for digit', 'originbuilder' ),
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Text Color', 'originbuilder' ),
						'name'			=> 'text_color',
						'description'	=> __( 'Set color for timer digit text', 'originbuilder' ),
					),
					array(
						'type'			=> 'color_picker',
						'label'			=> __( 'Unit Color', 'originbuilder' ),
						'name'			=> 'unit_color',
						'description'	=> __( 'Set color of the Timer Unit text.', 'originbuilder' ),
					),
					array(
						'type'			=> 'dropdown_font',
						'label'			=> __( 'Digit Text Size', 'originbuilder' ),
						'name'			=> 'digit_text_size',
						'description'	=> __( 'Set font size of the Timer Digit Text.', 'originbuilder' ),
						'options' 		=> array( 'min_font' => '10', 'max_font' => '72')
					),
					array(
						'type'			=> 'dropdown_font',
						'label'			=> __( 'Unit Text Size', 'originbuilder' ),
						'name'			=> 'unit_text_size',
						'description'	=> __( 'Set font size of the Timer Unit text.', 'originbuilder' ),
						'options' 		=> array( 'min_font' => '10', 'max_font' => '72')
					),
					/*array(
						'type'			=> 'text',
						'label'			=> __( 'Wrapper class name', 'originbuilder' ),
						'name'			=> 'wrap_class',
						'description'	=> __( 'Custom class for wrapper of the shortcode widget.', 'originbuilder' ),
					),
					array(
						'type' 			=> 'css_editor',
						'label' 		=> __( 'CSS box', 'originbuilder' ),
						'name' 			=> 'css',
						'description'	=> __( 'Default Design Options tab on or, apply for wrapper of box', 'originbuilder' ),
						'group' 		=> __( 'Design Options', 'originbuilder' ),
					)*/
				),
				'animate' => $animate

			)
		),
		
		'or_optinform' => array(
			'name' => __('Optin Form', 'originbuilder'),
			'description' => __('Optin Form/subscriber form', 'originbuilder'),
			'icon' => 'or-icon-optin', 
			'category' => '',
			'css_box' => true,
			/*'live_editor' => $live_tmpl.'or_optinform.php',*/
			'params' => array(
				array(
					'type'			=> 'text',
					'label'			=> __( 'Title', 'originbuilder' ),
					'name'			=> 'title',
					'description'	=> __( 'Enter form title. You can leave it blank if it\'s not needed.', 'originbuilder' ),
				),
				array(
					'type' 			=> 'optin_radio',
					'label' 		=> __( 'Fields', 'originbuilder' ),
					'name' 			=> 'field_email',
					'description'	=> __( '', 'originbuilder' ),
					'options'		=> array( 'email' => 'Email' ),
					'value'			=> 'email'
				),
				array(
					'type' 			=> 'checkbox',
					'label' 		=> __( '', 'originbuilder' ),
					'name' 			=> 'field_name_ck',
					'description'	=> __( '', 'originbuilder' ),
					'options'		=> array( 'yes' => 'Name'),
					'value'			=> ''
				),
				array(
					'type' 			=> 'animate_radio',
					'label' 		=> __( '', 'originbuilder' ),
					'name' 			=> 'field_name',
					'description'	=> __( '', 'originbuilder' ),
					'relation'	=> array(
						'parent'	=> 'field_name_ck',
						'show_when'	=> 'yes'
					),
					'options'		=> array( 'name' => 'Full Name', 'separate' => 'Separate First and Last names'),
					'value'			=> ''
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Enter placeholder for email field', 'originbuilder' ),
					'name'			=> 'placeholder_email_name',
					'description'	=> __( '', 'originbuilder' ),
					'value'			=> 'Enter Your Email Address'
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Enter placeholder for full name field', 'originbuilder' ),
					'name'			=> 'placeholder_full_name',
					'description'	=> __( '', 'originbuilder' ),
					'relation'	=> array(
						'parent'	=> 'field_name',
						'show_when'	=> 'name'
					),
					'value'			=> 'Enter Your Name'
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Enter placeholder for first names field', 'originbuilder' ),
					'name'			=> 'placeholder_separate_fname',
					'description'	=> __( '', 'originbuilder' ),
					'relation'	=> array(
						'parent'	=> 'field_name',
						'show_when'	=> 'separate'
					),
					'value'			=> 'Enter Your First Name'
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Enter placeholder for last names field', 'originbuilder' ),
					'name'			=> 'placeholder_separate_lname',
					'description'	=> __( '', 'originbuilder' ),
					'relation'	=> array(
						'parent'	=> 'field_name',
						'show_when'	=> 'separate'
					),
					'value'			=> 'Enter Your Last Name'
				),
				array(
					'type' 			=> 'optin_dropdown',
					'label' 		=> __( 'Email service provider', 'originbuilder' ),
					'name' 			=> 'responder',
					'description'	=> __( 'Please make sure to select the name field if you want to use GoToWebinar.', 'originbuilder' ),
					'options'		=> $responder,
				),
				array(
					'type' 			=> 'optinlist_dropdown',
					'label' 		=> __( 'List', 'originbuilder' ),
					'name' 			=> 'list_id',
					'description'	=> __( '', 'originbuilder' ),
					'value'			=> ''
				),
				array(
					'type' 			=> 'optinlist_hidden',
					'label' 		=> __( '', 'originbuilder' ),
					'name' 			=> 'list',
					'admin_label'	=> true,
					'description'	=> __( '', 'originbuilder' ),
					'value'			=> ''
				),
				array(
					'type' 			=> 'dropdown',
					'label' 		=> __( 'Success action', 'originbuilder' ),
					'name' 			=> 'successaction',
					'description'	=> __( '', 'originbuilder' ),
					'options'		=> array( 'no' => 'Redirect to new page', 'yes' => 'Show a Thank You message'),
				),
				array(
					'type' 			=> 'textarea',
					'label' 		=> __( 'Success message', 'originbuilder' ),
					'name' 			=> 'successmsg',
					'description'	=> __( '', 'originbuilder' ),
					'value'			=> 'VGhhbmsgeW91IGZvciBzdWJzY3JpYmluZy4gUGxlYXNlIGNoZWNrIHlvdXIgZW1haWwgdG8gY29uZmlybSB5b3VyIHN1YnNjcmlwdGlvbg==',
					'relation'	=> array(
						'parent'	=> 'successaction',
						'show_when'	=> 'yes'
					)
				),
				array(
					'type' 			=> 'text',
					'label' 		=> __( 'Redirect page url', 'originbuilder' ),
					'name' 			=> 'redirecturl',
					'description'	=> __( '', 'originbuilder' ),
					'value'			=> '',
					'relation'	=> array(
						'parent'	=> 'successaction',
						'show_when'	=> 'no'
					)
				),
				array(
					'type' 			=> 'checkbox',
					'label' 		=> __( '', 'originbuilder' ),
					'name' 			=> 'new_window',
					'description'	=> __( '', 'originbuilder' ),
					'options'		=> array( 'yes' => 'Open in a new tab'),
					'relation'	=> array(
						'parent'	=> 'successaction',
						'show_when'	=> 'no'
					)
				),
				array(
					'type' 			=> 'dropdown',
					'label' 		=> __( 'Form size', 'originbuilder' ),
					'name' 			=> 'form_size',
					'description'	=> __( '', 'originbuilder' ),
					'options'		=> array( 'normal' => 'Normal', 'small' => 'Small', 'large' => 'Large' ),
					'value'			=> 'name'
				),
				array(
					'type'			=> 'text',
					'label'			=> __( 'Button text', 'originbuilder' ),
					'name'			=> 'btn_txt',
					'description'	=> __( '', 'originbuilder' ),
					'value'			=> 'Subscribe'
				),
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Form alignment', 'originbuilder' ),
					'name'			=> 'title_align',
					'description'	=> __( '', 'originbuilder' ),
					'options'		=> array(
						'left'	=> 'left',
						'right'	=> 'right',
						'center'	=> 'center'
					),
					'value'			=> 'center'
				),
				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Button background color', 'originbuilder' ),
					'name'			=> 'btn_bgclr',
					'description'	=> __( '', 'originbuilder' ),
					'value'			=> '#B64747'
				),
				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Button hover background color', 'originbuilder' ),
					'name'			=> 'btn_hover_bgclr',
					'description'	=> __( '', 'originbuilder' ),
					'value'			=> '#061912'
				),
				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Button text color', 'originbuilder' ),
					'name'			=> 'btn_clr',
					'description'	=> __( '', 'originbuilder' ),
					'value'			=> '#ffffff'
				),
				array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Button hover text color', 'originbuilder' ),
					'name'			=> 'btn_hover_clr',
					'description'	=> __( '', 'originbuilder' ),
					'value'			=> '#ffffff'
				),
				/*array(
					'type'			=> 'color_picker',
					'label'			=> __( 'Form background color', 'originbuilder' ),
					'name'			=> 'form_bg_clr',
					'description'	=> __( '', 'originbuilder' ),
					'value'			=> '#202430'
				),*/
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Form field border radius', 'originbuilder' ),
					'name'			=> 'form_border_r',
					'description'	=> __( '', 'originbuilder' ),
					'options'		=> array(
						'min'	=> 1,
						'max'	=> 100,
						'unit' => 'px',
						'show_input'=> true
					),
					'value'			=> 3
				),
				array(
					'type'			=> 'number_slider',
					'label'			=> __( 'Button border radius', 'originbuilder' ),
					'name'			=> 'btn_border_r',
					'description'	=> __( '', 'originbuilder' ),
					'options'		=> array(
						'min'	=> 1,
						'max'	=> 100,
						'unit' => 'px',
						'show_input'=> true
					),
					'value'			=> 3
				),
				/*array(
					'type' 			=> 'checkbox',
					'label' 		=> __( '', 'originbuilder' ),
					'name' 			=> 'inline',
					'description'	=> __( '', 'originbuilder' ),
					'options'		=> array( 'yes' => 'horizontal form' ),
					'value'			=> 'name'
				),*/
			)
		),
		
		'or_social' => array(
			'name' => __('Social', 'originbuilder'),
			'description' => __('Social share.', 'originbuilder'),
			'icon' => 'or-icon-social',
			'category' => '',
			'css_box' => true,
			'tab_icons' => array(
				'general' => 'et-tools',
				'animate' => 'et-mobile'
			),
			/*'live_editor' => $live_tmpl.'or_optinform.php',*/
			'params' => array(
				'general' => array(
					array(
						'type'			=> 'text',
						'label'			=> __( 'Title', 'originbuilder' ),
						'name'			=> 'sharetxt',
						'description'	=> __( 'Enter share text. You can leave it blank if it\'s not needed.', 'originbuilder' ),
					),
					array(
						'type' 			=> 'dropdown_iconpack',
						'label' 		=> __( 'Icon pack design', 'originbuilder' ),
						'name' 			=> 'icondesign',
						'description'	=> '',
						'options'		=> array( 
							'big' => 'Big',
							'blocks' => 'Blocks',
							'circles' => 'Rounded',
							'dark' => 'Dark',
							'flat' => 'Flat',
							'grey_blocks' => 'Grey Blocks',
							'grey_circles' => 'Grey Circles',
							'light' => 'Light',
							'metro' => 'Metro',
							'modern' => 'Modern',
							'round' => 'Round',
							'tiny' => 'Tiny',
							'vertical2' => 'vertical',
							'vertical1' => 'vertical Box',
							/*'01' => 'square rounded', 
							'05' => 'square', 
							'02' => 'circle', 
							'03' => 'with full name', 
							'07' => 'shadow' */
						),
						'value'			=> 'big'
					),
					array(
						'type' 			=> 'dragdrop',
						'label' 		=> __( 'Social network', 'originbuilder' ),
						'name' 			=> 'network',
						'description'	=> __( '', 'originbuilder' ),
						'options'		=> array('facebook'=>'facebook', 'twitter'=>'twitter', 'linkedin'=>'linkedin', 'google-plus'=>'google-plus', 'pinterest'=> 'pinterest', 'print'=>'print', 'reddit'=>'reddit', 'stumbleupon'=>'stumbleupon', 'tumblr'=>'tumblr', 'vk'=>'vk', 'skype'=>'skype', 'pocket'=>'pocket'),
					),
					array(
						'type'			=> 'checkbox',
						'label'			=> __( '', 'originbuilder' ),
						'name'			=> 'showcount',
						'description'	=> __( 'This option willn\'t work for print, skype and pocket.', 'originbuilder' ),
						'options'		=> array( 'yes' => 'Show share count' )
					),
					array(
						'type'			=> 'checkbox',
						'label'			=> __( '', 'originbuilder' ),
						'name'			=> 'showcountonhover',
						'description'	=> __( '', 'originbuilder' ),
						'relation'	=> array(
							'parent'	=> 'showcount',
							'show_when'	=> 'yes'
						),
						'options'		=> array( 'yes' => 'Show only on hover' )
					),
					array(
						'type'			=> 'colorcheckbox',
						'label'			=> __( '', 'originbuilder' ),
						'name'			=> 'chngcolor',
						'description'	=> __( '', 'originbuilder' ),
						'options'		=> array( 'yes' => 'Override icon pack default color.' )
					),
					array(
						'name' => 'color',
						'label' => 'Icon Color',
						'type' => 'colorpicker',
						'target' => 'or_drageble_area',
						'relation'	=> array(
							'parent'	=> 'chngcolor',
							'show_when'	=> 'yes'
						),
						'description' => 'Change icon color.'
					),
					/*array(
						'type' 			=> 'dropdown',
						'label' 		=> __( 'After share action', 'originbuilder' ),
						'name' 			=> 'shareaction',
						'description'	=> '',
						'options'		=> array( '0' => 'Do nothing', '1' => 'Open a new URL' ),
					),
					array(
						'type'			=> 'text',
						'label'			=> __( 'Enter URL', 'originbuilder' ),
						'name'			=> 'url',
						'description'	=> __( 'Integrate a social app <a href="'.admin_url('options-general.php?page=originbuilder').'" target="_blank">Click here</a>', 'originbuilder' ),
						'relation'	=> array(
							'parent'	=> 'shareaction',
							'show_when'	=> '1'
						),
					),*/
				),
				'animate' => array(
					array(
						'name' => 'animateswitch',
						'label' => __( 'Animate Element', 'originbuilder' ),
						'type' => 'animate_radio',
						'options' => array(
							'yes' => 'ON',
							'no' => 'OFF'
						),
						'value' => 'no',
						'description' => __( '', 'originbuilder' )
					),
					array(
						'name' => 'animateeffect',
						'label' => __( 'Effect', 'originbuilder' ),
						'type' => 'animate_preview',
						'options' => $animate_arr,
						'description' => __( '', 'originbuilder' )
					),
				)
			)
		)

	)

);

