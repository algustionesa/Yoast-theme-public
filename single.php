<?php
/**
 * Template Name: Article
 */

namespace Yoast\YoastCom\Theme;
?>
<?php use Yoast\YoastCom\Settings\Hide_Comments;

get_header(); ?>

<?php get_template_part( 'html_includes/siteheader', array( 'academy-sub' => true ) ); ?>
<div class="site">

	<div class="row">
		<?php get_template_part( 'html_includes/partials/breadcrumbs' ); ?>
	</div>

	<main role="main">

		<article class="row">
			<h1><?php the_title(); ?></h1>

			<?php get_template_part( 'html_includes/partials/meta-full' ); ?>

			<div class="content">
				<?php the_content(); ?>
			</div>

			<?php get_template_part( 'html_includes/partials/social-share' ); ?>
		</article>

		<?php

		get_template_part( 'html_includes/partials/bio' );

		get_template_part( 'html_includes/partials/newsletter-subscribe', array( 'class' => 'fill--secondary announcement--pointer' ) );

		get_template_part( 'html_includes/partials/comments' );

		$primary_term_id = yoast_get_primary_term_id();
		if ( ! $primary_term_id ) {
			$cats            = get_categories( array( 'fields' => 'ids' ) );
			$primary_term_id = $cats[0];
		}
		$primary_term = get_term( $primary_term_id, 'category' );
		if ( 494 !== $primary_term_id ):
			?>
			<hr>
			<section class="row island iceberg">
				<h2 class="color-academy--secondary"><?php printf( __( 'Check out our must read articles about %s' ), $primary_term->name ); ?></h2>
				<?php
				get_template_part( 'html_includes/partials/recent-articles', array(
					'must_read' => true,
					'term_id'   => $primary_term_id
				) );
				?>
			</section>
			<?php
		endif;
		?>

		<hr class="hr--no-pointer">

	</main>

	<div class="rowholder">
		<?php get_template_part( 'html_includes/fullfooter' ); ?>
	</div>

</div>

<?php get_footer(); ?>
