<?php


namespace Yoast\YoastCom\Theme;


class Video_Modal {

	/**
	 * Adds the video modal to the footer.
	 *
	 * @param $args The shortcode args.
	 */
	public static function add_video_modal( $args ) {

		$add_modal_to_footer = array( __CLASS__, 'video_modal' );
		if ( ! has_action( 'wp_footer', $add_modal_to_footer ) ) {
			add_action( 'wp_footer', $add_modal_to_footer );
		}
	}

	/**
	 * Adds the video modal to the footer and renders a piece of script to open the modal with.
	 */
	public static function video_modal() {
		add_action( 'wp_footer', array( __CLASS__, 'footer_modal_script' ), 90 );
		get_template_part( '/html_includes/partials/video-modal' );
		wp_enqueue_script( 'jquery-modal' );
	}

	/**
	 * Renders the script to open the modal with.
	 */
	public static function footer_modal_script() {
		?>
		<script>
			jQuery( document ).ready( function( $ ) {
				$( 'a.open-video-modal' ).click( function( e ) {
					var anchor = $( e.target).closest('a');

					// Update the modal.
					$( '#video-modal-title' ).text( anchor.data( 'title' ) );
					console.log(anchor[0]);
					console.log(anchor.attr('href'));
					$( '#video-modal-frame' ).attr( 'src', anchor.attr( 'href' ) );

					// Open the modal.
					e.preventDefault();
					$( '#video-modal' ).modal( {
						closeText: '<i class="fa fa-times-circle"></i>'
					} );

				} );

			} );
		</script>
		<?php
	}
}
