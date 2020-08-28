<?php
/**
 * Displays the post entry title
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

<header>
	<h2 class="loop-entry-title">
		<a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>">
			<?php the_title(); ?>
		</a>
	</h2>
	<?php get_template_part( 'entry', 'meta' ); ?>
</header>