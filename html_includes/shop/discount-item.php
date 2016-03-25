<?php
namespace Yoast\YoastCom\Theme;

$discount  = $template_args['discount'];
$cart_item = false;
if ( ! empty( $template_args['cart_item'] ) ) {
	$cart_item = $template_args['cart_item'];
}

$title = '';
if ( ! empty( $template_args['title'] ) ) {
	$title = $template_args['title'];
}
?>
<li class="grid edd_cart_item item-discount">

	<?php if ( $title ) : ?>
		<div class="three-seventh">
			<div class="checkout-item__icon"></div>
			<strong><?php echo esc_html( $title ); ?></strong>
		</div>
	<?php endif; ?>
	<div class="three-seventh<?php if ( ! $title ) : ?> offset-three-seventh<?php endif; ?>">
		<?php echo esc_html( $discount['name'] ); ?>
	</div>
	<div class="one-seventh">
		<?php if ( $cart_item ) : ?>
			<?php echo esc_html( edd_currency_filter( edd_format_amount( ( -1 * edd_get_cart_item_discount_amount( $cart_item ) ) ) ) ); ?>
		<?php else : ?>
			<?php echo esc_html( edd_currency_filter( edd_format_amount( ( -1 * edd_get_cart_discounted_amount() ) ) ) ); ?>
		<?php endif; ?>
	</div>
</li>
