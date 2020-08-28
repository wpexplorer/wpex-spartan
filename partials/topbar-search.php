<?php
/**
 * Topbar searchform
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
if ( ! get_theme_mod( 'wpex_topbar_search', true ) ) {
	return;
} ?>

<div id="topbar-search" class="clr">
	<form method="get" class="topbar-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<input type="search" class="field topbar-searchform-input" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php _e( 'Type your search & hit enter','spartan' ); ?>" />
		<button type="submit" class="topbar-searchform-btn"><span class="fa fa-search"></span></button>
	</form>
</div><!-- topbar-search -->
<?php
// Search toggle for mobile devices
if ( get_theme_mod( 'wpex_responsive', true ) ) { ?>
	<span class="fa fa-search topbar-search-mobile-toggle"></span>
<?php } ?>