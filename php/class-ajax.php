<?php
/**
 * @package Yoast\YoastCom
 */

namespace Yoast\YoastCom\Theme;

use Yoast\YoastCom\EDD\Payment_Method_Provider;
use Yoast\YoastCom\VisitorCurrency\Currency_Controller;

/**
 * Handles the ajax requests in the theme
 */
class Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_ajax_cart_item_number', array( $this, 'cart_item_number' ) );
		add_action( 'wp_ajax_nopriv_cart_item_number', array( $this, 'cart_item_number' ) );

		add_action( 'wp_ajax_detect_currency', array( $this, 'detect_currency' ) );
		add_action( 'wp_ajax_nopriv_detect_currency', array( $this, 'detect_currency' ) );

		add_action( 'wp_ajax_yst_update_variation', array( $this, 'update_variation' ) );
		add_action( 'wp_ajax_nopriv_yst_update_variation', array( $this, 'update_variation' ) );

		add_action( 'wp_ajax_yst_update_payment_methods', array( $this, 'update_payment_methods' ) );
		add_action( 'wp_ajax_nopriv_yst_update_payment_methods', array( $this, 'update_payment_methods' ) );
	}

	/**
	 * Detect currency
	 */
	public function detect_currency() {
		$data = [ 'status' => 'error' ];

		if ( class_exists( 'Yoast\YoastCom\VisitorCurrency\Currency_Controller' ) ) {
			$alternate_currency = Currency_Controller::get_instance();
			$data               = [
				'status' => 'success',
				'data'   => [
					'currency' => $alternate_currency->get_currency(),
				],
			];
		}

		header( 'Content-Type: text/javascript' );
		$callback = filter_input( INPUT_GET, 'callback' );
		printf( '%s(%s);', $callback, wp_json_encode( $data ) );

		wp_die();
	}

	/**
	 * Outputs a response to an AJAX request for the cart item number
	 */
	public function cart_item_number() {

		$data = wp_json_encode( [
			'status' => 'success',
			'data'   => [
				'cartItems' => function_exists( 'edd_get_cart_quantity' ) ? edd_get_cart_quantity() : 0,
			],
		] );

		header( 'Content-Type: text/javascript' );
		$callback = filter_input( INPUT_GET, 'callback' );
		printf( '%s(%s);', $callback, $data );

		wp_die();
	}

	/**
	 * Updates a product variation to a different one
	 */
	public function update_variation() {
		$download_id = filter_input( INPUT_POST, 'download_id' );
		$price_id    = filter_input( INPUT_POST, 'price_id' );

		if ( false === $download_id || false === $price_id ) {
			echo wp_json_encode( [
				'status' => 'error',
				'error'  => 'No download_id and price_id provided.',
			] );
			wp_die();
		}

		$old_download = edd_get_item_position_in_cart( $download_id );

		// Add first, then remove, to keep discount codes that might apply.
		edd_add_to_cart( $download_id, array( 'price_id' => $price_id ) );
		edd_remove_from_cart( $old_download );

		echo wp_json_encode( [
			'status' => 'success',
		] );
		wp_die();
	}

	/**
	 * Updates the list of available payment providers.
	 */
	public function update_payment_methods() {
		$country_code = filter_input( INPUT_POST, 'country_code' );
		$currency     = filter_input( INPUT_POST, 'currency' );

		if ( $country_code === false || $currency === false ) {
			echo wp_json_encode( [
				'status' => 'error',
				'error'  => __( 'No country code and currency provided.', 'yoastcom' ),
			] );
			wp_die();
		}

		$providers = new Payment_Method_Provider();

		echo wp_json_encode( [
			'status' => 'success',
			'html'   => get_template_part( 'html_includes/shop/payment-providers',
				[
					'return'    => true,
					'providers' => $providers->filter_by_currency_and_country( $currency, $country_code )
				] )
		] );
		wp_die();
	}
}
