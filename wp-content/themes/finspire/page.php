<?php
/**
 * Default Template Main File.
 *
 * @package FINSPIRE
 * @author  TonaTheme
 * @version 1.0
 */

get_header();
$data  = \FINSPIRE\Includes\Classes\Common::instance()->data( 'single' )->get();
$layout = $data->get( 'layout' );
$sidebar = $data->get( 'sidebar' );
$layout = ( $layout ) ? $layout : 'full';
$sidebar = ( $sidebar ) ? $sidebar : '';
if (is_active_sidebar( $sidebar )) {$layout = 'right';} else{$layout = 'full';}
$class = ( !$layout || $layout == 'full' ) ? 'col-lg-12 col-md-12 col-sm-12 content-side' : 'col-lg-8 col-md-12 col-sm-12 content-side';
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
				<div class="blog-details-content">
					<div class="thm-unit-test">

						<?php while ( have_posts() ): the_post(); ?>
							<div class="text"><?php the_content(); ?></div>
						<?php endwhile; ?>

						<div class="clearfix"></div>
						<?php
						$defaults = array(
							'before' => '<div class="paginate-links">' . esc_html__( 'Pages:', 'finspire' ),
							'after'  => '</div>',

						);
						wp_link_pages( $defaults );
						?>

					</div>
					
					<?php comments_template(); ?>
					
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

<?php get_footer(); ?>
