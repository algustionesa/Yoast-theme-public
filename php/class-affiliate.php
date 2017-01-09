<?php
/**
 * @package Yoast\YoastCom
 */

namespace Yoast\YoastCom\Theme;

/**
 * Class Affiliate
 * @package Yoast\YoastCom\Theme
 *
 *
 * @see     edd_receipt_shortcode()
 *
 * Test with ?payment_key=[purchase_key] to load a specific purchase
 */

class Affiliate {

	const ACCOUNT_ID = '2747-a0800c';
	const GROUP = 'yoast';

	public function __construct() {
		// This is hooked just after the <body> tag.
		add_action( 'yst_body_open', array( $this, 'output_affiliate_code' ) );

		add_action( 'edd_complete_purchase', array( $this, 'set_conversion_cookie' ) );
	}

	/**
	 * Communicate conversion details to JavaScript
	 *
	 * @param int $payment_id Payment ID of the completed purchase.
	 */
	public function set_conversion_cookie( $payment_id ) {
		$payment = new \EDD_Payment( $payment_id );
		if ( empty( $payment->ID ) ) {
			return;
		}

		$commissions = $this->get_commissions( $payment );

		$arguments = json_encode( array(
			'account_id'  => self::ACCOUNT_ID,
			'order_id'    => $payment->ID,
			'commissions' => $commissions,
			'group'       => self::GROUP,
		) );

		setcookie( 'yst_affiliate_conversion', $arguments, 0, '/' );
	}

	/**
	 * Output the HTML/JS needed to track affiliate
	 */
	public function output_affiliate_code() {
		get_template_part( 'html_includes/partials/affiliate-code', array( 'account_id' => self::ACCOUNT_ID ) );
	}

	/**
	 * Build a list of commissions
	 *
	 * Logic has been extracted from [edd]/templates/shortcode-receipt.php
	 *
	 * @param \EDD_Payment $payment Payment.
	 *
	 * @return array
	 */
	private function get_commissions( $payment ) {
		$output = array();

		$cart = edd_get_payment_meta_cart_details( $payment->ID, true );

		if ( ! $cart || array() === $cart ) {
			return $output;
		}

		// Make sure we use the default currency (USD) for affiliate details.
		add_filter( 'yoast_edd_currency_override', '__return_false' );

		$commissions = array();

		foreach ( $cart as $key => $item ) {
			$amount_override = null;

			// We parse the bundle as item, not the individual products inside.
			if ( $item['in_bundle'] ) {
				continue;
			}

			$download_id = $item['id'];
			$price_id    = edd_get_cart_item_price_id( $item );

			/*
			 * Use the price of the option when it was present
			 */
			if ( edd_has_variable_prices( $download_id ) && ! is_null( $price_id ) ) {
				$amount_override = edd_get_price_option_amount( $download_id, $price_id );
			}

			/*
			 * Get payment meta
			 * Needed to get the discount from the order
			 */
			$payment_meta = $payment->get_meta();
			$price        = edd_get_download_final_price( $download_id, $payment_meta['user_info'], $amount_override );

			/*
			 * Determine the commission type based on taxonomy or bundle
			 */
			if ( edd_is_bundled_product( $download_id ) ) {
				$commission_type = 'bundle';
			} else {
				$commission_type = 'other';

				/** @var \WP_Term[] $terms */
				$terms = get_the_terms( $item['id'], 'download_category' );
				if ( count( $terms ) === 1 ) {

					$commission_type = $terms[0]->slug;
				}
			}

			$commissions[ $commission_type ][] = $price;
		}

		// Clean up the filter to force default currency.
		remove_filter( 'yoast_edd_currency_override', '__return_false' );

		/*
		 * Group by download_category taxonomy
		 * Format:
		 * sub_amount: {number}
		 * commission_type: '{taxonomy}'
		 */
		if ( $commissions ) {
			foreach ( $commissions as $commission => $prices ) {
				$output[] = array(
					'sub_amount'      => array_sum( $prices ),
					'commission_type' => $commission,
				);
			}
		}

		return $output;
	}
}
