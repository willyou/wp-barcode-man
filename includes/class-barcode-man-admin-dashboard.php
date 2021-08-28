<?php

class Barcodeman_Admin_Dashboard {

	public static $_instance;


	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}


	function __construct() {}

	/**
	 * Display the Barcodeman support page
	 */
	public function render_support() {

		Barcodeman_Admin::load_template( 'header', array( 'tabs' => Barcodeman_Admin::get_tabs() ) );
		Barcodeman_Admin::load_template( 'support', array() );
		Barcodeman_Admin::load_template('footer');

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
