<?php
/**
 * The template for displaying Author bios.
 *
 * @package     Spartan
 * @subpackage  Partials
 * @author      Alexander Clarke
 * @copyright   Copyright (c) 2014, Symple Workz LLC
 * @link        http://www.wpexplorer.com
 * @since       1.1.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Return if quote type
if ( 'quote' == get_post_format() ) {
	return;
}

// Return if disabled via theme mods
if ( ! get_theme_mod( 'wpex_post_author', true ) ) {
	return;
}

// Return if disabled via custom field
if ( 'on' == get_post_meta( get_the_ID(), 'wpex_disable_author', true ) ) {
	return;
} ?>

<div class="author-bio clr">
	<div class="author-bio-avatar clr">
		<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php _e( 'Visit Author Page', 'spartan' ); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'wpex_author_bio_avatar_size', 60 ) ); ?></a>
	</div><!-- .author-bio-avatar -->
	<div class="author-bio-content clr">
		<div class="author-bio-author clr">
			<?php _e( 'Authored by', 'spartan' ); ?>: <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php _e( 'Visit Author Page', 'spartan' ); ?>"><?php echo get_the_author(); ?></a></div>
		<?php if ( get_the_author_meta( 'url', $post->post_author ) ) { ?>
			<div class="author-bio-url">
				<?php if ( get_the_author_meta( 'wpex_website', $post->post_author ) ) { ?>
					<span><?php _e( 'Website', 'spartan' ); ?>:</span> <a href="<?php echo get_the_author_meta( 'url', $post->post_author ); ?>" title=""><?php echo get_the_author_meta( 'wpex_website', $post->post_author ); ?></a>
				<?php } else { ?>
				<a href="<?php echo get_the_author_meta( 'url', $post->post_author ); ?>" title=""><?php echo get_the_author_meta( 'url', $post->post_author ); ?></a>
				<?php } ?>
			</div>
		<?php } ?>
		<p><?php the_author_meta( 'description' ); ?></p>
	</div><!-- .author-bio-content -->
	<div class="author-bio-social clr">
		<?php
		// Display twitter url
		if ( get_the_author_meta( 'wpex_twitter', $post->post_author ) ) { ?>
			<a href="<?php echo get_the_author_meta( 'wpex_twitter', $post->post_author ); ?>" title="Twitter" class="twitter" target="_blank"><span class="fa fa-twitter"></span></a>
		<?php }
		// Display facebook url
		if ( get_the_author_meta( 'wpex_facebook', $post->post_author ) ) { ?>
			<a href="<?php echo get_the_author_meta( 'wpex_facebook', $post->post_author ); ?>" title="Facebook" class="facebook" target="_blank"><span class="fa fa-facebook"></span></a>
		<?php }
		// Display google plus url
		if ( get_the_author_meta( 'wpex_googleplus', $post->post_author ) ) { ?>
			<a href="<?php echo get_the_author_meta( 'wpex_googleplus', $post->post_author ); ?>" title="Google Plus" class="google-plus" target="_blank"><span class="fa fa-google-plus"></span></a>
		<?php }
		// Display Linkedin url
		if ( get_the_author_meta( 'wpex_linkedin', $post->post_author ) ) { ?>
			<a href="<?php echo get_the_author_meta( 'wpex_linkedin', $post->post_author ); ?>" title="LinkedIn" class="linkedin" target="_blank"><span class="fa fa-linkedin"></span></a>
		<?php }
		// Display pinterest plus url
		if ( get_the_author_meta( 'wpex_pinterest', $post->post_author ) ) { ?>
			<a href="<?php echo get_the_author_meta( 'wpex_pinterest', $post->post_author ); ?>" title="Pinterest" class="pinterest" target="_blank"><span class="fa fa-pinterest"></span></a>
		<?php }
		// Display instagram plus url
		if ( get_the_author_meta( 'wpex_instagram', $post->post_author ) ) { ?>
			<a href="<?php echo get_the_author_meta( 'wpex_instagram', $post->post_author ); ?>" title="Instagram" class="instagram" target="_blank"><span class="fa fa-instagram"></span></a>
		<?php } ?>
	</div><!-- .author-bio-social -->
</div><!-- .author-bio -->