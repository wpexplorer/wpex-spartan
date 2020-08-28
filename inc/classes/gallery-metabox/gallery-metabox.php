<?php
/**
 * Creates a gallery metabox for WordPress
 *
 * http://wordpress.org/plugins/easy-image-gallery/
 * https://github.com/woothemes/woocommerce
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Gallery_Metabox' ) ) {
	class WPEX_Gallery_Metabox {
		private $dir;
		private $post_types;

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Update directory var
			$this->dir = apply_filters( 'wpex_gallery_metabox_dir_uri', get_template_directory_uri() .'/inc/classes/gallery-metabox/' );

			// Post types to add the metabox to
			$this->post_types = apply_filters( 'wpex_gallery_metabox_post_types', array( 'post' ) );

			// Add metabox to corresponding post types
			foreach( $this->post_types as $key => $val ) {
				add_action( 'add_meta_boxes_'. $val, array( $this, 'add_meta' ), 20 );
			}

			// Save metabox
			add_action( 'save_post', array( $this, 'save_meta' ) );

			// Load scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
			
		}

		/**
		 * Adds the gallery metabox
		 *
		 * @since 1.0.0
		 */
		function add_meta( $post ) {
			add_meta_box(
				'wpex-gallery-metabox', 
				esc_html__( 'Image Gallery', 'spartan' ),
				array( $this, 'render' ),
				$post->post_type,
				'normal',
				'high'
			);
		}

		/**
		 * Render the gallery metabox
		 *
		 * @since 1.0.0
		 */
		public function render() {
			global $post; ?>
			<div id="wpex_gallery_images_container">
				<ul class="wpex_gallery_images">
					<?php
					$image_gallery = get_post_meta( $post->ID, '_easy_image_gallery', true );
					$attachments = array_filter( explode( ',', $image_gallery ) );
					if ( $attachments ) {
						foreach ( $attachments as $attachment_id ) {
							if ( wp_attachment_is_image ( $attachment_id  ) ) {
								echo '<li class="image" data-attachment_id="' . $attachment_id . '"><div class="attachment-preview"><div class="thumbnail">
											' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '</div>
											<a href="#" class="wpex-gmb-remove" title="' . esc_html__( 'Remove image', 'spartan' ) . '"><div class="media-modal-icon"></div></a>
										</div></li>';
							}
						}
					} ?>
				</ul>
				<input type="hidden" id="image_gallery" name="image_gallery" value="<?php echo esc_attr( $image_gallery ); ?>" />
				<?php wp_nonce_field( 'easy_image_gallery', 'easy_image_gallery' ); ?>
			</div>
			<p class="add_wpex_gallery_images hide-if-no-js">
				<a href="#" class="button-primary"><?php esc_html_e( 'Add/Edit Images', 'spartan' ); ?></a>
			</p>
			<p>
				<label for="easy_image_gallery_link_images">
					<input type="checkbox" id="easy_image_gallery_link_images" value="on" name="easy_image_gallery_link_images"<?php echo checked( get_post_meta( get_the_ID(), '_easy_image_gallery_link_images', true ), 'on', false ); ?> /> <?php esc_html_e( 'Enable Lightbox for this gallery?', 'spartan' )?>
				</label>
			</p>
		<?php
		}

		/**
		 * Render the gallery metabox
		 *
		 * @since 1.0.0
		 */
		public static function save_meta( $post_id ) {

			// Check nonce
			if ( ! isset( $_POST[ 'easy_image_gallery' ] )
				|| ! wp_verify_nonce( $_POST[ 'easy_image_gallery' ], 'easy_image_gallery' )
			) {
				return;
			}

			// Check auto save
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// Check user permissions
			$post_types = array( 'post' );
			if ( isset( $_POST['post_type'] ) && 'post' == $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return;
				}
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
			}

			if ( isset( $_POST[ 'image_gallery' ] ) && !empty( $_POST[ 'image_gallery' ] ) ) {
				$attachment_ids = sanitize_text_field( $_POST['image_gallery'] );
				// Turn comma separated values into array
				$attachment_ids = explode( ',', $attachment_ids );
				// Clean the array
				$attachment_ids = array_filter( $attachment_ids  );
				// Return back to comma separated list with no trailing comma. This is common when deleting the images
				$attachment_ids =  implode( ',', $attachment_ids );
				update_post_meta( $post_id, '_easy_image_gallery', $attachment_ids );
			} else {
				// Delete gallery
				delete_post_meta( $post_id, '_easy_image_gallery' );
			}

			// link to larger images
			if ( isset( $_POST[ 'easy_image_gallery_link_images' ] ) ) {
				update_post_meta( $post_id, '_easy_image_gallery_link_images', $_POST[ 'easy_image_gallery_link_images' ] );
			} else {
				update_post_meta( $post_id, '_easy_image_gallery_link_images', 'off' );
			}

			// Add action
			do_action( 'wpex_save_gallery_metabox', $post_id );

		}

		/**
		 * Load custom scripts
		 *
		 * @since 1.0.0
		 */
		public function scripts( $hook ) {

			if ( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' ) {
				return;
			}

			wp_enqueue_style( 'wpex-gmb-css', $this->dir .'gallery-metabox.css' );
			wp_enqueue_script( 'wpex-gmb-js', $this->dir .'gallery-metabox.js', array( 'jquery' ), false, true );
			wp_localize_script( 'wpex-gmb-js', 'wpexGmb', array(
				'title'  => esc_html__( 'Add Images to Gallery', 'spartan' ),
				'button' => esc_html__( 'Add to gallery', 'spartan' ),
				'remove' => esc_html__( 'Remove image', 'spartan' ),
			) );

		}


	}
}

