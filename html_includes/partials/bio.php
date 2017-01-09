<?php
namespace Yoast\YoastCom\Theme;
?>

<hr class="row hr--no-pointer">

<aside class="bio">
	<div class="row">
		<div class="media">
			<a href="#" class="img">
				<img src="<?php echo esc_url( url_author_avatar() ); ?>">
			</a>
			<div class="bd">
				<p>
					<?php the_author_meta( 'description' ); ?>
					<a href="<?php echo esc_attr( get_the_author_meta( 'yst_profile_url' ) ); ?>"><?php
						printf( __( 'Read all about %s', 'yoastcom' ), get_the_author_meta( 'first_name' ) ); ?> &raquo;</a>
					<br />
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'nicename' ) ) ); ?>"><?php
						echo esc_html( link_text_author_posts() );
					?></a>
					<?php if ( 'Female' === get_the_author_meta( 'gender' ) ) : ?>
						<?php _e( 'or find her on', 'yoastcom' ); ?>
					<?php elseif( 'Male' === get_the_author_meta( 'gender' ) ) : ?>
						<?php _e( 'or find him on', 'yoastcom' ); ?>
					<?php else: ?>
						<?php _e( 'or find them on', 'yoastcom' ); ?>
					<?php endif; ?>
					<?php if ( author_has( 'twitter' ) ) : ?>
						<a href="<?php echo esc_url( url_social_site( 'twitter' ) ); ?>" class="link--implicit">
							<span class="visuallyhidden focusable">Twitter</span>
							<span class="text-icon text-icon--twitter text-icon--social">&#xf081;</span>
						</a>
					<?php endif; ?>
					<?php if ( author_has( 'linkedin' ) ) : ?>
						<a href="<?php echo esc_url( url_social_site( 'linkedin' ) ); ?>" class="link--implicit">
							<span class="visuallyhidden focusable">Linkedin</span>
							<span class="text-icon text-icon--linkedin text-icon--social">&#xf08c;</span>
						</a>
					<?php endif; ?>
				</p>
			</div>
		</div>
	</div>
</aside>
