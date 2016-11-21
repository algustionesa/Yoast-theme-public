<?php

namespace Yoast\YoastCom\Theme;
?>
<?php get_header(); ?>

<?php get_template_part( 'html_includes/siteheader', array( 'about-sub' => true ) ); ?>
<div class="site">

	<div class="row">
		<?php get_template_part( 'html_includes/partials/breadcrumbs' ); ?>
	</div>

	<main role="main">

		<?php while ( have_posts() ) : the_post(); ?>
			<article class="row">
				<h1><?php the_title(); ?></h1>

				<div class="content">

					<?php the_content(); ?>

					<?php get_template_part( 'html_includes/partials/social-share' ); ?>
				</div>
			</article>
		<?php endwhile; ?>

		<hr />

		<section class="row iceberg">
			<h2><?php _e( 'Recent posts', 'yoastcom' ); ?></h2>
			<?php get_template_part( 'html_includes/partials/recent-articles' ); ?>
		</section>

		<?php get_template_part( 'html_includes/partials/newsletter-subscribe' ); ?>

	</main>

	<div class="rowholder">
		<?php get_template_part( 'html_includes/fullfooter' ); ?>
	</div>

</div>

<?php get_footer(); ?>
