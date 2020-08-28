<?php
/**
 * Custom pagination functions
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

/**
	Return correct pagination style
**/
if ( ! function_exists( 'wpex_get_pagination') ) {
	function wpex_get_pagination( $style = '' ) {
		$style = $style ? $style : get_theme_mod( 'wpex_pagination', 'pagination' );
		if ( isset( $_GET['wpex_pagination'] ) ) {
			$style = $_GET['wpex_pagination'];
		}
		if ( 'pagination' == $style ) {
			wpex_pagination();
		}
		if ( 'next-prev' == $style ) {
			wpex_page_jump();
		}
	}
}

/**
	Numbered pagination
**/
if ( ! function_exists( 'wpex_pagination') ) {
	function wpex_pagination() {
		global $wp_query;
		$total = $wp_query->max_num_pages;
		$big = 999999999; // need an unlikely integer
		if ( $total > 1 ) {
			if ( !$current_page = get_query_var( 'paged') )
				$current_page = 1;
			if ( get_option( 'permalink_structure') ) {
				$format = 'page/%#%/';
			} else {
				$format = '&paged=%#%';
			}
			if ( is_rtl() ) {
				$prev_link = __( 'Previous', 'spartan' ) .'<i class="fa fa-caret-right"></i>';
				$next_link = '<i class="fa fa-caret-left"></i>'. __( 'Next', 'spartan' );
			} else {
				$prev_link = '<i class="fa fa-caret-left"></i>'. __( 'Previous', 'spartan' );
				$next_link = __( 'Next', 'spartan' ) .'<i class="fa fa-caret-right"></i>';
			}
			$current_page_num = max( 1, get_query_var( 'paged') ); ?>
			<div class="site-pagination clr">
				<span class="site-pagination-heading"><?php _e( 'Pages', 'spartan' ); ?></span>
				<?php echo paginate_links( array(
					'base'		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'	=> $format,
					'current'	=> $current_page_num,
					'total'		=> $total,
					'mid_size'	=> 2,
					'type'		=> 'list',
					'prev_next'	=> false,
				) ); ?>
				</div><!-- .site-pagination -->
		<?php }
	}
}

/**
	Next/Previous page style pagination used for infinite scroll
**/
if ( !function_exists( 'wpex_page_jump') ) {
	function wpex_page_jump( $pages = '', $range = 4 ) {
		global $wp_query;
		$showitems = ($range * 2)+1; 
		global $paged;
		if ( empty( $paged ) ) {
			$paged = 1;
		}
		if ( $pages == '' ) {
			global $wp_query,$wpex_query;
			if ( $wpex_query ) {
				$pages = $wpex_query->max_num_pages;
			} else {
				$pages = $wp_query->max_num_pages;
			}
			if (!$pages) {
				$pages = 1;
			}
		}
		if ( 1 != $pages ) { ?>
			<div class="page-jump clr">
				<div class="newer-posts alignleft">
					<?php previous_posts_link( '&larr; ' . __( 'Newer Posts', 'spartan' ) ); ?>
				</div>
				<div class="older-posts alignright">
					<?php next_posts_link( __( 'Older Posts', 'spartan' ) .' &rarr;' ); ?>
				</div>
			</div>
		<?php }
		
	}
}