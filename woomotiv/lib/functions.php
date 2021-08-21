<?php

namespace WooMotiv;

use  WooMotiv\Framework\Helper ;
/**
 * Returns a link to upgrade
 *
 * @return string
 */

/**
 * Returns an upgrade notice
 *
 * @return string
 */
function upgrade_notice()
{
    if ( wmv_fs()->is_free_plan() ) {
        return '
            <div class="dlb_alert _error">' . __( 'Please upgrade to use this feature. Upgrading helps me complete developing Woomotiv.', 'woomotiv' ) . upgrade_link() . '</div>';
    }
}

/**
 * Returns DateTime object of the current time with the WP timezone
 *
 * @return DateTime
 */
function date_now()
{
    return new \DateTime( "now", Timezone::getWpTimezone() );
}

/**
 * Convert a date to the wordpress timezone
 *@param string|DateTime $date
 * @return DateTime
 */
function convert_timezone( $date = null )
{
    $timezone = Timezone::getWpTimezone();
    if ( !$date ) {
        $date = new \DateTime();
    }
    if ( is_string( $date ) ) {
        $date = new \DateTime( $date );
    }
    $date->setTimezone( $timezone );
    return $date;
}

/**
 * Undocumented function
 *
 * @param [type] $id_or_email
 * @param [type] $args
 * @return void
 */
function mod_avatar( $id_or_email, $default = '', $alt = '' )
{
    $file = get_avatar_url( $id_or_email, array(
        'size'    => 150,
        'default' => 404,
    ) );
    $file_headers = @get_headers( $file, 0 );
    if ( !$file_headers || strpos( $file_headers[0], '404 Not Found' ) !== false ) {
        return '<img src="' . $default . '" alt="' . $alt . '">';
    }
    return '<img src="' . $file . '" alt="' . $alt . '">';
}

/** 
 * days_in_month($month, $year) 
 * Returns the number of days in a given month and year, taking into account leap years. 
 * 
 * $month: numeric month (integers 1-12) 
 * $year: numeric year (any integer) 
 * 
 * Prec: $month is an integer between 1 and 12, inclusive, and $year is an integer. 
 * Post: none 
**/
function days_in_month( $month, $year )
{
    // calculate number of days in a month
    return ( $month == 2 ? ( $year % 4 ? 28 : (( $year % 100 ? 29 : (( $year % 400 ? 28 : 29 )) )) ) : (( ($month - 1) % 7 % 2 ? 30 : 31 )) );
}

/**
 * Return stats rows
 * @return array
 */
function get_statistics( $year, $month = 0, $day = 0 )
{
}

/**
 * Get orders
 * 
 * @param array $excluded_orders
 * @return array
 */
