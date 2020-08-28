<?php
/**
 * Single related posts
 *
 * @package     Spartan
 * @subpackage  Partials
 * @author      Alexander Clarke
 * @copyright   Copyright (c) 2014, Symple Workz LLC
 * @link        http://www.wpexplorer.com
 * @since       1.1.2
 * @version     1.3.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Return if disabled via meta
if ( ! get_theme_mod( 'wpex_related', true ) ) {
    return;
}

// Return if disabled via theme mods
if ( 'on' == get_post_meta( get_the_ID(), 'wpex_disable_related', true ) ) {
    return;
}

// Get Current post
$post_id = get_the_ID();

// Return if not standard post type
if ( 'post' != get_post_type( $post_id ) ) {
    return;
}

// Related query arguments
$args = array(
    'posts_per_page'      => '8',
    'post__not_in'        => array( $post_id ),
    'no_found_rows'       => true,
    'meta_key'            => '_thumbnail_id',
    'ignore_sticky_posts' => true,
);

// Related cats
if ( get_theme_mod( 'wpex_related_category_relation', true ) ) {

    $cats = wp_get_post_terms( $post_id, 'category' ); 
    $cats_ids = array();  
    foreach( $cats as $wpex_related_cat ) {
        $cats_ids[] = $wpex_related_cat->term_id; 
    }

    if ( $cats_ids ) {
        $args['category__in'] = $cats_ids;
    }

}

// Add order
if ( $order = get_theme_mod( 'wpex_related_order', 'DESC' ) ) {
    $args['order'] = $order;
}

// Add orderby
if ( $orderby = get_theme_mod( 'wpex_related_orderby', 'rand' ) ) {
    $args['orderby'] = $orderby;
}

// Exclude formats
$exclude_formats = array( 'post-format-quote', 'post-format-link', 'post-format-status' );
$exclude_formats = apply_filters( 'wpex_related_posts_exclude_formats', $exclude_formats );
if ( $exclude_formats ) {
    $args['tax_query'] = array(
        'relation'  => 'AND',
        array(
            'taxonomy'  => 'post_format',
            'field'     => 'slug',
            'terms'     => $exclude_formats,
            'operator'  => 'NOT IN',
        ),
    );
}

// Apply filters to arguments
$args = apply_filters( 'wpex_related_posts_args', $args );

// Query posts
$wpex_query = new wp_query( $args );

// Display related if posts are found
if ( $wpex_query->have_posts() ) : ?>

    <div class="related-carousel-wrap clr">
        <div class="heading"><?php _e( 'Related Posts', 'spartan' ); ?></div>
        <div class="related-carousel owl-carousel clr count-<?php echo count( $wpex_query->posts ); ?>">
            <?php
            // Loop through related posts
            foreach( $wpex_query->posts as $post ) : setup_postdata( $post ); ?>
            <?php
            // Display post thumbnail
            if ( has_post_thumbnail() && $wpex_img = wpex_image( 'array', '', true ) ) { ?>
                <div class="related-carousel-slide">
                    <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
                        <img src="<?php echo esc_url( $wpex_img['url']  ); ?>" alt="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" width="<?php echo esc_attr( $wpex_img['width'] ); ?>" height="<?php echo esc_attr( $wpex_img['height'] ); ?>" />
                        <?php the_title(); ?>
                    </a>
                </div><!-- .related-carousel-slide -->
            <?php } ?>
            <?php endforeach; ?>
        </div><!-- .related-carousel -->
    </div>

<?php endif;

// Reset post data
wp_reset_postdata();