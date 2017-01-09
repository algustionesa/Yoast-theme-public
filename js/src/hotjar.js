(function() {
	function add_tracking_code( h, o, t, j, a, r ) {
		h.hj = h.hj || function() {(h.hj.q = h.hj.q || []).push( arguments )};
		h._hjSettings = {hjid: a, hjsv: r};
		a = o.getElementsByTagName( 'head' )[0];
		r = o.createElement( 'script' );
		r.async = 1;
		r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
		a.appendChild( r );
	}

	if ( typeof window.yoast_hotjar !== 'undefined' ) {
		add_tracking_code( window, document, '//static.hotjar.com/c/hotjar-', '.js?sv=', window.yoast_hotjar.id, window.yoast_hotjar.sv );
	}
})();
