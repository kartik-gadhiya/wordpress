<?php
$options = finspire_WSH()->option();
$allowed_html = wp_kses_allowed_html( 'post' );

//Sidebar Logo Settings
$sidebar_logo = $options->get( 'sidebar_logo' );
$sidebar_logo_dimension = $options->get( 'sidebar_logo_dimension' );

$logo_type = '';
$logo_text = '';
$logo_typography = '';

?>  

<div id="sidebar-popup" class="sidebar-popup">
	<div class="popup-inner">
		<div class="close-popup">X</div>
		<figure class="logo-box"><?php echo finspire_logo( $logo_type, $sidebar_logo, $sidebar_logo_dimension, $logo_text, $logo_typography ); ?></figure>
		<?php if($options->get('sidebar_form_url_v1')){ ?>
		<div class="form-inner">
			<?php echo do_shortcode($options->get('sidebar_form_url_v1')); ?>
		</div>
		<?php } ?>
		<?php if($options->get('header_sidebar_title_v1') || $options->get('header_sidebar_btn_title_v1')){ ?>
		<div class="inner-box">
			<div class="icon-box"><i class="flaticon-alarm"></i></div>
			<div class="light-icon"><i class="flaticon-alarm"></i></div>
			<?php if($options->get('header_sidebar_title_v1')){ ?><h3><?php echo wp_kses($options->get('header_sidebar_title_v1'), true); ?></h3><?php } ?>
			<?php if($options->get('header_sidebar_btn_title_v1')){ ?>
			<a href="<?php echo esc_url($options->get('header_sidebar_btn_link_v1'), true); ?>" class="theme-btn white-bg"><span><?php echo wp_kses($options->get('header_sidebar_btn_title_v1'), true); ?></span><i class="flaticon-arrow"></i></a>
			<?php } ?>
		</div>
		<?php } ?>
		<?php if($options->get('header_sidebar_copyright_v1')){ ?>
		<div class="copyright">
			<p><?php echo finspire_copyright_year(); ?> <?php echo wp_kses($options->get('header_sidebar_copyright_v1'), true); ?></p>
		</div>
		<?php } ?>
	</div>
</div>
        
    
    
