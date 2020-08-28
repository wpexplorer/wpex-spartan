<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area clr">
		<div id="content" class="site-content left-content clr" role="main">
			<header class="archive-header clr">
				<h1 class="archive-header-title"><?php printf( __( 'Search Results for: %s', 'spartan' ), get_search_query() ); ?></h1>
				<?php if ( have_posts() ) { ?>
					<span class="layout-toggle"><span class="fa fa-bars"></span></span>
				<?php } ?>
			</header>
			<?php if ( have_posts() ) { ?>
				<div id="blog-wrap" class="clr">
					<?php
					$wpex_count='0';
					while ( have_posts() ) : the_post();
						$wpex_count++;
						get_template_part( 'partials/entry', 'layout' );
						if( '2' == $wpex_count ) {
							$wpex_count = '0';
						}
					endwhile; ?>
				</div><!-- #blog-wrap -->
				<?php wpex_get_pagination(); ?>
			<?php } else { ?>
				<?php get_template_part( 'partials/entry', 'none' ); ?>
			<?php } ?>
		</div><!-- #content -->
		<?php get_sidebar(); ?>
	</div><!-- #primary -->

<?php get_footer(); ?>