<?php

namespace ThanksToIT\WPFAIPC;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'ThanksToIT\WPFAIPC\IconPicker_Control' ) ) {

	class IconPicker_Control extends \WP_Customize_Control {

		protected $base_url = '';
		protected $directory_name = 'wp-fontawesome-iconpicker-control';
		protected $iconpicker_options = array( "hideOnSelect" => true);

		public function __construct( \WP_Customize_Manager $manager, $id, array $args = array() ) {
			if ( isset( $args['options'] ) ) {
				$this->iconpicker_options = wp_parse_args( $args['options'], $this->iconpicker_options );
			}
			if ( isset( $args['directory_name'] ) ) {
				$this->directory_name = $args['directory_name'];
			}
			if ( isset( $args['base_url'] ) ) {
				$this->base_url = $args['base_url'] . "/" . $this->directory_name;
			} else {
				$this->base_url = plugin_dir_url( __FILE__ );
			}
			$this->base_url .= "../";
			parent::__construct( $manager, $id, $args );
		}

		/**
		 * Render the control's content.
		 */
		public function render_content() {
			?>
            <label>
				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</span>
                <div class="wpfaipc-wrapper input-group icp-container">
                    <input data-placement="top" class="wpfaipc icp-auto" <?php $this->link(); ?>
                           value="<?php echo esc_attr( $this->value() ); ?>" type="text">
                    <span class="wpfaipc-icon input-group-addon"></span>
                </div>
            </label>
			<?php
		}

		/**
		 * Enqueue required scripts and styles.
		 */
		public function enqueue() {
			$itsjavi_url      = $this->base_url . "../vendor/itsjavi/fontawesome-iconpicker/dist";
			$font_awesome_url = "//use.fontawesome.com/releases/v5.5.0/css/all.css";
			wp_enqueue_script( 'wpfaipc-fontawesome-iconpicker', $itsjavi_url . '/js/fontawesome-iconpicker.min.js', array( 'jquery' ), '1.0.0', true );
			wp_enqueue_style( 'wpfaipc-fontawesome-iconpicker', $itsjavi_url . '/css/fontawesome-iconpicker.min.css' );
			wp_enqueue_script( 'wpfaipc-iconpicker-control', $this->base_url . '/assets/js/wpfaipc-iconpicker-control.js', array( 'jquery' ), '1.0.0', true );
			wp_enqueue_style( 'wpfaipc-iconpicker-control', $this->base_url . '/assets/css/wpfaipc-iconpicker-control.css' );
			wp_enqueue_style( 'wpfaipc-fontawesome', $font_awesome_url );
			wp_localize_script( 'wpfaipc-iconpicker-control', 'wpfaipc', array( 'opt' => $this->iconpicker_options ) );
		}

	}

}