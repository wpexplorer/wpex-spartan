<?php
/**
 * Displays the post entry meta
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

// Return if disabled
if ( ! get_theme_mod( 'wpex_blog_meta', true ) ) {
	return;
}

// Get array and set defaults
$array = get_theme_mod( 'wpex_entry_meta', array( 'date', 'comments' ) );

// Return if empty
if ( empty( $array ) ) {
	return;
}
// Turn into array
if ( ! is_array( $array ) ) {
	$array = explode( ',', $array );
} ?>

<div class="loop-entry-meta clr">
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
				<div class="loop-entry-meta-date">
					<span class="fa fa-clock-o"></span><?php echo get_the_date(); ?>
				</div>
			<?php break;
			// Author
			case 'author': ?>
			<div class="post-meta-author">
				<span class="fa fa-user"></span><?php the_author_posts_link(); ?>
			</div>
			<?php break;
			// Category
			case 'category': ?>
			<div class="loop-entry-meta-category">
				<span class="fa fa-folder"></span><?php the_category(', '); ?>
			</div>
			<?php break;
			// Comments
			case 'comments': ?>
			<?php if ( comments_open() ) { ?>
				<div class="loop-entry-meta-comments">
					<span class="fa fa-comments"></span><?php comments_popup_link( __( '0 Comments', 'spartan' ), __( '1 Comment',  'spartan' ), __( '% Comments', 'spartan' ), 'comments-link' ); ?>
				</div>
			<?php } ?>
		<?php
		} // END switch
	} // End foreach ?>
</div><!-- .loop-entry-meta -->