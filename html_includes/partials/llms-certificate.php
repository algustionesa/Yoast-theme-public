<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;
if ( is_user_admin() ) {
	show_admin_bar( false );
}

$academy_overview = apply_filters( 'yoast:url', 'academy_overview');

$is_public = isset( $template_args['is_public'] ) && true === $template_args['is_public'];

// Prevent the syllabus from showing.
remove_filter( 'the_content', 'llms_get_post_content' );

$certificate_id = get_post_meta( get_the_ID(), 'connected_certificate', true );
$certificate    = get_post( $certificate_id );
setup_postdata( $certificate );

$postmeta = get_post_meta( $certificate_id );

$certificate_title = $postmeta['_llms_certificate_title'][0];

$certimage_id = $postmeta['_llms_certificate_image'][0]; // Get Image Meta
$certimage    = wp_get_attachment_image_src( $certimage_id, 'print_certificate' ); //Get Right Size Image for Print Template

if ( $certimage == '' ) {
	$certimage        = apply_filters( 'lifterlms_placeholder_img_src', LLMS()->plugin_url() . '/assets/images/optional_certificate.png' );
	$certimage_width  = 800;
	$certimage_height = 616;
} else {
	$certimage_width  = $certimage[1];
	$certimage_height = $certimage[2];
	$certimage        = $certimage[0];
}

$certificate = new LLMS_Certificate;

?><!DOCTYPE html>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width">
	<meta name="robots" content="noindex,follow">

	<title><?php echo get_the_title(); ?> <?php _e( 'Certificate', 'yoastcom' ); ?></title>

	<?php $certificate_url_dir = plugins_url(); // Declare Plugin Directory ?>

	<link href="<?php echo get_template_directory_uri(); ?>/css/certificate.min.css" rel="stylesheet" media="all">

	<!--Make Background White to Print certificate -->
	<style type='text/css'>
		.llms-certificate-container {
			background-image: url(<?php echo $certimage; ?>);
		}
	</style>
	<?php //wp_head(); ?>
</head>
<body>
<main role="main">
	<div class="llms-certificate-container">
		<div id="certificate-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="llms-summary">
				<?php llms_print_notices(); ?>

				<?php do_action( 'before_lifterlms_certificate_main_content' ); ?>


				<h1><?php echo $certificate_title; ?></h1>

				<div class="contents">
					<?php
					remove_filter( 'the_content', 'wpautop' );
					the_content();
					add_filter( 'the_content', 'wpautop' );
					?>
				</div>
			</div>
		</div>
	</div>
	<?php if ( $is_public ) : ?>
		<section class="certificate-cta row iceberg">
			<a href="<?php echo $academy_overview ?>courses/"
			   class="button default"><?php _e( 'View all our courses on yoast.com', 'yoastcom' ); ?></a>
		</section>
	<?php else : ?>
		<div id="llms-print-certificate" class="no-print row">
			<button type="button" class="default"
			        onclick="window.print();"><?php _e( 'Print certificate', 'yoastcom' ); ?></button>
		</div>

		<section class="clear certificate-badge no-print row theme-courses">
			<h2><?php _e( 'Show your certificate on your site, implement our badge.', 'yoastcom' ); ?></h2>

			<?php $badge_html = \Yoast\YoastCom\Academy\get_badge_html( get_the_ID(), get_current_user_id() ); ?>

			<div class="alignleft badge-preview">
				<h3><?php _e( 'Badge preview', 'yoastcom' ); ?></h3>
				<?php echo $badge_html; ?>
			</div>

			<div class="alignleft">
				<h3><?php _e( 'Badge HTML', 'yoastcom' ); ?></h3>

				<p><?php _e( 'Use this HTML to display the badge on your site:', 'yoastcom' ); ?></p>
				<textarea cols="60" rows="5"><?php echo esc_textarea( $badge_html ); ?></textarea>
			</div>
		</section>
	<?php endif; ?>
</main>

</body>
