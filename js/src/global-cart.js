(function( $ ) {
	'use strict';

	var $body;

	function init() {
		$body = $(document.body);

//		retrieveGlobalCartItemNumber();
		handleShowCoupon();
	}

	function retrieveGlobalCartItemNumber() {
		$.getJSON(
			YoastAjax.ajaxurl + '?callback=?',
			{ action: 'cart_item_number' },
			handleGlobalCartItemNumber
		);
	}

	function handleGlobalCartItemNumber( response ) {
		if ( 'success' === response.status ) {
			var $container = $( '.cart .num-items' );
			$container.html( response.data.cartItems );

			if ( response.data.cartItems > 0 ) {
				$container.addClass( 'has-items' );
			}
			else {
				$container.removeClass( 'has-items' );
			}
		}
	}

	/**
	 * If a user places ?show_coupon in the URL, set a cookie to show the coupon field.
	 */
	function handleShowCoupon() {
		var query_vars = document.location.search;

		if ( '?show_coupon' === query_vars ) {
			document.cookie = 'yst_edd_discount=1; path=/';

			document.location.href = document.location.href
				.replace( document.location.search, '' )
				.replace( document.location.hash, '' );
		}
	}

	$( init );
}( jQuery ));
