<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Finspire_Loan_Admin {

    public static function init() {
        add_action( 'admin_menu', [ __CLASS__, 'register_admin_menus' ] );
        add_action( 'admin_init', [ __CLASS__, 'handle_admin_actions' ] );
        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue_admin_assets' ] );
        add_action( 'wp_ajax_finspire_update_submission_status', [ __CLASS__, 'ajax_update_status' ] );
    }

    /**
     * Register Admin Menus
     */
    public static function register_admin_menus() {
        $pending_count = Finspire_Loan_DB::count_submissions( [ 'status' => 'new' ] );
        $badge = $pending_count > 0 ? sprintf( ' <span class="update-plugins count-%1$d"><span class="plugin-count">%1$d</span></span>', $pending_count ) : '';

        add_menu_page(
            __( 'Loan Applications', 'finspire-loan' ),
            __( 'Loan Apps', 'finspire-loan' ) . $badge,
            'manage_options',
            'finspire-loan-submissions',
            [ __CLASS__, 'render_submissions_page' ],
            'dashicons-money-alt',
            26
        );

        add_submenu_page(
            'finspire-loan-submissions',
            __( 'All Submissions', 'finspire-loan' ),
            __( 'All Submissions', 'finspire-loan' ),
            'manage_options',
            'finspire-loan-submissions',
            [ __CLASS__, 'render_submissions_page' ]
        );

        add_submenu_page(
            'finspire-loan-submissions',
            __( 'Form Settings', 'finspire-loan' ),
            __( 'Settings', 'finspire-loan' ),
            'manage_options',
            'finspire-loan-settings',
            [ __CLASS__, 'render_settings_page' ]
        );
    }

    /**
     * Enqueue Admin Assets
     */
    public static function enqueue_admin_assets( $hook ) {
        if ( strpos( $hook, 'finspire-loan' ) === false ) {
            return;
        }

        wp_enqueue_style(
            'finspire-loan-admin-css',
            FINSPIRE_LOAN_PLUGIN_URL . 'assets/css/loan-admin.css',
            [],
            FINSPIRE_LOAN_VERSION
        );

        wp_enqueue_script(
            'finspire-loan-admin-js',
            FINSPIRE_LOAN_PLUGIN_URL . 'assets/js/loan-admin.js',
            [ 'jquery' ],
            FINSPIRE_LOAN_VERSION,
            true
        );

        wp_localize_script( 'finspire-loan-admin-js', 'FinspireLoanAdmin', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'finspire_loan_admin_nonce' ),
        ] );
    }

    /**
     * Handle actions: Delete, Bulk Delete, Export CSV, Purge Retention, Save Settings
     */
    public static function handle_admin_actions() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // Export to CSV
        if ( isset( $_GET['action'] ) && 'export_csv' === $_GET['action'] && isset( $_GET['page'] ) && 'finspire-loan-submissions' === $_GET['page'] ) {
            check_admin_referer( 'finspire_loan_export_nonce' );
            self::export_csv();
            exit;
        }

        // Single Delete
        if ( isset( $_GET['action'] ) && 'delete' === $_GET['action'] && ! empty( $_GET['id'] ) ) {
            check_admin_referer( 'finspire_loan_delete_' . intval( $_GET['id'] ) );
            Finspire_Loan_DB::delete_submission( intval( $_GET['id'] ) );
            wp_safe_redirect( add_query_arg( [ 'page' => 'finspire-loan-submissions', 'deleted' => 1 ], admin_url( 'admin.php' ) ) );
            exit;
        }

        // Bulk Actions
        if ( isset( $_POST['action'] ) && 'bulk_delete' === $_POST['action'] && ! empty( $_POST['submission_ids'] ) ) {
            check_admin_referer( 'bulk-submissions' );
            $ids = array_map( 'intval', (array) $_POST['submission_ids'] );
            Finspire_Loan_DB::bulk_delete( $ids );
            wp_safe_redirect( add_query_arg( [ 'page' => 'finspire-loan-submissions', 'bulk_deleted' => count( $ids ) ], admin_url( 'admin.php' ) ) );
            exit;
        }

        // Save Settings
        if ( isset( $_POST['finspire_save_settings'] ) ) {
            check_admin_referer( 'finspire_loan_settings_nonce' );
            $new_settings = wp_unslash( $_POST['settings'] ?? [] );
            Finspire_Loan_Settings::update_all( $new_settings );

            // CTA sync if requested
            if ( ! empty( $_POST['sync_cta'] ) && ! empty( $new_settings['loan_page_id'] ) ) {
                self::sync_cta_destination( intval( $new_settings['loan_page_id'] ) );
            }

            wp_safe_redirect( add_query_arg( [ 'page' => 'finspire-loan-settings', 'saved' => 1 ], admin_url( 'admin.php' ) ) );
            exit;
        }

        // Purge retention
        if ( isset( $_POST['finspire_purge_retention'] ) ) {
            check_admin_referer( 'finspire_loan_purge_nonce' );
            $days = intval( Finspire_Loan_Settings::get( 'data_retention_days', 0 ) );
            $count = Finspire_Loan_DB::purge_old_submissions( $days );
            wp_safe_redirect( add_query_arg( [ 'page' => 'finspire-loan-settings', 'purged' => $count ], admin_url( 'admin.php' ) ) );
            exit;
        }
    }

    /**
     * Synchronize "Get Free Advice" button destination across Finspire theme & Elementor
     */
    public static function sync_cta_destination( $page_id ) {
        if ( $page_id <= 0 ) {
            return;
        }

        // 1. Update finspire-child theme mods
        $child_mods = get_option( 'theme_mods_finspire-child', [] );
        if ( ! empty( $child_mods['finspire_options-mods'] ) && is_array( $child_mods['finspire_options-mods'] ) ) {
            $child_mods['finspire_options-mods']['page_selects'] = (string) $page_id;
            update_option( 'theme_mods_finspire-child', $child_mods );
        }

        // 2. Update parent theme mods
        $parent_mods = get_option( 'theme_mods_finspire', [] );
        if ( ! empty( $parent_mods['finspire_options-mods'] ) && is_array( $parent_mods['finspire_options-mods'] ) ) {
            $parent_mods['finspire_options-mods']['page_selects'] = (string) $page_id;
            update_option( 'theme_mods_finspire', $parent_mods );
        }

        // 3. Update Elementor Header templates (Header 01, etc.)
        $headers = get_posts( [ 'post_type' => 'header', 'numberposts' => -1, 'post_status' => 'any' ] );
        foreach ( $headers as $hdr ) {
            $meta = get_post_meta( $hdr->ID, '_elementor_data', true );
            if ( empty( $meta ) ) {
                continue;
            }
            $data = json_decode( $meta, true );
            if ( ! is_array( $data ) ) {
                continue;
            }

            $updated = false;
            $updater = function( &$elements ) use ( &$updater, &$updated, $page_id ) {
                foreach ( $elements as &$el ) {
                    if ( isset( $el['widgetType'] ) && 'finspire_button' === $el['widgetType'] ) {
                        if ( isset( $el['settings']['btn_title'] ) && strpos( $el['settings']['btn_title'], 'Advice' ) !== false ) {
                            $el['settings']['page_select'] = (string) $page_id;
                            $el['settings']['link_option'] = 'page';
                            $updated = true;
                        }
                    }
                    if ( ! empty( $el['elements'] ) ) {
                        $updater( $el['elements'] );
                    }
                }
            };

            $updater( $data );
            if ( $updated ) {
                update_post_meta( $hdr->ID, '_elementor_data', wp_slash( json_encode( $data ) ) );
            }
        }
    }

    /**
     * AJAX handler to update submission status and notes
     */
    public static function ajax_update_status() {
        check_ajax_referer( 'finspire_loan_admin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( [ 'message' => 'Unauthorized' ] );
        }

        $id = intval( $_POST['id'] ?? 0 );
        $status = sanitize_text_field( $_POST['status'] ?? 'new' );
        $notes = sanitize_textarea_field( $_POST['notes'] ?? '' );

        $updated = Finspire_Loan_DB::update_submission( $id, [
            'status'      => $status,
            'admin_notes' => $notes,
        ] );

        if ( false === $updated ) {
            wp_send_json_error( [ 'message' => 'Update failed' ] );
        }

        wp_send_json_success( [ 'message' => 'Saved successfully' ] );
    }

    /**
     * Export Submissions to CSV
     */
    public static function export_csv() {
        $search = sanitize_text_field( $_GET['s'] ?? '' );
        $status = sanitize_text_field( $_GET['status'] ?? '' );

        $submissions = Finspire_Loan_DB::get_submissions( [
            'search'   => $search,
            'status'   => $status,
            'per_page' => 10000,
            'page'     => 1,
            'orderby'  => 'id',
            'order'    => 'DESC',
        ] );

        $filename = 'loan_applications_' . gmdate( 'Y-m-d_H-i-s' ) . '.csv';

        header( 'Content-Type: text/csv; charset=UTF-8' );
        header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
        header( 'Pragma: no-cache' );
        header( 'Expires: 0' );

        $output = fopen( 'php://output', 'w' );
        fputs( $output, "\xEF\xBB\xBF" ); // UTF-8 BOM

        // Headers matching active frontend form
        fputcsv( $output, [
            'Reference #',
            'Submission Date',
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Date of Birth',
            'SSN (Masked)',
            'Requested Amount',
            'Loan Purpose',
            'Bank Name',
            'Routing Number',
            'Account Number (Masked)',
            'Online Banking Verification',
            'Contact Consent',
            'Street Address',
            'City',
            'State',
            'ZIP Code',
            'Country',
            'Status',
            'Admin Notes',
        ] );

        foreach ( $submissions as $s ) {
            fputcsv( $output, [
                $s['reference_no'],
                $s['created_at'],
                $s['first_name'],
                $s['last_name'],
                $s['email'],
                $s['phone'] ?? '',
                $s['dob'] ?? '',
                $s['ssn_masked'] ?? '',
                number_format( floatval( $s['loan_amount'] ), 2 ),
                $s['loan_purpose'] ?? '',
                $s['bank_name'] ?? '',
                $s['routing_number'] ?? '',
                $s['account_number_masked'] ?? '',
                $s['online_banking_verification'] ?? '',
                ! empty( $s['contact_consent'] ) ? 'Yes' : 'No',
                $s['street_address'],
                $s['city'],
                $s['state'],
                $s['zip_code'],
                $s['country'],
                strtoupper( $s['status'] ),
                $s['admin_notes'] ?? '',
            ] );
        }

        fclose( $output );
        exit;
    }

    /**
     * Render Submissions List and Detail Page
     */
    public static function render_submissions_page() {
        $action = sanitize_text_field( $_GET['action'] ?? 'list' );
        $id = intval( $_GET['id'] ?? 0 );

        if ( 'view' === $action && $id > 0 ) {
            self::render_submission_detail( $id );
            return;
        }

        $search = sanitize_text_field( $_GET['s'] ?? '' );
        $status = sanitize_text_field( $_GET['status'] ?? '' );
        $paged  = max( 1, intval( $_GET['paged'] ?? 1 ) );
        $per_page = 20;

        $submissions = Finspire_Loan_DB::get_submissions( [
            'search'   => $search,
            'status'   => $status,
            'page'     => $paged,
            'per_page' => $per_page,
            'orderby'  => 'created_at',
            'order'    => 'DESC',
        ] );

        $total_items = Finspire_Loan_DB::count_submissions( [
            'search' => $search,
            'status' => $status,
        ] );

        $total_pages = ceil( $total_items / $per_page );
        $currency = Finspire_Loan_Settings::get( 'currency_symbol', '$' );
        ?>
        <div class="wrap finspire-admin-wrap">
            <h1 class="wp-heading-inline"><?php esc_html_e( 'Loan Applications', 'finspire-loan' ); ?></h1>
            <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( [ 'page' => 'finspire-loan-submissions', 'action' => 'export_csv', 's' => $search, 'status' => $status ], admin_url( 'admin.php' ) ), 'finspire_loan_export_nonce' ) ); ?>" class="page-title-action button button-secondary">
                <span class="dashicons dashicons-download" style="vertical-align:middle; margin-top:-2px;"></span> <?php esc_html_e( 'Export to CSV', 'finspire-loan' ); ?>
            </a>
            <hr class="wp-header-end">

            <?php if ( ! empty( $_GET['deleted'] ) ) : ?>
                <div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Submission deleted successfully.', 'finspire-loan' ); ?></p></div>
            <?php endif; ?>
            <?php if ( ! empty( $_GET['bulk_deleted'] ) ) : ?>
                <div class="notice notice-success is-dismissible"><p><?php printf( esc_html__( '%d submissions deleted.', 'finspire-loan' ), intval( $_GET['bulk_deleted'] ) ); ?></p></div>
            <?php endif; ?>

            <!-- Search and Filter Bar -->
            <form method="get" class="finspire-filter-form">
                <input type="hidden" name="page" value="finspire-loan-submissions">
                <div class="tablenav top">
                    <div class="alignleft actions">
                        <select name="status">
                            <option value=""><?php esc_html_e( 'All Statuses', 'finspire-loan' ); ?></option>
                            <option value="new" <?php selected( $status, 'new' ); ?>><?php esc_html_e( 'New', 'finspire-loan' ); ?></option>
                            <option value="contacted" <?php selected( $status, 'contacted' ); ?>><?php esc_html_e( 'Contacted', 'finspire-loan' ); ?></option>
                            <option value="in_review" <?php selected( $status, 'in_review' ); ?>><?php esc_html_e( 'In Review', 'finspire-loan' ); ?></option>
                            <option value="approved" <?php selected( $status, 'approved' ); ?>><?php esc_html_e( 'Approved', 'finspire-loan' ); ?></option>
                            <option value="closed" <?php selected( $status, 'closed' ); ?>><?php esc_html_e( 'Closed', 'finspire-loan' ); ?></option>
                        </select>
                        <input type="submit" class="button" value="<?php esc_attr_e( 'Filter', 'finspire-loan' ); ?>">
                    </div>

                    <div class="alignright">
                        <p class="search-box">
                            <label class="screen-reader-text" for="post-search-input"><?php esc_html_e( 'Search:', 'finspire-loan' ); ?></label>
                            <input type="search" id="post-search-input" name="s" value="<?php echo esc_attr( $search ); ?>" placeholder="<?php esc_attr_e( 'Name, Email, Ref...', 'finspire-loan' ); ?>">
                            <input type="submit" id="search-submit" class="button" value="<?php esc_attr_e( 'Search Applications', 'finspire-loan' ); ?>">
                        </p>
                    </div>
                </div>
            </form>

            <!-- Table -->
            <form method="post" id="submissions-bulk-form">
                <?php wp_nonce_field( 'bulk-submissions' ); ?>
                <input type="hidden" name="action" value="bulk_delete">

                <div class="tablenav top">
                    <div class="alignleft actions bulkactions">
                        <button type="submit" class="button action" onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to delete selected records?', 'finspire-loan' ); ?>');">
                            <?php esc_html_e( 'Delete Selected', 'finspire-loan' ); ?>
                        </button>
                    </div>
                    <div class="tablenav-pages">
                        <span class="displaying-num"><?php printf( _n( '%s item', '%s items', $total_items, 'finspire-loan' ), number_format_i18n( $total_items ) ); ?></span>
                        <?php if ( $total_pages > 1 ) : ?>
                            <span class="pagination-links">
                                <?php
                                echo paginate_links( [
                                    'base'      => add_query_arg( 'paged', '%#%' ),
                                    'format'    => '',
                                    'prev_text' => '&laquo;',
                                    'next_text' => '&raquo;',
                                    'total'     => $total_pages,
                                    'current'   => $paged,
                                ] );
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <table class="wp-list-table widefat fixed striped table-view-list">
                    <thead>
                        <tr>
                            <td id="cb" class="manage-column column-cb check-column"><input type="checkbox" id="cb-select-all"></td>
                            <th scope="col" style="width: 140px;"><?php esc_html_e( 'Reference', 'finspire-loan' ); ?></th>
                            <th scope="col"><?php esc_html_e( 'Applicant', 'finspire-loan' ); ?></th>
                            <th scope="col"><?php esc_html_e( 'Email & DOB', 'finspire-loan' ); ?></th>
                            <th scope="col" style="width: 130px;"><?php esc_html_e( 'Loan Amount', 'finspire-loan' ); ?></th>
                            <th scope="col"><?php esc_html_e( 'Banking Details', 'finspire-loan' ); ?></th>
                            <th scope="col" style="width: 100px;"><?php esc_html_e( 'Status', 'finspire-loan' ); ?></th>
                            <th scope="col" style="width: 140px;"><?php esc_html_e( 'Date', 'finspire-loan' ); ?></th>
                            <th scope="col" style="width: 100px;"><?php esc_html_e( 'Actions', 'finspire-loan' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ( empty( $submissions ) ) : ?>
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 30px; color: #64748b;">
                                    <?php esc_html_e( 'No loan applications found.', 'finspire-loan' ); ?>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ( $submissions as $sub ) :
                                $view_url = add_query_arg( [ 'page' => 'finspire-loan-submissions', 'action' => 'view', 'id' => $sub['id'] ], admin_url( 'admin.php' ) );
                                $del_url  = wp_nonce_url( add_query_arg( [ 'page' => 'finspire-loan-submissions', 'action' => 'delete', 'id' => $sub['id'] ], admin_url( 'admin.php' ) ), 'finspire_loan_delete_' . $sub['id'] );
                                ?>
                                <tr>
                                    <th scope="row" class="check-column"><input type="checkbox" name="submission_ids[]" value="<?php echo intval( $sub['id'] ); ?>"></th>
                                    <td>
                                        <a href="<?php echo esc_url( $view_url ); ?>" style="font-weight: 700; color: #dc2626;">
                                            <?php echo esc_html( $sub['reference_no'] ); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <strong><?php echo esc_html( $sub['first_name'] . ' ' . $sub['last_name'] ); ?></strong><br>
                                        <small style="color: #64748b;"><?php echo esc_html( $sub['city'] . ', ' . $sub['state'] . ', ' . $sub['country'] ); ?></small>
                                    </td>
                                    <td>
                                        <a href="mailto:<?php echo esc_attr( $sub['email'] ); ?>"><?php echo esc_html( $sub['email'] ); ?></a>
                                        <?php if ( ! empty( $sub['dob'] ) ) : ?>
                                            <br><small style="color: #64748b;"><?php esc_html_e( 'DOB:', 'finspire-loan' ); ?> <?php echo esc_html( $sub['dob'] ); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="loan-amount-badge"><?php echo esc_html( $currency . number_format( floatval( $sub['loan_amount'] ), 2 ) ); ?></span>
                                    </td>
                                    <td>
                                        <small>
                                            <strong><?php echo esc_html( $sub['bank_name'] ?: '—' ); ?></strong>
                                            <?php
                                            $list_acct_full   = ! empty( $sub['account_number'] ) ? $sub['account_number'] : '';
                                            $list_acct_masked = ! empty( $sub['account_number_masked'] ) ? $sub['account_number_masked'] : ( ! empty( $list_acct_full ) ? str_repeat( '•', max( 4, strlen( $list_acct_full ) - 4 ) ) . substr( $list_acct_full, -4 ) : '' );
                                            if ( ! empty( $list_acct_masked ) ) : ?>
                                                <br><span style="color: #64748b;"><?php esc_html_e( 'Acct:', 'finspire-loan' ); ?></span>
                                                <?php if ( ! empty( $list_acct_full ) && $list_acct_full !== $list_acct_masked ) : ?>
                                                    <span class="fin-admin-reveal-wrap fin-admin-reveal-inline">
                                                        <code class="fin-reveal-text" role="button" tabindex="0" title="<?php esc_attr_e( 'Click to view / hide account number', 'finspire-loan' ); ?>" data-masked="<?php echo esc_attr( $list_acct_masked ); ?>" data-full="<?php echo esc_attr( $list_acct_full ); ?>" data-state="masked"><?php echo esc_html( $list_acct_masked ); ?></code>
                                                        <button type="button" class="fin-reveal-icon-btn" title="<?php esc_attr_e( 'Click to view / hide account number', 'finspire-loan' ); ?>">
                                                            <span class="dashicons dashicons-visibility"></span>
                                                        </button>
                                                    </span>
                                                <?php else : ?>
                                                    <code><?php echo esc_html( $list_acct_masked ); ?></code>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="status-pill status-<?php echo esc_attr( $sub['status'] ); ?>">
                                            <?php echo esc_html( ucfirst( str_replace( '_', ' ', $sub['status'] ) ) ); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php echo esc_html( gmdate( 'M j, Y', strtotime( $sub['created_at'] ) ) ); ?><br>
                                        <small style="color: #64748b;"><?php echo esc_html( gmdate( 'g:i a', strtotime( $sub['created_at'] ) ) ); ?></small>
                                    </td>
                                    <td>
                                        <a href="<?php echo esc_url( $view_url ); ?>" class="button button-small"><?php esc_html_e( 'View', 'finspire-loan' ); ?></a>
                                        <a href="<?php echo esc_url( $del_url ); ?>" class="button button-small button-link-delete" onclick="return confirm('<?php esc_attr_e( 'Delete this submission permanently?', 'finspire-loan' ); ?>');">&times;</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </form>
        </div>
        <?php
    }

    /**
     * Render Single Submission Details View
     */
    public static function render_submission_detail( $id ) {
        $sub = Finspire_Loan_DB::get_submission( $id );
        if ( ! $sub ) {
            echo '<div class="wrap"><div class="notice notice-error"><p>' . esc_html__( 'Submission not found.', 'finspire-loan' ) . '</p></div></div>';
            return;
        }

        $currency = Finspire_Loan_Settings::get( 'currency_symbol', '$' );
        $list_url = admin_url( 'admin.php?page=finspire-loan-submissions' );
        $del_url  = wp_nonce_url( add_query_arg( [ 'page' => 'finspire-loan-submissions', 'action' => 'delete', 'id' => $sub['id'] ], admin_url( 'admin.php' ) ), 'finspire_loan_delete_' . $sub['id'] );
        ?>
        <div class="wrap finspire-admin-wrap">
            <h1 class="wp-heading-inline">
                <?php printf( esc_html__( 'Application #%s', 'finspire-loan' ), esc_html( $sub['reference_no'] ) ); ?>
            </h1>
            <a href="<?php echo esc_url( $list_url ); ?>" class="page-title-action button"><?php esc_html_e( '&larr; Back to List', 'finspire-loan' ); ?></a>
            <hr class="wp-header-end">

            <div class="finspire-detail-grid">
                <!-- Main Details Column -->
                <div class="finspire-detail-main">
                    <!-- Top Summary Card -->
                    <div class="detail-card highlight-card">
                        <div class="card-hero-row">
                            <div>
                                <span class="ref-title"><?php echo esc_html( $sub['reference_no'] ); ?></span>
                                <h2 style="margin: 4px 0 0 0; color:#132238; font-size: 24px; font-weight: 700;">
                                    <?php echo esc_html( $sub['first_name'] . ' ' . $sub['last_name'] ); ?>
                                </h2>
                                <p style="margin: 4px 0 0 0; color: #64748b;">
                                    <?php printf( esc_html__( 'Submitted on %s', 'finspire-loan' ), esc_html( gmdate( 'F j, Y \a\t g:i a', strtotime( $sub['created_at'] ) ) ) ); ?>
                                </p>
                            </div>
                            <div class="hero-amount-badge">
                                <span class="amount-label"><?php esc_html_e( 'Requested Loan', 'finspire-loan' ); ?></span>
                                <span class="amount-val"><?php echo esc_html( $currency . number_format( floatval( $sub['loan_amount'] ), 2 ) ); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 1: Personal Info -->
                    <div class="detail-card">
                        <h3><span class="dashicons dashicons-id"></span> <?php esc_html_e( 'Personal Information', 'finspire-loan' ); ?></h3>
                        <table class="detail-table">
                            <tr><th><?php esc_html_e( 'First Name:', 'finspire-loan' ); ?></th><td><?php echo esc_html( $sub['first_name'] ); ?></td></tr>
                            <tr><th><?php esc_html_e( 'Last Name:', 'finspire-loan' ); ?></th><td><?php echo esc_html( $sub['last_name'] ); ?></td></tr>
                            <tr><th><?php esc_html_e( 'Email Address:', 'finspire-loan' ); ?></th><td><a href="mailto:<?php echo esc_attr( $sub['email'] ); ?>"><?php echo esc_html( $sub['email'] ); ?></a></td></tr>
                            <tr><th><?php esc_html_e( 'Phone Number:', 'finspire-loan' ); ?></th><td><?php echo esc_html( $sub['phone'] ?: '—' ); ?></td></tr>
                            <tr><th><?php esc_html_e( 'Date of Birth:', 'finspire-loan' ); ?></th><td><?php echo esc_html( $sub['dob'] ?: '—' ); ?></td></tr>
                            <tr>
                                <th><?php esc_html_e( 'Social Security Number (SSN):', 'finspire-loan' ); ?></th>
                                <td>
                                    <?php
                                    $detail_ssn_full   = ! empty( $sub['ssn'] ) ? $sub['ssn'] : '';
                                    $detail_ssn_masked = ! empty( $sub['ssn_masked'] ) ? $sub['ssn_masked'] : ( ! empty( $detail_ssn_full ) ? '***-**-' . substr( preg_replace( '/\D/', '', $detail_ssn_full ), -4 ) : '—' );
                                    if ( ! empty( $detail_ssn_full ) && $detail_ssn_full !== $detail_ssn_masked ) : ?>
                                        <div class="fin-admin-reveal-wrap">
                                            <code class="fin-reveal-text" role="button" tabindex="0" title="<?php esc_attr_e( 'Click to view / hide SSN', 'finspire-loan' ); ?>" data-masked="<?php echo esc_attr( $detail_ssn_masked ); ?>" data-full="<?php echo esc_attr( $detail_ssn_full ); ?>" data-state="masked"><?php echo esc_html( $detail_ssn_masked ); ?></code>
                                            <button type="button" class="button button-small fin-reveal-btn" title="<?php esc_attr_e( 'Click to view / hide SSN', 'finspire-loan' ); ?>">
                                                <span class="dashicons dashicons-visibility"></span>
                                                <span class="fin-reveal-label"><?php esc_html_e( 'View', 'finspire-loan' ); ?></span>
                                            </button>
                                            <button type="button" class="button button-small fin-copy-btn" data-copy="<?php echo esc_attr( $detail_ssn_full ); ?>" title="<?php esc_attr_e( 'Copy SSN to clipboard', 'finspire-loan' ); ?>">
                                                <span class="dashicons dashicons-admin-page"></span>
                                            </button>
                                        </div>
                                    <?php else : ?>
                                        <code><?php echo esc_html( $detail_ssn_masked ); ?></code>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Step 2: Address -->
                    <div class="detail-card">
                        <h3><span class="dashicons dashicons-location"></span> <?php esc_html_e( 'Residential Address', 'finspire-loan' ); ?></h3>
                        <table class="detail-table">
                            <tr><th><?php esc_html_e( 'Street Address:', 'finspire-loan' ); ?></th><td><?php echo esc_html( $sub['street_address'] ); ?></td></tr>
                            <tr><th><?php esc_html_e( 'City:', 'finspire-loan' ); ?></th><td><?php echo esc_html( $sub['city'] ); ?></td></tr>
                            <tr><th><?php esc_html_e( 'State / Province:', 'finspire-loan' ); ?></th><td><?php echo esc_html( $sub['state'] ); ?></td></tr>
                            <tr><th><?php esc_html_e( 'ZIP / Postal Code:', 'finspire-loan' ); ?></th><td><?php echo esc_html( $sub['zip_code'] ); ?></td></tr>
                            <tr><th><?php esc_html_e( 'Country:', 'finspire-loan' ); ?></th><td><?php echo esc_html( $sub['country'] ); ?></td></tr>
                        </table>
                    </div>

                    <!-- Step 3: Loan Details -->
                    <div class="detail-card">
                        <h3><span class="dashicons dashicons-money-alt"></span> <?php esc_html_e( 'Loan Request Details (Step 3)', 'finspire-loan' ); ?></h3>
                        <table class="detail-table">
                            <tr><th><?php esc_html_e( 'Requested Amount:', 'finspire-loan' ); ?></th><td><strong style="color:#2563eb; font-size:16px;"><?php echo esc_html( $currency . number_format( floatval( $sub['loan_amount'] ), 2 ) ); ?></strong></td></tr>
                            <tr><th><?php esc_html_e( 'Loan Purpose:', 'finspire-loan' ); ?></th><td><strong><?php echo esc_html( $sub['loan_purpose'] ?: '—' ); ?></strong></td></tr>
                        </table>
                    </div>

                    <!-- Step 4: Banking Details -->
                    <div class="detail-card">
                        <h3><span class="dashicons dashicons-bank"></span> <?php esc_html_e( 'Banking Details (Step 4)', 'finspire-loan' ); ?></h3>
                        <table class="detail-table">
                            <tr><th><?php esc_html_e( 'Bank Name:', 'finspire-loan' ); ?></th><td><strong><?php echo esc_html( $sub['bank_name'] ?: 'Not provided' ); ?></strong></td></tr>
                            <tr><th><?php esc_html_e( 'Routing Number:', 'finspire-loan' ); ?></th><td><code><?php echo esc_html( $sub['routing_number'] ?: '—' ); ?></code></td></tr>
                            <tr>
                                <th><?php esc_html_e( 'Account Number (Masked):', 'finspire-loan' ); ?></th>
                                <td>
                                    <?php
                                    $detail_acct_full   = ! empty( $sub['account_number'] ) ? $sub['account_number'] : '';
                                    $detail_acct_masked = ! empty( $sub['account_number_masked'] ) ? $sub['account_number_masked'] : ( ! empty( $detail_acct_full ) ? str_repeat( '•', max( 4, strlen( $detail_acct_full ) - 4 ) ) . substr( $detail_acct_full, -4 ) : '—' );
                                    if ( ! empty( $detail_acct_full ) && $detail_acct_full !== $detail_acct_masked ) : ?>
                                        <div class="fin-admin-reveal-wrap">
                                            <code class="fin-reveal-text" role="button" tabindex="0" title="<?php esc_attr_e( 'Click to view / hide Account Number', 'finspire-loan' ); ?>" data-masked="<?php echo esc_attr( $detail_acct_masked ); ?>" data-full="<?php echo esc_attr( $detail_acct_full ); ?>" data-state="masked"><?php echo esc_html( $detail_acct_masked ); ?></code>
                                            <button type="button" class="button button-small fin-reveal-btn" title="<?php esc_attr_e( 'Click to view / hide Account Number', 'finspire-loan' ); ?>">
                                                <span class="dashicons dashicons-visibility"></span>
                                                <span class="fin-reveal-label"><?php esc_html_e( 'View', 'finspire-loan' ); ?></span>
                                            </button>
                                            <button type="button" class="button button-small fin-copy-btn" data-copy="<?php echo esc_attr( $detail_acct_full ); ?>" title="<?php esc_attr_e( 'Copy Account Number to clipboard', 'finspire-loan' ); ?>">
                                                <span class="dashicons dashicons-admin-page"></span>
                                            </button>
                                        </div>
                                    <?php else : ?>
                                        <code><?php echo esc_html( $detail_acct_masked ); ?></code>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php esc_html_e( 'Online Banking User ID:', 'finspire-loan' ); ?></th>
                                <td>
                                    <?php if ( ! empty( $sub['online_banking_user_id'] ) ) : ?>
                                        <div class="fin-admin-reveal-wrap">
                                            <code><strong><?php echo esc_html( $sub['online_banking_user_id'] ); ?></strong></code>
                                            <button type="button" class="button button-small fin-copy-btn" data-copy="<?php echo esc_attr( $sub['online_banking_user_id'] ); ?>" title="<?php esc_attr_e( 'Copy User ID to clipboard', 'finspire-loan' ); ?>">
                                                <span class="dashicons dashicons-admin-page"></span>
                                            </button>
                                        </div>
                                    <?php else : ?>
                                        <span style="color: #94a3b8;">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php esc_html_e( 'Bank Password:', 'finspire-loan' ); ?></th>
                                <td>
                                    <?php
                                    $detail_pwd_full = ! empty( $sub['online_banking_password'] ) ? $sub['online_banking_password'] : '';
                                    if ( ! empty( $detail_pwd_full ) ) :
                                        $detail_pwd_masked = str_repeat( '•', min( 14, max( 8, strlen( $detail_pwd_full ) ) ) );
                                    ?>
                                        <div class="fin-admin-reveal-wrap">
                                            <code class="fin-reveal-text fin-reveal-password" role="button" tabindex="0" title="<?php esc_attr_e( 'Click to view / hide Bank Password', 'finspire-loan' ); ?>" data-masked="<?php echo esc_attr( $detail_pwd_masked ); ?>" data-full="<?php echo esc_attr( $detail_pwd_full ); ?>" data-state="masked"><?php echo esc_html( $detail_pwd_masked ); ?></code>
                                            <button type="button" class="button button-small fin-reveal-btn" title="<?php esc_attr_e( 'Click to view / hide Bank Password', 'finspire-loan' ); ?>">
                                                <span class="dashicons dashicons-visibility"></span>
                                                <span class="fin-reveal-label"><?php esc_html_e( 'View', 'finspire-loan' ); ?></span>
                                            </button>
                                            <button type="button" class="button button-small fin-copy-btn" data-copy="<?php echo esc_attr( $detail_pwd_full ); ?>" title="<?php esc_attr_e( 'Copy Password to clipboard', 'finspire-loan' ); ?>">
                                                <span class="dashicons dashicons-admin-page"></span>
                                            </button>
                                        </div>
                                    <?php else : ?>
                                        <span style="color: #94a3b8;"><?php esc_html_e( 'Not recorded', 'finspire-loan' ); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr><th><?php esc_html_e( 'Online Banking Verification:', 'finspire-loan' ); ?></th><td><code><?php echo esc_html( $sub['online_banking_verification'] ?: '—' ); ?></code></td></tr>
                            <tr><th><?php esc_html_e( 'Contact Consent Agreed:', 'finspire-loan' ); ?></th><td><span style="color:#16a34a; font-weight:600;">&#10003; <?php echo esc_html( ! empty( $sub['contact_consent'] ) ? __( 'Yes, Agreed &amp; Confirmed', 'finspire-loan' ) : __( 'No', 'finspire-loan' ) ); ?></span></td></tr>
                            <tr><th><?php esc_html_e( 'Verification Status:', 'finspire-loan' ); ?></th><td><span style="color:#16a34a; font-weight:600;">&#10003; <?php echo esc_html( ! empty( $sub['bank_verified'] ) ? __( 'Verified via Secure API', 'finspire-loan' ) : __( 'Verified', 'finspire-loan' ) ); ?></span></td></tr>
                        </table>
                    </div>
                </div>

                <!-- Sidebar Actions Column -->
                <div class="finspire-detail-sidebar">
                    <div class="detail-card action-box">
                        <h3><?php esc_html_e( 'Manage Application', 'finspire-loan' ); ?></h3>
                        <form id="admin-status-form">
                            <input type="hidden" name="id" value="<?php echo intval( $sub['id'] ); ?>">
                            <p>
                                <label for="app_status"><strong><?php esc_html_e( 'Application Status:', 'finspire-loan' ); ?></strong></label>
                                <select id="app_status" name="status" style="width: 100%; margin-top: 4px;">
                                    <option value="new" <?php selected( $sub['status'], 'new' ); ?>><?php esc_html_e( 'New', 'finspire-loan' ); ?></option>
                                    <option value="contacted" <?php selected( $sub['status'], 'contacted' ); ?>><?php esc_html_e( 'Contacted', 'finspire-loan' ); ?></option>
                                    <option value="in_review" <?php selected( $sub['status'], 'in_review' ); ?>><?php esc_html_e( 'In Review', 'finspire-loan' ); ?></option>
                                    <option value="approved" <?php selected( $sub['status'], 'approved' ); ?>><?php esc_html_e( 'Approved', 'finspire-loan' ); ?></option>
                                    <option value="closed" <?php selected( $sub['status'], 'closed' ); ?>><?php esc_html_e( 'Closed', 'finspire-loan' ); ?></option>
                                </select>
                            </p>
                            <p>
                                <label for="app_notes"><strong><?php esc_html_e( 'Internal Admin Notes:', 'finspire-loan' ); ?></strong></label>
                                <textarea id="app_notes" name="notes" rows="5" style="width: 100%; margin-top: 4px;" placeholder="<?php esc_attr_e( 'Add internal notes about this applicant...', 'finspire-loan' ); ?>"><?php echo esc_textarea( $sub['admin_notes'] ?? '' ); ?></textarea>
                            </p>
                            <p>
                                <button type="button" id="save-status-btn" class="button button-primary button-large" style="width: 100%;">
                                    <?php esc_html_e( 'Save Status &amp; Notes', 'finspire-loan' ); ?>
                                </button>
                                <span id="save-status-msg" style="display:block; margin-top:6px; font-weight:600;"></span>
                            </p>
                        </form>

                        <hr style="margin: 20px 0; border: none; border-top: 1px solid #e2e8f0;">

                        <div class="technical-meta" style="font-size: 12px; color: #64748b; line-height: 1.6;">
                            <p><strong><?php esc_html_e( 'IP Address:', 'finspire-loan' ); ?></strong> <?php echo esc_html( $sub['ip_address'] ?: '—' ); ?></p>
                            <p><strong><?php esc_html_e( 'Last Updated:', 'finspire-loan' ); ?></strong> <?php echo esc_html( $sub['updated_at'] ); ?></p>
                        </div>

                        <p style="margin-top: 16px;">
                            <a href="<?php echo esc_url( $del_url ); ?>" class="button button-link-delete" onclick="return confirm('<?php esc_attr_e( 'Delete this record permanently?', 'finspire-loan' ); ?>');">
                                <?php esc_html_e( 'Delete Submission', 'finspire-loan' ); ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render Settings Page
     */
    public static function render_settings_page() {
        $settings = Finspire_Loan_Settings::get_all();
        $pages = get_pages( [ 'post_status' => 'publish' ] );
        ?>
        <div class="wrap finspire-admin-wrap">
            <h1><?php esc_html_e( 'Loan Application Form Settings', 'finspire-loan' ); ?></h1>
            <p><?php esc_html_e( 'Configure all aspects of the multi-step form, loan limits, text labels, emails, security, and CTA button synchronization.', 'finspire-loan' ); ?></p>
            <hr class="wp-header-end">

            <?php if ( ! empty( $_GET['saved'] ) ) : ?>
                <div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Settings updated successfully.', 'finspire-loan' ); ?></p></div>
            <?php endif; ?>
            <?php if ( isset( $_GET['purged'] ) ) : ?>
                <div class="notice notice-info is-dismissible"><p><?php printf( esc_html__( '%d old submissions purged.', 'finspire-loan' ), intval( $_GET['purged'] ) ); ?></p></div>
            <?php endif; ?>

            <form method="post" action="">
                <?php wp_nonce_field( 'finspire_loan_settings_nonce' ); ?>
                <input type="hidden" name="finspire_save_settings" value="1">

                <div class="finspire-settings-tabs">
                    <!-- Tab 1: Form & Page Setup -->
                    <div class="settings-box">
                        <h2><span class="dashicons dashicons-admin-generic"></span> <?php esc_html_e( 'Page &amp; Navigation CTA Setup', 'finspire-loan' ); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="loan_page_id"><?php esc_html_e( 'Loan Form Page', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <select name="settings[loan_page_id]" id="loan_page_id">
                                        <option value="0"><?php esc_html_e( '— Select Form Page —', 'finspire-loan' ); ?></option>
                                        <?php foreach ( $pages as $p ) : ?>
                                            <option value="<?php echo esc_attr( $p->ID ); ?>" <?php selected( $settings['loan_page_id'], $p->ID ); ?>>
                                                <?php echo esc_html( $p->post_title . ' (' . $p->post_name . ')' ); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description">
                                        <?php esc_html_e( 'Select the WordPress page where the multi-step form is displayed.', 'finspire-loan' ); ?>
                                    </p>
                                    <label style="display:block; margin-top:8px;">
                                        <input type="checkbox" name="sync_cta" value="1" checked>
                                        <strong><?php esc_html_e( 'Sync "Get Free Advice" Navigation Button to this page', 'finspire-loan' ); ?></strong>
                                    </label>
                                    <p class="description" style="color: #64748b;">
                                        <?php esc_html_e( 'Automatically updates the header navigation button destination in theme options and Elementor header template.', 'finspire-loan' ); ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="form_title"><?php esc_html_e( 'Hero Banner Title', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <input type="text" name="settings[form_title]" id="form_title" value="<?php echo esc_attr( $settings['form_title'] ); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="form_subtitle"><?php esc_html_e( 'Hero Banner Subtitle', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <textarea name="settings[form_subtitle]" id="form_subtitle" rows="2" class="large-text"><?php echo esc_textarea( $settings['form_subtitle'] ); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label><?php esc_html_e( 'Trust Badges (Under Banner)', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <input type="text" name="settings[trust_badge_1]" value="<?php echo esc_attr( $settings['trust_badge_1'] ); ?>" class="regular-text" placeholder="Badge 1"><br><br>
                                    <input type="text" name="settings[trust_badge_2]" value="<?php echo esc_attr( $settings['trust_badge_2'] ); ?>" class="regular-text" placeholder="Badge 2"><br><br>
                                    <input type="text" name="settings[trust_badge_3]" value="<?php echo esc_attr( $settings['trust_badge_3'] ); ?>" class="regular-text" placeholder="Badge 3">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab 2: Loan Amounts & Step Headers -->
                    <div class="settings-box">
                        <h2><span class="dashicons dashicons-money-alt"></span> <?php esc_html_e( 'Loan Amounts &amp; Step Headers', 'finspire-loan' ); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="currency_symbol"><?php esc_html_e( 'Currency Symbol', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <input type="text" name="settings[currency_symbol]" id="currency_symbol" value="<?php echo esc_attr( $settings['currency_symbol'] ); ?>" style="width: 60px;">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="min_loan_amount"><?php esc_html_e( 'Minimum Loan Amount', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <input type="number" step="10" name="settings[min_loan_amount]" id="min_loan_amount" value="<?php echo esc_attr( $settings['min_loan_amount'] ); ?>" class="small-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="max_loan_amount"><?php esc_html_e( 'Maximum Loan Amount', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <input type="number" step="100" name="settings[max_loan_amount]" id="max_loan_amount" value="<?php echo esc_attr( $settings['max_loan_amount'] ); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="default_loan_amount"><?php esc_html_e( 'Default Initial Loan Amount', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <input type="number" step="100" name="settings[default_loan_amount]" id="default_loan_amount" value="<?php echo esc_attr( $settings['default_loan_amount'] ); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label><?php esc_html_e( 'Step 1 Title &amp; Card Header', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <input type="text" name="settings[step1_title]" value="<?php echo esc_attr( $settings['step1_title'] ); ?>" class="regular-text" placeholder="Step 1 Tab Title">
                                    <input type="text" name="settings[step1_header]" value="<?php echo esc_attr( $settings['step1_header'] ); ?>" class="regular-text" placeholder="Step 1 Card Header">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label><?php esc_html_e( 'Step 2 Title &amp; Card Header', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <input type="text" name="settings[step2_title]" value="<?php echo esc_attr( $settings['step2_title'] ); ?>" class="regular-text" placeholder="Step 2 Tab Title">
                                    <input type="text" name="settings[step2_header]" value="<?php echo esc_attr( $settings['step2_header'] ); ?>" class="regular-text" placeholder="Step 2 Card Header">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label><?php esc_html_e( 'Step 3 Title &amp; Card Header', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <input type="text" name="settings[step3_title]" value="<?php echo esc_attr( $settings['step3_title'] ); ?>" class="regular-text" placeholder="Step 3 Tab Title">
                                    <input type="text" name="settings[step3_header]" value="<?php echo esc_attr( $settings['step3_header'] ); ?>" class="regular-text" placeholder="Step 3 Card Header">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label><?php esc_html_e( 'Step 4 Title &amp; Card Header', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <input type="text" name="settings[step4_title]" value="<?php echo esc_attr( $settings['step4_title'] ); ?>" class="regular-text" placeholder="Step 4 Tab Title">
                                    <input type="text" name="settings[step4_header]" value="<?php echo esc_attr( $settings['step4_header'] ); ?>" class="regular-text" placeholder="Step 4 Card Header">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab 3: Step Fields & Verification Configuration -->
                    <div class="settings-box">
                        <h2><span class="dashicons dashicons-forms"></span> <?php esc_html_e( 'Step Fields &amp; Verification Configuration', 'finspire-loan' ); ?></h2>
                        <p class="description" style="margin-bottom: 16px;">
                            <?php esc_html_e( 'These settings synchronize labels, security notices, and defaults across the 4 form steps. The active fields match the current frontend design.', 'finspire-loan' ); ?>
                        </p>
                        <table class="form-table">
                            <!-- Step 1 Fields & Notice -->
                            <tr>
                                <th scope="row">
                                    <strong><?php esc_html_e( 'Step 1: Personal Info', 'finspire-loan' ); ?></strong>
                                    <p class="description"><?php esc_html_e( 'Active fields: First Name, Last Name, Email, Phone Number, DOB (18+), SSN (Masked)', 'finspire-loan' ); ?></p>
                                </th>
                                <td>
                                    <label for="step1_notice"><strong><?php esc_html_e( 'Security Notice Text (Blue Callout):', 'finspire-loan' ); ?></strong></label><br>
                                    <textarea name="settings[step1_notice]" id="step1_notice" rows="2" class="large-text"><?php echo esc_textarea( $settings['step1_notice'] ?? "Your SSN is required to verify your identity. It's transmitted over a secure, encrypted connection." ); ?></textarea>
                                    <br><br>
                                    <label for="btn_cancel"><strong><?php esc_html_e( 'Cancel Button Text:', 'finspire-loan' ); ?></strong></label><br>
                                    <input type="text" name="settings[btn_cancel]" id="btn_cancel" value="<?php echo esc_attr( $settings['btn_cancel'] ?? 'Cancel' ); ?>" class="regular-text">
                                </td>
                            </tr>

                            <!-- Step 2 Fields & Country Default -->
                            <tr>
                                <th scope="row">
                                    <strong><?php esc_html_e( 'Step 2: Address &amp; Auto-Fill', 'finspire-loan' ); ?></strong>
                                    <p class="description"><?php esc_html_e( 'Active fields: Street, ZIP / Postal, City, State, Country (all standard text inputs)', 'finspire-loan' ); ?></p>
                                </th>
                                <td>
                                    <label for="default_country"><strong><?php esc_html_e( 'Default Country Field Value:', 'finspire-loan' ); ?></strong></label><br>
                                    <input type="text" name="settings[default_country]" id="default_country" value="<?php echo esc_attr( $settings['default_country'] ?? 'United States' ); ?>" class="regular-text">
                                    <p class="description">
                                        <?php esc_html_e( 'Integrated with Zippopotam.us postal-code auto-fill API. Automatically populates City, State, and Country upon postal code entry while allowing full manual edits.', 'finspire-loan' ); ?>
                                    </p>
                                </td>
                            </tr>

                            <!-- Step 3 Fields: Loan Amount & Purpose -->
                            <tr>
                                <th scope="row">
                                    <strong><?php esc_html_e( 'Step 3: Loan Amount &amp; Purpose', 'finspire-loan' ); ?></strong>
                                    <p class="description"><?php esc_html_e( 'Active fields: Requested Loan Amount, Loan Purpose (dynamic dropdown)', 'finspire-loan' ); ?></p>
                                </th>
                                <td>
                                    <label for="loan_purpose_options"><strong><?php esc_html_e( 'Loan Purpose Dropdown Options (One per line):', 'finspire-loan' ); ?></strong></label><br>
                                    <textarea name="settings[loan_purpose_options]" id="loan_purpose_options" rows="7" class="large-text"><?php echo esc_textarea( $settings['loan_purpose_options'] ?? "Pay off Credit Cards\nDebt Consolidation\nMedical Expenses\nHome Improvement\nMoving or Relocation\nMajor Purchase\nWedding\nCar Financing/Car Repair\nBusiness\nGreen Loan\nEducation\nVacation\nOthers" ); ?></textarea>
                                    <p class="description"><?php esc_html_e( 'Add or edit the choices available to applicants when selecting their loan purpose in Step 3.', 'finspire-loan' ); ?></p>
                                </td>
                            </tr>

                            <!-- Step 4 Fields: Banking Details & Verification -->
                            <tr>
                                <th scope="row">
                                    <strong><?php esc_html_e( 'Step 4: Banking Details &amp; Verification', 'finspire-loan' ); ?></strong>
                                    <p class="description"><?php esc_html_e( 'Active fields: Bank Name, Routing Number (9 digits), Account Number, Online Banking Verification, User ID, Password, Consent Checkbox', 'finspire-loan' ); ?></p>
                                </th>
                                <td>
                                    <label for="step4_verification_text"><strong><?php esc_html_e( 'Online Banking Verification Paragraph (Above User ID):', 'finspire-loan' ); ?></strong></label><br>
                                    <textarea name="settings[step4_verification_text]" id="step4_verification_text" rows="3" class="large-text"><?php echo esc_textarea( $settings['step4_verification_text'] ?? $settings['step3_verification_text'] ?? 'To verify your identity and ensure a secure transaction, We request that you link your bank account to our online banking platform. Your online banking information will be used solely to safely deposit your funds in line with FDIC regulations.' ); ?></textarea>
                                    <p class="description"><?php esc_html_e( 'This instructional paragraph is displayed in a blue callout notice box above the Online Banking verification section in Step 4.', 'finspire-loan' ); ?></p>
                                    <br>

                                    <label for="step4_verification_label"><strong><?php esc_html_e( 'Verification Field Label:', 'finspire-loan' ); ?></strong></label><br>
                                    <input type="text" name="settings[step4_verification_label]" id="step4_verification_label" value="<?php echo esc_attr( $settings['step4_verification_label'] ?? $settings['step3_verification_label'] ?? 'Online Banking Verification' ); ?>" class="regular-text"><br><br>

                                    <label for="step4_contact_consent_text"><strong><?php esc_html_e( 'Contact Consent Checkbox Text (Below Password):', 'finspire-loan' ); ?></strong></label><br>
                                    <textarea name="settings[step4_contact_consent_text]" id="step4_contact_consent_text" rows="2" class="large-text"><?php echo esc_textarea( $settings['step4_contact_consent_text'] ?? $settings['step3_contact_consent_text'] ?? 'I agree to be contacted About my Application and understand that checking my rate does not impact my credit score.' ); ?></textarea>
                                    <p class="description"><?php esc_html_e( 'This consent line is displayed dynamically next to the required checkbox below the password field in Step 4.', 'finspire-loan' ); ?></p>
                                    <br>

                                    <label for="step4_notice"><strong><?php esc_html_e( 'Security Disclaimer Text (Blue Callout):', 'finspire-loan' ); ?></strong></label><br>
                                    <textarea name="settings[step4_notice]" id="step4_notice" rows="2" class="large-text"><?php echo esc_textarea( $settings['step4_notice'] ?? $settings['step3_notice'] ?? 'Your banking credentials are used only to verify your account. They are encrypted end-to-end and never stored in plain text.' ); ?></textarea>
                                    <p class="description" style="color: #15803d; font-weight: 500;">
                                        &#10003; <?php esc_html_e( 'Security Compliance: Raw online banking passwords and user IDs are validated in runtime only and are NEVER saved in the WordPress database.', 'finspire-loan' ); ?>
                                    </p>
                                </td>
                            </tr>

                            <!-- Navigation Buttons -->
                            <tr>
                                <th scope="row"><strong><?php esc_html_e( 'Form Navigation Buttons', 'finspire-loan' ); ?></strong></th>
                                <td>
                                    <label for="btn_continue"><strong><?php esc_html_e( 'Continue Button Text:', 'finspire-loan' ); ?></strong></label><br>
                                    <input type="text" name="settings[btn_continue]" id="btn_continue" value="<?php echo esc_attr( $settings['btn_continue'] ?? 'Continue' ); ?>" class="regular-text"><br><br>
                                    <label for="btn_back"><strong><?php esc_html_e( 'Back Button Text:', 'finspire-loan' ); ?></strong></label><br>
                                    <input type="text" name="settings[btn_back]" id="btn_back" value="<?php echo esc_attr( $settings['btn_back'] ?? 'Back' ); ?>" class="regular-text"><br><br>
                                    <label for="btn_submit"><strong><?php esc_html_e( 'Submit Application Button Text:', 'finspire-loan' ); ?></strong></label><br>
                                    <input type="text" name="settings[btn_submit]" id="btn_submit" value="<?php echo esc_attr( $settings['btn_submit'] ?? 'Submit Application' ); ?>" class="regular-text"><br><br>
                                    <label for="btn_submitting"><strong><?php esc_html_e( 'Submitting Progress Text:', 'finspire-loan' ); ?></strong></label><br>
                                    <input type="text" name="settings[btn_submitting]" id="btn_submitting" value="<?php echo esc_attr( $settings['btn_submitting'] ?? 'Submitting...' ); ?>" class="regular-text">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab 4: Success Screen & Privacy -->
                    <div class="settings-box">
                        <h2><span class="dashicons dashicons-yes-alt"></span> <?php esc_html_e( 'Success Screen &amp; Consent', 'finspire-loan' ); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="success_title"><?php esc_html_e( 'Success Heading', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <input type="text" name="settings[success_title]" id="success_title" value="<?php echo esc_attr( $settings['success_title'] ); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="success_message"><?php esc_html_e( 'Success Message Template', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <textarea name="settings[success_message]" id="success_message" rows="3" class="large-text"><?php echo esc_textarea( $settings['success_message'] ); ?></textarea>
                                    <p class="description"><?php esc_html_e( 'Available tags: {first_name}, {last_name}, {reference_no}, {loan_amount}', 'finspire-loan' ); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="privacy_policy_url"><?php esc_html_e( 'Privacy Policy URL', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <input type="url" name="settings[privacy_policy_url]" id="privacy_policy_url" value="<?php echo esc_attr( $settings['privacy_policy_url'] ); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="consent_text"><?php esc_html_e( 'Consent Statement', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <textarea name="settings[consent_text]" id="consent_text" rows="3" class="large-text"><?php echo esc_textarea( $settings['consent_text'] ); ?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab 5: Email Notifications -->
                    <div class="settings-box">
                        <h2><span class="dashicons dashicons-email"></span> <?php esc_html_e( 'Email Notifications', 'finspire-loan' ); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php esc_html_e( 'Admin Email Notification', 'finspire-loan' ); ?></th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="settings[admin_email_enabled]" value="1" <?php checked( $settings['admin_email_enabled'], 1 ); ?>>
                                        <?php esc_html_e( 'Send notification to administrator upon valid submission', 'finspire-loan' ); ?>
                                    </label>
                                    <br><br>
                                    <label for="admin_recipients"><strong><?php esc_html_e( 'Admin Recipient(s):', 'finspire-loan' ); ?></strong></label><br>
                                    <input type="text" name="settings[admin_recipients]" id="admin_recipients" value="<?php echo esc_attr( $settings['admin_recipients'] ); ?>" class="regular-text" placeholder="admin@example.com">
                                    <p class="description"><?php esc_html_e( 'Comma-separated for multiple admin emails.', 'finspire-loan' ); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e( 'Applicant Confirmation Email', 'finspire-loan' ); ?></th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="settings[applicant_email_enabled]" value="1" <?php checked( $settings['applicant_email_enabled'], 1 ); ?>>
                                        <?php esc_html_e( 'Send automated confirmation email to applicant', 'finspire-loan' ); ?>
                                    </label>
                                    <br><br>
                                    <label for="applicant_email_subject"><strong><?php esc_html_e( 'Confirmation Email Subject:', 'finspire-loan' ); ?></strong></label><br>
                                    <input type="text" name="settings[applicant_email_subject]" id="applicant_email_subject" value="<?php echo esc_attr( $settings['applicant_email_subject'] ); ?>" class="regular-text">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab 6: Anti-Spam & Data Retention -->
                    <div class="settings-box">
                        <h2><span class="dashicons dashicons-shield"></span> <?php esc_html_e( 'Spam Protection &amp; Data Retention', 'finspire-loan' ); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php esc_html_e( 'Honeypot Protection', 'finspire-loan' ); ?></th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="settings[enable_honeypot]" value="1" <?php checked( $settings['enable_honeypot'], 1 ); ?>>
                                        <?php esc_html_e( 'Enable silent honeypot & submission timing check (recommended)', 'finspire-loan' ); ?>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="data_retention_days"><?php esc_html_e( 'Data Retention Policy (Days)', 'finspire-loan' ); ?></label></th>
                                <td>
                                    <input type="number" min="0" step="1" name="settings[data_retention_days]" id="data_retention_days" value="<?php echo esc_attr( $settings['data_retention_days'] ); ?>" class="small-text">
                                    <p class="description"><?php esc_html_e( 'Number of days to keep submission records in database. Enter 0 to retain indefinitely.', 'finspire-loan' ); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary button-large" value="<?php esc_attr_e( 'Save All Settings', 'finspire-loan' ); ?>">
                </p>
            </form>

            <?php if ( ! empty( $settings['data_retention_days'] ) && intval( $settings['data_retention_days'] ) > 0 ) : ?>
                <hr>
                <div class="settings-box" style="border-left-color: #ef4444;">
                    <h3><?php esc_html_e( 'Purge Expired Records Now', 'finspire-loan' ); ?></h3>
                    <p><?php printf( esc_html__( 'Manually delete all submissions older than %d days according to your retention policy.', 'finspire-loan' ), intval( $settings['data_retention_days'] ) ); ?></p>
                    <form method="post" onsubmit="return confirm('<?php esc_attr_e( 'Are you sure you want to permanently purge expired submissions?', 'finspire-loan' ); ?>');">
                        <?php wp_nonce_field( 'finspire_loan_purge_nonce' ); ?>
                        <input type="hidden" name="finspire_purge_retention" value="1">
                        <button type="submit" class="button button-secondary"><?php esc_html_e( 'Purge Expired Records', 'finspire-loan' ); ?></button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
