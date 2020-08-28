<?php
/**
 * Displays tags on single posts
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
if ( ! get_theme_mod( 'wpex_post_tags', true ) ) {
	return;
}

// Display tags if enabled
the_tags( '<div class="post-tags"><span class="strong">'. __( 'Tags', 'spartan' ).':</span> ', ', ', '</div>' );