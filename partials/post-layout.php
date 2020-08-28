<?php
/**
 * Single post layout
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

// Get custom fields
$disable_share = get_post_meta( get_the_ID(), 'wpex_disable_social', true ); ?>

<article class="single-post-article clr">
	<?php wpex_ad_spot( 'post-before' ); ?>
	<?php get_template_part( 'partials/post-media' ); ?>
	<?php get_template_part( 'partials/post-header' ); ?>
	<?php if ( 'on' != $disable_share && get_theme_mod( 'wpex_social_sharing_post_top', false ) ) : ?>
		<div class="social-share-top clr"><?php get_template_part( 'partials/post-share' ); ?></div>
	<?php endif; ?>
	<?php get_template_part( 'partials/post-content' ); ?>
	<?php get_template_part( 'partials/post-tags' ); ?>
	<?php if ( 'on' != $disable_share && get_theme_mod( 'wpex_social_sharing_post_bottom', true ) ) : ?>
		<div class="social-share-bottom clr"><?php get_template_part( 'partials/post-share' ); ?></div>
	<?php endif; ?>
	<?php get_template_part( 'partials/post-author' ); ?>
	<?php get_template_part( 'partials/post-pagination' ); ?>
	<?php get_template_part( 'partials/post-related' ); ?>
	<?php comments_template(); ?>
	<?php get_template_part( 'partials/post-edit' ); ?>
</article>