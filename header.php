<?php
namespace Yoast\YoastCom\Theme;
?><!DOCTYPE html>
<!--[if lte IE 9]><html class="old-ie" lang="en"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en"><!--<[endif]-->
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php wp_title(); ?></title>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php

do_action( 'yst_body_open' );

$banner = get_theme_option( 'banner', 'child-settings' );
$show_banner = get_theme_option( 'show_banner', 'child-settings' );
$class = get_theme_option( 'banner_theme_class', 'child-settings' );
$variation = get_theme_option( 'banner_theme_variation', 'child-settings' );
$variation = ( ! empty( $variation ) ? ' ' . $variation : $variation );

if ( $show_banner === "on" && ! empty( $banner ) ) { ?>
	<div class="announcement-banner theme-<?php echo $class; ?>">
		<div class="decoration<?php echo $variation; ?>"></div>
		<div class="accent<?php echo $variation; ?>"></div>
		<div class="row">
			<?php echo $banner; ?>
		</div>
		<div class="decoration<?php echo $variation; ?> right"></div>
	</div>
<?php

}
