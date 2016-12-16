<?php
namespace Yoast\YoastCom\Theme;

$plugins = query_plugins(
	array(
		'posts_per_page' => -1,
		'orderby' => 'rand',
		'tax_query' => array(
			array(
				'taxonomy' => 'yoast_plugin_category',
				'field'    => 'term_id',
				'terms'    => array( 303, 407 ),
			),
		),
	)
);

$i = 0;

?>

<div class="js-random-show-items" data-show-items="2">

<?php while ( $plugins->have_posts() ) : $plugins->the_post(); ?>
	<?php $icon = get_product_icon(); ?>
	<a href="<?php the_permalink(); ?>" class="more color-courses hidden js-random-show-item">
		<?php if ( $icon && 0 === ( $i % 2 ) ) : ?>
			<img src="<?php echo esc_url( $icon ); ?>" class="more__plug show-on-desktop" width="40" height="40" />
		<?php endif; ?>
		<div class="more__holder arrowed-small">
			<div class="more__title"><?php the_title(); ?></div>
			<small class="more__link hide-on-tablet"><?php printf( __( 'More about %s', 'yoastcom' ), get_the_title() ); ?> &raquo;</small>
		</div>
		<?php if ( $icon && 1 === ( $i++ % 2 ) ) : ?>
			<img src="<?php echo esc_url( $icon ); ?>" class="more__plug show-on-desktop" width="40" height="40" />
		<?php endif; ?>
	</a>
<?php endwhile; wp_reset_postdata(); ?>
</div>
