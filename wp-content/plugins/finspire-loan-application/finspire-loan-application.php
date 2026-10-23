<?php
/**
 * Plugin Name: Finspire Custom Loan Application
 * Description: Fully-featured, responsive, 4-step custom loan advice application form with database storage, email notifications, spam protection, and admin submission management.
 * Version: 1.0.0
 * Author: Finspire Team
 * Text Domain: finspire-loan
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'FINSPIRE_LOAN_VERSION', '1.0.0' );
define( 'FINSPIRE_LOAN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'FINSPIRE_LOAN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include Core Classes
require_once FINSPIRE_LOAN_PLUGIN_DIR . 'includes/class-loan-db.php';
require_once FINSPIRE_LOAN_PLUGIN_DIR . 'includes/class-loan-settings.php';
require_once FINSPIRE_LOAN_PLUGIN_DIR . 'includes/class-loan-mailer.php';
require_once FINSPIRE_LOAN_PLUGIN_DIR . 'includes/class-loan-form-handler.php';
require_once FINSPIRE_LOAN_PLUGIN_DIR . 'includes/class-loan-admin.php';

/**
 * Main Plugin Initialization
 */
class Finspire_Loan_Application_Plugin {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'init', [ $this, 'init' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
        add_shortcode( 'loan_application_form', [ $this, 'render_shortcode' ] );
        add_shortcode( 'custom_loan_form', [ $this, 'render_shortcode' ] );

        // Theme CTA filter to ensure "Get Free Advice" directs to loan form
        add_filter( 'theme_mod_finspire_options-mods', [ $this, 'filter_theme_mods' ] );
    }

    /**
     * Plugin Activation
     */
    public function activate() {
        // 1. Create database table
        Finspire_Loan_DB::create_tables();

        // 2. Ensure loan page exists
        $page_id = self::ensure_loan_page_exists();

        // 3. Sync CTA navigation button
        if ( $page_id > 0 ) {
            Finspire_Loan_Admin::sync_cta_destination( $page_id );
        }
    }

    /**
     * Ensure dedicated "Apply for Loan Advice" page exists
     */
    public static function ensure_loan_page_exists() {
        $saved_page_id = Finspire_Loan_Settings::get( 'loan_page_id', 0 );

        if ( $saved_page_id > 0 && get_post( $saved_page_id ) ) {
            return $saved_page_id;
        }

        // Check if page with slug 'apply' or title 'Apply for Loan Advice' already exists
        $existing = get_page_by_path( 'apply' );
        if ( ! $existing ) {
            $existing = get_page_by_path( 'loan-application' );
        }

        if ( $existing ) {
            Finspire_Loan_Settings::update_all( [ 'loan_page_id' => $existing->ID ] );
            return $existing->ID;
        }

        // Create page
        $page_data = [
            'post_title'     => __( 'Apply for Loan Advice', 'finspire-loan' ),
            'post_name'      => 'apply',
            'post_content'    => '<!-- wp:shortcode -->[loan_application_form]<!-- /wp:shortcode -->',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'comment_status' => 'closed',
        ];

        $new_page_id = wp_insert_post( $page_data );

        if ( ! is_wp_error( $new_page_id ) && $new_page_id > 0 ) {
            // Set page template to default elementor template if available
            update_post_meta( $new_page_id, '_wp_page_template', 'tpl-default-elementor.php' );
            Finspire_Loan_Settings::update_all( [ 'loan_page_id' => $new_page_id ] );
            return $new_page_id;
        }

        return 0;
    }

    /**
     * Runtime Init
     */
    public function init() {
        Finspire_Loan_Form_Handler::init();
        if ( is_admin() ) {
            Finspire_Loan_Admin::init();
        }
    }

    /**
     * Check if current page is the loan form page
     */
    public function is_loan_page() {
        if ( is_admin() ) {
            return false;
        }

        global $post;
        if ( ! is_a( $post, 'WP_Post' ) ) {
            return false;
        }

        $loan_page_id = intval( Finspire_Loan_Settings::get( 'loan_page_id', 0 ) );
        if ( $loan_page_id > 0 && $post->ID === $loan_page_id ) {
            return true;
        }

        if ( has_shortcode( $post->post_content, 'loan_application_form' ) || has_shortcode( $post->post_content, 'custom_loan_form' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Enqueue CSS and JS assets
     */
    public function enqueue_assets() {
        if ( ! $this->is_loan_page() ) {
            return;
        }

        // Fonts: DM Sans for crisp modern typography matching reference
        wp_enqueue_style(
            'finspire-loan-fonts',
            'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400..800;1,9..40,400..800&display=swap',
            [],
            null
        );

        wp_enqueue_style(
            'finspire-loan-form-css',
            FINSPIRE_LOAN_PLUGIN_URL . 'assets/css/loan-form.css',
            [],
            FINSPIRE_LOAN_VERSION
        );

        wp_enqueue_script(
            'finspire-loan-form-js',
            FINSPIRE_LOAN_PLUGIN_URL . 'assets/js/loan-form.js',
            [ 'jquery' ],
            FINSPIRE_LOAN_VERSION,
            true
        );

        $settings = Finspire_Loan_Settings::get_all();

        wp_localize_script( 'finspire-loan-form-js', 'FinspireLoanData', [
            'ajax_url'            => admin_url( 'admin-ajax.php' ),
            'nonce'               => wp_create_nonce( 'finspire_loan_nonce' ),
            'currency_symbol'     => $settings['currency_symbol'] ?? '$',
            'min_loan_amount'     => floatval( $settings['min_loan_amount'] ?? 100 ),
            'max_loan_amount'     => floatval( $settings['max_loan_amount'] ?? 25000 ),
            'default_loan_amount' => floatval( $settings['default_loan_amount'] ?? 500 ),
            'step1_header'        => $settings['step1_header'] ?? 'Step 1 of 4 — Personal Info',
            'step2_header'        => $settings['step2_header'] ?? 'Step 2 of 4 — Address',
            'step3_header'        => $settings['step3_header'] ?? 'Step 3 of 4 — Banking Details',
            'step4_header'        => $settings['step4_header'] ?? 'Step 4 of 4 — Loan Amount',
        ] );
    }

    /**
     * Shortcode callback
     */
    public function render_shortcode() {
        ob_start();
        include FINSPIRE_LOAN_PLUGIN_DIR . 'templates/loan-form.php';
        return ob_get_clean();
    }

    /**
     * Filter theme mods to keep "Get Free Advice" pointing to loan page
     */
    public function filter_theme_mods( $mods ) {
        $loan_page_id = Finspire_Loan_Settings::get( 'loan_page_id', 0 );
        if ( $loan_page_id > 0 && is_array( $mods ) ) {
            $mods['page_selects'] = (string) $loan_page_id;
        }
        return $mods;
    }
}

// Instantiate plugin
Finspire_Loan_Application_Plugin::instance();
