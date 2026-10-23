<?php
/**
 * Available filters for extending Merlin WP.
 *
 * @package   Merlin WP
 * @version   @@pkg.version
 * @link      https://merlinwp.com/
 * @author    Rich Tabor, from ThemeBeans.com & the team at ProteusThemes.com
 * @copyright Copyright (c) 2018, Merlin WP of Inventionn LLC
 * @license   Licensed GPLv3 for Open Source Use
 */


/**
 * Add your widget area to unset the default widgets from.
 * If your theme's first widget area is "sidebar-1", you don't need this.
 *
 * @see https://stackoverflow.com/questions/11757461/how-to-populate-widgets-on-sidebar-on-theme-activation
 *
 * @param  array $widget_areas Arguments for the sidebars_widgets widget areas.
 *
 * @return array of arguments to update the sidebars_widgets option.
 */
function finspire_unset_default_widgets_args( $widget_areas ) {

	$widget_areas = array(
		'default-sidebar' => array(),
	);

	return $widget_areas;
}

add_filter( 'merlin_unset_default_widgets_args', 'finspire_unset_default_widgets_args' );

/**
 * Custom content for the generated child theme's functions.php file.
 *
 * @param string $output Generated content.
 * @param string $slug   Parent theme slug.
 */
function finspire_child_functions_php( $output, $slug ) {

	$slug_no_hyphens = strtolower( preg_replace( '#[^a-zA-Z]#', '', $slug ) );

	$output = "
		<?php
		/**
		 * Theme functions and definitions.
		 */
		function {$slug_no_hyphens}_child_enqueue_styles() {

		    if ( SCRIPT_DEBUG ) {
		        wp_enqueue_style( '{$slug}-style' , get_template_directory_uri() . '/style.css' );
		    } else {
		        wp_enqueue_style( '{$slug}-minified-style' , get_template_directory_uri() . '/style.css' );
		    }

		    wp_enqueue_style( '{$slug}-child-style',
		        get_stylesheet_directory_uri() . '/style.css',
		        array( '{$slug}-style' ),
		        wp_get_theme()->get('Version')
		    );
		}

		add_action(  'wp_enqueue_scripts', '{$slug_no_hyphens}_child_enqueue_styles' );\n
	";

	// Let's remove the tabs so that it displays nicely.
	$output = trim( preg_replace( '/\t+/', '', $output ) );

	// Filterable return.
	return $output;
}

add_filter( 'merlin_generate_child_functions_php', 'finspire_child_functions_php', 10, 2 );

/**
 * Define the demo import files (local files).
 * You have to use the same filter as in above example,
 * but with a slightly different array keys: local_*.
 * The values have to be absolute paths (not URLs) to your import files.
 * To use local import files, that reside in your theme folder,
 * please use the below code.
 * Note: make sure your import files are readable!
 */
function finspire_local_import_files() {
	return array(
		array(
			'import_file_name'         => esc_html__('Main Demo', 'finspire'),
			'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'demo-import/content/widgets.json',
			'local_import_redux'       => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'demo-import/content/redux_options.json',
					'option_name' => 'finspire_options',
				),
			),
			'local_import_file'        => trailingslashit( get_template_directory() ) . 'demo-import/content/content.xml',
			'import_preview_image_url' => get_template_directory_uri() . '/screenshot.png',
			'import_notice'            => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'finspire' ),
			'preview_url'              => 'http://commonsupport.net/newwp/finspire/',
		),
	);
}

add_filter( 'merlin_import_files', 'finspire_local_import_files' );

/**
 * Execute custom code after the whole import has finished.
 */
