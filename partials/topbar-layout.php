<?php
/**
 * Topbar Layout
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
if ( ! get_theme_mod( 'wpex_topbar', true ) ) {
	return;
}

// Get theme options
$is_responsive_enabled = get_theme_mod( 'wpex_responsive', true );
$wpex_login_page       = get_theme_mod( 'wpex_login_page' ); ?>

<div id="topbar" class="clr">
	<div class="container clr">
		<?php
		get_template_part( 'partials/topbar-date' );
		get_template_part( 'partials/topbar-nav' );
		get_template_part( 'partials/topbar-search' );
		if ( $wpex_login_page && $is_responsive_enabled  ) { ?>
			<a href="<?php echo get_permalink( $wpex_login_page ); ?>" title="<?php echo get_the_title( $wpex_login_page ); ?> "><span class="fa fa-user topbar-mobile-login-link"></span></a>
		<?php } ?>
		<?php
		// Top nav mobile toggle
		if ( has_nav_menu( 'top_menu' ) && $is_responsive_enabled ) { ?>
			<span class="fa fa-bars topbar-nav-mobile-toggle"></span>
		<?php } ?>
	</div><!-- .container -->
</div><!-- #topbar -->