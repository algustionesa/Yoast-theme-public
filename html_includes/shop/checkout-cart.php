<?php
namespace Yoast\YoastCom\Theme;
?>

<div id="edd_checkout_cart" class="checkout<?php if ( ! edd_is_ajax_disabled() ) {
	echo ' ajaxed';
} ?>">
	<?php $cart_items = edd_get_cart_contents(); ?>
	<div class="row">
		<ul class="list--unstyled checkout__products">
			<?php foreach ( $cart_items as $key => $cart_item ) : ?>
				<?php get_template_part( 'html_includes/shop/checkout-item', array(
					'class'    => '',
					'item'     => $cart_item,
					'key'      => $key,
					'readonly' => cart_is_renewal(),
				) ); ?>

				<?php if ( download_has_discount( $cart_item ) ) : ?>
					<?php $discounts = download_get_discounts( $cart_item['id'] ); ?>
					<?php foreach ( $discounts as $discount ) : ?>
						<?php get_template_part( 'html_includes/shop/discount-item', array(
							'discount'  => $discount,
							'cart_item' => $cart_item,
						) ); ?>
					<?php endforeach; ?>
				<?php endif; ?>

				<?php if ( cart_has_renewal_discount() ) : ?>
					<?php $percentage = cart_get_renewal_discount(); ?>
					<?php get_template_part( 'html_includes/shop/checkout-renewal', array(
						'percentage' => $percentage,
						'cart_item'  => $cart_item,
					) ); ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</div>

	<?php $discounts = get_global_discounts(); ?>
	<?php if ( ! empty( $discounts ) ) : ?>

		<hr class="hr--no-pointer tight hr__before-global-discount">

		<div class="row">
			<ul class="list--unstyled">
				<?php foreach ( $discounts as $i => $discount ) : ?>
					<?php get_template_part( 'html_includes/shop/discount-item', array(
						'discount' => $discount,
						'title'    => ( ( 0 === $i ) ? __( 'Discount', 'yoastcom' ) : '' ),
					) ); ?>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
	<?php

	if ( class_exists( 'edd_dp' ) ) {
		$edd_dp          = \edd_dp::instance();
		$discount_amount = $edd_dp->discounts->get_discount();
		if ( ! empty( $discount_amount ) ) {
			?>
			<hr class="hr--no-pointer tight hr__before-global-discount">

			<div class="row">
				<ul class="list--unstyled">
					<?php get_template_part( 'html_includes/partials/discount-item-flat', array(
						'title'  => __( 'Discount', 'yoastcom' ),
						'amount' => edd_currency_filter( edd_format_amount( $discount_amount ), edd_get_currency() ),
					) ); ?>
				</ul>
			</div>
			<?php
		}
	}
	?>


	<hr class="hr--no-pointer tight">

	<?php if ( edd_use_taxes() && cart_has_tax() ) : ?>
		<div class="row iceberg--small">
			<div class="grid">
				<div
					class="three-seventh offset-three-seventh medium-two-third small-half checkout__cart-price checkout__cart-cart--subtotal"><?php _e( 'Subtotal', 'yoastcom' ); ?></div>
				<div class="one-seventh medium-one-third small-half edd_cart_subtotal_amount">
					<?php echo esc_html( edd_currency_filter( edd_format_amount( edd_get_cart_subtotal() - edd_get_cart_discounted_amount() ) ) ); ?>
				</div>
			</div>
		</div>

		<?php if ( ! edd_prices_show_tax_on_checkout() ) : ?>
			<div class="row iceberg--small">
				<div class="grid">
					<div
						class="three-seventh offset-three-seventh medium-two-third small-half checkout__cart-price checkout__cart-cart--vat">
						<?php printf( __( 'VAT (<span class="yst-tax-rate">%s</span>%%)', 'yoastcom' ), number_format( ( edd_get_tax_rate() * 100 ), 1 ) ); ?>
					</div>
					<div class="one-seventh medium-one-third small-half">
						<span class="edd_cart_tax_amount" id="yst_main_tax"
						      data-tax="<?php echo esc_attr( edd_get_cart_tax() ); ?>">
							<?php echo esc_html( edd_currency_filter( edd_format_amount( edd_get_cart_tax() ) ) ); ?>
						</span>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<hr class="hr--no-pointer tight hr__after-tax">
	<?php endif; ?>

	<div class="row iceberg--small">
		<div class="grid">
			<div class="three-seventh medium-one-third hide-on-mobile">
				<?php if ( 2 === get_checkout_step() ) : ?>
					<a href="<?php echo esc_url( url_shop_page() ); ?>"
					   class="link--naked"><?php _e( '&laquo; Continue shopping', 'yoastcom' ); ?></a>
				<?php endif; ?>
			</div>
			<div
				class="three-seventh medium-one-third small-half checkout__cart-price checkout__cart-price--total"><?php _e( 'Total', 'yoastcom' ); ?></div>
			<div class="one-seventh medium-one-third small-half edd_cart_total">
				<span class="edd_cart_amount" data-subtotal="<?php echo esc_attr( edd_get_cart_total() ); ?>"
				      data-total="<?php echo esc_attr( edd_get_cart_total() ); ?>">
					<?php edd_cart_total(); ?>
				</span>
			</div>
		</div>
	</div>
</div>
