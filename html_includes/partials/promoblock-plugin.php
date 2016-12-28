<?php
namespace Yoast\YoastCom\Theme;

use Yoast\YoastCom\RemoteCheckout\Remote_Purchase_Button;

?>

<div class="one-third medium-one-half small-full">
	<div class="promoblock">
		<?php echo do_shortcode( '[video_modal title="Temporary video" video_url="https://www.youtube.com/embed/YlUsuNzETx4"]' ); ?>

		<h3 class="h4">
			<a href="<?php echo get_the_permalink(); ?>">
				<?php echo the_title( '', ' &raquo;' ) ?>
			</a>
		</h3>

		<?php
		$usps = post_meta( 'usps' );

		//filter out empty arrays.
		if ( is_array( $usps ) ) {
			$usps = array_filter( $usps );
		}

		get_template_part( 'html_includes/partials/list-usp', array( 'usps' => wp_list_pluck( (array) $usps, 'usp' ) ) );

		$download_id = post_meta( 'download_id' );
		if ( $download_id ) {
			$remote_purchase_button = new Remote_Purchase_Button();
			echo $remote_purchase_button->add_to_cart_button( array(
				'id'   => intval( $download_id ),
				'text' => __( 'Buy Yoast SEO Premium', 'yoastcom' ) . ' &raquo;',
			) );
		}
		?>

	</div>
</div>
