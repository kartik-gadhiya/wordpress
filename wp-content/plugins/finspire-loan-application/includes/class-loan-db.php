<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Finspire_Loan_DB {

    /**
     * Table name without prefix
     */
    const TABLE_NAME = 'loan_applications';

    /**
     * Get full table name with WordPress prefix
     */
    public static function get_table_name() {
        global $wpdb;
        return $wpdb->prefix . self::TABLE_NAME;
    }

    /**
     * Create or update database schema
     */
    public static function create_tables() {
        global $wpdb;
        $table_name = self::get_table_name();
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            reference_no varchar(64) NOT NULL,
            first_name varchar(100) NOT NULL,
            last_name varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            phone varchar(50) NOT NULL,
            dob varchar(30) DEFAULT '',
            ssn_masked varchar(30) DEFAULT '',
            age_confirmed tinyint(1) NOT NULL DEFAULT 1,
            street_address varchar(255) NOT NULL,
            zip_code varchar(30) NOT NULL,
            city varchar(100) NOT NULL,
            state varchar(100) NOT NULL,
            country varchar(100) NOT NULL,
            bank_name varchar(150) DEFAULT '',
            routing_number varchar(50) DEFAULT '',
            account_number_masked varchar(50) DEFAULT '',
            bank_verified tinyint(1) NOT NULL DEFAULT 1,
            employment_status varchar(100) DEFAULT '',
            monthly_income varchar(100) DEFAULT '',
            loan_purpose varchar(100) DEFAULT '',
            contact_method varchar(50) DEFAULT '',
            loan_amount decimal(12,2) NOT NULL DEFAULT '0.00',
            ip_address varchar(50) DEFAULT '',
            user_agent text DEFAULT NULL,
            status varchar(30) NOT NULL DEFAULT 'new',
            admin_notes text DEFAULT NULL,
            created_at datetime NOT NULL,
            updated_at datetime NOT NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY reference_no (reference_no),
            KEY email (email),
            KEY status (status),
            KEY created_at (created_at)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }

    /**
     * Generate unique reference number (e.g. LN-20261023-A8F2)
     */
    public static function generate_reference_no() {
        global $wpdb;
        $table_name = self::get_table_name();
        $prefix = 'LN-' . gmdate( 'Ymd' ) . '-';

        for ( $i = 0; $i < 10; $i++ ) {
            $random = strtoupper( substr( md5( uniqid( (string) wp_rand(), true ) ), 0, 5 ) );
            $candidate = $prefix . $random;
            $exists = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_name WHERE reference_no = %s", $candidate ) );
            if ( ! $exists ) {
                return $candidate;
            }
        }

        return $prefix . strtoupper( wp_generate_password( 6, false ) );
    }

    /**
     * Insert a new loan application submission
     */
    public static function insert_submission( $data ) {
        global $wpdb;
        $table_name = self::get_table_name();

        $now = current_time( 'mysql' );
        $ref_no = ! empty( $data['reference_no'] ) ? $data['reference_no'] : self::generate_reference_no();

        $ssn_masked = sanitize_text_field( $data['ssn_masked'] ?? '' );
        if ( empty( $ssn_masked ) && ! empty( $data['ssn'] ) ) {
            $clean_ssn = preg_replace( '/\D/', '', $data['ssn'] );
            $ssn_masked = strlen( $clean_ssn ) >= 4 ? ( '***-**-' . substr( $clean_ssn, -4 ) ) : '';
        }

        $acct_masked = sanitize_text_field( $data['account_number_masked'] ?? '' );
        if ( empty( $acct_masked ) && ! empty( $data['account_number'] ) ) {
            $clean_acct = preg_replace( '/\D/', '', $data['account_number'] );
            $acct_masked = strlen( $clean_acct ) >= 4 ? ( str_repeat( '*', max( 4, strlen( $clean_acct ) - 4 ) ) . substr( $clean_acct, -4 ) ) : '';
        }

        $insert_data = [
            'reference_no'          => $ref_no,
            'first_name'            => sanitize_text_field( $data['first_name'] ?? '' ),
            'last_name'             => sanitize_text_field( $data['last_name'] ?? '' ),
            'email'                 => sanitize_email( $data['email'] ?? '' ),
            'phone'                 => sanitize_text_field( $data['phone'] ?? '' ),
            'dob'                   => sanitize_text_field( $data['dob'] ?? '' ),
            'ssn_masked'            => $ssn_masked,
            'age_confirmed'         => ! empty( $data['age_confirmed'] ) ? 1 : 1,
            'street_address'        => sanitize_text_field( $data['street_address'] ?? '' ),
            'zip_code'              => sanitize_text_field( $data['zip_code'] ?? '' ),
            'city'                  => sanitize_text_field( $data['city'] ?? '' ),
            'state'                 => sanitize_text_field( $data['state'] ?? '' ),
            'country'               => sanitize_text_field( $data['country'] ?? '' ),
            'bank_name'             => sanitize_text_field( $data['bank_name'] ?? '' ),
            'routing_number'        => sanitize_text_field( $data['routing_number'] ?? '' ),
            'account_number_masked' => $acct_masked,
            'bank_verified'         => ! empty( $data['bank_verified'] ) ? 1 : 1,
            'employment_status'     => sanitize_text_field( $data['employment_status'] ?? '' ),
            'monthly_income'        => sanitize_text_field( $data['monthly_income'] ?? '' ),
            'loan_purpose'          => sanitize_text_field( $data['loan_purpose'] ?? '' ),
            'contact_method'        => sanitize_text_field( $data['contact_method'] ?? '' ),
            'loan_amount'           => floatval( $data['loan_amount'] ?? 0 ),
            'ip_address'            => sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' ),
            'user_agent'            => substr( sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ?? '' ), 0, 500 ),
            'status'                => 'new',
            'admin_notes'           => '',
            'created_at'            => $now,
            'updated_at'            => $now,
        ];

        $format = [
            '%s', '%s', '%s', '%s', '%s',
            '%s', '%s', '%d', '%s', '%s',
            '%s', '%s', '%s', '%s', '%s',
            '%s', '%d', '%s', '%s', '%s',
            '%s', '%f', '%s', '%s', '%s',
            '%s', '%s', '%s'
        ];

        $result = $wpdb->insert( $table_name, $insert_data, $format );

        if ( false === $result ) {
            return false;
        }

        $insert_data['id'] = $wpdb->insert_id;
        return $insert_data;
    }

    /**
     * Get a submission by ID
     */
    public static function get_submission( $id ) {
        global $wpdb;
        $table_name = self::get_table_name();
        return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $id ), ARRAY_A );
    }

    /**
     * Get a submission by reference number
     */
    public static function get_by_reference( $ref_no ) {
        global $wpdb;
        $table_name = self::get_table_name();
        return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE reference_no = %s", $ref_no ), ARRAY_A );
    }

    /**
     * Fetch submissions list with filter, search, order, and pagination
     */
    public static function get_submissions( $args = [] ) {
        global $wpdb;
        $table_name = self::get_table_name();

        $defaults = [
            'search'   => '',
            'status'   => '',
            'orderby'  => 'id',
            'order'    => 'DESC',
            'per_page' => 20,
            'page'     => 1,
        ];

        $params = wp_parse_args( $args, $defaults );

        $where = ['1=1'];
        $values = [];

        if ( ! empty( $params['search'] ) ) {
            $like = '%' . $wpdb->esc_like( sanitize_text_field( $params['search'] ) ) . '%';
            $where[] = '(reference_no LIKE %s OR first_name LIKE %s OR last_name LIKE %s OR email LIKE %s OR phone LIKE %s)';
            $values[] = $like;
            $values[] = $like;
            $values[] = $like;
            $values[] = $like;
            $values[] = $like;
        }

        if ( ! empty( $params['status'] ) && 'all' !== $params['status'] ) {
            $where[] = 'status = %s';
            $values[] = sanitize_text_field( $params['status'] );
        }

        $where_sql = implode( ' AND ', $where );

        // Validate orderby and order
        $allowed_orderby = ['id', 'reference_no', 'first_name', 'email', 'loan_amount', 'created_at', 'status'];
        $orderby = in_array( $params['orderby'], $allowed_orderby, true ) ? $params['orderby'] : 'id';
        $order = 'ASC' === strtoupper( $params['order'] ) ? 'ASC' : 'DESC';

        $per_page = max( 1, intval( $params['per_page'] ) );
        $page = max( 1, intval( $params['page'] ) );
        $offset = ( $page - 1 ) * $per_page;

        $sql = "SELECT * FROM $table_name WHERE $where_sql ORDER BY $orderby $order LIMIT %d OFFSET %d";
        $values[] = $per_page;
        $values[] = $offset;

        if ( ! empty( $values ) ) {
            $query = $wpdb->prepare( $sql, $values );
        } else {
            $query = $sql;
        }

        return $wpdb->get_results( $query, ARRAY_A );
    }

    /**
     * Count submissions for pagination
     */
    public static function count_submissions( $args = [] ) {
        global $wpdb;
        $table_name = self::get_table_name();

        $where = ['1=1'];
        $values = [];

        if ( ! empty( $args['search'] ) ) {
            $like = '%' . $wpdb->esc_like( sanitize_text_field( $args['search'] ) ) . '%';
            $where[] = '(reference_no LIKE %s OR first_name LIKE %s OR last_name LIKE %s OR email LIKE %s OR phone LIKE %s)';
            $values[] = $like;
            $values[] = $like;
            $values[] = $like;
            $values[] = $like;
            $values[] = $like;
        }

        if ( ! empty( $args['status'] ) && 'all' !== $args['status'] ) {
            $where[] = 'status = %s';
            $values[] = sanitize_text_field( $args['status'] );
        }

        $where_sql = implode( ' AND ', $where );
        $sql = "SELECT COUNT(*) FROM $table_name WHERE $where_sql";

        if ( ! empty( $values ) ) {
            return (int) $wpdb->get_var( $wpdb->prepare( $sql, $values ) );
        }

        return (int) $wpdb->get_var( $sql );
    }

    /**
     * Update submission status or notes
     */
    public static function update_submission( $id, $data ) {
        global $wpdb;
        $table_name = self::get_table_name();

        $fields = [];
        $format = [];

        if ( isset( $data['status'] ) ) {
            $fields['status'] = sanitize_text_field( $data['status'] );
            $format[] = '%s';
        }
        if ( isset( $data['admin_notes'] ) ) {
            $fields['admin_notes'] = sanitize_textarea_field( $data['admin_notes'] );
            $format[] = '%s';
        }

        if ( empty( $fields ) ) {
            return false;
        }

        $fields['updated_at'] = current_time( 'mysql' );
        $format[] = '%s';

        return $wpdb->update( $table_name, $fields, ['id' => intval( $id )], $format, ['%d'] );
    }

    /**
     * Delete submission by ID
     */
    public static function delete_submission( $id ) {
        global $wpdb;
        $table_name = self::get_table_name();
        return $wpdb->delete( $table_name, ['id' => intval( $id )], ['%d'] );
    }

    /**
     * Bulk delete submissions
     */
    public static function bulk_delete( array $ids ) {
        global $wpdb;
        $table_name = self::get_table_name();
        $sanitized_ids = array_map( 'intval', $ids );
        $sanitized_ids = array_filter( $sanitized_ids );

        if ( empty( $sanitized_ids ) ) {
            return 0;
        }

        $in_clause = implode( ',', $sanitized_ids );
        return $wpdb->query( "DELETE FROM $table_name WHERE id IN ($in_clause)" );
    }

    /**
     * Run data retention cleanup (e.g. delete submissions older than X days)
     */
    public static function purge_old_submissions( $retention_days ) {
        global $wpdb;
        $days = intval( $retention_days );
        if ( $days <= 0 ) {
            return 0; // Disabled
        }

        $table_name = self::get_table_name();
        $cutoff_date = gmdate( 'Y-m-d H:i:s', strtotime( "-{$days} days" ) );

        return $wpdb->query( $wpdb->prepare( "DELETE FROM $table_name WHERE created_at < %s", $cutoff_date ) );
    }
}
