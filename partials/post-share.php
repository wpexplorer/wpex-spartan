<?php
/**
 * Social sharing function
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

// Get post id
$post_id = get_the_ID();

// Array
$services_array = array( 'twitter', 'facebook', 'google_plus', 'pinterest', 'linkedin' );
$services_array = get_theme_mod( 'wpex_social_share_services', $services_array );

// Return if empty
if ( empty( $services_array ) ) {
    return;
}

// Create array if not array
if ( ! is_array( $services_array ) ) {
    $services_array = explode( ',', $services_array );
}

// Vars
$permalink          = get_permalink( $post_id );
$url                = urlencode( $permalink );
$title              = urlencode( esc_attr( the_title_attribute( 'echo=0' ) ) );
$summary            = urlencode( wp_trim_words( get_the_content( $post_id ), '40' ) );
$img                = urlencode( wp_get_attachment_url( get_post_thumbnail_id( $post_id ) ) );
$source             = urlencode( home_url() );
$services_array     = array_combine( $services_array, $services_array );
$social_share_title = __( 'Please Share', 'spartan' );
$social_share_title = apply_filters( 'wpex_social_share_title', $social_share_title ); ?>

<div class="social-share clr">
    <?php
    // Loop through services
    foreach( $services_array as $service ) {
        switch( $service ) {
            case 'twitter': ?>
                <a href="http://twitter.com/share?text=<?php echo $title; ?>&amp;url=<?php echo $url; ?>" target="_blank" title="<?php _e( 'Share on Twitter', 'spartan' ); ?>" rel="nofollow" class="twitter-share" onclick="javascript:window.open(this.href,
        '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><span class="fa fa-twitter"></span>Tweet</a>
            <?php
            break;
            case 'facebook': ?>
                <a href="http://www.facebook.com/share.php?u=<?php echo $url; ?>" target="_blank" title="<?php _e( 'Share on Facebook', 'spartan' ); ?>" rel="nofollow" class="facebook-share" onclick="javascript:window.open(this.href,
        '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><span class="fa fa-facebook-square"></span>Like</a>
                <?php
            break;
            case 'google_plus': ?>
                <a title="<?php _e( 'Share on Google+', 'spartan' ); ?>" rel="external" href="https://plus.google.com/share?url=<?php echo $url; ?>" class="googleplus-share" onclick="javascript:window.open(this.href,
        '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><span class="fa fa-google-plus"></span>Plus</a>
            <?php
            break;
            case 'pinterest': ?>
                <a href="http://pinterest.com/pin/create/button/?url=<?php echo $url; ?>&amp;media=<?php echo $img; ?>&amp;description=<?php echo $summary; ?>" target="_blank" title="<?php _e( 'Share on Pinterest', 'spartan' ); ?>" rel="nofollow" class="pinterest-share" onclick="javascript:window.open(this.href,
        '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><span class="fa fa-pinterest"></span>Pin It</a>
            <?php
            break;
            case 'linkedin': ?>
                <a title="<?php _e( 'Share on LinkedIn', 'spartan' ); ?>" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $url; ?>&amp;title=<?php echo $title; ?>&amp;summary=<?php echo $summary; ?>&amp;source=<?php echo $source; ?>" target="_blank" rel="nofollow" class="linkedin-share" onclick="javascript:window.open(this.href,
        '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><span class="fa fa-linkedin"></span>Share</a>
        <?php }
    } ?>
</div>