<?php

class Barcodeman_Admin_Dashboard {

	public static $_instance;


	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}


	function __construct() {

	}


	public static function view() {

		$dashboard = self::instance();

		$dashboard->render_connect();
	}

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

	/**
	 * Ajax response for stats block
	 */
	public static function render_stats_ajax() {

		$stats = self::instance()->_get_stats();

		if ( ! empty( $stats ) && ! is_wp_error( $stats ) ) {
			Barcodeman_Admin::load_template( 'stats', array( 'stats' => $stats ) );
		} else {
			Barcodeman_Admin::load_template( 'error', array( 'error' => $stats->get_error_message( 'printful' ) ) );
		}

		exit;
	}

	/**
	 * Ajax response for stats block
	 */
	public static function render_orders_ajax() {

		$orders = self::instance()->_get_orders();

		if ( ! empty( $orders ) && is_wp_error( $orders ) ) {
			Barcodeman_Admin::load_template( 'error', array( 'error' => $orders->get_error_message('printful') ) );
		} else {
			Barcodeman_Admin::load_template( 'order-table', array( 'orders' => $orders ) );
		}

		exit;
	}

	/**
	 * Get store statistics from API
	 * @param bool $only_cached_results
	 * @return mixed
	 */
	private function _get_stats($only_cached_results = false) {

		$stats = get_transient( 'printful_stats' );
		if ( $only_cached_results || $stats ) {
			return $stats;
		}

		try {
			$stats = Printful_Integration::instance()->get_client()->get( 'store/statistics' );
			if ( ! empty( $stats['store_statistics'] ) ) {
				$stats = $stats['store_statistics'];
			}
			set_transient( 'printful_stats', $stats, MINUTE_IN_SECONDS * 5 ); //cache for 5 minute
		} catch (PrintfulApiException $e) {
			return new WP_Error('printful', 'Could not connect to Printful API. Please try again later!');
		} catch (PrintfulException $e) {
			return new WP_Error('printful', 'Could not connect to Printful API. Please try again later!');
		}

		return $stats;
	}

	/**
	 * Get Printful orders from the API
	 * @param bool $only_cached_results
	 * @return mixed
	 */
	private function _get_orders($only_cached_results = false) {

		$orders = get_transient( 'printful_orders' );

		if ( $only_cached_results || $orders ) {
			return $orders;
		}

		try {
			$order_data = Printful_Integration::instance()->get_client()->get( 'orders' );

			if ( ! empty( $order_data ) ) {

				foreach ( $order_data as $key => $order ) {

					if($order['status'] == 'pending') {
						$order_data[$key]['status'] = 'Waiting for fulfillment';
					}
				}
			}

			$orders = array( 'count' => count( $order_data ), 'results' => $order_data );
			set_transient( 'printful_orders', $orders, MINUTE_IN_SECONDS * 5 ); //cache for 5 minute
		} catch (PrintfulApiException $e) {
			return new WP_Error('printful', 'Could not connect to Printful API. Please try again later!');
		} catch (PrintfulException $e) {
			return new WP_Error('printful', 'Could not connect to Printful API. Please try again later!');
		}

		return $orders;
	}

}
