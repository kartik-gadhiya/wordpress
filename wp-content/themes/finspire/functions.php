<?php

require_once get_template_directory() . '/includes/loader.php';

add_action( 'after_setup_theme', 'finspire_setup_theme' );
add_action( 'after_setup_theme', 'finspire_load_default_hooks' );


function finspire_setup_theme() {

	load_theme_textdomain( 'finspire', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'custom-background' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	
    
	// Set the default content width.
	$GLOBALS['content_width'] = 525;
	
	/*---------- Register image sizes ----------*/
	
	//Register image sizes
	add_image_size( 'finspire_100x100', 100, 100, true ); //finspire_100x100 Widget
	add_image_size( 'finspire_370x370', 370, 370, true ); //finspire_370x370 Shop Image
	add_image_size( 'finspire_550x224', 550, 224, true ); //finspire_550x224 Blog Grid
	add_image_size( 'finspire_530x274', 530, 274, true ); //finspire_530x274 Blog Grid
	
	
	/*---------- Register image sizes ends ----------*/
	
	
	
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'main_menu' => esc_html__( 'Main Menu', 'finspire' ),
		'footer_menu' => esc_html__( 'Footer Menu', 'finspire' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'      => 250,
		'height'     => 250,
		'flex-width' => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style();
	add_action( 'admin_init', 'finspire_admin_init', 2000000 );
}

/**
 * [finspire_admin_init]
 *
 * @param  array $data [description]
 *
 * @return [type]       [description]
 */


function finspire_admin_init() {
	remove_action( 'admin_notices', array( 'ReduxFramework', '_admin_notices' ), 99 );
}

/*---------- Sidebar settings ----------*/

/**
 * [finspire_widgets_init]
 *
 * @param  array $data [description]
 *
 * @return [type]       [description]
 */
function finspire_widgets_init() {

	global $wp_registered_sidebars;
	$theme_options = get_theme_mod( 'finspire' . '_options-mods' );
	register_sidebar( array(
		'name'          => esc_html__( 'Default Sidebar', 'finspire' ),
		'id'            => 'default-sidebar',
		'description'   => esc_html__( 'Widgets in this area will be shown on the right-hand side.', 'finspire' ),
		'before_widget'=>'<div id="%1$s" class="widget sidebar-widget">',
		'after_widget'=>'</div>',
		'before_title' => '<div class="widget-title"><h3>',
		'after_title' => '</h3></div>'
	) );
	register_sidebar(array(
		'name' => esc_html__('Footer Widget', 'finspire'),
		'id' => 'footer-sidebar',
		'description' => esc_html__('Widgets in this area will be shown in Footer Area.', 'finspire'),
		'before_widget'=>'<div class="col-lg-4 col-md-6 col-sm-12 footer-column footer-widget">',
		'after_widget'=>'</div>',
		'before_title' => '<div class="widget-title mb_25"><h3>',
		'after_title' => '</h3></div>'
	));
	if ( class_exists( '\Elementor\Plugin' )){
	register_sidebar(array(
	  'name' => esc_html__( 'Blog Listing', 'finspire' ),
	  'id' => 'blog-sidebar',
	  'description' => esc_html__( 'Widgets in this area will be shown on the right-hand side.', 'finspire' ),
	  'before_widget'=>'<div id="%1$s" class="widget sidebar-widget">',
	  'after_widget'=>'</div>',
	  'before_title' => '<div class="widget-title"><h3>',
	  'after_title' => '</h3></div>'
	));
    register_sidebar(array(
	  'name' => esc_html__( 'Portfolio Sidebar', 'finspire' ),
	  'id' => 'portfolio-sidebar',
	  'description' => esc_html__( 'Widgets in this area will be shown on the right-hand side.', 'finspire' ),
	  'before_widget'=>'<div id="%1$s" class="widget sidebar-widget">',
	  'after_widget'=>'</div>',
	  'before_title' => '<div class="widget-title"><h3>',
	  'after_title' => '</h3></div>'
	));
	register_sidebar(array(
	  'name' => esc_html__( 'Shop Sidebar', 'finspire' ),
	  'id' => 'shop-sidebar',
	  'description' => esc_html__( 'Widgets in this area will be shown on the right-hand side.', 'finspire' ),
	  'before_widget'=>'<div id="%1$s" class="widget sidebar-widget">',
	  'after_widget'=>'</div>',
	  'before_title' => '<div class="widget-title"><h3>',
	  'after_title' => '</h3></div>'
	));
	}
	if ( ! is_object( finspire_WSH() ) ) {
		return;
	}

	$sidebars = finspire_set( $theme_options, 'custom_sidebar_name' );

	foreach ( array_filter( (array) $sidebars ) as $sidebar ) {

		if ( finspire_set( $sidebar, 'topcopy' ) ) {
			continue;
		}

		$name = $sidebar;
		if ( ! $name ) {
			continue;
		}
		$slug = str_replace( ' ', '_', $name );

		register_sidebar( array(
			'name'          => $name,
			'id'            => sanitize_title( $slug ),
			'before_widget' => '<div id="%1$s" class="%2$s widget single-sidebar-box">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="sidebar-title"><h3> ',
			'after_title'   => '</h3></div>',
		) );
	}

	update_option( 'wp_registered_sidebars', $wp_registered_sidebars );
}

add_action( 'widgets_init', 'finspire_widgets_init' );

/*---------- Sidebar settings ends ----------*/

/*---------- Gutenberg settings ----------*/

function finspire_gutenberg_editor_palette_styles() {
    add_theme_support( 'editor-color-palette', array(
        array(
            'name' => esc_html__( 'strong yellow', 'finspire' ),
            'slug' => 'strong-yellow',
            'color' => '#f7bd00',
        ),
        array(
            'name' => esc_html__( 'strong white', 'finspire' ),
            'slug' => 'strong-white',
            'color' => '#fff',
        ),
		array(
            'name' => esc_html__( 'light black', 'finspire' ),
            'slug' => 'light-black',
            'color' => '#242424',
        ),
        array(
            'name' => esc_html__( 'very light gray', 'finspire' ),
            'slug' => 'very-light-gray',
            'color' => '#797979',
        ),
        array(
            'name' => esc_html__( 'very dark black', 'finspire' ),
            'slug' => 'very-dark-black',
            'color' => '#000000',
        ),
    ) );
	
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name' => esc_html__( 'Small', 'finspire' ),
			'size' => 10,
			'slug' => 'small'
		),
		array(
			'name' => esc_html__( 'Normal', 'finspire' ),
			'size' => 15,
			'slug' => 'normal'
		),
		array(
			'name' => esc_html__( 'Large', 'finspire' ),
			'size' => 24,
			'slug' => 'large'
		),
		array(
			'name' => esc_html__( 'Huge', 'finspire' ),
			'size' => 36,
			'slug' => 'huge'
		)
	) );
	
}
add_action( 'after_setup_theme', 'finspire_gutenberg_editor_palette_styles' );

