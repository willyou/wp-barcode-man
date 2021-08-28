<?php


class Barcodeman_Admin {

	const MENU_TITLE_TOP = 'BarcodeMan';
	const PAGE_TITLE_DASHBOARD = 'Dashboard';
	const MENU_TITLE_DASHBOARD = 'Dashboard';
	const MENU_SLUG_DASHBOARD = 'barcodeman-dashboard';
	const CAPABILITY = 'manage_options';

	public static function init() {
		$admin = new self;
		$admin->register_admin();
	}

    /**
     * Register admin scripts
     */
	public function register_admin() {

		add_action( 'admin_menu', array( $this, 'register_admin_menu_page' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_styles' ) );
		// add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_global_style' ) );
    }

    /**
     * Loads stylesheets used in printful admin pages
     * @param $hook
     */
		public function add_admin_styles($hook) {
			wp_enqueue_style( 'barcodeman-global', plugins_url( '../assets/css/global.css', __FILE__ ) );
		}

	/**
	 * Loads stylesheet for printful toolbar element
	 */
    public function add_global_style() {
	    if ( is_user_logged_in() ) {
		    wp_enqueue_style( 'barcodeman-global', plugins_url( '../assets/css/global.css', __FILE__ ) );
	    }
    }

	/**
	 * Loads scripts used in printful admin pages
	 * @param $hook
	 */
	public function add_admin_scripts($hook) {
		// if ( strpos( $hook, 'printful-dashboard' ) !== false ) {
		// 	wp_enqueue_script( 'wp-color-picker' );
		// 	wp_enqueue_script( 'printful-settings', plugins_url( '../assets/js/settings.js', __FILE__ ) );
		// 	wp_enqueue_script( 'printful-connect', plugins_url( '../assets/js/connect.js', __FILE__ ) );
		// 	wp_enqueue_script( 'printful-block-loader', plugins_url( '../assets/js/block-loader.js', __FILE__ ) );
		// 	wp_enqueue_script( 'printful-intercom', plugins_url( '../assets/js/intercom.min.js', __FILE__ ) );
		// }
	}

    /**
     * Register admin menu pages
     */
	public function register_admin_menu_page() {

		add_menu_page(
			__( 'Dashboard', 'barcodeman' ),
			self::MENU_TITLE_TOP,
			self::CAPABILITY,
			self::MENU_SLUG_DASHBOARD,
			array( 'Barcodeman_Admin', 'route' ),
			Barcodeman_Base::get_asset_url() . 'images/barcodeman-menu-icon.png',
			59
		);



	}

	/**
	 * Route the tabs
	 */
	public static function route() {

		$tabs = array(
			'dashboard' => 'Barcodeman_Admin_Dashboard',
			'setup'   => 'Barcodeman_Admin_Dashboard',
			'support'   => 'Barcodeman_Admin_Dashboard',
		);

		$tab = ( ! empty( $_GET['tab'] ) ? $_GET['tab'] : 'dashboard' );
		if ( ! empty( $tabs[ $tab ] ) ) {
			call_user_func( array( $tabs[ $tab ], 'view' ) );
		}
	}

    // Get the tabs
	public static function get_tabs() {

		$tabs = array(
			array( 'name' => __( 'Support', 'barcodeman' ), 'tab_url' => 'support' ),
		);

		array_unshift( $tabs, array( 'name' => __( 'Setup', 'barcodeman' ), 'tab_url' => false ) );

		return $tabs;
	}

	// Load template file
	public static function load_template( $name, $variables = array() ) {

		if ( ! empty( $variables ) ) {
			extract( $variables );
		}

		$filename = plugin_dir_path( __FILE__ ) . 'templates/' . $name . '.php';
		if ( file_exists( $filename ) ) {
			include( $filename );
		}
	}

}
