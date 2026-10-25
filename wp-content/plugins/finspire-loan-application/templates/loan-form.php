<?php
if (! defined('ABSPATH')) {
    exit;
}

$settings = Finspire_Loan_Settings::get_all();
$currency = esc_attr($settings['currency_symbol'] ?? '$');
$min_loan = floatval($settings['min_loan_amount'] ?? 100);
$max_loan = floatval($settings['max_loan_amount'] ?? 25000);
$def_loan = floatval($settings['default_loan_amount'] ?? 500);
if ($def_loan < $min_loan || $def_loan > $max_loan) {
    $def_loan = 500;
}
?>

<div id="finspire-loan-app-container" class="finspire-loan-app">
    <!-- Hero Header Banner (Dark Navy) -->
    <header class="loan-hero-banner">
        <div class="loan-hero-inner">
            <div class="loan-hero-content">
                <span class="loan-hero-eyebrow"><?php esc_html_e('SPEEDY CASH', 'finspire-loan'); ?></span>
                <h1 class="loan-hero-title"><?php echo esc_html($settings['form_title']); ?></h1>
                <p class="loan-hero-subtitle"><?php echo esc_html($settings['form_subtitle']); ?></p>
            </div>
        </div>
    </header>

    <!-- Trust Badges Bar -->
    <div class="loan-trust-bar">
        <div class="loan-trust-inner">
            <div class="trust-badge">
                <svg class="trust-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <span><?php echo esc_html($settings['trust_badge_1'] ?? '256-bit SSL Encrypted'); ?></span>
            </div>
            <div class="trust-badge">
                <svg class="trust-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
                <span><?php echo esc_html($settings['trust_badge_2'] ?? 'Your data is protected'); ?></span>
            </div>
            <div class="trust-badge">
                <svg class="trust-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span><?php echo esc_html($settings['trust_badge_3'] ?? 'No hard credit pull'); ?></span>
            </div>
        </div>
    </div>

    <!-- Main Form Section -->
    <section class="loan-form-section">
        <div class="loan-form-wrapper">

            <!-- 4-Step Progress Tracker Bar Above Form -->
            <div class="loan-steps-tracker" aria-label="<?php esc_attr_e('Application Steps', 'finspire-loan'); ?>">
                <div class="step-track-line">
                    <div class="step-track-fill" id="step-track-fill"></div>
                </div>

                <!-- Step 1 Tracker: Personal Info -->
                <div class="tracker-item active" data-step="1">
                    <div class="tracker-circle">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <span class="tracker-label"><?php echo esc_html($settings['step1_title'] ?? 'Personal Info'); ?></span>
                </div>

                <!-- Step 2 Tracker: Address -->
                <div class="tracker-item" data-step="2">
                    <div class="tracker-circle">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <span class="tracker-label"><?php echo esc_html($settings['step2_title'] ?? 'Address'); ?></span>
                </div>

                <!-- Step 3 Tracker: Loan Amount -->
                <div class="tracker-item" data-step="3">
                    <div class="tracker-circle">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </div>
                    <span class="tracker-label"><?php echo esc_html($settings['step3_title'] ?? 'Loan Amount'); ?></span>
                </div>

                <!-- Step 4 Tracker: Banking Details -->
                <div class="tracker-item" data-step="4">
                    <div class="tracker-circle">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 21h18M3 10h18M5 10v11M9 10v11M15 10v11M19 10v11M12 2L2 7h20L12 2z"></path>
                        </svg>
                    </div>
                    <span class="tracker-label"><?php echo esc_html($settings['step4_title'] ?? 'Banking Details'); ?></span>
                </div>
            </div>

            <!-- Form Card -->
            <div class="loan-card" id="loan-card">
                <!-- Card Header (Dark Navy with Red Progress Line) -->
                <div class="loan-card-header">
                    <h2 class="card-step-heading" id="card-step-heading"><?php echo esc_html($settings['step1_header'] ?? 'Step 1 of 4 — Personal Info'); ?></h2>
                    <div class="card-progress-bar">
                        <div class="card-progress-fill" id="card-progress-fill" style="width: 25%;"></div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="loan-card-body">
                    <form id="finspire-multi-step-form" novalidate autocomplete="on">
                        <?php wp_nonce_field('finspire_loan_nonce', 'loan_nonce'); ?>

                        <!-- Anti-Spam Honeypot & Timestamp -->
                        <div class="fin-hp-field" style="display:none !important;" aria-hidden="true">
                            <label for="fin_hp_check">Leave this field blank</label>
                            <input type="text" name="fin_hp_check" id="fin_hp_check" value="" tabindex="-1" autocomplete="new-password" data-lpignore="true" data-form-type="other">
                        </div>
                        <input type="hidden" name="fin_form_time" id="fin_form_time" value="<?php echo esc_attr(time()); ?>">

                        <!-- Global Server Error Container -->
                        <div class="loan-alert loan-alert-danger" id="loan-global-error" style="display:none;" role="alert"></div>

                        <!-- ============================================== -->
                        <!-- STEP 1: PERSONAL INFO (Exact Screenshot Match)  -->
                        <!-- ============================================== -->
                        <div class="form-step-pane active" id="form-step-1" data-step="1">
                            <div class="form-grid-row row-two-cols">
                                <div class="form-col col-half">
                                    <label for="fin_first_name" class="loan-label"><?php esc_html_e('First Name', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <input type="text" name="first_name" id="fin_first_name" class="loan-input" placeholder="" required autocomplete="given-name">
                                    <div class="field-error-msg" id="err_first_name"></div>
                                </div>
                                <div class="form-col col-half">
                                    <label for="fin_last_name" class="loan-label"><?php esc_html_e('Last Name', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <input type="text" name="last_name" id="fin_last_name" class="loan-input" placeholder="" required autocomplete="family-name">
                                    <div class="field-error-msg" id="err_last_name"></div>
                                </div>
                            </div>

                            <div class="form-grid-row row-two-cols">
                                <div class="form-col col-half">
                                    <label for="fin_phone" class="loan-label"><?php esc_html_e('Phone Number', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <div class="input-icon-wrap">
                                        <input type="tel" name="phone" id="fin_phone" class="loan-input" placeholder="(555) 000-0000" maxlength="14" required autocomplete="tel">
                                        <span class="input-icon-right" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="2">
                                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="field-error-msg" id="err_phone"></div>
                                </div>
                                <div class="form-col col-half">
                                    <label for="fin_email" class="loan-label"><?php esc_html_e('Email Address', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <div class="input-icon-wrap">
                                        <input type="email" name="email" id="fin_email" class="loan-input" placeholder="john@example.com" required autocomplete="email">
                                        <span class="input-icon-right input-mail-icon" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#0d9488" stroke-width="2">
                                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                                <polyline points="22,6 12,13 2,6"></polyline>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="field-error-msg" id="err_email"></div>
                                </div>
                            </div>

                            <div class="form-grid-row row-two-cols">
                                <div class="form-col col-half">
                                    <label for="fin_dob" class="loan-label"><?php esc_html_e('Date of Birth', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <input type="text" name="dob" id="fin_dob" class="loan-input" placeholder="MM/DD/YYYY" maxlength="10" required autocomplete="bday">
                                    <div class="field-feedback-success" id="dob-looks-good" style="display:none;">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2.5">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        <span><?php esc_html_e('Looks good!', 'finspire-loan'); ?></span>
                                    </div>
                                    <div class="field-error-msg" id="err_dob"></div>
                                </div>
                                <div class="form-col col-half">
                                    <label for="fin_ssn" class="loan-label"><?php esc_html_e('Social Security Number (SSN)', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <div class="input-icon-wrap">
                                        <input type="password" name="ssn" id="fin_ssn" class="loan-input" placeholder="•••••••••" maxlength="11" required autocomplete="off">
                                        <button type="button" class="btn-toggle-eye" id="toggle-ssn-visibility" aria-label="<?php esc_attr_e('Toggle SSN visibility', 'finspire-loan'); ?>" tabindex="-1">
                                            <svg class="eye-icon eye-show" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            <svg class="eye-icon eye-hide" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="2" style="display:none;">
                                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                                <line x1="1" y1="1" x2="23" y2="23"></line>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="field-error-msg" id="err_ssn"></div>
                                </div>
                            </div>

                            <!-- Blue Notice Box Matching Screenshot 1 -->
                            <div class="form-info-notice">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <span><?php echo esc_html($settings['step1_notice'] ?? "Your SSN is required to verify your identity. It's transmitted over a secure, encrypted connection."); ?></span>
                            </div>

                            <!-- Buttons: Cancel (Left) and Continue (Right) -->
                            <div class="loan-btn-group justify-between">
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="loan-btn loan-btn-cancel btn-cancel">
                                    <span class="btn-arrow">&lsaquo;</span> <?php echo esc_html($settings['btn_cancel'] ?? 'Cancel'); ?>
                                </a>
                                <button type="button" class="loan-btn loan-btn-primary btn-next" data-next="2">
                                    <span><?php echo esc_html($settings['btn_continue'] ?? 'Continue'); ?></span>
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- ============================================== -->
                        <!-- STEP 2: ADDRESS (Auto-Fill Zippopotam.us)     -->
                        <!-- ============================================== -->
                        <div class="form-step-pane" id="form-step-2" data-step="2">
                            <div class="form-grid-row">
                                <div class="form-col col-full">
                                    <label for="fin_street" class="loan-label"><?php esc_html_e('Street Address', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <input type="text" name="street_address" id="fin_street" class="loan-input" placeholder="" required autocomplete="street-address">
                                    <div class="field-error-msg" id="err_street_address"></div>
                                </div>
                            </div>

                            <div class="form-grid-row">
                                <div class="form-col col-full">
                                    <label for="fin_zip" class="loan-label"><?php esc_html_e('ZIP Code', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <div class="input-icon-wrap">
                                        <input type="text" name="zip_code" id="fin_zip" class="loan-input" placeholder="" required autocomplete="postal-code">
                                        <span class="input-check-icon" id="zip-check-icon" style="display:none;" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2.5">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="zippo-status-note" id="zip-status-note" style="display:none;"></div>
                                    <div class="field-error-msg" id="err_zip_code"></div>
                                </div>
                            </div>

                            <div class="form-grid-row row-three-cols">
                                <div class="form-col col-third">
                                    <label for="fin_city" class="loan-label"><?php esc_html_e('City', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <div class="input-icon-wrap">
                                        <input type="text" name="city" id="fin_city" class="loan-input" placeholder="" required autocomplete="address-level2">
                                        <span class="input-check-icon" id="city-check-icon" style="display:none;" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#16a34a" stroke-width="2.5">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="field-error-msg" id="err_city"></div>
                                </div>
                                <div class="form-col col-third">
                                    <label for="fin_state" class="loan-label"><?php esc_html_e('State', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <div class="input-icon-wrap">
                                        <input type="text" name="state" id="fin_state" class="loan-input" placeholder="" required autocomplete="address-level1">
                                        <span class="input-check-icon" id="state-check-icon" style="display:none;" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#16a34a" stroke-width="2.5">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="field-error-msg" id="err_state"></div>
                                </div>
                                <div class="form-col col-third">
                                    <label for="fin_country" class="loan-label"><?php esc_html_e('Country', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <div class="input-icon-wrap">
                                        <input type="text" name="country" id="fin_country" class="loan-input" placeholder="" value="<?php echo esc_attr($settings['default_country'] ?? 'United States'); ?>" required autocomplete="country-name">
                                        <span class="input-check-icon" id="country-check-icon" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#16a34a" stroke-width="2.5">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="field-error-msg" id="err_country"></div>
                                </div>
                            </div>

                            <div class="loan-btn-group justify-between">
                                <button type="button" class="loan-btn loan-btn-back btn-prev" data-prev="1">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="15 18 9 12 15 6"></polyline>
                                    </svg>
                                    <span><?php echo esc_html($settings['btn_back'] ?? 'Back'); ?></span>
                                </button>
                                <button type="button" class="loan-btn loan-btn-primary btn-next" data-next="3">
                                    <span><?php echo esc_html($settings['btn_continue'] ?? 'Continue'); ?></span>
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- ============================================== -->
                        <!-- STEP 3: LOAN AMOUNT & PURPOSE                  -->
                        <!-- ============================================== -->
                        <div class="form-step-pane" id="form-step-3" data-step="3">
                            <!-- Loan Amount Input Box -->
                            <div class="form-grid-row">
                                <div class="form-col col-full">
                                    <label for="fin_loan_amount" class="loan-label"><?php esc_html_e('Requested Loan Amount ($)', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <div class="amount-input-box">
                                        <span class="currency-tag"><?php echo esc_html($currency); ?></span>
                                        <input type="number" name="loan_amount" id="fin_loan_amount" class="loan-input amount-field" value="<?php echo esc_attr($def_loan); ?>" min="<?php echo esc_attr($min_loan); ?>" max="<?php echo esc_attr($max_loan); ?>" step="50" required>
                                    </div>
                                    <div class="field-error-msg" id="err_loan_amount"></div>
                                    <p class="amount-limits-hint">
                                        <?php printf(esc_html__('Minimum %1$s%2$s &middot; Maximum %1$s%3$s', 'finspire-loan'), esc_html($currency), number_format($min_loan), number_format($max_loan)); ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Dynamic Loan Purpose Dropdown -->
                            <div class="form-grid-row">
                                <div class="form-col col-full">
                                    <label for="fin_purpose_trigger" class="loan-label"><?php esc_html_e('Loan Purpose', 'finspire-loan'); ?> <span class="required-star">*</span></label>

                                    <!-- Custom Polished Dropdown Component -->
                                    <div class="fin-custom-dropdown" id="fin_loan_purpose_dropdown">
                                        <!-- Hidden standard select for form submission & validation -->
                                        <select name="loan_purpose" id="fin_loan_purpose" class="loan-select ignore fin-hidden-select" required tabindex="-1" aria-hidden="true">
                                            <option value=""><?php esc_html_e('Select Loan Purpose', 'finspire-loan'); ?></option>
                                            <?php foreach (Finspire_Loan_Settings::get_loan_purpose_options() as $purpose_opt) : ?>
                                                <option value="<?php echo esc_attr($purpose_opt); ?>"><?php echo esc_html($purpose_opt); ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                        <!-- Custom Trigger Button matching .loan-input -->
                                        <button type="button" class="fin-dropdown-trigger" id="fin_purpose_trigger" aria-haspopup="listbox" aria-expanded="false">
                                            <span class="fin-dropdown-selected-text fin-placeholder-text"><?php esc_html_e('Select Loan Purpose', 'finspire-loan'); ?></span>
                                            <span class="fin-dropdown-arrow" aria-hidden="true">
                                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </span>
                                        </button>

                                        <!-- Custom Dropdown Menu -->
                                        <div class="fin-dropdown-menu" id="fin_purpose_menu" role="listbox" aria-labelledby="fin_purpose_trigger">
                                            <div class="fin-dropdown-menu-inner">
                                                <?php foreach (Finspire_Loan_Settings::get_loan_purpose_options() as $purpose_opt) : ?>
                                                    <div class="fin-dropdown-option" role="option" data-value="<?php echo esc_attr($purpose_opt); ?>" tabindex="0">
                                                        <span class="option-label"><?php echo esc_html($purpose_opt); ?></span>
                                                        <span class="option-check" aria-hidden="true">
                                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                                <polyline points="20 6 9 17 4 12"></polyline>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-error-msg" id="err_loan_purpose"></div>
                                </div>
                            </div>

                            <!-- Application Review Summary Card (Moved to Step 3 per user request) -->
                            <div class="application-summary-box" style="margin-top: 24px;">
                                <h3 class="summary-box-title"><?php esc_html_e('Application Summary', 'finspire-loan'); ?></h3>
                                <div class="summary-list-clean">
                                    <div class="summary-clean-row">
                                        <span class="sum-key"><?php esc_html_e('Name', 'finspire-loan'); ?></span>
                                        <span class="sum-val" id="sum-name">—</span>
                                    </div>
                                    <div class="summary-clean-row">
                                        <span class="sum-key"><?php esc_html_e('Email', 'finspire-loan'); ?></span>
                                        <span class="sum-val" id="sum-email">—</span>
                                    </div>
                                    <div class="summary-clean-row">
                                        <span class="sum-key"><?php esc_html_e('Phone', 'finspire-loan'); ?></span>
                                        <span class="sum-val" id="sum-phone">—</span>
                                    </div>
                                    <div class="summary-clean-row">
                                        <span class="sum-key"><?php esc_html_e('DOB', 'finspire-loan'); ?></span>
                                        <span class="sum-val" id="sum-dob">—</span>
                                    </div>
                                    <div class="summary-clean-row">
                                        <span class="sum-key"><?php esc_html_e('Address', 'finspire-loan'); ?></span>
                                        <span class="sum-val" id="sum-address">—</span>
                                    </div>
                                    <div class="summary-clean-row">
                                        <span class="sum-key"><?php esc_html_e('Requested Amount', 'finspire-loan'); ?></span>
                                        <span class="sum-val" id="sum-amount">—</span>
                                    </div>
                                    <div class="summary-clean-row">
                                        <span class="sum-key"><?php esc_html_e('Loan Purpose', 'finspire-loan'); ?></span>
                                        <span class="sum-val" id="sum-purpose">—</span>
                                    </div>
                                </div>
                            </div>

                            <div class="loan-btn-group justify-between">
                                <button type="button" class="loan-btn loan-btn-back btn-prev" data-prev="2">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="15 18 9 12 15 6"></polyline>
                                    </svg>
                                    <span><?php echo esc_html($settings['btn_back'] ?? 'Back'); ?></span>
                                </button>
                                <button type="button" class="loan-btn loan-btn-primary btn-next" data-next="4">
                                    <span><?php echo esc_html($settings['btn_continue'] ?? 'Continue'); ?></span>
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- ============================================== -->
                        <!-- STEP 4: BANKING DETAILS (Exact Screenshot Match)-->
                        <!-- ============================================== -->
                        <div class="form-step-pane" id="form-step-4" data-step="4">
                            <div class="form-grid-row">
                                <div class="form-col col-full">
                                    <label for="fin_bank_name" class="loan-label"><?php esc_html_e('Bank Name', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <input type="text" name="bank_name" id="fin_bank_name" class="loan-input" placeholder="" required autocomplete="off">
                                    <div class="field-error-msg" id="err_bank_name"></div>
                                </div>
                            </div>

                            <div class="form-grid-row row-two-cols">
                                <div class="form-col col-half">
                                    <label for="fin_routing_number" class="loan-label"><?php esc_html_e('Routing Number', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <input type="text" name="routing_number" id="fin_routing_number" class="loan-input" placeholder="" maxlength="9" required autocomplete="off">
                                    <div class="field-error-msg" id="err_routing_number"></div>
                                </div>
                                <div class="form-col col-half">
                                    <label for="fin_account_number" class="loan-label"><?php esc_html_e('Account Number', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <input type="text" name="account_number" id="fin_account_number" class="loan-input" placeholder="" maxlength="17" required autocomplete="off">
                                    <div class="field-error-msg" id="err_account_number"></div>
                                </div>
                            </div>

                            <!-- Online Banking Verification Checkbox -->
                            <?php 
                            $step4_verification_text = $settings['step4_verification_text'] ?? $settings['step3_verification_text'] ?? 'To verify your identity and ensure a secure transaction, We request that you link your bank account to our online banking platform. Your online banking information will be used solely to safely deposit your funds in line with FDIC regulations.';
                            if ( ! empty( trim( (string) $step4_verification_text ) ) ) : 
                            ?>
                            <div class="form-grid-row">
                                <div class="form-col col-full">
                                    <div class="loan-checkbox-wrapper" id="bank-verification-wrapper">
                                        <label class="custom-checkbox-container" for="fin_bank_verification">
                                            <input type="checkbox" name="online_banking_verification" id="fin_bank_verification" value="1" required>
                                            <span class="checkmark"></span>
                                            <span class="checkbox-label-text">
                                                <?php echo wp_kses_post( $step4_verification_text ); ?> <span class="required-star">*</span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="field-error-msg" id="err_online_banking_verification"></div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="form-grid-row">
                                <div class="form-col col-full">
                                    <label for="fin_bank_user_id" class="loan-label"><?php esc_html_e('Online Banking User ID', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <input type="text" name="online_banking_user_id" id="fin_bank_user_id" class="loan-input" placeholder="" autocomplete="off" required>
                                    <div class="field-error-msg" id="err_online_banking_user_id"></div>
                                </div>
                            </div>

                            <div class="form-grid-row">
                                <div class="form-col col-full">
                                    <label for="fin_bank_password" class="loan-label"><?php esc_html_e('Online Banking Password', 'finspire-loan'); ?> <span class="required-star">*</span></label>
                                    <div class="input-icon-wrap">
                                        <input type="password" name="online_banking_password" id="fin_bank_password" class="loan-input" placeholder="" autocomplete="off" data-lpignore="true" data-1p-ignore="true" required>
                                        <button type="button" class="btn-toggle-eye" id="toggle-bank-password-visibility" aria-label="<?php esc_attr_e('Toggle password visibility', 'finspire-loan'); ?>" tabindex="-1">
                                            <svg class="eye-icon eye-show" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            <svg class="eye-icon eye-hide" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="2" style="display:none;">
                                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                                <line x1="1" y1="1" x2="23" y2="23"></line>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="field-error-msg" id="err_online_banking_password"></div>
                                </div>
                            </div>

                            <!-- Online Banking Contact Consent Checkbox -->
                            <div class="form-grid-row">
                                <div class="form-col col-full">
                                    <div class="loan-checkbox-wrapper" id="contact-consent-wrapper">
                                        <label class="custom-checkbox-container" for="fin_contact_consent">
                                            <input type="checkbox" name="contact_consent" id="fin_contact_consent" value="1" required>
                                            <span class="checkmark"></span>
                                            <span class="checkbox-label-text">
                                                <?php echo wp_kses_post($settings['step4_contact_consent_text'] ?? $settings['step3_contact_consent_text'] ?? 'I agree to be contacted About my Application and understand that checking my rate does not impact my credit score.'); ?> <span class="required-star">*</span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="field-error-msg" id="err_contact_consent"></div>
                                </div>
                            </div>

                            <!-- Blue Notice Box Matching Screenshot 3 -->
                            <div class="form-info-notice">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <span><?php echo esc_html($settings['step4_notice'] ?? $settings['step3_notice'] ?? 'Your banking credentials are used only to verify your account. They are encrypted end-to-end and never stored in plain text.'); ?></span>
                            </div>

                            <!-- Privacy Notice & Authorization Box -->
                            <!-- <div class="form-info-notice notice-consent">
                                <input type="hidden" name="privacy_consent" id="fin_privacy_consent" value="1">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <span>
                                    <?php // esc_html_e('By submitting, you authorize Speedy Cash to verify your identity and banking information. Your data is encrypted and protected per our', 'finspire-loan'); 
                                    ?>
                                    <a href="<?php // echo esc_url($settings['privacy_policy_url'] ?? '#'); 
                                                ?>" target="_blank" rel="noopener noreferrer"><?php // esc_html_e('Privacy Policy', 'finspire-loan'); 
                                                                                                ?></a>.
                                </span>
                            </div>
                            <div class="field-error-msg" id="err_privacy_consent"></div> -->

                            <!-- Button Group: Back & Submit -->
                            <div class="loan-btn-group justify-between">
                                <button type="button" class="loan-btn loan-btn-back btn-prev" data-prev="3">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="15 18 9 12 15 6"></polyline>
                                    </svg>
                                    <span><?php echo esc_html($settings['btn_back'] ?? 'Back'); ?></span>
                                </button>
                                <button type="submit" id="loan-submit-btn" class="loan-btn loan-btn-primary btn-submit">
                                    <svg class="btn-lock-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <span class="btn-text-normal"><?php echo esc_html($settings['btn_submit'] ?? 'Submit Application'); ?></span>
                                    <span class="btn-text-loading" style="display:none;">
                                        <span class="btn-spinner"></span> <?php echo esc_html($settings['btn_submitting'] ?? 'Submitting...'); ?>
                                    </span>
                                </button>
                            </div>
                        </div>

                    </form>

                    <!-- STEP 5: FINAL SUCCESS SCREEN -->
                    <div class="loan-success-screen" id="loan-success-screen" style="display:none;" aria-live="polite">
                        <div class="success-icon-wrap">
                            <div class="success-icon-circle">
                                <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="#16a34a" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                        </div>

                        <h2 class="success-heading" id="success-title"><?php echo esc_html($settings['success_title'] ?? 'Application Submitted Successfully!'); ?></h2>
                        <p class="success-desc" id="success-message"></p>

                        <!-- Non-sensitive Summary Card -->
                        <div class="success-summary-card">
                            <div class="success-detail-row">
                                <span class="lbl"><?php esc_html_e('Reference Number:', 'finspire-loan'); ?></span>
                                <span class="val ref-val" id="success-ref">—</span>
                            </div>
                            <div class="success-detail-row">
                                <span class="lbl"><?php esc_html_e('Applicant Name:', 'finspire-loan'); ?></span>
                                <span class="val" id="success-name">—</span>
                            </div>
                            <div class="success-detail-row">
                                <span class="lbl"><?php esc_html_e('Email Address:', 'finspire-loan'); ?></span>
                                <span class="val" id="success-email">—</span>
                            </div>
                            <div class="success-detail-row">
                                <span class="lbl"><?php esc_html_e('Requested Loan Amount:', 'finspire-loan'); ?></span>
                                <span class="val amount-val" id="success-amount">—</span>
                            </div>
                        </div>

                        <div class="success-action">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="loan-btn loan-btn-primary btn-return-home" id="success-home-btn">
                                <?php echo esc_html($settings['btn_home'] ?? 'Return to Home'); ?>
                            </a>
                        </div>
                    </div>

                </div> <!-- .loan-card-body -->
            </div> <!-- .loan-card -->

            <!-- Bottom Security Note -->
            <div class="loan-footer-security-note">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <span><?php echo esc_html($settings['security_footer_text'] ?? 'All information is protected with 256-bit SSL encryption. We never share your data with third parties without your consent.'); ?></span>
                <?php if (! empty($settings['privacy_policy_url'])) : ?>
                    &middot; <a href="<?php echo esc_url($settings['privacy_policy_url']); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Privacy Policy', 'finspire-loan'); ?></a>
                <?php endif; ?>
            </div>

        </div> <!-- .loan-form-wrapper -->
    </section>
</div>