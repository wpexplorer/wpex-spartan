<?php
/**
 * This class adds styling (color) options to the WordPress
 * Theme Customizer and outputs the needed CSS to the header
 * 
 * @package		WordPress
 * @subpackage	Spartan WPExplorer Theme
 * @link		http://codex.wordpress.org/Theme_Customization_API
 * @since		Spartan 1.0
 */

if ( ! class_exists( 'WPEX_Theme_Customizer_Typography' ) ) {
	class WPEX_Theme_Customizer_Typography {

		/*-----------------------------------------------------------------------------------*/
		/*	- Constructor
		/*-----------------------------------------------------------------------------------*/
		public function __construct() {
			
			// Setup the Theme Customizer settings and controls
			add_action( 'customize_register', array( $this , 'register' ) );

			// Reset cache on customizer save
			add_action( 'customize_save_after', array( $this, 'reset_cache' ) );

			// Load Google Fonts
			add_action( 'wp_head' , array( $this, 'load_fonts' ) );

			// Output custom CSS to live site
			add_action( 'wp_head' , array( $this, 'output_css' ) );

		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Array of elements for typography options
		/*-----------------------------------------------------------------------------------*/
		public function elements() {
			$array = array(
				'body'					=> array(
					'label'		=>	__( 'Body', 'spartan' ),
					'target'	=>	'body',
				),
				'logo'					=> array(
					'label'		=> __( 'Logo', 'spartan' ),
					'target'	=> '.site-text-logo a',
				),
				'blog_description'		=> array(
					'label'		=>	__( 'Logo Subheading', 'spartan' ),
					'target'	=>	'#blog-description',
				),
				'top_menu'				=> array(
					'label'		=> __( 'Top Menu', 'spartan' ),
					'target'	=> '#topbar-nav .sf-menu > li > a',
				),
				'top_menu_dropdown'	=> array(
					'label'		=> __( 'Top Menu: Dropdowns', 'spartan' ),
					'target'	=> '#topbar-nav .sf-menu > li > ul > li a',
				),
				'menu'					=> array(
					'label'		=> __( 'Main Menu', 'spartan' ),
					'target'	=> '#site-navigation .sf-menu > li > a',
				),
				'menu_dropdown'			=> array(
					'label'		=> __( 'Main Menu: Dropdowns', 'spartan' ),
					'target'	=> '#site-navigation .sf-menu > li > ul li a',
				),
				'post_tile'			=> array(
					'label'		=> __( 'Post: Entry Title', 'spartan' ),
					'target'	=> '.loop-entry-title',
				),
				'page_header'			=> array(
					'label'		=> __( 'Post: Single Title', 'spartan' ),
					'target'	=> '.post-header-title',
				),
				'page_title'	=> array(
					'label'		=> __( 'Page Title', 'spartan' ),
					'target'	=> '.page-header-title',
				),
				'sidebar_widget_title'	=> array(
					'label'		=> __( 'Sidebar Widget Heading', 'spartan' ),
					'target'	=> '.sidebar-widget .widget-title',
				),
				'footer_widget_title'	=> array(
					'label'		=> __( 'Footer Widget Heading', 'spartan' ),
					'target'	=> '.footer-widget .widget-title',
				),
				'entry_h2'		=> array(
					'label'		=> __( 'Post H2', 'spartan' ),
					'target'	=> '.entry h2'
				),
				'entry_h3'		=> array(
					'label'		=> __( 'Post H3', 'spartan' ),
					'target'	=> '.entry h3'
				),
			);
			return apply_filters( 'elements_array', $array );
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Register Typography Panel and Sections
		/*-----------------------------------------------------------------------------------*/
		public function register ( $wp_customize ) {

			// Add General Panel
			$wp_customize->add_panel( 'wpex_typography', array(
				'priority'		=> 144,
				'capability'	=> 'edit_theme_options',
				'title'			=> __( 'Typography', 'spartan' ),
			) );

			// Get elements
			$elements = self::elements();

			// Lopp through elements
			$count = '0';
			foreach( $elements as $element => $array ) {
				$count++;

				// Set vars
				$label = isset ( $array['label'] ) ? $array['label'] : '';

				if ( $label ) {

					// Define Body Section
					$wp_customize->add_section( 'wpex_typography_'. $element , array(
						'title'		=> $label,
						'priority'	=> $count,
						'panel'		=> 'wpex_typography',
					) );

					// Font Family
					$wp_customize->add_setting( 'wpex_'. $element .'_typography[font-family]', array(
						'type'				=> 'theme_mod',
						'transport'			=> 'refresh',
						'sanitize_callback' => false,
					) );
					$wp_customize->add_control(
						new WPEX_Fonts_Dropdown_Custom_Control(
							$wp_customize,
							'wpex_'. $element .'_typography[font-family]',
							array(
								'label'			=> __( 'Font Family', 'spartan' ),
								'section'		=> 'wpex_typography_'. $element,
								'settings'		=> 'wpex_'. $element .'_typography[font-family]',
								'priority'		=> 1,
								'description'	=> __( 'To prevent bugs with the customizer make sure to change your family first before tweaking the design.', 'spartan' ),
							)
						)
					);

					// Font Weight
					$wp_customize->add_setting( 'wpex_'. $element .'_typography[font-weight]', array(
						'type'				=> 'theme_mod',
						'transport'			=> 'refresh',
						'description'		=> __( 'Note: Not all Fonts support every font weight style.', 'spartan' ),
						'sanitize_callback' => false,
					) );
					$wp_customize->add_control( 'wpex_'. $element .'_typography[font-weight]', array(
						'label'			=> __( 'Font Weight', 'spartan' ),
						'section'		=> 'wpex_typography_'. $element,
						'settings'		=> 'wpex_'. $element .'_typography[font-weight]',
						'priority'		=> 2,
						'type'			=> 'select',
						'choices'	=> array (
							''		=> __( 'Default', 'spartan' ),
							'300'	=> __( 'Book: 300', 'spartan' ),
							'400'	=> __( 'Normal: 400', 'spartan' ),
							'600'	=> __( 'Semibold: 600', 'spartan' ),
							'700'	=> __( 'Bold: 700', 'spartan' ),
							'800'	=> __( 'Extra Bold: 800', 'spartan' ),
						),
						'description'	=> __( 'Important: Not all fonts support every font-weight.', 'spartan' ),
					) );

					// Font Style
					$wp_customize->add_setting( 'wpex_'. $element .'_typography[font-style]', array(
						'type'				=> 'theme_mod',
						'transport'			=> 'refresh',
						'sanitize_callback' => false,
					) );
					$wp_customize->add_control( 'wpex_'. $element .'_typography[font-style]', array(
						'label'		=> __( 'Font Style', 'spartan' ),
						'section'	=> 'wpex_typography_'. $element,
						'settings'	=> 'wpex_'. $element .'_typography[font-style]',
						'priority'	=> 3,
						'type'		=> 'select',
						'choices'	=> array (
							''		=> __( 'Default', 'spartan' ),
							'normal'	=> __( 'Normal', 'spartan' ),
							'italic'	=> __( 'Italic', 'spartan' ),
						),
					) );

					// Text-Transform
					$wp_customize->add_setting( 'wpex_'. $element .'_typography[text-transform]', array(
						'type'		=> 'theme_mod',
						'transport'	=> 'refresh',
						'sanitize_callback' => false,
					) );
					$wp_customize->add_control( 'wpex_'. $element .'_typography[text-transform]', array(
						'label'		=> __( 'Text Transform', 'spartan' ),
						'section'	=> 'wpex_typography_'. $element,
						'settings'	=> 'wpex_'. $element .'_typography[text-transform]',
						'priority'	=> 4,
						'type'		=> 'select',
						'choices'	=> array (
							''		=> __( 'Default', 'spartan' ),
							'capitalize'	=> __( 'Capitalize', 'spartan' ),
							'lowercase'		=> __( 'Lowercase', 'spartan' ),
							'uppercase'		=> __( 'Uppercase', 'spartan' ),
						),
					) );

					// Font Size
					$wp_customize->add_setting( 'wpex_'. $element .'_typography[font-size]', array(
						'type'				=> 'theme_mod',
						'transport'			=> 'refresh',
						'sanitize_callback' => false,
					) );
					$wp_customize->add_control( 'wpex_'. $element .'_typography[font-size]', array(
						'label'			=> __( 'Font Size', 'spartan' ),
						'section'		=> 'wpex_typography_'. $element,
						'settings'		=> 'wpex_'. $element .'_typography[font-size]',
						'priority'		=> 5,
						'type'			=> 'text',
						'description'	=> __( 'Value in pixels.', 'spartan' ),
					) );


					/* Font Color
					$wp_customize->add_setting( 'wpex_'. $element .'_typography[color]', array(
						'type'		=> 'theme_mod',
						'default'	=> '',
					) );
					$wp_customize->add_control(
						new WP_Customize_Color_Control(
							$wp_customize,
							'wpex_'. $element .'_typography_color',
							array(
								'label'		=> __( 'Font Color', 'spartan' ),
								'section'	=> 'wpex_typography_'. $element,
								'settings'	=> 'wpex_'. $element .'_typography[color]',
								'priority'	=> 6,
							)
						)
					); */

					// Line Height
					$wp_customize->add_setting( 'wpex_'. $element .'_typography[line-height]', array(
						'type'		=> 'theme_mod',
						'transport'	=> 'refresh',
						'sanitize_callback' => false,
					) );
					$wp_customize->add_control( 'wpex_'. $element .'_typography[line-height]',
						array(
							'label'		=> __( 'Line Height', 'spartan' ),
							'section'	=> 'wpex_typography_'. $element,
							'settings'	=> 'wpex_'. $element .'_typography[line-height]',
							'priority'	=> 7,
							'type'		=> 'text',
					) );

					// Letter Spacing
					$wp_customize->add_setting( 'wpex_'. $element .'_typography[letter-spacing]', array(
						'type'		=> 'theme_mod',
						'transport'	=> 'refresh',
						'sanitize_callback' => false,
					) );
					$wp_customize->add_control(
						new WPEX_Customize_Sliderui_Control(
							$wp_customize,
							'wpex_'. $element .'_typography_letter_spacing',
							array(
								'label'		=> __( 'Letter Spacing', 'spartan' ),
								'section'	=> 'wpex_typography_'. $element,
								'settings'	=> 'wpex_'. $element .'_typography[letter-spacing]',
								'priority'	=> 8,
								'type'		=> 'wpex_slider_ui',
								'choices'	=> array(
									'min'	=> 0,
									'max'	=> 20,
									'step'	=> 1,
								),
							)
						)
					);

				}
			} // End foreach

		} // End register

		/*-----------------------------------------------------------------------------------*/
		/*	- Reset Cache after customizer save
		/*-----------------------------------------------------------------------------------*/
		public function reset_cache() {
			remove_theme_mod( 'wpex_customizer_typography_cache' );
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Output Custom CSS
		/*-----------------------------------------------------------------------------------*/
		public function loop( $return = 'css' ) {
			// Get typography data cache
			$data = get_theme_mod( 'wpex_customizer_typography_cache', false );
			$css			= '';
			$load_scripts	= '';
			$fonts			= array();
			// If theme mod cache empty or is live customizer loop through elements and set output
			if ( empty( $data ) || is_customize_preview() ) {
				$elements		= self::elements();
				$theme_mods		= array( 'font-family', 'font-weight', 'font-style', 'font-size', 'color', 'line-height', 'letter-spacing', 'text-transform' );
				// Loop through each elements that need typography styling applied to them
				foreach( $elements as $element => $array ) {
					$add_css	= '';
					$target		= isset( $array['target'] ) ? $array['target'] : '';
					if ( $target ) {
						$get_mod = get_theme_mod( 'wpex_'. $element .'_typography' );
						foreach ( $theme_mods as $theme_mod ) {
							$val = isset ( $get_mod[$theme_mod] ) ? $get_mod[$theme_mod] : '';
							if ( $val ) {
								// Convert font-size to px
								if ( 'font-size' == $theme_mod || 'letter-spacing' == $theme_mod ) {
									$val = intval( $get_mod[$theme_mod] ) .'px';
								}
								// Add quotes around font-family && font family to scripts array
								if ( 'font-family' == $theme_mod ) {
									$fonts[] = $val;
									$val = '"'. $val .'"';
								}
								// Add custom CSS
								$add_css .= $theme_mod .':'. $val .';';
							}
						}
						if ( $add_css ) {
							$css .= $target .'{'. $add_css .'}';
						} 
					}
				}
				if ( $css || $fonts ) {
					// Only load 1 of each font
					if ( ! empty( $fonts ) ) {
						array_unique( $fonts );
					}
					// Get Google Scripts to load on the front end
					if ( ! empty ( $fonts ) ) {
						$google_fonts	= wpex_google_fonts_array();
						$scripts		= array();
						// Loop through fonts and create Google Font Link
						foreach ( $fonts as $font ) {
							if ( in_array( $font, $google_fonts ) ) {
								$scripts[] = 'https://fonts.googleapis.com/css?family='.str_replace(' ', '%20', $font ) .'';
							}
						}
						// If scripts need to be loaded create the link tags
						if ( ! empty( $scripts ) ) {
							$load_scripts = '<!-- Load Google Fonts -->';
							foreach ( $scripts as $script ) {
								$load_scripts .= '<link href="'. $script .':300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic" rel="stylesheet" type="text/css">';
							}
						}
					}
				}
			}
			// Set cache or get cache if not in customizer
			if ( ! is_customize_preview() ) {
				// Get Cache vars
				if ( $data ) {
					$css			= isset( $data['css'] ) ? $data['css'] : '';
					$fonts			= isset( $data['fonts'] ) ? $data['fonts'] : '';
					$load_scripts	= isset( $data['scripts'] ) ? $data['scripts'] : '';
				}
				// Set Cache
				else {
					set_theme_mod( 'wpex_customizer_typography_cache', array (
						'css'		=> $css,
						'fonts'		=> $fonts,
						'scripts'	=> $load_scripts,
					) );
				}
			}
			// Return CSS
			if ( 'css' == $return && $css ) {
				$css = '<!-- Typography CSS --><style type="text/css">'. $css .'</style>';
				return $css;
			}
			// Return Fonts array
			if ( 'fonts' == $return && ! empty( $fonts ) ) {
				return $fonts;
			}
			// Return Scripts
			if ( 'scripts' == $return && $load_scripts ) {
				return $load_scripts;
			}
		} // End loop function

		/*-----------------------------------------------------------------------------------*/
		/*	- Output Custom CSS
		/*-----------------------------------------------------------------------------------*/
		public function output_css() {
			echo self::loop( 'css' );
		} // End output_css function

		/*-----------------------------------------------------------------------------------*/
		/*	- Load Google Fonts
		/*-----------------------------------------------------------------------------------*/
		public function load_fonts() {
			echo self::loop( 'scripts' );
		} // End load_fonts function

	}
}
$wpex_theme_customizer_typography = new WPEX_Theme_Customizer_Typography();