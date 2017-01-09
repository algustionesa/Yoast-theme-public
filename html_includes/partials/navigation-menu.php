<?php

namespace Yoast\YoastCom\Theme;

if ( class_exists( 'Yoast\YoastCom\Menu\Menu_Structure' ) ) {

	/** @noinspection PhpUndefinedVariableInspection */
	$main_menu_items = $template_args['menu_data'];

	echo '<div id="yoast-main-menu" class="sticky" data-sticky-desktop data-sticky>';
	echo '<nav role="navigation">';

	get_template_part( 'html_includes/partials/navigation-menu-list', array(
		'menu_items' => $main_menu_items,
		'menu_type'  => 'main'
	) );

	echo '<li class="controls">';

//	echo '<a href="' . apply_filters( 'yoast:domain', 'my.yoast.com' ) . '">';
//	echo '<span class="fa fa-user"></span>login';
//	echo '</a>';

	echo '<a class="cart" href="' . apply_filters( 'yoast:url', 'checkout' ) . '">';
	echo '<img src="' . get_template_directory_uri() . '/images/cart.svg" alt="' . esc_attr( __( 'Shopping Cart', 'yoastcom' ) ) . '" />';
	echo '<span class="visuallyhidden focusable">' . esc_html( __( 'Cart', 'yoastcom' ) ) . '</span>';
	echo '<div class="num-items-container"><span class="num-items"></span></div>';
	echo '</a>';

	// Only for Yoast.com & my.yoast.com:
	if ( class_exists( 'Yoast\YoastCom\VisitorCurrency\Currency_Controller' ) ) {
		get_template_part( 'html_includes/partials/navigation-currency-switcher', Checkout_HTML::get_currency_switch_template_arguments() );
	}

	echo '</li>';

	echo '</ul>'; // main menu
	echo '</nav>'; // nav holder

	echo '</div>'; // main menu id
}
else {
	?>
	<nav role="navigation" class="sitenav sticky" data-sticky data-sticky-desktop aria-hidden="true">
		<?php wp_nav_menu( array(
			'theme_location'  => 'primary',
			'container_class' => 'mainnav',
			'walker'          => new Menu_Walker(),
		) );
		?>
	</nav>

	<nav role="navigation" class="sitenav sitenav--offcanvas">
		<?php wp_nav_menu( array(
			'theme_location'  => 'primary',
			'container_class' => 'mainnav',
			'walker'          => new Menu_Walker(),
		) );
		?>
	</nav>
	<?php
}
