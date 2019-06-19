<?php

$output = $thumb_data = $css = $speed = $animateevent = $animateeffect = $transition = '';
$swidth = 600;
$sheight = 300;
$animateswitch = 'no';
$image_size = 'full';
$onclick = 'none';

$slider_transition = array(
	'{$Duration:1200,$Opacity:2}',
	'{$Duration:1200,x:0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2}',
	'{$Duration:1200,x:-0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2}',
	'{$Duration:1200,y:-0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2}',
	'{$Duration:1000,$Zoom:11,$Easing:{$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2}',
	'{$Duration:1200,x:0.6,$Zoom:1,$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2}',
	'{$Duration:1000,x:-4,$Zoom:11,$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2,$Round:{$Top:2.5}}',
	'{$Duration:1000,y:4,$Zoom:11,$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2}',
	'{$Duration:1200,y:0.6,$Zoom:1,$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2}',
	'{$Duration:1000,y:-4,$Zoom:11,$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2}',
	'{$Duration:1200,y:-0.6,$Zoom:1,$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2}',
	'{$Duration:700,$Opacity:2,$Brother:{$Duration:1000,$Opacity:2}}',
	'{$Duration:1400,x:0.25,$Zoom:1.5,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Zoom:$JssorEasing$.$EaseInSine},$Opacity:2,$ZIndex:-10,$Brother:{$Duration:1400,x:-0.25,$Zoom:1.5,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Zoom:$JssorEasing$.$EaseInSine},$Opacity:2,$ZIndex:-10}}',
	'{$Duration:1200,y:1,$Easing:{$Top:$JssorEasing$.$EaseInOutQuart,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2,$Brother:{$Duration:1200,y:-1,$Easing:{$Top:$JssorEasing$.$EaseInOutQuart,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2}}',
	'{$Duration:1200,x:1,$Easing:{$Left:$JssorEasing$.$EaseInOutQuart,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2,$Brother:{$Duration:1200,x:-1,$Easing:{$Left:$JssorEasing$.$EaseInOutQuart,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2}}',
	'{$Duration:1600,x:-0.2,$Delay:40,$Cols:12,$During:{$Left:[0.4,0.6]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInOutExpo,$Opacity:$JssorEasing$.$EaseInOutQuad},$Opacity:2,$Outside:true,$Round:{$Top:0.5},$Brother:{$Duration:1000,x:0.2,$Delay:40,$Cols:12,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:1028,$Easing:{$Left:$JssorEasing$.$EaseInOutExpo,$Opacity:$JssorEasing$.$EaseInOutQuad},$Opacity:2,$Round:{$Top:0.5}}}',
	'{$Duration:1200,$Zoom:11,$Rotate:1,$Easing:{$Opacity:$JssorEasing$.$EaseLinear,$Rotate:$JssorEasing$.$EaseInQuad},$Opacity:2,$Round:{$Rotate:1},$ZIndex:-10,$Brother:{$Duration:1200,$Zoom:11,$Rotate:-1,$Easing:{$Opacity:$JssorEasing$.$EaseLinear,$Rotate:$JssorEasing$.$EaseInQuad},$Opacity:2,$Round:{$Rotate:1},$ZIndex:-10,$Shift:600}}',
	'{$Duration:1200,$Zoom:11,$Rotate:-1,$Easing:{$Zoom:$JssorEasing$.$EaseInQuad,$Opacity:$JssorEasing$.$EaseLinear,$Rotate:$JssorEasing$.$EaseInQuad},$Opacity:2,$Round:{$Rotate:0.5},$Brother:{$Duration:1200,$Zoom:1,$Rotate:1,$Easing:$JssorEasing$.$EaseSwing,$Opacity:2,$Round:{$Rotate:0.5},$Shift:90}}'
);

wp_enqueue_script('jssor.slider.mini');
wp_enqueue_script('slideshow-transition.min');
wp_enqueue_style('jssor-slider');

extract( $atts );

$items_number = (!empty($items_number)) ? $items_number : 1;

if( !empty( $images ) ){
	$images = explode( ',', $images );
}

