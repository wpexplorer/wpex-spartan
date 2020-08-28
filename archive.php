<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area clr">
		<div id="content" class="site-content left-content clr" role="main">
			<header class="archive-header clr">
				<h1 class="archive-header-title">
					<?php if ( single_term_title( '', false ) ) : ?>
						<?php single_term_title(); ?>
					<?php else : ?>
						<?php the_archive_title(); ?>
					<?php endif; ?>
					<?php wpex_grid_toggle(); ?>
				</h1>
			</header><!-- .archive-header -->
			<?php if ( have_posts() ) : ?>
				<div id="blog-wrap" class="clr">
					<?php if ( term_description() ) { ?>
						<div class="archive-description clr">
							<?php echo term_description(); ?>
						</div><!-- #archive-description -->
					<?php }
					// Content bottom ad
					wpex_ad_spot( 'archive-top', false );
					// Define counter var
					if ( ! is_paged() ) {
						$wpex_count='-1';
					} else {
						$wpex_count='0';
					}
					// The loop
					while ( have_posts() ) : the_post();
					$wpex_count++;
						// First post
						if ( '0' == $wpex_count
							&& has_post_thumbnail()
							&& get_theme_mod( 'wpex_archive_feature_first_post', true )
							&& ! is_paged() && $wp_query->found_posts > 1 ) {
							get_template_part( 'partials/archive-featured', 'post' );
						}
						// All other posts
						else {
							if ( '0' == $wpex_count ) {
								$wpex_count = '1';
							}
							get_template_part( 'partials/entry', 'layout' );
						}
						if ( '2' == $wpex_count ) {
							$wpex_count = '0';
						}
					endwhile; ?>
				</div><!-- #blog-wrap -->
				<?php wpex_get_pagination(); ?>
				<?php
				// Content bottom ad
				wpex_ad_spot( 'archive-bottom' ); ?>
			<?php else : ?>
				<?php get_template_part( 'partials/entry', 'none' ); ?>
			<?php endif; ?>
		</div><!-- #content -->
		<?php get_sidebar(); ?>
	</div><!-- #primary -->

<?php get_footer(); ?>