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

		<article class="row">
			<h1><?php _e( 'Sorry, this page could not be found.', 'yoastcom' ); ?></h1>

			<div class="content">
				<p><?php _e( 'Sorry! The page you are looking for doesn\'t exist or no longer exists. Some options for how to find it:', 'yoastcom' ); ?></p>
				<ol>
					<li><?php _e( 'If you typed in a URL... make sure the spelling, cApitALiZaTiOn, and punctuation are correct. Then try reloading the page.', 'yoastcom' ); ?></li>
					<li><?php printf( __( 'Try and find it in the %1$ssitemap%2$s.', 'yoastcom' ), '<a href="' . home_url( 'sitemap/' ) . '">', '</a>' ); ?></li>
					<li><?php printf( __( 'Start over again at the %1$shomepage%2$s.', 'yoastcom' ), '<a href="' . home_url( '/' ) . '">', '</a>' ); ?></li>
					<li>
						<?php _e( 'Search for it: ', 'yoastcom' ); ?>
						<?php add_theme_support( 'html5', array( 'search-form' ) ); ?>
						<?php echo get_search_form(); ?>
					</li>
				</ol>
			</div>
		</article>

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
