<?php
/**
 * Edit post link
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

// Edit post link
if ( is_user_logged_in() && current_user_can( 'edit_post', get_the_ID() ) ) { ?>
    <footer class="entry-footer">
        <?php edit_post_link( __( 'Edit this post', 'spartan' ) .' &#8594;', '<span class="edit-link clr">', '</span>' ); ?>
    </footer><!-- .entry-footer -->
<?php } ?>