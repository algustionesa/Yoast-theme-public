<?php

namespace Yoast\YoastCom\Theme;

/** @noinspection PhpUndefinedVariableInspection */
$menu_items = $template_args['menu_items'];
$menu_type  = $template_args['menu_type'];

echo '<ul class="yoast-' . $menu_type . '-menu">';

foreach ( $menu_items as $menu_item ) {

	$class = ( ! empty( $menu_item['classes'] ) ? ' class="' . implode( ' ', $menu_item['classes'] ) . '"' : '' );
	echo '<li' . $class . '>';

	if ( $menu_type === 'footer' ) {
		$menu_item['anchor_classes'][] = "h4";
	}

	get_template_part( 'html_includes/partials/navigation-menu-link', array(
		'menu_item' => $menu_item,
		'type'      => $menu_type
	) );

	if ( ! empty( $menu_item['children'] ) ) {

		echo '<div class="yoast-sub-menu">';
		get_template_part( 'html_includes/partials/navigation-menu-list', array(
			'menu_items' => $menu_item['children'],
			'menu_type'  => 'sub'
		) );

		echo '</div>';
	}
	echo '</li>';
}

if ( 'main' !== $menu_type ) {
	echo '</ul>';
}
