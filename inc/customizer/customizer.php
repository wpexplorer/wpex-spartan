<?php
/**
 * Customizer main functions and includes
 *
 * @package		Spartan
 * @subpackage	Customizer
 * @author		Alexander Clarke
 * @copyright	Copyright (c) 2014, Symple Workz LLC
 * @link		http://www.wpexplorer.com
 * @since		Spartan 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Loads customizer css file for the WordPress customizer
 *
 * @since 1.0.2
 */
if ( ! function_exists( 'wpex_customize_preview_css' ) ) {
	function wpex_customize_preview_css() {
		wp_enqueue_style(
			'wpex-customizer', get_template_directory_uri() . '/inc/customizer/assets/customizer-style.css',
			'1.0'
		);
	}
}
add_action( 'customize_controls_print_styles', 'wpex_customize_preview_css' );

/**
 * Include customizer functions and panels
 *
 * @since 1.0.2
 */
$customizer_dir = get_template_directory() .'/inc/customizer/';
require_once ( $customizer_dir .'fonts.php' );
require_once ( $customizer_dir .'controls.php' );
require_once ( $customizer_dir .'panels/general.php' );
require_once ( $customizer_dir .'panels/styling.php' );
require_once ( $customizer_dir .'panels/typography.php' );
require_once ( $customizer_dir .'panels/homepage.php' );
require_once ( $customizer_dir .'panels/image-sizes.php' );