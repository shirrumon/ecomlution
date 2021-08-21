<?php
/**
 * Popup Notices for WooCommerce (TTT) - Admin Settings - Messages Section
 *
 * @version 1.3.2
 * @since   1.1.1
 * @author  Thanks to IT
 */

namespace ThanksToIT\PNWC\Pro\Admin_Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'ThanksToIT\PNWC\Pro\Admin_Settings\Messages_Section' ) ) {

	class Messages_Section {

		/**
		 * get_message_options.
		 *
		 * @version 1.3.2
		 * @since   1.0.0
		 *
		 * @return array
		 */
		function get_message_options() {
			$amount          = get_option( 'ttt_pnwc_opt_message_customization_amount', 1 );
			$message_options = array();
			for ( $i = 1; $i <= $amount; $i ++ ) {
				/*$values = array();
				if ( $i == 0 ) {
					$default = 'Please read and accept the terms and conditions to proceed with your order.';
				}*/

				$pretty_i = $i;

				$message_options[] = array(
					array(
						//'name' => "&nbsp;",
						'name' => "Message #$pretty_i",
						'type' => "title",
						//'desc' => "<div style=''>Message #$pretty_i</div>",
						'id'   => "ttt_pnwc_opt_message_title[{$i}]",
					),
					array(
						'type'             => 'checkbox',
						//'id'               => "ttt_pnwc_opt_message_enabled_{$i}",
						'id'               => "ttt_pnwc_opt_message_enabled[{$i}]",
						'default'          => 'yes',
						'name'             => __( 'Enable', 'popup-notices-for-woocommerce' ),
						'desc'             => __( 'Enable customization', 'popup-notices-for-woocommerce' ),
					),
					/*array(
						'type'             => 'select',
						'class'            => 'chosen_select',
						'id'               => "ttt_pnwc_opt_message_type[{$i}]",
						'name'             => __( 'Type', 'popup-notices-for-woocommerce' ),
						'desc'             => __( '', 'popup-notices-for-woocommerce' ),
						'default'          => 'regular_html_content',
						'options'          => array(
							'regular_html_content'        => __( "Regular HTML Content", 'popup-notices-for-woocommerce' ),
							'wc_add_to_cart_message_html' => __( "Add to Cart - A product has been added to your cart", 'popup-notices-for-woocommerce' ),
							'woocommerce_checkout_coupon_message' => __( "Coupon Message - Have a coupon?", 'popup-notices-for-woocommerce' ),
						),
						'css'              => 'width:100%'
					),*/
					array(
						'type'             => 'text',
						'id'               => "ttt_pnwc_opt_message_original[{$i}]",
						'allow_raw_values' => true,
						'name'             => __( 'Original HTML Content', 'popup-notices-for-woocommerce' ),
						//'name'             => __( $pretty_i . ' - ' . 'Original', 'popup-notices-for-woocommerce' ),
						'desc'             => __( '', 'popup-notices-for-woocommerce' ),
						'desc_tip'         => __( "Only needs to be filled if Type option is Regular HTML Content.", 'popup-notices-for-woocommerce' ).'<br /><br />'.__( "It's necessary to write the HTML content exactly like it is on the source code", 'popup-notices-for-woocommerce' ),
						'default'          => $i == 1 ? __( 'Please read and accept the terms and conditions to proceed with your order.', 'woocommerce' ) : '',
						'css'              => 'width:100%'
					),
					array(
						'type'             => 'text',
						'id'               => "ttt_pnwc_opt_message_modified[{$i}]",
						'allow_raw_values' => true,
						'name'             => __( 'Modified HTML Content', 'popup-notices-for-woocommerce' ),
						'desc'             => __( '', 'popup-notices-for-woocommerce' ),
						'desc_tip'         => __( 'Leave it empty to preserve the original message', 'popup-notices-for-woocommerce' ),
						'default'          => '',
						'css'              => 'width:100%'
					),
					array(
						'type'             => 'text',
						'id'               => "ttt_pnwc_opt_message_content_before[{$i}]",
						'allow_raw_values' => true,
						'name'             => __( 'Additional Content Before', 'popup-notices-for-woocommerce' ),
						'desc'             => __( '', 'popup-notices-for-woocommerce' ),
						'desc_tip'         => __( 'CSS Class "enable-terms-checkbox" checks the term checkbox and "data-micromodal-close" attribute closes the popup', 'popup-notices-for-woocommerce' ),
						'default'          => '',
						'css'              => 'width:100%'
					),
					array(
						'type'             => 'text',
						'id'               => "ttt_pnwc_opt_message_content_after[{$i}]",
						'allow_raw_values' => true,
						'name'             => __( 'Additional Content After', 'popup-notices-for-woocommerce' ),
						'desc'             => __( '', 'popup-notices-for-woocommerce' ),
						'desc_tip'         => __( 'CSS Class "enable-terms-checkbox" checks the term checkbox and "data-micromodal-close" attribute closes the popup', 'popup-notices-for-woocommerce' ),
						'default'          => $i == 1 ? '<div style="text-align:center"><button data-micromodal-close class="enable-terms-checkbox">Accept</button></div>' : '',
						'css'              => 'width:100%'
					),
					array(
						'type'     => 'select',
						'id'       => "ttt_pnwc_opt_message_comparison_method[{$i}]",
						'default'  => 'contains',
						'class'    => 'chosen_select',
						'css'      => 'width:100%',
						'desc'     => sprintf( __( 'The method used to compare the %s field with the current message.', 'popup-notices-for-woocommerce' ), '<strong>' . __( 'Original HTML Content', 'popup-notices-for-woocommerce' ) . '</strong>' ),
						'name'     => __( 'Comparison method', 'popup-notices-for-woocommerce' ),
						'desc_tip' => sprintf( __( 'Use "%s" if you just want to check part of the message.', 'popup-notices-for-woocommerce' ), __( 'Contains', 'popup-notices-for-woocommerce' ) ) . '<br />' .
						              sprintf( __( 'Use "%s" if you want to compare the full message. Probably you\'ll need to include the full HTML present on the original message if you\'re using "%1$s"', 'popup-notices-for-woocommerce' ), __( 'Equality', 'popup-notices-for-woocommerce' ) ),
						'options'  => array(
							'contains' => __( 'Contains', 'popup-notices-for-woocommerce' ),
							'equality' => __( 'Equality', 'popup-notices-for-woocommerce' )
						),
					),
					/*array(
						'type'    => 'select',
						'id'      => "ttt_pnwc_opt_message_replace_method[{$i}]",
						'default' => 'replace_everything',
						'name'    => __( 'Replace method', 'popup-notices-for-woocommerce' ),
						'options' => array(
							'replace_match' => __( 'Replace match', 'popup-notices-for-woocommerce' ),
							'replace_everything' => __( 'Replace whole content', 'popup-notices-for-woocommerce' )
						),
					),*/
					array(
						'type'             => 'checkbox',
						'id'               => "ttt_pnwc_opt_message_remove[{$i}]",
						'default'          => 'no',
						'name'             => __( 'Remove', 'popup-notices-for-woocommerce' ),
						'desc'             => __( 'Remove message', 'popup-notices-for-woocommerce' ),
						'desc_tip'         => __( 'The message will be removed from popup and also from the regular notice.', 'popup-notices-for-woocommerce' ),
					),
					array(
						'type' => 'sectionend',
						'id'   => "ttt_pnwc_opt_message_title[{$i}]"
					)
				);
			}
			return $message_options;
		}

