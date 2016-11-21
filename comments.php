<?php
/**
 * @package Yoast\YoastCom
 */

namespace Yoast\YoastCom\Theme;

use Yoast\YoastCom\Settings\Hide_Comments;

if ( post_password_required() ) {
	return;
}

if ( Hide_Comments::hide_comments() ) {
	return;
}
?>
<div class="row">
<ol class="comment-list">
	<?php
	wp_list_comments( array(
		'style'  => 'ul',
		'walker' => new Comment_Walker(),
		'type'   => 'comment',
	) );
	?>
</ol>
</div>
