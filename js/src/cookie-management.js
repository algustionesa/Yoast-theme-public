( function() {
	"use strict";

	/**
	 * Creates a cookie based on the given parameters.
	 *
	 * @param {string} name The name to use for the cookie.
	 * @param {string} value The value to set the cookie to.
	 * @param {Number} days The amount of days before the cookie expires.
	 * @param {string} [domain] The domain to associate the cookie with.
	 */
	function createCookie( name, value, days, domain ) {
		var extra = "; path=/";

		if ( days ) {
			var date = new Date();
			date.setTime( date.getTime() + (
					days * 24 * 60 * 60 * 1000
				) );
			extra += "; expires=" + date.toGMTString();
		}

		if ( domain ) {
			extra += "; domain=" + domain;
		}

		document.cookie = name + "=" + value + extra + "";
	}

	/**
	 * Looks up and reads a cookie by a given name.
	 *
	 * @param {string} name The name of the cookie to look for.
	 * @returns {string} The cookie's value.
	 */
	function readCookie( name ) {
		var nameEQ = name + "=";
		var cookieArguments = document.cookie.split( ';' );

		for ( var i = 0; i < cookieArguments.length; i ++ ) {
			var cookieArgument = cookieArguments[i];

			while ( cookieArgument.charAt( 0 ) == ' ' ) {
				cookieArgument = cookieArgument.substring( 1, cookieArgument.length );
			}

			if ( cookieArgument.indexOf( nameEQ ) == 0 ) {
				return cookieArgument.substring( nameEQ.length, cookieArgument.length );
			}
		}

		return null;
	}

	window.createCookie = createCookie;
	window.readCookie = readCookie;

} )();

