<?php

if( $data = json_decode( base64_decode(  $atts['data'] ) ) )
{
	foreach( $data as $name => $args )
	{
		global $wp_registered_widget_updates;
		if( isset( $wp_registered_widget_updates[ $name ] ) )
		{
			$widget_obj = $wp_registered_widget_updates[ $name ]['callback'][0];
			$wgclasses = $widget_obj->widget_options['classname'];
			if( isset( $atts['css'] ) && !empty( $atts['css'] ) )
				$wgclasses .= ' '.esc_attr($atts['css']);
			$before_widget = sprintf('<div class="widget %s">', $wgclasses );
			$default_args = array( 'before_widget' => $before_widget, 'after_widget' => "</div>", 'before_title' => '<h2 class="widgettitle">', 'after_title' => '</h2>' );
			$correct_args = array();
			
			foreach( $args as $k => $v )
				$correct_args[$k] = ctype_digit($v)?intval(trim($v)):$v;

			$merge = wp_parse_args( $widget_obj->control_options, wp_parse_args( $default_args, $correct_args ) );

			@$widget_obj->widget( $merge, $merge );
			
		}
	}
}
else
{
	echo 'WP Widget: Error data structure';	
}
