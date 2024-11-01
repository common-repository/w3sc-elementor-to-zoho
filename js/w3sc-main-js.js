// Get From data by ajax
jQuery(document).ready(function () {
    jQuery('#w3sc-crm-connect-form').submit(function (e) {
        //Cancel from redirect
        e.preventDefault();
        var formData = jQuery(this).serializeArray();
        var data = {
            action: 'ss_ajax_action',
            purpose: 'w3sc-crm-connect',
            data: formData,
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        // Send Response in console log
        jQuery.post(w3sc_ajax_url, data, function (response) {
            console.log(response);
            response = parseInt(response);
            //Send data submission notification below submit form by jquery
            if (response == 1) {
                jQuery('#w3sc_msg').text('Contact created successfully');
            } else if (response == 2) {
                jQuery('#w3sc_msg').text('Lead Created successfully');
            } else {
                jQuery('#w3sc_msg').text('Failed to submit data');
            }
        });
    });
});
