<?php

$output = $title = $description = $video_info = $source = $video_upload = $animateeffect = $output = '';
$animateswitch = 'no';
$video_height = '250';
$check_video = 'true';

extract( $atts );

if(!empty($video_width)){
	$video_height = intval($video_width)/1.77;
}

if( isset( $_GET['or_action'] ) && $_GET['or_action'] === 'live-editor' )
	$is_live = true;
else $is_live = false;

$video_link = (!empty($video_link))?$video_link:'https://www.youtube.com/watch?v=iNJdPyoqt8U'; //default video

//Check youtube video url
$pattern = '~
	^(?:https?://)?              # Optional protocol
	 (?:www\.)?                  # Optional subdomain
	 (?:youtube\.com|youtu\.be)  # Mandatory domain name
	 /watch\?v=([^&]+)           # URI with video id as capture group 1
	 ~x';

$has_match = preg_match($pattern, $video_link, $matches);

$video_attributes = array();

$video_classes = array(
	'or_shortcode',
	'or_video_play',
	'or_video_wrapper',
	$wrap_class,
	isset($atts['css'])?$atts['css']:''
);

$video_attributes[] = 'class="'. esc_attr( implode(' ', $video_classes) ) .'"';

if( !$is_live && empty( $video_upload ) ){
	$video_attributes[] = 'data-video="'. esc_attr( $video_link ) .'"';
	$video_attributes[] = 'data-width="'. esc_attr( $video_width ) .'"';
	$video_attributes[] = 'data-height="'. esc_attr($video_height) .'"';
	$video_attributes[] = 'data-fullwidth="'. esc_attr( $full_width ) .'"';
	$video_attributes[] = 'data-autoplay="'. esc_attr( $auto_play ) .'"';
}

if( !empty($title) ) $video_info .= '<h3>'. $title .'</h3>';
if( !empty($description) ) $video_info .= '<p>'.$description.'</p>';

$output .= '<div class="video-info">'. $video_info .'</div>';
$output .= '<div '. implode(' ', $video_attributes) .'>';

if( $is_live ){
	$output .= '<div style="height:'.$video_height.'px;width:'.$video_width.'" class="disable-view-element">'
			.'<h3>For best perfomance, the video map has been disabled in this editing mode.</h3>'
			.'</div>';
}else if( !empty( $video_upload ) ){
	
	$autoplay = '';
	if( $auto_play == 'yes' )
		$autoplay = 'autoplay';
		
	$output .= '<video width="'.esc_attr( $video_width ).'" height="'.esc_attr( $video_height ).'" controls '.$autoplay.'><source src="'.esc_url($video_upload).'" type="video/mp4">Your browser does not support the video tag.</video>';
	
}

$output .= '</div>';

wp_enqueue_script( 'or-video-play' );

$effect = 'animated '.$animateeffect;

if($animateswitch == 'yes'){
	if($animateevent == 'onload'){
		$output = "<div class='wow ".$effect."' data-wow-duration='1s' data-wow-delay='0.5s'>".$output."</div>";
	}else{
		$output = "<div ".($animateevent == 'onclick' ? "onClick='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '')." ".($animateevent == 'onhover' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : '').">".$output."</div>";
	}
}


if( $check_video === 'true' ){
	echo $output;
}else{
	echo __('Origin Bulider error: Video format url incorrect', 'Origin Bulider');
}
