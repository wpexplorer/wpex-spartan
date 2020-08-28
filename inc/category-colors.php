<?php
/**
* Outputs the category color CSS
* 
* @package WordPress
* @subpackage Spartan WPExplorer Theme
* @since Spartan 1.0
*/
if ( ! function_exists( 'wpex_category_colors_css' ) ) :
	function wpex_category_colors_css() {
		$css='';
		$cats = get_categories( array(
			'orderby'		=> 'name',
			'hide_empty'	=> false,
			//'parent'	=> 0
		) );
		foreach( $cats as $cat ) {
			$theme_mod = get_theme_mod( 'wpex_cat_'. $cat->term_id .'_color' );
			if ( '' != $theme_mod ) {
				$id = $cat->term_id;
				$css .= '.cat-'. $id .'-bg,#site-navigation .dropdown-menu .cat-'. $id .':after, body.category-'. $id .' .layout-toggle {background-color:'. $theme_mod .'}#site-navigation .current-menu-item.cat-'. $id .' > a, .wpex-mobile-main-nav .cat-'. $id .' > a {color:'. $theme_mod .' !important}';
			}
		}
		if ( $css ) {
			$css = "\r\n" . "<!-- Category Colors -->\n<style type=\"text/css\">\n" . $css . "\n</style>";
			echo $css;
		} else {
			return;
		}

	}
endif;
add_action( 'wp_head' , 'wpex_category_colors_css' );