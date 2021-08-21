<?php
/**
 * Popup Notices for WooCommerce (TTT) - Core Class
 *
 * @version 1.2.9
 * @since   1.0.0
 * @author  Thanks to IT
 */

namespace ThanksToIT\PNWC\Pro;


use ThanksToIT\PNWC\Pro\Admin_Settings\Messages_Section;
use ThanksToIT\PNWC\Template;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'ThanksToIT\PNWC\Pro\Core' ) ) {

	class Core {

		public $plugin_info = array();

		/**
		 * Call this method to get singleton
		 * @return Core
		 */
		public static function instance() {
			static $instance = false;
			if ( $instance === false ) {
				$instance = new static();
			}

			return $instance;
		}

		/**
		 * Setups plugin
		 *
		 * @version 1.0.0
		 * @since 1.0.0
		 *
		 * @param $args
		 */
		public function setup( $args ) {
			$args = wp_parse_args( $args, array(
				'path' => '' // __FILE__
			) );

			$this->plugin_info = $args;
		}

		/**
		 * Gets plugin url
		 *
		 * @version 1.0.0
		 * @since 1.0.0
		 *
		 * @return string
		 */
		public function get_plugin_url() {
			$path = $this->plugin_info['path'];

			return plugin_dir_url( $path );
		}

		/**
		 * Gets plugins dir
		 *
		 * @version 1.0.0
		 * @since 1.0.0
		 *
		 * @return string
		 */
		public function get_plugin_dir() {
			$path = $this->plugin_info['path'];

			return untrailingslashit( plugin_dir_path( $path ) ) . DIRECTORY_SEPARATOR;;
		}

		/**
		 * Initializes
		 *
		 * @version 1.1.5
		 * @since 1.0.0
		 *
		 * @return Core
		 */
		public function init() {
			$this->set_admin();

			if ( 'yes' === get_option( 'ttt_pnwc_opt_enable', 'yes' ) ) {
				add_action( 'ttt_pnwc_license_data', array( $this, 'override_free_license_data' ), 10, 2 );

				add_filter( 'ttt_pnwc_localize_script', array( $this, 'localize_cookie_opt' ) );
				add_filter( 'ttt_pnwc_localize_script', array( $this, 'localize_audio_opt' ) );
				add_filter( 'ttt_pnwc_localize_script', array( $this, 'localize_ignore_opt' ) );
				add_filter( 'ttt_pnwc_localize_script', array( $this, 'localize_auto_close' ) );

				//add_filter( 'script_loader_src', array( $this, 'overwrite_js_src' ), 10, 2 );
				//add_filter( 'ttt_pnwc_localize_script', array( $this, 'localize_ajax_opt' ) );

				// Customizer
				if ( 'yes' === get_option( 'ttt_pnwc_opt_style_enabled', 'yes' ) ) {
					add_action( 'customize_register', array( $this, 'init_customizer' ) );
					add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_style' ) );
					add_action( 'ttt_pnwc_localize_script', array( $this, 'handle_popup_icon_css' ) );
				}

				// Hide WooCommerce Notices
				add_action( 'wp_enqueue_scripts', array( $this, 'hide_woocommerce_notices' ) );

				//add_action( 'ttt_pnwc_localize_script', array( $this, 'handle_popup_icon_css' ) );

				// Modal Template
				add_filter( 'ttt_pnwc_modal_template', array( $this, 'get_template_from_admin_settings' ) );

				// Adds Iconpicker control
				add_action( 'admin_init', array( $this, 'add_iconpicker_control' ) );

				// Load Font Awesome
				add_action( 'wp_enqueue_scripts', array( $this, 'load_font_awesome' ) );

				// Close button - Internal
				add_action( 'ttt_pnwc_footer_content', array( $this, 'handle_internal_button_template' ) );

				// Prevent Scrolling
				add_action( 'wp_footer', array( $this, 'prevent_scrolling' ) );

				// Add Messages Settings Section on Admin
				add_filter( 'woocommerce_get_sections_ttt-pnwc', function ( $sections ) {
					$sections['messages'] = __( 'Messages', 'popup-notices-for-woocommerce' );
					return $sections;
				} );
				add_filter( 'ttt_pnwc_settings_messages', function ( $settings ) {
					$messages_section = new Messages_Section();
					$settings         = $messages_section->get_settings( $settings );
					return $settings;
				} );

				// Customize Messages
                $message_customizer = new Message_Customizer();
                $message_customizer->init();

                // Restrictive Loading
                $restrictive_loading = new Restrictive_Loading();

                // Enqueue admin scripts
				add_action( 'admin_enqueue_scripts', array($this,'enqueue_admin_scripts') );
			}
		}

		function enqueue_admin_scripts() {
			if (
				! isset( $_GET['tab'] )
				|| 'ttt-pnwc' != $_GET['tab']
			) {
				return;
			}
			?>
			<style>
			.ttt-pnwc-list-a{
				list-style: inside;
			}
			</style>
			<?php
		}

		/**
         * get_hidden_notices_selector.
         *
		 * @version 1.1.5
		 * @since   1.1.5
		 */
		function get_hidden_notices_selector() {
			$error_notice_selector   = apply_filters( 'ttt_pnwc_notice_selector', '.woocommerce-error', 'error_wrapper' );
			$success_notice_selector = apply_filters( 'ttt_pnwc_notice_selector', '.woocommerce-message', 'success' );
			$info_notice_selector    = apply_filters( 'ttt_pnwc_notice_selector', '.woocommerce-info', 'info' );
			$notices_style_arr       = array();
			if ( 'yes' === get_option( 'ttt_pnwc_opt_hide_error_enable', 'no' ) ) {
				$notices_style_arr[] = $error_notice_selector;
			}
			if ( 'yes' === get_option( 'ttt_pnwc_opt_hide_success_enable', 'no' ) ) {
				$notices_style_arr[] = $success_notice_selector;
			}
			if ( 'yes' === get_option( 'ttt_pnwc_opt_hide_info_enable', 'no' ) ) {
				$notices_style_arr[] = $info_notice_selector;
			}
			if ( count( $notices_style_arr ) > 0 ) {
				$style = implode( ", ", $notices_style_arr );
				return $style;
			}
			return '';
		}

		/**
		 * Prevents Scrolling.
		 *
		 * @version 1.1.5
		 * @since   1.0.9
		 */
		function prevent_scrolling() {
			if ( 'no' === get_option( 'ttt_pnwc_opt_prevent_scroll', 'no' ) ) {
				return;
			}
			?>
            <script>
				jQuery(document).ajaxComplete(function () {
					if (jQuery('body').hasClass('woocommerce-checkout') || jQuery('body').hasClass('woocommerce-cart')) {
						jQuery('html, body').stop();
					}
				});
            </script>
			<?php
		}

		/**
		 * localize_cookie_opt
		 *
		 * @version 1.0.8
		 * @since   1.0.8
		 *
		 * @param $data
		 *
		 * @return mixed
		 */
		public function localize_cookie_opt( $data ) {
			$data['cookie_opt']['enabled']        = get_option( 'ttt_pnwc_opt_cookie_enabled', 'no' );
			$data['cookie_opt']['time']           = get_option( 'ttt_pnwc_opt_cookie_time', 0.5 );
			$data['cookie_opt']['message_origin'] = get_option( 'ttt_pnwc_opt_cookie_msg_origin', 'static' );
			return $data;
		}

		/**
		 * localize_auto_close.
		 *
		 * @version 1.2.7
		 * @since   1.2.3
		 *
		 * @param $data
		 *
		 * @return mixed
		 */
		public function localize_auto_close( $data ) {
			$data['auto_close_time'] = filter_var( get_option( 'ttt_pnwc_opt_auto_close_time', 0 ), FILTER_SANITIZE_NUMBER_INT );
			$data['auto_close_types'] = get_option( 'ttt_pnwc_opt_auto_close_types', array() );
			return $data;
		}

		/**
		 * localize_ignore_opt
		 *
		 * @version 1.0.8
		 * @since   1.0.8
		 * @param $data
		 *
		 * @return mixed
		 */
		public function localize_ignore_opt( $data ) {
			$ignored_messages_field             = html_entity_decode( get_option( 'ttt_pnwc_opt_ignore_msg_field', '<p></p>' ) );
			$data['ignored_msg']['field']       = ! empty( $ignored_messages_field ) ? explode( "\n", str_replace( "\r", "", $ignored_messages_field ) ) : '';
			//$data['ignored_msg']['regex']       = get_option( 'ttt_pnwc_opt_ignore_msg_regex', 'no' );
			//$data['ignored_msg']['regex_flags'] = get_option( 'ttt_pnwc_opt_ignore_msg_regex_f', 'i' );
			return $data;
		}

		/**
		 * localize_audio_opt
		 * @version 1.0.8
		 * @since   1.0.8
		 *
		 * @param $data
		 *
		 * @return mixed
		 */
		public function localize_audio_opt( $data ) {
			$data['audio']['enabled'] = get_option( 'ttt_pnwc_opt_audio_enable', 'no' );
			$data['audio']['opening'] = get_option( 'ttt_pnwc_opt_audio_opening', '' );
			$data['audio']['closing'] = get_option( 'ttt_pnwc_opt_audio_closing', '' ); //'http://freesound.org/data/previews/220/220170_4100837-lq.mp3';
			return $data;
		}

		/**
		 * handle_internal_button_template.
		 *
		 * @version 1.2.9
		 *
		 * @param $footer_content
		 *
		 * @return string
		 */
		public function handle_internal_button_template( $footer_content ) {
			$close_btn_internal    = get_option( 'ttt_pnwc_closebtn_int' );
			$close_btn_int_content = isset( $close_btn_internal['content'] ) ? $close_btn_internal['content'] : false;
			$close_btn_internal    = get_option( 'ttt_pnwc_closebtn_int' );
			$close_btn             = isset( $close_btn_internal['display'] ) ? $close_btn_internal['display'] : false;
			if ( $close_btn !== false ) {
				$footer_content .= '<button class="ttt-pnwc-close-internal" aria-label="Close modal" data-micromodal-close>' . esc_html( $close_btn_int_content ) . '</button>';
			}
			return $footer_content;
		}

		public function load_font_awesome() {
			$font_awesome_url = get_option( 'ttt_pnwc_opt_fa_url', '//use.fontawesome.com/releases/v5.5.0/css/all.css' );
			if ( ! empty( $font_awesome_url ) && "yes" === get_option( 'ttt_pnwc_opt_fa', 'yes' ) ) {
				wp_enqueue_style( 'wpfaipc-fontawesome-frontend', $font_awesome_url );
			}
		}

		public function handle_popup_icon_css( $obj ) {
			$customizer = new Customizer();
			return $customizer->handle_popup_icon_css( $obj );
		}

		public function add_iconpicker_control() {
			//new Test();
			//new Test();
			//new IconPicker_Control\TM_Customize_Iconpicker_Control();
		}

		/**
		 * Gets modal template from admin settings
		 *
		 * @version 1.0.6
		 * @since   1.0.6
		 *
		 * @param $template
		 *
		 * @return mixed|void
		 */
		public function get_template_from_admin_settings( $template ) {
			$template_obj   = new Template();
			$admin_template = get_option( 'ttt_pnwc_opt_modal_template', $template_obj->get_default_template() );
			//$admin_template = $template_obj->replace_template_variables();
			return $admin_template;
		}

		/**
		 * Adds customizer style
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function add_customizer_style() {
			$customizer = new Customizer();
			$customizer->add_style();
		}

		/**
		 * init_customizer
		 *
		 * @version 1.0.1
		 * @since   1.0.1
		 *
		 * @param $wp_customize
		 */
		function init_customizer( $wp_customize ) {
			$customizer = new Customizer();
			$customizer->create_admin_components( $wp_customize );
			add_action( 'customize_controls_print_scripts', array( $this, 'add_customizer_scripts' ) );
		}

		/**
		 * Manages Customizer scripts
		 *
		 * @version 1.0.1
		 * @since   1.0.1
		 *
		 */
		public function add_customizer_scripts() {
			$customizer = new Customizer();
			$customizer->manage_scripts();
		}

		/**
		 * Hides default WooCommerce Notices
		 *
		 * @version 1.1.6
		 * @since 1.0.0
		 */
		public function hide_woocommerce_notices() {
			$notices_selector = $this->get_hidden_notices_selector();
			if ( ! empty( $notices_selector ) ) {
				$style = $notices_selector . "{display:none !important}";
				wp_add_inline_style( 'ttt-pnwc', $style );
			}
		}

		/**
		 * Passes the Ajax option to javascript
		 *
		 * @version 1.0.0
		 * @since 1.0.0
		 *
		 * @param $data
		 *
		 * @return mixed
		 */
		public function localize_ajax_opt( $data ) {
			$data['ajax_opt'] = get_option( 'ttt_pnwc_opt_ajax', 'no' );

			return $data;
		}

		/**
		 * Overwrites main js url
		 *
		 * @version 1.0.0
		 * @since 1.0.0
		 *
		 * @param $src
		 * @param $handle
		 *
		 * @return string
		 */
		public function overwrite_js_src( $src, $handle ) {
			if ( $handle == 'ttt-pnwc' ) {
				$pro_plugin = \ThanksToIT\PNWC\Pro\Core::instance();
				$suffix     = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
				$plugin_dir = $pro_plugin->get_plugin_dir();
				$plugin_url = $pro_plugin->get_plugin_url();

				// Main js file
				$js_file = 'src/assets/dist/frontend/js/ttt-pnwc-pro' . $suffix . '.js';
				$js_ver  = date( "ymd-Gis", filemtime( $plugin_dir . $js_file ) );
				$src     = $plugin_url . $js_file . '?ver=' . $js_ver;
			}

			return $src;
		}

		/**
		 * Overwrites free license data
		 *
		 * @version 1.0.0
		 * @since 1.0.0
		 *
		 * @param $value
		 * @param string $data_type
		 *
		 * @return string
		 */
		public function override_free_license_data( $value, $data_type = 'is_free' ) {
			switch ( $data_type ) {
				case 'disabled_attribute':
					$value = '';
				break;
				case 'premium_info':
					$value = '';
				break;
				default:
					$value = false;
				break;
			}

			return $value;
		}

		/**
		 * Sets admin
		 * @version 1.0.0
		 * @since 1.0.0
		 */
		private function set_admin() {
			add_filter( 'ttt_pnwc_settings_general', array( $this, 'handle_admin_settings' ), PHP_INT_MAX );

			// Add settings link on plugins page
			$path = $this->plugin_info['path'];
			add_filter( 'plugin_action_links_' . plugin_basename( $path ), array( $this, 'add_action_links' ) );
		}

		/**
         * handle_admin_settings.
         *
         * @version 1.1.8
         * @since   1.1.7
         *
		 */
		public function handle_admin_settings( $settings ) {
            $admin_settings_class = new Admin_Settings();
            $settings = $admin_settings_class->init($settings);
			//$settings[] = new Admin_Settings();
			//error_log(print_r($settings,true));
			return $settings;
		}

		/**
		 * Adds action links
		 *
		 * @version 1.0.1
		 * @since 1.0.0
		 *
		 * @param $links
		 *
		 * @return array
		 */
		public function add_action_links( $links ) {
			$query                     = array();
			$query['autofocus[panel]'] = 'ttt_pnwc';
			$panel_link                = add_query_arg( $query, admin_url( 'customize.php' ) );
			$mylinks                   = array(
				'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=ttt-pnwc' ) . '">Settings</a>',
				'<a href="' . $panel_link . '">Custom Style</a>',
			);

			return array_merge( $mylinks, $links );
		}
	}
}