function get_orders( $excluded_orders = array() )
{
    global  $wpdb ;
    $excluded_orders = ( !is_array( $excluded_orders ) ? [] : $excluded_orders );
    $is_random = ( woomotiv()->config->woomotiv_display_order === 'random_sales' ? true : false );
    $raw = "\n        SELECT \n            POSTS.ID, POSTS.post_status, POSTS.post_type, \n            POSTMETA.meta_value AS 'customer_id'\n        \n        FROM \n            {$wpdb->prefix}posts AS POSTS\n        \n        LEFT JOIN\n            {$wpdb->prefix}postmeta AS POSTMETA\n                ON \n                    POSTMETA.post_id = POSTS.ID\n                AND\n                    POSTMETA.meta_key = '_customer_user'\n    ";
    $raw .= "\n            WHERE\n                POSTS.post_status = 'wc-completed' \n        ";
    $raw .= " AND POSTS.post_type = 'shop_order'";
    // Make sure it is a parent order
    $raw .= " AND POSTS.post_parent = 0";
    // Only if has products
    $raw .= " AND (SELECT COUNT(*) AS total_products FROM {$wpdb->prefix}woocommerce_order_items AS WOI where WOI.order_id = POSTS.ID) > 0";
    // Excluded orders
    
    if ( count( $excluded_orders ) ) {
        $excluded_orders_str = implode( ',', $excluded_orders );
        $raw .= " AND POSTS.ID NOT IN ({$excluded_orders_str})";
    }
    
    // exclude current user orders
    if ( is_user_logged_in() ) {
        
        if ( current_user_can( 'manage_options' ) ) {
            if ( (int) woomotiv()->config->woomotiv_admin_popups == 0 ) {
                $raw .= ' AND POSTMETA.meta_value != ' . get_current_user_id();
            }
        } else {
            if ( (int) woomotiv()->config->woomotiv_logged_own_orders == 0 ) {
                $raw .= ' AND POSTMETA.meta_value != ' . get_current_user_id();
            }
        }
    
    }
    // random or recent sales
    
    if ( $is_random ) {
        $raw .= " ORDER BY RAND()";
    } else {
        $raw .= " ORDER BY POSTS.post_date DESC";
    }
    
    // limit
    $raw .= " LIMIT " . woomotiv()->config->woomotiv_limit;
    $orders = array();
    // exlcuded products
    $excludedProducts = [];
    
    if ( woomotiv()->config->woomotiv_filter_products !== '' && woomotiv()->config->woomotiv_filter_products !== '0' ) {
        $excludedProducts = woomotiv()->config->woomotiv_filter_products;
        $excludedProducts = explode( ',', $excludedProducts );
    }
    
    foreach ( $wpdb->get_results( $raw ) as $data ) {
        $order = wc_get_order( $data->ID );
        $items = $order->get_items();
        $products = array();
        // only keep the published products
        foreach ( $items as $item ) {
            
            if ( $item->get_product() ) {
                $product = $item->get_product();
                // exlcude products
                if ( !in_array( $product->get_id(), $excludedProducts ) ) {
                    $products[] = $product;
                }
            }
        
        }
        if ( !count( $products ) ) {
            continue;
        }
        // select a random product
        $random = array_rand( $products, 1 );
        $product = $products[$random];
        $orders[] = (object) array(
            'id'      => $data->ID,
            'order'   => $order,
            'product' => $product,
        );
    }
    // Mysql ORDER BY RAND() returns a cached query after the first time
    if ( $is_random ) {
        shuffle( $orders );
    }
    return $orders;
}

/**
 * Get orders
 * 
 * @param array $excluded_order_items
 * @return array
 */
