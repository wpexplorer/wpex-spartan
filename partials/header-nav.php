<?php
/**
 * Header navigation
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

<div id="site-navigation-wrap" class="clr">
    <div id="site-navigation-inner" class="clr container">
        <nav id="site-navigation" class="navigation main-navigation clr">
            <?php
            // Check if main menu if defined
            if ( has_nav_menu( 'main_menu' ) ) {
                // Display main nav
                wp_nav_menu( array(
                    'theme_location'    => 'main_menu',
                    'sort_column'       => 'menu_order',
                    'menu_class'        => 'main-nav dropdown-menu sf-menu',
                    'fallback_cb'       => false,
                ) );
            // Display nav toggle for mobile devices
            if ( get_theme_mod( 'wpex_responsive', true ) ) { ?>
                <a href="#mobile-nav" class="navigation-toggle"><span class="fa fa-bars navigation-toggle-icon"></span><span class="navigation-toggle-text"><?php echo get_theme_mod( 'wpex_mobile_menu_open_text', __( 'Click here to navigate', 'spartan' ) ); ?></span></a>
            <?php } ?>
            <?php }
            // If main menu isn't defined display notice
            elseif ( is_user_logged_in() && current_user_can( 'edit_theme_options' ) ) { ?>
                <div id="site-navigation-notice">
                    <?php echo '<a href="'. admin_url( 'nav-menus.php' ) .'" title="'. __( 'WordPress Menu Editor', 'spartan' ) .'">'. __( 'Create and assign your menu', 'spartan' ) .' &rarr;</a>'; ?>
                </div>
            <?php } ?>
        </nav><!-- #site-navigation -->
    </div><!-- #site-navigation-inner -->
</div><!-- #site-navigation-wrap -->