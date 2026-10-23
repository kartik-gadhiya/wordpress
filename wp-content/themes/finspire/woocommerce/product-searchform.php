<?php

/**

 * The template for displaying product search form

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see     https://docs.woocommerce.com/document/template-structure/

 * @author  WooThemes

 * @package WooCommerce/Templates

 * @version 8.6.0

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit;

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
