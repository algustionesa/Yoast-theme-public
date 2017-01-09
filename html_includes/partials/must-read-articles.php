<?php
namespace Yoast\YoastCom\Theme;

if ( ! isset( $template_args['class1'] ) ) {
	$template_args['class1'] = '';
}

if ( ! isset( $template_args['class2'] ) ) {
	$template_args['class2'] = '';
}

$args = array( 'posts_per_page' => 3, 'post__not_in' => array( get_the_ID() ), 'term_id' => $template_args['term_id'] );

$posts_query = query_must_read_articles( $args );

if ( $posts_query->have_posts() ) :
?>
<div class="row iceberg">
	<h3 class="color-courses--secondary"><?php printf( __( ' Must read articles about %s' ), get_the_archive_title() ); ?></h3>

	<div class="grid">
		<?php
		theme_object()->excerpt->length( 8 );
		theme_object()->excerpt->more( ' &hellip; &raquo;' );
		?>
		<?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
			<div class="one-third">
				<div class="promoblock <?php echo esc_attr( $template_args['class1'] ); ?>">
					<a href="<?php the_permalink(); ?>" class="hide-on-tablet">
						<?php the_post_thumbnail( 'thumbnail-recent-articles' ); ?>
					</a>
					<h3 class="h4"><a href="<?php the_permalink(); ?>"
					                  class="<?php echo esc_attr( $template_args['class2'] ); ?>"><?php the_title(); ?></a>
					</h3>
					<?php post_meta_desc(); ?>
				</div>
			</div>
		<?php endwhile;
		wp_reset_postdata();
		theme_object()->excerpt->clear(); ?>
	</div>
</div>
<?php
endif;
