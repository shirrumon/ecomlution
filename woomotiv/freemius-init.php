<?php

/**
 * Freemius Init
 */
if ( !function_exists( 'wmv_fs' ) ) {
    // Create a helper function for easy SDK access.
    function wmv_fs()
    {
        global  $wmv_fs ;
        
        if ( !isset( $wmv_fs ) ) {
            // Activate multisite network integration.
            if ( !defined( 'WP_FS__PRODUCT_3507_MULTISITE' ) ) {
                define( 'WP_FS__PRODUCT_3507_MULTISITE', true );
            }
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $wmv_fs = fs_dynamic_init( array(
                'id'               => '3507',
                'slug'             => 'woomotiv',
                'type'             => 'plugin',
                'public_key'       => 'pk_c9d6b1f004fe3c448930d59d4a22d',
                'is_premium'       => false,
                'premium_suffix'   => 'Woomotiv Premium Plan',
                'has_addons'       => false,
                'has_paid_plans'   => true,
                'is_org_compliant' => false,
                'menu'             => array(
                'slug'       => 'woomotiv',
                'first-path' => 'admin.php?page=woomotiv',
                'support'    => false,
                'contact'    => false,
                'network'    => true,
            ),
                'is_live'          => true,
            ) );
        }
        
        return $wmv_fs;
    }

}
// Init Freemius.
wmv_fs();
// Signal that SDK was initiated.
do_action( 'wmv_fs_loaded' );