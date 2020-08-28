<?php
/**
 * The Header for our theme.
 *
 * @package		Spartan
 * @author		Alexander Clarke
 * @copyright	Copyright (c) 2014, Symple Workz LLC
 * @link		http://www.wpexplorer.com
 * @since		1.0.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php get_template_part( 'partials/meta-viewport' ); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="wrap" class="clr">

		<?php get_template_part( 'partials/header-layout' ); ?>

		<div class="site-main-wrap clr">
		
			<div id="main" class="site-main clr container">