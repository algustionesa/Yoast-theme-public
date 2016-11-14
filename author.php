<?php
/**
 * Template Name: About Author
 */

namespace Yoast\YoastCom\Theme;
?>
<?php get_header(); ?>

<?php get_template_part( 'html_includes/siteheader', array( 'about-sub' => true, ) ); ?>
<div class="site">

	<div class="row">
		<?php get_template_part( 'html_includes/partials/breadcrumbs' ); ?>
	</div>

	<main role="main">
		<?php if ( ! is_paged() ) { ?>
		<section class="row">
			<h1 class="color-about--secondary">Posts by <?php the_author(); ?></h1>
		</section>

		<section class="row bio">
			<div class="media media--nofloat">
				<a href="<?php echo esc_attr( get_the_author_meta( 'yst_profile_url' ) ); ?>" class="imgExt">
					<img alt="<?php echo esc_attr( get_the_author() ); ?>" width="160" height="160" src="<?php echo esc_url( url_author_avatar() ); ?>" class="promoblock promoblock--imageholder">
				</a>
				<div class="bd color-academy--secondary">
					<p>
						<?php the_author_meta( 'description' ); ?>
					</p>
					<p>
						<?php printf( link_text_author_bio_or_find(), '<a href="'.esc_attr( get_the_author_meta( 'yst_profile_url' ) ) . '">', '</a>', get_the_author_meta( 'first_name' ) ); ?>
						<?php get_template_part( 'html_includes/partials/social-icons' ); ?>
					</p>
				</div>
			</div>
		</section>

		<?php get_template_part( 'html_includes/partials/announcement', array( 'class' => "announcement--pointer-top island fill--secondary", 'text' => "Get more visitors! Our SEO Website review will tell you what to improve. Order an SEO Website review &raquo;" ) ); ?>
		<?php } else { ?>
		<section class="row">
			<h1 class="color-about--secondary">Posts by <?php the_author(); ?> archive - page <?php echo esc_html( get_query_var( 'paged' ) ); ?></h1>
		</section>
		<hr class="row"/>
		<?php } ?>

		<?php
			$i=1;
			while ( have_posts() ) : the_post();
				if ( $i > 1 ) {
					echo '<hr class="row hr--no-pointer">';
				}
				?>
			<section class="row">
				<?php theme_object()->excerpt->more( ' <a href="' . get_permalink() . '">&raquo;</a>' ); ?>
				<?php get_template_part( 'html_includes/partials/article-intro' ); ?>
			</section>
		<?php
			$i++;
			endwhile;
		?>
		<?php theme_object()->excerpt->clear(); ?>

		<div class="row">
			<?php get_template_part( 'html_includes/partials/pagination' ); ?>
		</div>

		<?php get_template_part( 'html_includes/partials/newsletter-subscribe', array( 'class' => "announcement--pointer-top fill--tertiary", ) ); ?>

	</main>

	<div class="rowholder">
		<?php get_template_part( 'html_includes/fullfooter' ); ?>
	</div>

</div>

<?php get_footer(); ?>
