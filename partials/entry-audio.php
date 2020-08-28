<?php
/**
 * Displays the post entry audio
 * The default layout in this theme is to display the thumbnail for entries
 *
 * @package		Spartan
 * @subpackage	Partials
 * @author		Alexander Clarke
 * @copyright	Copyright (c) 2014, Symple Workz LLC
 * @link		http://www.wpexplorer.com
 * @since		1.1.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return if disabled
if ( ! get_theme_mod( 'wpex_blog_entry_thumb', true ) ) {
	return;
}

// Return if there isn't any thumbnail defined
if ( ! has_post_thumbnail() ) {
	return;
} ?>

<div class="loop-entry-media clr">
	<?php
	// Cateogory tag
	wpex_category_tag(); ?>
	<figure class="loop-entry-thumbnail">
		<?php if ( get_theme_mod( 'wpex_entry_img_lightbox' ) ) { ?>
			<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" class="wpex-lightbox">
		<?php } else { ?>
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
		<?php } ?>
			<?php $img = wpex_image( 'array' ); ?>
			<div class="post-thumbnail">
				<img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" width="<?php echo esc_attr( $img['width'] ); ?>" height="<?php echo esc_attr( $img['height'] ); ?>" />
			</div><!-- .post-thumbnail -->
			<span class="loop-entry-audio-overlay"></span>
		</a>
	</figure><!-- .loop-entry-thumbnail -->
</div><!-- .loop-entry-media -->