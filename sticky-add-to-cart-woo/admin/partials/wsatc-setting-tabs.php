<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/multi/sidebar.php');
?>
<div class="wsatc-tabs">
	<button class="tab-link active" id="visibility"><?php esc_html_e( 'Visibillity', 'woo-sticky-add-to-cart' ); ?></button>
	<button class="tab-link" id="design"><?php esc_html_e( 'Design', 'woo-sticky-add-to-cart' ); ?></button>
	<button class="tab-link" id="fonts"><?php esc_html_e( 'Fonts', 'woo-sticky-add-to-cart' ); ?></button>
	<button class="tab-link" id="configuration"><?php esc_html_e( 'Configuration', 'woo-sticky-add-to-cart' ); ?></button>
	<?php do_action( 'wsatc_setting_tab_button' ); ?>
</div>
