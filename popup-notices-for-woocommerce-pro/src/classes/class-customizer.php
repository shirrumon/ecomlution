<?php
/**
 * Popup Notices for WooCommerce (TTT) - Customizer
 *
 * @version 1.2.9
 * @since   1.0.1
 * @author  Thanks to IT
 */

namespace ThanksToIT\PNWC\Pro;

use ThanksToIT\WPFAIPC\IconPicker_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'ThanksToIT\PNWC\Pro\Customizer' ) ) {

	class Customizer {

		/**
		 * @var \WP_Customize_Manager
		 */
		public $wp_customize;

		/**
		 * Manages scripts
		 *
		 * @version 1.0.6
		 * @since   1.0.1
		 *
		 */
		public function manage_scripts() {
			$plugin     = Core::instance();
			$suffix     = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '';
			$plugin_dir = $plugin->get_plugin_dir();
			$plugin_url = $plugin->get_plugin_url();

			// Main js file
			$js_file = 'src/assets/src/admin/js/ttt-pnwc-customizer' . $suffix . '.js';
			$js_ver  = date( "ymd-Gis", filemtime( $plugin_dir . $js_file ) );

		    wp_enqueue_script(
			    'ttt-pnwc-customizer',			//Give the script an ID
			    $plugin_url . $js_file,
			    array( 'jquery','customize-preview' ),	//Define dependencies
			    $js_ver,						//Define a version (optional)
			    true						//Put script in footer?
		    );
			wp_localize_script( 'ttt-pnwc-customizer', 'ttt_pnwc_customizer_info', array(
				'popup_notices_url' => esc_js( add_query_arg( array( 'ttt_pnwc' => 'info' ), get_home_url() ) )
			) );
		}

		/**
		 * Customize style
		 *
		 * @version 1.2.6
		 * @since   1.0.1
		 */
		public function add_style() {
			$general_options   = get_option( 'ttt_pnwc_c_general' );
			$close_btn_section = get_option( 'ttt_pnwc_closebtn' );

			// General Section
			$bkg_popup                    = isset( $general_options['popup_bkg_color'] ) ? $general_options['popup_bkg_color'] : '#ffffff';
			$notice_popup                 = isset( $general_options['notice_bkg_color'] ) ? $general_options['notice_bkg_color'] : '#eeeeee';
			$txt_color                    = isset( $general_options['txt_color'] ) ? $general_options['txt_color'] : '#6d6d6d';
			$link_color                   = isset( $general_options['link_color'] ) ? $general_options['link_color'] : '#347AC3';
			$link_hover_color             = isset( $general_options['link_h_color'] ) ? $general_options['link_h_color'] : '#54a9ff';
			$txt_size                     = isset( $general_options['txt_size'] ) ? $general_options['txt_size'] : 16;
			$justify_content              = isset( $general_options['justify_content'] ) ? $general_options['justify_content'] : 'center';
			$text_align                   = isset( $general_options['text_align'] ) ? $general_options['text_align'] : 'left';
			$border_color                 = isset( $general_options['b_color'] ) ? $general_options['b_color'] : '#c1c1c1';
			$border_width                 = isset( $general_options['b_width'] ) ? $general_options['b_width'] : '0';
			$border_radius                = isset( $general_options['b_radius'] ) ? $general_options['b_radius'] : '4';
			$icons_hide_small_devices     = isset( $general_options['ihosd'] ) ? $general_options['ihosd'] : false;
			$icons_hide                   = isset( $general_options['ih'] ) ? $general_options['ih'] : false;
			$rtl                          = isset( $general_options['rtl'] ) ? $general_options['rtl'] : false;
			$force                        = isset( $general_options['force'] ) ? $general_options['force'] : false;
			$icons_hide_small_devices_str = filter_var( $icons_hide_small_devices, FILTER_VALIDATE_BOOLEAN ) ? 'none !important' : 'inline-block !important';
			$icons_hide_str               = filter_var( $icons_hide, FILTER_VALIDATE_BOOLEAN ) ? 'display:none !important' : '';
			$rtl_str                      = filter_var( $rtl, FILTER_VALIDATE_BOOLEAN ) ? 'direction: rtl;' : '';

			// Close Button Section
			$close_btn_bkg      = isset( $close_btn_section['bkg_close_btn'] ) ? $close_btn_section['bkg_close_btn'] : '#ededed';
			$close_btn_color    = isset( $close_btn_section['color'] ) ? $close_btn_section['color'] : '#6d6d6d';
			$close_btn_hor_pos  = isset( $close_btn_section['hor_pos'] ) ? $close_btn_section['hor_pos'] : 'right';
			$close_btn_ver_pos  = isset( $close_btn_section['ver_pos'] ) ? $close_btn_section['ver_pos'] : 'top';
			$close_btn_hor_val  = isset( $close_btn_section['hor_val'] ) ? $close_btn_section['hor_val'] : '-23';
			$close_btn_ver_val  = isset( $close_btn_section['ver_val'] ) ? $close_btn_section['ver_val'] : '-23';
			$close_btn_b_radius = isset( $close_btn_section['b_radius'] ) ? $close_btn_section['b_radius'] : '50';

			// Icons Sections
			$success_section    = get_option( 'ttt_pnwc_success' );
			$error_section      = get_option( 'ttt_pnwc_error' );
			$info_section       = get_option( 'ttt_pnwc_info' );
			$success_icon_color = isset( $success_section['icon_color'] ) ? $success_section['icon_color'] : '#22bf21';
			$error_icon_color   = isset( $error_section['icon_color'] ) ? $error_section['icon_color'] : '#e21616';
			$info_icon_color    = isset( $info_section['icon_color'] ) ? $info_section['icon_color'] : '#347ac3';

			// Close Button - Internal
			$close_btn_internal      = get_option( 'ttt_pnwc_closebtn_int' );
			$close_btn_int_display   = isset( $close_btn_internal['display'] ) ? $close_btn_internal['display'] : false;
			$close_btn_int_bkg_color = isset( $close_btn_internal['bkg_color'] ) ? $close_btn_internal['bkg_color'] : '#cccccc';
			$close_btn_int_txt_color = isset( $close_btn_internal['txt_color'] ) ? $close_btn_internal['txt_color'] : '#000000';

			$important_force = $force==true ? '!important' : '';
			$style = "
			.ttt-pnwc-message{text-align:{$text_align}}
            .ttt-pnwc-container{background-color:{$bkg_popup};border:{$border_width}px solid {$border_color};border-radius:{$border_radius}px;$rtl_str}
            .ttt-pnwc-notice{
                font-size:{$txt_size}px;
                color:{$txt_color} !important;
                justify-content:{$justify_content};
            }
            .ttt-pnwc-notice *{color:{$txt_color} {$important_force};}
            .ttt-pnwc-notice a{color:{$link_color} {$important_force};}
            .ttt-pnwc-notice a:hover{color:{$link_hover_color} {$important_force};}
            button.ttt-pnwc-close{
                background-color:{$close_btn_bkg} !important; color:{$close_btn_color} !important;
                top:auto !important; right:auto !important;
                {$close_btn_hor_pos}:{$close_btn_hor_val}px !important; {$close_btn_ver_pos}:{$close_btn_ver_val}px !important;
                border-radius:{$close_btn_b_radius}px !important;
            }
            .ttt-pnwc-notice:after{background-color:{$notice_popup}}
            .ttt-pnwc-notice.success .ttt-pnwc-notice-icon{color:{$success_icon_color} {$important_force};}
            .ttt-pnwc-notice.error .ttt-pnwc-notice-icon{color:{$error_icon_color} {$important_force};}
            .ttt-pnwc-notice.info .ttt-pnwc-notice-icon{color:{$info_icon_color} {$important_force};}
            .ttt-pnwc-close-internal{                
                color:{$close_btn_int_txt_color} {$important_force}; background-color:{$close_btn_int_bkg_color} {$important_force};
            }                        
            @media (max-width: 550px) {
			  .ttt-pnwc-notice-icon {
			    display:{$icons_hide_small_devices_str};
			  }
			}
			.ttt-pnwc-notice-icon {{$icons_hide_str}}
            ";
			wp_add_inline_style( 'ttt-pnwc', $style );
		}

		/**
		 * @version 1.2.9
		 * @since   1.1.0
		 */
		public function handle_close_button_internal() {
			$wp_customize = $this->wp_customize;
			$section = $wp_customize->add_section( 'ttt_pnwc_closebtn_int', array(
				'title'       => __( 'Close Button - Internal', 'popup-notices-for-woocommerce' ),
				'description' => __( 'Popup Notices - Internal Close Button', 'popup-notices-for-woocommerce' ),
				'priority'    => 120,
				'panel'       => 'ttt_pnwc',
			) );
			// Close button display
			$setting = $wp_customize->add_setting( 'ttt_pnwc_closebtn_int[display]', array(
				'default'    => false,
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_closebtn_int_display', array(
				'type'     => 'checkbox',
				'label'    => __( 'Display', 'popup-notices-for-woocommerce' ),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );
			// Background color
			$setting = $wp_customize->add_setting( 'ttt_pnwc_closebtn_int[bkg_color]', array(
				'default'    => '#cccccc',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'ttt_pnwc_closebtn_int_bkg_color',
					array(
						'label'    => __( 'Background Color', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
					) )
			);
			// Text color
			$setting = $wp_customize->add_setting( 'ttt_pnwc_closebtn_int[txt_color]', array(
				'default'    => '#000000',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'ttt_pnwc_closebtn_int_txt_color',
					array(
						'label'    => __( 'Text Color', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
					) )
			);
			// Content
			$setting = $wp_customize->add_setting( 'ttt_pnwc_closebtn_int[content]', array(
				'default'    => __( 'Close', 'popup-notices-for-woocommerce' ),
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_closebtn_int_content', array(
				'type'     => 'text',
				'label'    => __( 'Content', 'popup-notices-for-woocommerce' ),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );
		}

		public function handle_close_button_external() {
			$wp_customize = $this->wp_customize;

			$section = $wp_customize->add_section( 'ttt_pnwc_closebtn', array(
				'title'       => __( 'Close Button - External', 'popup-notices-for-woocommerce' ),
				'description' => __( 'Popup Notices - External Close Button', 'popup-notices-for-woocommerce' ),
				'priority'    => 120,
				'panel'       => 'ttt_pnwc',
			) );

			// Close button Horizontal position
			$setting = $wp_customize->add_setting( 'ttt_pnwc_closebtn[hor_pos]', array(
				'default'    => 'right',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_closebtn_hor_pos', array(
				'type'     => 'select',
				'label'    => __( 'Horizontal position', 'popup-notices-for-woocommerce' ),
				'choices'  => array(
					'left'  => __( 'Left', 'popup-notices-for-woocommerce' ),
					'right' => __( 'Right', 'popup-notices-for-woocommerce' ),
				),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );

			// Close button Horizontal position value
			$setting = $wp_customize->add_setting( 'ttt_pnwc_closebtn[hor_val]', array(
				'default'    => - 23,
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_closebtn_hor_val', array(
				'type'     => 'number',
				'label'    => __( 'Horizontal position value', 'popup-notices-for-woocommerce' ),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );

			// Close button Vertical position
			$setting = $wp_customize->add_setting( 'ttt_pnwc_closebtn[ver_pos]', array(
				'default'    => 'top',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_closebtn_ver_pos', array(
				'type'     => 'select',
				'label'    => __( 'Vertical position', 'popup-notices-for-woocommerce' ),
				'choices'  => array(
					'top'    => __( 'Top', 'popup-notices-for-woocommerce' ),
					'bottom' => __( 'Bottom', 'popup-notices-for-woocommerce' ),
				),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );

			// Close button Vertical position value
			$setting = $wp_customize->add_setting( 'ttt_pnwc_closebtn[ver_val]', array(
				'default'    => - 23,
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_closebtn_ver_val', array(
				'type'     => 'number',
				'label'    => __( 'Vertical position value', 'popup-notices-for-woocommerce' ),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );

			// Close button bkg
			$setting = $wp_customize->add_setting( 'ttt_pnwc_closebtn[bkg_close_btn]', array(
				'default'    => '#ededed',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'ttt_pnwc_closebtn_bkg_close_btn',
					array(
						'label'    => __( 'Background', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
					) )
			);

			// Close button icon color
			$setting = $wp_customize->add_setting( 'ttt_pnwc_closebtn[color]', array(
				'default'    => '#6d6d6d',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'ttt_pnwc_closebtn_color',
					array(
						'label'    => __( 'Color', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
					) )
			);

			// Close button border radius
			$setting = $wp_customize->add_setting( 'ttt_pnwc_closebtn[b_radius]', array(
				'default'    => '50',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_closebtn_b_radius', array(
				'type'     => 'number',
				'label'    => __( 'Border Radius', 'popup-notices-for-woocommerce' ),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );
		}

		public function handle_popup_icon_css( $obj ) {
			$success_section           = get_option( 'ttt_pnwc_success' );
			$default_success_icon      = "yes" === get_option( 'ttt_pnwc_opt_fa', 'yes' ) ? 'fas fa-check-circle' : '';
			$error_section             = get_option( 'ttt_pnwc_error' );
			$default_error_icon        = "yes" === get_option( 'ttt_pnwc_opt_fa', 'yes' ) ? 'fas fa-exclamation-circle' : '';
			$info_section              = get_option( 'ttt_pnwc_info' );
			$default_info_icon         = "yes" === get_option( 'ttt_pnwc_opt_fa', 'yes' ) ? 'fas fa-info-circle' : '';
			$success_icon              = isset( $success_section['icon'] ) ? $success_section['icon'] : $default_success_icon;
			$obj['success_icon_class'] = $success_icon;
			$error_icon                = isset( $error_section['icon'] ) ? $error_section['icon'] : $default_error_icon;
			$obj['error_icon_class']   = $error_icon;
			$info_icon                 = isset( $info_section['icon'] ) ? $info_section['icon'] : $default_info_icon;
			$obj['info_icon_class']    = $info_icon;
			return $obj;
		}

		/**
		 * Creates admin components
		 *
		 * @version 1.2.6
		 * @since   1.0.1
		 *
		 * @param \WP_Customize_Manager $customize
		 */
		public function create_admin_components( \WP_Customize_Manager $customize ) {
			$this->wp_customize = $customize;
			$wp_customize       = $this->wp_customize;

			$wp_customize->add_panel( 'ttt_pnwc', array(
				'priority'       => 200,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Popup Notices', 'popup-notices-for-woocommerce' ),
				'description'    => __( 'WooCommerce Popup Notices custom style', 'popup-notices-for-woocommerce' ),
			) );
			$section = $wp_customize->add_section( 'ttt_pnwc_general', array(
				'title'       => __( 'General Style', 'popup-notices-for-woocommerce' ),
				'description' => __( 'Popup Notices - General Style', 'popup-notices-for-woocommerce' ),
				'priority'    => 120,
				'panel'       => 'ttt_pnwc',
			) );

			// Popup bkg
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[popup_bkg_color]', array(
				'default'    => '#ffffff',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'ttt_pnwc_c_general_popup_bkg_color',
					array(
						'label'    => __( 'Popup background', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
					) )
			);

			// Notice bkg
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[notice_bkg_color]', array(
				'default'    => '#eeeeee',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'ttt_pnwc_c_general_notice_bkg_color',
					array(
						'label'    => __( 'Notice background', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
					) )
			);

			// Text color
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[txt_color]', array(
				'default'    => '#6d6d6d',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'ttt_pnwc_c_general_txt_color',
					array(
						'label'    => __( 'Text Color', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
					) )
			);

			// Text size
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[txt_size]', array(
				'default'    => '16',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_c_general_txt_size', array(
				'type'     => 'number',
				'label'    => __( 'Text Size', 'popup-notices-for-woocommerce' ),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );

			// Link color
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[link_color]', array(
				'default'    => '#347AC3',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'ttt_pnwc_c_general_link_color',
					array(
						'label'    => __( 'Link Color', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
					) )
			);

			// Link hover color
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[link_h_color]', array(
				'default'    => '#54a9ff',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'ttt_pnwc_c_general_link_h_color',
					array(
						'label'    => __( 'Link Hover Color', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
					) )
			);

			// Justify Content
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[justify_content]', array(
				'default'    => 'center',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_c_general_justify_content', array(
				'type'     => 'select',
				'choices'  => array(
					'flex-start'    => __( 'Flex Start', 'popup-notices-for-woocommerce' ),
					'flex-end'      => __( 'Flex End', 'popup-notices-for-woocommerce' ),
					'center'        => __( 'Center', 'popup-notices-for-woocommerce' ),
					'space-between' => __( 'Space Between', 'popup-notices-for-woocommerce' ),
					'space-around'  => __( 'Space around', 'popup-notices-for-woocommerce' ),
					'space-evenly'  => __( 'Space evenly', 'popup-notices-for-woocommerce' ),
				),
				'label'    => __( 'Justify Content', 'popup-notices-for-woocommerce' ),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );

			// Align
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[text_align]', array(
				'default'    => 'left',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_c_general_text_align', array(
				'type'     => 'select',
				'choices'  => array(
					'left'    => __( 'Left', 'popup-notices-for-woocommerce' ),
					'right'   => __( 'Right', 'popup-notices-for-woocommerce' ),
					'center'  => __( 'Center', 'popup-notices-for-woocommerce' ),
					'justify' => __( 'Justify', 'popup-notices-for-woocommerce' ),
				),
				'label'    => __( 'Text Align', 'popup-notices-for-woocommerce' ),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );

			// Border Radius
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[b_radius]', array(
				'default'    => '4',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_c_general_b_radius', array(
				'type'     => 'number',
				'label'    => __( 'Border Radius', 'popup-notices-for-woocommerce' ),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );

			// Border Width
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[b_width]', array(
				'default'    => '0',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_c_general_b_width', array(
				'type'     => 'number',
				'label'    => __( 'Border Width', 'popup-notices-for-woocommerce' ),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );

			// Border Color
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[b_color]', array(
				'default'    => '#c1c1c1',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'ttt_pnwc_c_general_b_color',
					array(
						'label'    => __( 'Border Color', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
					) )
			);

			// Icons - Hide
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[ih]', array(
				'default'    => false,
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_c_general_ih', array(
				'type'     => 'checkbox',
				'label'    => __( 'Icons - Hide', 'popup-notices-for-woocommerce' ),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );

			// Icons - Hide on Small Devices
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[ihosd]', array(
				'default'    => true,
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_c_general_ihosd', array(
				'type'     => 'checkbox',
				'label'    => __( 'Icons - Hide on Small Devices', 'popup-notices-for-woocommerce' ),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );

			// RTL
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[rtl]', array(
				'default'    => false,
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_c_general_rtl', array(
				'type'     => 'checkbox',
				'label'    => __( 'RTL - Right to Left', 'popup-notices-for-woocommerce' ),
				'section'  => $section->id,
				'settings' => $setting->id,
			) );

			// Force - Override theme settings
			$setting = $wp_customize->add_setting( 'ttt_pnwc_c_general[force]', array(
				'default'    => false,
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control( 'ttt_pnwc_c_general_force', array(
				'type'        => 'checkbox',
				'label'       => __( 'Force Settings', 'popup-notices-for-woocommerce' ),
				'description' => __( 'This will try to overwrite some of your theme style like colors', 'popup-notices-for-woocommerce' ),
				'section'     => $section->id,
				'settings'    => $setting->id,
			) );

			// Close Button
			$this->handle_close_button_external();
			$this->handle_close_button_internal();
			$this->handle_success();
			$this->handle_error();
			$this->handle_info();

			$this->wp_customize = $wp_customize;
		}

		public function handle_success() {
			$wp_customize = $this->wp_customize;

			$section = $wp_customize->add_section( 'ttt_pnwc_success', array(
				'title'       => __( 'Success Notice', 'popup-notices-for-woocommerce' ),
				'description' => __( 'Popup Notices - Success Notice Type', 'popup-notices-for-woocommerce' ),
				'priority'    => 120,
				'panel'       => 'ttt_pnwc',
			) );

			$setting = $wp_customize->add_setting( 'ttt_pnwc_success[icon]', array(
				'default'    => "yes" === get_option( 'ttt_pnwc_opt_fa', 'yes' ) ? 'fas fa-check-circle' : '',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );

			if ( "yes" === get_option( 'ttt_pnwc_opt_fa', 'yes' ) ) {
				$wp_customize->add_control( new IconPicker_Control(
					$wp_customize,
					'ttt_pnwc_success_icon',
					array(
						'label'    => __( 'Icon Class', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
						'options'  => array( 'placement' => 'bottom' )
					)
				) );
			} else {
				$wp_customize->add_control( 'ttt_pnwc_success_icon', array(
					'type'     => 'text',
					'label'    => __( 'Icon Class', 'popup-notices-for-woocommerce' ),
					'section'  => $section->id,
					'settings' => $setting->id,
				) );
			}

			$setting = $wp_customize->add_setting( 'ttt_pnwc_success[icon_color]', array(
				'default'    => '#22bf21',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'ttt_pnwc_success_icon_color',
					array(
						'label'    => __( 'Icon Color', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
					) )
			);

		}

		public function handle_error() {
			$wp_customize = $this->wp_customize;
			$section      = $wp_customize->add_section( 'ttt_pnwc_error', array(
				'title'       => __( 'Error Notice', 'popup-notices-for-woocommerce' ),
				'description' => __( 'Popup Notices - Error Notice Type', 'popup-notices-for-woocommerce' ),
				'priority'    => 120,
				'panel'       => 'ttt_pnwc',
			) );

			$setting = $wp_customize->add_setting( 'ttt_pnwc_error[icon]', array(
				'default'    => "yes" === get_option( 'ttt_pnwc_opt_fa', 'yes' ) ? 'fas fa-exclamation-circle' : '',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );

			if ( "yes" === get_option( 'ttt_pnwc_opt_fa', 'yes' ) ) {
				$wp_customize->add_control( new IconPicker_Control(
					$wp_customize,
					'ttt_pnwc_error_icon',
					array(
						'label'    => __( 'Icon Class', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
						'options'  => array( 'placement' => 'bottom' )
					)
				) );
			} else {
				$wp_customize->add_control( 'ttt_pnwc_error_icon', array(
					'type'     => 'text',
					'label'    => __( 'Icon Class', 'popup-notices-for-woocommerce' ),
					'section'  => $section->id,
					'settings' => $setting->id,
				) );
			}

			$setting = $wp_customize->add_setting( 'ttt_pnwc_error[icon_color]', array(
				'default'    => '#e21616',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'ttt_pnwc_error_icon_color',
					array(
						'label'    => __( 'Icon Color', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
					) )
			);
		}

		public function handle_info() {
			$wp_customize = $this->wp_customize;
			$section      = $wp_customize->add_section( 'ttt_pnwc_info', array(
				'title'       => __( 'Info Notice', 'popup-notices-for-woocommerce' ),
				'description' => __( 'Popup Notices - Info Notice Type', 'popup-notices-for-woocommerce' ),
				'priority'    => 120,
				'panel'       => 'ttt_pnwc',
			) );

			$setting = $wp_customize->add_setting( 'ttt_pnwc_info[icon]', array(
				'default'    => "yes" === get_option( 'ttt_pnwc_opt_fa', 'yes' ) ? 'fas fa-info-circle' : '',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );

			if ( "yes" === get_option( 'ttt_pnwc_opt_fa', 'yes' ) ) {
				$wp_customize->add_control( new IconPicker_Control(
					$wp_customize,
					'ttt_pnwc_info_icon',
					array(
						'label'    => __( 'Icon Class', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
						'options'  => array( 'placement' => 'bottom' )
					)
				) );
			} else {
				$wp_customize->add_control( 'ttt_pnwc_info_icon', array(
					'type'     => 'text',
					'label'    => __( 'Icon Class', 'popup-notices-for-woocommerce' ),
					'section'  => $section->id,
					'settings' => $setting->id,
				) );
			}

			$setting = $wp_customize->add_setting( 'ttt_pnwc_info[icon_color]', array(
				'default'    => '#347ac3',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );
			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'ttt_pnwc_info_icon_color',
					array(
						'label'    => __( 'Icon Color', 'popup-notices-for-woocommerce' ),
						'section'  => $section->id,
						'settings' => $setting->id,
					) )
			);
		}
	}
}