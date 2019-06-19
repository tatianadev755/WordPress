<?php
if ( !class_exists( 'OrThemeOverride' ) ) {

    class OrThemeOverride {
    	private $paramarr = array('or_page_layout', 'or_bg_style', 'or_hide_page_title', 'or_hide_header', 'or_hide_footer', 'or_primary_bg_color', 'or_pbg_image', 'or_primary_bg_video', 'or_pbg_image_repeate', 'or_pbg_image_pos', 'or_pbg_image_size', 'or_pbg_image_attchment', 'or_bg_boxed_width', 'or_bg_boxed_shadow', 'or_bg_boxed_radiuss', 'or_primary_bg_video_unmute');
		private $selector = '.entry-title';
		private $afterHead = false;
		private $title;

        /**
        * PHP 5 Constructor
        */
        function __construct(){

	        add_action( 'add_meta_boxes', array( $this, 'add_box' ), 100 );
			add_action( 'save_post', array( $this, 'on_save' ) );
			add_action( 'delete_post', array( $this, 'on_delete' ) );
			add_filter( 'template_include', array( $this, 'view_project_template') );
			add_filter( 'body_class', array($this, 'add_class_boxed_template') );
			add_action( 'wp_head', array( $this, 'head_insert' ), 3000 );
			add_action( 'the_title', array( $this, 'wrap_title' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );

        } // __construct()


		private function is_hidden(  ){

			//if( is_singular() ){

				global $post;

				$toggle = get_post_meta( $post->ID, 'or_hide_page_title', true );

				if( (bool) $toggle ){
					return true;
				} else {
					return false;
				}

			/*} else {
				return false;
			}*/
			
		} // is_hidden()
		
		public function hide_title(){
			if( $this->is_hidden() ){
			?>
			<!-- Dojo Digital Hide Title -->
			<script type="text/javascript">
				jQuery(document).ready(function($){

					if( $('<?php echo $this->selector; ?>').length != 0 ) {
						$('<?php echo $this->selector; ?> span.or_hide_page_title').parents('<?php echo $this->selector; ?>:first').hide();
					} else {
						$('h1 span.or_hide_page_title').parents('h1:first').hide();
						$('h2 span.or_hide_page_title').parents('h2:first').hide();
					}

				});
			</script>
			<noscript><style type="text/css"> <?php echo $this->selector; ?> { display:none !important; }</style></noscript>
			<!-- END Dojo Digital Hide Title -->
			<?php
			}
			$this->afterHead = true;
		}


    	public function head_insert(){
			
			global $post;
			
			$lyt = get_post_meta($post->ID, 'or_page_layout', true);
			
			if( !is_singular() ) return;
			
			if($lyt == 'boxed'){
				
				$bg_style = get_post_meta($post->ID, 'or_bg_style', true);
				$bg_wid = get_post_meta($post->ID, 'or_bg_boxed_width', true);
				$bg_s = get_post_meta($post->ID, 'or_bg_boxed_shadow', true);
				$bg_r = get_post_meta($post->ID, 'or_bg_boxed_radiuss', true);
				$style = '';
				if($bg_style == 'color'){
					$color = get_post_meta( $post->ID, 'or_primary_bg_color', true );
					$style = 'body{ background-color: '.$color.'; }';
				}
				
				if($bg_style == 'image'){
					$imageId = get_post_meta( $post->ID, 'or_pbg_image', true );
					$imagerepeate = get_post_meta( $post->ID, 'or_pbg_image_repeate', true );
					$imagepos = get_post_meta( $post->ID, 'or_pbg_image_pos', true );
					$imagesize = get_post_meta( $post->ID, 'or_pbg_image_size', true );
					$imageattchment = get_post_meta( $post->ID, 'or_pbg_image_attchment', true );
					$url = wp_get_attachment_url($imageId);
					$style = 'body{ background-image: url('.$url.'); background-size: '.$imagesize.';  background-attachment: '.$imageattchment.';   background-position: '.$imagepos.';  background-repeat: '.$imagerepeate.'; }';
				}
				
				if($bg_style == 'video'){
					
				}
				
				$style .= '@media (min-width: 1200px){.or_boxeddiv{width: '.$bg_wid.';}}';
				
				if( (bool) $bg_s ) $style .= '.or_boxeddiv{box-shadow: 0 2px 0px 0 rgba(0,0,0,0.16),0 2px 4px 0 rgba(0,0,0,0.12);}';
				
				$style .= '.or_boxeddiv{border-radius: '.$bg_r.';}';  
			?>
			
			<style type="text/css" id="or_style_css">
			<?php echo $style; ?>
			</style>
			
			<?php
			
			$this->hide_title();
			
			}
			
			if($lyt == 'fullwidth'){
				$this->hide_title();
			}

		} // head_insert()


		public function add_box(){

			$posttypes = array( 'page' );

			foreach ( $posttypes as $posttype ){
				add_meta_box( 'or_themeoverride', 'Origin Builder Page Option', array( $this, 'build_box' ), $posttype, 'side', 'high' );
			}

		} // add_box()


		public function build_box( $post ){

			wp_nonce_field( 'or_custom_action_dononce', 'or_custom_name_noncename' );
			
			$lyt = get_post_meta($post->ID, 'or_page_layout', true);
			
			$bg_style = get_post_meta($post->ID, 'or_bg_style', true);
			
			$image = get_post_meta( $post->ID, 'or_pbg_image', true );
			$imagerepeate = get_post_meta( $post->ID, 'or_pbg_image_repeate', true );
			$imagepos = get_post_meta( $post->ID, 'or_pbg_image_pos', true );
			$imagesize = get_post_meta( $post->ID, 'or_pbg_image_size', true );
			$imageattchment = get_post_meta( $post->ID, 'or_pbg_image_attchment', true );
			
			$tchecked = $hchecked = $fchecked = $schecked = '';
			
			?>
			
			<div class="or_field_option">
				<div class="or_input_field">
					<label>Page Layout </label>
					<select name="or_page_layout" class="or_page_layout">
						<option value="themecreative" <?php if($lyt == 'themecreative') echo 'selected'; ?>>Theme Default</option>
						<option value="fullwidth" <?php if($lyt == 'fullwidth') echo 'selected'; ?>>Full Width (no-sidebar)</option>
						<option value="boxed" <?php if($lyt == 'boxed') echo 'selected'; ?>>Boxed (no-sidebar)</option>
					</select>
				</div>
				<div class="or_parent_bg_style">
					<div class="or_input_field">
					<label>Background Style</label>
					<select name="or_bg_style" class="or_bg_style">
						<option value="color" <?php if($bg_style == 'color') echo 'selected'; ?>>Color</option>
						<option value="image" <?php if($bg_style == 'image') echo 'selected'; ?>>Image</option>
						<option value="video" <?php if($bg_style == 'video') echo 'selected'; ?>>Video</option>
					</select>
					</div>
					<div class="or_bg_style_color">
						<div class="field-color_picker">
							<div class="or_primary_bg_color m-p-r-content">
								<label>Background Color</label>
								<input type="text" name="or_primary_bg_color" class="" value="<?php echo get_post_meta( $post->ID, 'or_primary_bg_color', true ); ?>"/>
							</div>
						</div>
					</div>
					
					<div class="or_bg_style_image">
						<div class="or_primary_bg_image or-attach-field-wrp or_input_field">
	
							<?php if( $image != '' ){ ?>
								
								<div class="img-wrp">
								 
									<img src="<?php echo site_url(); ?>/wp-admin/admin-ajax.php?action=or_get_thumbn&id=<?php echo $image; ?>" alt="" />
									<span class="sl-close remove_close" title="<?php _e('Delete this image', 'originbuilder'); ?>"></span>
								</div>
								<?php } ?>
							<div class="fe_image">
							<label for="files-data">
							Drag image here or
							<br/>
							<span>open image library</span>
							</label>

							<input type = "file" name = "files[]" accept = "image/*" class = "files-data form-control btn-upload1 upload_image" />
							</div>
							<input name="or_pbg_image" class="or_bg_image" value="<?php echo $image; ?>" type="hidden" />
							
							<div class="clear"></div> 
							<a class="button media button-primary">
							 <?php _e('open image library', 'originbuilder'); ?>
							</a>
						</div>
						
						<div class="or_input_field">
							<label>BG Repeat</label>
							<select name="or_pbg_image_repeate" class="or_pbg_image_repeate">
								<option selected="" value="" <?php if($imagerepeate == '') echo 'selected'; ?>>Yes</option>
								<option value="no-repeat" <?php if($imagerepeate == 'no-repeat') echo 'selected'; ?>>No Repeat</option>
								<option value="repeat-x" <?php if($imagerepeate == 'repeat-x') echo 'selected'; ?>>Repeat Horizontal</option>
								<option value="repeat-y" <?php if($imagerepeate == 'repeat-y') echo 'selected'; ?>>Repeat Vertical</option>
							</select>
						</div>
						
						<div class="or_input_field">
							<label>BG Position</label>
							<select name="or_pbg_image_pos" class="or_pbg_image_pos">
								<option value="center center" <?php if($imagepos == 'center center') echo 'selected'; ?>>center center</option>
								<option value="0px 0px" <?php if($imagepos == '0px 0px') echo 'selected'; ?>>0px 0px</option>
								<option value="50% 50%" <?php if($imagepos == '50% 50%') echo 'selected'; ?>>50% 50%</option>
							</select>
						</div>
						
						<div class="or_input_field">
							<label>BG Attachment</label>
							<select name="or_pbg_image_attchment" class="or_pbg_image_attchment">
								<option value="scroll" <?php if($imageattchment == 'scroll') echo 'selected'; ?>>scroll</option>
								<option value="fixed" <?php if($imageattchment == 'fixed') echo 'selected'; ?>>fixed</option>
								<option value="local" <?php if($imageattchment == 'local') echo 'selected'; ?>>local</option>
								<option value="initial" <?php if($imageattchment == 'initial') echo 'selected'; ?>>initial</option>
								<option value="inherit" <?php if($imageattchment == 'inherit') echo 'selected'; ?>>inherit</option>
							</select>
						</div>
						
						<div class="or_input_field">
							<label>BG Size</label>
							<select name="or_pbg_image_size" class="or_pbg_image_size">
								<option value="auto" <?php if($imagesize == 'auto') echo 'selected'; ?>>auto</option>
								<option value="length" <?php if($imagesize == 'length') echo 'selected'; ?>>length</option>
								<option value="cover" <?php if($imagesize == 'cover') echo 'selected'; ?>>cover</option>
								<option value="contain" <?php if($imagesize == 'contain') echo 'selected'; ?>>contain</option>
								<option value="initial" <?php if($imagesize == 'initial') echo 'selected'; ?>>initial</option>
								<option value="inherit" <?php if($imagesize == 'inherit') echo 'selected'; ?>>inherit</option>
							</select>
						</div>
						
					</div>
					
					<div class="or_bg_style_video or_input_field">
						<label>Video URL</label>
						<input type="text" value="<?php echo get_post_meta( $post->ID, 'or_primary_bg_video', true ); ?>" name="or_primary_bg_video">						
					</div>
					
					<div class="or_input_field or_primary_bg_video_unmute">
						<?php $value = get_post_meta( $post->ID, 'or_primary_bg_video_unmute', true ); if( (bool) $value ){ $mute = ' checked="checked"'; } ?>
						<label><input type="checkbox" name="or_primary_bg_video_unmute" <?php echo $mute; ?> /> Unmute video</label>
					</div>
					
				</div>
				
				<div class="or_input_field or_bg_boxed_width">
					<label>Box Width</label>
					<div class="or_slide_content">
					<div class="or_percent_slider"></div>
					<input type="text" class="or-param number_slider_field" name="or_bg_boxed_width" value="<?php echo get_post_meta( $post->ID, 'or_bg_boxed_width', true ) ? get_post_meta( $post->ID, 'or_bg_boxed_width', true ) : '1170'; ?>" />
					</div>
				</div>
				
				<div class="or_input_field or_bg_boxed_radius">
					<label>Boxed Border Radius <span class="or_tooltip"> ? </span></label>
					<span class="or_tooltip_popup">Border Radius will not work if you select background image or color on top or bottom row.</span>
					<div class="or_slide_content">
					<div class="or_percent_slider"></div>
					<input type="text" class="or-param number_slider_field" name="or_bg_boxed_radiuss" value="<?php echo get_post_meta( $post->ID, 'or_bg_boxed_radiuss', true ); ?>" />
					</div>
				</div>
				
				<div class="or_input_field or_bg_boxed_shadow">
					<?php $value = get_post_meta( $post->ID, 'or_bg_boxed_shadow', true ); if( (bool) $value ){ $schecked = ' checked="checked"'; } ?>
					<label><input type="checkbox" name="or_bg_boxed_shadow" <?php echo $schecked; ?> /> Box Shadow</label>
				</div>
				
				<div class="or_parent_pagetitle or_input_field">
					<?php $value = get_post_meta( $post->ID, 'or_hide_page_title', true ); if( (bool) $value ){ $tchecked = ' checked="checked"'; } ?>
					<label><input type="checkbox" name="or_hide_page_title" <?php echo $tchecked; ?> /> Hide the title on singular page views.</label>
				</div>
				<div class="or_parent_header or_input_field">
					<?php $value = get_post_meta( $post->ID, 'or_hide_header', true ); if( (bool) $value ){ $hchecked = ' checked="checked"'; } ?>
					<label><input type="checkbox" name="or_hide_header" <?php echo $hchecked; ?> /> Hide the header & footer on singular page views.</label>
				</div>
				<div class="or_parent_footer">
					<?php /*$value = get_post_meta( $post->ID, 'or_hide_footer', true ); if( (bool) $value ){ $fchecked = ' checked="checked"'; }*/ ?>
					<!--<label><input type="checkbox" name="or_hide_footer" <?php echo $fchecked; ?> /> Hide the footer on singular page views.</label>-->
				</div>
			</div>
			<style>
				.or_input_field{
					width: 100%;
					margin-bottom: 15px;
					position: relative;
					<!--float: left;-->
				}
				.or_input_field label {
					<!--float: left;-->
					width: 100%;
					margin-bottom: 5px;
					font-weight: bold;
				}
				.or_input_field .button.button-primary{
					border: none !important;
					box-shadow: none;
					<!--float: left;-->
					bottom: 30px !important;
				}
				.or_input_field .fe_image > label{
					top: 8px;
				}
				#or_themeoverride, #or_themeoverride .inside{
					position:relative;
				}
				#or_themeoverride input[type=text], #or_themeoverride select, #or_themeoverride textarea{
					width: 100%;
				}
				.or_slide_content {
					min-height: 2px !important;
					padding: 4px 0px 3px 0;
					text-align: left !important;
					width: 100%;
				}
				.or_slide_content .or_percent_slider {
					max-width: 80%;
				}
				.or_slide_content .number_slider_field {
					width: 18%!important;
					text-align: center;
					float: right;
					margin-top: -30px;
					padding: 5px 2px!important;
					font-size: 11px !important;
					min-width: 40px;
				}
				.or_tooltip{
					background-color: #efefef;
					color: #000;
					border-radius: 100%;
					border: 1px solid #666;
					font-size: 13px;
					width: 15px;
					height: 15px;
					display: inline-block;
					text-align: center;
					margin-left: 15px;
					line-height: 15px;
				}
				.or_tooltip_popup{
					float: left;
					width: calc(100% - 20px);
					background-color: #ffffff;
					padding: 10px;
					border-radius: 5px;
					box-shadow: 1px 1px 17px 1px #999;
					position: absolute;
					top: -80px;
					right: 0px;
					color: #000;
					display: none;
					font-weight: 500;
					z-index: 1;
					border-radius: 5px;
					box-shadow: 0 3px 7px 0 rgba(0, 0, 0, 0.1);
				}
				.or_tooltip_popup:after{
					position: absolute;
					content: "";
					background: #fff;
					transform: rotate(45deg);
					-webkit-transform: rotate(45deg);
					-moz-transform: rotate(45deg);
					height: 10px;
					width: 10px;
					
					border-radius: 5px;
					left: calc(50% + 31px);
					bottom: -2px;
					height: 20px;
					width: 20px;
					z-index: -1;
					transform: translateX(-50%) rotate(45deg);
					-webkit-transform: translateX(-50%) rotate(45deg);
				}
			</style>
			<script>
			jQuery(document).ready(function($){
				$('.or_page_layout').change(function(){
					
					var val = $(this).val();
					__or_show_hide__override(val);
					
				});
				$('.or_tooltip').hover(function(){
					$('.or_tooltip_popup').show();
						},function(){
					$('.or_tooltip_popup').hide();					
				});
				$('.or_bg_style').change(function(){
					
					var val = $(this).val();
					__or_show_hide__bg_style(val);
					
				});
				
				jQuery('.or_primary_bg_color').find('input').each(function(){
					this.color = new jscolor.color(this, {});
				});
				
				var el = jQuery('.or_primary_bg_image');
				
				jQuery('.or_primary_bg_image').find('.media').on( 'click', { callback: function( atts ){

					var wrp = jQuery(this.el).closest('.or-attach-field-wrp'), url = atts.url;
					//console.log(atts.id);
					wrp.find('input.or_bg_image').val(atts.id).change();
					if( typeof atts.sizes.medium == 'object' )
						var url = atts.sizes.medium.url;

					if( !wrp.find('img').get(0) ){
						wrp.prepend('<div class="img-wrp"><img src="'+url+'" alt="" /><span title="<?php _e('Delete this image', 'originbuilder'); ?>" class="sl-close remove_close"></span></div>');
						wrp.find('img').on( 'click', jQuery('.or_primary_bg_image'), function( e ){
							jQuery('.or_primary_bg_image').find('.media').trigger('click');
						});
						wrp.find('div.img-wrp .sl-close').on( 'click', jQuery('.or_primary_bg_image'), function( e ){
							e.data.find('input.or_bg_image').val('');
							jQuery(this).closest('div.img-wrp').remove();
						});
					}else wrp.find('img').attr({src : url});

				}, atts : { frame: 'select' } }, or.tools.media.open );

				jQuery('.or_primary_bg_image').find('div.img-wrp .sl-close').on( 'click', jQuery('.or_primary_bg_image'), function( e ){
					e.data.find('input.or_bg_image').val('');
					jQuery(this).closest('div.img-wrp').remove();
				});

				jQuery('.or_primary_bg_image').find('div.img-wrp img').on( 'click', jQuery('.or_primary_bg_image'), function( e ){
					jQuery('.or_primary_bg_image').find('.media').trigger('click');
				});
				
				function __or_show_hide__bg_style(val){
					
					$('.or_bg_style_image').hide();
					$('.or_bg_style_video').hide();
					$('.or_primary_bg_video_unmute').hide();
					
					if(val == 'color'){
						$('.or_bg_style_color').show();
					}
					
					if(val == 'image'){
						$('.or_bg_style_color').hide();
						$('.or_bg_style_image').show();
					}
					
					if(val == 'video'){
						$('.or_bg_style_color').hide();
						$('.or_bg_style_video').show();
						$('.or_primary_bg_video_unmute').show();
					}
				}
				
				function __or_show_hide__override(val){
					$('.or_parent_bg_style').hide();
					$('.or_parent_pagetitle').hide();
					$('.or_parent_header').hide();
					$('.or_parent_footer').hide();
					$('.or_bg_boxed_width').hide();
					$('.or_bg_boxed_shadow').hide();
					$('.or_bg_boxed_radius').hide();
						
					if(val == 'fullwidth'){
						$('.or_parent_pagetitle').show();
						$('.or_parent_header').show();
						$('.or_parent_footer').show();
					}
					if(val == 'boxed'){
						$('.or_parent_bg_style').show();
						$('.or_parent_pagetitle').show();
						$('.or_parent_header').show();
						$('.or_parent_footer').show();
						$('.or_bg_boxed_width').show();
						$('.or_bg_boxed_shadow').show();
						$('.or_bg_boxed_radius').show();
					}
				}
				
				__or_show_hide__override('<?php echo $lyt; ?>');
				__or_show_hide__bg_style('<?php echo $bg_style; ?>');
				
				
				var ell = jQuery('.or_bg_boxed_width'); 
				
				var data = { 'options': {'min' : 990,	'max' : 1170, 'unit' : 'px','show_input' : true}, 'value' : '<?php echo get_post_meta( $post->ID, 'or_bg_boxed_width', true ) ? get_post_meta( $post->ID, 'or_bg_boxed_width', true ) : '1170'; ?>' };
				
				draggble_slider(ell, data);
				
				var ell = jQuery('.or_bg_boxed_radius'); 
				
				var data = { 'options': {'min' : 0,	'max' : 100, 'unit' : 'px','show_input' : true}, 'value' : '<?php echo get_post_meta( $post->ID, 'or_bg_boxed_radiuss', true ) ? get_post_meta( $post->ID, 'or_bg_boxed_radiuss', true ) : '100'; ?>' };
				
				draggble_slider(ell, data);
				
				function draggble_slider(ell, data){
				
					var el_slider = ell.find('.or_percent_slider'), or_number_slider = function( ell, set_val ){
				
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
							
						ell.off('mouseup').on('mouseup',function(){
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
									ell.next('input').val((left+unit)+'|'+(right+unit));
								else ell.next('input').val(left+unit);
								
								if(show_input === true )
									ell.find('.fscaret').text('');
								else{
									ell.find('.fscaret.fss-left').html('<span>'+(left+unit)+'</span>');
									ell.find('.fscaret.fss-right').html('<span>'+(right+unit)+'</span>');
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
				
			});
			</script>
			<?php

		} // build_box()


		public function wrap_title( $content ){

			if( $this->is_hidden() && $content == $this->title && $this->afterHead ){
				$content = '<span class="or_hide_page_title">' . $content . '</span>';
			}

			return $content;

		} // wrap_title()
		
		public function load_scripts(){


			// Grab the title early in case it's overridden later by extra loops.
			global $post;
			$this->title = $post->post_title;

			if( $this->is_hidden() ){
				wp_enqueue_script( 'jquery' );

			}

		}

		public function on_save( $postID ){

			if ( ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
				|| !isset( $_POST[ 'or_custom_name_noncename' ] )
				|| !wp_verify_nonce( $_POST[ 'or_custom_name_noncename' ], 'or_custom_action_dononce' ) ) {
				return $postID;
			}
			
			//print_r($this->paramarr);
			
			foreach($this->paramarr as $v){
				$old = get_post_meta( $postID, $v, true );
				$new = $_POST[ $v ] ;

				if( $old ){
					if ( is_null( $new ) ){
						delete_post_meta( $postID, $v );
					} else {
						update_post_meta( $postID, $v, $new, $old );
					}
				} elseif ( !is_null( $new ) ){
					//echo $new;
					update_post_meta( $postID, $v, $new );
				}
			}

			return $postID;

		} // on_save()


		public function on_delete( $postID ){
			foreach($this->paramarr as $v){
				delete_post_meta( $postID, $v );
			}
			return $postID;
		} // on_delete()


		public function set_selector( $selector ){

			if( isset( $selector ) && is_string( $selector ) ){
				$this->selector = $selector;
			}

		} // set_selector()
		
		/**
         * Checks if the template is assigned to the page
         */
        public function view_project_template( $template ) {

                global $post;

                /*if (!isset($this->templates[get_post_meta( 
					$post->ID, '_wp_page_template', true 
				)] ) ) {
					
                        return $template;
						
                }*/
				
				$pagelayout = get_post_meta( $post->ID, 'or_page_layout', true );
				
				if($pagelayout == 'themecreative'){
					return $template;
				}elseif($pagelayout == 'boxed'){
					$file = plugin_dir_path(__FILE__). 'templates/or-boxed.php';
				}elseif($pagelayout == 'fullwidth'){
					$file = plugin_dir_path(__FILE__). 'templates/or-fullwidth.php';
				}       
				
                // Just to be safe, we check if the file exist first
                if( file_exists( $file ) ) {
                        return $file;
                } 
				
                return $template;

        }
		
		public function add_class_boxed_template($class){
			global $post;
			$pagelayout = get_post_meta( $post->ID, 'or_page_layout', true );
			if($pagelayout == 'boxed') $class[] = 'or_boxedbody_cls';
			return $class;	
		}


    } // OrThemeOverride

    $OrThemeOverride = new OrThemeOverride;

} // !class_exists( 'OrThemeOverride' )