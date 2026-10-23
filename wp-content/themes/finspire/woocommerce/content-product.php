<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.8.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

global $wp_query;
global $product;
$data  = \FINSPIRE\Includes\Classes\Common::instance()->data( 'single' )->get();
$layout = $data->get( 'layout' );
$sidebar = $data->get( 'sidebar' );

$layout = ( $layout ) ? $layout : 'full';
$sidebar = ( $sidebar ) ? $sidebar : '';
if (is_active_sidebar( $sidebar )) {$layout = 'right';} else{$layout = 'full';}

if( !$layout || $layout == 'full' ) $classes[] = 'col-lg-4 col-md-6 col-sm-12 shop-block'; else $classes[] = 'col-lg-6 col-md-6 col-sm-12 shop-block';  

global $post;
$post_thumbnail_id = get_post_thumbnail_id($post->ID);
$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);

$regular_price = $product->get_regular_price();
$sale_price    = $product->get_sale_price();

?>

<div  <?php post_class( $classes ); ?>>
	<div class="shop-block-one">
		<?php
		/**
		 * Hook: woocommerce_before_shop_loop_item.
		 *
		 * @hooked woocommerce_template_loop_product_link_open - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_before_shop_loop_item_title.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		?>
		<div class="image-box">
			<figure class="image"><?php the_post_thumbnail('finspire_370x370', array('class' => 'te-img')); ?></figure>
			<?php 
			// ðŸ”¹ Sale Badge
			if ( $product->is_on_sale() ) {
				echo '<span class="product-tags sale">Sale!</span>';
			}

			// ðŸ”¹ Sold Out Badge
			if ( ! $product->is_in_stock() ) {
				echo '<span class="product-tags sale">Sold Out</span>';
			}

			// ðŸ”¹ New Badge (published within last 30 days, adjust as needed)
			$postdate      = get_the_time( 'U' ); 
			$newness_days  = 30;
			if ( ( time() - ( 60 * 60 * 24 * $newness_days ) ) < $postdate ) {
				echo '<span class="product-tags">New</span>';
			}
			?>
		</div>
		
		<?php do_action( 'woocommerce_before_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		//do_action( 'woocommerce_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_after_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
		
		<div class="lower-content">
			<h3><a href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>"><?php the_title(); ?></a></h3>
			<span class="product-price mb_10">
				<?php 
				if ( $sale_price ) {
					echo '<del>' . wc_price($regular_price) . '</del> ' . wc_price($sale_price);
				} else {
					echo wc_price($regular_price);
				}
				?>
			</span>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>?add-to-cart=<?php echo get_the_ID(); ?>" title="Add to Cart">
				<button type="button"><i class="flaticon-two-lines"></i><span class="text"><?php esc_html_e('Add to Cart', 'finspire'); ?></span></button>
			</a>
		</div>

		<?php
		/**
		 * Hook: woocommerce_after_shop_loop_item.
		 *
		 * @hooked woocommerce_template_loop_product_link_close - 5
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
		
	</div>
</div>