<?php
/**
 * General theme options
 *
 * @package		WordPress
 * @subpackage	Spartan WPExplorer Theme
 * @since		Spartan 1.0
 */

if ( ! function_exists( 'wpex_customizer_general' ) ) {

	function wpex_customizer_general( $wp_customize ) {

		// Add General Panel
		$wp_customize->add_panel( 'wpex_general', array(
			'priority' => 140,
			'capability' => 'edit_theme_options',
			'title' => __( 'General', 'spartan' ),
		) );

		/*-----------------------------------------------------------------------------------*/
		/*	- Main
		/*-----------------------------------------------------------------------------------*/

		// Theme Settings Section
		$wp_customize->add_section( 'wpex_general' , array(
			'title' => __( 'Main', 'spartan' ),
			'panel' => 'wpex_general',
		) );

		// Responsive
		$wp_customize->add_setting( 'wpex_responsive', array(
			'type' => 'theme_mod',
			'default' => '1',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_responsive', array(
			'label' => __( 'Enable Responsive Design', 'spartan' ),
			'section' => 'wpex_general',
			'settings' => 'wpex_responsive',
			'type' => 'checkbox',
		) );

		// Page Comments
		$wp_customize->add_setting( 'wpex_page_comments', array(
			'type' => 'theme_mod',
			'default' => '',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_page_comments', array(
			'label' => __( 'Comments on Pages', 'spartan' ),
			'section' => 'wpex_general',
			'settings' => 'wpex_page_comments',
			'type' => 'checkbox',
		) );

		// Custom WP Gallery
		$wp_customize->add_setting( 'wpex_custom_wp_gallery_output', array(
			'type' => 'theme_mod',
			'default' => '1',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_custom_wp_gallery_output', array(
			'label' => __( 'Custom WP Gallery Output', 'spartan' ),
			'section' => 'wpex_general',
			'settings' => 'wpex_custom_wp_gallery_output',
			'type' => 'checkbox',
		) );

		// Pagination
		$wp_customize->add_setting( 'wpex_pagination', array(
			'type' => 'theme_mod',
			'default' => 'pagination',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_pagination', array(
			'label' => __( 'Pagination Style', 'spartan' ),
			'section' => 'wpex_general',
			'settings' => 'wpex_pagination',
			'type' => 'select',
			'choices' => array(
 				'pagination' => __( 'Pagination', 'spartan' ),
 				'next-prev' => __( 'Older/Newer', 'spartan' )
			)
		) );

		// Dashboard thumbns
		$wp_customize->add_setting( 'wpex_dashboard_thumbs', array(
			'type' => 'theme_mod',
			'default' => '1',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_dashboard_thumbs', array(
			'label' => __( 'Post Thumbs In Admin Dashboard', 'spartan' ),
			'section' => 'wpex_general',
			'settings' => 'wpex_dashboard_thumbs',
			'type' => 'checkbox',
		) );

		// Featured category entry
		$wp_customize->add_setting( 'wpex_archive_feature_first_post', array(
			'type' => 'theme_mod',
			'default' => true,
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_archive_feature_first_post', array(
			'label' => __( 'Featured Category Entry', 'spartan' ),
			'section' => 'wpex_general',
			'settings' => 'wpex_archive_feature_first_post',
			'type' => 'checkbox',
		) );

		/*-----------------------------------------------------------------------------------*/
		/*	- Top Bar
		/*-----------------------------------------------------------------------------------*/

		// Theme Settings Section
		$wp_customize->add_section( 'wpex_topbar' , array(
			'title' => __( 'Top Bar', 'spartan' ),
			'panel' => 'wpex_general',
		) );

		// Top bar
		$wp_customize->add_setting( 'wpex_topbar', array(
			'type' => 'theme_mod',
			'default' => '1',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_topbar', array(
			'label' => __( 'Enable Topbar', 'spartan' ),
			'section' => 'wpex_topbar',
			'settings' => 'wpex_topbar',
			'type' => 'checkbox',
		) );

		// Top bar date
		$wp_customize->add_setting( 'wpex_topbar_date', array(
			'type' => 'theme_mod',
			'default' => '1',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_topbar_date', array(
			'label' => __( 'Enable Topbar Date', 'spartan' ),
			'section' => 'wpex_topbar',
			'settings' => 'wpex_topbar_date',
			'type' => 'checkbox',
		) );

		// Top bar search
		$wp_customize->add_setting( 'wpex_topbar_search', array(
			'type' => 'theme_mod',
			'default' => '1',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_topbar_search', array(
			'label' => __( 'Enable Topbar Search', 'spartan' ),
			'section' => 'wpex_topbar',
			'settings' => 'wpex_topbar_search',
			'type' => 'checkbox',
		) );

		// Login/out page
		$choices = array(
			'' => __( 'None', 'spartan' ),
		);

		$pages = get_pages( array(
			'number' => '100',
		) );
		if ( $pages ) {
			foreach ( $pages as $page ) {
 				$choices[$page->ID] = $page->post_title;
			}
		}
		$wp_customize->add_setting( 'wpex_login_page', array(
			'type' => 'theme_mod',
			'default' => '',
			'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( 'wpex_login_page', array(
			'label' => __( 'Login Page URL', 'spartan' ),
			'section' => 'wpex_topbar',
			'settings' => 'wpex_login_page',
			'type' => 'select',
			'choices' => $choices,
			'description' => __( 'Select a page to add a login/logout link automatically to the end of the top bar menu.', 'spartan' ),
		) );


		/*-----------------------------------------------------------------------------------*/
		/*	- Header
		/*-----------------------------------------------------------------------------------*/

		// Theme Settings Section
		$wp_customize->add_section( 'wpex_header' , array(
			'title' => __( 'Header', 'spartan' ),
			'panel' => 'wpex_general'
		) );

		// Logo
		$wp_customize->add_setting( 'wpex_logo', array(
			'type' => 'theme_mod',
			'sanitize_callback' => 'esc_url',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'wpex_logo', array(
			'label' => __( 'Image Logo', 'spartan' ),
			'section' => 'wpex_header',
			'settings' => 'wpex_logo',
		) ) );

		// Retina Logo
		$wp_customize->add_setting( 'wpex_retina_logo', array(
			'type' => 'theme_mod',
			'default' => '',
			'sanitize_callback' => 'esc_url',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'wpex_retina_logo', array(
			'label' => __( 'Retina Image Logo', 'spartan' ),
			'section' => 'wpex_header',
			'settings' => 'wpex_retina_logo',
		) ) );

		// Retina Logo Height
		$wp_customize->add_setting( 'wpex_retina_logo_height', array(
			'type' => 'theme_mod',
			'default' => '',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'wpex_retina_logo_height', array(
			'label' => __( 'Logo Image Height For Retina', 'spartan' ),
			'section' => 'wpex_header',
			'settings' => 'wpex_retina_logo_height',
			'type' => 'text',
			'description' => __( 'Enter the standard height in pixels of your standard logo. This is used to set your retina logo to the correct dimensions', 'spartan' ),
		) );

		// Subheading
		$wp_customize->add_setting( 'wpex_logo_subheading', array(
			'type' => 'theme_mod',
			'default' => __( 'Edit your subheading via the theme customizer.', 'spartan' ),
			'transport' => 'refresh',
			'sanitize_callback' => 'wp_kses_post',
		) );
		$wp_customize->add_control( 'wpex_logo_subheading', array(
			'label' => __( 'Subheading Under Logo', 'spartan' ),
			'section' => 'wpex_header',
			'settings' => 'wpex_logo_subheading',
			'type' => 'textarea',
		) );

		// Fixed Nav
		$wp_customize->add_setting( 'wpex_fixed_nav', array(
			'type' => 'theme_mod',
			'default' => '1',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_fixed_nav', array(
			'label' => __( 'Fixed Navigation On Scroll', 'spartan' ),
			'section' => 'wpex_header',
			'settings' => 'wpex_fixed_nav',
			'type' => 'checkbox',
		) );

		// Mobile Menu Open Text
		$wp_customize->add_setting( 'wpex_mobile_menu_open_text', array(
			'type' => 'theme_mod',
			'default' => __( 'Browse Categories', 'spartan' ),
			'sanitize_callback' => 'wp_kses_post',
		) );
		$wp_customize->add_control( 'wpex_mobile_menu_open_text', array(
			'label' => __( 'Mobile Menu: Open Text', 'spartan' ),
			'section' => 'wpex_header',
			'settings' => 'wpex_mobile_menu_open_text',
			'type' => 'text',
		) );

		// Mobile Menu Open Text
		$wp_customize->add_setting( 'wpex_mobile_menu_close_text', array(
			'type' => 'theme_mod',
			'default' => __( 'Close navigation', 'spartan' ),
			'sanitize_callback' => 'wp_kses_post',
		) );
		$wp_customize->add_control( 'wpex_mobile_menu_close_text', array(
			'label' => __( 'Mobile Menu: Close Text', 'spartan' ),
			'section' => 'wpex_header',
			'settings' => 'wpex_mobile_menu_close_text',
			'type' => 'text',
		) );


		/*-----------------------------------------------------------------------------------*/
		/*	- Layouts
		/*-----------------------------------------------------------------------------------*/

		// Theme Settings Section
		$wp_customize->add_section( 'wpex_layouts' , array(
			'title' => __( 'Layouts', 'spartan' ),
			'panel' => 'wpex_general'
		) );

		// Site Layout
		$wp_customize->add_setting( 'wpex_entry_style', array(
			'type' => 'theme_mod',
			'default' => 'left-thumbnail',
			'sanitize_callback' => 'esc_html',
		) );

		$wp_customize->add_control( 'wpex_entry_style', array(
			'label' => __( 'Default Entry Style','spartan'),
			'section' => 'wpex_layouts',
			'settings' => 'wpex_entry_style',
			'type' => 'select',
			'choices' => array(
 				'left-thumbnail' => __( 'Left Thumbnail', 'spartan' ),
 				'two-columns' => __( '2 Columns', 'spartan' ),
			)
		) );

		// Site Layout
		$wp_customize->add_setting( 'wpex_site_layout', array(
			'type' => 'theme_mod',
			'default' => 'right-sidebar',
			'sanitize_callback' => 'esc_html',
		) );

		$wp_customize->add_control( 'wpex_site_layout', array(
			'label' => __( 'Site Layout','spartan'),
			'section' => 'wpex_layouts',
			'settings' => 'wpex_site_layout',
			'type' => 'select',
			'choices' => array(
 				'right-sidebar' => __( 'Right Sidebar', 'spartan' ),
 				'left-sidebar' => __( 'Left Sidebar', 'spartan' ),
			)
		) );

		// Footer Columns
		$wp_customize->add_setting( 'wpex_footer_columns', array(
			'type' => 'theme_mod',
			'default' => '4',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_footer_columns', array(
			'label' => __( 'Footer Widget Columns','spartan'),
			'section' => 'wpex_layouts',
			'settings' => 'wpex_footer_columns',
			'type' => 'select',
			'choices' => array(
				'4' => '4',
				'3' => '3',
				'2' => '2',
				'1' => '1',
				'0' => '0',
			)
		) );


		/*-----------------------------------------------------------------------------------*/
		/*	- Category Colors
		/*-----------------------------------------------------------------------------------*/
		$cats = get_categories( array(
			'orderby' => 'name',
			'hide_empty' => false,
			//'parent' => 0
		) );

		// Theme Settings Section
		$wp_customize->add_section( 'wpex_category_colors' , array(
			'title' => __( 'Category Colors', 'spartan' ),
			'panel' => 'wpex_general',
		) );

		// Loop through categories and add color option
		if( $cats ) {
			foreach( $cats as $cat ) {
				$wp_customize->add_setting( 'wpex_cat_'. $cat->term_id .'_color', array(
					'type' => 'theme_mod',
					'default' => '',
					'sanitize_callback' => 'esc_html',
				) );
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wpex_cat_'. $cat->term_id .'_color', array(
					'label' => $cat->name,
					'section' => 'wpex_category_colors',
					'settings' => 'wpex_cat_'. $cat->term_id .'_color',
				) ) );
			}
		}


		/*-----------------------------------------------------------------------------------*/
		/*	- Ads
		/*-----------------------------------------------------------------------------------*/

		// Default ads
		$ad_620x80 = '<a href="#"><img src="'. get_template_directory_uri() .'/images/ad-620x80.png" /></a>';
		$ad_250 = '<a href="#"><img src="'. get_template_directory_uri() .'/images/ad-250x250.png" /></a>';

		// Theme Settings Section
		$wp_customize->add_section( 'wpex_ads' , array(
			'title' => __( 'Advertisements', 'spartan' ),
			'panel' => 'wpex_general',
		) );

		// Header Ad
		$wp_customize->add_setting( 'wpex-ad-header', array(
			'type' => 'theme_mod',
			'default' => $ad_620x80,
			'transport' => 'refresh',
			'sanitize_callback' => false,
		) );
		$wp_customize->add_control( 'wpex-ad-header', array(
			'label' => __( 'Header', 'spartan' ),
			'section' => 'wpex_ads',
			'settings' => 'wpex-ad-header',
			'type' => 'textarea',
		) );

		// Post Before media
		$wp_customize->add_setting( 'wpex-ad-post-before', array(
			'type' => 'theme_mod',
			'default' => $ad_620x80,
			'transport' => 'refresh',
			'sanitize_callback' => false,
		) );
		$wp_customize->add_control( 'wpex-ad-post-before', array(
			'label' => __( 'Post: Before Media/Title', 'spartan' ),
			'section' => 'wpex_ads',
			'settings' => 'wpex-ad-post-before',
			'type' => 'textarea',
		) );

		// Post Top Ad
		$wp_customize->add_setting( 'wpex-ad-post-top', array(
			'type' => 'theme_mod',
			'default' => $ad_250,
			'transport' => 'refresh',
			'sanitize_callback' => false,
		) );
		$wp_customize->add_control( 'wpex-ad-post-top', array(
			'label' => __( 'Post Content: Top', 'spartan' ),
			'section' => 'wpex_ads',
			'settings' => 'wpex-ad-post-top',
			'type' => 'textarea',
			'description' => __( 'This ad is floated to the left and a 250x250 or 300x250 ad will work best.', 'spartan' ),
		) );

		// Post Bottom Ad
		$wp_customize->add_setting( 'wpex-ad-post-bottom', array(
			'type' => 'theme_mod',
			'default' => $ad_620x80,
			'transport' => 'refresh',
			'sanitize_callback' => false,
		) );
		$wp_customize->add_control( 'wpex-ad-post-bottom', array(
			'label' => __( 'Post Content: Bottom', 'spartan' ),
			'section' => 'wpex_ads',
			'settings' => 'wpex-ad-post-bottom',
			'type' => 'textarea',
		) );

		// Home Top Ad
		$wp_customize->add_setting( 'wpex-ad-home-top', array(
			'type' => 'theme_mod',
			'default' => $ad_620x80,
			'transport' => 'refresh',
			'sanitize_callback' => false,
		) );
		$wp_customize->add_control( 'wpex-ad-home-top', array(
			'label' => __( 'Homepage: Top', 'spartan' ),
			'section' => 'wpex_ads',
			'settings' => 'wpex-ad-home-top',
			'type' => 'textarea',
		) );

		// Home Bottom Ad
		$wp_customize->add_setting( 'wpex-ad-home-bottom', array(
			'type' => 'theme_mod',
			'default' => $ad_620x80,
			'transport' => 'refresh',
			'sanitize_callback' => false,
		) );
		$wp_customize->add_control( 'wpex-ad-home-bottom', array(
			'label' => __( 'Homepage: Bottom', 'spartan' ),
			'section' => 'wpex_ads',
			'settings' => 'wpex-ad-home-bottom',
			'type' => 'textarea',
		) );

		// Archive Top Ad
		$wp_customize->add_setting( 'wpex-ad-archive-top', array(
			'type' => 'theme_mod',
			'default' => $ad_620x80,
			'transport' => 'refresh',
			'sanitize_callback' => false,
		) );
		$wp_customize->add_control( 'wpex-ad-archive-top', array(
			'label' => __( 'Archive: Top', 'spartan' ),
			'section' => 'wpex_ads',
			'settings' => 'wpex-ad-archive-top',
			'type' => 'textarea',
		) );

		// Archive Bottom Ad
		$wp_customize->add_setting( 'wpex-ad-archive-bottom', array(
			'type' => 'theme_mod',
			'default' => $ad_620x80,
			'transport' => 'refresh',
			'sanitize_callback' => false,
		) );
		$wp_customize->add_control( 'wpex-ad-archive-bottom', array(
			'label' => __( 'Archive: Bottom', 'spartan' ),
			'section' => 'wpex_ads',
			'settings' => 'wpex-ad-archive-bottom',
			'type' => 'textarea',
		) );


		/*-----------------------------------------------------------------------------------*/
		/*	- SEO
		/*-----------------------------------------------------------------------------------*/

		// Vars
		$html_tags = array(
			'span' => 'span',
			'div' => 'div',
			'h2' => 'h2',
			'h3' => 'h3',
			'h4' => 'h4',
			'h5' => 'h5',
		);

		// Theme Settings Section
		$wp_customize->add_section( 'wpex_seo' , array(
			'title' => __( 'SEO', 'spartan' ),
			'panel' => 'wpex_general',
		) );

		// Comments Link
		$wp_customize->add_setting( 'wpex_comment_author_link', array(
			'type' => 'theme_mod',
			'default' => '',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_comment_author_link', array(
			'label' => __('Disable Links In Comments','spartan'),
			'section' => 'wpex_seo',
			'settings' => 'wpex_comment_author_link',
			'type' => 'checkbox',
		) );

		// Sidebar Widget Title Type
		$wp_customize->add_setting( 'wpex_sidebar_heading_tags', array(
			'type' => 'theme_mod',
			'default' => 'span',
			'sanitize_callback' => 'esc_html',
		) );

		$wp_customize->add_control( 'wpex_sidebar_heading_tags', array(
			'label' => __( 'Sidebar Heading Tags','spartan'),
			'section' => 'wpex_seo',
			'settings' => 'wpex_sidebar_heading_tags',
			'type' => 'select',
			'choices' => $html_tags,
		) );

		// Footer Widget Title Type
		$wp_customize->add_setting( 'wpex_footer_heading_tags', array(
			'type' => 'theme_mod',
			'default' => 'span',
			'sanitize_callback' => 'esc_html',
		) );

		$wp_customize->add_control( 'wpex_footer_heading_tags', array(
			'label' => __( 'Footer Heading Tags','spartan'),
			'section' => 'wpex_seo',
			'settings' => 'wpex_footer_heading_tags',
			'type' => 'select',
			'choices' => $html_tags,
		) );

		
		/*-----------------------------------------------------------------------------------*/
		/*	- Social Sharing
		/*-----------------------------------------------------------------------------------*/

		// Theme Settings Section
		$wp_customize->add_section( 'wpex_social_sharing' , array(
			'title' => __( 'Social Sharing', 'spartan' ),
			'panel' => 'wpex_general',
		) );

		// Enable/Disable Social at the top of posts
		$wp_customize->add_setting( 'wpex_social_sharing_post_top', array(
			'type' => 'theme_mod',
			'default' => '',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_social_sharing_post_top', array(
			'label' => __( 'Enable Social Sharing Above Posts', 'spartan' ),
			'section' => 'wpex_social_sharing',
			'settings' => 'wpex_social_sharing_post_top',
			'type' => 'checkbox',
		) );

		// Enable/Disable Social at the top of posts
		$wp_customize->add_setting( 'wpex_social_sharing_post_bottom', array(
			'type' => 'theme_mod',
			'default' => '1',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_social_sharing_post_bottom', array(
			'label' => __( 'Enable Social Sharing Below Posts', 'spartan' ),
			'section' => 'wpex_social_sharing',
			'settings' => 'wpex_social_sharing_post_bottom',
			'type' => 'checkbox',
		) );

		// Select Services
		$wp_customize->add_setting( 'wpex_social_share_services', array(
			'type' => 'theme_mod',
			'default' => array( 'twitter', 'facebook', 'google_plus', 'pinterest', 'linkedin' ),
			'sanitize_callback' => false,
		) );
		$wp_customize->add_control( new WPEX_Customize_Multicheck_Control( $wp_customize, 'wpex_social_share_services',
			array(
				'settings' => 'wpex_social_share_services',
				'label' => __( 'Enabled Services', 'spartan' ),
				'section' => 'wpex_social_sharing',
				'type' => 'multicheck',
				'choices' => array(
					'twitter' => 'Twitter',
					'facebook' => 'Facebook',
					'google_plus' => 'Google Plus',
					'pinterest' => 'Pinterest',
					'linkedin' => 'LinkedIn',
				)
			)
		) );


		/*-----------------------------------------------------------------------------------*/
		/*	- Copyright
		/*-----------------------------------------------------------------------------------*/

		// Copyright Section
		$wp_customize->add_section( 'wpex_copyright' , array(
			'title' => __( 'Copyright', 'spartan' ),
			'panel' => 'wpex_general',
		) );
		
		$wp_customize->add_setting( 'wpex_copyright', array(
			'type' => 'theme_mod',
			'default' => '',
			'sanitize_callback' => 'wp_kses_post',
		) );

		$wp_customize->add_control( 'wpex_copyright', array(
			'label' => __('Custom Copyright','spartan'),
			'section' => 'wpex_copyright',
			'settings' => 'wpex_copyright',
			'type' => 'textarea',
		) );

		/*-----------------------------------------------------------------------------------*/
		/*	- Entries
		/*-----------------------------------------------------------------------------------*/

		// Define Entries Section
		$wp_customize->add_section( 'wpex_entries' , array(
			'title' => __( 'Entries', 'spartan' ),
			'panel' => 'wpex_general',
		) );

		// Excerpt Length
		$wp_customize->add_setting( 'wpex_excerpt_length', array(
			'type' => 'theme_mod',
			'default' => '25',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'wpex_excerpt_length', array(
			'label' => __( 'Excerpt Lengths', 'spartan' ),
			'section' => 'wpex_entries',
			'settings' => 'wpex_excerpt_length',
		) );

		// Readmore Text
		$wp_customize->add_setting( 'wpex_readmore_text', array(
			'type' => 'theme_mod',
			'default' => __( 'Read More', 'spartan' ),
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_readmore_text', array(
			'label' => __( 'Entry Read More Link Text', 'spartan' ),
			'section' => 'wpex_entries',
			'settings' => 'wpex_readmore_text',
		) );

		// Ignore More Tag
		$wp_customize->add_setting( 'wpex_ignore_more_tag', array(
			'type' => 'theme_mod',
			'default' => '',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_ignore_more_tag', array(
			'label' => __( 'Ignore More Tag', 'spartan' ),
			'section' => 'wpex_entries',
			'settings' => 'wpex_ignore_more_tag',
			'type' => 'checkbox',
		) );

		// Entries display?
		$wp_customize->add_setting( 'wpex_entry_content_excerpt', array(
			'type' => 'theme_mod',
			'default' => 'excerpt',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_entry_content_excerpt', array(
			'label' => __( 'Entries display?', 'spartan' ),
			'section' => 'wpex_entries',
			'settings' => 'wpex_entry_content_excerpt',
			'type' => 'select',
			'choices' => array(
				'excerpt' => __( 'The Excerpt', 'spartan' ),
				'content' => __( 'The Content', 'spartan' )
			)
		) );

		// Readmore
		$wp_customize->add_setting( 'wpex_blog_readmore', array(
			'type' => 'theme_mod',
			'default' => '',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_blog_readmore', array(
			'label' => __( 'Entry Read More Link', 'spartan' ),
			'section' => 'wpex_entries',
			'settings' => 'wpex_blog_readmore',
			'type' => 'checkbox',
		) );

		// Entry Embeds
		$wp_customize->add_setting( 'wpex_entry_embeds', array(
			'type' => 'theme_mod',
			'default' => '',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_entry_embeds', array(
			'label' => __( 'Entry Video/Audio Embeds', 'spartan' ),
			'section' => 'wpex_entries',
			'settings' => 'wpex_entry_embeds',
			'type' => 'checkbox',
		) );


		// Entry Lightbox
		$wp_customize->add_setting( 'wpex_entry_img_lightbox', array(
			'type' => 'theme_mod',
			'default' => '',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_entry_img_lightbox', array(
			'label' => __( 'Entry Featured Image Lightbox', 'spartan' ),
			'section' => 'wpex_entries',
			'settings' => 'wpex_entry_img_lightbox',
			'type' => 'checkbox',
		) );

		// Entry Meta
		$wp_customize->add_setting( 'wpex_entry_meta', array(
			'type' => 'theme_mod',
			'default' => array( 'date', 'comments' ),
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( new WPEX_Customize_Multicheck_Control( $wp_customize, 'wpex_entry_meta',
			array(
				'settings' => 'wpex_entry_meta',
				'label' => __( 'Entry Meta Displays?', 'spartan' ),
				'section' => 'wpex_entries',
				'type' => 'multicheck',
				'choices' => array(
					'date' => __( 'Date', 'spartan' ),
					'author' => __( 'Author', 'spartan' ),
					'category' => __( 'Category', 'spartan' ),
					'comments' => __( 'Comments', 'spartan' ),
				)
			)
		) );

		/*-----------------------------------------------------------------------------------*/
		/*	- Posts
		/*-----------------------------------------------------------------------------------*/

		// Theme Settings Section
		$wp_customize->add_section( 'wpex_posts' , array(
			'title' => __( 'Posts', 'spartan' ),
			'panel' => 'wpex_general',
		) );

		// Post Thumb
		$wp_customize->add_setting( 'wpex_blog_post_thumb', array(
			'type' => 'theme_mod',
			'default' => '1',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_blog_post_thumb', array(
			'label' => __( 'Featured Image on Posts', 'spartan' ),
			'section' => 'wpex_posts',
			'settings' => 'wpex_blog_post_thumb',
			'type' => 'checkbox',
		) );

		// Post Tags
		$wp_customize->add_setting( 'wpex_post_tags', array(
			'type' => 'theme_mod',
			'default' => '1',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_post_tags', array(
			'label' => __( 'Post Tags', 'spartan' ),
			'section' => 'wpex_posts',
			'settings' => 'wpex_post_tags',
			'type' => 'checkbox',
		) );

		// Post Author
		$wp_customize->add_setting( 'wpex_post_author', array(
			'type' => 'theme_mod',
			'default' => '1',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_post_author', array(
			'label' => __( 'Post Author Box', 'spartan' ),
			'section' => 'wpex_posts',
			'settings' => 'wpex_post_author',
			'type' => 'checkbox',
		) );

		// Next Prev
		$wp_customize->add_setting( 'wpex_next_prev', array(
			'type' => 'theme_mod',
			'default' => '1',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_next_prev', array(
			'label' => __( 'Next & Previous Post Links', 'spartan' ),
			'section' => 'wpex_posts',
			'settings' => 'wpex_next_prev',
			'type' => 'checkbox',
		) );

		// Post Meta
		$wp_customize->add_setting( 'wpex_post_meta', array(
			'type' => 'theme_mod',
			'default' => array( 'date', 'author', 'category', 'comments' ),
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( new WPEX_Customize_Multicheck_Control( $wp_customize, 'wpex_post_meta',
			array(
				'settings' => 'wpex_post_meta',
				'label' => __( 'Post Meta Displays?', 'spartan' ),
				'section' => 'wpex_posts',
				'type' => 'multicheck',
				'choices' => array(
					'date' => __( 'Date', 'spartan' ),
					'author' => __( 'Author', 'spartan' ),
					'category' => __( 'Category', 'spartan' ),
					'comments' => __( 'Comments', 'spartan' ),
				)
			)
		) );

		// Related Posts
		$wp_customize->add_setting( 'wpex_related', array(
			'type' => 'theme_mod',
			'default' => '1',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_related', array(
			'label' => __( 'Related Posts', 'spartan' ),
			'section' => 'wpex_posts',
			'settings' => 'wpex_related',
			'type' => 'checkbox',
		) );

		// Related Posts Based on current category
		$wp_customize->add_setting( 'wpex_related_category_relation', array(
			'type' => 'theme_mod',
			'default' => true,
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_related_category_relation', array(
			'label' => __( 'Related Posts from Current Category', 'spartan' ),
			'section' => 'wpex_posts',
			'settings' => 'wpex_related_category_relation',
			'type' => 'checkbox',
			'description' => __( 'If enabled the related posts section will only display posts from the same categories that the current post belongs to.', 'spartan' )
		) );

		// Related Posts Order
		$wp_customize->add_setting( 'wpex_related_order', array(
			'type' => 'theme_mod',
			'default' => 'DESC',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_related_order', array(
			'label' => __( 'Related Posts Order', 'spartan' ),
			'section' => 'wpex_posts',
			'settings' => 'wpex_related_order',
			'type' => 'select',
			'choices' => array(
				'DESC' => __( 'Descending', 'spartan' ),
				'ASC' => __( 'Ascending', 'spartan' ),
			)
		) );

		// Related Posts Orderby
		$wp_customize->add_setting( 'wpex_related_orderby', array(
			'type' => 'theme_mod',
			'default' => 'rand',
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'wpex_related_orderby', array(
			'label' => __( 'Related Posts Orderby', 'spartan' ),
			'section' => 'wpex_posts',
			'settings' => 'wpex_related_orderby',
			'type' => 'select',
			'choices' => array(
             	'rand' => __( 'Random', 'spartan' ),
				'date' => __( 'Date', 'spartan' ),
				'modified' => __( 'Modified', 'spartan'),
				'menu_order' => __( 'Menu Order', 'spartan' ),
			)
		) );

	}
}
add_action( 'customize_register', 'wpex_customizer_general' );