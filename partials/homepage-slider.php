<?php
/**
 * Used to display a featured category slider
 *
 * @package		WordPress
 * @subpackage	Spartan WPExplorer Theme
 * @since		Spartan 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Homepage slider alternative
$slider_alt = get_theme_mod( 'wpex_homepage_slider_alt' );

if ( $slider_alt ) {
	echo '<div id="home-slider-wrap" class="clr">'. do_shortcode( $slider_alt ) .'</div>';
	return;
}

// Get slider content
$slider_content = get_theme_mod( 'wpex_homepage_slider_content', 'recent_posts' );

// Show homepage featured slider if theme panel category isn't blank
if ( $slider_content && 'none' != $slider_content && get_theme_mod( 'wpex_homepage_slider_count', '3' ) >= 1 ) :

	if ( 'recent_posts' != $slider_content ) {
		$wpex_tax_query = array (
			array (
				'taxonomy'	=> 'category',
				'field'		=> 'ID',
				'terms'		=> $slider_content,
			),
		);
	} else {
		$wpex_tax_query = NULL;
	}
		
	// Get posts based on featured category
	$wpex_query = new WP_Query( array(
		'post_type'				=>'post',
		'posts_per_page'		=> get_theme_mod( 'wpex_homepage_slider_count', '3' ),
		'no_found_rows'			=> true,
		'meta_key'				=> '_thumbnail_id',
		'tax_query'				=> $wpex_tax_query,
		'ignore_sticky_posts'	=> true,
	) );

	// Add filters for child thememing
	$wpex_query = apply_filters( 'wpex_featured_slider_query_args', $wpex_query );
	
	// If posts are found display slider
	if ( $wpex_query->have_posts() ) { ?>
		<div id="home-slider-wrap" class="clr">
			<div id="home-slider" class="owl-carousel">
				<?php
				$wpex_count='0';
				// Loop through each post
				while( $wpex_query->have_posts() ) : $wpex_query->the_post();
				$wpex_count++;
					if ( has_post_thumbnail() ) {
						$img_width		= get_theme_mod( 'wpex_home_slider_img_width', '620' );
						$img_height		= get_theme_mod( 'wpex_home_slider_img_height', '350' );
						$img_crop		= ( '9999' == $img_height ) ? false : true;
						$cropped_image	= wpex_img_resize( wp_get_attachment_url( get_post_thumbnail_id() ), $img_width, $img_height, $img_crop, 'array' );
						$excerpt		= wpex_excerpt( '25', false, false );
						if ( isset( $cropped_image['url'] ) ) { ?>
						<div class="home-slider-slide" data-dot="<?php echo esc_attr( $wpex_count ); ?>">
							<?php
							// Display category ID
							$wpex_category = get_the_category();
							if ( 'recent_posts' != $slider_content && isset( $wpex_category[0] ) ) {
								if ( $wpex_category[0]->term_id == $slider_content && isset( $wpex_category[1] ) ) {
									$wpex_cat_tag_id = $wpex_category[1]->term_id;
								} else {
									$wpex_cat_tag_id = '';
								}
							} else {
								$wpex_cat_tag_id = '';
							}
							wpex_category_tag( $wpex_cat_tag_id ); ?>
							<div class="home-slider-media">
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
									<img src="<?php echo esc_url( $cropped_image['url'] ); ?>" alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id( get_the_ID() ), '_wp_attachment_image_alt', true ) ); ?>" height="<?php echo esc_attr( $cropped_image['height'] ); ?>" width="<?php echo esc_attr( $cropped_image['width'] ); ?>" />
								</a>
							</div><!-- .home-slider-media -->
							<div class="home-slider-caption clr">
								<h2 class="home-slider-caption-title">
									<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id( get_the_ID() ), '_wp_attachment_image_alt', true ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
								</h2>
								<?php if ( $excerpt ) { ?>
									<div class="home-slider-caption-excerpt clr">
										<?php echo wp_kses_post( $excerpt ); ?>
									</div><!-- .home-slider-caption-excerpt -->
								<?php } ?>
							</div><!--.home-slider-caption -->
						</div><!-- .home-slider-slide-->
					<?php
					}
				}
				endwhile; ?>
			</div><!-- #home-slider -->
			<div id="home-slider-numbers"></div>
		</div><!-- #home-slider-wrap -->
	<?php } //End $wpex_query->have_posts check
	// Reset post data to prevent query issues
	wp_reset_postdata();
endif;