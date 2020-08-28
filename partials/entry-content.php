<?php
/**
 * Returns the correct template file for the post entry media.
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

<div class="loop-entry-excerpt entry clr">
	<?php if ( 'content' == get_theme_mod( 'wpex_entry_content_excerpt', 'excerpt' ) ) {
		the_content();
	} else {
		wpex_excerpt();
	} ?>
</div><!-- .loop-entry-excerpt -->