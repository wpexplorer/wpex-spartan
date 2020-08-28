<?php
/**
 * Displays the single post video
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

// Get gallery slides
$slides = wpex_get_gallery_ids();

// Display gallery if there are slides
if ( $slides ) : ?>
	<div class="single-post-media clr">
		<div class="post-gallery owl-carousel">
				<?php
				// Loop through each image in each gallery
				foreach( $slides as $attachment ) {
					// Get attachment data
					$attachment_data	= wpex_get_attachment( $attachment );
					$full_img			= wp_get_attachment_url( $attachment );
					$img				= wpex_image( 'array', $attachment );
					$img_url			= ! empty( $img['url'] ) ? $img['url'] : '';
					$alt				= isset( $attachment_data['alt'] ) ? $attachment_data['alt'] : '';
					$thumb_width		= apply_filters( 'wpex_gallery_thumb_width', '65' );
					$thumb_height		= apply_filters( 'wpex_gallery_thumb_height', '65' );
					$thumb_crop			= apply_filters( 'wpex_gallery_thumb_crop', true );
					// Display Image
					if ( $img_url ) { ?>
						<div data-dot='<img src="<?php echo wpex_img_resize( $full_img, $thumb_width, $thumb_height, $thumb_crop ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />'>
							<figure>
								<?php if ( wpex_gallery_is_lightbox_enabled() ) { ?>
									<a href="<?php echo esc_url( $full_img ); ?>" title="<?php echo esc_attr( $alt ); ?>" class="post-gallery-lightbox-item">
								<?php } ?>
								<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $alt ); ?>" width="<?php echo esc_attr(  $img['width'] ); ?>" height="<?php echo esc_attr( $img['height'] ); ?>" />
								<?php if ( wpex_gallery_is_lightbox_enabled() ) {
									echo '<span class="overlay"></span></a>';
								} ?>
								<?php if ( is_singular() && '' != $attachment_data['caption'] ) { ?>
									<div class="post-gallery-caption"><?php echo wp_kses_post( $attachment_data['caption'] ); ?></div>
								<?php } ?>
							</figure>
						</div>
					<?php } ?>
				<?php } ?>
			</div><!-- .post-gallery -->
		</div><!-- .single-post-media -->
<?php
// If there aren't any gallery items display the thumbnail
elseif ( has_post_thumbnail() ) :

	// Get featured image, see @inc/featured-image.php
	$img = wpex_image( 'array' );

	// Return if array is empty
	if ( empty( $img ) ) {
		return;
	} ?>
	<div class="single-post-media clr">
		<div class="post-thumbnail">
			<img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" width="<?php echo esc_attr( $img['width'] ); ?>" height="<?php echo esc_attr( $img['height'] ); ?>" />
		</div><!-- .post-thumbnail -->
	</div><!-- .single-post-media -->
<?php endif; ?>