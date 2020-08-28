<?php
/**
 * Site Header layout
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

<div id="top-wrap" class="clr">
	<?php get_template_part( 'partials/topbar-layout' ); ?>
	<header id="header" class="site-header clr container">
		<?php echo get_template_part( 'partials/header-branding' ); ?>
		<?php echo wpex_ad_spot( 'header' ); ?>
	</header><!-- #header -->
	<?php get_template_part( 'partials/header-nav' ); ?>
</div><!-- #top-wrap -->