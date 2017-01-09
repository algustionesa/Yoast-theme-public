<?php
/**
 * @package Yoast\YoastCom
 *
 * Theme functions.php
 */

namespace Yoast\YoastCom\Theme;

require_once( dirname( __FILE__ ) . '/php/functions-helpers.php' );
require_once( dirname( __FILE__ ) . '/php/functions-links.php' );
require_once( dirname( __FILE__ ) . '/php/functions-checkout.php' );

spl_autoload_register( function( $classname ) {
	if ( false !== strpos( $classname, 'Yoast\\YoastCom\\Theme\\' ) ) {
		$classname = str_replace( 'Yoast\\YoastCom\\Theme\\', '', $classname );

		$classname = strtolower( $classname );
		$classname = str_replace( '_', '-', $classname );

		require_once( dirname( __FILE__ ) . '/php/class-' . $classname . '.php' );
	}
});

/**
 * Return the instantiated theme object
 *
 * @return Theme
 */
function theme_object() {
	static $theme_object;

	if ( ! isset( $theme_object ) ) {
		$theme_object = new Theme();
	}

	return $theme_object;
}

theme_object();

// Comment to test submodule push. #3
