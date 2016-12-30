<?php

namespace Yoast\YoastCom\Theme;

$forced_currency = apply_filters( 'yoast_detect_visitor_currency', null );

/*
 * If we have switched currencies (and must provide a way to switch back)
 * or the current currency is not the default one
 */
if ( is_null( $forced_currency ) ) {
	$options = '';
	$prefix = $template_args['label'];

	foreach ( $template_args['options'] as $option => $label ) {
		$selected = ( $option === $template_args['current'] ) ? ' selected="selected"' : '';
		$options .= sprintf('<option value="%1$s"%3$s>%2$s</option>', $option, $label, $selected );
	}

	$display = ( count( $template_args['options'] ) === 1 ) ? ' style="display: none;" ' : '';

	$output = sprintf(
		'%s<select class="yst_currency_switch_dropdown"%s>%s</select>',
		$prefix,
		$display,
		$options
	);

	if ( $template_args['wrap'] === true ) {
		$output = sprintf(
			'<div class="yst_currency_switch"%s>%s<select class="yst_currency_switch_dropdown">%s</select></div>',
			$display,
			$prefix,
			$options
		);
	}

	echo $output;
}
