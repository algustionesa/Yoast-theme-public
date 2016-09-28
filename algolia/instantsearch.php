<?php
/**
 * Template Name: Algolia instantsearch
 *
 * The name and location of this file is fixed. the Algoliasearch plugin looks for this file while loading the instantsearch template.
 */

namespace Yoast\YoastCom\Theme;
?>
<?php get_header(); ?>

<?php get_template_part( 'html_includes/siteheader', array( 'academy-sub' => true ) ); ?>
<div class="site">

	<div class="row">
		<?php get_template_part( 'html_includes/partials/breadcrumbs' ); ?>
	</div>

	<main role="main">
		<div class="row">
			<div class="search-header">
				<h1><?php echo esc_html( get_the_archive_title() ); ?></h1>

				<div id="algolia-search-box">
					<div id="algolia-stats"></div>
					<svg class="search-icon" width="25" height="25" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
						<path d="M24.828 31.657a16.76 16.76 0 0 1-7.992 2.015C7.538 33.672 0 26.134 0 16.836 0 7.538 7.538 0 16.836 0c9.298 0 16.836 7.538 16.836 16.836 0 3.22-.905 6.23-2.475 8.79.288.18.56.395.81.645l5.985 5.986A4.54 4.54 0 0 1 38 38.673a4.535 4.535 0 0 1-6.417-.007l-5.986-5.986a4.545 4.545 0 0 1-.77-1.023zm-7.992-4.046c5.95 0 10.775-4.823 10.775-10.774 0-5.95-4.823-10.775-10.774-10.775-5.95 0-10.775 4.825-10.775 10.776 0 5.95 4.825 10.775 10.776 10.775z" fill-rule="evenodd"></path>
					</svg>
				</div>

			</div>
			<?php get_template_part( 'html_includes/partials/algolia-instantsearch') ?>
		</div>

		<?php get_template_part( 'html_includes/partials/newsletter-subscribe' ); ?>

	</main>

	<div class="rowholder">
		<?php get_template_part( 'html_includes/fullfooter' ); ?>
	</div>
</div>

<?php get_footer(); ?>


