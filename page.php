<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

get_header(); ?>
	<div id="primary" class="content-area clr">
		<div id="content" class="site-content left-content clr" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'partials/page-layout' ); ?>
			<?php endwhile; ?>
		</div><!-- #content -->
		<?php get_sidebar(); ?>
	</div><!-- #primary -->
<?php get_footer(); ?>