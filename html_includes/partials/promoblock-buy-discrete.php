<?php

namespace Yoast\YoastCom\Theme;

theme_object()->excerpt->length( 30 );

$download_id = get_the_ID();
$download    = new \EDD_Download( $download_id );

$download_page_url = get_post_meta( $download_id, 'url', true );
if ( ! $download_page_url ) {
	$download_page_url = get_permalink( $download_id );
}


?>
	<div class="checkout-cross-sell__item">

		<div class="checkout-cross-sell__icon show-on-desktop"><?php

			$savings = get_template_part( 'html_includes/partials/more-save', array( 'return' => true, 'debug' => false ) );

			if ( empty( $savings ) ) {
				$icon = get_product_icon( $item['id'] );
				if ( $icon ) {
					$savings = sprintf( '<img class="more__plug more__plug--small" src="%s" width="55" height="55" />', esc_url( $icon ) );
				}
			}

			echo $savings;

			?></div>

		<div class="checkout-cross-sell__details">
			<div class="checkout-cross-sell__title"><a href="<?php echo $download_page_url ?>"
			                                           target="_blank"><?php the_title(); ?></a></div>

			<form id="buy-<?php echo $download_id ?>"
			      class="edd_download_purchase_form edd_purchase_<?php echo $download_id ?>" method="post">
				<input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart">
				<input type="hidden" name="download_id" value="<?php echo $download_id ?>">

				<?php
				if ( $download->has_variable_prices() ) {
					get_template_part( 'html_includes/shop/pricing-options', array(
						'name'      => 'edd_options[price_id][]',
						'id_prefix' => 'csau_download_',
						'label'     => '',
					) );
				}
				elseif ( edd_item_quantities_enabled() ) { ?>
					<label>
						<?php _e( 'Amount', 'yoastcom' ); ?>
						<input type="number" min="1" step="1"
						       name="edd_options[quantity]"
						       class="edd-input edd-item-quantity size-s"
						       value="1"/>
					</label>
					<?php
				}
				else {
					printf( '<div>%s</div>', str_replace( ' ', '', edd_currency_filter( $download->get_price() ) ) );
				}
				?>

				<button type="submit"
				        class="color-courses-secondary button--naked">&laquo; <?php _e( 'Add to cart', 'yoastcom' ); ?></button>
			</form>
		</div>
	</div>
	<?php

theme_object()->excerpt->clear();
