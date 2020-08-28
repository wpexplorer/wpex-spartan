<?php
/**
 * Used to display a featured category carousel
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get carousel content
$carousel_content = get_theme_mod( 'wpex_homepage_carousel_content', 'recent_posts' );

// Show homepage featured carousel if theme panel category isn't blank
if ( $carousel_content && 'none' != $carousel_content && get_theme_mod( 'wpex_homepage_carousel_count', '8' ) >= 1 ) {

	if ( 'recent_posts' != $carousel_content ) {
		$tax_query = array (
			array (
				'taxonomy'	=> 'category',
				'field'		=> 'ID',
				'terms'		=> $carousel_content,
			),
		);
	} else {
		$tax_query = NULL;
	}
		
	// Get posts based on featured category
	$wpex_query = new WP_Query( array(
		'post_type'				=>'post',
		'posts_per_page'		=> get_theme_mod( 'wpex_homepage_carousel_count', '8' ),
		'no_found_rows'			=> true,
		'meta_key'				=> '_thumbnail_id',
		'tax_query'				=> $tax_query,
		'ignore_sticky_posts'	=> true,
	) );

	// Add filters for child thememing
	$wpex_query = apply_filters( 'wpex_featured_carousel_query_args', $wpex_query );
	
	// If posts are found display slider
	if ( $wpex_query->have_posts() ) { ?>
		<div class="featured-carousel-wrap clr">
			<h2 class="heading"><?php echo get_theme_mod( 'wpex_homepage_carousel_heading', __( 'Featured', 'spartan' ) ); ?></h2>
			<div class="featured-carousel owl-carousel clr count-<?php echo count( $wpex_query->posts ); ?>">
				<?php
				// Loop through each post
				foreach( $wpex_query->posts as $post ) : setup_postdata( $post );
					if ( has_post_thumbnail() ) {
						$img_width = get_theme_mod( 'wpex_home_carousel_img_width', '620' );
						$img_height = get_theme_mod( 'wpex_home_carousel_img_height', '350' );
						$img_crop = ( '9999' == $img_height ) ? false : true;
						$img = wpex_img_resize( wp_get_attachment_url( get_post_thumbnail_id() ), $img_width, $img_height, $img_crop, 'array' ); ?>
						<div class="featured-carousel-slide">
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
								<img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo the_title(); ?>" height="<?php echo esc_attr( $img['height'] ); ?>" width="<?php echo esc_attr( $img['width'] ); ?>" />
								<?php the_title(); ?>
							</a>
						</div><!-- .featured-carousel-->
					<?php }
				endforeach; ?>
			</div><!-- .featured-carousel -->
		</div><!-- .featured-carousel-wrap -->
	<?php } ?>
	<?php wp_reset_postdata(); ?>
<?php } ?>