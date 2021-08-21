<?php
/**
 * EU VAT for WooCommerce - Admin Section Settings
 *
 * @version 1.7.2
 * @since   1.5.0
 * @author  WPWhale
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_EU_VAT_Settings_Admin' ) ) :

class Alg_WC_EU_VAT_Settings_Admin extends Alg_WC_EU_VAT_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.5.0
	 * @since   1.5.0
	 */
	function __construct() {
		$this->id   = 'admin';
		$this->desc = __( 'Admin & Advanced', 'eu-vat-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 1.7.2
	 * @since   1.5.0
	 * @todo    [dev] (important) set "Session type" default value to "WC session (recommended)"
	 */
	function get_settings() {

		$admin_settings = array(
			array(
				'title'    => __( 'Admin Options', 'eu-vat-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_eu_vat_admin_options',
			),
			array(
				'title'    => __( 'Meta box', 'eu-vat-for-woocommerce' ),
				'desc_tip' => __( 'Adds EU VAT number summary meta box to admin order edit page.', 'eu-vat-for-woocommerce' ),
				'desc'     => __( 'Add', 'eu-vat-for-woocommerce' ),
				'id'       => 'alg_wc_eu_vat_add_order_edit_metabox',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Column', 'eu-vat-for-woocommerce' ),
				'desc_tip' => __( 'Adds EU VAT number column to admin orders list.', 'eu-vat-for-woocommerce' ),
				'desc'     => __( 'Add', 'eu-vat-for-woocommerce' ),
				'id'       => 'alg_wc_eu_vat_add_order_list_column',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_eu_vat_admin_options',
			),
		);

		$advanced_settings = array(
			array(
				'title'    => __( 'Advanced Options', 'eu-vat-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_eu_vat_advanced_options',
			),
			array(
				'title'    => __( 'Debug', 'eu-vat-for-woocommerce' ),
				'desc'     => __( 'Enable', 'eu-vat-for-woocommerce' ),
				'desc_tip' => sprintf( __( 'Log will be added to %s.', 'eu-vat-for-woocommerce' ),
					'<a href="' . admin_url( 'admin.php?page=wc-status&tab=logs' ) . '">' . __( 'WooCommerce > Status > Logs', 'eu-vat-for-woocommerce' ) . '</a>' ),
				'id'       => 'alg_wc_eu_vat_debug',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Session type', 'eu-vat-for-woocommerce' ),
				'id'       => 'alg_wc_eu_vat_session_type',
				/*'default'  => 'standard',*/
				'default'  => 'wc',
				'type'     => 'select',
				'class'    => 'wc-enhanced-select',
				'options'  => array(
					'standard' => __( 'Standard PHP session', 'eu-vat-for-woocommerce' ),
					'wc'       => __( 'WC session (recommended)', 'eu-vat-for-woocommerce' ),
				),
			),
			array(
				'title'    => __( 'Force VAT recheck on checkout', 'eu-vat-for-woocommerce' ),
				'desc'     => __( 'Enable', 'eu-vat-for-woocommerce' ),
				'id'       => 'alg_wc_eu_vat_force_checkout_recheck',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_eu_vat_advanced_options',
			),
		);

		$additional_info = array(
			array(
				'title'    => '&#8505;' . ' ' . __( 'Additional Info', 'eu-vat-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_eu_vat_additional_info',
				'desc'     => '<ul style="background-color:white;padding:10px 30px;color:black;list-style-type:square;margin-top:50px;">' .
					'<li>' . sprintf( __( 'Field ID used for EU VAT: %s.', 'eu-vat-for-woocommerce' ) , '<code>' . '_' . alg_wc_eu_vat_get_field_id() . '</code>' ) . '</li>' .
					'<li>' . sprintf( __( 'Tool for adding EU country standard VAT rates: %s.', 'eu-vat-for-woocommerce' ),
						'<a href="' . admin_url( 'tools.php?page=alg-wc-eu-vat-country-rates' ) . '">' . __( 'Tools > EU country VAT Rates', 'eu-vat-for-woocommerce' ) . '</a>' ) . '</li>' .
					'<li>' . sprintf( __( 'EU VAT report: %s.', 'eu-vat-for-woocommerce' ),
						'<a href="' . admin_url( 'admin.php?page=wc-reports&tab=taxes&report=alg_wc_eu_vat' ) . '">' . __( 'WooCommerce > Reports > Taxes > EU VAT', 'eu-vat-for-woocommerce' ) . '</a>' ) . '</li>' .
					'<li>' . sprintf( __( 'You can use shortcodes in field label, placeholder, description and all messages options, e.g.: %s.', 'eu-vat-for-woocommerce' ),
						'<a target="_blank" href="https://wpfactory.com/item/eu-vat-for-woocommerce/#alg_wc_eu_vat_translate"><code>[alg_wc_eu_vat_translate]</code></a>' ) . '</li>' .
					'<li>' . sprintf( __( 'Plugin description on %s.', 'eu-vat-for-woocommerce' ),
						'<a target="_blank" href="https://wpfactory.com/item/eu-vat-for-woocommerce/">WPFactory</a>' ) . '</li>' .
				'</ul>',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_eu_vat_additional_info',
			),
		);

		return array_merge( $admin_settings, $advanced_settings, $additional_info );
	}

}

endif;

return new Alg_WC_EU_VAT_Settings_Admin();
