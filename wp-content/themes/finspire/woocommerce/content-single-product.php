<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
	 $allowed_tags = wp_kses_allowed_html('post');

	global $post;
	global $product;
	$post_thumbnail_id = get_post_thumbnail_id($post->ID);
	$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);

	$regular_price = $product->get_regular_price();
	$sale_price    = $product->get_sale_price();

?>
<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row align-items-center">
		
		<div class="col-lg-6">
			<div class="ltn__shop-details-img-gallery">
				<?php the_post_thumbnail('full'); ?>
			</div>
		</div>
        
        <div class="col-lg-6">
    
            <?php
                /**
                 * woocommerce_single_product_summary hook.
                 *
                 * @hooked woocommerce_template_single_title - 5
                 * @hooked woocommerce_template_single_rating - 10
                 * @hooked woocommerce_template_single_price - 10
                 * @hooked woocommerce_template_single_excerpt - 20
                 * @hooked woocommerce_template_single_add_to_cart - 30
                 * @hooked woocommerce_template_single_meta - 40
                 * @hooked woocommerce_template_single_sharing - 50
                 * @hooked WC_Structured_Data::generate_product_data() - 60
                 */
                do_action( 'woocommerce_single_product_summary' );
            ?>
			
			<div class="product-details__content">
				<div class="product-details__value">
					<h3><?php woocommerce_template_single_price();?></h3>
				</div>	 
				<div class="product-details__text">
					<p><?php woocommerce_template_single_excerpt();?></p>
				</div> 
				<div class="cart-box">
					<?php woocommerce_template_single_add_to_cart();?>
				</div>
				<div class="product-description-box">
					<?php woocommerce_template_single_meta();?>
				</div>
			</div>			
			
		</div>	
		</div>
		<?php
			/**
			 * woocommerce_after_single_product_summary hook.
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
		?>
	
</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
