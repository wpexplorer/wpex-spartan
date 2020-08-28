<?php
/**
 * Template Name: Contributors
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

get_header(); ?>
	<div id="primary" class="content-area clr">
		<div id="content" class="site-content left-content" role="main">
			<header class="archive-header clr">
				<h1 class="archive-header-title"><?php the_title(); ?></h1>
			</header><!-- #page-header -->
			<?php
			// Start loop
			while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" class="clr">
					<div class="entry clr">
						<?php the_content(); ?>
					</div><!-- .entry -->
					<?php
					// Get a list of users
					$contributors = get_users(
						array(
							'orderby'	=> 'post_count',
							'role'		=> 'contributor',
							'order'		=> 'DESC',
						)
					);
					$administrators = get_users(
						array(
							'orderby'	=> 'post_count',
							'role'		=> 'administrator',
							'order'		=> 'DESC',
						)
					);
					$users = array_merge( $contributors, $administrators )?>
					<div id="contributors-template-wrap" class="clr">
						<?php
						// Loop through authors
						foreach( $users as $wpex_contributor ) {
							get_template_part( 'partials/contributor' );
						} ?>
					</div><!-- #contributors-template-wrap -->
				</article><!-- #post -->
			<?php
			// End loop
			endwhile; ?>
		</div><!-- #content -->
		<?php get_sidebar(); ?>
	</div><!-- #primary -->
<?php get_footer(); ?>