<?php
/**
 * The template for displaying search forms.
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */
?>

<form method="get" id="searchform" class="site-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<input type="search" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php _e( 'Search...','spartan' ); ?>" />
	<button type="submit"><span class="fa fa-search"></span></button>
</form>