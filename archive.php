<?php
/**
 * Template Name: Single category
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

			<h1><?php echo esc_html( get_the_archive_title() ); ?></h1>
			<?php if ( is_search() ) { ?>
				<div id="content">
					<form action="<?php echo home_url(); ?>">
						<input type="search" name="s" value="<?php echo get_search_query(); ?>"/>

						<p>
							You can filter your search by post type:
							<select name="post_type">
								<?php
								$post_types = get_post_types( array( 'public' => true ), 'objects' );
								unset( $post_types['attachment'], $post_types['plugin_review'] );

								$post_types = array_merge(
									array(
										'any' => (object) array(
											'labels' => (object) array(
												'name' => 'Any',
											)
										)
									),
									$post_types
								);

								$req_post_type = filter_input( INPUT_GET, 'post_type' );
								if ( ! $req_post_type ) {
									$req_post_type = 'any';
								}

								foreach ( $post_types as $post_type => $obj ) {
									$sel = '';
									if ( $req_post_type === $post_type ) {
										$sel = 'selected ';
									}
									echo '<option ' . $sel . 'value="' . $post_type . '">' . str_replace( 'Yoast ', '', $obj->labels->name ) . '</option>';
								}
								?>
							</select>
						</p>
						<input type="submit" class="button default" value="Search"/>
					</form>
				</div>
			<?php } ?>
		</div>

		<?php if ( is_home() && ! is_front_page() ) :
			$posts_page_id = get_option( 'page_for_posts' );
			?>
			<div class="row">
				<div class="media media--nofloat">
					<?php if ( has_post_thumbnail( $posts_page_id ) ) : ?>
						<div class="imgExt">
							<img
								src="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $posts_page_id ), 'thumbnail-recent-articles' ); ?>"
								width="250" height="131"
								class="promoblock promoblock--imageholder theme-courses--secondary">
						</div>
					<?php endif; ?>
					<div class="bd content color-courses--secondary">
						<div class="content promoblock theme-courses--secondary">
							<?php
							$home_post = get_post( $posts_page_id );
							if ( $home_post->post_content !== '' ) {
								$content = $home_post->post_content;
							} else {
								$content = $home_post->post_excerpt;
							}

							echo wpautop( do_shortcode( $content ) );
							?>
							<i aria-hidden="true"
							   class="blockicon color-courses--secondary fa fa-newspaper-o"></i>
						</div>
					</div>
				</div>
			</div>

			<?php
			$banner_content = get_post_meta( $home_post->ID, 'banner-content', true );
			$banner_url     = get_post_meta( $home_post->ID, 'banner-url', true );
			if ( $banner_content !== '' ) {
				$args = array(
					'text'  => $banner_content,
					'url'   => $banner_url,
					'class' => 'announcement-pointer announcement--pointer-top',
					'icon'  => 'gears',
				);
				get_template_part( 'html_includes/partials/announcement', $args );
			} else {
				echo '<hr class="row hr--no-pointer">';
			}
			?>
		<?php elseif ( '' !== term_description() ) : ?>
			<div class="row">
				<div class="media media--nofloat">
					<div class="bd content color-courses--secondary">
						<?php the_archive_description(); ?>
					</div>
				</div>
			</div>

			<hr class="row hr--no-pointer">
		<?php else : ?>
			<hr class="row hr--no-pointer">
		<?php endif; ?>

		<?php if ( have_posts() ): ?>
			<div class="row">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php theme_object()->excerpt->more( ' <a href="' . get_permalink() . '">&raquo;</a>' ); ?>
					<?php get_template_part( 'html_includes/partials/article-intro' ); ?>
					<hr class="hr--no-pointer">
				<?php endwhile; ?>

				<?php get_template_part( 'html_includes/partials/pagination' ); ?>
			</div>
			<?php theme_object()->excerpt->clear(); ?>
		<?php endif; ?>

		<?php if ( is_category() ) : ?>
			<hr>

			<div class="row iceberg">
				<h2 class="tight"><?php _e( 'Browse other Yoast Categories', 'yoastcom' ); ?></h2>
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
