<?php
$options = finspire_WSH()->option();
$allowed_html = wp_kses_allowed_html( 'post' );

//Home One Logo Settings
$dark_logo = $options->get( 'dark_logo' );
$dark_logo_dimension = $options->get( 'dark_logo_dimension' );

$logo_type = '';
$logo_text = '';
$logo_typography = ''; ?>

<?php if( $options->get('show_header_sidebar_v1') == true ){ ?>
<?php get_template_part('templates/header/sidebar_settings'); ?>
<?php };?>

<header class="main-header">
	<div class="large-container">
		<!-- header-lower -->
		<div class="header-lower">
			<div class="outer-box">
				<div class="left-column">
					<figure class="logo"><?php echo finspire_logo( $logo_type, $dark_logo, $dark_logo_dimension, $logo_text, $logo_typography ); ?></figure>
					<div class="menu-area clearfix">
						<!--Mobile Navigation Toggler-->
						<div class="mobile-nav-toggler">
							<i class="icon-bar"></i>
							<i class="icon-bar"></i>
							<i class="icon-bar"></i>
						</div>
						<nav class="main-menu navbar-expand-md navbar-light">
							<div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
								<ul class="navigation clearfix">
									<?php if( has_nav_menu( 'main_menu' ) ):?>
										<?php wp_nav_menu( array( 'theme_location' => 'main_menu', 'container_id' => 'navbar-collapse-1',
											'container_class'=>'navbar-collapse collapse navbar-right',
											'menu_class'=>'nav navbar-nav',
											'fallback_cb'=>false, 
											'items_wrap' => '%3$s', 
											'container'=>false,
											'depth'=>'3',
											'walker'=> new Bootstrap_walker(),  
										)); ?>
									<?php else:?>
										<li><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) );?>"><?php esc_html_e( 'Add Menu', 'finspire' );?></a></li>
									<?php endif;?>
								</ul>
							</div>
						</nav>
					</div>
				</div>
				<div class="menu-right-content">
					<?php 
						if( $options->get('show_btn') == true ){ 
						$mount_links = !empty( $options->get('page_selects') ) ? $options->get('page_selects') : '#';
						$mount_btn_title = $options->get('btn_title') ? $options->get('btn_title') : esc_html__( 'Get In Touch', 'finspire' );
					?>
					<div class="btn-box"><a href="<?php echo esc_url( get_page_link( $mount_links ) ); ?>" class="theme-btn dark-bg"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses( $mount_btn_title, true ); ?></span></a></div>
					<?php };?>
					<?php if( $options->get('show_header_sidebar_v1') == true ){ ?>
					<div class="sidebar-toggler"><i class="flaticon-mozy"></i></div>
					<?php };?>
				</div>
			</div>
		</div>
	</div>

	<!--sticky Header-->
	<div class="sticky-header">
		<div class="large-container">
			<div class="outer-box pl_30 pr_30">
				<figure class="logo"><?php echo finspire_logo( $logo_type, $dark_logo, $dark_logo_dimension, $logo_text, $logo_typography ); ?></figure>
				<div class="menu-area clearfix">
					<nav class="main-menu clearfix">
						<!--Keep This Empty / Menu will come through Javascript-->
					</nav>
				</div>
				<div class="menu-right-content">
					<?php 
						if( $options->get('show_btn') == true ){ 
						$mount_links = !empty( $options->get('page_selects') ) ? $options->get('page_selects') : '#';
						$mount_btn_title = $options->get('btn_title') ? $options->get('btn_title') : esc_html__( 'Get In Touch', 'finspire' );
					?>
					<div class="btn-box"><a href="<?php echo esc_url( get_page_link( $mount_links ) ); ?>" class="theme-btn dark-bg"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses( $mount_btn_title, true ); ?></span></a></div>
					<?php };?>
					<?php if( $options->get('show_header_sidebar_v1') == true ){ ?>
					<div class="sidebar-toggler"><i class="flaticon-mozy"></i></div>
					<?php };?>
				</div>
			</div>
		</div>
	</div>
</header>

<?php get_template_part('templates/header/mobile_settings'); ?>