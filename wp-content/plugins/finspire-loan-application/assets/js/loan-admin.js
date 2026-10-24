/**
 * Finspire Loan Application - Admin JS
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Bulk select all checkboxes
        $('#cb-select-all').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('input[name="submission_ids[]"]').prop('checked', isChecked);
        });

        // Save status & notes via AJAX
        $('#save-status-btn').on('click', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var $msg = $('#save-status-msg');
            var formData = $('#admin-status-form').serialize();

            $btn.prop('disabled', true).text('Saving...');
            $msg.text('').css('color', '');

            $.ajax({
                url: FinspireLoanAdmin.ajax_url,
                type: 'POST',
                data: formData + '&action=finspire_update_submission_status&nonce=' + FinspireLoanAdmin.nonce,
                dataType: 'json',
                success: function(res) {
                    $btn.prop('disabled', false).text('Save Status & Notes');
                    if (res && res.success) {
                        $msg.text('Status updated successfully!').css('color', '#16a34a');
                        setTimeout(function() { $msg.fadeOut(500, function() { $(this).text('').show(); }); }, 3000);
                    } else {
                        $msg.text(res.data && res.data.message ? res.data.message : 'Error updating').css('color', '#dc2626');
                    }
                },
                error: function() {
                    $btn.prop('disabled', false).text('Save Status & Notes');
                    $msg.text('Server communication error.').css('color', '#dc2626');
                }
            });
        });

        // Click-to-reveal sensitive fields (SSN, Account Number, Bank Password)
        $(document).on('click', '.fin-reveal-btn, .fin-reveal-icon-btn, .fin-reveal-text', function(e) {
            e.preventDefault();
            var $target = $(this);
            var $wrap = $target.closest('.fin-admin-reveal-wrap');
            var $text = $wrap.find('.fin-reveal-text');
            var $btn = $wrap.find('.fin-reveal-btn, .fin-reveal-icon-btn');
            var $label = $btn.find('.fin-reveal-label');
            var $icon = $btn.find('.dashicons');

            if (!$text.length) {
                return;
            }

            var currentState = $text.attr('data-state') || 'masked';
            var maskedVal = $text.attr('data-masked') || '';
            var fullVal = $text.attr('data-full') || '';

            if (!fullVal || fullVal === maskedVal) {
                return;
            }

            if (currentState === 'masked') {
                $text.text(fullVal).attr('data-state', 'revealed');
                if ($label.length) {
                    $label.text('Hide');
                }
                if ($icon.length) {
                    $icon.removeClass('dashicons-visibility').addClass('dashicons-hidden');
                }
                $btn.attr('title', 'Click to hide');
            } else {
                $text.text(maskedVal).attr('data-state', 'masked');
                if ($label.length) {
                    $label.text('View');
                }
                if ($icon.length) {
                    $icon.removeClass('dashicons-hidden').addClass('dashicons-visibility');
                }
                $btn.attr('title', 'Click to view');
            }
        });

        // Keyboard accessibility for .fin-reveal-text (Enter / Space)
        $(document).on('keydown', '.fin-reveal-text', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).trigger('click');
            }
        });

        // Copy sensitive values to clipboard
        $(document).on('click', '.fin-copy-btn', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var textToCopy = $btn.attr('data-copy') || '';
            if (!textToCopy) {
                return;
            }

            var doCopyFallback = function(str) {
                var $textarea = $('<textarea>')
                    .val(str)
                    .css({ position: 'fixed', opacity: '0', top: '0', left: '0' })
                    .appendTo('body');
                $textarea.focus().select();
                try {
                    document.execCommand('copy');
                } catch (err) {}
                $textarea.remove();
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(textToCopy).catch(function() {
                    doCopyFallback(textToCopy);
                });
            } else {
                doCopyFallback(textToCopy);
            }

            // Visual copied feedback
            var origHtml = $btn.html();
            $btn.addClass('fin-copy-success').html('<span class="dashicons dashicons-yes"></span>');
            setTimeout(function() {
                $btn.removeClass('fin-copy-success').html(origHtml);
            }, 1600);
        });
    });
})(jQuery);
