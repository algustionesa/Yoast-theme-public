<?php
namespace Yoast\YoastCom\Theme;

$categories = query_categories( array( 'number' => 3, 'orderby' => 'rand' ) );
?>
<?php foreach ( $categories as $category ) : ?>
	<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="more more--naked color-courses">
		<div class="more__holder more__holder--naked more__holder--left">
			<div class="more__supertitle"><?php echo esc_html( $category->name ); ?></div>
			<div class="more__sublink"><?php echo get_term_meta( $category->term_id, 'yoastcom_term_shortdesc', true ); ?></div>
		</div>
	</a>
<?php endforeach; ?>
