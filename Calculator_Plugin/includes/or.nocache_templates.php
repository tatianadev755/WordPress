<?php
/**
*
*	Origin Builder
*	(c) originbuilder.com
*
*/
if(!defined('or_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

global $or;

?>

<script type="text/html" id="tmpl-or-components-template">
	<div id="or-components">
		<ul class="or-components-categories">
			<li data-category="all" class="all active"><?php _e('All', 'or_composer'); ?></li>
			<?php
				
				$maps = $or->get_maps();
				$categories = array();
				
				foreach( $maps as $key => $map )
				{
					$category = isset( $map['category'] ) ? $map['category'] : '';
					if( !in_array( $category, $categories ) && $category != '' )
					{
						array_push( $categories, $category );
						echo '<li data-category="'.sanitize_title($category).'" class="'.sanitize_title($category).'">';
						echo esc_html($category);
						echo '</li>';
					}
				}
			?>
			<li data-category="or-wp-widgets" class="or-mostused mcl-mostused">
				  <?php _e('Most Used', 'or_composer'); ?>
			</li>
			<li data-category="or-content" class="or-content mcl-content">
			  <?php _e('Contents', 'or_composer'); ?>
			</li>
			<li data-category="or-clipboard" class="or-social mcl-social">
				  <?php _e('Social', 'or_composer'); ?>
			</li>
			<li data-category="or-clipboard" class="or-marketing mcl-marketing">
				 <?php _e('Marketing', 'or_composer'); ?>
			</li>
			<li data-category="or-wp-widgets" class="or-wp-widgets mcl-wp-widgets">
			  <?php _e('Wordpress Widgets', 'or_composer'); ?>
			</li>
		</ul>
		<ul class="or-components-list-main or-components-list all" style="display:block">
			<?php
  
				foreach( $maps as $key => $map )
				{
					if( !isset( $map['system_only'] ) )
					{echo $map['category'];
						$category = isset( $map['category'] ) ? $map['category'] : '';
						$name = isset( $map['name'] ) ? $map['name'] : '';
						$icon = isset( $map['icon'] ) ? $map['icon'] : '';
					?>
				<li <?php
								 
							?> data-category="<?php echo sanitize_title($category); ?>" data-name="<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $key ); ?>">
							<div>
								<span class="cpicon <?php echo esc_attr( $icon ); ?>"></span>
								<span class="cpdes">
									<strong><?php echo esc_html( $name ); ?></strong>
								</span>
								<span class="desc"><?php if( isset( $map['description'] ) && !empty( $map['description'] ) ){
									echo esc_attr( $map['description'] );
								} ?></span>
							</div>
						</li>
  
					<?php
					}	
				}	
			?>
		</ul>
	 
	</div>
</script>

 
 
<script type="text/html" id="tmpl-or-content-template"> 
 
		<ul class="or-components-list-main or-components-list or_content" style="display:none">
			 <?php
			 $maps = $or->get_maps();
              $con=array('or_box','or_column_text','or_icon','or_spacing','or_raw_code','or_title','or_pie_chart','or_button','or_post_type_list','or_progress_bars','or_post_type_list');
				foreach( $maps as $key => $map )
				{
					if( !isset( $map['system_only'] ) )
					{ 
						$category = isset( $map['category'] ) ? $map['category'] : '';
						$name = isset( $map['name'] ) ? $map['name'] : '';
						$icon = isset( $map['icon'] ) ? $map['icon'] : '';
					 if(in_array(esc_attr( $key ),$con)){ ?>
	<li   data-category="<?php echo sanitize_title($category); ?>" data-name="<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $key ); ?>">
							<div>
								<span class="cpicon <?php echo esc_attr( $icon ); ?>"></span>
								<span class="cpdes">
									<strong><?php echo esc_html( $name ); ?></strong>
								</span>
								<span class="desc"><?php if( isset( $map['description'] ) && !empty( $map['description'] ) ){
									echo esc_attr( $map['description'] );
								} ?></span>
							</div>
						</li>
					 
					<?php
					 }
					}	
				}	
			?>
		</ul>
	  
</script>


<script type="text/html" id="tmpl-or-mostused-template"> 
 
		<ul class="or-components-list-main or-components-list or_mostused" style="display:none">
			 <?php
			 $maps = $or->get_maps();
              $con=array('or_icon','or_box','or_column_text','or_spacing','or_raw_code','or_title','or_carousel_images','or_carousel_post','or_post_type_list','or_single_image','or_post_type_list');
				foreach( $maps as $key => $map )
				{
					if( !isset( $map['system_only'] ) )
					{ 
						$category = isset( $map['category'] ) ? $map['category'] : '';
						$name = isset( $map['name'] ) ? $map['name'] : '';
						$icon = isset( $map['icon'] ) ? $map['icon'] : '';
					 if(in_array(esc_attr( $key ),$con)){ ?>
			<li <?php
								 
							?> data-category="<?php echo sanitize_title($category); ?>" data-name="<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $key ); ?>">
							<div>
								<span class="cpicon <?php echo esc_attr( $icon ); ?>"></span>
								<span class="cpdes">
									<strong><?php echo esc_html( $name ); ?></strong>
								</span>
								<span class="desc"><?php if( isset( $map['description'] ) && !empty( $map['description'] ) ){
									echo esc_attr( $map['description'] );
								} ?></span>
							</div>
						</li>
					 
					<?php
					 }
					}	
				}	
			?>
		</ul>
	  
</script>

<script type="text/html" id="tmpl-or-social-template"> 
 
		<ul class="or-components-list-main or-components-list or_social" style="display:none">
			 <?php
			 $maps = $or->get_maps();
              $con=array('or_fb_recent_post','or_instagram_feed','or_twitter_feed');
				foreach( $maps as $key => $map )
				{
					if( !isset( $map['system_only'] ) )
					{echo $map['category'];
						$category = isset( $map['category'] ) ? $map['category'] : '';
						$name = isset( $map['name'] ) ? $map['name'] : '';
						$icon = isset( $map['icon'] ) ? $map['icon'] : '';
					 if(in_array(esc_attr( $key ),$con)){ ?>
			<li <?php
								 
							?> data-category="<?php echo sanitize_title($category); ?>" data-name="<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $key ); ?>">
							<div>
								<span class="cpicon <?php echo esc_attr( $icon ); ?>"></span>
								<span class="cpdes">
									<strong><?php echo esc_html( $name ); ?></strong>
								</span>
								<span class="desc"><?php if( isset( $map['description'] ) && !empty( $map['description'] ) ){
									echo esc_attr( $map['description'] );
								} ?></span>
							</div>
						</li>
					 
					<?php
					 }
					}	
				}	
			?>
		</ul>
	  
</script>


<script type="text/html" id="tmpl-or-marketing-template"> 
 
		<ul class="or-components-list-main or-components-list or_marketing" style="display:none">
			 <?php
			 $maps = $or->get_maps();
              $con=array('or_pie_chart','or_progress_bars','or_counter_box','or_video_play');
				foreach( $maps as $key => $map )
				{
					if( !isset( $map['system_only'] ) )
					{echo $map['category'];
						$category = isset( $map['category'] ) ? $map['category'] : '';
						$name = isset( $map['name'] ) ? $map['name'] : '';
						$icon = isset( $map['icon'] ) ? $map['icon'] : '';
					 if(in_array(esc_attr( $key ),$con)){ ?>
					<li   data-category="<?php echo sanitize_title($category); ?>" data-name="<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $key ); ?>">
							<div>
								<span class="cpicon <?php echo esc_attr( $icon ); ?>"></span>
								<span class="cpdes">
									<strong><?php echo esc_html( $name ); ?></strong>
								</span>
								<span class="desc"><?php if( isset( $map['description'] ) && !empty( $map['description'] ) ){
									echo esc_attr( $map['description'] );
								} ?></span>
							</div>
						</li>
					 
					<?php
					 }
					}	
				}	
			?>
		</ul>
	  
</script>


<script type="text/html" id="tmpl-or-wp-widgets-template">
<div id="or-wp-list-widgets"><?php 
	
	if( !function_exists( 'submit_button' ) ){
		function submit_button( $text = null, $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) {
			echo or_get_submit_button( $text, $type, $name, $wrap, $other_attributes );
		}
	}
	
	ob_start();
		@wp_list_widgets();
		$content = str_replace( array( '<script', '</script>' ), array( '&lt;script', '&lt;/script&gt;' ), ob_get_contents() );
	ob_end_clean();
	
	echo $content;
	
?></div>
</script>
