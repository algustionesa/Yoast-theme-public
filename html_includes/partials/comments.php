<?php

use Yoast\YoastCom\Settings\Hide_Comments;

if ( ! Hide_Comments::hide_comments() ) :
	comment_form();

	$comments_number = get_comments_number();
	if ( $comments_number > 0 ) : ?>
		<div class="entry-comments" id="comments">
			<div class="row">
				<h3><?php printf( _n( '%d Response to %s', '%d Responses to %s', $comments_number ), $comments_number, get_the_title() ); ?></h3>
			</div>
			<?php comments_template(); ?>
		</div>
		<?php
	endif;
endif;
