<?php
/**
 * Popup Notices for WooCommerce (TTT) - Restrictive Loading Class
 *
 * @version 1.1.7
 * @since   1.1.6
 * @author  Thanks to IT
 */

namespace ThanksToIT\PNWC\Pro;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'ThanksToIT\PNWC\Restrictive_Loading\Pro' ) ) {
	class Restrictive_Loading {

		/**
		 * Restrictive_Loading constructor.
		 *
		 * @version 1.1.7
		 * @since   1.1.7
		 *
		 */
		public function __construct() {
			add_filter( 'ttt_pnwc_is_allowed_to_load', array( $this, 'is_allowed_to_load' ) );
			add_filter( 'ttt_pnwc_conditionals_options', array( 'ThanksToIT\PNWC\Pro\Functions', 'get_conditionals' ) );
		}

		/**
		 * is_allowed_to_load.
		 *
		 * @version 1.1.7
		 * @since   1.1.7
		 *
		 * @param $is_allowed
		 *
		 * @return bool
		 */
		function is_allowed_to_load( $is_allowed ) {
			$is_allowed_arr = array();

			if ( $this->need_to_check_multiple_option( 'ttt_pnwc_opt_restrictive_loading_pages' ) ) {
				$is_allowed_arr[] = $this->is_current_page_allowed();
			}
			if ( $this->need_to_check_multiple_option( 'ttt_pnwc_opt_restrictive_loading_conditionals' ) ) {
				$is_allowed_arr[] = $this->is_conditional_allowed();
			}

			if ( count( $is_allowed_arr ) > 0 && false === array_search( true, $is_allowed_arr ) ) {
				return false;
			} else {
				return true;
			}
		}

		/**
		 * need_to_check_multiple_option
		 *
		 * @version 1.1.7
		 * @since   1.1.7
		 *
		 * @param $option
		 *
		 * @return bool
		 */
		function need_to_check_multiple_option( $option ) {
			$pages_allowed = get_option( $option, array() );
			if ( empty( $pages_allowed ) || count( $pages_allowed ) == 0 ) {
				return false;
			} else {
				return true;
			}
		}

		/**
		 * is_conditional_allowed.
		 *
		 * @version 1.1.7
		 * @since   1.1.7
		 *
		 * @return bool
		 */
		function is_conditional_allowed() {
			$conditionals = get_option( 'ttt_pnwc_opt_restrictive_loading_conditionals', array() );
			$allowed      = false;
			if ( empty( $conditionals ) || count( $conditionals ) == 0 ) {
				$allowed = true;
			} else {
				foreach ( $conditionals as $conditional ) {
					$function = $conditional;
					if ( in_array( $function, array_keys( Functions::get_conditionals() ) ) ) {
						$allowed = $function();
						if ( $allowed ) {
							break;
						}
					}
				}
			}

			return $allowed;
		}

		/**
		 * is_current_page_allowed.
		 *
		 * @version 1.1.7
		 * @since   1.1.7
		 *
		 * @return mixed|void
		 */
		public function is_current_page_allowed() {
			$pages_allowed = get_option( 'ttt_pnwc_opt_restrictive_loading_pages', array() );
			$allowed       = false;
			if ( empty( $pages_allowed ) ) {
				$allowed = true;
			} else {
				if ( is_page( $pages_allowed ) ) {
					$allowed = true;
				}
			}
			return apply_filters( 'ttt_pnwc_current_page_allowed', $allowed, $pages_allowed );
		}
	}
}