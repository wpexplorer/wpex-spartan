<?php
/**
 * The default template for displaying post entries.
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

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clr' ); ?>>
	<?php get_template_part( 'partials/entry', 'media' ); ?>
	<div class="loop-entry-content clr">
		<?php get_template_part( 'partials/entry-title' ); ?>
		<?php get_template_part( 'partials/entry-meta' ); ?>
		<?php get_template_part( 'partials/entry-content' ); ?>
	</div><!-- .loop-entry-content -->
</article><!-- .loop-entry -->