		/**
		 * get_template_variables.
		 *
		 * @version 1.3.2
		 * @since   1.0.0
		 *
		 * @return array
		 */
		function get_template_variables() {
			return array(
				'post_title'          => __( 'Post or Product title', 'popup-notices-for-woocommerce' ),
				'cart_permalink'      => __( 'Cart permalink', 'popup-notices-for-woocommerce' ),
				'myaccount_permalink' => __( 'My account permalink', 'popup-notices-for-woocommerce' ),
				'shop_permalink'      => __( 'Shop permalink', 'popup-notices-for-woocommerce' ),
				'checkout_permalink'  => __( 'Checkout permalink', 'popup-notices-for-woocommerce' ),
				'terms_permalink'     => __( 'Terms permalink', 'popup-notices-for-woocommerce' ),
			);
		}

		/**
		 * get_template_variables_str.
		 *
		 * @version 1.3.2
		 * @since   1.0.0
		 *
		 * @return string
		 */
		function get_template_variables_str(){
			$variables = $this->get_template_variables();
			$output = '<ul class="ttt-pnwc-list-a">';
			foreach ($variables as $key=>$value){
				$output.='<li><strong>{{'.$key.'}}</strong>: '.$value.'</li>';
			}
			$output.='</ul>';
			return $output;
		}

