<?php
/**
 * Create custom gallery output for the WP gallery shortcode
 *
 * @package WordPress
 * @subpackage Spartan
 * @since Spartan 1.0
*/

// Return if disabled
if ( ! get_theme_mod( 'wpex_custom_wp_gallery_output', true ) ) {
	return;
}

// Add custom fields to the WP Gallery for image height and width
add_filter('gallery_fields_to_edit', 'edit_media_custom_field', 11, 2 );
add_filter('gallery_fields_to_save', 'save_media_custom_field', 11, 2 );

function edit_media_custom_field( $form_fields, $post ) {
	$form_fields['custom_field'] = array( 'label' => 'Custom Field', 'input' => 'text', 'value' => get_post_meta( $post->ID, '_custom_field', true ) );
	return $form_fields;
}

function save_media_custom_field( $post, $attachment ) {
	update_post_meta( $post['ID'], '_custom_field', $attachment['custom_field'] );
	return $post;
}


// Custom WP Gallery Output
if ( !function_exists( 'wpex_custom_wp_gallery' ) ) :
	function wpex_custom_wp_gallery( $output, $attr ) {
		
		// load scripts
		global $post, $wp_locale;
		$output = '';

		static $instance = 0;
		$instance++;

		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( !$attr['orderby'] ) {
				unset( $attr['orderby'] );
			}
		}

		extract( shortcode_atts( array(
			'order'			=> 'ASC',
			'orderby'		=> 'menu_order ID',
			'id'			=> $post->ID,
			'columns'		=> 3,
			'include'		=> '',
			'exclude'		=> '',
			'img_height'	=> '',
			'img_width'		=> ''
		), $attr ) );

		$id = intval($id);
		if ( 'RAND' == $order ) {
			$orderby = 'none';
		}

		if ( !empty( $include ) ) {
			$include = preg_replace( '/[^0-9,]+/', '', $include );
			$_attachments = get_posts(
				array(
					'include'			=> $include,
					'post_status'		=> '',
					'inherit'			=> '',
					'post_type'			=> 'attachment',
					'post_mime_type'	=> 'image',
					'order'				=> $order,
					'orderby'			=> $orderby
				)
			);

		$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( !empty($exclude) ) {
			$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
			$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		} else {
			$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
			return $output;
		}

		// Define important vars
		$columns = intval($columns);
		$float = is_rtl() ? 'right' : 'left';

		$output .= '<div id="gallery-'. $instance .'" class="gallery galleryid-'. $id .' wpex-gallery wpex-gallery-lightbox clr">';
			
			// Begin Loop
			$gallery_id = $id;
			$count=0;
			foreach ( $attachments as $id => $attachment ) {
				$count++;

				// Full image url
				$full_img = wp_get_attachment_url( $id );
			
				// Set image cropping sizes
				if ( '' == $img_width ) {
					$img_width = get_theme_mod( 'wpex_gallery_image_width', get_theme_mod( 'wpex_post_img_width', '650' ) );
				}
				if ( '' == $img_height ) {
					$img_height = get_theme_mod( 'wpex_gallery_image_height', get_theme_mod( 'wpex_post_img_height', '450' ) );
				}

				if ( '9999' == $img_height ) {
					$img_crop = false;
				} else {
					$img_crop = true;
				}
				
				// Set correct cropping sizes
				if( $columns > 1 ) {
					$img_url = wpex_img_resize( $full_img, $img_width, $img_height, $img_crop );
				} else {
					$img_url = wp_get_attachment_url( $id );
				}
		
				// Start Gallery Item
				$output .= '<figure class="gallery-item '. wpex_grid_class( $columns ) .' col col-'. $count .'">';
				
					// Display image
					$output .= '<a href="'. $full_img .'" title="'. $attachment->post_title .'">
									<img src="'. $img_url .'" alt="'. get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) .'" />
									<figcaption class="gallery-item-overlay"><span class="fa fa-search"></span></figcaption>
								</a>';

					// Display Caption
					if ( trim( $attachment->post_excerpt ) ) {
						$output .= '<div class="gallery-item-caption">'. wptexturize($attachment->post_excerpt) . '</div>';
					}
					
				// Close gallery item div
				$output .= "</figure>";

						
				// Set vars to remove margin on last item of each row and clear floats
				if( $count == $columns ) {
					$count='0';
				}
				
			}

		// Clear floats and close gallery div
		$output .= "</div>\n";

		return $output;
	}
endif;
add_filter( 'post_gallery', 'wpex_custom_wp_gallery', 10, 2 );