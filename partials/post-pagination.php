<?php
/**
 * Single post pagination (next/prev)
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
if ( ! get_theme_mod( 'wpex_next_prev', true ) ) {
    return;
} ?>

<div class="next-prev clr">
    <?php
    // Previous post link
    if( is_rtl() ) {
        $img = get_template_directory_uri() .'/images/next-post.png';
    } else {
        $img = get_template_directory_uri() .'/images/prev-post.png';
    }
    next_post_link(
        '<div class="post-prev">%link</div>',
        '<img src="'. $img .'" alt="'. __( 'Next Article', 'spartan' ) .'" />'. __( 'Previous Article', 'spartan' ) .''
    );
    // Next post link
    if( is_rtl() ) {
        $img = get_template_directory_uri() .'/images/prev-post.png';
    } else {
        $img = get_template_directory_uri() .'/images/next-post.png';
    }
    previous_post_link(
        '<div class="post-next">%link</div>',
        '<img src="'. $img .'" alt="'. __( 'Next Article', 'spartan' ) .'" />'. __( 'Next Article', 'spartan' ) .''
    ); ?>
</div><!-- .post-post-pagination -->