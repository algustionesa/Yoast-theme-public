<?php

namespace Yoast\YoastCom\Theme;

use Yoast\YoastCom\Academy\Manual_Approval;

/** @var \LLMS_Course $course */
$course = $template_args['course'];

$raw_percentage = (int) $course->get_percent_complete();
$percentage = apply_filters( 'yoast_llms_certificate_percentage_complete', $raw_percentage, $course );
$completed = ( 100 === (int) $percentage );

$pending_approval = Manual_Approval::has_pending_approval( get_current_user_id(), $course );

if ( $completed ) {
	$url_certificate = \Yoast\YoastCom\Academy\get_certificate_url( $course );
}

?>

<li <?php post_class( array( 'my-courses-course' ), $course->id ); ?>>
	<div class="img">
		<?php echo lifterlms_get_featured_image( $course->id ); ?>
	</div>

	<div class="title">
	<h3>
		<a href="<?php echo esc_url( get_permalink( $course->id ) ); ?>">
			<?php echo esc_html( get_the_title( $course->id ) ); ?>
		</a>
	</h3>
	</div>
	<?php if ( $completed ) : ?>
		<?php if ( $url_certificate ) : ?>
			<div class="certificate">
				<a class="button default" href="<?php echo esc_url( $url_certificate ); ?>">
					<i class="fa fa-graduation-cap" aria-hidden="true"></i><?php _e( 'Show certificate', 'yoastcom' ); ?>
				</a>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( ! $completed ) : ?>
	<div class="my-courses-progress">
		<?php printf( __( 'Finished %d%%', 'yoastcom' ), $percentage ); ?>
	</div>
	<?php endif; ?>

	<?php if ( $pending_approval && 100 === $raw_percentage ) : ?>
		<div class="link">
			<div class="rectangle"><i class="fa fa-clock-o" aria-hidden="true"></i>Waiting for approval from the Yoast team.</div>
		</div>
	<?php endif; ?>

	<?php if ( 100 !== $raw_percentage ) : ?>
		<div class="link">
			<?php $next_lesson = $course->get_next_uncompleted_lesson(); ?>
			<a class="button default" href="<?php echo esc_url( get_permalink( $next_lesson ) ); ?>">
				<i class="fa fa-arrow-circle-right" aria-hidden="true"></i><?php _e( 'Continue', 'yoastcom' ); ?>
			</a>
		</div>
	<?php endif; ?>
</li>
