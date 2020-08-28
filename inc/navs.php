<?php
/**
 * Modify WP menu for dropdown styles
 *
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

class WPEX_Top_Walker_Nav_Menu extends Walker_Nav_Menu {
	function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
		$id_field = $this->db_fields['id'];
		if ( !empty( $children_elements[$element->$id_field] ) && ( $depth == 0 ) ) {
			$element->classes[] = 'dropdown';
			$element->title .= ' <i class="fa fa-caret-down nav-arrow"></i>';
		}
		if ( !empty( $children_elements[$element->$id_field] ) && ( $depth > 0 ) ) {
			$element->classes[] = 'dropdown';
			if( is_rtl() ) {
				$element->title .= ' <i class="fa fa-caret-left nav-arrow"></i>';
			} else {
				$element->title .= ' <i class="fa fa-caret-right nav-arrow"></i>';
			}
		}
		Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
}


// Adds category classes to menu
if( ! function_exists( 'wpex_nav_menu_css_class' ) ) :
	function wpex_nav_menu_css_class( $classes, $item ){
	    if( 'category' == $item->object ){
	        $classes[] = 'cat-' . $item->object_id;
	    }
	    return $classes;
	}
endif;
add_filter( 'nav_menu_css_class', 'wpex_nav_menu_css_class', 10, 2 );


/**
 * Adds a login/logout link to the end of your menu nav
 *
 * @since 1.0
 */
if ( !function_exists( 'wpex_add_search_to_menu' ) ) :
	function wpex_add_search_to_menu ( $items, $args ) {
		// Return if login/out nav item is disabled
		if( ! get_theme_mod( 'wpex_login_page' ) ) {
			return $items;
		}
		// Display login/out nav item
		if ( 'top_menu' == $args->theme_location ) {
			if( is_user_logged_in() ) {
				$items .= '<li><a href="'. wp_logout_url( get_permalink() ) .'" class="nav-loginout-link"><span class="fa fa-unlock"></span>'. get_theme_mod( 'wpex_logout_link_txt', __( 'Log Out', 'spartan' ) ) .'</a></li>';
			} else {
				$login_page = get_theme_mod( 'wpex_login_page', '' );
				if( $login_page ) {
					$items .= '<li><a href="'. get_permalink( $login_page ) .'" class="nav-loginout-link">
					<span class="fa fa-lock"></span>
					'. get_the_title( $login_page ) .'</a>
					</li>';
				}
			}
		}
		return $items;
	}
endif;
add_filter( 'wp_nav_menu_items', 'wpex_add_search_to_menu', 11, 2 );