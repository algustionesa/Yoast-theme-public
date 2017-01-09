<?php
/**
 * @package Yoast\YoastCom
 */

namespace Yoast\YoastCom\Theme;

$hide_vat = true;
if ( 0 != edd_get_cart_tax() ) {
	$hide_vat = false;
}
?>
<div class="purchase_summary alignright">
	<table>
		<tr><th colspan="2"><?php _e( 'Purchase summary', 'yoastcom' ); ?></th></tr>
		<tr class="edd_cart_tax_row"<?php ( ( $hide_vat ) ? 'style="display:none;"' : '' ); ?>>
			<th class="edd_cart_tax">
				<?php _e( 'VAT', 'yoastcom' ); ?>
				(<span id="yst_secondary_tax_rate"><?php echo esc_html( edd_get_tax_rate() ); ?></span>%)
			</th>
			<th class="edd_cart_item_price">
				<span class="edd_cart_tax_amount" id="yst_secondary_tax"><?php echo esc_html( edd_cart_tax() ); ?></span>
			</th>
		</tr>
		<tr>
			<th><?php _e( 'Total', 'yoastcom' ); ?>:</th>
			<th class="edd_cart_amount"><?php echo esc_html( edd_cart_total( false ) ); ?></th>
		</tr>
	</table>
</div>
