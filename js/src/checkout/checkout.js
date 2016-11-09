(function( $ ) {
	'use strict';

	var $body;

	function init() {
		$body = $(document.body);

		initCheckoutPage();
		bindCurrencySwitch();

		$body.ready( disableAutocompleteDiscount );
	}

	function bindCurrencySwitch() {
		$( window ).on( 'currency_switched', function() {
			recalculate_taxes();
			displaySupportedPaymentMethods();
		} );
	}

	function initCheckoutPage() {
		$body.on( 'edd_quantity_updated', handleQuantityUpdate );
		$body.on( 'change', '.yst-edd-pricing-switcher', handleChangeDownloadVariation );
		$body.on( 'edd_cart_billing_address_updated', hideProvinceField );
		$( '#billing_country' ).on( 'change', displaySupportedPaymentMethods );

		$(document).ajaxComplete(reloadOnFreeCart);

		$( '#edd_first' ).focus();
	}

	function reloadOnFreeCart( event, xhr, settings ) {
		if ( settings.url !== edd_global_vars.ajaxurl) {
			return;
		}

		if ( typeof xhr.responseJSON === 'undefined' ) {
			return;
		}

		var discount_response = xhr.responseJSON;
		if ( discount_response && discount_response.msg == 'valid') {
			if( '0.00' == discount_response.total_plain ) {
				location.reload();
			}
		}
	}

	/**
	 * Updates the price after the product after a quantity update
	 *
	 * @param {jQuery.Event} e
	 * @param {Object} data
	 */
	function handleQuantityUpdate( e, data ) {
		EDD_Checkout.recalculate_taxes();
	}

	/**
	 * Handles a change to the download variation by the user
	 *
	 * @param {jQuery.Event} e
	 */
	function handleChangeDownloadVariation( e ) {
		var $this = $( e.currentTarget );

		var download_id = $this.data( 'download-id' );
		var price_id = $this.val();

		var postData = {
			action: 'yst_update_variation',
			download_id: download_id,
			price_id: price_id
		};

		$.ajax({
			type: "POST",
			data: postData,
			dataType: "json",
			url: edd_global_vars.ajaxurl,
			xhrFields: {
				withCredentials: true
			}
		}).success(function( response ) {
			if ( 'success' === response.status ) {
				EDD_Checkout.recalculate_taxes();
			}
		});
	}

	/**
	 * If a country has no states, hide the province field
	 *
	 * @param {jQuery.Event} e
	 * @param {String} data
	 */
	function hideProvinceField( e, data ) {
		if ( 'nostates' === data ) {
			$( '#edd-card-state-wrap' ).hide();
		} else {
			$( '#edd-card-state-wrap' ).show();
		}
	}

	function disableAutocompleteDiscount() {
		$( '#edd-discount' ).attr( "autocomplete", "off" );
	}

	function displaySupportedPaymentMethods() {
		var country_code = $( '#billing_country' ).val();
		var currency = $( '.yst_currency_switch_dropdown' ).val();
		var payment_options_list = $( '#yst-payment-methods-list' )

		if ( country_code === '' ) {
			payment_options_list.text( YoastI18n.select_country );
			return;
		}

		if ( currency === '' ) {
			payment_options_list.text( YoastI18n.select_currency );
			return;
		}

		$.ajax({
			type: "POST",
			data: {
				country_code: country_code,
				currency: currency
			},
			dataType: "json",
			url: YoastAjax.admin + '?action=yst_update_payment_methods',
			beforeSend: function() {
				payment_options_list.text( YoastI18n.loading + '...' );
			}
		}).success(function( response ) {
			if ( 'success' === response.status ) {
				payment_options_list.html( response.html );
			}
		});
	}

	$( init );
}( jQuery ));
