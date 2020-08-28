<?php
/**
 * Footer navigation
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

// Outputs the footer nav
wp_nav_menu( array(
	'container'			=> false,
	'theme_location'	=> 'footer_menu',
	'sort_column'		=> 'menu_order',
	'menu_class'		=> 'footer-nav clr',
	'fallback_cb'		=> false,
) );