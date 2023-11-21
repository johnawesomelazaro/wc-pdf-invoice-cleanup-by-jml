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

        // Change label of button to indicate progress
        $(this).html('Calculating data...');
		
        $.ajax({
            url: object.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'wpicbj_calculate_wc_pdf_invoice_db_records_and_file_size_ajax_action',
            },
            success: function(response) {

                console.log(response);

                setTimeout(function() {
                    // Change label of button to indicate completion of calculation 
                    $('#calculate').html('Calculation completed');
                    // Insert results if it not yet exist
                    if( $('#calculate-results').length === 0 ) {
                        $('<div>')
                            .attr('id', 'calculate-results')
                            .html(response.calculate_html)
                            .insertAfter('#calculate');
                    }
                }, 1000);

                
                
            },
            error: function(error) {
                console.error(error);
            }
        });

    });

    $(document).on('click', '#cleanup-data', function() {

        // Continue only if the button has not been clicked
        if( !$(this).hasClass('cleanup-completed') ) {
            
            // Change label of button to indicate progress
            $(this).html('Cleaning up data...');
            
            $.ajax({
                url: object.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'wpicbj_cleanup_wc_pdf_invoice_db_records_and_file_size_ajax_action',
                },
                success: function(response) {

                    setTimeout(function() {
                        // Change label of button + css class to indicate completion of cleanup 
                        $('#cleanup-data')
                            .html('Cleanup completed')
                            .addClass('cleanup-completed');
                        // Add strike effect on calculate results texts
                        $('#calculate-results p:first-child').css('text-decoration', 'line-through');
                    }, 1000);
                    
                },
                error: function(error) {
                    console.error(error);
                }
            });
        
        }

    });

})( jQuery );
