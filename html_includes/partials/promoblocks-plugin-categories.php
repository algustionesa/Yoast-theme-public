<?php
namespace Yoast\YoastCom\Theme;
?>
<div class="grid">
	<?php foreach ( array( 'analytics-and-metrics-plugins', 'wordpress-comments', 'functionality-plugins', 'fixes-and-tweaks', 'deprecated-plugins', ) as $i => $category ) : ?>
		<?php get_template_part( 'html_includes/partials/promoblock-plugin-category', array(
			'category' => $category,
		) ); ?>
	<?php endforeach; ?>
</div>
