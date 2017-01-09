<?php
namespace Yoast\YoastCom\Theme;

$title = '';
if ( ! empty( $template_args['title'] ) ) {
	$title = $template_args['title'];
}
$description = '';
if ( ! empty( $template_args['description'] ) ) {
	$description = $template_args['description'];
}
$amount = '';
if ( ! empty( $template_args['amount'] ) ) {
	$amount = $template_args['amount'];
}


/*
 * Make sure we only display the UPGRADE discount once per cart
 *
 * Otherwise the discount will be distributed over all products with the same ID
 * as the discounted product.
 */

?>
<li class="grid edd_cart_item item-discount">

	<?php if ( $title ) : ?>
		<div class="three-seventh">
			<div class="checkout-item__icon show-on-desktop"></div>
			<strong><?php echo esc_html( $title ); ?></strong>
		</div>
	<?php endif; ?>
	<div class="three-seventh<?php if ( ! $title ) : ?> offset-three-seventh<?php endif; ?>">
		<?php echo esc_html( $description ); ?>
	</div>
	<div class="one-seventh">
		<?php echo $amount ?>
	</div>
</li>
