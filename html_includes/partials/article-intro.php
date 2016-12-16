<?php

namespace Yoast\YoastCom\Theme;

use Yoast\YoastCom\Settings\Hide_Comments;

$post_id   = get_the_ID();
$post_type = get_post_type_object( get_post_type() );
$icon      = 'newspaper-o';
if ( 'yoast_dev_article' === $post_type->name ) {
	$icon = 'cogs';
}
?>
<h2 class="tight"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
<div class="meta">
	<p>
		<?php if ( is_tag() ) { ?>
			<i class="fa color-courses--secondary fa-<?php echo $icon; ?>"
			   title="<?php echo $post_type->labels->singular_name; ?>" aria-hidden="true"></i>
		<?php } ?>
		<?php the_time( 'j F Y' ); ?> <?php _e( 'by', 'yoastcom' ); ?> <a
			href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'nicename' ) ) ); ?>"><?php the_author(); ?> &raquo;</a>
		<?php if ( ! Hide_Comments::hide_comments( $post_id ) && get_comments_number() > 0 ) : ?>
			- <a
				href="<?php the_permalink(); ?>#comments"><?php get_template_part( 'html_includes/partials/comments-number' ); ?></a>
		<?php endif; ?>
	</p>
</div>
<div class="media media--nofloat">
	<a href="<?php the_permalink(); ?>" class="imgExt">
		<?php the_post_thumbnail( 'thumbnail-recent-articles' ); ?>
	</a>
	<article class="bd">
		<div class="content">
			<?php
			the_excerpt();

			if ( 'yoast_dev_article' === $post_type->name ) {
				$dev_cats = get_the_term_list( $post_id, 'yoast_dev_category', '', ', ' );
				if ( $dev_cats !== false ) {
					echo _n( __( 'Category:', 'yoastcom' ), __( 'Categories:', 'yoastcom' ), substr_count( $dev_cats, ', ' ) + 1 ) . ' ';
					echo $dev_cats;
					echo '<br/>';
				}
			}
			else {
				$categories = get_the_category( $post_id );
				if ( false !== $categories ) {
					echo _n( __( 'Category:', 'yoastcom' ), __( 'Categories:', 'yoastcom' ), count( $categories ) ) . ' ';
					the_category( ', ' );
					echo '<br/>';
				}
			}

			$tags = get_the_tags( $post_id );
			if ( $tags !== false ) {
				echo _n( __( 'Tag:', 'yoastcom' ), __( 'Tags:', 'yoastcom' ), count( $tags ) ) . ' ';
				the_tags( '', ', ' );
			}
			?>
		</div>
	</article>
</div>
