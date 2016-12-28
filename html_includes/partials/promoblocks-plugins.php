<?php
namespace Yoast\YoastCom\Theme;

$categories = array();
if ( isset( $template_args['categories'] ) ) {
	$categories = $template_args['categories'];
}

$args = array(
	'posts_per_page' => 25,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
);

if ( isset ( $template_args['included'] ) ) {
	$args['post__in'] = $template_args['included'];
}

if ( isset ( $template_args['excluded'] ) ) {
	$args['post__not_in'] = $template_args['excluded'];
}


if ( ! empty( $categories ) ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'yoast_plugin_category',
			'field'    => 'term_id',
			'terms'    => $categories,
		),
	);
}

$plugins = query_plugins( $args );

echo '<div class="grid">';

while ( $plugins->have_posts() ) : $plugins->the_post();
	get_template_part( 'html_includes/partials/promoblock-plugin' );
endwhile;

echo '</div>';

