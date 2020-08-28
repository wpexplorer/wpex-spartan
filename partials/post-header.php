<?php
/**
 * Single post header
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
} ?>

<header class="post-header clr">
	<h1 class="post-header-title"><?php the_title(); ?></h1>
	<?php get_template_part( 'partials/post', 'meta' ); ?>
</header><!-- .page-header -->