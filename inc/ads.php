<?php
/**
 * Returns the correct grid class based on column number
 *
 * @package WordPress
 * @subpackage Spartan
 * @since Spartan 1.0
*/

// Grid Classes
if ( ! function_exists( 'wpex_ad_spot' ) ) {
	function wpex_ad_spot( $area = '' ) {
		// Sample ad
		if ( $area == 'post-top' ) {
			$sample_ad = '<a href="#"><img src="'. get_template_directory_uri() .'/images/ad-250x250.png" /></a>';
		}
		else {
			$sample_ad = '<a href="#"><img src="'. get_template_directory_uri() .'/images/ad-620x80.png" /></a>';
		}
		// Get theme mod
		$theme_mod = get_theme_mod( 'wpex-ad-'. $area, $sample_ad );
		// If ad defined in the customizer, display it
		if ( $theme_mod ) { ?>
			<div class="ad-spot <?php echo esc_attr( $area ); ?>-ad clr">
				<?php echo do_shortcode( $theme_mod ); ?>
			</div><!-- .ad-spot -->
		<?php }
	}
}