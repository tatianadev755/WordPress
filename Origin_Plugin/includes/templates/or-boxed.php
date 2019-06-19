<?php
global $post;
$header = get_post_meta( $post->ID, 'or_hide_header', true );
//$footer = get_post_meta( $post->ID, 'or_hide_footer', true );

$bg_style = get_post_meta($post->ID, 'or_bg_style', true);
?>
<?php if( ! (bool) $header ) get_header(); else{ ?>
	<!DOCTYPE html>
	<html <?php language_attributes(); ?>>
	<head>
	<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
	<?php echo '<div class="or_boxeddiv">'; ?>
<?php } ?>

<?php if($bg_style == 'video'){ ?>
<script async src="https://www.youtube.com/iframe_api"></script>
<?php $videourl = get_post_meta($post->ID, 'or_primary_bg_video', true); $mute = get_post_meta($post->ID, 'or_primary_bg_video_unmute', true); ?>
	<div class="video-background or_video_box">
    <div class="video-foreground .embed-responsive embed-responsive-16by9"><div id="player" class="embed-responsive-item"><div id="muteYouTubeVideoPlayer"></div><!--<iframe src="<?php //echo get_post_meta($post->ID, 'or_primary_bg_video', true); ?>?autoplay=1" frameborder="0" allowfullscreen></iframe>--></div>
	</div>
	</div>
<script>
function YouTubeGetID(url){
  var ID = '';
  url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
  if(url[2] !== undefined) {
    ID = url[2].split(/[^0-9a-z_\-]/i);
    ID = ID[0];
  }
  else {
    ID = url;
  }
    return ID;
}

 function onYouTubeIframeAPIReady() {
  var player;
  player = new YT.Player('muteYouTubeVideoPlayer', {
    videoId: YouTubeGetID('<?php echo $videourl; ?>'), // YouTube Video ID
    width: 560,               // Player width (in px)
    height: 316,              // Player height (in px)
    playerVars: {
      autoplay: 1,        // Auto-play the video on load
      controls: 1,        // Show pause/play buttons in player
      showinfo: 0,        // Hide the video title
      modestbranding: 1,  // Hide the Youtube Logo
      loop: 1,            // Run the video in a loop
      fs: 0,              // Hide the full screen button
      cc_load_policty: 0, // Hide closed captions
      iv_load_policy: 3,  // Hide the Video Annotations
      autohide: 0         // Hide video controls when playing
    },
    events: {
      onReady: function(e) {
			<?php if( !((bool) $mute) ){ ?>
				e.target.mute();
			<?php } ?>
      }
    }
  });
 }
 
 // Written by @labnol 
</script>
<?php } ?>
	<?php  while ( have_posts() ) : the_post(); ?>
		
			<h1><?php the_title(); ?></h1>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'originbuilder' ) ); ?>
			<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
		
	<?php endwhile; ?>
	<div class="clearfix"></div>
<?php if( ! (bool) $header ) get_footer(); else{ echo '</div>';  wp_footer(); echo '<body>'; } ?>