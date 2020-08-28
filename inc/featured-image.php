<?php
/**
 * Returns a post featured image URl
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
*/


// Returns the site featured image
if ( ! function_exists( 'wpex_image' ) ) {
		function wpex_image( $return = 'url', $id = '', $custom_query = false ) {

			// Post Vars
			global $post;
			$post_id 		= $post->ID;
			$post_type		= get_post_type( $post_id );
			$attachment_id	= $id ? $id : get_post_thumbnail_id( $post_id );
			$attachment_url	= wp_get_attachment_url( $attachment_id );
			
			// Resizing Vars
			$width	= '9999';
			$height	= '9999';
			$crop	= false;
			
			/** Pages **/
			if ( $post_type == 'page' && is_singular( 'page' ) ) {
				$width	= '9999';
				$height	= '9999';
			}

			/** Standard post **/
			if ( $post_type == 'post' ) {
				// Single Posts
				if ( is_singular() && !$custom_query ) {
					$width	= get_theme_mod( 'wpex_post_img_width', '620' );
					$height	= get_theme_mod( 'wpex_post_img_height', '350' );
				} elseif ( is_singular() && $custom_query ) {
					$width	= get_theme_mod( 'wpex_related_entry_img_width', '620' );
					$height	= get_theme_mod( 'wpex_related_entry_img_height', '350' );
				} else {
					// Entries
					$width	= get_theme_mod( 'wpex_entry_img_width', '620' );
					$height	= get_theme_mod( 'wpex_entry_img_height', '350' );
				}
			}
		
			// Return Dimensions & crop
			if( $width ) {
				$width = intval( $width );
			} else {
				$width = '9999';
			}
			if( $height ) {
				$height = intval( $height );
			} else {
				$height = '9999';
			}
			if( '9999' == $height ) {
				$crop = false;
			} else {
				$crop = true;
			}
			$resized_array = wpex_img_resize( $attachment_url, $width, $height, $crop, 'array' );

			if ( 'url' == $return ) {
				return $resized_array['url'];
			} elseif ( 'array' == $return ) {
				return $resized_array;
			}

		}
}