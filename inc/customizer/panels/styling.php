<?php
/**
 * This class adds styling (color) options to the WordPress
 * Theme Customizer and outputs the needed CSS to the header
 * 
 * @package		WordPress
 * @subpackage	Spartan WPExplorer Theme
 * @since		Spartan 1.0
 * @link		http://codex.wordpress.org/Theme_Customization_API
 */

if ( ! class_exists( 'WPEX_Theme_Customizer_Styling' ) ) {
	class WPEX_Theme_Customizer_Styling {

		/*-----------------------------------------------------------------------------------*/
		/*	- Constructor
		/*-----------------------------------------------------------------------------------*/
		public function __construct() {
			
			// Setup the Theme Customizer settings and controls
			add_action( 'customize_register', array( $this , 'register' ) );

			// Reset cache on customizer save
			add_action( 'customize_save_after', array( $this, 'reset_cache' ) );

			// Output custom CSS to live site
			add_action( 'wp_head' , array( $this, 'header_output' ) );

		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Array of elements for styling options
		/*-----------------------------------------------------------------------------------*/
		public function wpex_color_options() {

			$array = array();

			// Top Bar
			$array[] = array(
				'label'		=> __( 'Top Bar Background', 'spartan' ),
				'id'		=> 'topbar_bg',
				'element'	=> '#topbar',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Bottom Border', 'spartan' ),
				'id'		=> 'topbar_border',
				'element'	=> '#topbar',
				'style'		=> 'border-color',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Date Borders', 'spartan' ),
				'id'		=> 'topbar_date_borders',
				'element'	=> '#topbar-date',
				'style'		=> 'border-color',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Text Color', 'spartan' ),
				'id'		=> 'topbar_color',
				'element'	=> '#topbar, #topbar p',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Link Color', 'spartan' ),
				'id'		=> 'topbar_link_color',
				'element'	=> '#topbar a',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Link Hover Color', 'spartan' ),
				'id'		=> 'topbar_link_hover_color',
				'element'	=> '#topbar a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_topbar',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Menu Divider Color', 'spartan' ),
				'id'		=> 'topbar_menu_divider_color',
				'element'	=> '#topbar-nav .sf-menu > li:after',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_topbar',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Menu Bottom Border Color', 'spartan' ),
				'id'		=> 'topbar_menu_bottom_border_color',
				'element'	=> '#topbar-nav .sf-menu > li > a',
				'style'		=> 'border-color',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Menu Dropdowns Background', 'spartan' ),
				'id'		=> 'topbar_menudropdown_bg',
				'element'	=> '#topbar-nav .sf-menu .sub-menu',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Menu Dropdowns Borders', 'spartan' ),
				'id'		=> 'topbar_menudropdown_borders',
				'element'	=> '#topbar-nav .sf-menu .sub-menu a',
				'style'		=> 'border-color',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Menu Dropdowns Link Color', 'spartan' ),
				'id'		=> 'topbar_menudropdown_link_color',
				'element'	=> '#topbar-nav .sf-menu .sub-menu a',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Menu Dropdowns Link Hover Color', 'spartan' ),
				'id'		=> 'topbar_menudropdown_link_hover_color',
				'element'	=> '#topbar-nav .sf-menu .sub-menu a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_topbar',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Search Background', 'spartan' ),
				'id'		=> 'topbar_search_bg',
				'element'	=> '.topbar-searchform-input',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Search Borders', 'spartan' ),
				'id'		=> 'topbar_search_border_color',
				'element'	=> '.topbar-searchform-input',
				'style'		=> 'border-color',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Search Color', 'spartan' ),
				'id'		=> 'topbar_search_color',
				'element'	=> '.topbar-searchform-input',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Search Icon Color', 'spartan' ),
				'id'		=> 'topbar_search_icon_color',
				'element'	=> '.header-searchform-btn',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'			=> __( 'Top Bar Mobile Icons Color', 'spartan' ),
				'id'			=> 'topbar_mobile_icons_color',
				'element'		=> '#topbar .topbar-nav-mobile-toggle, #topbar .topbar-search-mobile-toggle, #topbar .topbar-mobile-login-link',
				'style'			=> 'color',
				'section'		=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'			=> __( 'Top Bar Mobile Icons Border Color', 'spartan' ),
				'id'			=> 'topbar_mobile_icons_borders',
				'element'		=> '#topbar .container, #topbar .topbar-nav-mobile-toggle, #topbar .topbar-search-mobile-toggle, #topbar .topbar-mobile-login-link',
				'style'			=> 'border-color',
				'section'		=> 'wpex_styling_topbar',
				'media_query'	=> '@media only screen and (max-width: 959px)',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Mobile Menu Link Color', 'spartan' ),
				'id'		=> 'topbar_mobile_menu_link_color',
				'element'	=> '.wpex-mobile-top-nav-ul li a',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Mobile Menu Link Hover Color', 'spartan' ),
				'id'		=> 'topbar_mobile_menu_link_hover_color',
				'element'	=> '.wpex-mobile-top-nav-ul li a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_topbar',
			);

			$array[] = array(
				'label'		=> __( 'Top Bar Mobile Menu Link Border Color', 'spartan' ),
				'id'		=> 'topbar_mobile_menu_link_border_color',
				'element'	=> '.wpex-mobile-top-nav-ul li a',
				'style'		=> 'border-color',
				'section'	=> 'wpex_styling_topbar',
			);

			// Header
			$array[] = array(
				'label'		=> __( 'Header Top Padding', 'spartan' ),
				'id'		=> 'header_top_pad',
				'element'	=> '#header',
				'style'		=> 'padding-top',
				'type'		=> 'text',
				'default'	=> '',
				'section'	=> 'wpex_styling_header',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=> __( 'Header Bottom Padding', 'spartan' ),
				'id'		=> 'header_bottom_pad',
				'element'	=> '#header',
				'style'		=> 'padding-bottom',
				'type'		=> 'text',
				'default'	=> '',
				'section'	=> 'wpex_styling_header',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=> __( 'Header Background', 'spartan' ),
				'id'		=> 'header_bg_color',
				'element'	=> '#top-wrap',
				'style'		=> 'background-color',
				'section'	=> 'wpex_styling_header',
			);

			$array[] = array(
				'label'		=>	__( 'Logo Text Color', 'spartan' ),
				'id'		=>	'logo_color',
				'element'	=> '.site-text-logo a',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_header',
			);

			$array[] = array(
				'label'		=>	__( 'Logo Text Color: Hover', 'spartan' ),
				'id'		=>	'logo_hover_color',
				'element'	=> '.site-text-logo a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_header',
			);

			$array[] = array(
				'label'		=>	__( 'Logo Subheading Text Color', 'spartan' ),
				'id'		=>	'subheading_color',
				'element'	=> '#blog-description',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_header',
			);

			// Menu
			$array[] = array(
				'label'		=>	__( 'Menu Background', 'spartan' ),
				'id'		=>	'nav_bg',
				'element'	=> '#site-navigation-inner, #site-navigation-wrap.is-sticky',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_menu',
			);

			$array[] = array(
				'label'		=>	__( 'Menu Top Border Color', 'spartan' ),
				'id'		=>	'nav_top_border',
				'element'	=> '#site-navigation-inner',
				'style'		=> 'border-top-color',
				'section'	=> 'wpex_styling_menu',
			);

			$array[] = array(
				'label'		=>	__( 'Menu Link Border Color', 'spartan' ),
				'id'		=>	'nav_link_border_color',
				'element'	=> '.header-search-icon,#site-navigation .dropdown-menu > li',
				'style'		=> 'border-color',
				'section'	=> 'wpex_styling_menu',
			);

			$array[] = array(
				'label'		=>	__( 'Menu Link Color', 'spartan' ),
				'id'		=>	'nav_link_color',
				'element'	=> '#site-navigation .dropdown-menu > li > a, a.navigation-toggle',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_menu',
			);

			$array[] = array(
				'label'		=>	__( 'Menu Link Hover Color', 'spartan' ),
				'id'		=>	'nav_link_hover_color',
				'element'	=> '#site-navigation .dropdown-menu > li > a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_menu',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Menu Link Hover Background', 'spartan' ),
				'id'		=>	'nav_link_hover_bg',
				'element'	=> '#site-navigation .dropdown-menu > li > a:hover',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_menu',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Active Menu Link Color', 'spartan' ),
				'id'		=>	'nav_link_active_color',
				'element'	=> '#site-navigation .dropdown-menu > .current-menu-item > a,#site-navigation .dropdown-menu > .current-menu-ancestor > a,#site-navigation .dropdown-menu > .current-menu-parent > a',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_menu',
			);

			$array[] = array(
				'label'		=>	__( 'Active Menu Link Background', 'spartan' ),
				'id'		=>	'nav_link_active_bg',
				'element'	=> '#site-navigation .dropdown-menu > .current-menu-item > a,#site-navigation .dropdown-menu > .current-menu-ancestor > a,#site-navigation .dropdown-menu > .current-menu-parent > a',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_menu',
			);

			$array[] = array(
				'label'		=>	__( 'Sub-Menu Background', 'spartan' ),
				'id'		=>	'nav_drop_bg',
				'element'	=> '#site-navigation-wrap .dropdown-menu ul',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_menu',
			);

			$array[] = array(
				'label'		=>	__( 'Sub-Menu Border', 'spartan' ),
				'id'		=>	'nav_drop_border',
				'element'	=> '#site-navigation-wrap .dropdown-menu ul',
				'style'		=> 'border-color',
				'section'	=> 'wpex_styling_menu',
			);

			$array[] = array(
				'label'		=>	__( 'Sub-Menu Link Bottom Border', 'spartan' ),
				'id'		=>	'nav_drop_link_border',
				'element'	=> '#site-navigation .dropdown-menu ul li',
				'style'		=> 'border-color',
				'section'	=> 'wpex_styling_menu',
			);

			$array[] = array(
				'label'		=>	__( 'Sub-Menu Link Color', 'spartan' ),
				'id'		=>	'nav_drop_link_color',
				'element'	=> '#site-navigation .dropdown-menu ul > li > a',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_menu',
			);

			$array[] = array(
				'label'		=>	__( 'Sub-Menu Link Hover Color', 'spartan' ),
				'id'		=>	'nav_drop_link_hover_color',
				'element'	=> '#site-navigation .dropdown-menu ul > li > a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_menu',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Sub-Menu Link Hover Background', 'spartan' ),
				'id'		=>	'nav_drop_link_hover_bg',
				'element'	=> '#site-navigation .dropdown-menu ul > li > a:hover',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_menu',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Mobile Menu Background', 'spartan' ),
				'id'		=>	'mobile_nav_bg',
				'element'	=> '.wpex-mobile-main-nav .container',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_menu',
			);

			$array[] = array(
				'label'		=>	__( 'Mobile Menu Link Color', 'spartan' ),
				'id'		=>	'mobile_nav_link_color',
				'element'	=> '.wpex-mobile-main-nav-ul li a',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_menu',
			);

			$array[] = array(
				'label'		=>	__( 'Mobile Menu Link Hover Color', 'spartan' ),
				'id'		=>	'mobile_nav_link_hover_color',
				'element'	=> '.wpex-mobile-main-nav-ul li a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_menu',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Mobile Menu Borders', 'spartan' ),
				'id'		=>	'mobile_nav_borders',
				'element'	=> '.wpex-mobile-main-nav-ul li a',
				'style'		=> 'border-color',
				'section'	=> 'wpex_styling_menu',
			);

			// Links
			$array[] = array(
				'label'		=>	__( 'Headings With Links Hover', 'spartan' ),
				'id'		=>	'headings_links_hover',
				'element'	=> 'h1 a:hover, h2 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_links',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Entry Title Color', 'spartan' ),
				'id'		=>	'entry_title_color',
				'element'	=> '.loop-entry-title a',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_links',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Entry Title Hover Color', 'spartan' ),
				'id'		=>	'entry_title_hover_color',
				'element'	=> '.loop-entry-title a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_links',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Post/Page Content Link Color', 'spartan' ),
				'id'		=>	'post_link_color',
				'element'	=> '.single .entry a, p.logged-in-as a, .comment-navigation a, .page .entry a, .entry-footer a, .home-slider-caption-excerpt a, .post-meta a, .home-cat-entry-post-other a, .home-cat-entry-post-other a:hover, .featured-carousel-slide a:hover, .related-carousel-slide a:hover, .next-prev a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_links',
			);

			$array[] = array(
				'label'		=>	__( 'Post/Page Content Link Hover Color', 'spartan' ),
				'id'		=>	'post_link_hover_color',
				'element'	=> '.single .entry a:hover, p.logged-in-as a:hover, .comment-navigation a:hover, .page .entry a:hover, .entry-footer a:hover, .home-slider-caption-excerpt a:hover, .post-meta a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_links',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Sidebar Link Color', 'spartan' ),
				'id'		=>	'sidebar_link_color',
				'element'	=> '.sidebar-container a',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_links',
			);

			$array[] = array(
				'label'		=>	__( 'Sidebar Link Hover Color', 'spartan' ),
				'id'		=>	'sidebar_link_hover_color',
				'element'	=> '.sidebar-container a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_links',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Readmore Color', 'spartan' ),
				'id'		=>	'readmore_color',
				'element'	=> '.loop-entry .wpex-readmore a, .home-slider-caption-excerpt .wpex-readmore a',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_links',
			);

			$array[] = array(
				'label'		=>	__( 'Readmore Hover Color', 'spartan' ),
				'id'		=>	'readmore_hover_color',
				'element'	=> '.loop-entry .wpex-readmore a:hover, .home-slider-caption-excerpt .wpex-readmore a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_links',
				'transport'	=> 'refresh',
			);

			// Widgets
			$array[] = array(
				'label'		=>	__( 'Sidebar Title Color', 'spartan' ),
				'id'		=>	'sidebar_title_color',
				'element'	=> '.sidebar-container .widget-title',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_widgets',
			);

			$array[] = array(
				'label'		=>	__( 'Sidebar Border Color', 'spartan' ),
				'id'		=>	'sidebar_title_border_color',
				'element'	=> '.sidebar-container .widget-title',
				'style'		=> 'border-color',
				'section'	=> 'wpex_styling_widgets',
			);

			$array[] = array(
				'label'		=>	__( 'Calendar Heading Color', 'spartan' ),
				'id'		=>	'calendar_heading_color',
				'element'	=> '#wp-calendar caption',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_widgets',
			);

			$array[] = array(
				'label'		=>	__( 'Tag Cloud Color', 'spartan' ),
				'id'		=>	'tag_cloud_color',
				'element'	=> '.widget_tag_cloud a, #wpex-widget-tags-tab a',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_widgets',
			);

			$array[] = array(
				'label'		=>	__( 'Tag Cloud Background', 'spartan' ),
				'id'		=>	'tag_cloud_bg',
				'element'	=> '.widget_tag_cloud a, #wpex-widget-tags-tab a',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_widgets',
			);

			$array[] = array(
				'label'		=>	__( 'Tag Cloud Hover Color', 'spartan' ),
				'id'		=>	'tag_cloud_hover_color',
				'element'	=> '.widget_tag_cloud a:hover, #wpex-widget-tags-tab a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_widgets',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Tag Cloud Hover Background', 'spartan' ),
				'id'		=>	'tag_cloud_hover_bg',
				'element'	=> '.widget_tag_cloud a:hover, #wpex-widget-tags-tab a:hover',
				'style'		=> 'background-color',
				'section'	=> 'wpex_styling_widgets',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Tab Widget Active Tab Border Color', 'spartan' ),
				'id'		=>	'tab_widget_active_color',
				'element'	=> '.wpex-tabs-widget-tabs a.active',
				'style'		=> 'border-top-color',
				'section'	=> 'wpex_styling_widgets',
			);

			$array[] = array(
				'label'		=>	__( 'Tab Widget Text Highlight Color', 'spartan' ),
				'id'		=>	'tab_widget_text_highlight_color',
				'element'	=> '.wpex-tabs-widget-tabs a.active, #wpex-widget-popular-tab .counter',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_widgets',
			);


			$array[] = array(
				'label'		=>	__( 'Search Widget Submit Button Color', 'spartan' ),
				'id'		=>	'widget_search_submit_color',
				'element'	=> '.site-searchform button',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_widgets',
			);

			$array[] = array(
				'label'		=>	__( 'Search Widget Submit Button Background', 'spartan' ),
				'id'		=>	'widget_search_submit_bg',
				'element'	=> '.site-searchform button',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_widgets',
			);

			$array[] = array(
				'label'		=>	__( 'Slider Widget Active Bullet', 'spartan' ),
				'id'		=>	'widget_slider_active_bullet',
				'element'	=> '.slider-widget .owl-dots .owl-dot:hover, .slider-widget .owl-dots .owl-dot.active',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_widgets',
			);

			// Buttons
			$array[] = array(
				'label'		=>	__( 'Theme Button Color', 'spartan' ),
				'id'		=>	'theme_button_color',
				'element'	=> 'input[type="button"], input[type="submit"], .page-numbers a:hover, .page-numbers.current, .page-links span, .page-links a:hover span, .home-slider-caption-excerpt .wpex-readmore a, .loop-entry .wpex-readmore a',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_buttons',
			);

			$array[] = array(
				'label'		=>	__( 'Theme Button Background', 'spartan' ),
				'id'		=>	'theme_button_bg',
				'element'	=> 'input[type="button"], input[type="submit"], .page-numbers a:hover, .page-numbers.current, .page-links span, .page-links a:hover span, .home-slider-caption-excerpt .wpex-readmore a, .loop-entry .wpex-readmore a',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_buttons',
			);

			$array[] = array(
				'label'		=>	__( 'Theme Button Hover Color', 'spartan' ),
				'id'		=>	'theme_button_hover_color',
				'element'	=> 'input[type="button"]:hover, input[type="submit"]:hover, .home-slider-caption-excerpt .wpex-readmore a:hover, .loop-entry .wpex-readmore a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_buttons',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Theme Button Hover Background', 'spartan' ),
				'id'		=>	'theme_button_hover_bg',
				'element'	=> 'input[type="button"]:hover, input[type="submit"]:hover, .home-slider-caption-excerpt .wpex-readmore a:hover, .loop-entry .wpex-readmore a:hover',
				'style'		=> 'background-color',
				'section'	=> 'wpex_styling_buttons',
				'transport'	=> 'refresh',
			);

			// Footer
			$array[] = array(
				'label'		=>	__( 'Footer Widgets Background', 'spartan' ),
				'id'		=>	'footer_widgets_bg',
				'element'	=> '#footer-wrap',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_footer',
			);

			$array[] = array(
				'label'		=>	__( 'Footer Widgets Text', 'spartan' ),
				'id'		=>	'footer_widgets_color',
				'element'	=> '#footer-wrap, #footer-wrap p',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_footer',
			);

			$array[] = array(
				'label'		=>	__( 'Footer Widgets Heading', 'spartan' ),
				'id'		=>	'footer_widgets_headings',
				'element'	=> '#footer-wrap h2, #footer-wrap h3, #footer-wrap h4, #footer-wrap h5,  #footer-wrap h6, #footer-widgets .widget-title',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_footer',
			);

			$array[] = array(
				'label'		=>	__( 'Footer Widgets Links', 'spartan' ),
				'id'		=>	'footer_widgets_links_color',
				'element'	=> '#footer-wrap a, #footer-widgets .widget_nav_menu ul > li li a:before',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_footer',
			);

			$array[] = array(
				'label'		=>	__( 'Footer Widgets Links Hover', 'spartan' ),
				'id'		=>	'footer_widgets_links_hover_color',
				'element'	=> '#footer-wrap a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_footer',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Footer Widgets Borders', 'spartan' ),
				'id'		=>	'footer_widgets_borders',
				'element'	=> '#footer-widgets .widget_nav_menu ul > li, #footer-widgets .widget_nav_menu ul > li a, .footer-widget > ul > li:first-child, .footer-widget > ul > li, .footer-nav li:before, .wpex-tabs-widget-tab ul li',
				'style'		=> 'border-color',
				'section'	=> 'wpex_styling_footer',
			);

			$array[] = array(
				'label'		=>	__( 'Footer Bottom Background', 'spartan' ),
				'id'		=>	'footer_bottom_bg',
				'element'	=> '#footer-bottom',
				'style'		=> 'background',
				'section'	=> 'wpex_styling_footer',
			);

			$array[] = array(
				'label'		=>	__( 'Footer Bottom Text', 'spartan' ),
				'id'		=>	'footer_bottom_color',
				'element'	=> '#footer-bottom, #footer-bottom p',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_footer',
			);

			$array[] = array(
				'label'		=>	__( 'Footer Bottom Links', 'spartan' ),
				'id'		=>	'footer_bottom_links_color',
				'element'	=> '#footer-bottom a',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_footer',
			);

			$array[] = array(
				'label'		=>	__( 'Footer Bottom Links Hover', 'spartan' ),
				'id'		=>	'footer_bottom_links_hover_color',
				'element'	=> '#footer-bottom a:hover',
				'style'		=> 'color',
				'section'	=> 'wpex_styling_footer',
				'transport'	=> 'refresh',
			);

			// Other
			$array[] = array(
				'label'		=>	__( 'Main Body Background', 'spartan' ),
				'id'		=>	'body_background',
				'element'	=> 'body',
				'style'		=> 'background-color',
			);
			$array[] = array(
				'label'		=>	__( 'Author Comment Label Color', 'spartan' ),
				'id'		=>	'author_comment_label_color',
				'element'	=> '.author-badge',
				'style'		=> 'color',
			);

			$array[] = array(
				'label'		=>	__( 'Author Comment Label Background', 'spartan' ),
				'id'		=>	'author_comment_label_bg',
				'element'	=> '.author-badge',
				'style'		=> 'background',
			);
			$array[] = array(
				'label'		=>	__( 'Back To Top Arrow Color', 'spartan' ),
				'id'		=>	'scrolltop_color',
				'element'	=> '.site-scroll-top',
				'style'		=> 'color',
			);

			$array[] = array(
				'label'		=>	__( 'Back To Top Arrow Background', 'spartan' ),
				'id'		=>	'scrolltop_bg',
				'element'	=> '.site-scroll-top',
				'style'		=> 'background-color',
			);

			$array[] = array(
				'label'		=>	__( 'Back To Top Arrow Hover Color', 'spartan' ),
				'id'		=>	'scrolltop_hover_color',
				'element'	=> '.site-scroll-top:hover',
				'style'		=> 'color',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Back To Top Arrow Hover Background', 'spartan' ),
				'id'		=>	'scrolltop_hover_bg',
				'element'	=> '.site-scroll-top:hover',
				'style'		=> 'background-color',
				'transport'	=> 'refresh',
			);

			$array[] = array(
				'label'		=>	__( 'Gallery Lightbox Hover Background', 'spartan' ),
				'id'		=>	'gallery_bg_hover',
				'element'	=> '.gallery-item-overlay',
				'style'		=> 'background',
				'transport'	=> 'refresh',
			);

			// Apply filters for child theming magic
			$array = apply_filters( 'wpex_color_options_array', $array );

			// Return array
			return $array;
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Reset Cache after customizer save
		/*-----------------------------------------------------------------------------------*/
		public function reset_cache() {
			remove_theme_mod( 'wpex_customizer_css_cache' );
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Register theme options
		/*-----------------------------------------------------------------------------------*/
		public function register ( $wp_customize ) {

			// Add Styling Panel
			$wp_customize->add_panel( 'wpex_styling', array(
				'priority'		=> 143,
				'capability'	=> 'edit_theme_options',
				'title'			=> __( 'Styling', 'spartan' ),
			) );

			// Styling Top Bar
			$wp_customize->add_section( 'wpex_styling_topbar' , array(
				'title'		=> __( 'Top Bar', 'spartan' ),
				'priority'	=> 160,
				'panel'		=> 'wpex_styling',
			) );

			// Styling Header
			$wp_customize->add_section( 'wpex_styling_header' , array(
				'title'		=> __( 'Header', 'spartan' ),
				'priority'	=> 161,
				'panel'		=> 'wpex_styling',
			) );

			// Styling Menu
			$wp_customize->add_section( 'wpex_styling_menu' , array(
				'title'		=> __( 'Menu', 'spartan' ),
				'priority'	=> 162,
				'panel'		=> 'wpex_styling',
			) );

			// Styling Links
			$wp_customize->add_section( 'wpex_styling_links' , array(
				'title'		=> __( 'Links', 'spartan' ),
				'priority'	=> 163,
				'panel'		=> 'wpex_styling',
			) );

			// Styling Buttons
			$wp_customize->add_section( 'wpex_styling_buttons' , array(
				'title'		=> __( 'Buttons', 'spartan' ),
				'priority'	=> 164,
				'panel'		=> 'wpex_styling',
			) );

			// Styling Widgets
			$wp_customize->add_section( 'wpex_styling_widgets' , array(
				'title'		=> __( 'Widgets', 'spartan' ),
				'priority'	=> 165,
				'panel'		=> 'wpex_styling',
			) );

			// Styling Footer
			$wp_customize->add_section( 'wpex_styling_footer' , array(
				'title'		=> __( 'Footer', 'spartan' ),
				'priority'	=> 166,
				'panel'		=> 'wpex_styling',
			) );

			// Styling Other
			$wp_customize->add_section( 'wpex_styling_other' , array(
				'title'		=> __( 'Other', 'spartan' ),
				'priority'	=> 167,
				'panel'		=> 'wpex_styling',
			) );

			// Get Color Options
			$color_options = self::wpex_color_options();

			// Loop through color options and add a theme customizer setting for it
			$count='3';
			foreach( $color_options as $option ) {
				$count++;
				$default	= isset( $option['default'] ) ? $option['default'] : '';
				$type		= isset( $option['type'] ) ? $option['type'] : '';
				$section	= isset( $option['section'] ) ? $option['section'] : 'wpex_styling_other';
				if ( 'text' == $type ) {
					$wp_customize->add_setting( 'wpex_'. $option['id'] .'', array(
						'type'				=> 'theme_mod',
						'default'			=> $default,
						'transport'			=> 'refresh',
						'sanitize_callback' => false,
					) );
					$wp_customize->add_control( 'wpex_'. $option['id'] .'', array(
						'label'		=> $option['label'],
						'section'	=> $section,
						'settings'	=> 'wpex_'. $option['id'] .'',
						'priority'	=> $count,
						'type'		=> 'text',
					) );
				} else {
					$wp_customize->add_setting( 'wpex_'. $option['id'] .'', array(
						'type'				=> 'theme_mod',
						'default'			=> $default,
						'transport'			=> 'refresh',
						'sanitize_callback'	=> 'sanitize_hex_color',
						'sanitize_callback' => false,
					) );
					$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wpex_'. $option['id'] .'', array(
						'label'		=> $option['label'],
						'section'	=> $section,
						'settings'	=> 'wpex_'. $option['id'] .'',
						'priority'	=> $count,
					) ) );
				}
			}
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Output CSS
		/*-----------------------------------------------------------------------------------*/
		public function header_output() {
			// Get cached CSS output
			$data	= get_theme_mod( 'wpex_customizer_css_cache', false );
			$css	= '';
			// If theme mod cache empty or is live customizer loop through elements and set output
			if ( empty( $data ) || is_customize_preview() ) {

				$color_options	= self::wpex_color_options();

				foreach( $color_options as $option ) {

					// Get and sanitize data
					$style_output	= '';
					$style			= isset( $option['style'] ) ? $option['style'] : '';
					$media_query	= isset( $option['media_query'] ) ? $option['media_query'] : '';
					$theme_mod		= get_theme_mod( 'wpex_'. $option['id'] );

					// Continute if required vars are empty
					if ( ! $theme_mod || ! $style ) {
						continue;
					}

					// Generate CSS
					if ( is_array( $style ) ) {
						foreach ( $style as $s ) {
							$style_output .= $option['element'] .'{ '. $s .':'. $theme_mod.'; }';
						}
					} else {
						$style_output = $option['element'] .'{ '. $style .':'. $theme_mod.'; }';
					}

					// Add CSS
					if ( $media_query ) {
						$css .= $media_query .' {';
							$css .= $style_output;
						$css .= '}';
					} else {
						$css .= $style_output;
					}

				}
			}
			// Set cache or get cache if not in customizer
			if ( ! is_customize_preview() ) {
				// Get Cache
				if ( $data ) {
					$css = get_theme_mod( 'wpex_customizer_css_cache' );
				}
				// Set Cache
				else {
					if ( $css ) {
						set_theme_mod( 'wpex_customizer_css_cache', $css );
					} else {
						set_theme_mod( 'wpex_customizer_css_cache', 'empty' );
					}
				}
			}
			// Output CSS in head if not empty
			if ( $css && 'empty' != $css ) {
				$css = preg_replace( '/\s+/', ' ', $css );
				$css = '<!-- Theme Customizer Styling Options --><style type="text/css">' . $css . '</style>';
				echo $css;
			}
		} // End header_output function
	}
}

$wpex_theme_customizer_styling = new WPEX_Theme_Customizer_Styling(); 