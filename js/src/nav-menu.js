jQuery( document ).ready( function( $ ) {

	/**
	 * Sets jQuery event listeners to improve the visual flow of 'current menu item parents'.
	 */
	function init() {
		var parent_class = 'current-menu-parent';
		var active_item = $( '.current-menu-parent' );
		var non_active_items = $( '#yoast-main-menu .menu-item:not(.current-menu-parent)' );

		non_active_items.hover(
			function() {
				active_item.removeClass( parent_class );
			},
			function() {
				active_item.addClass( parent_class );
			}
		);

		/**
		 * Set the clicked menu item as the new parent, unbind current event listeners and reinitialise the event listeners for the new 'current parent'.
		 */
		non_active_items.click( function( evt ) {
			var clicked_menu_item = $( evt.target ).closest( '.menu-item' );
			clicked_menu_item.addClass( parent_class );
			non_active_items.unbind( 'hover' );
			non_active_items.unbind( 'click' );
			init();
		} );
	}


	function init_disable_scroll() {
		// The show/hide menu event is bound later and, by jQuery standards, will be executed later.
		// So, when checking if the menu is showing it actually says: the menu is going to be hidden very soon.

		$( '#mobile-show-nav' ).click( function() {
			if ( $( 'body' ).attr( 'data-show-mobile-nav' ) ) { // if the mobile menu is showing.
				enable_scroll();
			} else {
				disable_scroll();
			}
		} );
	}

	function disable_scroll() {
		var top = $( 'html' ).scrollTop() || $( 'body' ).scrollTop();
		$( 'html' ).addClass( 'no-scroll' );
		$( 'html' ).css( { 'top': -top } );
	}

	function enable_scroll() {
		var topPx = $( 'html' ).css( 'top' );
		var top = Math.abs( parseInt( topPx ) );

		$( 'html' ).removeClass( 'no-scroll' );
		$( 'html' ).css( { 'top': undefined } );
		$( 'body' ).scrollTop( top );
	}

	init();
	init_disable_scroll();
} );
