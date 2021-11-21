<?php
/**
 * Plugin Name: Barcode Man for WooCommerce
 * Plugin URI: https://wordpress.org/plugins/barcode-man/
 * Description: Connect to the Bar Code Man service for WooCommerce.
 * Version: 1.0.2
 * Author: Barcode Man
 * Author URI: https://saberwp.com/
 * License: GPL2 http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: barcodeman
 * WC requires at least: 3.0.0
 * WC tested up to: 5.5
 *
 * @package BarcodeMan
 */

namespace BarcodeMan;

define( 'BARCODEMAN_PLUGIN_NAME', 'Barcode Man' );
define( 'BARCODEMAN_VERSION', '1.0.2' );
define( 'BARCODEMAN_PATH', plugin_dir_path( __FILE__ ) );
define( 'BARCODEMAN_URL', plugin_dir_url( __FILE__ ) );
define( 'BARCODEMAN_DEV_MODE', 0 );
define( 'BARCODEMAN_TEXT_DOMAIN', 'barcodeman' );

/**
 * Main plugin class for BarcodeMan.
 */
class BarcodeMan_Base {

	/**
	 * Construct the plugin.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Initialize the plugin.
	 */
	public function init() {

		require_once BARCODEMAN_PATH . 'includes/class-barcodeman-admin.php';
		require_once BARCODEMAN_PATH . 'includes/class-barcodeman-admin-dashboard.php';

		Barcodeman_Admin::init();

	}

	/**
	 * Get the full URL to the assets directory.
	 *
	 * @return string
	 */
	public static function get_asset_url() {
		return trailingslashit( plugin_dir_url( __FILE__ ) ) . 'assets/';
	}

}

new BarcodeMan_Base();
