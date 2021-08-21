<?php
/**
 * Plugin Name: MultiWooPlugin
 * Plugin URI: http://www.eu.limepatterns.site/
 * Description: This is the very first plugin I ever created.
 * Version: develop
 * Author: shirrumon
 * Author URI: http://www.eu.limepatterns.site/
 **/

include_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/multi/sticky-add-to-cart-woo/woo-sticky-add-to-cart.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/multi/woocommerce-side-cart-premium/xoo-wsc-main.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/multi/woomotiv/index.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/multi/eu-vat-for-woocommerce/eu-vat-for-woocommerce.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/multi/popup-notices-for-woocommerce-pro/popup-notices-for-woocommerce-pro.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/multi/tier-pricing-table/tier-pricing-table.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/multi/product-recommendation-quiz-for-ecommerce/product-recommendation-quiz-for-ecommerce.php');

add_action('admin_menu', 'test_plugin_setup_menu');
function test_plugin_setup_menu(){
    $icon = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIHN0eWxlPSJmaWxsOiB2aW9sZXQ7Ij48cGF0aCBkPSJNMjQgMTloLTF2LTIuMmMtMS44NTMgNC4yMzctNi4wODMgNy4yLTExIDcuMi02LjYyMyAwLTEyLTUuMzc3LTEyLTEyaDFjMCA2LjA3MSA0LjkyOSAxMSAxMSAxMSA0LjY2IDAgOC42NDctMi45MDQgMTAuMjQ5LTdoLTIuMjQ5di0xaDR2NHptLTExLjAzNiAwaC0xLjg4NmMtLjM0LS45NTctLjQzNy0xLjU3MS0xLjE3Ny0xLjg3OGgtLjAwMWMtLjc0My0uMzA4LTEuMjUxLjA2MS0yLjE2Mi40OTRsLTEuMzMzLTEuMzMzYy40MjctLjg5OS44MDQtMS40MTUuNDk0LTIuMTYzLS4zMDgtLjc0LS45MjYtLjgzOS0xLjg3OC0xLjE3N3YtMS44ODZjLjk1NC0uMzM5IDEuNTctLjQzNyAxLjg3OC0xLjE3OC4zMDgtLjc0My0uMDYtMS4yNDgtLjQ5NC0yLjE2MmwxLjMzMy0xLjMzM2MuOTE4LjQzNiAxLjQyMS44MDEgMi4xNjIuNDk0bC4wMDEtLjAwMWMuNzQtLjMwNy44MzgtLjkyNCAxLjE3Ny0xLjg3N2gxLjg4NmMuMzQuOTU4LjQzNyAxLjU3IDEuMTc3IDEuODc3bC4wMDEuMDAxYy43NDMuMzA4IDEuMjUyLS4wNjIgMi4xNjItLjQ5NGwxLjMzMyAxLjMzM2MtLjQzNS45MTctLjgwMSAxLjQyMS0uNDk0IDIuMTYxdi4wMDFjLjMwNy43MzkuOTE1LjgzNSAxLjg3OCAxLjE3OHYxLjg4NmMtLjk1My4zMzgtMS41NzEuNDM3LTEuODc4IDEuMTc4LS4zMDguNzQzLjA2IDEuMjQ5LjQ5NCAyLjE2MmwtMS4zMzMgMS4zMzNjLS45Mi0uNDM4LTEuNDItLjgwMi0yLjE1Ny0uNDk2LS43NDYuMzEtLjg0NC45MjYtMS4xODMgMS44OHptLS45NDMtNC42NjdjLTEuMjg5IDAtMi4zMzMtMS4wNDQtMi4zMzMtMi4zMzMgMC0xLjI4OSAxLjA0NC0yLjMzNCAyLjMzMy0yLjMzNCAxLjI4OSAwIDIuMzMzIDEuMDQ1IDIuMzMzIDIuMzM0IDAgMS4yODktMS4wNDQgMi4zMzMtMi4zMzMgMi4zMzN6bS04LjAyMS01LjMzM2gtNHYtNGgxdjIuMmMxLjg1My00LjIzNyA2LjA4My03LjIgMTEtNy4yIDYuNjIzIDAgMTIgNS4zNzcgMTIgMTJoLTFjMC02LjA3MS00LjkyOS0xMS0xMS0xMS00LjY2IDAtOC42NDcgMi45MDQtMTAuMjQ5IDdoMi4yNDl2MXoiLz48L3N2Zz4K';
    add_menu_page( 'Ecomlution', 'Ecomlution', 'manage_options', 'Ecomlution', 'init', $icon, 10 );
    echo '
    <style>
    #toplevel_page_wsatc, #toplevel_page_side-cart-woocommerce-settings, #toplevel_page_woomotiv, #toplevel_page_prqfw{
    display: none;
    }
    </style>
    ';
}

function init(){
    echo "<div class='adminpage'>";
    require_once 'sidebar.php';
    echo "
        <div class='main'>
        <h1>This will be admin panel</h1>
</div>
<style>
    .adminpage{
    display: inline-flex;
    }
    
    .main{
    text-align: center;
    min-width: 50vw;
    }
</style>
    ";
    echo "</div>";
}

if( !function_exists('is_plugin_active') ) {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if(is_plugin_active('multi/multiplugin.php') == true){
    activate_plugins(array(
        '/sticky-add-to-cart-woo/woo-sticky-add-to-cart.php', //sticky activate
        '/woocommerce-side-cart-premium/xoo-wsc-main.php', //side-cart activate
        '/woomotiv/index.php', //sales notification activate
        '/eu-vat-for-woocommerce/eu-vat-for-woocommerce.php', //vat activate
        '/popup-notices-for-woocommerce-pro/popup-notices-for-woocommerce-pro.php', //popup ajax notice activate
        '/tier-pricing-table/tier-pricing-table.php', //bundlle sell activate
        '/product-recommendation-quiz-for-ecommerce/product-recommendation-quiz-for-ecommerce.php' //recomendation quiz activate
    ));
}
else{
    deactivate_plugins(array(
        '/sticky-add-to-cart-woo/woo-sticky-add-to-cart.php', //sticky deactivate
        '/woocommerce-side-cart-premium/xoo-wsc-main.php', //side-cart deactivate
        '/woomotiv/index.php', //sales notification deactivate
        '/eu-vat-for-woocommerce/eu-vat-for-woocommerce.php', //vat deactivate
        '/popup-notices-for-woocommerce-pro/popup-notices-for-woocommerce-pro.php', //popup ajax notice deactivate
        '/tier-pricing-table/tier-pricing-table.php', //bundlle sell deactivate
        '/product-recommendation-quiz-for-ecommerce/product-recommendation-quiz-for-ecommerce.php' //recomendation quiz deactivate
    ));
}
?>