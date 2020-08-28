<?php
/**
 * Single post content
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
} ?>

<div class="entry clr">
	<?php
	// Post top ad
	wpex_ad_spot( 'post-top' );

	// Post Content
	the_content();

	// Paginate posts when using <!--nextpage-->
	wp_link_pages( array(
		'before'		=> '<div class="page-links clr">',
		'after'			=> '</div>',
		'link_before'	=> '<span>',
		'link_after' 	=> '</span>',
	) );

	// Post bottom ad
	wpex_ad_spot( 'post-bottom' );  ?>
</div><!-- .entry -->