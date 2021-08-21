<?php
/**
 * Popup Notices for WooCommerce (TTT) - Admin Settings
 *
 * @version 1.0.1
 * @since   1.0.1
 * @author  Thanks to IT
 */

namespace ThanksToIT\PNWC\Pro;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'ThanksToIT\PNWC\Pro\Admin_Settings' ) ) {

	class Admin_Settings {

		/**
		 * init.
		 *
		 * @version 1.3.0
		 * @since   1.3.0
		 *
		 * @param $settings
		 *
		 * @return mixed
		 */
		function init( $settings ) {
			$settings = $this->handle_admin_settings( $settings );
			return $settings;
		}

		/**
		 * handle_admin_settings.
		 *
		 * @version 1.3.0
		 *
		 * @param $settings
		 *
		 * @return mixed
		 */
		public function handle_admin_settings( $settings ) {
			$index                         = key( wp_list_filter( $settings, array( 'id' => 'ttt_pnwc_opt_fa' ) ) );
			$settings[ $index ]['default'] = 'yes';

			// Multiline fields
			foreach ( $settings as $key => $field ) {
				if ( isset( $field['premium_multiline_field'] ) && $field['premium_multiline_field'] === true ) {
					$settings[ $key ]['type']     = 'textarea';
					$settings[ $key ]['desc_tip'] = ! isset( $settings[ $key ]['desc_tip'] ) ? '' : $settings[ $key ]['desc_tip'];
					$settings[ $key ]['desc_tip'] = str_replace( __( 'Add multiple messages on pro version.', 'popup-notices-for-woocommerce' ), '', $settings[ $key ]['desc_tip'] );
					$settings[ $key ]['desc_tip'] .= ' ' . __( 'Add each value on a separate line.', 'popup-notices-for-woocommerce' );
				}
			}

			/*$index                                   = key( wp_list_filter( $settings, array( 'id' => 'ttt_pnwc_opt_hide_default_notices' ) ) );
			$settings[ $index ]['desc_tip']          = apply_filters( 'ttt_pnwc_license_data', '', 'premium_info' );
			$settings[ $index ]['custom_attributes'] = apply_filters( 'ttt_pnwc_license_data', '', 'disabled_attribute' );*/
			//error_log(print_r($settings,true));
			return $settings;
		}
	}
}