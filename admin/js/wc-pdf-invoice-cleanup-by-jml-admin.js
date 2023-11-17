(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).on('click', '#calculate', function() {
		
        $.ajax({
            url: object.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'wpicbj_calculate_wc_pdf_invoice_db_records_and_file_size_ajax_action',
            },
            success: function(response) {

                console.log(response);

                // Check if the element with id "qwer" already exists
                if( $('#calculate-results').length === 0 ) {
                    // If not, create a new element with id "qwer" after the element with id "calculate"
                    $('<div>')
                    .attr('id', 'calculate-results')
                    .html(response.calculate_html)
                    .insertAfter('#calculate');
                }
                
            },
            error: function(error) {
                console.error(error);
            }
        });

    });

})( jQuery );
