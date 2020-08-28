<?php
/**
 * The template for displaying Author archive pages.
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
			<?php if ( have_posts() ) : the_post(); ?>
				<header class="archive-header clr">
					<div class="author-archive-gravatar clr">
						<?php echo get_avatar( get_the_author_meta('user_email'), '60'); ?>
					</div>
					<h1 class="archive-header-title"><?php _e( 'Articles Written By', 'spartan' ); ?>: <?php echo get_the_author() ?></h1>
					<div class="archive-description clr">
						<?php
						// Display post count
						$wpex_post_count = count_user_posts( get_query_var( 'author' ) );
						if ( '1' == $wpex_post_count ) {
							_e( 'This author has written 1 article', 'spartan' );
						} else {
							echo sprintf( __( 'This author has written %s articles', 'spartan' ), $wpex_post_count );
						} ?>
					</div><!-- #archive-description -->
					<?php
					// Display grid toggle, see functions/categories.php
					wpex_grid_toggle(); ?>
				</header><!-- .archive-header -->
				<?php rewind_posts(); ?>
				<div id="blog-wrap" class="clr">
					<?php if ( term_description() ) { ?>
						<div class="archive-description clr">
							<?php echo term_description(); ?>
						</div><!-- #archive-description -->
					<?php } ?>
					<?php if ( ! is_paged() ) {
						$wpex_count='-1';
					} else {
						$wpex_count='0';
					} ?>
					<?php while ( have_posts() ) : the_post(); ?>
					<?php $wpex_count++; ?>
						<?php if ( '0' == $wpex_count
							&& has_post_thumbnail()
							&& get_theme_mod( 'wpex_cat_feature_first_post', true )
							&& ! is_paged() ) { ?>
							<?php get_template_part( 'partials/archive-featured', 'post' ); ?>
						<?php } else { ?>
							<?php get_template_part( 'partials/entry', 'layout' ); ?>
						<?php } ?>
					<?php if ( '2' == $wpex_count ) { ?>
						<?php $wpex_count = '0'; ?>
					<?php } ?>
					<?php endwhile; ?>
				</div><!-- #blog-wrap -->
				<?php wpex_get_pagination(); ?>
				<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
				<?php endif;
				// Content bottom ad
				wpex_ad_spot( 'archive-bottom' ); ?>
		</div><!-- #content -->
		<?php get_sidebar(); ?>
	</div><!-- #primary -->

<?php get_footer(); ?>