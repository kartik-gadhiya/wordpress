<?php
/**
 * 404 page file
 *
 * @package    WordPress
 * @subpackage Finspire
 * @author     Theme Kalia <admin@themekalia.com>
 * @version    1.0
 */

?>
<?php get_header();
$data = \FINSPIRE\Includes\Classes\Common::instance()->data( '404' )->get();
$options = finspire_WSH()->option();
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

<!-- error-section -->
<section class="error-page">
    <div class="auto-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="error-content text-center">
                    <div class="big-title">
                        <h2>
                        	<?php if( $options->get( '404_page_title' ) ):?>
								<?php echo wp_kses( $options->get( '404_page_title' ), true );?>
                            <?php else:?>
                            	<?php esc_html_e( '404', 'finspire' );?>
                            <?php endif;?>
                        </h2>
                    </div>
                    <div class="title">
                        <h4>
                        	<?php if( $options->get( '404_page_heading' ) ):?>
								<?php echo wp_kses( $options->get( '404_page_heading' ), true );?>
                            <?php else:?>
                                <?php esc_html_e( 'Page not found', 'finspire' );?>
                            <?php endif;?>
                        </h4>
                    </div>
                    <div class="text">
                        <p>
                        	<?php if( $options->get( '404_page_content' ) ):?>
								<?php echo wp_kses( $options->get( '404_page_content' ), true );?>
                            <?php else:?>
                                <?php esc_html_e( 'Try refining your search or use the navigation below to return', 'finspire' );?><br>
                                <?php esc_html_e( 'to the main home page..', 'finspire' );?>
                            <?php endif;?>
                        </p>
                    </div>
                    <?php if ( $options->get( 'back_home_btn', true ) ) : ?>
                    <div class="btns-box">
                        <a class="theme-btn dark-bg" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div>    
                        <span class="text">
                            	<?php 
									if( $options->get( 'back_home_btn_label' ) ){
										echo wp_kses( $options->get( 'back_home_btn_label' ), true );
									}else{
										esc_html_e( 'Back to Home Page', 'finspire' );
									}
								?>
                            </span>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
         
<?php }
get_footer(); ?>
