<?php
/**
 * Plugin Name: IATBD Core
 * Description: Core Elementor widgets and functionality for Industrial Automation & Technology Bangladesh (IATBD).
 * Plugin URI:  https://iatbd.com/
 * Version:     1.0.0
 * Author:      IATBD
 * Author URI:  https://iatbd.com/
 * Text Domain: iatbd-core
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'IATBD_CORE_VERSION' ) ) {
	define( 'IATBD_CORE_VERSION', '1.0.0' );
}
if ( ! defined( 'IATBD_CORE_FILE' ) ) {
	define( 'IATBD_CORE_FILE', __FILE__ );
}
if ( ! defined( 'IATBD_CORE_PATH' ) ) {
	define( 'IATBD_CORE_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'IATBD_CORE_URL' ) ) {
	define( 'IATBD_CORE_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! function_exists( 'iatbd_core_load_plugin' ) ) {
	function iatbd_core_load_plugin() {
		// Load main plugin class
		require_once IATBD_CORE_PATH . 'includes/plugin.php';

		// Run the plugin instance
		if ( class_exists( '\Elementor_Test\Elementor_Test' ) ) {
			\Elementor_Test\Elementor_Test::instance();
		}
	}
	add_action( 'plugins_loaded', 'iatbd_core_load_plugin' );
}
