<?php
/**
 * Displays the featured entry for categories
 *
 * @package		Spartan
 * @subpackage	Partials
 * @author		Alexander Clarke
 * @copyright	Copyright (c) 2014, Symple Workz LLC
 * @link		http://www.wpexplorer.com
 * @since		1.1.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<article class="archive-featured-post clr">
	<div class="archive-featured-post-media clr">
		<figure class="archive-featured-post-thumbnail">
			<?php
			// Cateogory tag
			wpex_category_tag( get_query_var( 'cat' ), true ); ?>
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
				<?php $img = wpex_image( 'array' ); ?>
				<div class="post-thumbnail">
					<img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" width="<?php echo esc_attr( $img['width'] ); ?>" height="<?php echo esc_attr( $img['height'] ); ?>" />
				</div><!-- .post-thumbnail -->
			</a>
		</figure><!-- .archive-featured-post-thumbnail -->
	</div><!-- .archive-featured-post-media -->
	<div class="archive-featured-post-content clr">
		<header>
			<h2 class="archive-featured-post-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a>
			</h2>
		</header>
		<div class="archive-featured-post-excerpt clr">
			<?php wpex_excerpt( '25', false ); ?>
		</div><!-- .archive-featured-post-excerpt -->
	</div><!-- .archive-featured-post-content -->
</article><!-- .archive-featured-post -->