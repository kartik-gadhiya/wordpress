<?php
/**
 * Tag Main File.
 *
 * @package FINSPIRE
 * @author  Theme Kalia
 * @version 1.0
 */

get_header();
global $wp_query;
$data  = \FINSPIRE\Includes\Classes\Common::instance()->data( 'tag' )->get();
$layout = $data->get( 'layout' );
$sidebar = $data->get( 'sidebar' );
$layout = ( $layout ) ? $layout : 'right';
$sidebar = ( $sidebar ) ? $sidebar : 'default-sidebar';
if (is_active_sidebar( $sidebar )) {$layout = 'right';} else{$layout = 'full';}
$class = ( !$layout || $layout == 'full' ) ? 'col-lg-12 col-md-12 col-sm-12 content-side' : 'col-lg-8 col-md-12 col-sm-12 content-side';
if ( class_exists( '\Elementor\Plugin' ) AND $data->get( 'tpl-type' ) == 'e' AND $data->get( 'tpl-elementor' ) ) {
	echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $data->get( 'tpl-elementor' ) );
} else {
?>

<?php if ( $data->get( 'enable_banner' ) ) : ?>
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

<!-- sidebar-page-container -->
<section class="sidebar-page-container sec-pad">
    <div class="auto-container">
        <div class="row clearfix">
			<?php if( $data->get( 'layout' ) == 'left' ): ?>
			<div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
				<div class="blog-sidebar">
                    <?php dynamic_sidebar( $sidebar ); ?>
                </div>
            </div>
			<?php endif; ?>
			<div class="content-side <?php echo esc_attr( $class ); ?>">
				<div class="blog-list-content">
					<div class="thm-unit-test">
						
						<?php
							while ( have_posts() ) :
								the_post();
								finspire_template_load( 'templates/blog/blog.php', compact( 'data' ) );
							endwhile;
							wp_reset_postdata();
						?>
							
					</div>
					
					<!--Pagination-->
					<div class="pagination-two">
						<?php finspire_the_pagination( $wp_query->max_num_pages );?>
					</div>
				</div>
			</div>
			<?php if( $data->get( 'layout' ) == 'right' ): ?>
			<div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
				<div class="blog-sidebar">
                    <?php dynamic_sidebar( $sidebar ); ?>
                </div>
            </div>
			<?php endif; ?>
		</div>
	</div>
</section> 
<!--End blog area--> 
<?php
}
get_footer();
