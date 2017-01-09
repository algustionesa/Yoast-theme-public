<?php
namespace Yoast\YoastCom\Theme;

use Yoast\YoastCom\EDD\Alternate_Currency;

$item = $template_args['item'];
$id   = 'edd_cart_item_' . $template_args['key'] . '_' . $item['id'];

$readonly = false;
if ( isset( $template_args['readonly'] ) && $template_args['readonly'] ) {
	$readonly = true;
}
?>
<li
	class="grid <?php echo esc_attr( $template_args['class'] ); ?> edd_cart_item"
	id="<?php echo esc_attr( $id ); ?>"
	data-download-id="<?php echo esc_attr( $item['id'] ); ?>">
	<div class="three-seventh small-full checkout__title edd_cart_item_name">

		<div class="checkout-item__icon show-on-desktop"><?php
			$icon = get_product_icon( $item['id'] );
			if ( $icon ) {
				printf( '<img class="more__plug more__plug--small" src="%s" width="40" height="40" alt="">', esc_url( $icon ) );
			}
			?>
		</div>

		<?php the_checkout_item_title( $item['id'] ); ?>
	</div>
	<?php
	$variable_pricing = edd_has_variable_prices( $item['id'] );
	?>
	<div class="three-seventh medium-two-third small-full">
		<?php if ( $variable_pricing ) {
			if ( $readonly ) {
				get_template_part( 'html_includes/shop/pricing-option', array(
					'download_id' => $item['id'],
					'price_id'    => $item['options']['price_id'],
				) );
			}
			else {
				get_template_part( 'html_includes/shop/pricing-options', array(
					'id'       => $item['id'],
					'selected' => $item['options']['price_id'],
					'class'    => 'yst-edd-pricing-switcher',
					'label'    => '',
				) );
			}
		}
		elseif ( edd_item_quantities_enabled() ) { ?>
			<label>
				<?php _e( 'Amount', 'yoastcom' ); ?>
				<input type="number" min="1" step="1"
				       name="edd-cart-download-<?php echo $template_args['key']; ?>-quantity"
				       data-key="<?php echo $template_args['key']; ?>"
				       class="edd-input edd-item-quantity size-s"
				       value="<?php echo edd_get_cart_item_quantity( $item['id'], $item['options'] ); ?>"/>

				<input type="hidden" name="edd-cart-downloads[]" value="<?php echo $item['id']; ?>"/>
				<input type="hidden" name="edd-cart-download-<?php echo $template_args['key']; ?>-options"
				       value="<?php echo esc_attr( serialize( $item['options'] ) ); ?>"/>
			</label>
		<?php } ?>
	</div>
	<div class="checkout__price one-seventh medium-one-third small-full">
		<a href="<?php echo esc_url( edd_remove_item_url( $template_args['key'] ) ); ?>"
		   class="button--naked checkout__cancel edd_cart_remove_item_btn"><span class="text-icon">&#xf00d;</a>

		<?php
		echo esc_html(
			edd_currency_filter( edd_format_amount(
				edd_get_cart_item_price( $item['id'], $item['options'] ) *
				edd_get_cart_item_quantity( $item['id'], $item['options'] )
			) )
		);
		?>

	</div>
</li>
