<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://johnmarclazaro.com
 * @since      1.0.0
 *
 * @package    Wc_Pdf_Invoice_Cleanup_By_Jml
 * @subpackage Wc_Pdf_Invoice_Cleanup_By_Jml/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wc_Pdf_Invoice_Cleanup_By_Jml
 * @subpackage Wc_Pdf_Invoice_Cleanup_By_Jml/includes
 * @author     John Marc Lazaro <johnmarclazaro1@gmail.com>
 */
class Wc_Pdf_Invoice_Cleanup_By_Jml_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wc-pdf-invoice-cleanup-by-jml',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
