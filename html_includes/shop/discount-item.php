<?php
namespace Yoast\YoastCom\Theme;

$discount = $template_args['discount'];
$cart_item = false;
if ( ! empty( $template_args['cart_item'] ) ) {
	$cart_item = $template_args['cart_item'];
}

$title = '';
if ( ! empty( $template_args['title'] ) ) {
	$title = $template_args['title'];
}

/*
 * Make sure we only display the UPGRADE discount once per cart
 *
 * Otherwise the discount will be distributed over all products with the same ID
 * as the discounted product.
 */
if ( false === $cart_item || substr( $discount['code'], 0, strlen( 'UPGRADE' ) ) !== 'UPGRADE' ) :
	?>
	<li class="grid edd_cart_item item-discount">

		<?php if ( $title ) : ?>
			<div class="three-seventh">
				<div class="checkout-item__icon show-on-desktop"></div>
				<strong><?php echo esc_html( $title ); ?></strong>
			</div>
		<?php endif; ?>
		<div class="three-seventh<?php if ( ! $title ) : ?> offset-three-seventh<?php endif; ?>">
			<?php echo esc_html( $discount['name'] ); ?>
		</div>
		<div class="one-seventh">
			<?php if ( $cart_item ) : ?>
				<?php echo esc_html( edd_currency_filter( edd_format_amount( ( - 1 * edd_get_cart_item_discount_amount( $cart_item ) ) ) ) ); ?>
			<?php else : ?>
				<?php echo esc_html( edd_currency_filter( edd_format_amount( ( - 1 * edd_get_cart_discounted_amount() ) ) ) ); ?>
			<?php endif; ?>
		</div>
	</li>
	<?php
endif;