if ( is_array( $images ) && !empty( $images ) ) {

	foreach($images as $image_id){
		$attachment_data[] = wp_get_attachment_image_src( $image_id, $image_size );
		$attachment_data_thumb[] = wp_get_attachment_image_src( $image_id, 'thumbnail' );
		$attachment_data_full[] = wp_get_attachment_image_src( $image_id, 'full' );
	}

}else{
	echo '<div class="or-carousel_images align-center" style="border:1px dashed #ccc;"><br /><h3>Carousel Images: '.__( 'No images upload', 'originbuilder' ).'</h3></div>';
	return;
}

$element_attribute = array();

$el_classes = array(
	'or_slider_container_jssor'
);

$rand = rand();

if( $css != '' )$el_classes[] = $css;

$element_attribute[] = 'class="'. esc_attr( implode( ' ', $el_classes ) ) .'"';
$element_attribute[] = 'id="or_jssor'.$rand.'"';
 
if( 'custom_link' === $onclick && !empty( $custom_links ) ){
	$custom_links = preg_replace('/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $custom_links)));
	$custom_links_arr = explode("\n", $custom_links);
}

ob_start();

if(!empty($title)){
	echo '<h3 class="or-title image-gallery-title">'. esc_html($title) .'</div>';
}

$fillmode = ( $atts['aspect_ratio'] )? ( $atts['aspect_ratio'] ) : '0';
?>
<script type='text/javascript'>
	jQuery(document).ready(function ($) {
		var _SlideshowTransitions = [<?php echo $slider_transition[($transition == '' ? 0 : $transition )]; ?>];
		console.log(_SlideshowTransitions);
		var _CaptionTransitions = [];
		var options = {
			$FillMode: <?php echo $fillmode; ?>,
			$AutoPlay: <?php echo ($auto_play == 'yes' ? 1 : 0); ?>,
			$AutoPlayInterval: <?php echo ($speed*1000); ?>,
			$SlideshowOptions: {											
				$Class: $JssorSlideshowRunner$,
				$Transitions: _SlideshowTransitions,
				$TransitionsOrder: 1,
				$ShowLink: true														
			},
			
			<?php if($navigation == 'yes' || $show_thumb == 'yes'){ ?>
			$ArrowNavigatorOptions: {       
				$Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
				$ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
				$AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
				$Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
			},
			<?php } ?>
			
			<?php if($pagination == 'yes'){ ?>
			$BulletNavigatorOptions: {            
				$Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
				$ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
				$ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
				$AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
				$Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
				$Rows: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
				$SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
				$SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
				$Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
			},
			<?php } ?>
			
			<?php if($show_thumb == 'yes'){ ?>
			$ThumbnailNavigatorOptions: {
				$Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
				$ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

				$Loop: 1,                                       //[Optional] Enable loop(circular) of carousel or not, 0: stop, 1: loop, 2 rewind, default value is 1
				$SpacingX: 3,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
				$SpacingY: 3,                                   //[Optional] Vertical space between each thumbnail in pixel, default value is 0
				$Cols: 4,                              //[Optional] Number of pieces to display, default value is 1
				$ParkingPosition: 50,                          //[Optional] The offset position to park thumbnail,

				$ArrowNavigatorOptions: {
					$Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
					$ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
					$AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
					$Steps: 4                                       //[Optional] Steps to go for each navigation request, default value is 1
				},
				
				
			},
			<?php } ?>
		};
		
		var jssor_slider<?php echo $rand; ?> = new $JssorSlider$(<?php echo 'or_jssor'.$rand; ?>, options);
		
	});
</script>

<div <?php echo implode( ' ', $element_attribute ); ?> style="width:<?php echo $swidth; ?>px; height:<?php echo $sheight; ?>px;position: relative;">
	<div u="slides" class="jssor_slider_slides" style="width:<?php echo $swidth; ?>px; height:<?php echo $sheight; ?>px ;cursor: move; position: absolute;top:0px;left:0px;overflow:hidden;">
		<?php foreach($attachment_data as $i => $image): ?>

			<div>

			<?php if( 'none' === $onclick ): ?>
				<img src="<?php echo $image[0]; ?>" u="image" />
			<?php else:

				switch( $onclick ){

					case 'lightbox':
						echo '<a class="or-image-link" data-lightbox="or-lightbox" rel="prettyPhoto" href="'. esc_attr( esc_attr( $attachment_data_full[$i][0] ) ) .'">'
							.'<img src="'. esc_attr($image[0]) .'" /></a>';
						break;

					case 'custom_link':
						if(isset($custom_links_arr[$i])){
							echo '<a href="'. esc_attr( strip_tags($custom_links_arr[$i]) ) .'" target="'. esc_attr($custom_links_target) .'">'
								.'<img src="'. esc_attr($image[0]) .'" /></a>';
						}else{
							echo '<img src="'. esc_attr($image[0]) .'" />';
						}

						break;

				}

			endif; ?>
				
				 <img u="thumb" src="<?php echo $attachment_data_thumb[$i][0]; ?>" />

			</div>

		<?php endforeach; ?>
	</div>
	
	<?php if($navigation == 'yes'){ ?>
		<style>
			/* jssor slider arrow navigator skin 03 css */
			/*
			.jssora03l                  (normal)
			.jssora03r                  (normal)
			.jssora03l:hover            (normal mouseover)
			.jssora03r:hover            (normal mouseover)
			.jssora03l.jssora03ldn      (mousedown)
			.jssora03r.jssora03rdn      (mousedown)
			*/
			.jssora03l, .jssora03r {
				display: block;
				position: absolute;
				/* size of arrow element */
				width: 55px;
				height: 55px;
				cursor: pointer;
				background: url(<?php echo or_URL.'/assets/images/'; ?>a03.png) no-repeat;
				overflow: hidden;
			}
			.jssora03l { background-position: -3px -33px; }
			.jssora03r { background-position: -63px -33px; }
			.jssora03l:hover { background-position: -123px -33px; }
			.jssora03r:hover { background-position: -183px -33px; }
			.jssora03l.jssora03ldn { background-position: -243px -33px; }
			.jssora03r.jssora03rdn { background-position: -303px -33px; }
		</style>
		<!-- Arrow Left -->
		<span u="arrowleft" class="jssora03l" style="top: 123px; left: 8px;">
		</span>
		<!-- Arrow Right -->
		<span u="arrowright" class="jssora03r" style="top: 123px; right: 8px;">
		</span>
	<?php } ?>
	
	<?php if($pagination == 'yes'){ ?>
		<style>
		/* jssor slider bullet navigator skin 03 css */
		/*
		.jssorb03 div           (normal)
		.jssorb03 div:hover     (normal mouseover)
		.jssorb03 .av           (active)
		.jssorb03 .av:hover     (active mouseover)
		.jssorb03 .dn           (mousedown)
		*/
		.jssorb03 {
			position: absolute;
		}
		.jssorb03 div, .jssorb03 div:hover, .jssorb03 .av {
			position: absolute;
			/* size of bullet elment */
			width: 21px;
			height: 21px;
			text-align: center;
			line-height: 21px;
			color: white;
			font-size: 12px;
			background: url(<?php echo or_URL.'/assets/images/'; ?>b03.png) no-repeat;
			overflow: hidden;
			cursor: pointer;
		}
		.jssorb03 div { background-position: -5px -4px; }
		.jssorb03 div:hover, .jssorb03 .av:hover { background-position: -35px -4px; }
		.jssorb03 .av { background-position: -65px -4px; }
		.jssorb03 .dn, .jssorb03 .dn:hover { background-position: -95px -4px; }
		</style>
		<div u="navigator" class="jssorb03" style="bottom: 16px; right: 6px;">
            <!-- bullet navigator item prototype -->
            <div u="prototype"><div u="numbertemplate"></div></div>
        </div>
	<?php } ?>
	
	<?php if($show_thumb == 'yes'){ ?>
		<style>
		/* jssor slider thumbnail navigator skin 07 css */
		/*
		.jssort07 .p            (normal)
		.jssort07 .p:hover      (normal mouseover)
		.jssort07 .pav          (active)
		.jssort07 .pav:hover    (active mouseover)
		.jssort07 .pdn          (mousedown)
		*/
		.jssort07 {
			position: absolute;
			/* size of thumbnail navigator container */
			width: 800px;
			height: 100px;
		}

			.jssort07 .p {
				position: absolute;
				top: 0;
				left: 0;
				width: 99px;
				height: 66px;
			}

			.jssort07 .i {
				position: absolute;
				top: 0px;
				left: 0px;
				width: 99px;
				height: 66px;
				filter: alpha(opacity=80);
				opacity: .8;
			}

			.jssort07 .p:hover .i, .jssort07 .pav .i {
				filter: alpha(opacity=100);
				opacity: 1;
			}

			.jssort07 .o {
				position: absolute;
				top: 0px;
				left: 0px;
				width: 97px;
				height: 64px;
				border: 1px solid #000;
				box-sizing: content-box;
				transition: border-color .6s;
				-moz-transition: border-color .6s;
				-webkit-transition: border-color .6s;
				-o-transition: border-color .6s;
			}

			.jssort07 .pav .o {
				border-color: #0099ff;
			}

			.jssort07 .p:hover .o {
				border-color: #fff;
				transition: none;
				-moz-transition: none;
				-webkit-transition: none;
				-o-transition: none;
			}

			.jssort07 .p.pdn .o {
				border-color: #0099ff;
			}

			* html .jssort07 .o {
				/* ie quirks mode adjust */
				width /**/: 99px;
				height /**/: 66px;
			}
		</style>
		<div u="thumbnavigator" class="jssort07" style="width: 500px; height: 100px; left: 0px; bottom: 0px;">
            <!-- Thumbnail Item Skin Begin -->
            <div u="slides" style="cursor: default;">
                <div u="prototype" class="p">
                    <div u="thumbnailtemplate" class="i"></div>
                    <div class="o"></div>
                </div>
            </div>
            <!-- Thumbnail Item Skin End -->
            <!--#region Arrow Navigator Skin Begin -->
            <!-- Help: http://www.jssor.com/tutorial/set-arrow-navigator.html -->
            <style>
                /* jssor slider arrow navigator skin 11 css */
                /*
                .jssora11l                  (normal)
                .jssora11r                  (normal)
                .jssora11l:hover            (normal mouseover)
                .jssora11r:hover            (normal mouseover)
                .jssora11l.jssora11ldn      (mousedown)
                .jssora11r.jssora11rdn      (mousedown)
                */
                .jssora11l, .jssora11r {
                    display: block;
                    position: absolute;
                    /* size of arrow element */
                    width: 37px;
                    height: 37px;
                    cursor: pointer;
                    background: url(<?php echo or_URL.'/assets/images/'; ?>a11.png) no-repeat;
                    overflow: hidden;
                }

                .jssora11l {
                    background-position: -11px -41px;
                }

                .jssora11r {
                    background-position: -71px -41px;
                }

                .jssora11l:hover {
                    background-position: -131px -41px;
                }

                .jssora11r:hover {
                    background-position: -191px -41px;
                }

                .jssora11l.jssora11ldn {
                    background-position: -251px -41px;
                }

                .jssora11r.jssora11rdn {
                    background-position: -311px -41px;
                }
            </style>
            <!-- Arrow Left -->
            <span u="arrowleft" class="jssora11l" style="top: 123px; left: 8px;">
            </span>
            <!-- Arrow Right -->
            <span u="arrowright" class="jssora11r" style="top: 123px; right: 8px;">
            </span>
            <!--#endregion Arrow Navigator Skin End -->
        </div>
	<?php } ?>
	
</div>


<?php
$output = ob_get_clean();

//$output = '<div class="or-carousel_images">'.$output.'</div>';

$effect = 'animated '.$animateeffect;

if($animateswitch == 'yes'){
	if($animateevent == 'onload'){
		$output = "<div class='wow ".$effect."' data-wow-duration='1s' data-wow-delay='0.5s'>".$output."</div>";
	}else{
		$output = "<div ".($animateevent == 'onclick' ? "onClick='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '')." ".($animateevent == 'onhover' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '').">".$output."</div>";
	}
}

echo $output;