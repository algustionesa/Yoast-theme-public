<?php
/**
 * @package Yoast\YoastCom
 */

namespace Yoast\YoastCom\Theme;

/**
 * Handles all the customization to the EDD checkout functionality
 */
class Checkout {

	/**
	 * Constructor
	 */
	public function __construct() {
		// VAT related functions.
		add_action( 'wp_ajax_yst_check_vat', array( $this, 'ajax_check_vat' ) );
		add_action( 'wp_ajax_nopriv_yst_check_vat', array( $this, 'ajax_check_vat' ) );
		add_action( 'edd_checkout_error_checks', array( $this, 'validate_btw_nr' ), 10, 2 );
		add_filter( 'edd_payment_meta', array( $this, 'add_btw_nr_to_payment' ) );
		add_filter( 'edd_purchase_data_before_gateway', array( $this, 'maybe_remove_tax' ) );
		add_filter( 'edd_purchase_form_required_fields', array( $this, 'fix_state_required' ), 10 );
	}

	/**
	 * Check a given VAT number with the europe VIES check
	 *
	 * @param string $country The country code to check with the VAT number.
	 * @param string $vat_nr  The VAT number to check.
	 *
	 * @return bool|null
	 */
	private function check_vat( $country, $vat_nr ) {

		$country = trim( $country );
		$vat_nr  = trim( $vat_nr );

		// Exception for Greece:
		if ( strtoupper( $country ) === 'GR' ) {
			$country = 'EL';
		}

		// Strip all spaces from the VAT number to improve usability of the VAT field.
		$vat_nr = str_replace( ' ', '', $vat_nr );

		if ( 0 === strpos( $vat_nr, $country ) ) {
			$vat_nr = trim( substr( $vat_nr, strlen( $country ) ) );
		}

		if ( empty( $vat_nr ) ) {
			return 0;
		}

		try {
			// Do the remote request.
			$client = new \SoapClient( 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl' );

			$returnVat = $client->checkVat( array(
				'countryCode' => $country,
				'vatNumber'   => $vat_nr,
			) );
		} catch ( \Exception $e ) {

			if ( $e->getMessage() === 'INVALID_INPUT' ) {
				return 0;
			}

			error_log( 'VIES API Error for ' . $country . ' - ' . $vat_nr . ': ' . $e->getMessage() );

			echo $e->getMessage();
			return 2;
		}

		// Return the response.
		if ( isset( $returnVat ) ) {
			return $returnVat->valid ? 1 : 0;
		}

		// Return null if the service is down.
		return 2;
	}

	/**
	 * Status codes:
	 *
	 * 0 : False, invalid VAT number
	 * 1 : True, valid VAT number
	 * 2 : Service is down
	 *
	 * @todo ADD NONCES GODDAMNIT
	 */
	public function ajax_check_vat() {
		$result = 0;
		if ( isset( $_POST['country'] ) && isset( $_POST['vat_nr'] ) ) {
			$result = $this->check_vat( $_POST['country'], $_POST['vat_nr'] );
		}

		echo $result;
		exit;
	}

	/**
	 * Check for errors with out custom fields
	 *
	 * @param array $valid_data Unused.
	 * @param array $data       The data filled in by the customer.
	 */
	public function validate_btw_nr( $valid_data, $data ) {
		if ( ! empty( $data['yst_btw'] ) ) {
			$vat_response = $this->check_vat( $data['billing_country'], $data['yst_btw'] );

			if ( 0 === $vat_response ) {
				edd_set_error( 'yst_btw', __( 'We cannot verify this VAT number, this means you will have to pay VAT. Please make sure you\'ve entered the number correctly.', 'yoastcom' ) );
			} elseif ( 2 === $vat_response ) {
				edd_set_error( 'yst_btw_unavailable', __( 'We cannot check if your VAT number is correct because the VAT checking system for the EU is currently down. We\'re sorry for the inconvenience. Please try again later.', 'yoastcom' ) );
			}
		}
	}

	/**
	 * Store the custom field data in the payment meta
	 *
	 * @param array $payment_meta The payment meta that will be saved in the database.
	 *
	 * @return array
	 */
	public function add_btw_nr_to_payment( $payment_meta ) {
		$payment_meta['btw_nr'] = isset( $_POST['yst_btw'] ) ? sanitize_text_field( $_POST['yst_btw'] ) : '';

		return $payment_meta;
	}

	/**
	 * @param array $purchase_data The purchase data for the payment.
	 *
	 * @return array
	 */
	public function maybe_remove_tax( $purchase_data ) {

		if ( empty( $purchase_data['post_data']['yst_btw'] ) ) {
			return $purchase_data;
		}

		// If the customer is based in the Netherlands, leave VAT intact.
		if ( 'NL' === strtoupper( $purchase_data['post_data']['billing_country'] ) ) {
			return $purchase_data;
		}

		// If we get to this point with a VAT nr, we can assume it's correct (validate_btw_nr takes care of the validation).
		// Subtract tax from the total price.
		$purchase_data['price'] = ( $purchase_data['price'] - $purchase_data['tax'] );

		// Update cart with new price information.
		if ( ! empty( $purchase_data['cart_details'] ) && is_array( $purchase_data['cart_details'] ) ) {
			foreach ( $purchase_data['cart_details'] as $item_key => & $item_value ) {
				// Subtract tax from the current cart item.
				$item_value['price'] = ( $item_value['price'] - $item_value['tax'] );
			}
			unset( $item_value );
		}

		$purchase_data = $this->remove_tax_from_purchase_data( $purchase_data );

		return $purchase_data;
	}

	/**
	 * Make sure the tax is not applied multiple times.
	 *
	 * @param array $purchase_data
	 *
	 * @return array
	 */
	protected function remove_tax_from_purchase_data( $purchase_data ) {
		$purchase_data['tax'] = 0.00;

		if ( ! empty( $purchase_data['cart_details'] ) && is_array( $purchase_data['cart_details'] ) ) {
			foreach ( $purchase_data['cart_details'] as $item_key => & $item_value ) {
				$item_value['tax'] = 0.00;
			}
			unset( $item_value );
		}

		return $purchase_data;
	}

	/**
	 * @param array $required_fields
	 *
	 * @return array
	 */
	public function fix_state_required( $required_fields ) {
		if ( isset( $_POST['billing_country'] ) && 'US' != $_POST['billing_country'] && 'CA' != $_POST['billing_country'] ) {
			unset( $required_fields['card_state'] );
		}

		return $required_fields;
	}

}
