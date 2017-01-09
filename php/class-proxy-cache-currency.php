<?php

namespace Yoast\YoastCom\Theme;

use Yoast\YoastCom\VisitorCurrency\Currency_Controller;

class Proxy_Cache_Currency implements Proxy_Cache_Module_Interface {

	/**
	 * @return array
	 */
	public function get_vary_options() {
		// Not sure if we should always set the header or only when it is different.
		/*
		$is_switched = isset( $_COOKIE['yoast_currency_switched'] ) ? $_COOKIE['yoast_currency_switched'] : false;

		$currency_controller = Currency_Controller::get_instance();
		if ( $currency_controller->get_currency() !== $currency_controller->get_default_currency() || $is_switched ) {
			return array( 'X-Currency' );
		}
		*/

		return array( 'X-Currency' );
	}

	/**
	 * @return null
	 */
	public function set_headers() {
		$currency_controller = Currency_Controller::get_instance();
		header( 'X-Currency: ' . $currency_controller->get_currency() );
	}
}
