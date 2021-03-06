<?php
/**
 * Displays the post entry video
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

// Get post video
$has_video = wpex_post_has_video();

// Display post video
if ( $has_video
	&& get_theme_mod( 'wpex_entry_embeds' )
	&& 'on' != get_post_meta( get_the_ID(), 'wpex_disable_entry_embed', true ) ) { ?>
	<div class="loop-entry-media clr">
		<?php echo wpex_post_video(); ?>
	</div><!-- .loop-entry-media -->
<?php } elseif ( has_post_thumbnail() ) { ?>
	<div class="loop-entry-media clr">
		<?php
		// Cateogory tag
		wpex_category_tag(); ?>
		<figure class="loop-entry-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
				<?php $img = wpex_image( 'array' ); ?>
				<div class="post-thumbnail">
					<img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" width="<?php echo esc_attr( $img['width'] ); ?>" height="<?php echo esc_attr( $img['height'] ); ?>" />
				</div><!-- .post-thumbnail -->
				<span class="loop-entry-video-overlay"></span>
			</a>
		</figure><!-- .post-entry-thumbnail -->
	</div><!-- .loop-entry-media -->
<?php } ?>