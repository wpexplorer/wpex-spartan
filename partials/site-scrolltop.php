<?php
/**
 * Ouputs the back to top button
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

// Return if disabled
if ( ! get_theme_mod( 'wpex_scroll_top', true ) ) {
	return;
} ?>

<a href="#" class="site-scroll-top"><span class="fa fa-arrow-up"></span></a>