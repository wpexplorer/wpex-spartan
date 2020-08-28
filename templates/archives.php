<?php
/**
 * Template Name: Archives
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

get_header(); ?>
	<div id="primary" class="content-area clr">
		<div id="content" class="site-content left-content boxed-content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" class="clr archives-template">
					<?php if ( !is_front_page() ) { ?>
						<header class="page-header clr">
							<h1 class="page-header-title"><?php the_title(); ?></h1>
						</header><!-- #page-header -->
						<?php get_template_part( 'partials/page-thumbnail' ); ?>
					<?php } ?>
					<div class="entry clr">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links clr">', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->
					<div class="archives-template clr">
						<div class="archives-template-box">
							<h2><?php _e( 'Latest Posts', 'spartan' ); ?></h2>
							<ul>
								<?php
								query_posts( array(
									'post_type'      => 'post',
									'posts_per_page' => '10',
									'no_found_rows'  => true,
								) );
								$count=0;
								while ( have_posts() ) : the_post(); $count++; ?>
									<li>
										<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
									</li>
								<?php endwhile; wp_reset_query(); ?>
							</ul>
						</div><!-- .archives-template-box -->
						<div class="archives-template-box">
							<h2><?php _e( 'Archives by Month', 'spartan' ); ?></h2>
							<ul><?php wp_get_archives('type=monthly'); ?></ul>
						</div><!-- .archives-template-box -->
						<div class="archives-template-box">
							<h2><?php _e( 'Archives by Format', 'spartan' ); ?></h2>
							<ul>
								<li><a href="<?php echo get_post_format_link( 'gallery' ); ?>" title="<?php _e( 'Gallery', 'spartan' ); ?>"><?php _e( 'Gallery', 'spartan' ); ?></a></li>
								<li><a href="<?php echo get_post_format_link( 'video' ); ?>" title="<?php _e( 'Video', 'spartan' ); ?>"><?php _e( 'Video', 'spartan' ); ?></a></li>
								<li><a href="<?php echo get_post_format_link( 'audio' ); ?>" title="<?php _e( 'Audio', 'spartan' ); ?>"><?php _e( 'Audio', 'spartan' ); ?></a></li>
								<li><a href="<?php echo get_post_format_link( 'quote' ); ?>" title="<?php _e( 'Quotes', 'spartan' ); ?>"><?php _e( 'Quotes', 'spartan' ); ?></a></li>
							</ul>
						</div><!-- .archives-template-box -->
						<div class="archives-template-box">
							<h2><?php _e( 'Archives by Category', 'spartan' ); ?></h2>
							<ul><?php wp_list_categories( 'title_li=&hierarchical=0' ); ?></ul>
						</div><!-- .archives-template-box -->
					</div><!-- .archives-template -->
				</article><!-- #post -->
			<?php endwhile; ?>
		</div><!-- #content -->
		<?php
		// Get sidebar if post layout meta isn't set to fullwidth
		if( 'fullwidth' != get_post_meta( get_the_ID(), 'wpex_post_layout', true ) ) {
			get_sidebar();
		} ?>
	</div><!-- #primary -->
<?php get_footer(); ?>