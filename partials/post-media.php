<?php
/**
 * Single post media
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

// Get post format
$format = get_post_format();
// Gets the correct template part for each post format
if ( 'video' == $format ) {
	get_template_part( 'partials/post-video' );
} elseif ( 'audio' == $format ) {
	get_template_part( 'partials/post-audio' );
} elseif ( 'gallery' == $format ) {
	get_template_part( 'partials/post-gallery' );
} else {
	get_template_part( 'partials/post-thumbnail' );
}