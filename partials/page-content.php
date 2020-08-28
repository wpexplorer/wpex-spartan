<?php
/**
 * Single page content
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
    <?php the_content(); ?>
    <?php get_template_part( 'partials/post-link', 'pages' ); ?>
    <?php get_template_part( 'partials/post', 'edit' ); ?>
</div><!-- .entry -->