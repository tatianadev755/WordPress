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

//Cache

foreach(

	array(
		'text' => 'or_param_type_text',
		'optinlist_hidden' => 'or_param_type_optinlist_hidden',
		'hidden' => 'or_param_type_hidden',
		'textarea' => 'or_param_type_textarea_raw_html',
		'select' => 'or_param_type_select',
		'dropdown' => 'or_param_type_select',
		'dropdown_font' => 'or_param_type_select_font',
		'textarea_html' => 'or_param_type_textarea_html',
		'editor' => 'or_param_type_editor',
		'multiple' => 'or_param_type_multiple',
		'checkbox' => 'or_param_type_checkbox',
		'colorcheckbox' => 'or_param_type_colorcheckbox',
		'radio' => 'or_param_type_radio',
		'animate_radio' => 'or_param_type_animate_radio',
		'attach_media' => 'or_param_type_attach_media',
		'attach_image' => 'or_param_type_attach_image',
		'attach_image_url' => 'or_param_type_attach_image_url',
		'attach_images' => 'or_param_type_attach_images',
		'color_picker' => 'or_param_type_color_picker',
		'colorpicker' => 'or_param_type_colorpicker',
		'icon_picker' => 'or_param_type_icon_picker',
		'date_picker' => 'or_param_type_date_picker',
		'or_box' => 'or_param_type_or_box',
		'wp_widget' => 'or_param_type_wp_widget',
		'css_box_tbtl' => 'or_param_type_css_box_tbtl',
		'css_box_border' => 'or_param_type_css_box_border',
		'group' => 'or_param_type_group',
		'link' => 'or_param_type_link',
		'autocomplete' => 'or_param_type_autocomplete',
		'number_slider' => 'or_param_type_number_slider',
		'random' => 'or_param_type_random',
		'animate_preview' => 'or_param_type_animate_preview',
		'animate_image_preview' => 'or_param_type_animate_image_preview',
		'optin_radio' => 'or_param_type_optin_radio',
		'optin_dropdown' => 'or_param_type_optin_select',
		'optinlist_dropdown' => 'or_param_type_optinlist_select',
		'dragdrop'	=> 'or_param_type_dragdrop',
		'dropdown_iconpack'	=> 'or_param_type_dropdown_iconpack',
	) as $name => $func ){

	$or->add_param_type_cache( $name, $func );
	
}

// Nocache

foreach(

	array(
		'post_taxonomy' => 'or_param_type_post_taxonomy',
	) as $name => $func ){

	$or->add_param_type( $name, $func );
	
}

function or_param_type_text(){
	echo '<input name="{{data.name}}" class="or-param" value="{{data.value}}" type="text" />';
}

function or_param_type_hidden(){
	echo '<input name="{{data.name}}" class="or-param" value="{{data.value}}" type="hidden" />';
}

function or_param_type_textarea_raw_html(){
?>
	<textarea cols="46" rows="8" class="or-row-area or-param">{{or.tools.base64.decode(data.value) }}</textarea>

	<!--For instant saving, dont change to base64-->
	<textarea name="{{data.name}}"  style="display:none;"class="or-param">{{or.tools.base64.decode( data.value.replace(/(?:\r\n|\r|\n)/g,'') )}}</textarea>
	<#

		data.callback = function( wrp, $ ){
			var pop = wrp.closest('.or-params-popup');
			or.tools.popup.callback( pop, { 
				before_callback : function( pop ){
					
					pop.find('textarea.or-row-area').each(function(){
						$(this).parent().find( 'textarea.or-param' ).val( or.tools.base64.encode( this.value ) );
					  $(this).val( or.tools.base64.decode( this.value)  );
					}); 
				}
			});
		}

	#>
<?php
}

function or_param_type_select(){
?>
		<select class="or-param" name="{{data.name}}">
			<# if( data.options ){
				for( var n in data.options ){
					if( typeof data.options[n] == 'array' ||  typeof data.options[n] == 'object' ){
					#><optgroup label="{{n}}"><#
						for( var m in data.options[n] ){
							#><option<#
								if( m == data.value ){ #> selected<# }
								#> value="{{m}}">{{data.options[n][m]}}</option><#
						}
					#></optgroup><#

					}else{

			#><option<#
						if( n == data.value ){ #> selected<# }
					#> value="{{n}}">{{data.options[n]}}</option><#
					}
				}
			} #>
		</select>
<?php
}

function or_param_type_select_font(){
?>
		<select class="or-param" name="{{data.name}}">
			<#  if( data.options ){
				var i = data.options['min_font'], max = data.options['max_font'];
				console.log(i + ' ' + max);
				for( ; i <= max; i++ ){
			#><option<# if( i == data.value ){ #> selected<# }
					#> value="{{i}}">{{i}}px</option><#
				}
			} #>
		</select>
<?php
}

function or_param_type_textarea_html(){
?>
	<# var eid = parseInt( Math.random()*100000 ); #>

	<div class="or-textarea_html-field-wrp">
		<div class="or-editor-wrapper">
            <div id="wp-or-content-{{eid}}-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                <div id="wp-or-content-{{eid}}-editor-tools" class="wp-editor-tools hide-if-no-js">
                    <div id="wp-or-content-{{eid}}-media-buttons" class="wp-media-buttons">
                        <button type="button" class="button or-insert-media" data-editor="or-content-{{eid}}">
                        	<i class="sl-cloud-upload"></i> <?php _e('Insert Media', 'originbuilder'); ?>
                        </button>
                    </div>
                    <div class="wp-editor-tabs">
                        <button type="button" class="wp-switch-editor switch-tmce" data-wp-editor-id="or-content-{{eid}}"><?php _e('Visual', 'originbuilder'); ?></button>
                        <button type="button" class="wp-switch-editor switch-html" data-wp-editor-id="or-content-{{eid}}"><?php _e('Text', 'originbuilder'); ?></button>
                    </div>
                </div>
                <div id="wp-or-content-{{eid}}-editor-container" class="wp-editor-container">
                    <div id="qt_or-content-{{eid}}_toolbar" class="quicktags-toolbar"></div>
                    <textarea class="wp-editor-area or-param" rows="10" autocomplete="off" width="100%" name="{{data.name}}" id="or-content-{{eid}}">{{data.value}}</textarea>
                </div>
            </div>
        </div>
	</div>
	<#
		data.callback = function( wrp, $ ){

			or.tools.editor.init( $('#or-content-'+eid) );

			var pop = wrp.closest('.or-params-popup');
			or.tools.popup.callback( pop, { 
				before_callback : function( pop ){
	
					if( pop.find('.wp-editor-wrap').hasClass('tmce-active') )
						pop.find('textarea.or-param').val( tinyMCE.activeEditor.getContent() );
	
				}
			});

			wrp.find('.or-insert-media').on('click', { callback : function( atts ){
				or.tools.editor.insert( window.wpActiveEditor ,wp.media.string.image( atts ) );

			}, atts : {frame:'post'} }, or.tools.media.open );

		}
	#>

<?php
}

function or_param_type_editor(){
?>
	<# var eid = parseInt( Math.random()*100000 ); #>

	<div class="or-textarea_html-field-wrp">
		<div class="or-editor-wrapper">
            <div id="wp-or-content-{{eid}}-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                <div id="wp-or-content-{{eid}}-editor-tools" class="wp-editor-tools hide-if-no-js">
                    <div id="wp-or-content-{{eid}}-media-buttons" class="wp-media-buttons">
                        <button type="button" class="button or-insert-media" data-editor="or-content-{{eid}}">
                        	<i class="sl-cloud-upload"></i> <?php _e('Insert Media', 'originbuilder'); ?>
                        </button>
                    </div>
                    <div class="wp-editor-tabs">
                        <button type="button" class="wp-switch-editor switch-tmce" data-wp-editor-id="or-content-{{eid}}"><?php _e('Visual', 'originbuilder'); ?></button>
                        <button type="button" class="wp-switch-editor switch-html" data-wp-editor-id="or-content-{{eid}}"><?php _e('Text', 'originbuilder'); ?></button>
                    </div>
                </div>
                <div id="wp-or-content-{{eid}}-editor-container" class="wp-editor-container">
                    <div id="qt_or-content-{{eid}}_toolbar" class="quicktags-toolbar"></div>
                    <textarea class="wp-editor-area or-param" rows="10" autocomplete="off" width="100%" name="{{data.name}}" id="or-content-{{eid}}">{{or.tools.base64.decode(data.value.replace(/(?:\r\n|\r|\n)/g,'')).replace(/\%SITE\_URL\%/g,site_url)}}</textarea>
                </div>
            </div>
        </div>
	</div>
	<#
		data.callback = function( wrp, $ ){

			or.tools.editor.init( $('#or-content-'+eid) );

			var pop = wrp.closest('.or-params-popup');
			or.tools.popup.callback( pop, { 
				before_callback : function( pop ){
	
					pop.find('.wp-editor-wrap').each(function(){
						if( $(this).hasClass('tmce-active') ){
							var txt = $(this).find('textarea.or-param'), id = txt.get(0).id, 
								content = tinyMCE.get( id ).getContent(), rex = new RegExp( site_url, "g");
							content = content.replace( rex, '%SITE_URL%' );
							txt.val( or.tools.base64.encode( content ) );
						}
					});
	
				}
			});

			wrp.find('.or-insert-media').on('click', { callback : function( atts ){

				or.tools.editor.insert( window.wpActiveEditor ,wp.media.string.image( null, atts ) );

			}, atts : {frame:'post'} }, or.tools.media.open );

		}
	#>

<?php
}

