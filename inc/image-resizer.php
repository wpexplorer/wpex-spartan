<?php
/**
 * Automatically crop, resize and save featured images
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
*/

// Change default crop location in WordPress
if ( ! function_exists( 'wpex_img_crop_location' ) ) {
	function wpex_img_crop_location( $payload, $orig_w, $orig_h, $dest_w, $dest_h, $crop ){

	// Sanitize
	$orig_w = intval( $orig_w );
	$orig_h = intval( $orig_h );
	$dest_w = intval( $dest_w );
	$dest_h = intval( $dest_h );
	
	// Change this to a conditional that decides whether you 
	// want to override the defaults for this image or not.
	if( false ) {
		return $payload;
	}

	if ( $crop ) {
		// crop the largest possible portion of the original image that we can size to $dest_w x $dest_h
		$aspect_ratio = $orig_w / $orig_h;
		$new_w = min($dest_w, $orig_w);
		$new_h = min($dest_h, $orig_h);

		if ( !$new_w ) {
			$new_w = intval($new_h * $aspect_ratio);
		}

		if ( ! $new_h ) {
			$new_h = intval($new_w / $aspect_ratio);
		}

		$size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

		$crop_w = round($new_w / $size_ratio);
		$crop_h = round($new_h / $size_ratio);

		// Crop images in the middle horizontally
		$s_x = floor( ($orig_w - $crop_w) / 2 );

		// Crop to the top vertically
		if ( 'top' == get_theme_mod( 'wpex_img_crop_location', 'top' ) ) {
			$s_y = 0;

		// Crop to the center vertically
		} elseif ( 'middle' == get_theme_mod( 'wpex_img_crop_location', 'top' ) ) {
			$s_y = floor( ($orig_h - $crop_h) / 2 );
		}
		

	} else {
		// don't crop, just resize using $dest_w x $dest_h as a maximum bounding box
		$crop_w = $orig_w;
		$crop_h = $orig_h;
		$s_x = 0;
		$s_y = 0;

		list( $new_w, $new_h ) = wp_constrain_dimensions( $orig_w, $orig_h, $dest_w, $dest_h );
	}

	// if the resulting image would be the same size or larger we don't want to resize it
	if ( $new_w >= $orig_w && $new_h >= $orig_h )
		return false;

	// the return array matches the parameters to imagecopyresampled()
	// int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h
	return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );

	}
}
add_filter( 'image_resize_dimensions', 'wpex_img_crop_location', 10, 6 );

// Resizer Script
if ( ! function_exists( 'wpex_img_resize' ) ) {
	function wpex_img_resize( $url, $width, $height = null, $crop = null, $return = 'url' ) {
		
		// Validate inputs
		if ( ! $url OR ! $width ) {
			false;
		}
		
		// Set dimensions
		$aq_width	= $width;
		$aq_height	= $height;
		
		// Define upload path & dir
		$upload_info = wp_upload_dir();
		$upload_dir  = $upload_info['basedir'];
		$upload_url  = $upload_info['baseurl'];

		// WPML tweak
		global $sitepress;
		if ( $sitepress ) {
			$upload_url = $sitepress->convert_url( $upload_url );
		}

		// Set correct schemes
		$url = set_url_scheme( $url );
		$upload_url = set_url_scheme( $upload_url );
		
		// check if $img_url is local if not return full img
		if ( false === strpos( $url, $upload_url ) ) {
			if ( 'array' == $return ) {
				return array(
					'url'		=> $url,
					'width'		=> '',
					'height'	=> ''
				);
			} else {
				return $url;
			}
		}
		
		//define path of image
		$rel_path = str_replace( $upload_url, '', $url );
		$img_path = $upload_dir . $rel_path;
		
		// check if img path exists, and is an image indeed if not return full img
		if ( ! file_exists( $img_path ) OR ! getimagesize( $img_path ) ) {
			if ( 'array' == $return ) {
				return array(
					'url'		=> $url,
					'width'		=> '',
					'height'	=> ''
				);
			} else {
				return $url;
			}
		}
		
		//get image info
		$info                    = pathinfo( $img_path );
		$ext                     = $info['extension'];
		list( $orig_w, $orig_h ) = getimagesize( $img_path );
				
		//get image size after cropping
		$dims	= image_resize_dimensions( $orig_w, $orig_h, $aq_width, $aq_height, $crop );
		$dst_w	= $dims[4];
		$dst_h	= $dims[5];
		
		//use this to check if cropped image already exists, so we can return that instead
		$suffix = "{$dst_w}x{$dst_h}";
		$dst_rel_path = str_replace( '.'.$ext, '', $rel_path );
		$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";
		
		//can't resize, so return original url
		if ( ! $dst_h ) {
			$img_url	= $url;
			$dst_w		= $orig_w;
			$dst_h		= $orig_h;
		}
		
		// else check if cache exists
		elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
			$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
		}
		
		//else, we resize the image and return the new resized image url
		else {
			
			$editor = wp_get_image_editor( $img_path );
			
			// Return nothing if there is an error
			if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $aq_width, $aq_height, $crop ) ) ) {
				return false;
			}

			// Ger resized file
			$resized_file = $editor->save();

			// Return the resized image URL
			if ( ! is_wp_error( $resized_file ) ) {
				$resized_rel_path	= str_replace( $upload_dir, '', $resized_file['path'] );
				$img_url			= $upload_url . $resized_rel_path;
			}

			// Return nothing if there is an error
			else {
				return false;
			}
			
		}
		
		//retina support
		if ( get_theme_mod( 'wpex_retina' ) ) {
			
			// Define retina widths
			$retina_w	= $dst_w*2;
			$retina_h	= $dst_h*2;
			
			//get image size after cropping
			$dims_x2	= image_resize_dimensions( $orig_w, $orig_h, $retina_w, $retina_h, $crop );
			$dst_x2_w	= $dims_x2[4];
			$dst_x2_h	= $dims_x2[5];
			
			// If possible lets make the @2x image
			if ( $dst_x2_h ) {
			
				// @2x image url
				$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}@2x.{$ext}";
				
				// Check if retina image exists
				if ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
					// Already exists, do nothing
				} else {
					// Doesnt exist, lets create it
					$editor = wp_get_image_editor( $img_path );
					if ( ! is_wp_error( $editor ) ) {
						$editor->resize( $retina_w, $retina_h, $crop );
						$filename	= $editor->generate_filename( $dst_w . 'x' . $dst_h . '@2x' );
						$editor		= $editor->save( $filename );
					}
				}
			
			}
		
		}
		
		// Validate url, width, height
		$img_url	= isset( $img_url ) ? $img_url : $url;
		$dst_w		= isset( $dst_w ) ? $dst_w : '';
		$dst_h		= isset( $dst_h ) ? $dst_h : '';

		// Return Image data
		if ( 'url' == $return ) {
			return $img_url;
		} elseif ( 'array' == $return ) {
			return array(
				'url'		=> $img_url,
				'width'		=> $dst_w,
				'height'	=> $dst_h
			);
		} else {
			return $img_url;
		}
	}
}