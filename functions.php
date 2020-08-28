<?php
/**
 * Theme functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package   Spartan
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @license   http://themeforest.net/licenses/terms/regular
 * @since     Spartan 1.0.0
 * @version   1.4
 */

/**
 * Main Theme Class
 *
 * @since Spartan 1.1.2
 */
class Spartan_Theme {

	/**
	 * Start things up
	 *
	 * @since 1.1.2
	 */
	public function __construct() {

		// Define theme constants
		add_action( 'after_setup_theme', array( $this, 'constants' ), 0 );

		// Main theme setup
		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );

		// Include helper functions
		add_action( 'init', array( $this, 'include_files' ), 0 );

		// Load front-end scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );

		// Register widget areas
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );

		// Tweak posts-per-page
		add_filter( 'pre_get_posts', array( $this, 'pre_get_posts' ) );

		// Add custom user social options
		add_filter( 'user_contactmethods', array( $this, 'user_fields' ) );

		// SSL fix for attachments
		add_filter( 'wp_get_attachment_url', array( $this, 'honor_ssl_for_attachments' ) );

		// Tweak post classes
		add_filter( 'post_class', array( $this, 'post_class' ) );

		// Add custom body classes
		add_filter( 'body_class', array( $this, 'body_class' ) );

		// Add tinymce editor buttons
		add_filter( 'mce_buttons_2', array( $this, 'mce_font_size_select' ) );

		// Add tinymce editor font sizes
		add_filter( 'tiny_mce_before_init', array( $this, 'fontsize_formats' ) );

		// Tweak WP excerpt more text
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );

		// Tweak the wp_list_categories output to remove rel tag
		add_filter( 'wp_list_categories', array( $this, 'remove_category_list_rel' ) );

		// Tweak the_category output to remove the rel tag
		add_filter( 'the_category', array( $this, 'remove_category_list_rel' ) );

		/**
		 * Migrate old custom CSS to new CSS in WP admin panel
		 *
		 * @since 1.3.0
		 */
		if ( function_exists( 'wp_update_custom_css_post' ) ) {

			if ( $deprecated_css = get_option( 'wpex_custom_css' ) ) {

				// Get core CSS and add to it
				$core_css = wp_get_custom_css();
				$return   = wp_update_custom_css_post( $core_css . $deprecated_css );

				if ( ! is_wp_error( $return ) ) {

					// Save backup then remove deprecated
					add_option( 'wpex_custom_css_backup', $deprecated_css );

					// Remove option
					delete_option( 'wpex_custom_css' );
					delete_option( 'wpex_custom_css_theme' );

				}

			}

		} else {
			add_action( 'wp_head', array( $this, 'deprecated_css' ) );
		}

	}

	/**
	 * Returns current theme version
	 *
	 * @since 1.1.5
	 * @access public
	 */
	public static function theme_version() {

		// Get theme data
		$theme = wp_get_theme();

		// Return theme version
		return $theme->get( 'Version' );

	}

	/**
	 * Define theme constants
	 *
	 * @since 1.1.5
	 * @access public
	 */
	public static function constants() {
		define( 'WPEX_THEME_VERSION', self::theme_version() );
		define( 'WPEX_CSS_DIR_URI', get_template_directory_uri() . '/css/' );
		define( 'WPEX_JS_DIR_URI', get_template_directory_uri() . '/js/' );
	}

	/**
	 * Functions called during each page load, after the theme is initialized
	 * Perform basic setup, registration, and init actions for the theme
	 *
	 * @link  http://codex.wordpress.org/Plugin_API/Action_Reference/after_setup_theme
	 * @since 1.1.2
	 */
	public static function after_setup_theme() {

		// WP content width variable
		if ( ! isset( $content_width ) ) {
			$content_width = 650;
		}

		// Register navigation menus
		register_nav_menus ( array(
			'top_menu'    => __( 'Top', 'spartan' ),
			'main_menu'   => __( 'Main', 'spartan' ),
			'footer_menu' => __( 'Footer', 'spartan' ),
		) );

		// Localization support
		load_theme_textdomain( 'spartan', get_template_directory() . '/languages' );

		// Enable some useful post formats for the blog
		add_theme_support( 'post-formats', array( 'video', 'audio', 'gallery' ) );

		// Add theme support
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Remove theme check nags
		if ( 'nag' == 'annoying' ) {
			add_theme_support( 'custom-header', $args );
			the_post_thumbnail();
		}

	}

	/**
	 * Include theme functions and classes
	 *
	 * @since 1.1.2
	 */
	public static function include_files() {
		self::theme_functions();
		self::theme_classes();
		self::custom_widgets();
	}

	/**
	 * Theme functions
	 *
	 * @since 1.1.2
	 */
	public static function theme_functions() {
		$dir = trailingslashit( get_template_directory() . '/inc' );
		require_once( $dir . 'core-functions.php' );
		require_once( $dir . 'customizer/customizer.php' );
		require_once( $dir . 'dashboard-thumbs.php' );
		require_once( $dir . 'meta-config.php' );
		require_once( $dir . 'category-colors.php' );
		require_once( $dir . 'categories.php' );
		require_once( $dir . 'navs.php' );
		require_once( $dir . 'featured-image.php' );
		require_once( $dir . 'comments-callback.php' );
		require_once( $dir . 'wp-gallery.php' );
		require_once( $dir . 'image-resizer.php' );
		require_once( $dir . 'pagination.php' );
		require_once( $dir . 'ads.php' );
	}

	/**
	 * Theme Classes
	 *
	 * @since 1.1.2
	 */
	public static function theme_classes() {
		$dir = get_template_directory() .'/inc/';
		require_once( $dir .'classes/gallery-metabox/gallery-metabox.php' );
		require_once( $dir .'classes/custom-metaboxes/init.php' );
	}

	/**
	 * Include Custom Widgets
	 *
	 * @since 1.1.2
	 */
	public static function custom_widgets() {
		$dir = get_template_directory() .'/inc/';
		require_once( $dir . 'widgets/widget-flickr.php' );
		require_once( $dir . 'widgets/widget-social.php' );
		require_once( $dir . 'widgets/widget-video.php' );
		require_once( $dir . 'widgets/widget-posts-thumbnails.php' );
		require_once( $dir . 'widgets/widget-slider.php' );
		require_once( $dir . 'widgets/widget-tabs.php' );
		require_once( $dir . 'widgets/widget-comments-avatar.php' );
		require_once( $dir . 'widgets/widget-posts-icons.php' );
		require_once( $dir . 'widgets/widget-recent-news.php' );

	}

	/**
	 * Hooks functions to wp_enqueue_scripts to load scrips on the front-end
	 *
	 * @link    http://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
	 * @since   1.1.2
	 */
	public static function wp_enqueue_scripts() {
		self::theme_css();
		self::theme_js();
	}

	/**
	 * Returns all CSS needed for the front-end
	 *
	 * @since 1.1.2
	 */
	public static function theme_css() {

		// Main CSS
		wp_enqueue_style( 'wpex-style', get_stylesheet_uri(), false, WPEX_THEME_VERSION );

		// Remove symple shortcodes font awesome
		wp_dequeue_style( 'symple_shortcodes_font_awesome' );

		// Font Awesome
		wp_enqueue_style( 'font-awesome', WPEX_CSS_DIR_URI .'font-awesome.min.css', false, '4.2.0' );

		// Responsive CSS
		if ( get_theme_mod( 'wpex_responsive', true ) ) {
			wp_enqueue_style( 'wpex-responsive', get_template_directory_uri() .'/css/responsive.css', array( 'wpex-style' ), WPEX_THEME_VERSION );
		}

		// Remove Contact Form 7 Styles
		if ( function_exists( 'wpcf7_enqueue_styles') ) {
			wp_dequeue_style( 'contact-form-7' );
		}

		// IE8 CSS fixes
		$ie_8_url = apply_filters( 'wpex_ie_8_url', WPEX_CSS_DIR_URI .'ie8.css' );
		if ( $ie_8_url ) {
			wp_enqueue_style( 'st-ie8', $ie_8_url );
			wp_style_add_data( 'st-ie8', 'conditional', 'IE 8' );
		}

	}

	/**
	 * Returns all js needed for the front-end
	 *
	 * @since 1.1.2
	 */
	public static function theme_js() {

		// HTML5 shiv
		wp_enqueue_script( 'html5shiv', WPEX_JS_DIR_URI .'html5.js', array(), false, false );
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

		// Threaded commments
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Retina Support
		if ( get_theme_mod( 'wpex_retina' ) ) {
			wp_enqueue_script( 'wpex-retina', WPEX_JS_DIR_URI .'retina.js', array( 'jquery' ), '', true );
		}

		// Main js plugins
		wp_enqueue_script( 'wpex-plugins', WPEX_JS_DIR_URI .'plugins.js', array( 'jquery' ), '1.0', true );

		// Init
		wp_enqueue_script( 'wpex-global', WPEX_JS_DIR_URI .'global.js', array( 'jquery' ), '1.0', true );

		// Localize
		$home_slideshow = get_theme_mod( 'wpex_homepage_slider_slideshow' );
		$home_slideshow = $home_slideshow ? 'true' : 'false';
		$home_slideshow_speed  = get_theme_mod( 'wpex_homepage_slider_slideshow_speed', '7000' );
		$args = array(
			'mobileMenuOpen'        => get_theme_mod( 'wpex_mobile_menu_open_text', __( 'Browser Categories', 'spartan' ) ),
			'mobileMenuClosed'      => get_theme_mod( 'wpex_mobile_menu_close_text', __( 'Close navigation', 'spartan' ) ),
			'homeSlideshow'         => $home_slideshow,
			'homeSlideshowSpeed'    => $home_slideshow_speed,
			'UsernamePlaceholder'   => __( 'Username', 'spartan' ),
			'PasswordPlaceholder'   => __( 'Password', 'spartan' ),
			'enableFitvids'         => 'true',
		);
		$args = apply_filters( 'wpex_localize_array', $args );
		wp_localize_script( 'wpex-global', 'wpexLocalize', $args );

		// Retina logo
		$retina_logo = self::retina_logo();
		if ( $retina_logo ) {
			wp_add_inline_script( 'wpex-global', $retina_logo, 'before' );
		}

	}

	/**
	 * Adds the retina logo to the head
	 *
	 * @since   1.1.2
	 */
	public static function retina_logo() {
		$logo_url    = get_theme_mod( 'wpex_retina_logo' );
		$logo_height = get_theme_mod( 'wpex_retina_logo_height' );
		if ( $logo_url && $logo_height) {
			return 'jQuery(function($){if (window.devicePixelRatio >= 2) {$("#logo img").attr("src", "'. esc_url( $logo_url ) .'");$("#logo img").css("height", "'. intval( $logo_height ) .'");}});';
		}
	}

	/**
	 * Registers the theme sidebars (widget areas)
	 *
	 * @link    http://codex.wordpress.org/Function_Reference/register_sidebar
	 * @since   1.1.2
	 */
	public static function register_sidebars() {

		// Vars
		$wpex_sidebar_heading_tags = get_theme_mod( 'wpex_sidebar_heading_tags', 'span' );
		$wpex_sidebar_heading_tags = $wpex_sidebar_heading_tags ? $wpex_sidebar_heading_tags : 'span';

		$wpex_footer_heading_tags = get_theme_mod( 'wpex_footer_heading_tags', 'span' );
		$wpex_footer_heading_tags = $wpex_footer_heading_tags ? $wpex_footer_heading_tags : 'span';

		// Sidebar
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'spartan' ),
			'id'            => 'sidebar',
			'description'   => __( 'Widgets in this area are used in the sidebar region.', 'spartan' ),
			'before_widget' => '<div class="sidebar-widget %2$s clr">',
			'after_widget'  => '</div>',
			'before_title'  => '<'. $wpex_sidebar_heading_tags.' class="widget-title">',
			'after_title'   => '</'. $wpex_sidebar_heading_tags.'>',
		) );

		// Footer 1
		register_sidebar( array(
			'name'          => __( 'Footer 1', 'spartan' ),
			'id'            => 'footer-one',
			'description'   => __( 'Widgets in this area are used in the first footer region.', 'spartan' ),
			'before_widget' => '<div class="footer-widget %2$s clr">',
			'after_widget'  => '</div>',
			'before_title'  => '<'. $wpex_footer_heading_tags.' class="widget-title">',
			'after_title'   => '</'. $wpex_footer_heading_tags.'>',
		) );

		// Footer 2
		if ( get_theme_mod( 'wpex_footer_columns', '4' ) > '1' ) {
			register_sidebar( array(
				'name'          => __( 'Footer 2', 'spartan' ),
				'id'            => 'footer-two',
				'description'   => __( 'Widgets in this area are used in the second footer region.', 'spartan' ),
				'before_widget' => '<div class="footer-widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<'. $wpex_footer_heading_tags.' class="widget-title">',
				'after_title'   => '</'. $wpex_footer_heading_tags.'>',
			) );
		}

		// Footer 3
		if ( get_theme_mod( 'wpex_footer_columns', '4' ) > '2' ) {
			register_sidebar( array(
				'name'          => __( 'Footer 3', 'spartan' ),
				'id'            => 'footer-three',
				'description'   => __( 'Widgets in this area are used in the third footer region.', 'spartan' ),
				'before_widget' => '<div class="footer-widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<'. $wpex_footer_heading_tags.' class="widget-title">',
				'after_title'   => '</'. $wpex_footer_heading_tags.'>',
			) );
		}

		// Footer 4
		if ( get_theme_mod( 'wpex_footer_columns', '4' ) > '3' ) {
			register_sidebar( array(
				'name'          => __( 'Footer 4', 'spartan' ),
				'id'            => 'footer-four',
				'description'   => __( 'Widgets in this area are used in the fourth footer region.', 'spartan' ),
				'before_widget' => '<div class="footer-widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<'. $wpex_footer_heading_tags.' class="widget-title">',
				'after_title'   => '</'. $wpex_footer_heading_tags.'>',
			) );
		}

	}

	/**
	 * This function runs before the main query
	 *
	 * @link    http://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
	 * @since   1.1.2
	 */
	public static function pre_get_posts( $query ) {

		// Not needed in admin
		if ( is_admin() ) {
			return $query;
		}

		// Exclude posts
		if ( $query->is_home() AND $query->is_main_query() ) {
			if ( function_exists( 'wpex_exclude_home_ids' ) ) {
				$array = wpex_exclude_home_ids();
				if ( is_array( $array ) && !empty( $array ) ) {
					$query->set('post__not_in', $array );
				}
			}
		}

		// Set search results to post post type only
		if ( $query->is_search ) {
			$query->set( 'post_type', 'post' );
		}

	}

	/**
	 * Add new user fields
	 *
	 * @link    http://codex.wordpress.org/Plugin_API/Filter_Reference/user_contactmethods
	 * @since   1.1.2
	 */
	public static function user_fields( $contactmethods ) {

		// Add Website
		if ( ! isset( $contactmethods['wpex_website'] ) ) {
			$contactmethods['wpex_website'] = __( 'Website Name', 'spartan' );
		}
		// Add Twitter
		if ( ! isset( $contactmethods['wpex_twitter'] ) ) {
			$contactmethods['wpex_twitter'] = 'Twitter';
		}
		// Add Facebook
		if ( ! isset( $contactmethods['wpex_facebook'] ) ) {
			$contactmethods['wpex_facebook'] = 'Facebook';
		}
		// Add GoglePlus
		if ( ! isset( $contactmethods['wpex_googleplus'] ) ) {
			$contactmethods['wpex_googleplus'] = 'Google+';
		}
		// Add LinkedIn
		if ( ! isset( $contactmethods['wpex_linkedin'] ) ) {
			$contactmethods['wpex_linkedin'] = 'LinkedIn';
		}
		// Add Pinterest
		if ( ! isset( $contactmethods['wpex_pinterest'] ) ) {
			$contactmethods['wpex_pinterest'] = 'Pinterest';
		}
		// Add Pinterest
		if ( ! isset( $contactmethods['wpex_instagram'] ) ) {
			$contactmethods['wpex_instagram'] = 'Instagram';
		}

		// Return contactmethods
		return $contactmethods;

	}

	/**
	 * The wp_get_attachment_url() function doesn't distinguish whether a page request arrives via HTTP or HTTPS.
	 * Using wp_get_attachment_url filter, we can fix this to avoid the dreaded mixed content browser warning
	 *
	 * @link    http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_get_attachment_url
	 * @since   1.1.2
	 */
	public static function honor_ssl_for_attachments( $url ) {
		$http       = site_url( FALSE, 'http' );
		$https      = site_url( FALSE, 'https' );
		$isSecure   = false;
		if ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ) {
			$isSecure = true;
		}
		if ( $isSecure ) {
			return str_replace( $http, $https, $url );
		} else {
			return $url;
		}
	}

	/**
	 * Adds new classes to the post_class function
	 *
	 * @link    http://codex.wordpress.org/Function_Reference/post_class
	 * @since   1.1.2
	 */
	public static function post_class( $classes ) {

		// Post Data
		global $post, $wpex_count;
		if ( $post ) {
			$post_id    = $post->ID;
			$post_type  = get_post_type( $post_id );
		}

		// Entry classes
		if ( ! is_singular() ) {
			$classes[] = 'loop-entry';
			if ( 'post' != $post_type ) {
				$classes[] = $post_type .'-entry';
			}
		}

		// Add Categories
		if ( $post_terms = get_the_terms( $post, 'category' ) ) {
			foreach ( $post_terms as $post_term ) {
				$classes[] = 'cat-'. $post_term->term_id;
			}
		}

		// Counter
		if ( $wpex_count ) {
			$classes[] = 'col-'. $wpex_count;
		}

		// No thumbnail
		if ( ! has_post_thumbnail() && 'video' != get_post_format() ) {
			$classes[] = 'no-thumbnail';
		}

		// Cookie based column class
		if ( isset( $_COOKIE["wpex-entry-columns"] ) ) {
			$cookie = $_COOKIE["wpex-entry-columns"];
		} else {
			$cookie = '';
		}
		if ( 'two-columns' == get_theme_mod( 'wpex_entry_style' ) && 'disabled' != $cookie ) {
			$classes[] = 'col';
		} elseif ( 'enabled' == $cookie ) {
			$classes[] = 'col';
		}

		// Return classes
		return $classes;

	}

	/**
	 * Adds new classes to the body_class function
	 *
	 * @link    http://codex.wordpress.org/Function_Reference/post_class
	 * @since   1.1.2
	 */
	public static function body_class( $classes ) {

		global $post;
		$is_mobile = wp_is_mobile();

		// Get post layout
		if ( is_singular() ) {
			$post_layout = get_post_meta( get_the_ID(), 'wpex_post_layout', true );
			if ( 'fullwidth' == $post_layout ) {
				$post_layout = 'fullwidth-post';
			}
		}

		// WPExplorer class
		$classes[] = 'wpex-theme';

		// Mobile
		if ( $is_mobile ) {
			$classes[] = 'is-mobile';
		}

		// Layout Classes
		if ( isset( $post_layout ) ) {
			$classes[] = $post_layout;
		} else {
			$classes[] = get_theme_mod( 'wpex_site_layout', 'right-sidebar' );
		}

		// Fixed header
		if ( get_theme_mod( 'wpex_fixed_nav', true ) && ! $is_mobile ) {
			$classes[] = 'fixed-nav';
		}

		// RTL
		if ( is_rtl() && ! in_array( 'rtl', $classes ) ) {
			$classes[] = 'rtl';
		}

		return $classes;

	}

	/**
	 * Add Font size select to tinymce
	 *
	 * @link    http://codex.wordpress.org/Plugin_API/Filter_Reference/mce_buttons,_mce_buttons_2,_mce_buttons_3,_mce_buttons_4
	 * @since   1.1.2
	 */
	public static function mce_font_size_select( $buttons ) {
		array_unshift( $buttons, 'fontsizeselect' );
		return $buttons;
	}

	/**
	 * Customize default font size selections for the tinymce
	 *
	 * @link    http://codex.wordpress.org/Plugin_API/Filter_Reference/mce_buttons,_mce_buttons_2,_mce_buttons_3,_mce_buttons_4
	 * @since   1.1.2
	 */
	public static function fontsize_formats( $initArray ) {
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
		return $initArray;
	}

	/**
	 * Alters the default excerpt more string
	 *
	 * @link    http://codex.wordpress.org/Plugin_API/Filter_Reference/excerpt_more
	 * @since   1.1.2
	 */
	public static function excerpt_more( $more ) {
	   return '&hellip;';
	}

	/**
	 * Alters the default excerpt more string
	 * This is done so the theme validates via W3C
	 *
	 * @since 1.1.2
	 */
	public static function remove_category_list_rel( $output ) {
		return str_replace( ' rel="category tag"', '', $output );
	}

	/**
	 * Add deprecated CSS to wp_head
	 *
	 * @since 1.3.0
	 */
	public static function deprecated_css() {
		if ( $deprecated_css = get_option( 'wpex_custom_css' ) ) {
			echo '<style>' . esc_attr( $deprecated_css ) . '</style>';
		}
	}

}
new Spartan_Theme;