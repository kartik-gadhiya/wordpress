<?php
/**
 * Blog Post Main File.
 *
 * @package FINSPIRE
 * @author  Theme Kalia
 * @version 1.0
 */

get_header();
$options = finspire_WSH()->option();

$data    = \FINSPIRE\Includes\Classes\Common::instance()->data( 'single' )->get();
$layout = $data->get( 'layout' );
$sidebar = $data->get( 'sidebar' );
$layout = ( $layout ) ? $layout : 'full';
$sidebar = ( $sidebar ) ? $sidebar : '';
if (is_active_sidebar( $sidebar )) {$layout = 'right';} else{$layout = 'full';}
$class = ( !$layout || $layout == 'full' ) ? 'col-lg-12 col-md-12 col-sm-12 content-side' : 'col-lg-8 col-md-12 col-sm-12 content-side';

if ( class_exists( '\Elementor\Plugin' ) && $data->get( 'tpl-type' ) == 'e') {
	
	while(have_posts()) {
	   the_post();
	   the_content();
    }

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

<!-- Start Blog Single Page -->
<section class="sidebar-page-container sec-pad">
    <?php while ( have_posts() ) : the_post(); ?>
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

				<article class="thm-unit-test">
					<div class="blog-details-content">

						<div class="sec-title mb_45 d-flex align-items-center gap-4">
							<?php if( has_category() ){ ?><span class="sub-title mb-0"><?php the_category(', '); ?></span><?php };?>
							<?php if( $options->get('single_post_author') != true || $options->get('single_post_date') != true ){ ?>
							<p class="mt-0"><?php esc_html_e('By', 'finspire'); ?> <?php the_author(); ?>&nbsp;&nbsp;<?php echo get_the_date(); ?></p>
							<?php };?>
						</div>
						<?php if( has_post_thumbnail() ){?>
						<figure class="image-box mb_45"><?php the_post_thumbnail('full'); ?></figure>
						<?php };?>
						<div class="text"><?php the_content(); ?></div>
						<div class="clearfix"></div>
						<?php wp_link_pages(array('before'=>'<div class="paginate-links mt-30">'.esc_html__('Pages: ', 'finspire'), 'after' => '</div>', 'link_before'=>'<span>', 'link_after'=>'</span>')); ?>
						<?php if(has_tag()){ ?>
						<div class="post-tags mt_40">
							<ul class="tags-list">
								<li><span><?php esc_html_e('Tags:', 'finspire'); ?></span></li>
								<?php the_tags('<li>', ', </li><li>', '</li>'); ?>
							</ul>
						</div>
						<?php };?>
						
						<?php comments_template(); ?>
						
					</div>
				</article>

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
	
	<?php endwhile; ?>
</section>
<!--End blog area--> 

<?php
}
get_footer();
