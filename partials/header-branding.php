<?php
/**
 * Header branding => logo & site description
 *
 * @package     Spartan
 * @subpackage  Partials
 * @author      Alexander Clarke
 * @copyright   Copyright (c) 2014, Symple Workz LLC
 * @link        http://www.wpexplorer.com
 * @since       1.1.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get data
$logo_src    = apply_filters( 'wpex_logo_src', get_theme_mod( 'wpex_logo' ) );
$blog_name   = get_bloginfo( 'name' );
$description = get_theme_mod( 'wpex_logo_subheading', __( 'Edit your subheading via the theme customizer.', 'spartan' ) );

// Sanitize data
$description = wpex_sanitize_data( $description, 'html' ); ?>

<div class="site-branding clr">
	<div id="logo" class="clr">
		<?php
		// Get correct tag for SEO
		if ( is_front_page() ) {
			$open_tag = '<h1>';
			$close_tag = '</h1>';
		} else {
			$open_tag = '<h2>';
			$close_tag = '</h2>';
		} ?>
		<?php if ( $logo_src ) {
			echo $open_tag; ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( $blog_name ); ?>" rel="home">
				<img src="<?php echo esc_url( $logo_src ); ?>" alt="<?php echo esc_attr( $blog_name ); ?>" />
			</a>
		<?php
			echo $close_tag;
		} else { ?>
			<div class="site-text-logo clr">
				<?php echo $open_tag; ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( $blog_name ); ?>" rel="home"><?php echo esc_html( $blog_name ); ?></a>
				<?php echo $close_tag; ?>
			</div>
		<?php } ?>
	</div><!-- #logo -->
	<?php if ( $description ) : ?>
		<div id="blog-description" class="clr">
			<?php echo wp_kses_post( $description ); ?>
		</div><!-- #blog-description -->
	<?php endif; ?>
</div><!-- .site-branding -->