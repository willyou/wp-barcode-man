<?php
/**
 * Admin class for BarcodeMan.
 *
 * @package Barcodeman
 */

namespace BarcodeMan;

/**
 * Admin class for BarcodeMan.
 */
class Barcodeman_Admin {

	const MENU_TITLE_TOP       = 'BarcodeMan';
	const PAGE_TITLE_DASHBOARD = 'Dashboard';
	const MENU_TITLE_DASHBOARD = 'Dashboard';
	const MENU_SLUG_DASHBOARD  = 'barcodeman-dashboard';
	const CAPABILITY           = 'manage_options';

	/**
	 * Class init.
	 */
	public static function init() {
		$admin = new self();
		$admin->register_admin();
	}

	/**
	 * Register admin scripts
	 */
	public function register_admin() {

		add_action( 'admin_menu', array( $this, 'register_admin_menu_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_global_style' ) );

	}

	/**
	 * Loads stylesheets used in barcodeman admin pages.
	 *
	 * @param Hook $hook Hook to target.
	 */
	public function add_admin_styles( $hook ) {
		wp_enqueue_style( 'barcodeman-global', plugins_url( '../assets/css/global.css', __FILE__ ), array(), '1.0.0' );
	}

	/**
	 * Loads stylesheet for barcodeman toolbar element
	 */
	public function add_global_style() {
		if ( is_user_logged_in() ) {
			wp_enqueue_style( 'barcodeman-global', plugins_url( '../assets/css/global.css', __FILE__ ), array(), '1.0.0' );
		}
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
			array( '\BarcodeMan\Barcodeman_Admin', 'route' ),
			Barcodeman_Base::get_asset_url() . 'images/barcodeman-menu-icon.png',
			59.57567657
		);

	}

	/**
	 * Route the tabs
	 */
	public static function route() {
		if ( isset( $_GET['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'view_tab' ) ) {
			$tab_value = ( isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : '' );
		}

		$tab = ( isset( $tab_value ) ? $tab_value : 'dashboard' );
		call_user_func( array( 'BarcodeMan\Barcodeman_Admin_Dashboard', 'render_' . $tab ) );
	}

	/**
	 * Get the tabs
	 */
	public static function get_tabs() {

		$tabs = array(
			array(
				'name'    => __( 'Support', 'barcodeman' ),
				'tab_url' => 'support',
			),
		);

		array_unshift(
			$tabs,
			array(
				'name'    => __( 'Setup', 'barcodeman' ),
				'tab_url' => false,
			)
		);

		return $tabs;
	}

	/**
	 * Load template file
	 *
	 * @param Name      $name template name.
	 * @param Variables $variables variables passed to template.
	 */
	public static function load_template( $name, $variables = array() ) {

		if ( ! empty( $variables ) && isset( $variables['tabs'] ) ) {
			$tabs = $variables['tabs'];
		}

		$filename = plugin_dir_path( __FILE__ ) . 'templates/' . $name . '.php';
		if ( file_exists( $filename ) ) {
			include $filename;
		}
	}

}
