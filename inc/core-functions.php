<?php
/**
 * Core theme functions.
 *
 * @package		WordPress
 * @subpackage	Spartan
 * @since		Spartan 1.1.2
 */

/**
 * Returns correct grid class
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpex_grid_class' ) ) {
	function wpex_grid_class( $col ) {
		return 'span_1_of_'. $col;
	}
}

/**
 * Check if post has a video defined
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpex_post_has_video' ) ) {
	function wpex_post_has_video() {
		$post_id = get_the_ID();
		if ( get_post_meta( $post_id, 'wpex_post_video', true ) || get_post_meta( $post_id, 'wpex_post_video', true ) ) {
			return true;
		}
	}
}

/**
 * Returns the correct post video
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpex_post_video' ) ) {
	function wpex_post_video() {
		$post_id        = get_the_ID();
		$video_url		= get_post_meta( $post_id, 'wpex_post_video', true );
		$video_embed	= get_post_meta( $post_id, 'wpex_post_video_embed', true );
		if ( $video_embed ) {
			return '<div class="post-video wpex-video-embed clr">'. $video_embed .'</div>';
		} elseif ( $video_url ) {
			return '<div class="post-video wpex-video-embed clr">'. wp_oembed_get( $video_url ) .'</div>';
		} else {
			return;
		}
	}
}

/**
 * Checks if a user has social options defined
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpex_contributor_has_social' ) ) {
	function wpex_contributor_has_social( $user_id = NULL ) {
		if ( '' != get_the_author_meta( 'wpex_twitter', $user_id ) ) {
			return true;
		}
		elseif ( '' != get_the_author_meta( 'wpex_facebook', $user_id ) ) {
			return true;
		}
		elseif ( '' != get_the_author_meta( 'wpex_googleplus', $user_id ) ) {
			return true;
		}
		elseif ( '' != get_the_author_meta( 'wpex_linkedin', $user_id ) ) {
			return true;
		}
		elseif ( '' != get_the_author_meta( 'wpex_instagram', $user_id ) ) {
			return true;
		}
		// Display pinterest plus url
		elseif ( '' != get_the_author_meta( 'wpex_pinterest', $user_id ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Returns the ID's to exclude for the homepage
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpex_exclude_home_ids' ) ) {
	function wpex_exclude_home_ids(){
		$array = array();

		// Build array of slider ID's
		if ( $exclude = get_theme_mod( 'wpex_homepage_slider_exclude_posts' ) ) {
			$content = get_theme_mod( 'wpex_homepage_slider_content', 'recent_posts' );
			$count = get_theme_mod( 'wpex_homepage_slider_count', '3' );
			if( $content && 'none' != $content && $count >= 1 ) {
				if ( 'recent_posts' == $content ) {
					$posts = get_posts( array(
						'post_type'			=> 'post',
						'posts_per_page'	=> $count,
						'meta_key'			=> '_thumbnail_id',
					) );
					if ( $posts ) {
						foreach( $posts as $post ) {
							$array[] = $post->ID;
						}
					}
				} elseif ( 'none' != $content ) {
					$posts = get_posts( array(
						'post_type'			=> 'post',
						'posts_per_page'	=> $count,
						'meta_key'			=> '_thumbnail_id',
						'tax_query'			=> array (
							array (
								'taxonomy'	=> 'category',
								'field'		=> 'ID',
								'terms'		=> $content,
							)
						)
					) );
					if ( $posts ) {
						foreach( $posts as $post ) {
							$array[] = $post->ID;
						}
					}
				}
			}
		}

		// Build array of carousel ID's
		if ( $exclude = get_theme_mod( 'wpex_homepage_carousel_exclude_posts' ) ) {
			$content = get_theme_mod( 'wpex_homepage_carousel_content', 'recent_posts' );
			$count = get_theme_mod( 'wpex_homepage_carousel_count', '3' );
			if( $content && 'none' != $content && $count >= 1 ) {
				if ( 'recent_posts' == $content ) {
					$posts = get_posts( array(
						'post_type'			=> 'post',
						'posts_per_page'	=> $count,
						'meta_key'			=> '_thumbnail_id',
					) );
					if ( $posts ) {
						foreach( $posts as $post ) {
							$array[] = $post->ID;
						}
					}
				} elseif ( 'none' != $content ) {
					$posts = get_posts( array(
						'post_type'			=> 'post',
						'posts_per_page'	=> $count,
						'meta_key'			=> '_thumbnail_id',
						'tax_query'			=> array (
							array (
								'taxonomy'	=> 'category',
								'field'		=> 'ID',
								'terms'		=> $content,
							)
						)
					) );
					if ( $posts ) {
						foreach( $posts as $post ) {
							$array[] = $post->ID;
						}
					}
				}
			}
		}

		return $array;
	}
}

/**
 * Custom excerpts based on wp_trim_words
 * Created for child-theming purposes
 * 
 * Learn more at http://codex.wordpress.org/Function_Reference/wp_trim_words
 *
 * @since Spartan 1.0
 */
