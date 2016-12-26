(
	function( $ ) {
		'use strict';

		/**
		 * Intializes the checkout.
		 */
		function init() {
			$( document ).ready( bindEvents );
			$( document ).ready( detectCurrency );
		}

		/**
		 * Binds the events necessary for the currency switching.
		 */
		function bindEvents() {
			$( document ).on( 'edd_cart_billing_address_updated', function() {
				detectCurrency( $( '#billing_country' ).val() );
			});

			$( document ).on( 'change', '.yst_currency_switch_dropdown', function( event ) {
				switchCurrency( $( this ).val() );
			} );
		}

		/**
		 * Shows the currency.
		 *
		 * @param {string} currency The currency to display.
		 * @returns {void}
		 */
		function showCurrency( currency ) {
			$( '.yst_currency_switch_dropdown' ).val( currency );

			// Switch price fields to reflect currency change
			$( '.yoast-currency' ).addClass( 'hidden' );
			$( '.yoast-currency__' + currency ).removeClass( 'hidden' );
		}

		/**
		 * Detects the currency based on the passed country code.
		 *
		 * @param string country The country to look up a currency for.
		 * @returns {void}
		 */
		function detectCurrency( country ) {
			if ( typeof country !== "string" ) {
				country = null;
			}

			$.ajax( {
				url: YoastAjax.admin + '?callback=?&action=detect_currency',
				data: { billing_country: country},
				dataType: 'json',
				type: 'post',
				success: function( response ) {
					switchCurrency( response.data.currency, true );
				}
			} );
		}

		/**
		 * Switches the currency based on the passed variable.
		 *
		 * @param {string} to_currency The currency to switch to.
		 * @param {boolean} [force] Force the currency.
		 * @returns {boolean} Whether or not the currency was successfully switched.
		 */
		function switchCurrency( to_currency, force ) {
			var current_currency = readCookie( 'yoast_cart_currency' );

			if ( to_currency === null ) {
				to_currency = 'USD';
			}

			if ( force === false && current_currency === to_currency ) {
				return false;
			}

			$.ajax( {
				url: YoastAjax.admin + '?callback=?&action=yst_update_current_currency',
				data: {
					currency: to_currency,
					billing_country: $( '#billing_country').val(),
				},
				dataType: 'json',
				type: 'post',
				beforeSend: function() {
					createCookie( 'yoast_cart_currency', to_currency, 356, '.yoast.com' );
					createCookie( 'yoast_cart_currency', to_currency, 356, '.yoast.dev' );
				},
				success: function() {
					showCurrency( to_currency );

					$( window ).trigger( 'currency_switched' );
				}
			} );
		}

		$( init );
	}
)( jQuery );
