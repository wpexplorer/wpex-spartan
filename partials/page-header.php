<?php
/**
 * Single page header
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
if ( 'on' == get_post_meta( get_the_ID(), 'wpex_disable_page_title', true ) ) {
	return;
} ?>

<header class="page-header clr">
	<h1 class="page-header-title"><?php the_title(); ?></h1>
</header><!-- #page-header -->