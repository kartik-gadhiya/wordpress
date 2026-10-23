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

<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
	<div class="form-group">
		<input name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php echo esc_attr__( 'Search Here', 'finspire' ); ?>" type="search" required />
		<button type="submit"><i class="flaticon-search"></i></button>
	</div>
</form>
