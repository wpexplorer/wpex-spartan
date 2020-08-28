<?php
/**
 * Site Footer Layout
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

<footer id="footer-wrap" class="site-footer clr">
	<?php get_template_part( 'partials/footer-widgets' ); ?>
	<?php get_template_part( 'partials/footer-bottom' ); ?>
</footer><!-- #footer-wrap -->