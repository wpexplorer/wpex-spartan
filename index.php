<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
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
			<?php
			// Display posts
			if ( have_posts() ) :
				// Home top ad
				wpex_ad_spot( 'home-top' );
				// Get homepage slider
				if ( is_home() && ! is_paged() ) {
					get_template_part( 'partials/homepage', 'slider' );
				} ?>
				<?php if ( is_home() && is_front_page() ) { ?>
					<header class="archive-header clr">
						<h1 class="archive-header-title"><?php echo _e( 'Latest News', 'spartan' ); ?></h1>
						<?php if ( have_posts() ) { ?>
							<span class="layout-toggle"><span class="fa fa-bars"></span></span>
						<?php } ?>
					</header><!-- .archive-header -->
				<?php } ?>
 				<div id="blog-wrap" class="clr">
					<?php
					$wpex_count='0';
					while ( have_posts() ) : the_post();
						$wpex_count++;
						get_template_part( 'partials/entry', 'layout' );
						if ( '2' == $wpex_count ) {
							$wpex_count = '0';
						}
					endwhile; ?>
				</div><!-- #blog-wrap -->
				<?php wpex_get_pagination(); ?>
				<?php
				// Home bottom ad
				wpex_ad_spot( 'home-bottom' ); ?>
			<?php else : ?>
				<?php get_template_part( 'partials/entry', 'none' ); ?>
			<?php endif; ?>
		</div><!-- #content -->
		<?php get_sidebar(); ?>
	</div><!-- #primary -->

<?php get_footer(); ?>