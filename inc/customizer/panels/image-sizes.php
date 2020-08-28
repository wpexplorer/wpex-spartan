<?php
/**
 * Image Resizing theme options
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

if ( ! function_exists( 'wpex_customizer_image_sizes' ) ) {

	function wpex_customizer_image_sizes( $wp_customize ) {

		// Add General Panel
		$wp_customize->add_panel( 'wpex_img_sizes', array(
			'priority' => 142,
			'capability' => 'edit_theme_options',
			'title' => __( 'Image Sizes', 'spartan' ),
			'description' => __( 'This theme uses a built-in image resizing function based on the WordPress wp_get_image_editor() function so you can quickly alter the image sizes on your site without having to regenerate the thumbnails. If you are more concerend with site speed then you will probably want to set your entry image sizes to a different crop then your posts and if your main priority is storage space you will probably want to set entry sizes the same as post sizes.<br /><br />', 'spartan' ),

		) );

		/*-----------------------------------------------------------------------------------*/
		/* - General
		/*-----------------------------------------------------------------------------------*/

		$wp_customize->add_section( 'wpex_img_sizes_general' , array(
			'title' => __( 'General', 'spartan' ),
			'priority' => 1,
			'panel' => 'wpex_img_sizes',
			
		) );

		$wp_customize->add_setting( 'wpex_img_crop_location', array(
			'type' => 'theme_mod',
			'default' => 'top',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_img_crop_location', array(
			'label' => __( 'Vertical Image Crop Location', 'spartan' ),
			'section' => 'wpex_img_sizes_general',
			'settings' => 'wpex_img_crop_location',
			'priority' => '99',
			'type'  => 'select',
			'description' => __( 'Select the default image cropping location. This will only affect newly uploaded/cropped images.', 'spartan' ),
			'choices' => array(
				'top' => __( 'Top', 'spartan' ),
				'middle' => __( 'Middle', 'spartan' ),
			)
		) );

		$wp_customize->add_setting( 'wpex_retina', array(
			'type' => 'theme_mod',
			'default' => '',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_retina', array(
			'label' => __( 'Enable Retina.js.', 'spartan' ),
			'settings' => 'wpex_retina',
			'section' => 'wpex_img_sizes_general',
			'priority' => '999',
			'type'  => 'checkbox',
			'description' => __( 'This will create a second cropped version of every image that is 2x as big as the original.', 'spartan' ),
		) );


		/*-----------------------------------------------------------------------------------*/
		/* - Entries
		/*-----------------------------------------------------------------------------------*/

		$wp_customize->add_section( 'wpex_img_sizes_entries' , array(
			'title' => __( 'Entries', 'spartan' ),
			'priority' => 2,
			'panel' => 'wpex_img_sizes',
			'description' => __( 'Select your custom image resizing. You may enter "9999" for both the height and the width and it will remove all cropping, but if you enter "9999" for only the width or only the height then it will resize based on the defined size for the oposite side. For example setting the height to "9999" will keep all your image proportions and simply shrink down to the max width value.', 'spartan' )
			
		) );

		$wp_customize->add_setting( 'wpex_entry_img_width', array(
			'type' => 'theme_mod',
			'default' => '620',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'wpex_entry_img_width', array(
			'label'  => __( 'Entry Image Width', 'spartan' ),
			'settings' => 'wpex_entry_img_width',
			'section' => 'wpex_img_sizes_entries',
			'priority' => '2',
		) );

		$wp_customize->add_setting( 'wpex_entry_img_height', array(
			'type' => 'theme_mod',
			'default' => '350',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'wpex_entry_img_height', array(
			'label' => __( 'Entry Image Height', 'spartan' ),
			'settings' => 'wpex_entry_img_height',
			'section' => 'wpex_img_sizes_entries',
			'priority' => '3',
		) );


		/*-----------------------------------------------------------------------------------*/
		/* - Posts
		/*-----------------------------------------------------------------------------------*/

		$wp_customize->add_section( 'wpex_img_sizes_post' , array(
			'title' => __( 'Single Post', 'spartan' ),
			'priority' => 3,
			'panel' => 'wpex_img_sizes',
			
		) );

		$wp_customize->add_setting( 'wpex_post_img_width', array(
			'type' => 'theme_mod',
			'default' => '620',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'wpex_post_img_width', array(
			'label'  => __( 'Post Image Width', 'spartan' ),
			'section' => 'wpex_img_sizes_post',
			'settings' => 'wpex_post_img_width',
			'priority' => '5',
		) );

		$wp_customize->add_setting( 'wpex_post_img_height', array(
			'type' => 'theme_mod',
			'default' => '350',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'wpex_post_img_height', array(
			'label'  => __( 'Post Image Height', 'spartan' ),
			'section' => 'wpex_img_sizes_post',
			'settings' => 'wpex_post_img_height',
			'priority' => '6',
		) );


		/*-----------------------------------------------------------------------------------*/
		/* - Related
		/*-----------------------------------------------------------------------------------*/

		$wp_customize->add_section( 'wpex_img_sizes_related_posts' , array(
			'title' => __( 'Related Posts', 'spartan' ),
			'priority' => 4,
			'panel' => 'wpex_img_sizes',
		) );

		$wp_customize->add_setting( 'wpex_related_entry_img_width', array(
			'type' => 'theme_mod',
			'default' => '620',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'wpex_related_entry_img_width', array(
			'label'  => __( 'Related Entry Image Width', 'spartan' ),
			'section' => 'wpex_img_sizes_related_posts',
			'settings' => 'wpex_related_entry_img_width',
			'priority' => '9',
		) );

		$wp_customize->add_setting( 'wpex_related_entry_img_height', array(
			'type' => 'theme_mod',
			'default' => '350',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'wpex_related_entry_img_height', array(
			'label'  => __( 'Related Entry Image Height', 'spartan' ),
			'section' => 'wpex_img_sizes_related_posts',
			'settings' => 'wpex_related_entry_img_height',
			'priority' => '10',
		) );


		/*-----------------------------------------------------------------------------------*/
		/* - Homepage Slider
		/*-----------------------------------------------------------------------------------*/

		$wp_customize->add_section( 'wpex_img_sizes_home_slider' , array(
			'title' => __( 'Homepage Slider', 'spartan' ),
			'priority' => 5,
			'panel' => 'wpex_img_sizes',
			
		) );

		$wp_customize->add_setting( 'wpex_home_slider_img_width', array(
			'type' => 'theme_mod',
			'default' => '620',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'wpex_home_slider_img_width', array(
			'label'  => __( 'Homepage Slider Image Width', 'spartan' ),
			'section' => 'wpex_img_sizes_home_slider',
			'settings' => 'wpex_home_slider_img_width',
			'priority' => '11',
		) );

		$wp_customize->add_setting( 'wpex_home_slider_img_height', array(
			'type' => 'theme_mod',
			'default' => '350',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'wpex_home_slider_img_height', array(
			'label'  => __( 'Homepage Slider Image Height', 'spartan' ),
			'section' => 'wpex_img_sizes_home_slider',
			'settings' => 'wpex_home_slider_img_height',
			'priority' => '12',
		) );


		/*-----------------------------------------------------------------------------------*/
		/* - Homepage Carousel
		/*-----------------------------------------------------------------------------------*/

		$wp_customize->add_section( 'wpex_img_sizes_home_carousel' , array(
			'title' => __( 'Homepage Carousel', 'spartan' ),
			'priority' => 6,
			'panel' => 'wpex_img_sizes',
			
		) );

		$wp_customize->add_setting( 'wpex_home_carousel_img_width', array(
			'type' => 'theme_mod',
			'default' => '620',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'wpex_home_carousel_img_width', array(
			'label'  => __( 'Homepage Carousel Image Width', 'spartan' ),
			'section' => 'wpex_img_sizes_home_carousel',
			'settings' => 'wpex_home_carousel_img_width',
			'priority' => '13',
		) );

		$wp_customize->add_setting( 'wpex_home_carousel_img_height', array(
			'type' => 'theme_mod',
			'default' => '350',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'wpex_home_carousel_img_height', array(
			'label'  => __( 'Homepage Carousel Image Height', 'spartan' ),
			'section' => 'wpex_img_sizes_home_carousel',
			'settings' => 'wpex_home_carousel_img_height',
			'priority' => '14',
		) );
	}
}
add_action( 'customize_register', 'wpex_customizer_image_sizes' );