function get_products( $excluded_order_items = array() )
{
    global  $wpdb ;
    $is_outofstock_visible = ( woomotiv()->config->woomotiv_filter_out_of_stock == 1 ? true : false );
    $is_random = ( woomotiv()->config->woomotiv_display_order === 'random_sales' ? true : false );
    $excluded_order_items = ( !is_array( $excluded_order_items ) ? [] : $excluded_order_items );
    
    if ( woomotiv()->config->woomotiv_filter_products !== '' && woomotiv()->config->woomotiv_filter_products !== '0' ) {
        $excluded_products = woomotiv()->config->woomotiv_filter_products;
        $excluded_products = array_filter( explode( ',', $excluded_products ) );
    }
    
    $raw = "\n        SELECT \n            C.ID AS product_id, \n            A.order_id,\n            A.order_item_id,\n            D.post_status AS order_status,\n            F.meta_value AS customer_id,\n            J.meta_value AS stock_status\n        FROM \n            {$wpdb->prefix}woocommerce_order_items AS A\n        INNER JOIN\n            {$wpdb->prefix}woocommerce_order_itemmeta AS B\n                ON\n                    A.order_item_id = B.order_item_id\n                AND\n                    B.meta_key = '_product_id'\n        INNER JOIN\n            {$wpdb->prefix}posts AS C\n                ON\n                    C.ID = B.meta_value\n                AND\n                    C.post_status = 'publish'\n        INNER JOIN\n            {$wpdb->prefix}posts AS D\n                ON\n                    A.order_id = D.ID\n                AND\n                    D.post_type = 'shop_order'\n        LEFT JOIN\n            {$wpdb->prefix}postmeta AS F\n                ON \n                    F.post_id = D.ID\n                AND\n                    F.meta_key = '_customer_user'\n        INNER JOIN\n            {$wpdb->prefix}postmeta AS J\n            ON\n                J.post_id = C.ID\n            AND\n                J.meta_key = '_stock_status'\n        WHERE\n            A.order_item_type = 'line_item'\n    ";
    $raw .= " AND D.post_status = 'wc-completed'";
    // Make sure it is a parent order
    $raw .= " AND D.post_parent = 0";
    // Is out of stock enabled?
    if ( !$is_outofstock_visible ) {
        $raw .= " AND J.meta_value != 'outofstock'";
    }
    // Excluded order items ( No-repeat functionality)
    
    if ( count( $excluded_order_items ) ) {
        $excluded_order_items_str = implode( ',', $excluded_order_items );
        $raw .= " AND A.order_item_id NOT IN ({$excluded_order_items_str})";
    }
    
    // Excluded products
    
    if ( count( $excluded_products ) ) {
        $excluded_products_str = implode( ',', $excluded_products );
        $raw .= " AND C.ID NOT IN ({$excluded_products_str})";
    }
    
    // exclude current user orders
    if ( is_user_logged_in() ) {
        
        if ( current_user_can( 'manage_options' ) ) {
            if ( (int) woomotiv()->config->woomotiv_admin_popups == 0 ) {
                $raw .= ' AND F.meta_value != ' . get_current_user_id();
            }
        } else {
            if ( (int) woomotiv()->config->woomotiv_logged_own_orders == 0 ) {
                $raw .= ' AND F.meta_value != ' . get_current_user_id();
            }
        }
    
    }
    // random or recent sales
    
    if ( $is_random ) {
        $raw .= " ORDER BY RAND()";
    } else {
        $raw .= " ORDER BY A.order_item_id DESC";
    }
    
    // limit
    $raw .= " LIMIT " . woomotiv()->config->woomotiv_limit;
    $products = array();
    foreach ( $wpdb->get_results( $raw ) as $data ) {
        $order = wc_get_order( (int) $data->order_id );
        $products[] = [
            'id'            => $data->product_id,
            'order'         => $order,
            'order_id'      => (int) $data->order_id,
            'order_item_id' => (int) $data->order_item_id,
            'product'       => wc_get_product( (int) $data->product_id ),
        ];
    }
    // Mysql ORDER BY RAND() returns a cached query after the first time
    if ( $is_random ) {
        shuffle( $products );
    }
    return $products;
}

/**
 * Get reviews
 *
 * @param array $excluded
 * @return array
 */
function get_reviews( $excluded_reviews = array() )
{
    $excluded_reviews = ( !is_array( $excluded_reviews ) ? [] : $excluded_reviews );
    $is_random = ( woomotiv()->config->woomotiv_display_order === 'random_sales' ? true : false );
    /** Only Premium */
    if ( wmv_fs()->is_free_plan() ) {
        return array();
    }
}

/**
 * Get custom popups
 *
 * @return array
 */
function get_custom_popups( $excluded_popups )
{
    /** Only Premium */
    if ( wmv_fs()->is_free_plan() ) {
        return array();
    }
}

/**
 * Check for valid nonce
 * @return bool
 */
function validateNounce()
{
    if ( !wp_verify_nonce( woomotiv()->request->post( 'nonce', null ), 'woomotiv' ) ) {
        response( false );
    }
}

/**
 * Return json response and die
 */
function response( $success, $data = array() )
{
    if ( $success ) {
        wp_send_json_success( $data );
    }
    wp_send_json_error( $data );
}
