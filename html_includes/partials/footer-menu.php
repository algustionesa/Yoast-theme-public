<?php

namespace Yoast\YoastCom\Theme;

if ( class_exists( 'Yoast\YoastCom\Menu\Menu_Structure' ) ) {

	/** @noinspection PhpUndefinedVariableInspection */
	$menu_items = $template_args['menu_data'];

	echo '<div class="grid">';

	foreach ( $menu_items as $item ) {
		echo '<div class="one-third medium-one-half small-full">';
		echo '<div class="promoblock arrowed-medium widget_nav_menu theme-' . $item['type'] . '">';
		get_template_part( 'html_includes/partials/navigation-menu-list', array(
			'menu_items' => array( $item ),
			'menu_type'  => 'footer'
		) );
		echo '</div>';
		echo '</div>';
	}
	echo '</div>'; // grid

	echo '<div class="boxes boxes--footer"></div>';
}
else {
	?>
	<div class="grid">
		<div class="one-third medium-one-half small-full">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>

		<div class="one-third hide-on-tablet">
			<?php dynamic_sidebar( 'footer-2' ); ?>
		</div>

		<div class="one-third medium-one-half small-full">
			<?php dynamic_sidebar( 'footer-3' ); ?>
		</div>
	</div>

	<div class="boxes boxes--footer"></div>
	<?php
}
