<?php
/**
 * Footer bottom
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

<div id="footer-bottom" class="clr">
    <div class="container clr">
        <?php if ( is_rtl() ) {
            get_template_part( 'partials/footer', 'nav' );
            get_template_part( 'partials/site', 'copyright' );
        } else {
            get_template_part( 'partials/site', 'copyright' );
            get_template_part( 'partials/footer', 'nav' );
        } ?>
    </div><!-- .container -->
</div><!-- #footer-bottom -->