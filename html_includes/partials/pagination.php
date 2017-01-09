<?php
namespace Yoast\YoastCom\Theme;

/** @var \WP_Query $wp_query */
global $wp_query;

if ( $wp_query->max_num_pages > 1 ) :

	$big = 999999999; // need an unlikely integer
	$links = str_replace( '/page/1/', '/', paginate_links( array(
		'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format'  => '?paged=%#%',
		'current' => max( 1, get_query_var( 'paged' ) ),
		'total'   => $wp_query->max_num_pages,
		'type'    => 'list',
		'end_size' => 4
	) ) );

	?>
	<div class="pagination">
		<?php echo $links ?>
	</div>
<?php

endif;
