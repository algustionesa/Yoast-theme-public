<?php

namespace Yoast\YoastCom\Theme;

$forced_currency = apply_filters( 'yoast_detect_visitor_currency', null );

/*
 * If we have switched currencies (and must provide a way to switch back)
 * or the current currency is not the default one
 */
if ( is_null( $forced_currency ) ) {

	$to_euros_class = $to_dollars_class = '';

	/** @noinspection PhpUndefinedVariableInspection */
	if ( $template_args['current'] === 'USD' ) {
		$to_dollars_class = ' selected="selected"';
	}

	if ( $template_args['current'] === 'EUR' ) {
		$to_euros_class = ' selected="selected"';
	}

	// I want to pay in USD [switch to EUR]
	// I want to pay in EUR [switch to USD]
	$toggle = sprintf( __( '%s', 'yoastcom' ), '<select class="yst_currency_switch_dropdown"><option value="%1$s"%3$s>%1$s %2$s</option><option value="%4$s"%6$s>%4$s %5$s</option></select>' );

	echo sprintf( $toggle, 'USD', '($)', $to_dollars_class, 'EUR', '(&euro;)', $to_euros_class );
}
