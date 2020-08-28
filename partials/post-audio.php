<?php
/**
 * Displays the single post audio
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

// Get post audio
$audio_url = get_post_meta( $post->ID, 'wpex_post_audio', true );

// Display post audio
if ( $audio_url ) : ?>

	<div class="single-post-media clr">
		<div class="post-audio wpex-audio-embed clr">
			<?php echo apply_filters( 'the_content', $audio_url ); ?>
		</div><!-- .post-audio -->
	</div><!-- .single-post-media -->
	
<?php
// If no audio defined, then display the thumbnail
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