function finspire_after_import_setup() {
	// Assign menus to their locations.
	$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	$footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );

	set_theme_mod(
		'nav_menu_locations', array(
			'main_menu' => $main_menu->term_id,
			'footer_menu' => $footer_menu->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Home Page 01' );
	$blog_page_id  = get_page_by_title( 'Blog List View' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );
    
    $logo = get_page_by_title( 'logo', OBJECT, 'attachment' );

    if( $logo ) {
    	set_theme_mod( 'custom_logo', $logo->ID );
    }

	// Set Permalink Structure to Day and Name
	
	
	// Import other Elementor Settings
	finspire_import_elementor_settings();
	
	// Regenerate Elementor CSS
	finspire_regenerate_elementor_css();
	
	// Flush rewrite rules after everything is done
	flush_rewrite_rules();
}

add_action( 'merlin_after_all_import', 'finspire_after_import_setup' );


/**
 * Set Permalink Structure to Day and Name
 * Format: /%year%/%monthnum%/%day%/%postname%/
 */


/**
 * Import Elementor Global Settings
 */
function finspire_import_elementor_settings() {
	
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	// Get the active Elementor kit ID
	$kit_id = \Elementor\Plugin::$instance->kits_manager->get_active_id();
	
	if ( ! $kit_id ) {
		return;
	}

	// Get current settings
	$current_settings = get_post_meta( $kit_id, '_elementor_page_settings', true );
	if ( ! is_array( $current_settings ) ) {
		$current_settings = array();
	}

	// Define your Global Colors
	$global_colors = array(
		array(
			'_id'   => 'primary',
			'title' => esc_html__( 'Primary', 'finspire' ),
			'color' => '#EF433C',
		),
		array(
			'_id'   => 'secondary',
			'title' => esc_html__( 'Secondary', 'finspire' ),
			'color' => '#1C1C1C',
		),
		array(
			'_id'   => 'text',
			'title' => esc_html__( 'Text', 'finspire' ),
			'color' => '#4F5B64',
		),
		array(
			'_id'   => 'accent',
			'title' => esc_html__( 'Title', 'finspire' ),
			'color' => '#1C1C1C',
		),
	);

	// Define your Global Fonts
	$global_fonts = array(
		array(
			'_id'           => 'primary',
			'title'         => esc_html__( 'Primary Heading', 'finspire' ),
			'typography_typography' => 'custom',
			'typography_font_family' => 'Plus Jakarta Sans',
			'typography_font_weight' => '600',
		),
		array(
			'_id'           => 'secondary',
			'title'         => esc_html__( 'Secondary Heading', 'finspire' ),
			'typography_typography' => 'custom',
			'typography_font_family' => 'Plus Jakarta Sans',
			'typography_font_weight' => '400',
		),
		array(
			'_id'           => 'text',
			'title'         => esc_html__( 'Body Text', 'finspire' ),
			'typography_typography' => 'custom',
			'typography_font_family' => 'Plus Jakarta Sans',
			'typography_font_weight' => '400',
		),
		array(
			'_id'           => 'accent',
			'title'         => esc_html__( 'Accent Text', 'finspire' ),
			'typography_typography' => 'custom',
			'typography_font_family' => 'Plus Jakarta Sans',
			'typography_font_weight' => '500',
		),
	);

	// Update settings
	$updated_settings = array_merge( $current_settings, array(
		'system_colors' => $global_colors,
		'system_typography' => $global_fonts,
		'custom_typography' => array(),
		'container_width' => array(
			'unit' => 'px',
			'size' => 1200,
		),
		'viewport_lg' => 1200,
		'page_title_selector' => 'h1.entry-title',
	) );
	
	// Update kit settings
	update_post_meta( $kit_id, '_elementor_page_settings', $updated_settings );
	
	// Set other Elementor options
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );
	update_option( 'elementor_cpt_support', array( 'page', 'post', 'header', 'footer', 'mega_menu' ) );
	update_option( 'elementor_load_fa4_shim', 'yes' );

	error_log( 'Finspire Import: Elementor global settings imported' );
}

/**
 * Regenerate Elementor CSS files after import
 */
function finspire_regenerate_elementor_css() {
	
	if ( ! did_action( 'elementor/loaded' ) ) {
		error_log( 'Finspire Import: Cannot regenerate CSS - Elementor not loaded' );
		return;
	}

	// Clear Elementor cache
	if ( class_exists( '\Elementor\Plugin' ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}

	// Regenerate CSS for all Elementor pages
	if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
		$post_ids = get_posts( array(
			'post_type'      => any,
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'meta_key'       => '_elementor_edit_mode',
			'meta_value'     => 'builder',
		) );

		foreach ( $post_ids as $post_id ) {
			$css_file = new \Elementor\Core\Files\CSS\Post( $post_id );
			$css_file->update();
		}
	}

	// Clear transients
	delete_transient( 'elementor_google_fonts' );
	
	error_log( 'Finspire Import: Elementor CSS regenerated' );
}


/**
 * Helper function to export current Elementor settings
 * Add ?export_elementor_settings=1 to any page URL to export settings
 * This is useful during development to get your current settings
 */
function finspire_export_elementor_settings_helper() {
	
	if ( ! current_user_can( 'manage_options' ) || ! isset( $_GET['export_elementor_settings'] ) ) {
		return;
	}

	if ( ! did_action( 'elementor/loaded' ) ) {
		wp_die( 'Elementor is not active' );
	}

	$kit_id = \Elementor\Plugin::$instance->kits_manager->get_active_id();
	
	if ( ! $kit_id ) {
		wp_die( 'No active Elementor kit found' );
	}

	$settings = get_post_meta( $kit_id, '_elementor_page_settings', true );
	
	$export_data = array(
		'kit_settings'      => $settings,
		'elementor_options'  => array(
			'elementor_container_width'                        => get_option( 'elementor_container_width' ),
			'elementor_space_between_widgets'                  => get_option( 'elementor_space_between_widgets' ),
			'elementor_stretched_section_container'            => get_option( 'elementor_stretched_section_container' ),
			'elementor_page_title_selector'                    => get_option( 'elementor_page_title_selector' ),
			'elementor_disable_color_schemes'                  => get_option( 'elementor_disable_color_schemes' ),
			'elementor_disable_typography_schemes'             => get_option( 'elementor_disable_typography_schemes' ),
			'elementor_cpt_support'                            => get_option( 'elementor_cpt_support' ),
			'elementor_experiment-container'                   => get_option( 'elementor_experiment-container' ),
			'elementor_experiment-e_dom_optimization'          => get_option( 'elementor_experiment-e_dom_optimization' ),
			'elementor_experiment-e_optimized_assets_loading'  => get_option( 'elementor_experiment-e_optimized_assets_loading' ),
		),
	);

	// Output as downloadable JSON
	header( 'Content-Type: application/json' );
	header( 'Content-Disposition: attachment; filename="elementor-settings.json"' );
	echo json_encode( $export_data, JSON_PRETTY_PRINT );
	exit;
}

add_action( 'init', 'finspire_export_elementor_settings_helper' );