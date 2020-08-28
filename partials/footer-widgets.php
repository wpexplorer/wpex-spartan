<?php
/**
 * Footer widgets
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

// Display footer unless set to 0 columns
$cols = get_theme_mod( 'wpex_footer_columns' );
$cols = $cols ? $cols : '4';
$grid_class = wpex_grid_class( $cols );

// Return if columns is set to 0
if ( '0' == $cols ) { 
    return;
} ?>

<div id="footer" class="container wpex-row clr">
    <div id="footer-widgets" class="clr">
        <div class="footer-box <?php echo esc_attr( $grid_class ); ?> col col-1">
            <?php dynamic_sidebar( 'footer-one' ); ?>
        </div><!-- .footer-box -->
        <?php
        // Second footer area
        if ( $cols >= '2' ) { ?>
            <div class="footer-box <?php echo esc_attr( $grid_class ); ?> col col-2">
                <?php dynamic_sidebar( 'footer-two' ); ?>
            </div><!-- .footer-box -->
        <?php } ?>
        <?php
        // Third Footer Area
        if ( $cols >= '3' ) { ?>
            <div class="footer-box <?php echo esc_attr( $grid_class ); ?> col col-3">
                <?php dynamic_sidebar( 'footer-three' ); ?>
            </div><!-- .footer-box -->
        <?php } ?>
        <?php
        // Fourth Footer Area
        if ( $cols == '4' ) { ?>
            <div class="footer-box <?php echo esc_attr( $grid_class ); ?> col col-4">
                <?php dynamic_sidebar( 'footer-four' ); ?>
            </div><!-- .footer-box -->
        <?php } ?>
    </div><!-- #footer-widgets -->
</div><!-- #footer -->