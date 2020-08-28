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

// Display if conditions are met
if ( 'on' !== get_post_meta( get_the_ID(), 'wpex_disable_featured_image', true )
	 && has_post_thumbnail() ) : ?>

	<div class="page-thumbnail">
		<?php the_post_thumbnail( 'full' ); ?>
	</div><!-- .page-thumbnail -->

<?php endif; ?>