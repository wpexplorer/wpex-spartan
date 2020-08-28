<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @license	http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link	https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'wpex_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function wpex_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'wpex_';

	// Posts
	$meta_boxes[] = array(
		'id'			=> 'wpex-post-meta',
		'title'			=> __( 'Post Settings', 'spartan' ),
		'pages'			=> array( 'post' ),
		'context'		=> 'normal',
		'priority'		=> 'high',
		'show_names'	=> true,
		'fields'		=> array(
			array(
				'name'		=> __( 'Layout', 'spartan' ),
				'desc'		=> '',
				'id'		=> $prefix . 'post_layout',
				'type'		=> 'select',
				'std'		=> 'right-sidebar',
				'options'	=> array(
					array(
						'name'	=> __( 'Default', 'spartan' ),
						'value'	=> '',
					),
					array(
						'name'	=> __( 'Right Sidebar', 'spartan' ),
						'value'	=> 'right-sidebar',
					),
					array(
						'name' 	=> __( 'Left Sidebar', 'spartan' ),
						'value'	=> 'left-sidebar',
					),
					array(
						'name'	=> __( 'FullWidth', 'spartan' ),
						'value'	=> 'fullwidth',
					),
				),
			),
			array(
				'name'	=> __( 'Video URL', 'spartan' ),
				'desc'	=> __( 'Enter in a video URL that is compatible with WordPress\'s built-in oEmbed function or self-hosted video function.', 'spartan' ),
				'id'	=> $prefix . 'post_video',
				'type'	=> 'file',
				'std'	=> '',
			),
			array(
				'name'	=> __( 'Video Embed', 'spartan' ),
				'desc'	=> __( 'Enter your embed code for your video here as an alternative to the video URL.', 'spartan' ),
				'id'	=> $prefix . 'post_video_embed',
				'type'	=> 'textarea_code',
				'std'	=> '',
			),
			array(
				'name'	=> __( 'Audio URL', 'spartan' ),
				'desc'	=> __( 'Enter in an audio URL that is compatible with WordPress\'s built-in self-hosted video function.', 'spartan' ),
				'id'	=> $prefix . 'post_audio',
				'type'	=> 'file',
				'std'	=> '',
			),
			array(
				'name'	=> __( 'Disable Entry Embed', 'spartan' ),
				'desc'	=> __( 'Check this box to disable the video/audio embed on entries. See the theme customizer if you wish to do this for all video & audio entries.', 'spartan' ),
				'id'	=> $prefix . 'disable_entry_embed',
				'type'	=> 'checkbox',
				'std'	=> '',
			),
			array(
				'name'	=> __( 'Disable Author Bio', 'spartan' ),
				'desc'	=> __( 'Disable the author bio on this post.', 'spartan' ),
				'id'	=> $prefix . 'disable_author',
				'type'	=> 'checkbox',
				'std'	=> '',
			),
			array(
				'name'	=> __( 'Disable Related Posts', 'spartan' ),
				'desc'	=> __( 'Disable the related posts on this post.', 'spartan' ),
				'id'	=> $prefix . 'disable_related',
				'type'	=> 'checkbox',
				'std'	=> '',
			),
			array(
				'name'	=> __( 'Disable Featured Image Display (On Post)', 'spartan' ),
				'desc'	=> __( 'Check this box to prevent the featured image from displaying on the post.', 'spartan' ),
				'id'	=> $prefix . 'disable_featured_image',
				'type'	=> 'checkbox',
				'std'	=> '',
			),
		),
	);

	// Pages
	$meta_boxes[] = array(
		'id'			=> 'wpex-post-meta',
		'title'			=> __( 'Page Settings', 'spartan' ),
		'pages'			=> array( 'page' ),
		'context'		=> 'normal',
		'priority'		=> 'high',
		'show_names'	=> true,
		'fields'		=> array(
			array(
				'name'		=> __( 'Layout', 'spartan' ),
				'desc'		=> '',
				'id'		=> $prefix . 'post_layout',
				'type'		=> 'select',
				'std'		=> 'right-sidebar',
				'options'	=> array(
					array(
						'name'	=> __( 'Default', 'spartan' ),
						'value'	=> '',
					),
					array(
						'name'	=> __( 'Right Sidebar', 'spartan' ),
						'value'	=> 'right-sidebar',
					),
					array(
						'name' 	=> __( 'Left Sidebar', 'spartan' ),
						'value'	=> 'left-sidebar',
					),
					array(
						'name'	=> __( 'FullWidth', 'spartan' ),
						'value'	=> 'fullwidth',
					),
				),
			),
			array(
				'name'	=> __( 'Disable Featured Image Display', 'spartan' ),
				'desc'	=> __( 'Check this box to prevent the featured image from displaying on the post.', 'spartan' ),
				'id'	=> $prefix . 'disable_featured_image',
				'type'	=> 'checkbox',
				'std'	=> '',
			),
			array(
				'name'	=> __( 'Disable Page Title', 'spartan' ),
				'desc'	=> __( 'Check this box to disable the page title.', 'spartan' ),
				'id'	=> $prefix . 'disable_page_title',
				'type'	=> 'checkbox',
				'std'	=> '',
			),
		),
	);

	return $meta_boxes;
}