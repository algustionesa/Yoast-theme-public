<?php
namespace Yoast\YoastCom\Theme;

$category = '';
if ( isset( $template_args['category'] ) ) {
	$category = $template_args['category'];
}

$plugins = query_plugins( array(
	'post_type'      => 'yoast_plugins',
	'posts_per_page' => 25,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'post__not_in'   => array( 302 ),
	'tax_query'      => array(
		array(
			'taxonomy' => 'yoast_plugin_category',
			'field'    => 'slug',
			'terms'    => $category,
		)
	)
) );

$term = get_term_by( 'slug', $category, 'yoast_plugin_category' );

?>

<div class="one-third">
	<div class="promoblock arrowed-small">
		<h2 class="h4"><?php echo esc_html( $term->name ); ?></h2>
		<p class="hide-on-mobile">
			<?php echo esc_html( $term->description ); ?>
		</p>

		<ul class="list list--unstyled list--plugin hide-on-mobile">
			<?php while ( $plugins->have_posts() ) :
				$plugins->the_post();
				$title = get_the_title(); ?>
				<li>
					<a href="<?php the_permalink(); ?>" class=""><?php echo $title ?>&nbsp;&raquo;</a>
					<a href="<?php the_permalink(); ?>" class="text-icon link--naked pull-right more-info"><span class="screen-reader-text"><?php printf( __( 'More information about %s', 'yoastcom' ), $title ); ?></span>&#xf05a;</a>
					<a href="<?php echo esc_url( url_plugin_download() ); ?>" class="text-icon link--naked pull-right" aria-label="<?php echo esc_attr( sprintf( __('Download %s', 'yoastcom'), $title ) ) ?>">&#xf01a;</a>
				</li>
			<?php
			endwhile;

			wp_reset_postdata();
			?>
		</ul>
	</div>
</div>