if ( ! function_exists( 'wpex_excerpt' ) ) {
	function wpex_excerpt( $length = 25, $readmore = true, $echo = true ) {
		$length = get_theme_mod( 'wpex_excerpt_length', '25' );
		if ( ! $length || ! is_numeric( $length ) ) {
			return;
		}
		$length = intval( $length );
		// Main vars
		global $post;
		$id = $post->ID;
		$output = '';
		// Check if read more is enabled
		if ( $readmore ) {
			if ( get_theme_mod( 'wpex_blog_readmore' ) ) {
				$readmore = true;
			} else {
				$readmore = false;
			}
		}
		// Readmore text
		$readmore_text = get_theme_mod( 'wpex_readmore_text', __( 'Read More', 'spartan' ) );
		if ( '' == $readmore_text ) {
			$readmore_text = __( 'Read More', 'spartan' );
		}
		// Readmore link HTML
		$readmore_link = '<div class="wpex-readmore">
			<a href="'. get_permalink( $id ) .'" title="'. $readmore_text .'" rel="bookmark">';
				$readmore_link .= '<span class="text">'. $readmore_text .'</span>';
				if ( is_rtl() ) {
					$readmore_link .= '<span class="arrow">&larr;</span>';
				} else {
					$readmore_link .= '<span class="arrow">&rarr;</span>';
				}
			$readmore_link .= '</a>
		</div>';
		// Display custom excerpt
		if ( has_excerpt( $id ) ) {
			$output = $post->post_excerpt;
			if ( $readmore ) {
				$output .= apply_filters( 'wpex_readmore_link', $readmore_link );
			}
		} else {
			if ( ! is_single() && ! get_theme_mod( 'wpex_ignore_more_tag' ) && strpos( $post->post_content, '<!--more-->' )  ) {
				if ( $echo ) {
					the_content( '' );
				} else {
					return get_the_excerpt( '' );
				}
			} else {
				$output = wp_trim_words( strip_shortcodes( get_the_content( $id ) ), $length, '&hellip;' );
			}
			if ( $readmore ) {
				$output .= apply_filters( 'wpex_readmore_link', $readmore_link );
			}
		}
		if ( isset( $output ) && '' != $output ) {
			if ( $echo ) {
				echo strip_shortcodes( $output );
			} else {
				return strip_shortcodes( $output );
			}
		}
	}
}

/**
 * Returns correct font awesome icon for current post format
 *
 * @since Spartan 1.0
 */
if ( ! function_exists( 'wpex_post_format_icon' ) ) {
	function wpex_post_format_icon() {
		global $post;
		$post_id = $post->ID;
		$format = get_post_format();
		// Video
		if ( 'video' == $format ) {
			$icon = 'fa-film';
		}
		// Audio
		if ( 'audio' == $format ) {
			$icon = 'fa-music';
		}
		// Gallery
		elseif ( 'gallery' == $format ) {
			$icon = 'fa-file-photo-o';
		}
		// Quote
		elseif ( 'quote' == $format ) {
			$icon = 'fa-quote-left';
		}
		// Standard
		else {
			$icon = 'fa-file-text-o';
		}
		$icon = apply_filters( 'wpex_post_format_icon', $icon );
		echo $icon;
	}
}

/**
 * Sanitizes data
 *
 * @since   1.0.0
 * @return  string
 */
if ( ! function_exists( 'wpex_sanitize_data' ) ) {
	function wpex_sanitize_data( $data, $type ) {

		// URL
		if ( 'url' == $type ) {
			$data = esc_url( $data );
		}

		// HTML
		elseif ( 'html' == $type ) {
			$data = wp_kses( $data, array(
					'a'         => array(
						'href'  => array(),
						'title' => array()
					),
					'br'        => array(),
					'em'        => array(),
					'strong'    => array(),
			) );
		}

		// Videos
		elseif ( 'video' == $type ) {
			$data = wp_kses( $data, array(
				'iframe' => array(
					'src'               => array(),
					'type'              => array(),
					'allowfullscreen'   => array(),
					'allowscriptaccess' => array(),
					'height'            => array(),
					'width'             => array()
				),
				'embed' => array(
					'src'               => array(),
					'type'              => array(),
					'allowfullscreen'   => array(),
					'allowscriptaccess' => array(),
					'height'            => array(),
					'width'             => array()
				),
			) );
		}
		return $data;
	}
}

/**
 * Echo escaped post title
 *
 * @since   Spartan 2.0.0
 * @return  string
 */
function wpex_esc_title() {
	echo wpex_get_esc_title();
}

/**
 * Return escaped post title
 *
 * @since   Spartan 1.5.4
 * @return  string
 */
function wpex_get_esc_title() {
	return esc_attr( the_title_attribute( 'echo=0' ) );
}