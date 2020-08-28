<?php
/**
 * Fixes HTTPS issues with  wp_get_attachment_url()
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_get_attachment_url
 * https://github.com/syamilmj/Aqua-Resizer/issues/21
 *
 * @package WordPress
 * @subpackage Spartan
 * @since Spartan 1.0
*/

if ( ! function_exists( 'wpex_honor_ssl_for_attachments' ) ) {
	function wpex_honor_ssl_for_attachments($url) {
		$http = site_url(FALSE, 'http');
		$https = site_url(FALSE, 'https');
		$isSecure = false;
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
		|| $_SERVER['SERVER_PORT'] == 443) {
			$isSecure = true;
		}
		return ( $isSecure ) ? str_replace($http, $https, $url) : $url;
	}
}
add_filter('wp_get_attachment_url', 'wpex_honor_ssl_for_attachments');