<?php
/**
 * Admin dashboard class.
 *
 * @package Barcodeman
 */

/**
 * Barcodeman_Admin_Dashboard class.
 */
class Barcodeman_Admin_Dashboard {

	/**
	 * Instance variable.
	 *
	 * @var Instance $instance instance of the singleton object.
	 */
	public static $instance;

	/**
	 * Instance
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Display the Barcodeman support page
	 */
	public function render_support() {

		Barcodeman_Admin::load_template( 'header', array( 'tabs' => Barcodeman_Admin::get_tabs() ) );
		Barcodeman_Admin::load_template( 'support', array() );
		Barcodeman_Admin::load_template( 'footer' );

	}

	/**
	 * Display the dashboard
	 */
	public function render_dashboard() {

		Barcodeman_Admin::load_template( 'header', array( 'tabs' => Barcodeman_Admin::get_tabs() ) );
		Barcodeman_Admin::load_template( 'connect', array() );
		Barcodeman_Admin::load_template( 'footer' );

	}

}