function or_param_type_multiple(){
?>

	<div or-multiple-field-wrp>
		<select multiple>
			<# if( data.options ){
				var vals = data.value.split(',');
				for( var n in data.options ){
					if( typeof data.options[n] == 'array' ||  typeof data.options[n] == 'object' ){
					#><optgroup label="{{n}}"><#
						for( var m in data.options[n] ){
							#><option<#
								if( vals.indexOf( m ) > -1 ){ #> selected<# }
								#> value="{{m}}">{{data.options[n][m]}}</option><#
						}
					#></optgroup><#

					}else{

			#><option<#
						if( vals.indexOf( n ) > -1 ){ #> selected<# }
					#> value="{{n}}">{{data.options[n]}}</option><#
					}
				}
			} #>
		</select>
		<input type="hidden" name="{{data.name}}" class="or-param" value="{{data.value}}" />
		<a href="#" class="clear-selected">
			<i class="sl-close"></i> <?php _e('Remove Selection', 'originbuilder'); ?>
		</a>
	</div>
	<#
		data.callback = function( el ){
			el.find('select').on( 'change', el, function(e){
				e.data.find('input.or-param').val( jQuery(this).val() );
			});
			el.find('.clear-selected').on( 'click', el, function(e){
				e.data.find('select option:selected').removeAttr('selected');
				e.data.find('input.or-param').val('');
				e.preventDefault();
			});
		}
	#>
<?php
}

function or_param_type_checkbox(){
?>

	<# if( data.options ){
		var vals = data.value.split(',');
		for( var n in data.options ){
			#><span class="nowrap">
			<div class="checkbox checkbox1 abs">
       <label>
        <input type="checkbox" class="or-param" name="{{data.name}}" <#
				if( vals.indexOf( n ) > -1 ){ #> checked<# }
			#> value="{{n}}" /> {{data.options[n]}}
         <span> </span>
        </label>
      </div>
	  
	  </span>
		<# }
	} #><input type="checkbox" checked class="or-param" value="" name="{{data.name}}" style="display:none;" />
<?php
}

function or_param_type_colorcheckbox(){
?>

	<# if( data.options ){
		var vals = data.value.split(',');
		for( var n in data.options ){
			#><span class="nowrap">
			<div class="checkbox checkbox1 abs">
       <label>
        <input type="checkbox" class="or-param" id="or_check_checkbox" name="{{data.name}}" <#
				if( vals.indexOf( n ) > -1 ){ #> checked<# }
			#> value="{{n}}" /> {{data.options[n]}}
         <span> </span>
        </label>
      </div>
	  
	  </span>
		<# }
	} #><input type="checkbox" checked class="or-param" value="" name="{{data.name}}" style="display:none;" />	
	<#
		data.callback = function( el ){
			el.find('input[type=checkbox]').on( 'click', el, function(e){
				if(jQuery(this).is(':checked')){
					jQuery('.or_drageble_area .or_svg .path').css({'fill':jQuery('.or_drageble_area_color').val()});
				}else{
					jQuery('.or_drageble_area .or_svg .path').css({'fill':''});
				}
			});
		}
	#>
<?php
}

function or_param_type_radio(){
?>
	<div or-multiple-field-wrp>
		<# if( data.options ){
			for( var n in data.options ){
				#><span class="nowrap"><input type="radio" class="or-param" name="{{data.name}}" <#
					if( n == data.value ){ #> checked<# }
				#> value="{{n}}" /> {{data.options[n]}}</span>
			<# } #>
			<a href="#" class="clear-selected">
				<i class="sl-close"></i> <?php _e('Remove Selection', 'originbuilder'); ?>
			</a>
		<# } #><input type="radio" class="or-param empty-value" value="" name="{{data.name}}" style="display:none;" />
	</div>
	<#
		data.callback = function( el ){
			el.find('.clear-selected').on( 'click', el, function(e){
				e.data.find('input.or-param.empty-value').attr({'checked':true});
				e.preventDefault();
			});
		}
	#>
<?php
}

function or_param_type_animate_radio(){
?>
	<div or-multiple-field-wrp>
		<# if( data.options ){
			for( var n in data.options ){
				#><span class="nowrap"><input type="radio" class="or-param" name="{{data.name}}" <#
					if( n == data.value ){ #> checked<# }
				#> value="{{n}}" /> {{data.options[n]}}</span>
			<# } #>
		<# } #><input type="radio" class="or-param empty-value" value="" name="{{data.name}}" style="display:none;" />
	</div>
<?php
}

function or_param_type_animate_preview(){
	?>
	<select class="or-param play_animate_select" name="{{data.name}}">
		<# if( data.options ){
			for( var n in data.options ){
				if( typeof data.options[n] == 'array' ||  typeof data.options[n] == 'object' ){
				#><optgroup label="{{n}}"><#
					for( var m in data.options[n] ){
						#><option<#
							if( m == data.value ){ #> selected<# }
							#> value="{{m}}">{{data.options[n][m]}}</option><#
					}
				#></optgroup><#

				}else{

		#><option<#
					if( n == data.value ){ #> selected<# }
				#> value="{{n}}">{{data.options[n]}}</option><#
				}
			}
		} #>
	</select>
	<div class="or_animate_preview">
		<p id="or_preview"><?php _e('The element will animate like this.', 'originbuilder'); ?><br/><?php _e('You can click the play button to preview it.', 'originbuilder'); ?></p>
		<a href="javascript:;" class="play_animate_preview"><i class="fa fa-play"></i></a>
	</div>
	<#
		data.callback = function( el ){
			el.find('.play_animate_preview').on( 'click', el, function(e){
				setTimeout( function (){ el.find('#or_preview').attr('class',''); }, 1000, el);
				el.find('#or_preview').attr('class','animated ' + e.data.find('select.or-param').val());
				e.preventDefault();
			});
			el.find('.play_animate_select').on( 'change', el, function(e){
				setTimeout( function (){ el.find('#or_preview').attr('class',''); }, 1000, el);
				el.find('#or_preview').attr('class','animated ' + e.data.find('select.or-param').val());
				e.preventDefault();
			});
		}
	#>
	<?php
}

function or_param_type_animate_image_preview(){
	?>
	<select class="or-param play_animate_select" name="{{data.name}}">
		<# if( data.options ){
			for( var n in data.options ){
				if( typeof data.options[n] == 'array' ||  typeof data.options[n] == 'object' ){
				#><optgroup label="{{n}}"><#
					for( var m in data.options[n] ){
						#><option<#
							if( m == data.value ){ #> selected<# }
							#> value="{{m}}">{{data.options[n][m]}}</option><#
					}
				#></optgroup><#

				}else{

		#><option<#
					if( n == data.value ){ #> selected<# }
				#> value="{{n}}">{{data.options[n]}}</option><#
				}
			}
		} #>
	</select>
	<div class="or_animate_preview">
		<div id="or_slider_jssor_be" style="width:362px;height:245px;position: relative;">
			<div u="slides" class="jssor_slider_slides" style="width:362px;height:245px;cursor: move; position: absolute;top:0px;left:0px;overflow:hidden;">
				<div>
					<img src="<?php echo or_URL.'/assets/images/get_logo.png'; ?>" alt="" u="image">
				</div>
				<div>
					<img src="<?php echo or_URL.'/assets/images/get_logo.png'; ?>" alt="" u="image">
				</div>
				<div>
					<img src="<?php echo or_URL.'/assets/images/get_logo.png'; ?>" alt="" u="image">
				</div>
			</div>
		</div>
	</div>
	<#
		data.callback = function( el ){
			var _SlideshowTransitions = [
				{$Duration:1200,$Opacity:2},
				
				{$Duration:1200,x:0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2},
				{$Duration:1200,x:-0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2},
				{$Duration:1200,y:-0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2},
				{$Duration:1000,$Zoom:11,$Easing:{$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2},
				{$Duration:1200,x:0.6,$Zoom:1,$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2},
				{$Duration:1000,x:-4,$Zoom:11,$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2,$Round:{$Top:2.5}},
				{$Duration:1000,y:4,$Zoom:11,$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2},
				{$Duration:1200,y:0.6,$Zoom:1,$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2},
				{$Duration:1000,y:-4,$Zoom:11,$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2},
				{$Duration:1200,y:-0.6,$Zoom:1,$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2},
				
				{$Duration:700,$Opacity:2,$Brother:{$Duration:1000,$Opacity:2}},
				{$Duration:1400,x:0.25,$Zoom:1.5,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Zoom:$JssorEasing$.$EaseInSine},$Opacity:2,$ZIndex:-10,$Brother:{$Duration:1400,x:-0.25,$Zoom:1.5,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Zoom:$JssorEasing$.$EaseInSine},$Opacity:2,$ZIndex:-10}},
				{$Duration:1200,y:1,$Easing:{$Top:$JssorEasing$.$EaseInOutQuart,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2,$Brother:{$Duration:1200,y:-1,$Easing:{$Top:$JssorEasing$.$EaseInOutQuart,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2}},
				{$Duration:1200,x:1,$Easing:{$Left:$JssorEasing$.$EaseInOutQuart,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2,$Brother:{$Duration:1200,x:-1,$Easing:{$Left:$JssorEasing$.$EaseInOutQuart,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2}},
				{$Duration:1600,x:-0.2,$Delay:40,$Cols:12,$During:{$Left:[0.4,0.6]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInOutExpo,$Opacity:$JssorEasing$.$EaseInOutQuad},$Opacity:2,$Outside:true,$Round:{$Top:0.5},$Brother:{$Duration:1000,x:0.2,$Delay:40,$Cols:12,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:1028,$Easing:{$Left:$JssorEasing$.$EaseInOutExpo,$Opacity:$JssorEasing$.$EaseInOutQuad},$Opacity:2,$Round:{$Top:0.5}}},
				{$Duration:1200,$Zoom:11,$Rotate:1,$Easing:{$Opacity:$JssorEasing$.$EaseLinear,$Rotate:$JssorEasing$.$EaseInQuad},$Opacity:2,$Round:{$Rotate:1},$ZIndex:-10,$Brother:{$Duration:1200,$Zoom:11,$Rotate:-1,$Easing:{$Opacity:$JssorEasing$.$EaseLinear,$Rotate:$JssorEasing$.$EaseInQuad},$Opacity:2,$Round:{$Rotate:1},$ZIndex:-10,$Shift:600}},
				{$Duration:1200,$Zoom:11,$Rotate:-1,$Easing:{$Zoom:$JssorEasing$.$EaseInQuad,$Opacity:$JssorEasing$.$EaseLinear,$Rotate:$JssorEasing$.$EaseInQuad},$Opacity:2,$Round:{$Rotate:0.5},$Brother:{$Duration:1200,$Zoom:1,$Rotate:1,$Easing:$JssorEasing$.$EaseSwing,$Opacity:2,$Round:{$Rotate:0.5},$Shift:90}}
			];
			var options = {
				$FillMode: 1,
				$AutoPlaySteps: 1,
				$PauseOnHover: 1,
				$ArrowKeyNavigation: true,	
				$SlideDuration: 500,
				$MinDragOffsetToSlide: 20,													
				$SlideSpacing: 0, 													
				$DisplayPieces: 1,																	
				$ParkingPosition: 0,																
				$UISearchMode: 1,	
				$PlayOrientation: 1,															
				$DragOrientation: 1,
				$AutoPlay: true,
				$AutoPlayInterval: 2000,
				$SlideDuration: 3000,
				$SlideshowOptions: {											
					$Class: $JssorSlideshowRunner$,
					$Transitions: [_SlideshowTransitions[el.find('.play_animate_select').val()]],
					$TransitionsOrder: 1,
					$ShowLink: true														
				},
				$ThumbnailNavigatorOptions: {
					$Class: $JssorThumbnailNavigator$,						 
					$ChanceToShow: 2,															 
					$ActionMode: 0,																 
					$DisableDrag: true,														 
					$Orientation: 2																 
				}
			};
			var jssor_slider = new $JssorSlider$('or_slider_jssor_be', options);
			el.find('.play_animate_select').on( 'change', el, function(e){
				jssor_slider.$SetSlideshowTransitions([_SlideshowTransitions[e.data.find('select.or-param').val()]]);
				
				e.preventDefault();
			});
		}
	#>
	<?php
}

function or_param_type_attach_media(){
?>

	<div class="or-attach-field-wrp">
		<input name="{{data.name}}" class="or-param" value="{{data.value}}" type="hidden" />
		<div class="media-wrp">
			<div class="filename"><#
				if( data.value != '' ){
					data.value = data.value.split('/');
					#>{{data.value[data.value.length-1]}}<#
				}else{
					#>empty<#
				}
			#></div>
			<i class="sl-close" title="<?php _e('Delete this mdia', 'originbuilder'); ?>"></i>		</div>
		<div class="clear"></div>
		<a class="button media button-primary">
			<i class="sl-cloud-upload"></i> <?php _e('Browse Media', 'originbuilder'); ?>
		</a>
	</div>
	<#
		data.callback = function( el, $ ){

			el.find('.media').on( 'click', { callback: function( atts ){

				var wrp = $(this.el).closest('.or-attach-field-wrp'), url = atts.url;

				wrp.find('input.or-param').val(url).change();
				
				url = url.split('/');
				
				wrp.find('.filename').html(url[url.length-1]);

			}, atts : { frame: 'select' } }, or.tools.media.open );

			el.find('div.media-wrp .sl-close').on( 'click', el, function( e ){
				e.data.find('input.or-param').val('');
				$(this).closest('div.media-wrp').find('.filename').html('empty');
			});

			el.find('div.media-wrp .filename').on( 'click', el, function( e ){
				el.find('.media').trigger('click');
			});



		}
	#>
<?php
}

function or_param_type_attach_image(){
?>

	<div class="or-attach-field-wrp">
	
	<# if( data.value != '' ){ #>
		
		<div class="img-wrp">
		 
			<img src="{{site_url}}/wp-admin/admin-ajax.php?action=or_get_thumbn&id={{data.value}}" alt="" />
			<span class="sl-close remove_close" title="<?php _e('Delete this image', 'originbuilder'); ?>"></span>
		</div>
		<# } #>
	<div class="fe_image">
	<label for="files-data">
Drag image here or
<br/>
<span>open image library</span>
</label>

	<input type = "file" name = "files[]" accept = "image/*" class = "files-data form-control btn-upload1 upload_image" />
	</div>
		<input name="{{data.name}}" class="or-param" value="{{data.value}}" type="hidden" />
		
		<div class="clear"></div> 
		<a class="button media button-primary">
		 <?php _e('open image library', 'originbuilder'); ?>
		</a>
	</div>
	<#
		data.callback = function( el, $ ){

			el.find('.media').on( 'click', { callback: function( atts ){

				var wrp = $(this.el).closest('.or-attach-field-wrp'), url = atts.url;

				wrp.find('input.or-param').val(atts.id).change();
				if( typeof atts.sizes.medium == 'object' )
					var url = atts.sizes.medium.url;

				if( !wrp.find('img').get(0) ){
					wrp.prepend('<div class="img-wrp"><img src="'+url+'" alt="" /><span title="<?php _e('Delete this image', 'originbuilder'); ?>" class="sl-close remove_close"></span></div>');
					wrp.find('img').on( 'click', el, function( e ){
						el.find('.media').trigger('click');
					});
					wrp.find('div.img-wrp .sl-close').on( 'click', el, function( e ){
						e.data.find('input.or-param').val('');
						$(this).closest('div.img-wrp').remove();
					});
				}else wrp.find('img').attr({src : url});

			}, atts : { frame: 'select' } }, or.tools.media.open );

			el.find('div.img-wrp .sl-close').on( 'click', el, function( e ){
				e.data.find('input.or-param').val('');
				$(this).closest('div.img-wrp').remove();
			});

			el.find('div.img-wrp img').on( 'click', el, function( e ){
				el.find('.media').trigger('click');
			});



		}
	#>
<?php
}

function or_param_type_attach_image_url(){
?>

	<div class="or-attach-field-wrp">
	
		<# if( data.value != '' ){ #>
		<div class="img-wrp">
			<img src="{{data.value}}" alt="" />
			<span class="sl-close remove_close" title="<?php _e('Delete this image', 'originbuilder'); ?>"></span>
			<div class="img-sizes"></div>
		</div>
		<# } #>
			<div class="fe_image">
	<label for="files-data">
Drag image here or
<br/>
<span>open image library</span>
</label>
	<input name="{{data.name}}" class="or-param" value="{{data.value}}" type="hidden" />
	<input type = "file" name = "files[]" accept = "image/*" class = "files-data form-control btn-upload1 image_url" />
	</div>
		<div class="clear"></div>
		<a class="button media button-primary">
			<!--<i class="sl-cloud-upload"></i>--> <?php _e('open image library', 'originbuilder'); ?>
		</a>
	</div>
	<#
		data.callback = function( el ){

			var $ = jQuery;

			el.find('.media').on( 'click', { callback : function( atts ){

				var wrp = $(this.el).closest('.or-attach-field-wrp'), url = atts.url;

				if( atts.size != undefined && atts.size != null && atts.sizes[atts.size] != undefined ){
					var url = atts.sizes[atts.size].url;
				}else if( typeof atts.sizes.medium == 'object' ){
					var url = atts.sizes.medium.url;
				}

				if( url != undefined && url != '' ){
					wrp.find('input.or-param').val(url).change();
				}

				if( !wrp.find('img').get(0) ){
					wrp.prepend('<div class="img-wrp"><img src="'+url+'" alt="" /><span title="<?php _e('Delete this image', 'originbuilder'); ?>" class="sl-close remove_close"></span></div>');
					el.find('div.img-wrp img').on( 'click', el, function( e ){
						el.find('.media').trigger('click');
					});
					el.find('div.img-wrp .sl-close').on( 'click', el, function( e ){
						$(this).closest('div.img-wrp').remove();
						e.data.find('input.or-param').val('');
					});
				}else{
					wrp.find('img').attr({src : url});
					wrp.find('.img-sizes').html('');
				}

				var btn, wrpsizes = wrp.find('.img-sizes');
				for( var si in atts.sizes ){
					btn = $('<button data-url="'+atts.sizes[si].url+
								'" class="button">'+atts.sizes[si].width+'x'+
								atts.sizes[si].height+'</button>'
							);

					if( atts.size != undefined && atts.size ){

						if( atts.size == si )
							btn.addClass('button-primary');

					}else if( si == 'medium' )
						btn.addClass('button-primary');

					btn.on( 'click', function(e){

						var wrp = $(this).closest('.or-attach-field-wrp'), url = $(this).data('url');

						$(this).parent().find('button').removeClass('button-primary');
						$(this).addClass('button-primary');

						wrp.find('img').attr({ src : url });
						wrp.find('input.or-param').val( url );

						e.preventDefault();
						return false;

					});
					 <?php //wrpsizes.append( btn );?>
				}

			}, atts : {frame:'post'} }, or.tools.media.open );

			el.find('div.img-wrp .sl-close').on( 'click', el, function( e ){
				$(this).closest('div.img-wrp').remove();
				e.data.find('input.or-param').val('');
			});

			el.find('div.img-wrp img').on( 'click', el, function( e ){
				el.find('.media').trigger('click');
			});

		}
	#>
<?php
}


function or_param_type_attach_images(){
?>
	<div class="or-attach-field-wrp">
		<input name="{{data.name}}" class="or-param" value="{{data.value}}" type="hidden" />
		<#
			if( data.value != '' ){
				data.value = data.value.split(',');
				for( var n in data.value ){
					#><div data-id="{{data.value[n]}}" class="img-wrp"><img title="<?php _e('Drag image to sort', 'originbuilder'); ?>" src="{{site_url}}/wp-admin/admin-ajax.php?action=or_get_thumbn&id={{data.value[n]}}&size=thumbnail" alt="" /><span class="sl-close drag_close1"></span></div><#
				}
		 #>
		<# } #>
		<div class="clear"></div>
				<div class="fe_image">
	<label for="files-data">
Drag image here or
<br/>
<span>open image library</span>
</label>

	<input type = "file" name = "files[]" accept = "image/*" class = "files-data form-control btn-upload1 attach-images" />
	</div>
		<a class="button media button-primary">
			<i title="<?php _e('Delete this image', 'originbuilder'); ?>" class="sl-cloud-upload"></i> <?php _e('open image library', 'originbuilder'); ?>
		</a>
	</div>

	<#
		data.callback = function( el ){

			el.find('.media').on( 'click', function( atts ){

				var wrp = jQuery(this.els).closest('.or-attach-field-wrp'), url = atts.url;

				wrp.find('input.or-param').val(atts.id).change();
				if( typeof atts.sizes.thumbnail == 'object' )
					var url = atts.sizes.thumbnail.url;

				wrp.prepend('<div data-id="'+atts.id+'" class="img-wrp"><img title="<?php _e('Drag image to sort', 'originbuilder'); ?>" src="'+url+'" alt="" /><span title="<?php _e('Delete this image', 'originbuilder'); ?>" class="sl-close drag_close1"></span></div>');
				helper( wrp );

			}, or.tools.media.opens );

			function helper( el ){

				or.ui.sortable({

					items : 'div.or-attach-field-wrp>div.img-wrp',
					helper : ['or-ui-handle-image', 25, 25 ],
					connecting : false,
					vertical : false,
					end : function( e, el ){
						refresh( jQuery(el).closest('.or-attach-field-wrp') );
					}

				});


				el.find('div.img-wrp i.sl-close').off('click').on( 'click', el, function( e ){
					jQuery(this).closest('div.img-wrp').remove();
					refresh( e.data );
				});

				refresh( el );

			}

			function refresh( el ){
				var val = [];
				el.find('div.img-wrp').each(function(){
					val[ val.length ] = jQuery(this).data('id');
				});
				if( val.length <= 4 ){
					el.removeClass('img-wrp-medium').removeClass('img-wrp-large');
				}else if( val.length > 4 && val.length < 9 ){
					el.addClass('img-wrp-medium').removeClass('img-wrp-large');
				}else if( val.length >= 9 ){
					el.removeClass('img-wrp-medium').addClass('img-wrp-large');
				}

				el.find('input.or-param').val( val.join(',') );

				el.find('div.img-wrp img').on( 'click', el, function( e ){
					el.find('.media').trigger('click');
				});
			}

			helper( el.find('.or-attach-field-wrp') );

		}
	#>

<?php
}

function or_param_type_color_picker(){
?>
	<input name="{{data.name}}" value="{{data.value}}" placeholder="" class="or-param" type="text"  />
	<#
		data.callback = function( el ){
			el.find('input').each(function(){
				this.color = new jscolor.color(this, {});
			});
	    }
	#>
<?php
}

function or_param_type_colorpicker(){
?>
	<input name="{{data.name}}" value="{{data.value}}" placeholder="" class="or-param or_drageble_area_color" type="text" />
	<#
		var target = data.target;
		data.callback = function( el ){
			var obj = el.find('input');
			el.find('input').each(function(){
				this.color = new jscolor.color(this, {
					onImmediateChange:function(result){
						jQuery('.or_drageble_area .or_svg .path').css({'fill':obj.val()});
					}
				});
			});
	    }
	#>
<?php
}

function or_param_type_icon_picker(){

?>	<# prefix = ''; if( data.value == undefined || data.value == '' ){ data.value='leaf'; prefix = 'fa-'; } #>
	<div class="icons-preview">
		<i class="{{prefix}}{{data.value}}"></i>
	</div>
	<input name="{{data.name}}" value="{{data.value}}" placeholder="Click to select icon" class="or-param or-param-icons" type="text" />
	<#
		data.callback = function( el, $ ){

			el.find('input.or-param').on('focus', function(){

				$('.or-icons-picker-popup').remove();

				var listObj = jQuery( '<div class="icons-list noneuser">'+or.tools.get_icons()+'</div>' );

				var atts = { title: 'Select Icons', width: 600, class: 'or-icons-picker-popup or-hs-popup-iconpicker', keepCurrentPopups: true };
				var pop = or.tools.popup.render( this, atts );
				pop.data({ target: this, scrolltop: jQuery(window).scrollTop() });

				pop.find('.m-p-body').off('mousedown').on('mousedown',function(e){
					e.preventDefault();
					return false;
				});

				$(this).off( 'keyup' ).on( 'keyup', listObj, function( e ){

					clearTimeout( this.timer );
					this.timer = setTimeout( function( el, list ){

						if( list.find('.seach-results').length == 0 ){

							var sr = $('<div class="seach-results"></div>');
							list.prepend( sr );

						}else sr = list.find('.seach-results');

						var found = ['<span class="label">Search Results:</span>'];
						list.find('>i').each(function(){

							if( this.className.indexOf( el.value.trim() ) > -1
								&& found.length < 16
								&& $.inArray( this.className, found )
							)found.push( '<span data-icon="'+this.className+'"><i class="'+this.className+'"></i>'+this.className+'</span>' );

						});
						if( found.length > 1 ){
							sr.html( found.join('') );
							sr.find('span').on('mousedown', function(){

								if( $(this).data('icon') === undefined )
								{
									e.preventDefault();
									return false;
								}
								var tar = or.get.popup(this).data('target');
								tar.value = $(this).data('icon');
								$(tar).trigger('change');
								setTimeout( function(el){el.trigger('blur');}, 100, $(tar) );
							});
						}
						else sr.html( '<span class="label">The key you entered was not found.</span>' );

					}, 150, this, e.data );

				});

				listObj.find('i').on('mousedown', function( e ){

					var tar = or.get.popup(this).data('target');
					tar.value = this.className;

					$(tar).trigger('change');
					setTimeout( function(el){el.trigger('blur');}, 100, $(tar) );

				});

				setTimeout(function( el, list ){
					el.append( list );
				}, 10, pop.find('.m-p-body'), listObj );

			}).on('change',function(){
				jQuery(this).parent().find('.icons-preview i').attr({class: this.value});
			}).on('blur', function(){
				//$('.or-icons-picker-popup').remove();
			});

	    }
	#>
<?php
}

function or_param_type_date_picker(){
?>

	<input name="{{data.name}}" class="or-param" value="{{data.value}}" type="text" />
	<#
		data.callback = function( wrp, $ ){
			new Pikaday(
		    {
		        field: wrp.find('.or-param').get(0),
		        firstDay: 1,
				format: 'YYYY-MM-DD HH:mm:ss',
		        minDate: new Date(2000, 0, 1),
		        maxDate: new Date(2020, 12, 31),
		        yearRange: [2000,2020]
		    });
		}
	#>

<?php
}

function or_param_type_or_box(){

?>

	<textarea name="data" class="or-param or-box-area forceHide">{{data.value}}</textarea>
	<button class="button html-code" data-action="html-code">
		<i class="sl-doc"></i> <?php _e('HTML Code', 'originbuilder'); ?>
	</button>
	<button class="button css-code" data-action="css-code">
		<i class="sl-settings"></i> <?php _e('CSS Code', 'originbuilder'); ?>
	</button>
	<button class="button align-center add-top" data-action="add" data-pos="top">
		<i class="sl-plus"></i>
	</button>
	<div class="or-box-render"></div>
	<button class="button align-center add-bottom" data-action="add" data-pos="bottom">
		<i class="sl-plus"></i>
	</button>
	<div class="or-box-trash">
		<a href="#" class="button forceHide" data-action="undo">
			<i class="sl-action-undo"></i> Undo Delete(0)
		</a>
	</div>
<#

	data.callback = function( wrp, $ ){

		try{
			var data_obj = or.tools.base64.decode( data.value.replace(/(?:\r\n|\r|\n)/g,'') );
			data_obj = data_obj.replace( /\%SITE\_URL\%/g, site_url );
			data_obj = JSON.parse( data_obj );
		}catch(e){
			var data_obj = [{tag:'div',children:[{tag:'text', content:'There was an error with content structure.'}]}];
		}

		wrp.find('.or-box-render').eq(0).append( or.template( 'box-design', data_obj ) );

		var pop = or.get.popup( wrp );
		
		or.tools.popup.callback( pop, { before_callback : or.ui.or_Box.renderBack });
		pop.addClass('preventCancel');

		or.ui.or_Box.sort();

		wrp.on( 'click', function( e ){

			if( e.target.tagName == 'I' )
				var el = $( e.target.parentNode );
			else var el = $( e.target );

			or.ui.or_Box.actions( el, e );

		} );

	}

#>
<?php
}


function or_param_type_wp_widget(){

?><#

	try{
		var obj = JSON.parse( or.tools.base64.decode( data.value ) );
	}catch(e){
		return '<center><?php _e('There was an error with content structure.', 'originbuilder'); ?></center>';
	}
	var html = '';

	for( var n in obj ){

		or.widgets.find('input[name="id_base"]').each(function(){

			if( this.value == n ){

				html = jQuery(this).closest('div.widget').find('.widget-content').html();
				html = '<div class="or-widgets-container" data-name="'+n+'">'
					   +html.replace(/name="([^"]*)"/g,function(r,v){

							v = v.split('][');
							v = ( v[1] != undefined ) ? v[1] : v[0];
							v = v.replace(/\]/g,'').trim();
							var str = 'name="'+v+'"';

							if( obj[n][v] != undefined )
								str += ' data-value="'+or.tools.esc(obj[n][v])+'"';

							return str;

						})+'</div>';
			}
		});
	}

	#>{{{html}}}<#

	data.callback = function( wrp, $ ){

		wrp.find('*[data-value]').each(function(){
			switch( this.tagName ){
				case 'INPUT' :
					if( this.type == 'radio' || this.type == 'checkbox' )
						this.checked = true;
					else this.value = jQuery(this).data('value');
				break;
				case 'TEXTAREA' :
					this.value = jQuery(this).data('value');
				break;
				case 'SELECT' :
					var vls = jQuery(this).data('value');
					if( vls )vls = vls.toString().split(',');
					else vls = [''];

					if( vls.length > 1 )
						this.multiple = 'multiple';
					jQuery(this).find('option').each(function(){
						if( vls.indexOf( this.value ) > -1 )
							this.selected = true;
						else this.selected = false;
					});
				break;
			}
		});

		var pop = or.get.popup( wrp );

		or.tools.popup.callback( pop, { 
			
			before_callback : function( wrp ){

				var name = wrp.find('.or-widgets-container').data('name'),
					fields = wrp.find('form.fields-edit-form').serializeArray(),
					data = {};
	
				data[ name ] = {};
	
				fields.forEach(function(n){
					if( data[ name ][n.name] == undefined )
						data[ name ][n.name] = n.value;
					else data[ name ][n.name] += ','+n.value;
				});
	
				var string = or.tools.base64.encode( JSON.stringify( data ) );
	
				wrp.find('.m-p-r-content').append('<textarea name="data" class="or-param or-widget-area forceHide">'+string+'</textarea>');
	
			},
			after_callback : function( wrp ){
				wrp.find('.m-p-r-content .or-param').remove();
			}
		});

	}

#>
<?php
}


function or_param_type_css_box_tbtl(){
?>
	<#
		var imp = data.value.indexOf('!important');
		if( imp > -1 )
			imp = '!important';
		else imp = '';
		var val = data.value.replace('!important','').split(' ');
	#>
	<ul class="multi-fields-ul">
		<li>
			<input class="or-param" name="{{data.name}}-top" class="m-f-u-first" value="{{val[0]}}" type="text" /><!--<br /> <strong>Top</strong>-->
		</li>
	
		<li>
			<input class="or-param" name="{{data.name}}-left" type="text" value="{{val[3]}}" /><!--<br /> Left-->
		</li>
		<li>
			<input class="or-param" name="{{data.name}}-right" class="m-f-u-last" type="text" value="{{val[1]}}" /><!--<br /> Right-->
		</li>
			<li>
			<input class="or-param" name="{{data.name}}-bottom" type="text" value="{{val[2]}}" /><!--<br /> Bottom-->
		</li>
		<li class="m-f-u-li-link mtips">
			 
			 <div class="checkbox checkbox1 linking_abs row_checked">
       <label>
        <input <# if( val[0] == val[1] && val[1] == val[2] && val[2] == val[3] ){ #>checked<#} #> type="checkbox" />
         <span> </span>
        </label>
      </div>
			 <span class="mt-mes"><# if( val[0] == val[1] && val[1] == val[2] && val[2] == val[3] ){ #>Unlock<#} 
			 else{ #>
			 Lock
			 <# } #></span>
		</li> 
		<input type="hidden" class="or-param" name="{{data.name}}-important" value="{{imp}}" />
		<br />
		 
	</ul>
 
	<#
		data.callback = function( el, $ ){
			el.find('input[type=text]').on( 'keyup', el, function( e ){
				if( e.data.find('input[type=checkbox]').get(0).checked == true ){
					var cur = this;
					e.data.find()
					e.data.find('input[type=text]').each(function(){
						if( this != cur )
							this.value = cur.value;
					});
				}
			}).on( 'mousedown', function(e){
				
				if( e.which !== undefined && e.which !== 1 )
					return false;
					
				$(document).on( 'mouseup', function(){
					$(document).off( 'mousemove' ).off('mouseup');
					$('body').css({cursor:''});
				});
				
				var ext = this.value.replace(/[0-9\-]/g,'');
				if( ext === '' )
					ext = 'px';
				$(document).on( 'mousemove', { 
					el: this,
					cur: parseInt(this.value!==''?this.value:0),
					ext: ext,
					top: e.clientY
				}, function(e){
					var offset = e.clientY-e.data.top;
					e.data.el.value = (e.data.cur-offset)+e.data.ext;
					$(e.data.el).trigger('change');
				});
				
				$('body').css({cursor:'ns-resize'});
				
				$( window ).off('mouseup').on('mouseup', function(){
					$(document).off('mousemove');
					$(window).off('mouseup');
					$('html,body').removeClass('or_dragging noneuser');
				});
				
			});
			el.find('input[type=checkbox]').on( 'change', el, function( e ){
				if( this.checked == true ){
					e.data.find('input[type=text]').val( e.data.find('input[type=text]').get(0).value );
				}
			});
		}
	#>
<?php
}
function or_param_type_css_box_border(){
?>
	<#
		var imp = data.value.indexOf('!important');
		if( imp > -1 )
			imp = '!important';
		else imp = '';
		var val = data.value.replace('!important','').split(' ');
	#>
	<ul class="multi-fields-ul">
		
		<li>
			<span class="m-f-u-li-splect">
				<select name="border-style" class="or-param">
					<option value="none">none</option>
					<option <# if(val[1]== 'hidden'){ #>selected<# } #> value="hidden">hidden</option>
					<option <# if(val[1]== 'dotted'){ #>selected<# } #> value="dotted">dotted</option>
					<option <# if(val[1]== 'dashed'){ #>selected<# } #> value="dashed">dashed</option>
					<option <# if(val[1]== 'solid'){ #>selected<# } #> value="solid">solid</option>
					<option <# if(val[1]== 'double'){ #>selected<# } #> value="double">double</option>
					<option <# if(val[1]== 'groove'){ #>selected<# } #> value="groove">groove</option>
					<option <# if(val[1]== 'ridge'){ #>selected<# } #> value="ridge">ridge</option>
					<option <# if(val[1]== 'inset'){ #>selected<# } #> value="inset">inset</option>
					<option <# if(val[1]== 'outset'){ #>selected<# } #> value="outset">outset</option>
					<option <# if(val[1]== 'initial'){ #>selected<# } #> value="initial">initial</option>
					<option <# if(val[1]== 'inherit'){ #>selected<# } #> value="inherit">inherit</option>
				</select>
			</span>
		 
		</li>
		<li>
			<input name="border-width" class="m-f-u-first or-param" value="{{val[0]}}" type="text" /> 
		</li>
		<li>
			<input type="text" name="border-color" value="{{val[2]}}" width="80" class="m-f-bb-color or-param" />  
		</li>
		<input type="hidden" name="border-important" class="or-param" value="{{imp}}" />
	</ul>
	<#
		data.callback = function( el ){
			el.find('input.m-f-bb-color').each(function(){
				this.color = new jscolor.color(this, {});
			});
	    }
	#>
<?php
}
function or_param_type_group(){
?>
<input type="hidden" name="{{data.name}}[0]" class="or-param" />
<div class="or-group-rows"></div>
<#
	try{
		data.value = or.tools.base64.decode( data.value );
		data.value = data.value.replace( /\%SITE\_URL\%/g, site_url );
		data.value = JSON.parse( data.value );
		var values = {};
		for( var i in data.value ){
			if( typeof( data.value[i] ) == 'object' ){
				if( i.indexOf( data.name+'[' ) == -1 ){
					values[ data.name+'['+i+']' ] = {};
					for( var j in data.value[i] ){
						values[ data.name+'['+i+']['+j+']' ] = data.value[i][j];
					}
				}else values[ i ] = data.value[i];
			}
		}
	}catch(e){
		data.value = {'0':{}};
		var values = {};
	}

	data.callback = function( wrp, $, data ){
		
		wrp.data({ 'name' : data.name, 'params': data.params });

		for( var n in data.value ){
			if( typeof( data.value[n] ) == 'object' ){
				var params = or.params.fields.group.set_index( data.params, data.name, n );
				
				var grow = $( or.template( 'param-group' ) );
				wrp.find('.or-group-rows').append( grow );
				
				or.params.fields.render( grow.find('.or-group-body'), params, values );
			}

		}

		wrp.find('.or-group-rows').append( '<div class="or-group-controls or-add-group"><img class="sl-plus" src="<?php echo or_URL; ?>/assets/images/add_blue.png" /><img class="sl-plus1" src="<?php echo or_URL; ?>/assets/images/plus_white.png"><?php _e('Add another section', 'originbuilder'); ?></div>' );
 
		or.params.fields.group.callback( wrp );
		
	}

#>
<?php
}

function or_param_type_link(){
?>
<#
	if( typeof data.value != 'undefined' && data.value != '' )
		var value = data.value.split('|');
	else value = ['','','','',''];
#>
	<input name="{{data.name}}" class="or-param" value="{{data.value}}" type="hidden" />
	<a class="button link button-primary">
		<i class="sl-link"></i> <?php _e( 'Add your link', 'originbuilder' ); ?>
	</a>
	 
	<span class="link-preview">
		<# if( value[0] !== undefined && value[0] != '' ){ #><strong>Link:</strong> {{value[0]}}<br /><# } #>
		<# if( value[1] !== undefined && value[1] != '' ){ #><strong>Title:</strong> {{value[1]}}<br /><# } #>
		<# if( value[2] !== undefined && value[2] != '' ){ #><strong>Target:</strong> {{value[2]}}<br /><# } #>
	</span>

<#

	data.callback = function( wrp, $ ){
		wrp.find('.button.link').on( 'click', wrp, function(e) {

            wpLink.open();

            var value = e.data.find('.or-param').val();
            if( value != '' )
				value = value.split('|');
			else value = ['','','','',''];

            $('#wp-link-url').val( value[0] );
	        $('#wp-link-text').val( value[1] );
	        if( value[2] == '_blank' )
	        	$('#wp-link-target').attr({checked: true});

            if( $('#wp-link-update #or-link-submit').length == 0 ){
            	$('#wp-link-update').append('<input type="submit" value="Add Link" class="button button-primary" id="or-link-submit" name="wp-link-submit" style="display: none">');
				$('#wp-link-cancel, #wp-link-close').on( 'click', function(e) {
					$('#wp-link-submit').css({display: 'block'});
					$('#or-link-submit').css({display: 'none'});
			        wpLink.close();
			        e.preventDefault ? e.preventDefault() : e.returnValue = false;
			        e.stopPropagation();
			        return false;
			    });
            }

            $('#wp-link-submit').css({display: 'none'});

            $('#wp-link-update #or-link-submit').css({display: 'block'}).off('click').on( 'click', e.data, function(e) {

	            var url = $('#wp-link-url').val(),
	            	text = $('#wp-link-text').val(),
	            	target = $('#wp-link-target').get(0).checked?'_blank':'';

				e.data.find('.or-param').val(url+'|'+text+'|'+target);

				var preview = '';
				if( url != '' )
					preview += '<strong>Link:</strong> '+url+'<br />';
				if( text != '' )
					preview += '<strong>Title:</strong> '+text+'<br />';
				if( target != '' )
					preview += '<strong>Target:</strong> '+target+'<br />';

				e.data.find('.link-preview').html( preview );

				$('#wp-link-close').trigger('click');

	            wpLink.close();
	            e.preventDefault
	            return false;
	        });
            return false;
        });
	}

#>

<?php
}

function or_param_type_post_taxonomy(){

	$post_types = get_post_types( array(
			'public'   => true,
			'_builtin' => false
		),
		'names'
	);

	$post_types = array_merge( array( 'post' => 'post'), $post_types );

	foreach($post_types as $post_type){
		$taxonomy_objects = get_object_taxonomies( $post_type, 'objects' );
		$taxonomy = key( $taxonomy_objects );
		$args[ $post_type ] = or_get_terms( $taxonomy, 'slug' );
	}

	echo '<label>'.__( 'Select Content Type', 'originbuilder' ).': </label>';
	echo '<br />';
	echo '<select class="or-content-type">';
	foreach( $args as $k => $v ){
		echo '<option value="'.esc_attr($k).'">'.ucwords( str_replace(array('-','_'), array(' ', ' '), $k ) ).'</option>';
	}
	echo '</select>';
	echo '<div class="or-select-wrp">';
		echo '<select style="height: 150px" multiple class="or-taxonomies-select">';

		foreach( $args as $type => $arg ){

			echo '<option class="'.esc_attr($type).'-st" value="'.esc_attr($type).'" style="display:none;">'.esc_html($type).'</option>';

			foreach( $arg as $k => $v ){

				$k = $type.':'.str_replace( ':', '&#58;', $k );

				echo '<option class="'.esc_attr($type).' '.esc_attr($k).'" value="'.esc_attr($k).'" style="display:none;">'.esc_html($v).'</option>';

			}
		}

		echo '</select>';
		echo '<button class="button unselected" style="margin-top: 10px;">Remove selection</button>';
	echo '</div>';

?>
<#

	data.callback = function( wrp, $ ){

		// Action for changing content type
		wrp.find('.or-content-type').on( 'change', wrp, function( e ){

			var type = this.value;

			e.data.find('.or-taxonomies-select option').each(function(){

				this.selected = false;

				if( $(this).hasClass( type ) )
					this.style.display = '';
				else this.style.display = 'none';

				if( this.value == type ){
					this.checked = true;
					e.data.find('input.or-param').val( type );
				}
			});

		});
		// Action for changing taxonomies
		wrp.find('.or-taxonomies-select').on( 'change', wrp, function( e ){

			var value = [];
			$(this).find('option:selected').each(function(){
				value.push( this.value );
			});

			e.data.find('input.or-param').val( value.join(',') );

		});
		// Action remove selection
		wrp.find('.unselected').on( 'click', wrp, function( e ){

			e.data.find( '.or-taxonomies-select option:selected' ).attr({ selected: false });
			e.preventDefault();

		});

		var values = data.value.split(','),
		valuez = data.value+',';

		// Active selected taxonomies
		if( values.length > 0 ){

			selected = values[0].split( ':' )[0];

			// Active selected content type
			if( selected != '' )
				wrp.find('.or-content-type option[value='+selected+']').attr('selected','selected').trigger('change');
			else wrp.find('.or-content-type').trigger('change');

			wrp.find('.or-taxonomies-select option').each(function(){
				if( valuez.indexOf( this.value+',' ) > -1 ){
					this.selected = true;
				}else this.selected = false;
			});
		}

		wrp.find('.or-select-wrp')
			.append('<input class="or-param" name="'+data.name+'" type="hidden" value="'+data.value+'" />');

	}

#>


<?php
}

function or_param_type_autocomplete(){
	
?>
<div class="or_autocomplete_wrp">
	<input class="or-param" name="{{data.name}}" type="hidden" value="{{data.value}}" />
	<ul class="autcp-items"></ul>
	<input type="text" class="or-autp-enter" placeholder="<?php _e('Enter your word','originbuilder'); ?>..." />
	<div class="or-autp-suggestion or-free-scroll">
		<ul>
			<li><?php _e('Show up 120 relate posts','originbuilder'); ?></li>
		</ul>
	</div>
</div>
<#
	data.callback = function( wrp, $ ){
		
		function render( data, wrp ){
			
			var out = '', post_type = 'any', category = '', category_name = '', numberposts = 120, taxonomy = '', terms = '';
			
			if( data.options !== undefined ){
				if( data.options.post_type !== undefined )
					post_type = data.options.post_type;
				if( data.options.category !== undefined )
					category = data.options.category;
				if( data.options.category_name !== undefined )
					category_name = data.options.category_name;
				if( data.options.numberposts !== undefined )
					numberposts = data.options.numberposts;
				if( data.options.taxonomy !== undefined )
					taxonomy = data.options.taxonomy;
				if( data.options.terms !== undefined )
					terms = data.options.terms;
			}
			
			if( data.value !== '' ){
				var items = data.value.split(','), item, id;
				for( var i=0; i<items.length; i++ ){
					item = items[i].split(':');
					id = item[0];
					if( item[1] !== undefined )
						item = item[1];
					else item = '';
					out += '<li data-id="'+id+'"><span>'+or.tools.esc_attr(item)+'</span><i class="sl-close or-ac-remove" title="<?php _e( 'Remove item','originbuilder' ); ?>"></i></li>';
				}
			}
			
			wrp.find('ul.autcp-items').html( out );
			helper( wrp.find('.or_autocomplete_wrp') );
			
			wrp.find('.or-autp-enter').on('focus',function(){
				$(this.parentNode).find('.or-autp-suggestion').show();
			}).on('blur',function(){
				setTimeout( function(el){
					el.hide();
				}, 200, $(this.parentNode).find('.or-autp-suggestion') );
			}).on('keyup',function(){
				
				if( this.value === '' )
					return;
					
				if( $(this.parentNode).find('.or-autp-suggestion .fa-spinner').length == 0 ){
					$(this.parentNode).find('.or-autp-suggestion ul').prepend('<li class="sg-loading or-free-scroll"><i class="fa fa-spinner fa-spin"></i> searching...</li>');
				}
				clearTimeout( this.timer );
				this.session = Math.random();
				this.timer = setTimeout(function(el){
					
					$.post(
		
						or_ajax_url,
					
						{
							'action': 'or_suggestion',
							'security': or_ajax_nonce,
							'post_type': post_type,
							'category': category,
							'category_name': category_name,
							'numberposts': numberposts,
							'taxonomy': taxonomy,
							'terms': terms,
							's': el.value,
							'session': el.session
						},
					
						function (result) {
							$(el.parentNode).find('.sg-loading').remove();
							if( el.session == result.__session ){
								var ex = [], out = [], item;
								for( var n in result ){
									if( n !== '__session' ){
										if( ex.indexOf( n ) === -1 ){
											ex.push(n);
											out.push('<li class="label or-free-scroll">'+n+'</li>');	
										}
										for( var m in result[n] ){
											item = result[n][m].split(':');
											out.push('<li class="or-free-scroll" data-value="'+or.tools.esc_attr(result[n][m])+'">'+item[1]+'</li>');	
										}
									}	
								}
								if( out.length === 0 )
									out.push('<li><?php _e('Nothing found','originbuilder'); ?></li>');
								$(el.parentNode).find('.or-autp-suggestion ul').html( out.join('') ).find('li').on('click',function(){
									var value = $(this).data('value');
									if( value === null || value === undefined )
										return;
									value = value.split(':');
									$(this).closest('.or_autocomplete_wrp').find('ul.autcp-items').append('<li data-id="'+value[0]+'"><span>'+or.tools.esc_attr(value[1])+'</span><i class="sl-close or-ac-remove" title="<?php _e( 'Remove item','originbuilder' ); ?>"></i></li>');
									helper( $(this).closest('.or_autocomplete_wrp') );
								});
							}
						}
					);
					
				}, 250, this);
			});
				
		}
		
		function helper( el ){

			or.ui.sortable({

				items : 'div.or_autocomplete_wrp>ul>li',
				helper : ['or-ui-handle-image', 25, 25 ],
				connecting : false,
				vertical : true,
				end : function( e, el ){
					refresh( $(el).closest('.or_autocomplete_wrp') );
				}

			});


			el.find('i.or-ac-remove').off('click').on( 'click', el, function( e ){
				$(this).closest('li').remove();
				refresh( e.data );
			});

			refresh( el );

		}

		function refresh( el ){
			
			var val = [];
			
			el.find('>ul.autcp-items>li').each(function(){
				val[ val.length ] = $(this).data('id')+':'+$(this).find('>span').html();
			});

			el.find('input.or-param').val( val.join(',') );

		}
		
		render( data, wrp );
	
	}	
#>	
<?php	
}	

function or_param_type_number_slider(){
	?>
	<#
		var type, show_input;
		show_input = (typeof data.options['show_input'] == 'undefined' )? false: data.options['show_input'];

		if( show_input === true){
			type = 'text';
		}else{
			type = 'hidden';
		}
	#>

    <div class="or_percent_slider"></div>
	<input type="{{type}}" class="or-param number_slider_field" name="{{data.name}}" value="{{data.value}}" />

	<#

	data.callback = function( el, $, data ){

        var el_slider = el.find('.or_percent_slider'), or_number_slider = function( el, set_val ){
	        
			var _step, range = (typeof data.options['range'] == 'undefined' )? false: data.options['range'],
				show_input = (typeof data.options['show_input'] == 'undefined' )? false: data.options['show_input'],
				unit = (typeof data.options['unit'] == 'undefined' )? '': data.options['unit'];

			if(show_input === true ){
				_step = 1;
			}
			else{
				_step = data.options['step'];
			}
			if( set_val == 'NaN' )
				set_val = 0.75*parseInt( data.options['max'] );
				
			el.off('mouseup').on('mouseup',function(){
				$(this).next('input').change();
			}).freshslider({
				
				step	: _step,
				range	: range,
				min		: data.options['min'],
				max		: data.options['max'],
				unit	: data.options['unit'],
				value	: set_val,
				enabled : data.options['enabled'],

				onchange: function( left, right ){
					
					if( range === true )
						el.next('input').val((left+unit)+'|'+(right+unit));
					else el.next('input').val(left+unit);
					
					if(show_input === true )
						el.find('.fscaret').text('');
					else{
						el.find('.fscaret.fss-left').html('<span>'+(left+unit)+'</span>');
						el.find('.fscaret.fss-right').html('<span>'+(right+unit)+'</span>');
					}
					
				}
			});

		};
		
		var values = data.value.split('|');
		for( var i in values ){
			values[i] = parseInt( values[i] );
		}
		or_number_slider( el_slider, values );
		
		el_slider.next('input').on('change', { el : el , el_slider: el_slider, data : data }, function(e){
	
			var _value = $(this).val();
			
			_value = _value.split('|');
			for( var i in _value ){
				_value[i] = parseInt( _value[i] );
			}
			
			if(/^\d+$/.test(_value) && _value !== ''){
				
				if(this.value!==_value)
					$(this).val( parseInt(_value) );

				if( _value > e.data.data.options['max'] ) _value = e.data.data.options['max'];

				or_number_slider( e.data.el_slider, _value.toString().split('|') );
				
			}else{
				e.data.el_slider.next('input').val('');
			}

		});
    }

	#>
	<?php
}

 add_action('wp_ajax_cvf_upload_files1', 'cvf_upload_files1');
add_action('wp_ajax_nopriv_cvf_upload_files1', 'cvf_upload_files1'); // Allow front-end submission

function cvf_upload_files1(){
	
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg"); // Supported file types
    //$max_file_size = 1024 * 500; // in kb
    $max_image_upload = 10; // Define how many images can be uploaded to the current post
    $wp_upload_dir = wp_upload_dir();
    $path = $wp_upload_dir['path'] . '/';
    $count = 0;
 
    // Image upload handler
    if( $_SERVER['REQUEST_METHOD'] == "POST" ){
                  
            foreach ( $_FILES['files']['name'] as $f => $name ) {
                $extension = pathinfo( $name, PATHINFO_EXTENSION );
                
                if ( $_FILES['files']['error'][$f] == 4 ) {
                    continue;
                }
               
                if ( $_FILES['files']['error'][$f] == 0 ) {
                    if( ! in_array( strtolower( $extension ), $valid_formats ) ){
                        $upload_message[] = "$name is not a valid format";
                        continue;
                   
                    } else{
                        // If no errors, upload the file...
                        if( move_uploaded_file( $_FILES["files"]["tmp_name"][$f], $path.$_FILES["files"]["name"][0] ) ) {
                            $count++;

                            $filename = $path.$_FILES["files"]["name"][0];
                            $filetype = wp_check_filetype( basename( $filename ), null );
                            $wp_upload_dir = wp_upload_dir();
                            $attachment = array(
                                'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
                                'post_mime_type' => $filetype['type'],
                                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                                'post_content'   => '',
                                'post_status'    => 'inherit'
                            );
                            // Insert attachment to the database
                            $attach_id = wp_insert_attachment( $attachment, $filename );

                            require_once( ABSPATH . 'wp-admin/includes/image.php' );
                           
                            $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
                            wp_update_attachment_metadata( $attach_id, $attach_data );
                           
                        }
                    }
                }
            }
        
    }
    // Loop through each error then output it to the screen
    if ( isset( $upload_message ) ) :
        foreach ( $upload_message as $msg ){       
            printf( __('<p class="bg-danger">%s</p>', 'wp-trade'), $msg );
        }
    endif;
    // If no error, show success message
    if( $count != 0 ){
        $image_attributes = wp_get_attachment_image_src( $attach_id,'thumbnail' );
			 if($image_attributes[0]!=""){
				 echo $attach_id."--yes--".$image_attributes[0];
							 
			 } 
    }
   
    exit();

}
 add_action('wp_ajax_cvf_upload_files2', 'cvf_upload_files2');
add_action('wp_ajax_nopriv_cvf_upload_files2', 'cvf_upload_files2'); // Allow front-end submission

function cvf_upload_files2(){
	
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg"); // Supported file types
    //$max_file_size = 1024 * 500; // in kb
    $max_image_upload = 10; // Define how many images can be uploaded to the current post
    $wp_upload_dir = wp_upload_dir();
    $path = $wp_upload_dir['path'] . '/';
    $count = 0;
 
    // Image upload handler
    if( $_SERVER['REQUEST_METHOD'] == "POST" ){
                  
            foreach ( $_FILES['files']['name'] as $f => $name ) {
                $extension = pathinfo( $name, PATHINFO_EXTENSION );
                
                if ( $_FILES['files']['error'][$f] == 4 ) {
                    continue;
                }
               
                if ( $_FILES['files']['error'][$f] == 0 ) {
                    if( ! in_array( strtolower( $extension ), $valid_formats ) ){
                        $upload_message[] = "$name is not a valid format";
                        continue;
                   
                    } else{
                        // If no errors, upload the file...
                        if( move_uploaded_file( $_FILES["files"]["tmp_name"][$f], $path.$_FILES["files"]["name"][0] ) ) {
                            $count++;

                            $filename = $path.$_FILES["files"]["name"][0];
                            $filetype = wp_check_filetype( basename( $filename ), null );
                            $wp_upload_dir = wp_upload_dir();
                            $attachment = array(
                                'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
                                'post_mime_type' => $filetype['type'],
                                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                                'post_content'   => '',
                                'post_status'    => 'inherit'
                            );
                            // Insert attachment to the database
                            $attach_id = wp_insert_attachment( $attachment, $filename );

                            require_once( ABSPATH . 'wp-admin/includes/image.php' );
                           
                            $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
                            wp_update_attachment_metadata( $attach_id, $attach_data );
                           
                        }
                    }
                }
            }
        
    }
    // Loop through each error then output it to the screen
    if ( isset( $upload_message ) ) :
        foreach ( $upload_message as $msg ){       
            printf( __('<p class="bg-danger">%s</p>', 'wp-trade'), $msg );
        }
    endif;
    // If no error, show success message
    if( $count != 0 ){
        $image_attributes = wp_get_attachment_image_src( $attach_id,'full' );
			 if($image_attributes[0]!=""){
				 echo $attach_id."--yes--".$image_attributes[0];
							 
			 } 
    }
   
    exit();

}
function or_param_type_random(){
?>
	<#
		var new_random = parseInt(Math.random()*1000000);
	#>
	<input name="{{data.name}}" class="or-param" value="{{new_random}}" type="text" />

<?php
}

function or_param_type_optin_select(){
?>
		<select class="or-param" name="{{data.name}}">
			<# if( data.options ){
				for( var n in data.options ){
					if( typeof data.options[n] == 'array' ||  typeof data.options[n] == 'object' ){
					#><optgroup label="{{n}}"><#
						for( var m in data.options[n] ){
							#><option<#
								if( m == data.value ){ #> selected<# }
								#> value="{{m}}">{{data.options[n][m]}}</option><#
						}
					#></optgroup><#

					}else{

			#><option<#
						if( n == data.value ){ #> selected<# }
					#> value="{{n}}">{{data.options[n]}}</option><#
					}
				}
			} #>
		</select>
		
		<#
			data.callback = function( el ){
				el.find('select').on( 'change', el, function(e){
					var list = el.next().find('.or_optin_list');
					var list_id = el.next().find('.or_optin_list_id');
					jQuery.ajax({
						url  :  ajaxurl,
						data : { 'action' : 'or_get_subscriber_setting', 'responder' : jQuery(this).val() },
						type : 'post',
						success : function(result){
							var result = jQuery.parseJSON(result);
							//console.log(result);
							list.find('option').remove();
							
							if(result.error){
								
								list.append(jQuery("<option>", { 
									value: 0,
									text : result.error 
								}));
								
							}else{
								
								list.append(jQuery("<option>", { 
									value: 'null',
									text : 'select'
								}));
								
								jQuery.each( result.list, function( key, value ) {
									
									if(list_id.val() == '')
										list_id.val(key);
									
									list.append(jQuery("<option>", { 
										value: key,
										text : value
									}));
									
								});
								
							}
							
						}
					});
					
				});				
			}
		#>
		
<?php
}

function or_param_type_optinlist_select(){
?>
		<select class="or_optin_list">
			<# if( data.options ){
				for( var n in data.options ){
					if( typeof data.options[n] == 'array' ||  typeof data.options[n] == 'object' ){
					#><optgroup label="{{n}}"><#
						for( var m in data.options[n] ){
							#><option<#
								if( m == data.value ){ #> selected<# }
								#> value="{{m}}">{{data.options[n][m]}}</option><#
						}
					#></optgroup><#

					}else{

			#><option<#
						if( n == data.value ){ #> selected<# }
					#> value="{{n}}">{{data.options[n]}}</option><#
					}
				}
			} #>
		</select>
		
		<input type="hidden" value="{{data.value}}" id="or_optin_list_id" class="or-param" name="{{data.name}}">
		
		<#
			data.callback = function( el ){
				
				el.find('select').on( 'change', el, function(e){
					var list_id = el.find('select').val();
					el.find('input').val(list_id);
					el.next().find('input').val( el.find('select option:selected').text() );
				});
				
				if(el.find('select').val() != ''){
					var responder = el.prev().find('select').val();
					var list_id = el.find('input').val();
					jQuery.ajax({
						url  :  ajaxurl,
						data : { 'action' : 'or_get_subscriber_setting', 'responder' : responder },
						type : 'post',
						success : function(result){
							var result = jQuery.parseJSON(result);
							if(result.error){
								el.find('select').append(jQuery("<option>", { 
									value: 0,
									text : result.error 
								}));
							}else{
								var select = "";
								el.find('select').append(jQuery("<option>", { 
									value: 'null',
									text : 'select'
								}));
								jQuery.each( result.list, function( key, value ) {
									if(key == list_id){
										el.find('select').append(jQuery("<option>", { 
											value: key,
											text : value
										})).val(key);
									}else{
										el.find('select').append(jQuery("<option>", { 
											value: key,
											text : value
										}));	
									}
								});
							}
							
						}
					});
				}
			}
		#>
		
<?php
}

function or_param_type_optin_radio(){
?>
	<div or-multiple-field-wrp>
		<# if( data.options ){
			for( var n in data.options ){
				#><span class="nowrap"><input type="radio" class="or-param" name="{{data.name}}" <#
					if( n == data.value ){ #> checked<# }
				#> value="{{n}}" /> {{data.options[n]}}</span>
			<# } #>
		<# } #><input type="radio" class="or-param empty-value" value="" name="{{data.name}}" style="display:none;" />
	</div>
<?php
}

function or_param_type_optinlist_hidden(){
	echo '<input name="{{data.name}}" class="or-param optin_list" value="{{data.value}}" type="hidden" />';
}

function or_param_type_dragdrop(){
	//echo '<input name="{{data.name}}" class="or-param m-p-rela" value="{{data.value}}" type="checkbox" />';
	?>
	<div class="or_drageble_area">
		<input type="hidden" class="or-param" value="{{data.value}}" name="{{data.name}}" />
	
		<div class="or_dragdrop_available_div">
			<ul id="or_dragdrop_available" class="or_ssbaSortable">
				<# if( data.options ){
					var vals = data.value.split(',');
					for( var n in data.options ){
						if(!(vals.indexOf(data.options[n]) > -1)){
						#>
						<li data-value="{{data.options[n]}}" data-src="<?php echo or_URL . '/assets/images/social/'; ?>{{data.options[n]}}<?php echo '/01.svg'; ?>"><img src="<?php echo or_URL . '/assets/images/social/'; ?>{{data.options[n]}}<?php echo '/01.svg'; ?>" alt="" class="or_svg"></li>
						<# } #>
					<# } #>
				<# } #>
			</ul>
		</div>
		<div class="or_dragdrop_select_div">
			<p><span class="ti-import"></span> Drap icons below to add. Move left or right to rearrange.</p>
			<ul id="or_dragdrop_select" class="or_ssbaSortable">
				<# if(data.value){ var vals = data.value.split(','); #>
				<# for( var n in vals ){ #>
					<li data-value="{{vals[n]}}" data-src="<?php echo or_URL . '/assets/images/social/'; ?>{{vals[n]}}<?php echo '/01.svg'; ?>"><img src="<?php echo or_URL . '/assets/images/social/'; ?>{{vals[n]}}<?php echo '/01.svg'; ?>" alt="" class="or_svg" ></li>
				<# } } #>
			</ul>
		</div>
	</div>
	<#
		data.callback = function( el ){
			//console.log(el);
			jQuery(function() {
				jQuery( "#or_dragdrop_available, #or_dragdrop_select" ).sortable({
					connectWith: ".or_ssbaSortable",
					stop: function( event, ui ){
						var data = el.find('.or_drageble_area input.or-param[type="hidden"]').val();
						var val = [];
						var temp = '';
						/*if(data != ''){
							val = data.split(',');
						}*/
						jQuery('#or_dragdrop_select li').each(function(i){
							temp = jQuery(this).attr('data-value');
							
							/*if(-1 < val.indexOf(temp)){
								alert(temp);
								val.splice(val.indexOf(temp), 1);
							}*/
							val.push(temp);
							
						});
						el.find('.or_drageble_area input.or-param[type="hidden"]').val(val.join());
						
					}
				}).disableSelection();
			});	
			
			jQuery('img.or_svg').each(function(){
				var $img = jQuery(this);
				var imgID = $img.attr('id');
				var imgClass = $img.attr('class');
				var imgURL = $img.attr('src');
			
				jQuery.get(imgURL, function(data) {
					// Get the SVG tag, ignore the rest
					var $svg = jQuery(data).find('svg');
			
					// Add replaced image's ID to the new SVG
					if(typeof imgID !== 'undefined') {
						$svg = $svg.attr('id', imgID);
					}
					// Add replaced image's classes to the new SVG
					if(typeof imgClass !== 'undefined') {
						$svg = $svg.attr('class', imgClass+' replaced-svg');
					}
			
					// Remove any invalid XML tags as per http://validator.w3.org
					$svg = $svg.removeAttr('xmlns:a');
					
					// Check if the viewport is set, else we gonna set it if we can.
					if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
						$svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
					}
			
					// Replace image with new SVG
					$img.replaceWith($svg);
					if(jQuery('#or_check_checkbox').is(':checked')){
						jQuery('.or_drageble_area .or_svg .path').css({'fill':jQuery('.or_drageble_area_color').val()});
					}
			
				}, 'xml');
			
			});	
		}
	#>
	<?php
	
}

function or_param_type_dropdown_iconpack(){
	?>
	<select class="or-param" name="{{data.name}}">
		<# if( data.options ){
			for( var n in data.options ){
				if( typeof data.options[n] == 'array' ||  typeof data.options[n] == 'object' ){
				#><optgroup label="{{n}}"><#
					for( var m in data.options[n] ){
						#><option<#
							if( m == data.value ){ #> selected<# }
							#> value="{{m}}">{{data.options[n][m]}}</option><#
					}
				#></optgroup><#

				}else{

		#><option<#
					if( n == data.value ){ #> selected<# }
				#> value="{{n}}">{{data.options[n]}}</option><#
				}
			}
		} #>
	</select>
	<#
		data.callback = function( el ){
			
			el.find('select').on( 'change', el, function(e){
				var icon = el.find('select').val();
				jQuery( "ul.or_ssbaSortable li" ).each(function( index ) {
					/*var src = jQuery( this ).find('img').attr('src');
					var path = src.substring(0,src.lastIndexOf('/')); // get the path from the src 
					var newSrc = path+"/"+icon+".svg"; // re-assemble
					jQuery( this ).find('img').attr('src', newSrc);*/
					var src = jQuery( this ).attr('data-src');
					var path = src.substring(0,src.lastIndexOf('/')); // get the path from the src 
					var imgURL = path+"/"+icon+".svg"; // re-assemble
					
					var $img = jQuery(this).find('svg');
					var imgID = 'undefined';
					var imgClass = 'or_svg';
				
					jQuery.get(imgURL, function(data) {
						// Get the SVG tag, ignore the rest
						var $svg = jQuery(data).find('svg');
				
						// Add replaced image's ID to the new SVG
						if(imgID !== 'undefined') {
							$svg = $svg.attr('id', imgID);
						}
						// Add replaced image's classes to the new SVG
						if(imgClass !== 'undefined') {
							$svg = $svg.attr('class', imgClass+' replaced-svg');
						}
				
						// Remove any invalid XML tags as per http://validator.w3.org
						$svg = $svg.removeAttr('xmlns:a');
						
						// Check if the viewport is set, else we gonna set it if we can.
						if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
							$svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
						}
				
						// Replace image with new SVG
						$img.replaceWith($svg);
						
						if(jQuery('#or_check_checkbox').is(':checked')){
							jQuery('.or_drageble_area .or_svg .path').css({'fill':jQuery('.or_drageble_area_color').val()});
						}
				
					}, 'xml');
				});
			});	

			jQuery( "ul.or_ssbaSortable li" ).each(function( index ) {
				var src = jQuery( this ).find('img').attr('src');
				var path = src.substring(0,src.lastIndexOf('/')); // get the path from the src 
				var newSrc = path+"/"+data.value+".svg"; // re-assemble
				jQuery( this ).find('img').attr('src', newSrc);
				jQuery( this ).attr('data-src', newSrc);
			});		
			
		}
	#>
	<?php
}