<?php
/**
 * Plugin Name: Heartbeat API
 * Plugin URI: https://hsoft.cloud/products/wooxpart
 * Description: Get better feedback. Increase your conversion rate using HSoft Store plugin.
 * Version: 1.0.0
 * Author: HSoft
 * Author URI: https://hsoft.cloud
 * Text Domain: wooxpart
 * Domain Path: /languages/
 * Requires at least: 1.0.0
 * Requires PHP: 7.4
 *
 * @package HSoft
 */

// Register assets.
add_action( 'wp_enqueue_scripts', 'heartbeat_register_assets' );
function heartbeat_register_assets() {
    wp_enqueue_script( 'custom-heartbeat-api', plugin_dir_url(__FILE__) . 'heartbeat.js', array( 'heartbeat', 'jquery' ), null, true );
}

// Handle Heartbeat request.
function myplugin_receive_heartbeat( $response, $data ) {
    error_log(print_r('heartbeat called', true));
    if ( empty( $data['my_custom_data'] ) ) {
        return $response;
    }

    $received_data = sanitize_text_field( $data['my_custom_data'] );
    $response['custom_value_hashed'] = sha1( $received_data );

    return $response;
}
add_filter( 'heartbeat_received', 'myplugin_receive_heartbeat', 10, 2 );

function custom_heartbeat_interval( $settings ) {
    if ( is_admin() ) {
        return $settings; // Keep default in admin.
    }

    $settings['interval'] = 5; // 5 seconds for frontend.
    return $settings;
}
add_filter( 'heartbeat_settings', 'custom_heartbeat_interval' );
