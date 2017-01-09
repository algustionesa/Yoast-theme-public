<?php
namespace Yoast\YoastCom\Theme;

$search_url = apply_filters( 'yoastcom_search_url', home_url() );
?>
<div class="searchbar">
	<form action="<?php echo esc_attr( $search_url ); ?>">
		<input type="search" name="s"
		       placeholder="<?php _e( apply_filters( 'yoast_theme-search_placeholder', 'Search&hellip;' ), 'yoastcom' ); ?>">
		
		<button class="button--naked search-button hide-on-desktop"><span class="visuallyhidden focusable"><?php _e( 'Search', 'yoastcom' ); ?></span><span class="text-icon">&#xf002;</span></button>
	</form>
</div>
