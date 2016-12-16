<?php
/**
 * Template Name: Single category
 */

namespace Yoast\YoastCom\Theme;

$term_id      = get_queried_object_id();
$cat_image_id = get_term_meta( $term_id, 'yoastcom_term_image_id', true );
$cat_icon     = get_term_meta( $term_id, 'yoastcom_term_icon', true );

$banner_text = get_term_meta( $term_id, 'yoastcom_term_banner_text', true );
$banner_url  = get_term_meta( $term_id, 'yoastcom_term_banner_url', true );
$banner_icon = get_term_meta( $term_id, 'yoastcom_term_banner_icon', true );

?>
<?php get_header(); ?>

<?php get_template_part( 'html_includes/siteheader', array( 'academy-sub' => true ) ); ?>
<div class="site">

	<div class="row">
		<?php get_template_part( 'html_includes/partials/breadcrumbs' ); ?>
	</div>

	<main role="main">
		<div class="row">

			<?php if ( ! is_paged() ) : ?>

				<h1><?php echo esc_html( get_the_archive_title() ); ?></h1>

				<?php if ( '' !== get_the_archive_description() ) : ?>
					<div class="row">
						<div class="media media--nofloat">
							<?php if ( $cat_image_id ) : ?>
								<div class="imgExt">
									<img
										src="<?php echo wp_get_attachment_image_url( $cat_image_id, 'thumbnail-recent-articles' ); ?>"
										width="250" height="131"
										class="promoblock promoblock--imageholder theme-courses--secondary">
								</div>
							<?php endif; ?>
							<div class="content promoblock theme-courses--secondary">
								<?php the_archive_description(); ?>
								<i aria-hidden="true"
								   class="blockicon color-courses--secondary fa fa-<?php echo $cat_icon; ?>"></i>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php else: ?>
				<h1><?php printf( __( '%s archives', 'yoastcom' ), esc_html( get_the_archive_title() ) ); ?></h1>
			<?php endif; ?>

		</div>

		<?php
		if ( $banner_text && $banner_url ) {
			get_template_part( 'html_includes/partials/announcement', array(
				'class' => 'announcement--pointer announcement--pointer-top',
				'text'  => $banner_text . ' &raquo;',
				'url'   => $banner_url,
				'icon'  => $banner_icon,
			) );
		} else {
			echo '<hr>';
		}
		?>

		<?php if ( ! is_paged() ) : ?>
			<?php get_template_part( 'html_includes/partials/must-read-articles', array( 'class1' => 'theme-courses--secondary', 'term_id' => $term_id ) ); ?>
		<?php endif; ?>

		<?php if ( have_posts() ): ?>
		<div class="row">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php theme_object()->excerpt->more( ' <a href="' . get_permalink() . '">&raquo;</a>' ); ?>

				<?php get_template_part( 'html_includes/partials/article-intro' ); ?>
			<hr class="hr--no-pointer">
		<?php endwhile; ?>
		<?php theme_object()->excerpt->clear(); ?>

			<?php get_template_part( 'html_includes/partials/pagination' ); ?>
		</div>
		<?php endif; ?>

		<?php if ( is_category() ) : ?>
			<hr>

			<div class="row iceberg">
				<h2 class="tight"><?php _e( 'Browse other categories', 'yoastcom' ); ?></h2>
				<?php get_template_part( 'html_includes/partials/more-categories' ); ?>

			</div>
		<?php endif; ?>

		<?php get_template_part( 'html_includes/partials/newsletter-subscribe' ); ?>

	</main>

	<div class="rowholder">
		<?php get_template_part( 'html_includes/fullfooter' ); ?>
	</div>

</div>

<?php get_footer(); ?>
