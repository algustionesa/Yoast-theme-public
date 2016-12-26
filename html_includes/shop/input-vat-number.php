<?php
/**
 * @package Yoast\YoastCom
 */

namespace Yoast\YoastCom\Theme;

$vat_nr = '';
if ( isset( $_POST['yst_btw'] ) ) {
	$vat_nr = $_POST['yst_btw'];
}
?>
<p id="yst-edd-btw-wrap" style="display: none;">
	<label for="yst_btw" class="edd-label">
		<?php _e( 'VAT number (optional)', 'yoast-theme' ); ?>
		<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
	</label>
	<span class="edd-description"><?php _e( 'If you have a company with a valid VAT number, please enter it here, it will be checked automatically. If it checks out OK, you won&#8217;t have to pay VAT.', 'yoast-theme' ); ?></span>
	<input type="text" id="yst_btw" name="yst_btw" class="edd-input ignore" placeholder="<?php _e( 'Enter a valid VAT number', 'yoast-theme' ); ?>" value="<?php echo esc_attr( $vat_nr ); ?>" />
</p>
<?php
