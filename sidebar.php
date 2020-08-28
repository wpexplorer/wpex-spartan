<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

// Return on full-width post
if ( is_singular() && 'fullwidth' == get_post_meta( get_the_ID(), 'wpex_post_layout', true ) ) {
	return;
}

// Display sidebar if active
if ( is_active_sidebar( 'sidebar' ) ) : ?>
	<aside id="secondary" class="sidebar-container">
		<div class="sidebar-inner">
			<div class="widget-area"><?php dynamic_sidebar( 'sidebar' ); ?></div>
		</div>
	</aside>
<?php endif; ?>