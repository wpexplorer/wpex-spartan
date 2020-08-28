<?php
/**
 * Topbar date
 *
 * @package     Spartan
 * @subpackage  Partials
 * @author      Alexander Clarke
 * @copyright   Copyright (c) 2014, Symple Workz LLC
 * @link        http://www.wpexplorer.com
 * @since       1.1.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Return if menu isn't set to this region
if ( ! has_nav_menu( 'top_menu' ) ) {
	return;
} ?>

<div id="topbar-nav" class="cr">
	<?php wp_nav_menu( array(
		'theme_location'	=> 'top_menu',
		'sort_column'		=> 'menu_order',
		'menu_class'		=> 'top-nav sf-menu',
		'fallback_cb'		=> false,
		'walker'			=> new WPEX_Top_Walker_Nav_Menu(),
	) ); ?>
</div><!-- #topbar-nav -->