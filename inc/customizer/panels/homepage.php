<?php
/**
 * Homepage slider customizer settings
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

if( ! function_exists( 'wpex_customizer_homepage' ) ) {
	function wpex_customizer_homepage( $wp_customize ) {

		// Add Homepage Panel
		$wp_customize->add_panel( 'wpex_homepage', array(
			'priority' => 141,
			'capability' => 'edit_theme_options',
			'title' => __( 'Homepage', 'spartan' ),
		) );

		$slider_carousel_choices = array(
			'none' => __( 'None - Disable', 'spartan' ),
			'recent_posts' => __( 'Recent Posts', 'spartan' ),
		);

		// Main Cats Options
		$cats = get_categories();
		if ( $cats ) {
			foreach ( $cats as $cat ) {
				$slider_carousel_choices[$cat->term_id] = $cat->name;
			}
		}

		/*-----------------------------------------------------------------------------------*/
		/*  - Homepage Categories
		/*-----------------------------------------------------------------------------------*/
		
		// Get parent categories
		$parent_cats = get_categories( array(
					'orderby' => 'name',
					'parent' => 0
		) );
		if ( $parent_cats ) {
			foreach ( $parent_cats as $cat ) {
				$slider_carousel_choices[$cat->term_id] = $cat->name;
			}
		}

		// Define Theme Settings Section
		$wp_customize->add_section( 'wpex_home_categories' , array(
			'title' => __( 'Homepage Categories', 'spartan' ),
			'panel' => 'wpex_homepage',
			'description' => __( 'By default the Hompeage template displays all parent categories and a list of the recent posts for that category. Here you can elect the categories to include. Uncheck any you want to exclude.', 'spartan' ),
		) );

		// Loop through categories and add color option
		if( $parent_cats ) {
			foreach( $parent_cats as $cat ) {
				$wp_customize->add_setting( 'wpex_home_cat_'. $cat->term_id, array(
					'type' => 'theme_mod',
					'default' => '1',
					'sanitize_callback' => 'esc_html',
				) );
				$wp_customize->add_control( 'wpex_home_cat_'. $cat->term_id, array(
					'label' => $cat->name,
					'section' => 'wpex_home_categories',
					'settings' => 'wpex_home_cat_'. $cat->term_id,
					'type' => 'checkbox',
				) );
			}
		}

		// How many items to show per category
		$wp_customize->add_setting( 'wpex_homepage_cat_entry_count', array(
			'type' => 'theme_mod',
			'default' => '6',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'wpex_homepage_cat_entry_count', array(
			'label' => __( 'Posts Per Category', 'spartan' ),
			'section' => 'wpex_home_categories',
			'settings' => 'wpex_homepage_cat_entry_count',
			'description' => __( 'How many posts do you wish to show per category. This number includes the first featured post', 'spartan' ),
		) );


		/*-----------------------------------------------------------------------------------*/
		/*  - Homepage Slider
		/*-----------------------------------------------------------------------------------*/

		// Theme Settings Section
		$wp_customize->add_section( 'wpex_slider' , array(
			'title' => __( 'Homepage Slider', 'spartan' ),
			'panel' => 'wpex_homepage',
		) );

		// Slider Content
		$wp_customize->add_setting( 'wpex_homepage_slider_content', array(
			'type' => 'theme_mod',
			'default' => 'recent_posts',
			'sanitize_callback' => 'esc_html',
		) );

		$wp_customize->add_control( 'wpex_homepage_slider_content', array(
			'label' => __( 'Homepage Slider Content', 'spartan' ),
			'section' => 'wpex_slider',
			'settings' => 'wpex_homepage_slider_content',
			'type' => 'select',
			'choices' => $slider_carousel_choices,
		) );

		// Slider Count
		$wp_customize->add_setting( 'wpex_homepage_slider_count', array(
			'type' => 'theme_mod',
			'default' => '3',
			'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( 'wpex_homepage_slider_count', array(
			'label' => __( 'Homepage Slider Count', 'spartan' ),
			'section' => 'wpex_slider',
			'settings' => 'wpex_homepage_slider_count',
			'type' => 'text',
		) );

		// Slider exclude posts
		$wp_customize->add_setting( 'wpex_homepage_slider_exclude_posts', array(
			'type' => 'theme_mod',
			'sanitize_callback' => 'esc_html',
		) );

		$wp_customize->add_control( 'wpex_homepage_slider_exclude_posts', array(
			'label' => __( 'Exclude Posts', 'spartan' ),
			'section' => 'wpex_slider',
			'settings' => 'wpex_homepage_slider_exclude_posts',
			'type' => 'checkbox',
			'description' => __( 'Check this box to exclude posts included in the carousel from the homepage grid.', 'spartan' ),
		) );

		// Slider SlideShow
		$wp_customize->add_setting( 'wpex_homepage_slider_slideshow', array(
			'type' => 'theme_mod',
			'default' => '',
			'sanitize_callback' => 'esc_html',
		) );

		$wp_customize->add_control( 'wpex_homepage_slider_slideshow', array(
			'label' => __( 'Automatic Slideshow', 'spartan' ),
			'section' => 'wpex_slider',
			'settings' => 'wpex_homepage_slider_slideshow',
			'type' => 'checkbox',
		) );

		// Slider SlideShow Speed
		$wp_customize->add_setting( 'wpex_homepage_slider_slideshow_speed', array(
			'type' => 'theme_mod',
			'default' => '7000',
			'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( 'wpex_homepage_slider_slideshow_speed', array(
			'label' => __( 'Slideshow Speed', 'spartan' ),
			'section' => 'wpex_slider',
			'settings' => 'wpex_homepage_slider_slideshow_speed',
			'type' => 'text',
		) );

		// Slider Alt
		$wp_customize->add_setting( 'wpex_homepage_slider_alt', array(
			'type' => 'theme_mod',
			'sanitize_callback' => 'wp_kses_post',
		) );

		$wp_customize->add_control( 'wpex_homepage_slider_alt', array(
			'label' => __( 'Homepage Slider Alternative', 'spartan' ),
			'section' => 'wpex_slider',
			'settings' => 'wpex_homepage_slider_alt',
			'type' => 'textarea',
		) );


		/*-----------------------------------------------------------------------------------*/
		/*  - Homepage Carousel
		/*-----------------------------------------------------------------------------------*/
		
		// Theme Settings Section
		$wp_customize->add_section( 'wpex_carousel' , array(
			'title' => __( 'Homepage Carousel', 'spartan' ),
			'panel' => 'wpex_homepage',
		) );

		// Carousel Heading
		$wp_customize->add_setting( 'wpex_homepage_carousel_heading', array(
			'type' => 'theme_mod',
			'default' => __( 'Featured', 'spartan' ),
			'sanitize_callback' => 'wp_kses_post',
		) );

		$wp_customize->add_control( 'wpex_homepage_carousel_heading', array(
			'label' => __( 'Homepage Carousel Heading', 'spartan' ),
			'section' => 'wpex_carousel',
			'settings' => 'wpex_homepage_carousel_heading',
		) );

		// Carousel Content
		$wp_customize->add_setting( 'wpex_homepage_carousel_content', array(
			'type' => 'theme_mod',
			'default' => 'recent_posts',
			'sanitize_callback' => 'esc_html',
		) );

		$wp_customize->add_control( 'wpex_homepage_carousel_content', array(
			'label' => __( 'Homepage Carousel Content', 'spartan' ),
			'section' => 'wpex_carousel',
			'settings' => 'wpex_homepage_carousel_content',
			'type' => 'select',
			'choices' => $slider_carousel_choices,
		) );

		// Carousel Count
		$wp_customize->add_setting( 'wpex_homepage_carousel_count', array(
			'type' => 'theme_mod',
			'default' => '3',
			'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( 'wpex_homepage_carousel_count', array(
			'label' => __( 'Homepage Carousel Count', 'spartan' ),
			'section' => 'wpex_carousel',
			'settings' => 'wpex_homepage_carousel_count',
			'type' => 'text',
		) );

		// Carousel exclude posts
		$wp_customize->add_setting( 'wpex_homepage_carousel_exclude_posts', array(
			'type' => 'theme_mod',
			'sanitize_callback' => 'esc_html',
		) );

		$wp_customize->add_control( 'wpex_homepage_carousel_exclude_posts', array(
			'label' => __( 'Exclude Posts', 'spartan' ),
			'section' => 'wpex_carousel',
			'settings' => 'wpex_homepage_carousel_exclude_posts',
			'type' => 'checkbox',
			'description' => __( 'Check this box to exclude posts included in the carousel from the homepage grid.', 'spartan' ),
		) );

	}
}
add_action( 'customize_register', 'wpex_customizer_homepage' );