// Class needed only in the admin
if ( is_admin() ) {
	new WPEX_Gallery_Metabox;
}

/**
 * Check if the post has a gallery
 *
 * @since 3.0.0
 */
function wpex_post_has_gallery( $post_id = '' ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	if ( get_post_meta( $post_id, '_easy_image_gallery', true ) ) {
		return true;
	}
}

/**
 * Retrieve attachment IDs
 *
 * @since 1.0.0
 */
function wpex_get_gallery_ids( $post_id = '' ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$attachment_ids = get_post_meta( $post_id, '_easy_image_gallery', true );
	if ( $attachment_ids ) {
		$attachment_ids = explode( ',', $attachment_ids );
		return array_filter( $attachment_ids );
	}
}

/**
 * Get array of gallery image urls
 *
 * @since 3.5.0
 */
function wpex_get_gallery_images( $post_id = '', $size = 'full' ) {
	$ids = wpex_get_gallery_ids( $post_id );
	if ( $ids ) {
		$images = array();
		foreach ( $ids as $id ) {
			$image = wp_get_attachment_image_src( $id, $size );
			$image = isset( $image[0] ) ? $image[0] : '';
			if ( $image ) {
				$images[] = $image;
			}
		}
		return $images;
	}
}

/**
 * Retrieve attachment data
 *
 * @since 1.0.0
 */
function wpex_get_attachment( $id ) {
	$attachment = get_post( $id );
	return array(
		'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption'     => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href'        => get_permalink( $attachment->ID ),
		'src'         => $attachment->guid,
		'title'       => $attachment->post_title,
	);
}

/**
 * Return gallery count
 *
 * @since 1.0.0
 */
function wpex_gallery_count() {
	$ids = wpex_get_gallery_ids();
	return count( $ids );
}

/**
 * Check if lightbox is enabled
 *
 * @since 1.0.0
 */
function wpex_gallery_is_lightbox_enabled() {
	if ( 'on' == get_post_meta( get_the_ID(), '_easy_image_gallery_link_images', true ) ) {
		return true;
	}
}