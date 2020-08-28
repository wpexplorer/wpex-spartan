<?php
/**
 * Displays the single post thumbnail
 *
 * @package		Spartan
 * @subpackage	Partials
 * @author		Alexander Clarke
 * @copyright	Copyright (c) 2014, Symple Workz LLC
 * @link		http://www.wpexplorer.com
 * @since		1.1.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return if there isn't any thumbnail defined
if ( ! has_post_thumbnail() ) {
	return;
}

// Return if disabled via theme mod
if ( ! get_theme_mod( 'wpex_blog_post_thumb', true ) ) {
	return;
}

// Return if disabled via custom field
if ( 'on' == get_post_meta( get_the_ID(), 'wpex_disable_featured_image', true ) ) {
	return;
}

// Get featured image, see @inc/featured-image.php
$img = wpex_image( 'array' );

// Return if array is empty
if ( empty( $img ) ) {
	return;
} ?>

<div class="single-post-media clr">
	<div class="post-thumbnail">
		<img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php wpex_esc_title(); ?>" width="<?php echo esc_attr( $img['width'] ); ?>" height="<?php echo esc_attr( $img['height'] ); ?>" />
	</div><!-- .post-thumbnail -->
</div><!-- .single-post-media -->