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
    });
})(jQuery);
