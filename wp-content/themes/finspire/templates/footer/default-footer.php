<?php
/**
 * Footer Template  File
 *
 * @package FINSPIRE
 * @author  Theme Kalia
 * @version 1.0
 */

$options = finspire_WSH()->option();
$allowed_html = wp_kses_allowed_html( 'post' );

$logo_image = $options->get( 'logo_image' );
$logo_image = finspire_set( $logo_image, 'url', FINSPIRE_URI . '' );
?>

<footer class="footer-style-four bg-color-2">
	<?php if( $options->get('show_footer_top') == true ){ ?>
	<div class="footer-top">
		<div class="auto-container">
			<div class="top-inner">
				<?php if($logo_image) {?>
				<figure class="footer-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($logo_image); ?>" alt="<?php bloginfo( 'name' ); ?>"></a></figure>
				<?php };?>
				<?php if($options->get( 'footer_text_v1' )){?>
				<h3><?php echo wp_kses( $options->get( 'footer_text_v1'), true ); ?> <a href="<?php echo esc_url( $options->get( 'footer_link_v1'), true ); ?>"><i class="flaticon-two-lines"></i></a></h3>
				<?php };?>
			</div>
		</div>
	</div>
	<?php };?>
	<?php if ( is_active_sidebar( 'footer-sidebar' ) ) { ?>
	<div class="widget-section">
		<div class="auto-container">
			<div class="row clear">
				<?php dynamic_sidebar( 'footer-sidebar' ); ?>
			</div>
		</div>
	</div>
	<?php };?>
	<?php if( $options->get('show_bottom_footer_v1') == true ){ ?>
	<div class="footer-bottom">
		<div class="auto-container">
			<div class="bottom-inner">
				<?php if( $options->get('show_footer_social_v1') == true ){ ?>
				<ul class="social-links">
					<?php if($options->get( 'footer_social_title_v1' )){?><li><h6><?php echo wp_kses( $options->get( 'footer_social_title_v1'), true ); ?></h6></li><?php };?>
					<?php echo finspire_get_social_icon(); ?>
				</ul>
				<?php };?>
				<div class="right-column">
					<?php if($options->get( 'footer_copyright_text_v1' )){?>
					<p><?php echo finspire_copyright_year(); ?> <?php echo wp_kses( $options->get( 'footer_copyright_text_v1'), true ); ?></p>
					<?php };?>
					<ul class="footer-nav">
						<?php if( has_nav_menu( 'footer_menu' ) ):?>
							<?php wp_nav_menu( array( 'theme_location' => 'footer_menu', 'container_id' => 'navbar-collapse-1',
								'container_class'=>'navbar-collapse collapse navbar-right',
								'menu_class'=>'nav navbar-nav',
								'fallback_cb'=>false, 
								'items_wrap' => '%3$s', 
								'container'=>false,
								'depth'=>'1',
								'walker'=> new \FINSPIREPLUGIN\Element\Mega_Menu_Walkers()  
							)); ?>
						<?php else:?>
							<li><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) );?>"><?php esc_html_e( 'Add Menu', 'finspire' );?></a></li>
						<?php endif;?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<?php };?>
</footer>
