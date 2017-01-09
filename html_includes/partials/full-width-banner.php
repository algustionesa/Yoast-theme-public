<?php

$class = ( ! empty( $template_args['class'] ) ? sprintf( ' class="%s"', $template_args['class'] ) : '' );

?>
<div<?php echo $class ?>>
	<div class="row">
		<?php echo $template_args['content']; ?>
	</div>
</div>
