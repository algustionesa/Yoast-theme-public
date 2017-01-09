<?php
namespace Yoast\YoastCom\Theme;
?>
	<header role="banner"
	        class="siteheader <?php if ( isset( $template_args['home'] ) ) : ?> siteheader--home<?php endif; ?>" <?php if ( isset( $template_args['home'] ) ) : ?> data-header-home<?php endif; ?>>

		<?php if ( isset( $template_args['home'] ) ) : ?>
			<div class="row masthead">
				<h1 class="home-title">
					<a href="<?php echo esc_attr( home_url() ); ?>" class="pagetitle pagetitle--home"><span
							class="visuallyhidden">Yoast</span></a>
				</h1>

				<p class="h2 tagline">
					<?php echo esc_html( get_bloginfo( 'description' ) ); ?>
				</p>

				<?php get_template_part( 'html_includes/header-controls-mobile' ); ?>
				<?php get_template_part( 'html_includes/partials/search', array( 'type' => 'mobile' ) ); ?>
			</div>

		<?php endif; ?>

		<?php if ( isset( $template_args['home-sub'] ) ) : ?>
			<div class="row masthead">
				<a href="<?php echo esc_attr( home_url() ); ?>" class="pagetitle">
					<span class="visuallyhidden">Yoast</span>
				</a>

				<?php get_template_part( 'html_includes/header-controls-mobile' ); ?>
			</div>
		<?php endif; ?>

		<?php theme_object()->navigation->output_menu_bar(); ?>
	</header>

<?php

if ( isset( $template_args['home'] ) ) {
	get_template_part( 'html_includes/partials/fullbanner-home' );
}
