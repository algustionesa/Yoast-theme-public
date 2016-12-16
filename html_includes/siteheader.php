<?php

namespace Yoast\YoastCom\Theme;

$yoast_url = apply_filters( 'yoast:domain', 'yoast.com' );

?>
<header role="banner" class="siteheader">

	<div class="row masthead">
		<a href="<?php echo $yoast_url; ?>" class="pagetitle"><span class="visuallyhidden">Yoast</span></a>

		<?php get_template_part( 'html_includes/header-controls-mobile' ); ?>
		<?php get_template_part( 'html_includes/partials/search' ); ?>
	</div>

	<?php

	theme_object()->navigation->output_menu_bar();
	?>
</header>
