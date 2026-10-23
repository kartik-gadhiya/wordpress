<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Finspire_Loan_Mailer {

    /**
     * Send both admin notification and applicant confirmation emails
     */
    public static function send_notifications( array $submission ) {
        self::send_admin_notification( $submission );
        self::send_applicant_confirmation( $submission );
    }

    /**
     * Send email to site administrators
     */
    public static function send_admin_notification( array $submission ) {
        if ( ! Finspire_Loan_Settings::get( 'admin_email_enabled', 1 ) ) {
            return false;
        }

        $recipients = Finspire_Loan_Settings::get( 'admin_recipients', get_option( 'admin_email' ) );
        if ( empty( $recipients ) ) {
            return false;
        }

        $site_name = get_bloginfo( 'name' );
        $ref_no    = esc_html( $submission['reference_no'] ?? '' );
        $name      = esc_html( trim( ( $submission['first_name'] ?? '' ) . ' ' . ( $submission['last_name'] ?? '' ) ) );
        $email     = sanitize_email( $submission['email'] ?? '' );
        $phone     = esc_html( $submission['phone'] ?? '' );
        $amount    = number_format( floatval( $submission['loan_amount'] ?? 0 ), 2 );
        $currency  = esc_html( Finspire_Loan_Settings::get( 'currency_symbol', '$' ) );
        $date      = esc_html( $submission['created_at'] ?? current_time( 'mysql' ) );
        $view_url  = admin_url( 'admin.php?page=finspire-loan-submissions&action=view&id=' . intval( $submission['id'] ?? 0 ) );

        $subject_tpl = Finspire_Loan_Settings::get( 'admin_email_subject', '[New Loan Application] #{reference_no} - {first_name} {last_name}' );
        $subject = str_replace(
            ['{reference_no}', '{first_name}', '{last_name}', '{site_name}'],
            [$ref_no, $submission['first_name'] ?? '', $submission['last_name'] ?? '', $site_name],
            $subject_tpl
        );

        $body = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6fa; margin: 0; padding: 24px; color: #1e293b; }
                .email-container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
                .header { background: #132238; color: #ffffff; padding: 24px 30px; }
                .header h2 { margin: 0 0 6px 0; font-size: 20px; font-weight: 700; color: #ffffff; }
                .header p { margin: 0; font-size: 13px; color: #94a3b8; }
                .content { padding: 30px; }
                .ref-badge { display: inline-block; background: #fef2f2; color: #dc2626; padding: 4px 12px; border-radius: 999px; font-weight: 700; font-size: 12px; margin-bottom: 20px; }
                .table-info { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
                .table-info td { padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
                .table-info td.label { width: 40%; color: #64748b; font-weight: 500; }
                .table-info td.val { width: 60%; color: #0f172a; font-weight: 600; }
                .btn { display: inline-block; background: #dc2626; color: #ffffff !important; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: 600; font-size: 14px; }
                .footer { padding: 20px 30px; background: #f8fafc; font-size: 12px; color: #94a3b8; border-top: 1px solid #f1f5f9; text-align: center; }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">
                    <h2>' . esc_html( $site_name ) . ' — New Loan Application</h2>
                    <p>A new multi-step loan advice enquiry has been submitted on your website.</p>
                </div>
                <div class="content">
                    <span class="ref-badge">Ref: ' . $ref_no . '</span>
                    <table class="table-info">
                        <tr><td class="label">Applicant Name:</td><td class="val">' . $name . '</td></tr>
                        <tr><td class="label">Email Address:</td><td class="val"><a href="mailto:' . esc_attr( $email ) . '">' . $email . '</a></td></tr>
                        <tr><td class="label">Date of Birth:</td><td class="val">' . esc_html( $submission['dob'] ?? 'Not specified' ) . '</td></tr>
                        <tr><td class="label">SSN (Masked):</td><td class="val">' . esc_html( $submission['ssn_masked'] ?? '•••••••••' ) . '</td></tr>
                        <tr><td class="label">Address:</td><td class="val">' . esc_html( trim( ($submission['street_address'] ?? '') . ', ' . ($submission['city'] ?? '') . ', ' . ($submission['state'] ?? '') . ' ' . ($submission['zip_code'] ?? '') . ', ' . ($submission['country'] ?? '') ) ) . '</td></tr>
                        <tr><td class="label">Bank Name:</td><td class="val">' . esc_html( $submission['bank_name'] ?? 'Not specified' ) . '</td></tr>
                        <tr><td class="label">Routing Number:</td><td class="val">' . esc_html( $submission['routing_number'] ?? '—' ) . '</td></tr>
                        <tr><td class="label">Account Number:</td><td class="val">' . esc_html( $submission['account_number_masked'] ?? '—' ) . '</td></tr>
                        <tr><td class="label">Requested Loan Amount:</td><td class="val" style="color:#dc2626; font-size:16px;">' . $currency . $amount . '</td></tr>
                        <tr><td class="label">Submitted On:</td><td class="val">' . $date . '</td></tr>
                    </table>
                    <p style="text-align: center; margin: 28px 0 10px 0;">
                        <a href="' . esc_url( $view_url ) . '" class="btn">View Full Submission in Admin</a>
                    </p>
                </div>
                <div class="footer">
                    &copy; ' . gmdate('Y') . ' ' . esc_html( $site_name ) . '. All rights reserved. Secure administrator notification.
                </div>
            </div>
        </body>
        </html>';

        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'Reply-To: ' . $name . ' <' . $email . '>',
        ];

        try {
            return wp_mail( $recipients, $subject, $body, $headers );
        } catch ( \Exception $e ) {
            error_log( 'Finspire Loan Form Mailer Error: ' . $e->getMessage() );
            return false;
        }
    }

    /**
     * Send confirmation email to the applicant
     */
    public static function send_applicant_confirmation( array $submission ) {
        if ( ! Finspire_Loan_Settings::get( 'applicant_email_enabled', 1 ) ) {
            return false;
        }

        $applicant_email = sanitize_email( $submission['email'] ?? '' );
        if ( empty( $applicant_email ) ) {
            return false;
        }

        $site_name = get_bloginfo( 'name' );
        $ref_no    = esc_html( $submission['reference_no'] ?? '' );
        $first_name= esc_html( $submission['first_name'] ?? '' );
        $amount    = number_format( floatval( $submission['loan_amount'] ?? 0 ), 2 );
        $currency  = esc_html( Finspire_Loan_Settings::get( 'currency_symbol', '$' ) );
        $privacy_url = esc_url( Finspire_Loan_Settings::get( 'privacy_policy_url', home_url( '/privacy-policy/' ) ) );

        $subject_tpl = Finspire_Loan_Settings::get( 'applicant_email_subject', 'Your Loan Application #{reference_no} Has Been Received' );
        $subject = str_replace(
            ['{reference_no}', '{first_name}', '{last_name}', '{site_name}'],
            [$ref_no, $first_name, $submission['last_name'] ?? '', $site_name],
            $subject_tpl
        );

        $body = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6fa; margin: 0; padding: 24px; color: #1e293b; }
                .email-container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
                .header { background: #132238; color: #ffffff; padding: 28px 30px; text-align: center; }
                .header h1 { margin: 0 0 6px 0; font-size: 22px; font-weight: 700; color: #ffffff; }
                .header p { margin: 0; font-size: 13px; color: #94a3b8; }
                .content { padding: 30px; }
                .success-badge { text-align: center; margin: 10px 0 24px 0; }
                .check-circle { display: inline-block; width: 48px; height: 48px; line-height: 48px; border-radius: 50%; background: #dcfce7; color: #16a34a; font-size: 24px; font-weight: bold; }
                .summary-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin: 20px 0; }
                .summary-card p { margin: 8px 0; font-size: 14px; }
                .summary-card p strong { color: #0f172a; }
                .footer { padding: 20px 30px; background: #f8fafc; font-size: 12px; color: #94a3b8; border-top: 1px solid #f1f5f9; text-align: center; line-height: 1.6; }
                .footer a { color: #64748b; text-decoration: underline; }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">
                    <h1>' . esc_html( $site_name ) . '</h1>
                    <p>Loan Advice &amp; Financial Consulting</p>
                </div>
                <div class="content">
                    <div class="success-badge">
                        <div class="check-circle">&#10003;</div>
                        <h2 style="margin: 12px 0 6px 0; color: #0f172a; font-size: 20px;">Your Request Has Been Submitted!</h2>
                        <p style="margin: 0; color: #64748b; font-size: 14px;">Thank you, <strong>' . $first_name . '</strong>. We have received your request.</p>
                    </div>

                    <div class="summary-card">
                        <p><strong>Submission Reference:</strong> ' . $ref_no . '</p>
                        <p><strong>Requested Loan Amount:</strong> ' . $currency . $amount . '</p>
                        <p><strong>Status:</strong> Under Advisory Review</p>
                    </div>

                    <h3 style="font-size: 15px; color: #0f172a; margin-top: 24px;">What Happens Next?</h3>
                    <p style="font-size: 14px; color: #475569; line-height: 1.6;">
                        One of our loan advisors will review your preferences and contact you via your preferred communication method within one business day to discuss available options.
                    </p>
                    <p style="font-size: 14px; color: #475569; line-height: 1.6;">
                        If you have any questions in the meantime, simply reply to this email or visit our website.
                    </p>
                </div>
                <div class="footer">
                    &copy; ' . gmdate('Y') . ' ' . esc_html( $site_name ) . '. All rights reserved.<br>
                    <a href="' . $privacy_url . '">Privacy Policy</a> &bull; <a href="' . esc_url( home_url() ) . '">Visit Website</a>
                </div>
            </div>
        </body>
        </html>';

        $headers = [
            'Content-Type: text/html; charset=UTF-8',
        ];

        try {
            return wp_mail( $applicant_email, $subject, $body, $headers );
        } catch ( \Exception $e ) {
            error_log( 'Finspire Loan Form Mailer Error: ' . $e->getMessage() );
            return false;
        }
    }
}
