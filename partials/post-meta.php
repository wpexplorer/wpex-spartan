<?php
/**
 * Single post meta
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

// Get array and set defaults
$array = get_theme_mod( 'wpex_post_meta', array( 'date', 'author', 'category', 'comments' ) );

// Return if empty
if ( empty( $array ) ) {
	return;
}

// Turn into array
if ( ! is_array( $array ) ) {
	$array = explode( ',', $array );
} ?>

<div class="post-meta clr">
	<?php
	// Swap order if RTL
	if ( is_rtl() ) {
		$array = array_reverse( $array );
	}
	// Loop through meta options
	foreach( $array as $item ) {
	switch( $item ) {
		// Date
		case 'date': ?>
		<span class="post-meta-date">
			<?php _e( 'Posted on', 'spartan' ); ?> <?php echo get_the_date(); ?>
		</span>
		<?php break;
		// Author
		case 'author': ?>
		<span class="post-meta-author">
			<?php _e( 'by', 'spartan' ); ?> <?php the_author_posts_link(); ?>
		</span>
		<?php break;
		// Category
		case 'category': ?>
		<span class="post-meta-category">
			<?php _e( 'in', 'spartan' ); ?> <?php the_category(', '); ?>
		</span>
		<?php break;
		// Comments
		case 'comments': ?>
		<?php if ( comments_open() ) { ?>
			<span class="post-meta-comments">
				<?php _e( 'with', 'spartan' ); ?> <?php comments_popup_link( __( '0 Comments', 'spartan' ), __( '1 Comment',  'spartan' ), __( '% Comments', 'spartan' ), 'comments-link' ); ?>
			</span>
		<?php } ?>
	<?php } // END switch
	} // End foreach ?>
</div><!-- .post-meta -->