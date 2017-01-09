<?php
namespace Yoast\YoastCom\Theme;

$cart_item  = $template_args['cart_item'];
$percentage = $template_args['percentage'];

$cart_items      = edd_get_cart_content_details();
$discount_amount = 0;
foreach ( $cart_items as $item ) {
	$current_discount = $item['discount'];
	$discount_amount += ( edd_sl_cart_details_item_discount( $current_discount, $item ) - $current_discount );
}
$discount_amount *= -1;
if ($discount_amount) :
	$discount_amount = edd_currency_filter( edd_format_amount( $discount_amount ) );
	?>
<li class="grid edd_cart_item item-discount">
	<div class="three-seventh offset-three-seventh">
		<?php printf( __( 'License renewal discount: %s', 'edd_sl' ), $percentage . '%' ); ?>
	</div>
	<div class="one-seventh">
		<?php echo esc_html( $discount_amount ); ?>
	</div>
</li>
<?php
endif;
