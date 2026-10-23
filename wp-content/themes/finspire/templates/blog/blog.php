<?php

/**
 * Blog Content Template
 *
 * @package    WordPress
 * @subpackage FINSPIRE
 * @author     Themekalia
 * @version    1.0
 */

if (class_exists('Finspire_Resizer')) {
    $img_obj = new Finspire_Resizer();
} else {
    $img_obj = array();
}
$options = finspire_WSH()->option();
?>


<div <?php post_class(); ?>>
	<div class="news-block-one <?php if(! has_post_thumbnail() ) echo 'alternate'; ?>">
		<div class="inner-box">
			<?php if( has_post_thumbnail() ){?>
			<figure class="image-box"><a href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>"><?php the_post_thumbnail('full'); ?></a></figure>
			<?php };?>
			<div class="lower-content">
				<?php if( has_category() ){ ?><span class="category"><?php the_category(', '); ?></span><?php };?>
				<h3><a href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>"><?php the_title();?></a></h3>
				<div class="text">
					<?php the_excerpt(); ?>
				</div>
				<?php if( $options->get('blog_post_author') != true || $options->get('blog_post_date') != true ){ ?>
				<div class="lower-box">
					<div class="link-box">
						<a href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>"><i class="flaticon-two-lines"></i></a>
					</div>
					<div class="inner">
						<?php if( $options->get( 'blog_post_author' ) != true ){ ?>
						<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta('ID') )); ?>"><?php esc_html_e('By', 'finspire'); ?> <?php the_author(); ?></a>
						<?php };?>
						<?php if( $options->get( 'blog_post_date' ) != true ){ ?>
						<span><?php echo get_the_date(); ?></span>
						<?php };?>
					</div>
				</div>
				<?php };?>
			</div>
		</div>
	</div>
</div>
