<?php
/**
 * Ouputs the copyright info
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

// Get copyright data
$copyright = get_theme_mod( 'wpex_copyright', 'Copyright 2014 Your Company LLC' ); ?>

<div id="copyright" class="clr" role="contentinfo">
	<?php if ( $copyright ) { ?>
		<?php echo do_shortcode( $copyright ); ?>
	<?php } else { ?>
		<?php _e( 'Copyright', 'spartan' ); ?> <?php echo date('Y'); ?> <?php echo get_bloginfo( 'name' ); ?>
	<?php } ?>
</div><!-- #copyright -->