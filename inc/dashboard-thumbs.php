<?php
/**
 * Displays thumbnails in the WP dashboard
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

// Return if disabled
if ( ! get_theme_mod( 'wpex_dashboard_thumbs', true ) ) {
	return;
}

// Ads the new column
if ( ! function_exists( 'wpex_posts_columns' ) ) {
	function wpex_posts_columns( $defaults ){
		$defaults['wpex_post_thumbs'] = __( 'Featured Image', 'spartan' );
		return $defaults;
	}
}
add_filter( 'manage_posts_columns', 'wpex_posts_columns', 5 );

// Displays the thumbnail in the new 'wpex_post_thumbs' column
if ( ! function_exists( 'wpex_posts_custom_columns' ) ) {
	function wpex_posts_custom_columns( $column_name, $id ){
		if( $column_name === 'wpex_post_thumbs' ) {
			$thumbnail_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'thumbnail' );
			if( isset( $thumbnail_image_url[0] ) ) {
				echo '<img src="'. $thumbnail_image_url[0] .'" style="width:70px;height:auto;" />';
			}
		}
	}
}
add_action( 'manage_posts_custom_column', 'wpex_posts_custom_columns', 5, 2 );