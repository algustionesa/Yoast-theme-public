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

		add_action( 'wp_ajax_yst_update_supported_currencies', array( $this, 'update_supported_currencies' ) );
		add_action( 'wp_ajax_nopriv_yst_update_supported_currencies', array( $this, 'update_supported_currencies' ) );

		add_action( 'wp_ajax_yst_update_current_currency', array( $this, 'update_current_currency' ) );
		add_action( 'wp_ajax_nopriv_yst_update_current_currency', array( $this, 'update_current_currency' ) );

		add_action( 'wp_ajax_yst_is_country_in_eu', array( $this, 'is_country_in_eu' ) );
		add_action( 'wp_ajax_nopriv_yst_is_country_in_eu', array( $this, 'is_country_in_eu' ) );
	}

	/**
	 * Detect currency
	 *
	 * @throws \InvalidArgumentException
	 */
	public function detect_currency() {
		$data = [ 'status' => 'error' ];

		if ( class_exists( Currency_Controller::class ) ) {
			$alternate_currency = Currency_Controller::get_instance();

			$data = [
				'status' => 'success',
				'data' => [
					'currency' => $alternate_currency->detect_currency(),
				],
			];
		}

		$this->create_callback( $data );

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

		$this->create_callback( $data );

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

	/**
	 * Updates the HTML based on the supported currencies.
	 */
	public function update_supported_currencies() {
		$billing_country = filter_input( INPUT_POST, 'billing_country' );

		if ( $billing_country === false ) {
			echo wp_json_encode( [
				'status' => 'error',
				'error'  => __( 'No country code provided.', 'yoastcom' ),
			] );
			wp_die();
		}

		echo wp_json_encode( [
			'status' => 'success',
			'menu_html' => get_template_part(
				'html_includes/shop/switch-currency',
				Checkout_HTML::get_currency_switch_template_arguments( '', false, $billing_country, true )
			),
			'html'   => get_template_part(
				'html_includes/shop/switch-currency',
				Checkout_HTML::get_currency_switch_template_arguments( 'I want to pay in', true, $billing_country, true )
			),
		] );

		wp_die();
	}

	/**
	 * Determines whether or not the posted country is in the European Union.
	 */
	public function is_country_in_eu() {
		$billing_country = filter_input( INPUT_POST, 'billing_country' );
		$is_in_eu = false;

		if ( class_exists( Currency_Controller::class ) ) {
			$currency_controller = Currency_Controller::get_instance();

			$is_in_eu = in_array( $billing_country, $currency_controller->get_eu_countries(), false );
		}

		echo wp_json_encode( [
			'status' => 'success',
			'display_vat' => $is_in_eu,
		] );

		wp_die();
	}

	/**
	 * Updates the current currency.
	 *
	 * @throws \InvalidArgumentException
	 */
	public function update_current_currency() {
		$currency = filter_input( INPUT_POST, 'currency' );

		if ( class_exists( Currency_Controller::class ) ) {
			$currency_controller = Currency_Controller::get_instance();
			$currency_controller->set_currency( $currency );

			$this->create_callback( [
				'status' => 'success',
				'data' => [
					'currency' => $currency_controller->detect_currency(),
				],
			] );

			wp_die();
		}

		echo wp_json_encode( [
			'status' => 'error',
			'error'  => __( 'Could not update currency.', 'yoastcom' ),
		] );

		wp_die();
	}

	/**
	 * Creates a valid JavaScript callback method.
	 *
	 * @param array $data The data to pass to the callback.
	 */
	private function create_callback( $data ) {
		header( 'Content-Type: text/javascript' );
		$callback = filter_input( INPUT_GET, 'callback' );
		printf( '%s(%s);', $callback, wp_json_encode( $data ) );
	}
}
