<?php
 
/**
Plugin Name: Barcode Man for WooCommerce
Plugin URI: https://wordpress.org/plugins/printful-shipping-for-woocommerce/
Description: Calculate correct shipping and tax rates for your Printful-Woocommerce integration.
Version: 1.0
Author: Barcode Man
Author URI: http://itsgookit.com
License: GPL2 http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: printful
WC requires at least: 3.0.0
WC tested up to: 5.5
*/

class BarcodeMan_Base {

    const VERSION = '1.0.0';
	const PF_HOST = 'https://www.printful.com/';
	const PF_API_HOST = 'https://api.printful.com/';

    // Construct the plugin
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ) );
    }

    // Initialize the plugin.
    public function init() {

      

	    // WP REST API.
	    // $this->rest_api_init();

        //load required classes
	   
	    require_once 'includes/class-barcode-man-admin.php';
	    require_once 'includes/class-barcode-man-admin-dashboard.php';
	    // require_once 'includes/class-printful-admin-settings.php';
	    // require_once 'includes/class-printful-admin-status.php';
	    // require_once 'includes/class-printful-admin-support.php';
	    // // require_once 'includes/class-printful-size-chart-tab.php';
	    // // require_once 'includes/class-printful-size-chart-tab.php';
        // require_once 'includes/class-printful-template.php';
        // // require_once 'includes/class-printful-customizer.php';
        // // require_once 'includes/class-printful-size-guide.php';

	    //launch init
	    Barcodeman_Admin::init();
	    
	    //hook ajax callbacks
	    // add_action( 'wp_ajax_save_printful_settings', array( 'Printful_Admin_Settings', 'save_printful_settings' ) );
	    // add_action( 'wp_ajax_ajax_force_check_connect_status', array( 'Printful_Integration', 'ajax_force_check_connect_status' ) );
	    // add_action( 'wp_ajax_get_printful_stats', array( 'Printful_Admin_Dashboard', 'render_stats_ajax' ) );
	    // add_action( 'wp_ajax_get_printful_orders', array( 'Printful_Admin_Dashboard', 'render_orders_ajax' ) );
	    // add_action( 'wp_ajax_get_printful_status_checklist', array( 'Printful_Admin_Status', 'render_status_table_ajax' ) );
	    // add_action( 'wp_ajax_get_printful_status_report', array( 'Printful_Admin_Support', 'render_status_report_ajax' ) );
	    // add_action( 'wp_ajax_get_printful_carriers', array( 'Printful_Admin_Settings', 'render_carriers_ajax' ) );
    }

    

	/**
	 * @return string
	 */
    public static function get_asset_url() {
		return trailingslashit(plugin_dir_url(__FILE__)) . 'assets/';
    }

    /**
	 * @return string
	 */
	public static function get_printful_host() {
		if ( defined( 'PF_DEV_HOST' ) ) {
			return PF_DEV_HOST;
		}

		return self::PF_HOST;
	}

	/**
	 * @return string
	 */
	public static function get_printful_api_host() {
		if ( defined( 'PF_DEV_API_HOST' ) ) {
			return PF_DEV_API_HOST;
		}

		return self::PF_API_HOST;
	}

    private function rest_api_init()
    {
        // REST API was included starting WordPress 4.4.
        if ( ! class_exists( 'WP_REST_Server' ) ) {
            return;
        }

        // Init REST API routes.
        add_action( 'rest_api_init', array( $this, 'register_rest_routes' ), 20);
    }

    public function register_rest_routes()
    {
        require_once 'includes/class-printful-rest-api-controller.php';

        $printfulRestAPIController = new Printful_REST_API_Controller();
        $printfulRestAPIController->register_routes();
    }
}

new BarcodeMan_Base();    