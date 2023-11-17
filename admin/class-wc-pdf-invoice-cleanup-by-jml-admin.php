<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://johnmarclazaro.com
 * @since      1.0.0
 *
 * @package    Wc_Pdf_Invoice_Cleanup_By_Jml
 * @subpackage Wc_Pdf_Invoice_Cleanup_By_Jml/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wc_Pdf_Invoice_Cleanup_By_Jml
 * @subpackage Wc_Pdf_Invoice_Cleanup_By_Jml/admin
 * @author     John Marc Lazaro <johnmarclazaro1@gmail.com>
 */
class Wc_Pdf_Invoice_Cleanup_By_Jml_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_Pdf_Invoice_Cleanup_By_Jml_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_Pdf_Invoice_Cleanup_By_Jml_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        $file_last_modified_date = filemtime( plugin_dir_path( __FILE__ ) . 'css/wc-pdf-invoice-cleanup-by-jml-admin.css' );

		wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/wc-pdf-invoice-cleanup-by-jml-admin.css',
            array(),
            $file_last_modified_date,
            'all'
        );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_Pdf_Invoice_Cleanup_By_Jml_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_Pdf_Invoice_Cleanup_By_Jml_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$file_last_modified_date = filemtime( plugin_dir_path( __FILE__ ) . 'js/wc-pdf-invoice-cleanup-by-jml-admin.js' );

		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/wc-pdf-invoice-cleanup-by-jml-admin.js',
			array( 'jquery' ),
			$file_last_modified_date,
			false
		);

		wp_localize_script(
			$this->plugin_name,
			'object',
			array(
				'ajaxurl' => admin_url('admin-ajax.php')
			)
		) ;

	}

	/**
	 * Create new sub-menu under `Tools` menu
	 *
	 * @since    1.0.0
	 */
	public function admin_menu() {

		add_submenu_page(
			'tools.php',
			'WooCommerce PDF Invoice Cleanup',
			'WooCommerce PDF Invoice Cleanup',
			'manage_options',
			'wc-pdf-invoice-cleanup',
			array( $this, 'wc_pdf_invoice_cleanup_admin_page' )
		);

	}

	/**
	 * New sub-menu `WooCommerce PDF Invoice Cleanup` content
	 *
	 * @since    1.0.0
	 */
	public function wc_pdf_invoice_cleanup_admin_page() {

		?>
		<div class="wrap">
			<h1>WooCommerce PDF Invoice Cleanup</h2>
			<p class="main-instruction">To calculate the space used by PDF invoice files and data, click the 'Calculate' button below.</p>
			<button class="button button-primary" id="calculate">Calculate</button>
		</div>
		<?php

	}

    /**
	 * AJAX handler to calculate WooCommerce PDF invoice DB records and file size
	 *
	 * @since    1.0.0
	 */
    function wpicbj_calculate_wc_pdf_invoice_db_records_and_file_size_ajax_action() {

        global $wpdb;

        // WooCommerce PDF invoice post meta keys to calculate
        $meta_keys = array(
            '_wc_pdf_invoice_created_date',
            '_invoice_created_mysql',
            '_wc_pdf_invoice_number',
            '_invoice_number',
            '_invoice_created',
            '_invoice_date',
            '_invoice_number_display',
            '_pdf_company_name',
            '_pdf_company_details',
            '_pdf_registered_name',
            '_pdf_registered_address',
            '_pdf_company_number',
            '_pdf_tax_number',
            '_pdf_logo_file',
            '_invoice_meta',
        );

        $total_db_size = 0;

        // Iterate on each meta keys
        foreach( $meta_keys as $meta_key ) {

            // DB query to get the size of characters
            $size_query = "SELECT SUM(LENGTH(meta_value) + LENGTH(meta_key)) AS meta_size FROM {$wpdb->prefix}postmeta WHERE meta_key = %s";
            $meta_size = $wpdb->get_var($wpdb->prepare($size_query, $meta_key));

            // If records found
            // Then add to `$total_db_size`
            if( $meta_size ) {
                $total_db_size += $meta_size;
            }
        }

        $directory_path = ABSPATH . 'wp-content/uploads/woocommerce_pdf_invoice';

        // Use glob to get an array of file paths in the directory
        $files = glob($directory_path . '/*');

        // Use array_map to apply filesize to each file
        // And get an array of sizes
        // Then calculate sum
        $total_file_size = array_sum( array_map( 'filesize', $files ) );

        $html = '
            <p>
                <b>Total File Size:</b> ' . size_format($total_db_size) . '<br>
                <b>Database Size:</b>  ' . size_format($total_file_size) . '
            </p>
            <p>Please do not navigate away or perform other actions while cleanup is in progress. Wait for completion to avoid potential issues.</p>
            <button class="button button-primary" id="cleanup-data">Cleanup Data</button>
        ';

        // Return
        echo json_encode(
            array(
                'total_db_size' => size_format($total_db_size),
                'total_file_size' => size_format($total_file_size),
                'calculate_html' => $html
            )
        );

        wp_die();

    }

    /**
	 * AJAX handler to cleanup WooCommerce PDF invoice DB records and file size
	 *
	 * @since    1.0.0
	 */
    function wpicbj_cleanup_wc_pdf_invoice_db_records_and_file_size_ajax_action() {

        // WooCommerce PDF invoice post meta keys to delete
        $meta_keys = array(
            '_wc_pdf_invoice_created_date',
            '_invoice_created_mysql',
            '_wc_pdf_invoice_number',
            '_invoice_number',
            '_invoice_created',
            '_invoice_date',
            '_invoice_number_display',
            '_pdf_company_name',
            '_pdf_company_details',
            '_pdf_registered_name',
            '_pdf_registered_address',
            '_pdf_company_number',
            '_pdf_tax_number',
            '_pdf_logo_file',
            '_invoice_meta'
        );

        // Convert meta keys to a comma-separated string for the SQL query
        $meta_keys_string = "'" . implode("','", $meta_keys) . "'";

        // Run delete query matching the post meta keys defined in `$meta_keys`
        global $wpdb;
        $db_delete_query = $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM $wpdb->postmeta WHERE meta_key IN ($meta_keys_string)"
            )
        );

        $directory_path = ABSPATH . 'wp-content/uploads/woocommerce_pdf_invoice';

        $file_delete = false;

        // Ensure the directory path is valid and exists
        if( is_dir( $directory_path ) ) {

            // Get all PDF files in the directory
            $pdf_files = glob($directory_path . '/*.pdf');

            // Loop through each PDF file and delete it
            foreach( $pdf_files as $pdf_file ) {
                if( is_file( $pdf_file ) ) {
                    unlink( $pdf_file );
                }
            }

            $file_delete = true;

        }

        // Return
        echo json_encode(
            array(
               'success' => (
                    $db_delete_query !== false &&
                    $file_delete
                    ? true
                    : false
                ) 
            )
        );

        wp_die();

    }

}
