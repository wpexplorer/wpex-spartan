<?php
/**
 * Useful category functions
 *
 * @package WordPress
 * @subpackage Spartan
 * @since Spartan 1.0
*/

// Returns the first category name, link, id
if ( ! function_exists( 'wpex_get_first_category' ) ) {
	function wpex_get_first_category( $return = 'link', $cat_id = false, $child = false ) {
		
		// If currently on category archive display the first child category of current cat
		if ( $child || is_category() ) {
			if ( $cat_id ) {
				$main_cat = $cat_id;
			} else {
				$main_cat = get_query_var( 'cat' );
			}
			$cats = get_the_category();
			$child_cats = array();
			foreach( $cats as $cat ) {
				if ( cat_is_ancestor_of( $main_cat, $cat ) ) {
					$child_cats[] = $cat->term_id;
				}
			}
			if ( $child_cats && isset( $child_cats[0] ) ){
				if ( 'link' == $return ) {
					return '<a href="'.get_category_link( $child_cats[0] ).'" title="'. get_cat_name( $child_cats[0] ) .'">'. get_cat_name( $child_cats[0] ) .'</a>';
				} elseif ( 'name' == $return ) {
					return get_cat_name( $child_cats[0] );
				} elseif ( 'id' == $return ) {
					return $child_cats[0];
				}
			}
			// Display first cat on categories if no child of current cat
			elseif (  is_category() && $category = get_query_var( 'cat' ) ) {
				if ( 'link' == $return ) {
					return '<a href="'.get_category_link( $category ).'" title="'. esc_attr( get_cat_name( $category ) ) .'">'. get_cat_name( $category ) .'</a>';
				} elseif ( 'name' == $return ) {
					return get_cat_name( $category );
				} elseif ( 'id' == $return ) {
					return $category;
				}
			}
			// On homepage display main category tag as fallback
			elseif ( is_front_page() && $category = $cat_id ) {
				if ( 'link' == $return ) {
					return '<a href="'.get_category_link( $category ).'" title="'. esc_attr( get_cat_name( $category ) ) .'">'. get_cat_name( $category ) .'</a>';
				} elseif ( 'name' == $return ) {
					return get_cat_name( $category );
				} elseif ( 'id' == $return ) {
					return $category;
				}
			}
		}
		// Return first category
		else {
			$category = get_the_category();
			if ( isset( $category[0] ) ){
				if ( 'link' == $return ) {
					return '<a href="'.get_category_link( $category[0]->term_id ).'" title="'. esc_attr( $category[0]->cat_name ) .'">'. $category[0]->cat_name .'</a>';
				} elseif ( 'name' == $return ) {
					return $category[0]->cat_name;
				} elseif ( 'id' == $return ) {
					return $category[0]->term_id;
				}
			}
		}

	}
}

// Outputs the category tag on entries
if ( !function_exists( 'wpex_category_tag' ) ) {
	function wpex_category_tag( $cat_id = NULL, $child = false ) {
		if ( is_category() && ! $cat_id ) {
			$cat_id = get_query_var( 'cat' );
		}
		if ( ! $cat_id ) {
			$cat_id = wpex_get_first_category( 'id' );
		}
		if ( ! $cat_id ) {
			return;
		} else {
			// Display first child cat
			if ( $child || $cat_id ) {
				$output = wpex_get_first_category( 'link', $cat_id, true );
			} else {
				$output = wpex_get_first_category( 'link' );
			}
			if ( $output ) { ?>
				<div class="entry-cat-tag cat-<?php echo esc_attr( $cat_id ); ?>-bg">
					<?php echo $output; ?>
				</div><!-- .entry-cat-tag -->
			<?php }
		}
	}
}

// Outputs category tag for widgets
if ( ! function_exists( 'wpex_widget_category_tag' ) ) {
	function wpex_widget_category_tag( $return = 'link' ) {
		$category	= get_the_category();
		$output		=	'';
		if ( isset( $category[0] ) ){
			if ( 'link' == $return ) {
				$output = '<a href="'.get_category_link( $category[0]->term_id ).'" title="'. esc_attr( $category[0]->cat_name ) .'">'. $category[0]->cat_name .'</a>';
			} elseif ( 'name' == $return ) {
				$output = $category[0]->cat_name;
			} elseif ( 'id' == $return ) {
				$output = $category[0]->term_id;
			}
			if ( ! empty( $output ) ) { ?>
				<div class="entry-cat-tag cat-<?php echo esc_attr( $category[0]->term_id ); ?>-bg">
					<?php echo $output; ?>
				</div><!-- .entry-cat-tag -->
			<?php }
		}
	}
}

// Archive column toggle
if ( ! function_exists( 'wpex_grid_toggle' ) ) {
	function wpex_grid_toggle() {
		global $wp_query;
		if ( have_posts() && $wp_query->found_posts > 2 ) {
			// Get cookie
			if ( isset( $_COOKIE["wpex-entry-columns"] ) ) {
				$cookie = $_COOKIE["wpex-entry-columns"];
			} else {
				$cookie = '';
			}
			// Set font awesome icon class
			if ( 'two-columns' == get_theme_mod( 'wpex_entry_style' ) && 'disabled' != $cookie ) {
				$icon = 'th-list';
			} elseif ( 'enabled' == $cookie ) {
				$icon = 'th-list';
			} else {
				$icon = 'bars';
			}
			?>
			<span class="layout-toggle"><span class="fa fa-<?php echo esc_html( $icon ); ?>"></span></span>
		<?php } 
	}
}