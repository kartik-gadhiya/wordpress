<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     4.7.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();
global $wp_query;
$data  = \FINSPIRE\Includes\Classes\Common::instance()->data( 'single' )->get();
$layout = $data->get( 'layout' );
$sidebar = $data->get( 'sidebar' );
if (is_active_sidebar( $sidebar )) {$layout = 'right';} else{$layout = 'full';}
$class = ( !$layout || $layout == 'full' ) ? 'col-lg-12 col-sm-12 col-sm-12 content-side' : 'col-lg-8 col-sm-12 col-sm-12 content-side';

if ( class_exists( '\Elementor\Plugin' ) AND $data->get( 'tpl-type' ) == 'e' AND $data->get( 'tpl-elementor' ) ) {
	echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $data->get( 'tpl-elementor' ) );
} else {
?>

<?php if ( class_exists( '\Elementor\Plugin' )): ?>
	<?php do_action( 'finspire_banner', $data ); ?>
<?php else: ?>

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

<?php endif; ?>

<!-- shop-page-section --> 
<section class="shop-page-section sec-pad te-shop-archive__custom te-shop-cat">
	<div class="auto-container">
		<div class="row clearfix">			
			
			<!-- sidebar area -->
			<?php if( $data->get( 'layout' ) == 'left' ): ?>
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
				<div class="blog-sidebar ltn__shop-sidebar">
                    <?php dynamic_sidebar( $sidebar ); ?>
                </div>
            </div>
			<?php endif; ?>
			<!-- sidebar area -->
			
			<div class="content-side <?php echo esc_attr($class); ?> ">
				<div class="our-shop">
					<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                        
                        <!--Sort By-->
                        <div class="items-sorting">
                            <div class="text">
                                <?php woocommerce_result_count(); ?>
                            </div>
                            <div class="woocommerce-form">
								<?php
                                    /**
                                     * woocommerce_before_shop_loop hook
                                     *
                                     * @hooked woocommerce_result_count - 20
                                     * @hooked woocommerce_catalog_ordering - 30
                                     */
                                    do_action( 'woocommerce_before_shop_loop' );
                                ?>
                            </div>
                        </div>
                        
                    <?php endif; ?>
                    <?php
                        /**
                         * woocommerce_before_main_content hook
                         *
                         * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                         * @hooked woocommerce_breadcrumb - 20
                         */
                        do_action( 'woocommerce_before_main_content' );
                    ?>                
                    <?php
                        /**
                         * woocommerce_archive_description hook
                         *
                         * @hooked woocommerce_taxonomy_archive_description - 10
                         * @hooked woocommerce_product_archive_description - 10
                         */
                        do_action( 'woocommerce_archive_description' );
                    ?>
                    
                    <?php if ( have_posts() ) : ?>
                
                    <?php woocommerce_product_loop_start(); ?>
        
                        <?php woocommerce_product_subcategories(); ?>
        
                        <?php while ( have_posts() ) : the_post(); ?>
        
                            <?php wc_get_template_part( 'content', 'product' ); ?>
        
                        <?php endwhile; // end of the loop. ?>
        
                    <?php woocommerce_product_loop_end(); ?>
        
                    <?php
                        /**
                         * woocommerce_after_shop_loop hook
                         *
                         * @hooked woocommerce_pagination - 10
                         */
                        do_action( 'woocommerce_after_shop_loop' );
                    ?>
        
                    <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
            
                        <?php wc_get_template( 'loop/no-products-found.php' ); ?>
            
                    <?php endif; ?>
                    
                    <?php
                        /**
                         * woocommerce_after_main_content hook
                         *
                         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                         */
                        do_action( 'woocommerce_after_main_content' );
                    ?>	
            	</div>
            </div>
			
			<!-- sidebar area -->
			<?php if( $data->get( 'layout' ) == 'right' ): ?>
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
				<div class="blog-sidebar ltn__shop-sidebar">
                    <?php dynamic_sidebar( $sidebar ); ?>
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
