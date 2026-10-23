<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header( 'shop' );
$data    = \FINSPIRE\Includes\Classes\Common::instance()->data( 'single' )->get();

$layout = $data->get( 'layout' );
$sidebar = $data->get( 'sidebar' );

$layout = ( $layout ) ? $layout : 'full';
$sidebar = ( $sidebar ) ? $sidebar : '';
if (is_active_sidebar( $sidebar )) {$layout = 'right';} else{$layout = 'full';}
$class = ( !$layout || $layout == 'full' ) ? 'col-lg-12 col-sm-12 col-sm-12 content-side' : 'col-lg-8 col-sm-12 col-sm-12 content-side';

if ( class_exists( '\Elementor\Plugin' ) && $data->get( 'tpl-type' ) == 'e') {
	
	while(have_posts()) {
	   the_post();
	   the_content();
    }

} else {
?>

<?php if ( class_exists( '\Elementor\Plugin' )):?>
	<?php do_action( 'finspire_banner', $data );?>
<?php else:?>

<section class="page-title centred">
	<?php if( $data->get( 'banner' ) ){?>
	<div class="bg-layer" style="background-image: url(<?php echo esc_url( $data->get( 'banner' ) ); ?>);"></div>
	<?php } ?>
	<div class="auto-container">
		<div class="content-box">
			<h1><?php if( $data->get( 'title' ) ) echo wp_kses( $data->get( 'title' ), true ); else( the_title( ) ); ?></h1>
			<?php if(finspire_the_breadcrumb()){ ?>
			<ul class="bread-crumb">
				<?php echo finspire_the_breadcrumb(); ?>
			</ul>
			<?php } ?>
		</div>
	</div>
</section>

<?php endif;?>

<!--Start Product Details Area-->
<section class="shop-page-section sec-pad te-shop__detail">
    <div class="auto-container">
		<div class="row clearfix">
			
				<!-- sidebar area -->
				<?php if( $data->get( 'layout' ) == 'left' ): ?>
				<div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
					<div class="blog-sidebar ltn__shop-sidebar">
						<?php 
							do_action( 'finspire_sidebar', $data );

							/**
							 * woocommerce_sidebar hook
							 *
							 * @hooked woocommerce_get_sidebar - 10
							 */
							do_action( 'woocommerce_sidebar' );
						?>
					</div>
				</div>
				<?php endif; ?>
				<!-- sidebar area -->
				
				<div class="<?php echo esc_attr($class);?>">
					<?php
						/**
						 * woocommerce_before_main_content hook
						 *
						 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
						 * @hooked woocommerce_breadcrumb - 20
						 */
						do_action( 'woocommerce_before_main_content' );
					?>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php wc_get_template_part( 'content', 'single-product' ); ?>
						<?php endwhile; // end of the loop. ?>
					<?php
						/**
						 * woocommerce_after_main_content hook
						 *
						 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
						 */
						do_action( 'woocommerce_after_main_content' );
					?>                    
				</div>   
				
				<!-- sidebar area -->
				<?php if( $data->get( 'layout' ) == 'right' ): ?>
				<div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
					<div class="blog-sidebar ltn__shop-sidebar">
						<?php 
							do_action( 'finspire_sidebar', $data );

							/**
							 * woocommerce_sidebar hook
							 *
							 * @hooked woocommerce_get_sidebar - 10
							 */
							do_action( 'woocommerce_sidebar' );
						?>
					</div>
				</div>
				<?php endif; ?>
				<!-- sidebar area -->
			 
		</div>		
	</div>
</section>

<?php
}
get_footer( 'shop' );
