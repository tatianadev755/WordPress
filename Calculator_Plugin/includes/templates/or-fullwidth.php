<?php
global $post;
$header = get_post_meta( $post->ID, 'or_hide_header', true );
$footer = get_post_meta( $post->ID, 'or_hide_footer', true );
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
	<?php  while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?> id="page-<?php the_ID(); ?>">
			<h1><?php the_title(); ?></h1>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'originbuilder' ) ); ?>
			<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
		</article>
	<?php endwhile; ?>
	<div class="clearfix"></div>
<?php if( ! (bool) $header ) get_footer(); else{ wp_footer(); echo '</div>'; } ?>