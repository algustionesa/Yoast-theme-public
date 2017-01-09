<?php
/**
 * Template Name: Software
 */

namespace Yoast\YoastCom\Theme;
?>
<?php get_header(); ?>

<?php get_template_part( 'html_includes/siteheader', array( 'software' => true ) ); ?>

<div class="site">
	<div class="row">
		<?php get_template_part( 'html_includes/partials/breadcrumbs' ); ?>
		<?php get_template_part( 'html_includes/partials/social', array( 'class' => "pull-right" ) ); ?>
	</div>

	<main role="main">

		<div class="row iceberg">
			<h1>Software by Yoast</h1>
			<?php get_template_part( 'html_includes/partials/more-software' ); ?>
		</div>

		<?php get_template_part( 'html_includes/partials/banner-announcement-software' ); ?>

		<div class="rowholder">
			<section class="row island">
				<?php get_template_part( 'html_includes/partials/more-categories', array( 'class' => "color-plugins--secondary" ) ); ?>
			</section>
		</div>

		<?php get_template_part( 'html_includes/partials/newsletter-subscribe', array( 'class' => "announcement--pointer-top" ) ); ?>

		<?php get_template_part( 'html_includes/partials/announcement', array(
			'class' => 'fill--secondary',
			'url' => url_ebooks_archive(),
			'text' => __( 'Want to know how to improve your site? Order an SEO Website Review', 'yoastcom' ) . ' &raquo;',
		) ); ?>

	</main>

	<div class="rowholder">
		<?php get_template_part( 'html_includes/fullfooter' ); ?>
	</div>

</div>

<?php get_footer(); ?>
