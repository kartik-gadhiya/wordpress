<?php
/**
 * Merlin WP configuration file.
 */

if ( ! class_exists( 'Merlin' ) ) {
	return;
}

defined('THEMAZINE_IMPORT_VENDOR_PATH') || define('THEMAZINE_IMPORT_VENDOR_PATH', get_template_directory() . '/demo-import/vendor/');
require_once THEMAZINE_IMPORT_VENDOR_PATH . 'autoload.php';

if ( ! class_exists( '\WP_Importer' ) ) {
	require ABSPATH . '/wp-admin/includes/class-wp-importer.php';
}
require_once get_template_directory() . '/demo-import/importer/WPImporterLogger.php';
require_once get_template_directory() . '/demo-import/importer/WPImporterLoggerCLI.php';
require_once get_template_directory() . '/demo-import/importer/WXRImportInfo.php';
require_once get_template_directory() . '/demo-import/importer/WXRImporter.php';
require_once get_template_directory() . '/demo-import/importer/Importer.php';

/**
 * Initialize Merlin on init hook to avoid early translation load.
 */
function themekalia_init_merlin_wizard() {

	$wizard = new Merlin(

		$config = array(
			'directory'            => 'demo-import',
			'merlin_url'           => 'demo-import',
			'parent_slug'          => 'themes.php',
			'capability'           => 'manage_options',
			'child_action_btn_url' => 'https://codex.wordpress.org/child_themes',
			'dev_mode'             => true,
			'license_step'         => false,
			'license_required'     => false,
			'license_help_url'     => '',
			'edd_remote_api_url'   => '',
			'edd_item_name'        => 'Finspire',
			'edd_theme_slug'       => 'finspire',
			'ready_big_button_url' => home_url( '/' ),
		),

		$strings = array(
			'admin-menu'               => esc_html__( 'Theme Kalia Import', 'finspire' ),
			'title%s%s%s%s'            => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'finspire' ),
			'return-to-dashboard'      => esc_html__( 'Return to the dashboard', 'finspire' ),
			'ignore'                   => esc_html__( 'Disable this wizard', 'finspire' ),
			'btn-skip'                 => esc_html__( 'Skip', 'finspire' ),
			'btn-next'                 => esc_html__( 'Next', 'finspire' ),
			'btn-start'                => esc_html__( 'Start', 'finspire' ),
			'btn-no'                   => esc_html__( 'Cancel', 'finspire' ),
			'btn-plugins-install'      => esc_html__( 'Install', 'finspire' ),
			'btn-child-install'        => esc_html__( 'Install', 'finspire' ),
			'btn-content-install'      => esc_html__( 'Install', 'finspire' ),
			'btn-import'               => esc_html__( 'Import', 'finspire' ),
			'btn-license-activate'     => esc_html__( 'Activate', 'finspire' ),
			'btn-license-skip'         => esc_html__( 'Later', 'finspire' ),
			'license-header%s'         => esc_html__( 'Activate %s', 'finspire' ),
			'license-header-success%s' => esc_html__( '%s is Activated', 'finspire' ),
			'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'finspire' ),
			'license-label'            => esc_html__( 'License key', 'finspire' ),
			'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'finspire' ),
			'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'finspire' ),
			'license-tooltip'          => esc_html__( 'Need help?', 'finspire' ),
			'welcome-header%s'         => esc_html__( 'Welcome to %s', 'finspire' ),
			'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'finspire' ),
			'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'finspire' ),
			'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'finspire' ),
			'child-header'             => esc_html__( 'Install Child Theme', 'finspire' ),
			'child-header-success'     => esc_html__( 'You\'re good to go!', 'finspire' ),
			'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'finspire' ),
			'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'finspire' ),
			'child-action-link'        => esc_html__( 'Learn about child themes', 'finspire' ),
			'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'finspire' ),
			'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'finspire' ),
			'plugins-header'           => esc_html__( 'Install Plugins', 'finspire' ),
			'plugins-header-success'   => esc_html__( 'You\'re up to speed!', 'finspire' ),
			'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'finspire' ),
			'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'finspire' ),
			'plugins-action-link'      => esc_html__( 'Advanced', 'finspire' ),
			'import-header'            => esc_html__( 'Import Content', 'finspire' ),
			'import'                   => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'finspire' ),
			'import-action-link'       => esc_html__( 'Advanced', 'finspire' ),
			'ready-header'             => esc_html__( 'All done. Have fun!', 'finspire' ),
			'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'finspire' ),
			'ready-action-link'        => esc_html__( 'Extras', 'finspire' ),
			'ready-big-button'         => esc_html__( 'View your website', 'finspire' ),
			'ready-link-1'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://themeforest.net/user/themekalia/', esc_html__( '5 Star For Project Finspire', 'finspire' ) ),
			'ready-link-2'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://themekalia.com/support', esc_html__( 'Get Finspire Theme Support', 'finspire' ) ),
		)
	);
}
add_action( 'init', 'themekalia_init_merlin_wizard' );
