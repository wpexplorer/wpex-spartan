<?php
/**
 * Template Name: Homepage
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

get_header(); ?>
	<div id="primary" class="content-area clr">
		<div id="content" class="site-content left-content boxed-content" role="main">
			<?php
			// Home top ad
			wpex_ad_spot( 'home-top' );
			// Get homepage slider
			get_template_part( 'partials/homepage', 'slider' );
			// Start main loop
			while ( have_posts() ) : the_post();
				// Get categories
				$wpex_cats = get_categories( array(
					'orderby'	=> 'name',
 					'parent'	=> 0,
				) );
				if ( $wpex_cats ) {?>
					<div class="home-cats clr">
						<?php
						$wpex_count = '0';
						// Loop through categories
						foreach ( $wpex_cats as $wpex_cat ) :
							if ( get_theme_mod( 'wpex_home_cat_' . $wpex_cat->term_id, '1' ) ) {
								$wpex_count++; ?>
								<div class="home-cat-entry clr col-<?php echo esc_attr( $wpex_count ); ?>">
									<h2 class="heading">
										<a href="<?php echo get_category_link( $wpex_cat->term_id ); ?>" title="<?php echo esc_html( $wpex_cat->name ); ?>">
											<?php echo esc_html( $wpex_cat->name ); ?>
										</a>
									</h2>
									<?php
									// Get posts from current cat
									$wpex_cat_posts = new WP_Query( array(
										'post_type'			=> 'post',
										'posts_per_page'	=> get_theme_mod( 'wpex_homepage_cat_entry_count', '6' ),
										'no_found_rows'		=> true,
										'post__not_in'		=> wpex_exclude_home_ids(),
										'tax_query'			=> array ( array (
											'taxonomy'		=> 'category',
											'field'			=> 'slug',
											'terms'			=> $wpex_cat->slug
										) ),
									) );
									if ( $wpex_cat_posts->posts ) { ?>
										<ul>
											<?php
											// Loop through category posts
											$wpex_count_2='';
											foreach( $wpex_cat_posts->posts as $post ) : setup_postdata( $post );
												$wpex_count_2++;
												// Display featured image for first post
												if( '1' == $wpex_count_2 ) {
													// Get cropped featured image
													$img_width = get_theme_mod( 'wpex_home_cat_img_width', '620' );
													$img_height = get_theme_mod( 'wpex_home_cat_img_width', '350' );
													$img_crop = ( '9999' == $img_height ) ? false : true;
													$wpex_img = wpex_img_resize( wp_get_attachment_url( get_post_thumbnail_id() ), $img_width, $img_height, $img_crop, 'array' ); ?>
													<li class="home-cat-entry-post-first clr">
														<div class="home-cat-entry-post-first-media clr">
															<?php
															// Display post video
															if ( 'video' == get_post_format() && get_theme_mod( 'wpex_home_video_embeds' ) && get_post_meta( get_the_ID(), 'wpex_post_video', true ) ) {
																wpex_post_video();
															}
															// Display thumbnail
															else { ?>
																<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
																	<img src="<?php echo esc_url( $wpex_img['url'] ); ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); ?>" width="<?php echo esc_attr( $wpex_img['width'] ); ?>" height="<?php echo esc_attr( $wpex_img['height'] ); ?>" />
																</a>
															<?php } ?>
															<?php
															// Category tag
															wpex_category_tag( $wpex_cat->term_id, true ); ?>
														</div>
														<h3 class="home-cat-entry-post-first-title">
															<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
																<?php the_title(); ?>
															</a>
														</h3>
														<p><?php echo strip_shortcodes( wp_trim_words( get_the_content(), '25', '&hellip;' ) ); ?></p>
													</li><!-- .home-cat-entry-post-firs -->
												<?php }
												// Display simple entries for other posts
												else { ?>
													<li class="home-cat-entry-post-other clr">
														<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a>
													</li><!-- .home-cat-entry-post-other -->
												<?php } ?>
											<?php endforeach; ?>
										</ul>
									<?php } ?>
								</div><!-- .home-cat-entry -->
						<?php }
						// End category loop
						if( '2' == $wpex_count ) {
							$wpex_count = '0';
						}
						endforeach; ?>
					</div><!-- .home-cats -->
				<?php } ?>
			<?php
			// Get homepage carousel
			get_template_part( 'partials/homepage', 'carousel' );
			// End main loop
			endwhile;
			// Home bottom ad
			wpex_ad_spot( 'home-bottom' ); ?>
		</div><!-- #content -->
		<?php
		// Get sidebar if post layout meta isn't set to fullwidth
		if( 'fullwidth' != get_post_meta( get_the_ID(), 'wpex_post_layout', true ) ) {
			get_sidebar();
		} ?>
	</div><!-- #primary -->
<?php get_footer(); ?>