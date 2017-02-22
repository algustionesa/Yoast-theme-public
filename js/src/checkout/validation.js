;(
	function( $ ) {
		var $body;

		var VATDetails = {
			valid: false,
			number: '',
			country: ''
		};

		var VATStatistics = function() {
			this.startTime = 0;
			this.endTime = 0;
			this.duration = 0;

			if ( typeof __gaTracker !== "undefined" ) {
				this.tracker = __gaTracker;
			}
			else {
				this.tracker = function() {
				};
			}
		};

		VATStatistics.prototype.start = function() {
			this.startTime = new Date().getTime();
			this.endTime = 0;
			this.duration = 0;

			this.tracker( 'send', 'event', 'checkout', 'vat-check', 'start' );
		};

		VATStatistics.prototype.end = function() {
			this.endTime = new Date().getTime();
			this.duration = this.endTime - this.startTime;
		};

		VATStatistics.prototype.notVerified = function() {
			this.end();

			this.tracker( 'send', 'event', 'checkout', 'vat-check', 'cannot verify', this.duration );
		};

		VATStatistics.prototype.failed = function() {
			this.end();

			this.tracker( 'send', 'event', 'checkout', 'vat-check', 'failed', this.duration );
		};

		VATStatistics.prototype.success = function() {
			this.end();

			this.tracker( 'send', 'event', 'checkout', 'vat-check', 'ok', this.duration );
		};

		var vatStatistics = new VATStatistics();

		/**
		 * Checks the VAT NR with the VIES API
		 */
		function checkVATNumber( country, vat_number ) {
			// We can't determine the validity without a country and VAT number.
			if ( country === '' || vat_number === '' ) {
				return;
			}

			var $spinner = $( '#yst-edd-btw-wrap .fa-spinner' );
			$spinner.addClass( 'show' );

			vatStatistics.start();

			VATDetails.country  = country;
			VATDetails.number   = vat_number;
			VATDetails.valid    = null;

			var xhr = jQuery.post( yoast_com_checkout_vars.ajaxurl, {
				action: 'yst_check_vat',
				country: country,
				vat_nr: vat_number
			}, function( response ) {
				$spinner.removeClass( 'show' );
				$( '#vaterror' ).remove();

				if ( '1' == response ) {
					$( '#yst_btw' ).removeClass( 'error' ).addClass( 'valid' );

					VATDetails.valid = true;
					vatStatistics.success();
				}
				else if ( '2' == response ) {
					// Show error, the service is down
					$( '#yst_btw' ).removeClass( 'valid' ).addClass( 'error' );

					jQuery( "#yst-edd-btw-wrap" ).append( '<span id="vaterror" class="error">We cannot check if your VAT number is correct because the VAT checking system for the EU is currently down. We\'re sorry for the inconvenience. Please send us an email on <a href="mailto:support@yoast.com">support@yoast.com</a> or try again later.</span>' );

					VATDetails.valid = false;
					vatStatistics.failed();
				}
				else {
					$( '#yst_btw' ).removeClass( 'valid' ).addClass( 'error' );

					jQuery( "#yst-edd-btw-wrap" ).append( '<span id="vaterror" class="error">We cannot verify this VAT number, this means you will have to pay VAT. Please make sure you\'ve entered the number correctly.</span>' );

					VATDetails.valid = false;
					vatStatistics.notVerified();
				}
			} );

			// If we fail, try again in a second.
			xhr.fail( function() {
				setTimeout( checkVATNumber, 1000 );
			} );
		}

		/**
		 * Rounds a price to two decimal places.
		 *
		 * @param {int} price The initial price.
		 * @returns {int} The rounded price with two decimal places.
		 */
		function roundPrice( price ) {
			return Math.round( price * 100 ) / 100;
		}

		/**
		 * Determines whether or not the current VATDetails global is a valid, non-Dutch tax rate.
		 *
		 * @returns {boolean} Whether or not the tax rate is considered valid.
		 */
		function isValidNonDutchTaxRate() {
			return VATDetails.valid == true && VATDetails.country !== 'NL' && taxData.tax_rate_raw !== 0;
		}

		/**
		 * Fixes the tax in the UI after everything has been recalculated by EDD
		 *
		 * @param {jQuery.Event} e
		 * @param {Object} data Data returned by the EDD AJAX.
		 *
		 * @returns {void}
		 */
		function fixTaxAfterRecalculation( e, data ) {
			var taxData = data.response;
			var billing_country = data.postdata.billing_country;

			if ( billing_country !== '' ) {
				displayVATField( billing_country );
			}

			if ( isValidNonDutchTaxRate() ) {
				taxData.total_raw = taxData.total_raw - parseFloat( taxData.tax_raw );

				taxData.tax_raw = 0;
				taxData.tax_rate_raw = 0;
				taxData.tax_rate = '0%';

				// Format fancy prices
				taxData.total   = '$ ' + roundPrice( taxData.total_raw );
				taxData.tax     = '$' + roundPrice( taxData.tax_raw );

				$( '.edd_cart_amount' ).html( taxData.total );
				$( '.yst-tax-rate' ).html( taxData.tax_rate.replace( '%', '' ) );
				$( '.edd_cart_tax_amount' ).html( taxData.tax );
			}

			var secondaryTax = $( '#yst_secondary_tax_rate' );

			if ( secondaryTax.length > 0 ) {
				secondaryTax.html( taxData.tax_rate.replace( '%', '' ) );
			}

			$( '#yst_secondary_tax' ).html( taxData.tax );

		}

		/**
		 * Hides or shows the state field based on the selected country.
		 *
		 * @returns {void}
		 */
		function hideOrShowStateField() {
			var $billingCountry = $( '#billing_country' );
			var billingCountry = $billingCountry.val();
			if ( '' === billingCountry ) {
				$( '#edd-card-state-wrap' ).hide();
			}
			else {
				// Trigger a 'change' in the billing country so EDD can 'fix' the state field.
				$billingCountry.trigger( 'change' );
			}
		}

		/**
		 * Determines whether or not the VAT field should be displayed based on the country.
		 *
		 * @param {string} country The country to check.
		 * @returns {void}
		 */
		function displayVATField( country ) {
			$.ajax( {
				url: YoastAjax.admin + '?action=yst_display_vat_input',
				data: { billing_country: country },
				dataType: 'json',
				type: 'post',
				success: function( response ) {
					if ( response.display_vat === true ) {
						showVATElements();
					} else {
						hideVATElements();
					}

					displayVATWarning( country );
				}
			} );
		}

		/**
		 * Hides or shows the VAT Number field based on the selected country.
		 *
		 * @returns {void}
		 */
		function hideOrShowVATNumber( taxData ) {
			var billingCountry = $( '#billing_country' ).val();

			// Don't display the VAT number input field unless we support said country.
			hideVATElements();
			$( '#yst-dutch-vat-notice' ).remove();

			// No special BTW rule for The Netherlands
			if ( billingCountry === 'NL' ) {
				showVATElements();
				displayVATWarning( billingCountry );
			}

			// Check if the country is in our special tax list
			if ( taxData && taxData.tax_rate_raw === 0 ) {
				hideVATElements();
				return;
			}
		}

		/**
		 * Adds the VAT warning to the DOM.
		 *
		 * @returns {void}
		 */
		function addVATWarning() {
			$( '#yst-edd-btw-wrap' ).after( '<p id="yst-dutch-vat-notice" style="display: none;"><strong>Please note:</strong> Since Yoast is based in the Netherlands we cannot reverse charge the VAT.<br />VAT will be added to the invoice.</p>' );
		}

		/**
		 * Displays or hides the VAT warning.
		 *
		 * @param {string} country The country to check.
		 *
		 * @returns {void}
		 */
		function displayVATWarning( country ) {
			console.log( $( '#yst-dutch-vat-notice' ).length );
			if ( country !== 'NL' ) {
				$( '#yst-dutch-vat-notice' ).hide();

				return;
			}

			$( '#yst-dutch-vat-notice' ).show();
		}

		/**
		 * Shows the VAT-related fields and information.
		 *
		 * @returns {void}
		 */
		function showVATElements() {
			$( '#yst-edd-btw-wrap' ).show();
			$( '.edd_cart_tax_row' ).css( 'display', 'table-row' );
		}

		/**
		 * Hides the VAT-related fields and information.
		 *
		 * @returns {void}
		 */
		function hideVATElements() {
			$( '#yst-edd-btw-wrap' ).hide();
			$( '.edd_cart_tax_row' ).css( 'display', 'none' );
		}


		function initChosen() {
			$( ".chosen-select" ).chosen();
			$body.on( 'edd_cart_billing_address_updated', function() {
				// Remove the old chosen select box.
				$( '#edd-card-state-wrap .chosen-container' ).remove();

				// Chosenfy the new select box.
				$( 'select[name="card_state"]' ).chosen();
			} );
		}

		jQuery( document ).ready( function( $ ) {
			$body = $( 'body' );

			hideOrShowStateField();
			hideOrShowVATNumber();
			addVATWarning();
			initChosen();

			$body.on( 'edd_taxes_recalculated', fixTaxAfterRecalculation );

			$( '#card_number' ).payment( 'formatCardNumber' );
			$( '#card-cvc' ).payment( 'formatCardCVC' );

			$( '#card_number' ).on( "input", function() {
				if ( $.payment.validateCardNumber( $( this ).val() ) ) {
					$( this ).removeClass( 'error' ).addClass( 'valid' );
				}
				else {
					$( this ).removeClass( 'valid' ).addClass( 'error' );
				}

				if ( $( "#card_cvc" ).val() != '' ) {
					if ( $.payment.validateCardCVC( $( "#card_cvc" ).val(), $.payment.cardType( $( this ).val() ) ) ) {
						$( "#card_cvc" ).removeClass( 'error' ).addClass( 'valid' );
					}
					else {
						$( "#card_cvc" ).removeClass( 'valid' ).addClass( 'error' );
					}
				}
			} );

			$( '#card_cvc' ).on( "input", function() {
				if ( $.payment.validateCardCVC( $( this ).val(), $.payment.cardType( $( '#card_number' ).val() ) ) ) {
					$( this ).removeClass( 'error' ).addClass( 'valid' );
				}
				else {
					$( this ).removeClass( 'valid' ).addClass( 'error' );
				}
			} );

			$( '#card_exp_year' ).on( "input", function() {
				var month = $( '#card_exp_month' ).val();
				var year = $( this ).val();

				if ( 4 === year.length ) {
					year = year.slice( - 2 );
					$( this ).val( year );
					return;
				}

				if ( month != '' ) {
					if ( $.payment.validateCardExpiry( month, year ) ) {
						$( 'edd-input-cvc' ).removeClass( 'error' ).addClass( 'valid' );
					}
					else {
						$( 'edd-input-cvc' ).removeClass( 'valid' ).addClass( 'error' );
					}
				}
			} );

			// validate signup form on keyup and submit
			$( "#edd_purchase_form" ).validate( {
				unhighlight: function( el, error, valid, _orig ) {
					if ( el.type === "radio" ) {
						this.findByName( el.name ).removeClass( error ).addClass( valid );
					}
					else if ( ! $( el ).hasClass( 'ignore' ) ) {
						$( el ).removeClass( error ).addClass( valid );
					}
					else {
						$( el ).removeClass( error ).removeClass( valid );
					}
				},
				errorClass: 'error error-message',
				rules: {
					edd_email: {
						required: true,
						email: true
					},
					edd_first: "required",
					card_name: "required",
					card_address: {
						required: true,
						minlength: 2
					},
					card_city: {
						required: true,
						minlength: 2
					},
					card_zip: {
						required: true,
						minlength: 2
					},
					billing_country: "required",
					card_state: "required",

					edd_agree_to_terms: "required"
				},
				messages: {
					edd_first: "Please enter your first name",
					edd_email: "Please enter a valid email address",
					edd_agree_to_terms: "<strong>Error</strong> - Please accept our terms: ",
					card_name: "Please enter the name on your credit card",
					card_address: "Please enter your billing address",
					card_zip: "Please enter your zip / postal code",
					card_state: "Please enter your state",
					card_city: "Please enter your city",
					billing_country: "Please enter your country"
				}
			} );

			$body.on( "change", "#yst_btw, #billing_country, #card_state", function() {
				var vat_number = $( '#yst_btw' ).val();
				var billingCountry = $( '#billing_country' ).val();

				checkVATNumber( billingCountry, vat_number );

				// Re-calculate taxes based on current country and state.
				EDD_Checkout.recalculate_taxes();
			} );
		} );
	}( jQuery )
);
