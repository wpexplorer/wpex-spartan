<?php
/**
 * The standard page layout
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

<article id="post-<?php the_ID(); ?>" class="clr">
	<?php if ( ! is_front_page() ) { ?>
		<?php get_template_part( 'partials/page-thumbnail' ); ?>
		<?php get_template_part( 'partials/page-header' ); ?>
	<?php } ?>
	<?php get_template_part( 'partials/page-content' ); ?>
</article><!-- #post -->

<?php if ( get_theme_mod( 'wpex_page_comments' ) ) : ?>
	<?php comments_template(); ?>
<?php endif; ?>