		function get_examples_str( $examples_array ) {
			$output = '<ul class="ttt-pnwc-list-a">';
			foreach ( $examples_array as $value ) {
				$output .= '<li>' . $value . '</li>';
			}
			$output .= '</ul>';
			return $output;
		}

		/**
		 * get_settings.
		 *
		 * @version 1.3.2
		 * @since   1.0.0
		 *
		 * @param $settings
		 *
		 * @todo Inform useful filters to be used on `[ttt_pnwc_get_message]` shortcode like `wc_add_to_cart_message_html`, `woocommerce_checkout_coupon_message`, ...
		 *
		 * @return array
		 */
		public function get_settings( $settings ) {

			// Settings
			$settings = array(

				array(
					'name' => __( 'Messages Customization', 'popup-notices-for-woocommerce' ),
					'type' => 'title',
					'desc' => __( 'Customize WooCommerce messages modifying or adding more content after or before them.', 'popup-notices-for-woocommerce' ),
					'id'   => 'ttt_pnwc_opt_message_customization',
				),
				array(
					'type'    => 'checkbox',
					'id'      => 'ttt_pnwc_opt_message_customization_enable',
					'name'    => __( 'Customize Messages', 'popup-notices-for-woocommerce' ),
					'desc'    => __( 'Customize Notice messages', 'popup-notices-for-woocommerce' ),
					'default' => 'no',
				),
				array(
					'type'    => 'checkbox',
					'id'      => 'ttt_pnwc_opt_message_customization_smart_content',
					'name'    => __( 'Smart Additional Content', 'popup-notices-for-woocommerce' ),
					'desc'    => __( 'Additional Content will be visible only inside the Popup', 'popup-notices-for-woocommerce' ),
					'default' => 'yes',
				),
				array(
					'type'    => 'checkbox',
					'id'      => 'ttt_pnwc_opt_message_customization_shortcodes',
					'name'    => __( 'Shortcodes', 'popup-notices-for-woocommerce' ),
					'desc'    => __( 'Allow Shortcodes on Modified HTML Content', 'popup-notices-for-woocommerce' ),
					'checkboxgroup' => 'start',
					'default' => 'yes',
				),
				array(
					'type'          => 'checkbox',
					'id'            => 'ttt_pnwc_opt_message_customization_shortcodes_original_content',
					'name'          => __( 'Allow Shortcodes', 'popup-notices-for-woocommerce' ),
					'desc'          => __( 'Allow Shortcodes on Original HTML Content', 'popup-notices-for-woocommerce' ),
					'desc_tip'      => sprintf( __( 'You can use the %s shortcode to get dynamic messages from any filter you wish. e.g. %s.', 'popup-notices-for-woocommerce' ), '<code>' . '[ttt_pnwc_get_message]' . '</code>', '<code>' . '[ttt_pnwc_get_message filter="wc_add_to_cart_message_html"]' . '</code>' ),
					'checkboxgroup' => 'end',
					'default'       => 'yes',
				),
				array(
					'type'    => 'checkbox',
					'id'      => 'ttt_pnwc_opt_message_customization_gettext',
					'name'    => __( 'Customize Translated Text', 'popup-notices-for-woocommerce' ),
					'desc'    => __( 'Try to customize the translated text with <code>gettext</code> filter', 'popup-notices-for-woocommerce' ),
					'desc_tip'=> __( 'Only enable it if the text you want to customize is not getting modified, as it\'s slower and does not allow HTML.', 'popup-notices-for-woocommerce' ) . '<br />' . __( 'The correct way of creating a Notice in WooCommerce is using the <code>wc_add_notice()</code> or <code>WP_Error::add()</code> functions.', 'popup-notices-for-woocommerce' ) . '<br />' . __( 'If the message you want to customize is not getting modified, probably it was not created with these functions.', 'popup-notices-for-woocommerce' ),
					'default' => 'no',
				),
				array(
					'type'    => 'text',
					'id'      => 'ttt_pnwc_opt_message_customization_content_tag',
					'name'    => __( 'Additional Content Tag', 'popup-notices-for-woocommerce' ),
					'desc'    => __( 'Additional Content HTML tag', 'popup-notices-for-woocommerce' ),
					'default' => 'div',
				),
				array(
					'type'              => 'number',
					'id'                => 'ttt_pnwc_opt_message_customization_amount',
					'name'              => __( 'Total Messages', 'popup-notices-for-woocommerce' ),
					'desc'              => __( 'Total number of messages you want to customize', 'popup-notices-for-woocommerce' ),
					'custom_attributes' => array( 'min' => 1 ),
					'default'           => 1,
				),
				array(
					'type' => 'sectionend',
					'id'   => 'ttt_pnwc_opt_message_customization'
				),
				array(
					'name' => __( 'Template Variables', 'popup-notices-for-woocommerce' ),
					'type' => 'title',
					'desc' => __( 'You can use some template variables on <strong>Modified HTML Content</strong> option, but some of them may only work according to the context.', 'popup-notices-for-woocommerce' ).'<br />'.$this->get_template_variables_str(),
					'id'   => 'ttt_pnwc_opt_message_variables',
				),
				array(
					'type' => 'sectionend',
					'id'   => 'ttt_pnwc_opt_message_variables'
				),
				array(
					'name' => __( 'Examples', 'popup-notices-for-woocommerce' ),
					'type' => 'title',
					'desc' => __( 'Examples you can use on <strong>Original HTML Content</strong>.', 'popup-notices-for-woocommerce' ) .
					          $this->get_examples_str( array(
						          sprintf( __( 'Use %s to modify the %s message (%s)', 'popup-notices-for-woocommerce' ), '<code>' . '[ttt_pnwc_get_message filter="wc_add_to_cart_message_html"]' . '</code>', '<strong>' . __( 'Add to cart', 'popup-notices-for-woocommerce' ) . '</strong>', '<strong>' . __( '%s has been added to your cart.', 'woocommerce' ) . '</strong>' ),
						          sprintf( __( 'Use %s to modify the %s message (%s)', 'popup-notices-for-woocommerce' ), '<code>' . '[ttt_pnwc_get_message filter="woocommerce_cart_product_cannot_add_another_message"]' . '</code>', '<strong>' . __( 'Cannot add another', 'popup-notices-for-woocommerce' ) . '</strong>', '<strong>' . __( 'You cannot add another "%s" to your cart.', 'woocommerce' ) . '</strong>' )
					          ) ),
					'id'   => 'ttt_pnwc_opt_message_examples',
				),
				array(
					'type' => 'sectionend',
					'id'   => 'ttt_pnwc_opt_message_examples'
				),
			);

			// Messages
			$messages = wp_list_filter( $settings, array( 'id' => 'ttt_pnwc_opt_message_customization', 'type' => 'sectionend' ) );
			reset( $messages );
			$messages_index = key( $messages );
			array_splice( $settings, $messages_index + 1, 0, call_user_func_array( 'array_merge', $this->get_message_options() ) );


			return $settings;
		}
	}
}