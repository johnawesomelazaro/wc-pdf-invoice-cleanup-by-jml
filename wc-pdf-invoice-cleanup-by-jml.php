<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://johnmarclazaro.com
 * @since             1.0.0
 * @package           Wc_Pdf_Invoice_Cleanup_By_Jml
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce PDF Invoice Cleanup
 * Plugin URI:        https://johnmarclazaro.com/wc-pdf-invoice-cleanup
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            John Marc Lazaro
 * Author URI:        https://johnmarclazaro.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-pdf-invoice-cleanup-by-jml
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WC_PDF_INVOICE_CLEANUP_BY_JML_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wc-pdf-invoice-cleanup-by-jml-activator.php
 */
function activate_wc_pdf_invoice_cleanup_by_jml() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-pdf-invoice-cleanup-by-jml-activator.php';
	Wc_Pdf_Invoice_Cleanup_By_Jml_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wc-pdf-invoice-cleanup-by-jml-deactivator.php
 */
function deactivate_wc_pdf_invoice_cleanup_by_jml() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-pdf-invoice-cleanup-by-jml-deactivator.php';
	Wc_Pdf_Invoice_Cleanup_By_Jml_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wc_pdf_invoice_cleanup_by_jml' );
register_deactivation_hook( __FILE__, 'deactivate_wc_pdf_invoice_cleanup_by_jml' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-pdf-invoice-cleanup-by-jml.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_pdf_invoice_cleanup_by_jml() {

	$plugin = new Wc_Pdf_Invoice_Cleanup_By_Jml();
	$plugin->run();

}
run_wc_pdf_invoice_cleanup_by_jml();
