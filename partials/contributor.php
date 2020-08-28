<?php
/**
 * The default template for displaying post content.
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Vars
global $wpex_contributor;
$user_id = $wpex_contributor->ID;
$display_name = $wpex_contributor->display_name;
$author_profile_url = get_author_posts_url( $user_id ); ?>

<article class="contributor-entry boxed-content clr">
	<div class="contributor-entry-inner clr">
		<div class="contributor-entry-avatar">
			<a href="<?php echo esc_url( $author_profile_url ); ?>" title="<?php _e( 'Posts by', 'spartan' ); ?> <?php echo esc_attr( $display_name ); ?>">
				<?php echo get_avatar( $user_id , '80' ); ?>
			</a>
			<div class="contributor-entry-count">
				<a href="<?php echo esc_url( $author_profile_url ); ?>" title="<?php _e( 'Posts by', 'spartan' ); ?> <?php echo esc_attr( $display_name ); ?>"><?php echo count_user_posts( $user_id ); ?> <?php _e( 'articles', 'spartan' ); ?></a>
			</div>
		</div><!-- .contributor-entry-avatar -->
		<div class="contributor-entry-desc">
			<h2 class="contributor-entry-title">
				<a href="<?php echo esc_url( $author_profile_url ); ?>" title="<?php _e( 'Posts by', 'spartan' ); ?> <?php echo esc_attr( $display_name ); ?>"><?php echo esc_html( $display_name ); ?></a>
			</h2>
			<?php if ( get_the_author_meta( 'url', $user_id ) ) { ?>
				<div class="contributor-entry-url">
					<?php if ( $url = get_the_author_meta( 'wpex_website', $user_id ) ) { ?>
						<span><?php _e( 'Website', 'spartan' ); ?>:</span> <a href="<?php echo get_the_author_meta( 'url', $user_id ); ?>" title=""><?php echo esc_url( $url ); ?></a>
					<?php } elseif ( $url = get_the_author_meta( 'url', $user_id ) ) { ?>
						<a href="<?php echo esc_url( $url ); ?>" title=""><?php echo esc_url( $url ); ?></a>
					<?php } ?>
				</div>
			<?php } ?>
			<p><?php echo get_user_meta( $user_id, 'description', true ); ?></p>
			<?php
			// If any social option is defined display the social links
			if( wpex_contributor_has_social( $user_id ) ) { ?>
				<div class="contributor-entry-social clr">
					<?php
					// Display twitter url
					if ( $url = get_the_author_meta( 'wpex_twitter', $user_id ) ) { ?>
						<a href="<?php echo esc_url( $url ); ?>" title="Twitter" class="twitter"><span class="fa fa-twitter"></span></a>
					<?php }
					// Display facebook url
					if ( $url = get_the_author_meta( 'wpex_facebook', $user_id ) ) { ?>
						<a href="<?php echo esc_url( $url ); ?>" title="Facebook" class="facebook"><span class="fa fa-facebook"></span></a>
					<?php }
					// Display google plus url
					if ( $url = get_the_author_meta( 'wpex_googleplus', $user_id ) ) { ?>
						<a href="<?php echo esc_url( $url ); ?>" title="Google Plus" class="google-plus"><span class="fa fa-google-plus"></span></a>
					<?php }
					// Display Linkedin url
					if ( $url = get_the_author_meta( 'wpex_linkedin', $user_id ) ) { ?>
						<a href="<?php echo esc_url( $url ); ?>" title="Facebook" class="linkedin"><span class="fa fa-linkedin"></span></a>
					<?php }
					// Display pinterest plus url
					if ( $url = get_the_author_meta( 'wpex_pinterest', $user_id ) ) { ?>
						<a href="<?php echo esc_url( $url ); ?>" title="Pinterest" class="pinterest"><span class="fa fa-pinterest"></span></a>
					<?php }
					// Display instagram plus url
					if ( $url = get_the_author_meta( 'wpex_instagram', $user_id ) ) { ?>
						<a href="<?php echo esc_url( $url ); ?>" title="Instagram" class="instagram"><span class="fa fa-instagram"></span></a>
					<?php } ?>
				</div><!-- .author-bio-social -->
			<?php } ?>
		</div><!-- .contributor-entry-desc -->
	</div><!-- .contributor-entry-inner -->
</article><!-- .contributor-entry -->