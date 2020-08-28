<?php
/**
 * Outputs the metaviewport tag for the site head
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
}

// Responsive Meta Tag
if ( get_theme_mod( 'wpex_responsive', true ) ) { ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<?php }
// Non Responsive Meta tag
else { ?>
	<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
<?php } ?>