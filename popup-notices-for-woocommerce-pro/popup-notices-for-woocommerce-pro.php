<?php
/**
 * Plugin Name: Pop-up Notices for WooCommerce Pro
 * Description: Turn your WooCommerce Notices into Popups
 * Version: 1.3.3
 * Author: Thanks to IT
 * Author URI: https://github.com/thanks-to-it
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: popup-notices-for-woocommerce
 * Domain Path: /src/languages
 * WC requires at least: 3.0.0
 * WC tested up to: 4.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

require_once "vendor/autoload.php";

// Check if WooCommerce is active
$plugin = 'woocommerce/woocommerce.php';
if (
	! in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins', array() ) ) ) &&
	! ( is_multisite() && array_key_exists( $plugin, get_site_option( 'active_sitewide_plugins', array() ) ) )
) {
	return;
}

$pro_plugin = \ThanksToIT\PNWC\Pro\Core::instance();
$pro_plugin->setup( array(
	'path' => __FILE__
) );
$pro_plugin->init();