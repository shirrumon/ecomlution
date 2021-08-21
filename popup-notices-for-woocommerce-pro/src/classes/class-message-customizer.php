<?php
/**
 * Popup Notices for WooCommerce (TTT) - Message Customizer
 *
 * @version 1.3.2
 * @since   1.1.5
 * @author  Thanks to IT
 */

namespace ThanksToIT\PNWC\Pro;

use ThanksToIT\WPFAIPC\IconPicker_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'ThanksToIT\PNWC\Pro\Message_Customizer' ) ) {

	class Message_Customizer {

		public $_messages = array();
		public $shortcode_texts = array();

		/**
		 * init.
		 *
		 * @version 1.3.2
		 * @since   1.0.0
		 */
		function init() {
			// Filters for Regular HTML Content
			add_filter( 'woocommerce_add_error', array( $this, 'customize_message' ), 10 );
			add_filter( 'woocommerce_add_success', array( $this, 'customize_message' ), 10 );
			add_filter( 'woocommerce_add_notice', array( $this, 'customize_message' ), 10 );

			add_filter( 'init', array( $this, 'add_filters_from_ttt_pnwc_get_message_shortcode' ), 10 );

			// Filters for Specific Messages
			//add_filter( 'wc_add_to_cart_message_html', array( $this, 'customize_message' ), 10, 2 );
			//add_filter( 'woocommerce_checkout_coupon_message', array( $this, 'customize_message' ), 10 );

			// Try to modify translated strings
			add_filter( 'gettext', array( $this, 'customize_translated_text' ), 10, 3 );

			add_shortcode('ttt_pnwc_get_message',array($this,'ttt_pnwc_get_message'));
		}

		/**
		 * ttt_pnwc_get_message.
		 *
		 * @version 1.3.2
		 * @since   1.3.2
		 *
		 * @param $atts
		 *
		 * @return string
		 */
		function ttt_pnwc_get_message( $atts ) {
			$atts = shortcode_atts( array(
				'filter' => '',
			), $atts );
			if ( ! empty( $atts['filter'] ) ) {
				add_filter( $atts['filter'], array( $this, 'get_shortcode_texts' ), 10, 10 );
				if ( isset( $this->shortcode_texts[ $atts['filter'] ]['content'] ) ) {
					return $this->shortcode_texts[ $atts['filter'] ]['content'];
				}
			}
			return '';
		}

		/**
		 * get_shortcode_texts.
		 *
		 * @version 1.3.2
		 * @since   1.3.2
		 *
		 * @param $text
		 *
		 * @return mixed
		 */
		function get_shortcode_texts( $text ) {
			$this->shortcode_texts[ current_filter() ]['content'] = $text;
			$this->shortcode_texts[ current_filter() ]['args'] = func_get_args();
			return $text;
		}

		/**
		 * add_filters_from_ttt_pnwc_get_message_shortcode.
		 *
		 * @version 1.3.2
		 * @since   1.3.2
		 */
		function add_filters_from_ttt_pnwc_get_message_shortcode() {
			if (
				is_admin()
				|| 'yes' !== get_option( 'ttt_pnwc_opt_message_customization_shortcodes_original_content', 'yes' )
			) {
				return;
			}
			$messages        = $this->get_messages();
			$messages_amount = get_option( 'ttt_pnwc_opt_message_customization_amount', 1 );
			for ( $i = 1; $i <= $messages_amount; $i ++ ) {
				if ( 'no' === $messages[ $i ]['enabled'] ) {
					continue;
				}
				do_shortcode( $messages[ $i ]['original_msg'] );
			}
		}

		/**
		 * customize_translated_text.
		 *
		 * @version 1.2.1
		 * @since   1.2.0
		 *
		 * @param $translation
		 * @param $text
		 * @param $domain
		 *
		 * @return string
		 */
		function customize_translated_text( $translation, $text, $domain ) {
			if (
				is_admin() ||
				'no' === get_option( 'ttt_pnwc_opt_message_customization_enable', 'no' ) ||
				'no' === get_option( 'ttt_pnwc_opt_message_customization_gettext', 'no' )
			) {
				return $translation;
			}
			$modified_text = $this->customize_message( $text );
			if ( $modified_text != $text ) {
				$translation = wp_strip_all_tags( $modified_text );
			}
			return $translation;
		}

		/**
		 * get_params_from_filter
		 *
		 * @version 1.3.2
		 * @since   1.3.2
		 *
		 * @param $filter
		 *
		 * @return mixed
		 */
		function get_params_from_filter( $filter ) {
			return $this->shortcode_texts[ $filter ]['args'];
		}

		/**
		 * get_filter_by_original_msg.
		 *
		 * @version 1.3.2
		 * @since   1.3.2
		 *
		 * @param $original_msg
		 *
		 * @return bool|int|null|string
		 */
		function get_filter_by_original_msg( $original_msg ) {
			if ( count( $result = wp_list_filter( $this->shortcode_texts, array( 'content' => $original_msg ) ) ) == 0 ) {
				return false;
			}
			reset( $result );
			$first_key = key( $result );
			return $first_key;
		}

		/**
		 * replace_variables.
		 *
		 * @version 1.3.2
		 * @since   1.1.5
		 *
		 * @param $text
		 * @param $params
		 *
		 * @return mixed|string
		 */
		function replace_variables( $text, $original_msg ) {
			$replace_array = array(
				"{{cart_permalink}}"      => esc_url( wc_get_page_permalink( 'cart' ) ),
				"{{myaccount_permalink}}" => esc_url( wc_get_page_permalink( 'myaccount' ) ),
				"{{shop_permalink}}"      => esc_url( wc_get_page_permalink( 'shop' ) ),
				"{{checkout_permalink}}"  => esc_url( wc_get_page_permalink( 'checkout' ) ),
				"{{terms_permalink}}"     => esc_url( wc_get_page_permalink( 'terms' ) )
			);
			$filter = $this->get_filter_by_original_msg( $original_msg );
			if ( false !== $filter ) {
				$params        = $this->get_params_from_filter( $filter );
				$replace_array = array_merge( $replace_array, $this->get_dynamic_template_variables( $params ) );
			}
			return str_replace(
				array_keys( $replace_array ),
				array_values( $replace_array ),
				$text
			);
		}

		/**
		 * get_title_from_param.
		 *
		 * @version 1.3.2
		 * @since   1.3.2
		 *
		 * @param $param
		 *
		 * @return string
		 */
		function get_title_from_param( $param ) {
			$title = '';
			if ( is_array( $param ) ) {
				$titles = array_map( 'get_the_title', array_keys( $param ) );
				$title  = wc_format_list_of_items( $titles );
			} elseif ( is_object( $param ) ) {
				$title = get_the_title( $param );
				if ( empty( $title ) && false !== strpos( get_class( $param ), 'WC_Product' ) ) {
					$title = $param->get_title();
				}
			} elseif ( is_int( $param ) ) {
				$title = get_the_title( $param );
			}
			return $title;
		}

		/**
		 * replace_post_id_variables.
		 *
		 * @version 1.3.2
		 * @since   1.3.2
		 *
		 * @return mixed
		 */
		function get_dynamic_template_variables( $params ) {
			$replace_array     = array();
			$post_title_result = '';
			for ( $i = 1; $i < count( $params ); $i ++ ) {
				$post_title_result = $this->get_title_from_param( $params[ $i ] );
				if ( ! empty( $post_title_result ) ) {
					break;
				}
			}
			if ( ! empty( $post_title_result ) ) {
				$replace_array["{{post_title}}"] = $post_title_result;
			}
			return $replace_array;
		}

		/**
		 * get_messages.
		 *
		 * @version 1.3.2
		 * @since   1.1.5
		 *
		 * @return array
		 */
		function get_messages() {
			if ( count( $this->_messages ) == 0 ) {
				$messages_amount    = get_option( 'ttt_pnwc_opt_message_customization_amount', 1 );
				$enabled_opt        = get_option( "ttt_pnwc_opt_message_enabled", array() );
				$comparison_opt     = get_option( "ttt_pnwc_opt_message_comparison_method", array() );
				$replace_opt        = get_option( "ttt_pnwc_opt_message_replace_method", array() );
				$remove_opt         = get_option( "ttt_pnwc_opt_message_remove", array() );
				$original_opt       = get_option( "ttt_pnwc_opt_message_original", array() );
				$modified_opt       = get_option( "ttt_pnwc_opt_message_modified", array() );
				$content_before_opt = get_option( "ttt_pnwc_opt_message_content_before", array() );
				$content_after_opt  = get_option( "ttt_pnwc_opt_message_content_after", array() );
				for ( $i = 1; $i <= $messages_amount; $i ++ ) {
					$this->_messages[ $i ] = array(
						'enabled'           => isset( $enabled_opt[ $i ] ) ? $enabled_opt[ $i ] : 'yes',
						'comparison_method' => isset( $comparison_opt[ $i ] ) ? $comparison_opt[ $i ] : 'contains',
						'replace_method'    => isset( $replace_opt[ $i ] ) ? $replace_opt[ $i ] : 'replace_everything',
						'remove'            => isset( $remove_opt[ $i ] ) ? $remove_opt[ $i ] : 'no',
						'original_msg'      => isset( $original_opt[ $i ] ) ? $original_opt[ $i ] : ( $i == 1 ? __( 'Please read and accept the terms and conditions to proceed with your order.', 'woocommerce' ) : '' ),
						'modified_msg'      => isset( $modified_opt[ $i ] ) ? $modified_opt[ $i ] : '',
						'content_before'    => isset( $content_before_opt[ $i ] ) ? $content_before_opt[ $i ] : '',
						'content_after'     => isset( $content_after_opt[ $i ] ) ? $content_after_opt[ $i ] : ( $i == 1 ? '<div style="text-align:center"><button data-micromodal-close class="enable-terms-checkbox">Accept</button></div>' : '' )
					);
				}
			}
			return $this->_messages;
		}

		/**
		 * customize_message.
		 *
		 * @version 1.3.2
		 * @since   1.1.1
		 *
		 * @param $text
		 *
		 * @return string
		 */
		function customize_message( $text ) {
			if (
				is_admin() ||
				'no' === get_option( 'ttt_pnwc_opt_message_customization_enable', 'no' )
			) {
				return $text;
			}
			$modified_content_allows_shortcode = 'yes' === get_option( 'ttt_pnwc_opt_message_customization_shortcodes', 'yes' );
			$original_content_allows_shortcode = 'yes' === get_option( 'ttt_pnwc_opt_message_customization_shortcodes_original_content', 'yes' );
			$messages_amount                   = get_option( 'ttt_pnwc_opt_message_customization_amount', 1 );
			$content_wrapper_tag               = get_option( 'ttt_pnwc_opt_message_customization_content_tag', 'div' );
			$content_class                     = 'yes' === get_option( 'ttt_pnwc_opt_message_customization_smart_content', 'yes' ) ? 'ttt-smart-additional-content' : '';
			$messages                          = $this->get_messages();
			$text_sanitized                    = wp_kses( html_entity_decode( $text ), wp_kses_allowed_html( 'post' ) );
			for ( $i = 1; $i <= $messages_amount; $i ++ ) {
				if ( 'no' === $messages[ $i ]['enabled'] ) {
					continue;
				}
				$original_msg = $messages[ $i ]['original_msg'];
				if ( $original_content_allows_shortcode ) {
					remove_filter( 'the_content', 'wpautop' );
					$original_msg = apply_filters( 'the_content', $original_msg );
				}
				$original_msg_sanitized = wp_kses( html_entity_decode( $original_msg ), wp_kses_allowed_html( 'post' ) );
				if (
					( 'equality' == $messages[ $i ]['comparison_method'] && $original_msg_sanitized == $text_sanitized )
					||
					( 'contains' == $messages[ $i ]['comparison_method'] && ! empty( $original_msg_sanitized ) && false !== strpos( $text_sanitized, $original_msg_sanitized ) )
				) {
					//Remove
					if ( 'yes' === $messages[ $i ]['remove'] ) {
						return '';
					}
					//Replace
					$replace = html_entity_decode( $messages[ $i ]['modified_msg'] );
					if ( ! empty( $replace ) ) {
						$text = $replace;
					}
					//Content Before
					$content_before = html_entity_decode( $messages[ $i ]['content_before'] );
					if ( ! empty( $content_before ) ) {
						$text = "<{$content_wrapper_tag} class='{$content_class} ttt-pnwc-before'>" . $content_before . "</{$content_wrapper_tag}>" . $text;
					}
					//Content After
					$content_after = html_entity_decode( $messages[ $i ]['content_after'] );
					if ( ! empty( $content_after ) ) {
						$text = $text . "<{$content_wrapper_tag} class='{$content_class} ttt-pnwc-after'>" . $content_after . "</{$content_wrapper_tag}>";
					}
					$text = $this->replace_variables( $text, $original_msg );
					$text = wp_kses( $text, wp_kses_allowed_html( 'post' ) );
					if ( $modified_content_allows_shortcode ) {
						remove_filter( 'the_content', 'wpautop' );
						$text = apply_filters( 'the_content', $text );
					}
				}
			}
			return $text;
		}
	}
}