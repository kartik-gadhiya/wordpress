<?php
$options = finspire_WSH()->option();
$allowed_html = wp_kses_allowed_html( 'post' );

//Main Logo Settings
$mobile_logo = $options->get( 'mobile_logo' );
$mobile_logo_dimension = $options->get( 'mobile_logo_dimension' );

$logo_type = '';
$logo_text = '';
$logo_typography = '';
?>   

<div class="mobile-menu">
	<div class="menu-backdrop"></div>
	<div class="close-btn">X</div>

	<nav class="menu-box">
		<div class="nav-logo">
			<?php if( $options->get( 'mobile_logo_show' ) == true ){?>
                <?php echo finspire_logo( $logo_type, $mobile_logo, $mobile_logo_dimension, $logo_text, $logo_typography ); ?>
            <?php } else { ?>
                <a href="<?php echo esc_url( home_url( '/' ) );?>"><img src="<?php echo esc_url( get_template_directory_uri() );?>/assets/images/logo-2.png" alt="<?php bloginfo( 'name' );?>"></a>
            <?php };?>
		</div>
		<div class="menu-outer">
		
			<ul class="navigation clearfix">
				<?php if( has_nav_menu( 'main_menu' ) ):?>
					<?php wp_nav_menu( array( 'theme_location' => 'main_menu', 'container_id' => 'navbar-collapse-1',
						'container_class'=>'navbar-collapse collapse navbar-right',
						'menu_class'=>'nav navbar-nav',
						'fallback_cb'=>false, 
						'items_wrap' => '%3$s', 
						'container'=>false,
						'depth'=>'3',
						'walker'=> new Bootstrap_walker()
					)); ?>
				<?php else:?>
					<li><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) );?>"><?php esc_html_e( 'Add Menu', 'finspire' );?></a></li>
				<?php endif;?>
			</ul>

		</div>
		<div class="contact-info">
			<?php if($options->get('mobile_info_title')){ ?><h4><?php echo wp_kses($options->get('mobile_info_title'), true); ?></h4><?php };?>
			<ul>
				<?php if($options->get('mobile_address')){ ?>
				<li><?php echo wp_kses($options->get('mobile_address'), true); ?></li>
				<?php };?>
				<?php if($options->get('mobile_phone')){ ?>
				<li><a href="tel:<?php echo esc_attr($options->get('mobile_phone'), true); ?>"><?php echo wp_kses($options->get('mobile_phone'), true); ?></a></li>
				<?php };?>
				<?php if($options->get('mobile_email')){ ?>
				<li><a href="mailto:<?php echo esc_attr($options->get('mobile_email'), true); ?>"><?php echo wp_kses($options->get('mobile_email'), true); ?></a></li>
				<?php };?>
			</ul>
		</div>
		<?php if( $options->get('show_mobile_social') == true ){ ?>
		<div class="social-links">
			<ul class="clearfix">
				<?php echo finspire_get_social_icon(); ?>
			</ul>
		</div>
		<?php };?>
	</nav>
</div>
