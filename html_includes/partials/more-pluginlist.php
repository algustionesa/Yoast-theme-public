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
	'post__not_in' => ['247896','99668'], // Exclude GA + GA eCommerce.
);

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

?>
<?php while ( $plugins->have_posts() ) : $plugins->the_post(); ?>
	<a href="<?php the_permalink(); ?>" class="more">
		<?php $icon = get_product_icon(); ?>
		<?php if ( $icon ) : ?>
			<img src="<?php echo esc_url( $icon ); ?>" class="more__plug show-on-desktop" width="40" height="40" alt="" />
		<?php endif; ?>
		<div class="more__holder more__holder--left">
			<div class="more__title"><?php the_title(); ?></div>
			<div class="more__subtitle hide-on-tablet"><!-- Byline --></div>
		</div>
		<div class="more__pointer more__link arrowed hide-on-mobile"><?php _e( 'More about this plugin', 'yoastcom' ); ?></div>
	</a>
<?php endwhile; wp_reset_postdata(); ?>
