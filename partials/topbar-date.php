<?php
/**
 * Topbar date
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
if ( ! get_theme_mod( 'wpex_topbar_date', true ) ) {
	return;
} ?>

<div id="topbar-date" class="clr">
	<div class="topbar-date-full"><span class="fa fa-clock-o"></span><?php echo date_i18n('l jS F Y'); ?></div>
	<div class="topbar-date-condensed"><span class="fa fa-clock-o"></span><?php echo date_i18n('j-M-Y'); ?></div>
</div><!-- .topbar-date -->