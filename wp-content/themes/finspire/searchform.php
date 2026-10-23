<?php
/**
 * Search Form template
 *
 * @package FINSPIRE
 * @author Theme Kalia
 * @version 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Restricted' );
}
?>
<div class="search-widget">
	<div class="search-form">
		<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
			<div class="form-group">
				<input name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php echo esc_attr__( 'Search...', 'finspire' ); ?>" type="search" required />
				<button type="submit"><i class="flaticon-search-interface-symbol"></i></button>
			</div>
		</form>
	</div>
</div>
