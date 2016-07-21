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

	/**
	 *
	 */
	function init_swipe_menu() {
		var swipeDistance = 75; //distance in pixels
		$( '.site' ).swipe( {
			swipeLeft: function() {
				if ( !$( 'body' ).attr( 'data-show-mobile-nav' ) ) { // if the mobile menu is not showing
					$( '#mobile-show-nav' ).trigger( 'click' );
				}
			}
		} );
		$( 'body' ).after().swipe( {
			swipeRight: function() {
				if ( $( 'body' ).attr( 'data-show-mobile-nav' ) ) { // if the mobile menu is showing
					$( '#mobile-show-nav' ).trigger( 'click' );
				}
			}
		} );

		// prevent clicking the link when the user tries to swipe the menu away. This is primarily a problem in desktop browsers.
		var menu_item_links = $( '.sub-menu-item a' );
		var startX;

		menu_item_links.on( "mousedown", function( evt ) {
			startX = evt.screenX;
		} );

		menu_item_links.on( 'click', function( evt ) {
			var distance = Math.abs( startX - evt.screenX );
			if ( distance >= swipeDistance ) {
				evt.preventDefault();
			}
		} );
	}


	init();
	init_swipe_menu();
	
} );
