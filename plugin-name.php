<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Plugin Boilerplate
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress dashboard.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /resources/lang/
 * Min WP Version:    4.7
 * Min PHP Version:   5.3
 */

// namespace Vendor_Name\Plugin_Name;

 // If this file is called directly, abort.
 if ( ! defined( 'WPINC' ) ) {
 	die;
 }

$autoloader = dirname( __FILE__ ) . '/vendor/autoload.php';
if ( file_exists( $autoloader ) ) {
	require_once $autoloader;
}

\Vendor_Name\Plugin_Name\define_plugin_constants( __FILE__ );

$requirements = new \Vendor_Name\Plugin_Name\Requirements();
$requirements->check();
register_activation_hook( __FILE__, array( 'Vendor_Name\Plugin_Name\Setup', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Vendor_Name\Plugin_Name\Setup', 'deactivate' ) );
// register_uninstall_hook( __FILE__, array( 'Vendor_Name\Plugin_Name\Setup', 'uninstall' ) );



/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
\add_action( 'plugins_loaded', function () {
    $plugin = new \Vendor_Name\Plugin_Name\Plugin();
    $plugin->run();
} );

// ddd( \do_action('admin_init') );
// ddd( admin_init );
// d( version_compare( WP_VERSION, PLUGIN_MIN_WP_VERSION, '>' ) );
// d( WP_VERSION );
// d( PLUGIN_MIN_WP_VERSION );
// d( version_compare( PHP_VERSION, PLUGIN_MIN_PHP_VERSION, '>' ) );
// d( PHP_VERSION );
// d( PLUGIN_MIN_PHP_VERSION );
// ddd( Requirements::requirements_met() );
// d( PLUGIN_ROOT );
// d( PLUGIN_BASENAME );
// d( PLUGIN_DIR );
// d( PLUGIN_URL );
// d( PLUGIN_VERSION );
// ddd( PLUGIN_TEXT_DOMAIN );