/*---------- Gutenberg settings ends ----------*/

/*---------- Enqueue Styles and Scripts ----------*/

function finspire_enqueue_scripts() {
	// Color Scheme Code
	$options = finspire_WSH()->option();
	
	$header_meta = get_post_meta( get_the_ID(), 'header_style_settings');
	$header_option = $options->get( 'header_style_settings' );
	$header = ( $header_meta ) ? $header_meta['0'] : $header_option;
		
	if( $options->get( 'main_color_scheme' ) ){
		$maincolor = str_replace( '#', '' , $options->get( 'main_color_scheme' ));
		
	}else{
		$maincolor = str_replace( '#', '' , '#00c486' );
	}
	if( $options->get( 'secondary_color_scheme' ) ){
		$secondcolor = str_replace( '#', '' , $options->get( 'secondary_color_scheme' ));
	}
	else{
		$secondcolor = str_replace( '#', '' , '#062a26' );	
	}
	
    //styles
    wp_enqueue_style( 'font-awesome-all', get_template_directory_uri() . '/assets/css/font-awesome-all.css' );
	wp_enqueue_style( 'flaticon', get_template_directory_uri() . '/assets/css/flaticon.css' );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css' );
	wp_enqueue_style( 'jquery-fancybox', get_template_directory_uri() . '/assets/css/jquery.fancybox.min.css' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/css/animate.css' );
	wp_enqueue_style( 'nice-select', get_template_directory_uri() . '/assets/css/nice-select.css' );
	wp_enqueue_style( 'odometer', get_template_directory_uri() . '/assets/css/odometer.css' );
	wp_enqueue_style( 'swiper-bundle', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css' );
	wp_enqueue_style( 'jquery-ui', get_template_directory_uri() . '/assets/css/jquery-ui.css' );
	wp_enqueue_style( 'elpath', get_template_directory_uri() . '/assets/css/elpath.css' );
	wp_enqueue_style( 'finspire-main', get_stylesheet_uri() );
	wp_enqueue_style( 'finspire-main-style', get_template_directory_uri() . '/assets/css/style.css' );
	wp_enqueue_style( 'finspire-custom', get_template_directory_uri() . '/assets/css/custom.css' );
	wp_enqueue_style( 'finspire-tut', get_template_directory_uri() . '/assets/css/tut.css' );
	wp_enqueue_style( 'finspire-gutenberg', get_template_directory_uri() . '/assets/css/gutenberg.css' );
	wp_enqueue_style( 'finspire-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css' );
	wp_enqueue_style( 'finspire-responsive', get_template_directory_uri() . '/assets/css/responsive.css' );
	
    //scripts
	wp_enqueue_script( 'jquery-ui-core');
	wp_enqueue_script( 'popper', get_template_directory_uri().'/assets/js/popper.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri().'/assets/js/bootstrap.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'gsap', get_template_directory_uri().'/assets/js/gsap.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'gsap-scroll-trigger', get_template_directory_uri().'/assets/js/gsap-scroll-trigger.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'wow', get_template_directory_uri().'/assets/js/wow.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'jquery-fancybox', get_template_directory_uri().'/assets/js/jquery.fancybox.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'appear', get_template_directory_uri().'/assets/js/appear.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'odometer', get_template_directory_uri().'/assets/js/odometer.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'isotope', get_template_directory_uri().'/assets/js/isotope.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'swiper-bundle', get_template_directory_uri().'/assets/js/swiper-bundle.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'jquery-nice-select', get_template_directory_uri().'/assets/js/jquery.nice-select.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'jquery-lettering', get_template_directory_uri().'/assets/js/jquery.lettering.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'jquery-circletype', get_template_directory_uri().'/assets/js/jquery.circleType.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'chart', get_template_directory_uri().'/assets/js/chart.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'charts', get_template_directory_uri().'/assets/js/chart.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'jquery-ui', get_template_directory_uri().'/assets/js/jquery-ui.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'marquee', get_template_directory_uri().'/assets/js/marquee.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'finspire-main-theme', get_template_directory_uri().'/assets/js/script.js', array(), false, true );
	
	if( is_singular() ) wp_enqueue_script('comment-reply');
}
add_action( 'wp_enqueue_scripts', 'finspire_enqueue_scripts' );

/*---------- Enqueue styles and scripts ends ----------*/

/*---------- Google fonts ----------*/

function finspire_fonts_url() {
    $fonts_url = '';

    // Define the fonts and their weights/styles
    $font_families = array(
        'Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800'
    );

    // Allow modifications via filter
    $font_families = apply_filters('finspire_font_families', $font_families);

    // Build the Google Fonts URL
    $query_args = array(
        'family'  => implode('&family=', $font_families),
        'display' => 'swap'
    );

    $protocol  = is_ssl() ? 'https' : 'http';
    $fonts_url = add_query_arg($query_args, $protocol . '://fonts.googleapis.com/css2');

    return esc_url_raw($fonts_url);
}


function finspire_theme_styles() {
    wp_enqueue_style( 'finspire-theme-fonts', finspire_fonts_url(), array(), null );
}

add_action( 'wp_enqueue_scripts', 'finspire_theme_styles' );
add_action( 'admin_enqueue_scripts', 'finspire_theme_styles' );

/*---------- Google fonts ends ----------*/

/*---------- More functions ----------*/

// 1) finspire_set function

/**
 * [finspire_set description]
 *
 * @param  array $data [description]
 *
 * @return [type]       [description]
 */
if ( ! function_exists( 'finspire_set' ) ) {
	function finspire_set( $var, $key, $def = '' ) {

		if ( is_object( $var ) && isset( $var->$key ) ) {
			return $var->$key;
		} elseif ( is_array( $var ) && isset( $var[ $key ] ) ) {
			return $var[ $key ];
		} elseif ( $def ) {
			return $def;
		} else {
			return false;
		}
	}
}

// 2) finspire_add_editor_styles function

function finspire_add_editor_styles() {
    add_editor_style( 'editor-style.css' );
}
add_action( 'admin_init', 'finspire_add_editor_styles' );

// 3) Add specific CSS class by filter body class.

$options = finspire_WSH()->option(); 
if( finspire_set($options, 'boxed_wrapper') ){

add_filter( 'body_class', function( $classes ) {
    $classes[] = 'boxed_wrapper';
    return $classes;
} );
}

add_filter('doing_it_wrong_trigger_error', function () {return false;}, 10, 0);


//Related Products

function finspire_related_products_limit() {
  global $product;
	
	$args['posts_per_page'] = 6;
	return $args;
}
function finspire_register_block_patterns() {
    register_block_pattern(
        'finspire/custom-pattern-1',
        array(
            'title'       => __('Custom Pattern 1', 'finspire'),
            'description' => __('Description of Custom Pattern 1.', 'finspire'),
            'content'     => '<!-- Your block pattern content here -->',
            'categories'  => array('text'),
            'keywords'    => array('pattern', 'layout', 'custom'),
        )
    );

    // Add more block patterns as needed
}
add_action('init', 'finspire_register_block_patterns');
function finspire_register_block_styles() {
    // Register custom block styles for specific blocks
    register_block_style(
        'core/paragraph',
        array(
            'name'         => 'finspire-custom-style-1',
            'label'        => __('Custom Style 1', 'finspire'),
            'style_handle' => 'finspire-custom-style-1-css', // Enqueue your custom style CSS
        )
    );

    // Add more custom block styles as needed
}
add_action('init', 'finspire_register_block_styles');

function finspire_set_permalinks_on_activation() {
    // Define the "Day and name" structure
    $day_and_name_structure = '/%year%/%monthnum%/%day%/%postname%/';

    // Get the current structure from the database
    $current_structure = get_option('permalink_structure');

    // Only update if the structure is different to save server resources
    if ($current_structure !== $day_and_name_structure) {
        // 1. Update the option in the wp_options table
        update_option('permalink_structure', $day_and_name_structure);

        // 2. Flush the rewrite rules so the .htaccess file updates immediately
        // The 'true' parameter tells WP to hard-flush the .htaccess file
        flush_rewrite_rules(true);
    }
}

// This hook triggers ONLY when the theme is activated via the Admin Panel
add_action('after_switch_theme', 'finspire_set_permalinks_on_activation');