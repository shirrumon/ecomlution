<?php
/**
 * Popup Notices for WooCommerce (TTT) - Functions
 *
 * @version 1.1.5
 * @since   1.1.5
 * @author  Thanks to IT
 */

namespace ThanksToIT\PNWC\Pro;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'ThanksToIT\PNWC\Pro\Functions' ) ) {

	class Functions {
		static function get_conditionals() {
			return array(
				'is_woocommerce'      => __( 'Is WooCommerce', 'popup-notices-for-woocommerce' ),
				'is_shop'             => __( 'Is Shop', 'popup-notices-for-woocommerce' ),
				'is_product_category' => __( 'Is Product Category', 'popup-notices-for-woocommerce' ),
				'is_product_tag'      => __( 'Is Product Tag', 'popup-notices-for-woocommerce' ),
				'is_product'          => __( 'Is Product', 'popup-notices-for-woocommerce' ),
				'is_cart'             => __( 'Is Cart', 'popup-notices-for-woocommerce' ),
				'is_checkout'         => __( 'Is Checkout', 'popup-notices-for-woocommerce' ),
				'is_account_page'     => __( 'Is Account Page', 'popup-notices-for-woocommerce' ),
				'is_wc_endpoint_url'  => __( 'Is WC Endpoint URL', 'popup-notices-for-woocommerce' ),
				'is_ajax'             => __( 'Is AJAX', 'popup-notices-for-woocommerce' ),
			);
		}
	}
}