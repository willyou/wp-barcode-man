<?php

/*
Plugin Name: Barcode Man for WooCommerce
Plugin URI: https://saberwp.com/plugins/barcode-man-wc/
Description: Connect to the Bar Code Man service for WooCommerce.
Version: 1.0.0
Author: Barcode Man
Author URI: https://saberwp.com/
License: GPL2 http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: barcodeman
WC requires at least: 3.0.0
WC tested up to: 5.5
*/

class BarcodeMan_Base {

	const VERSION = '1.0.0';

	// Construct the plugin
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	// Initialize the plugin.
	public function init() {

		require_once 'includes/class-barcode-man-admin.php';
		require_once 'includes/class-barcode-man-admin-dashboard.php';

		Barcodeman_Admin::init();

	}

	/**
	 * @return string
	 */
	public static function get_asset_url() {
		return trailingslashit(plugin_dir_url(__FILE__)) . 'assets/';
	}

}

new BarcodeMan_Base();
