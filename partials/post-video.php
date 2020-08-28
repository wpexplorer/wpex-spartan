<?php
/**
 * Displays the single post video
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

// Display post video
if ( $post_video = wpex_post_video() ) :  ?>
	<div class="single-post-media clr">
		<?php echo $post_video; ?>
	</div><!-- .single-post-media -->
<?php
// If no video defined, then display the thumbnail
elseif ( has_post_thumbnail() ) :

	// Get featured image, see @inc/featured-image.php
	$img = wpex_image( 'array' );

	// Return if array is empty
	if ( empty( $img ) ) {
		return;
	} ?>
	<div class="single-post-media clr">
		<div class="post-thumbnail">
			<img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" width="<?php echo esc_attr( $img['width'] ); ?>" height="<?php echo esc_attr( $img['height'] ); ?>" />
		</div><!-- .post-thumbnail -->
	</div><!-- .single-post-media -->
<?php endif; ?>