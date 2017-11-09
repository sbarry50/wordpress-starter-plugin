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
 * @package           Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Starter Plugin
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress dashboard.
 * Version:           1.1.1
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /resources/lang/
 */

use Vendor\Plugin\Container\Container;
use Vendor\Plugin\Config\Config;
use Vendor\Plugin\Plugin;

 // If this file is called directly, abort.
 if ( ! defined( 'ABSPATH' ) ) {
 	die;
 }

$autoloader = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $autoloader ) ) {
	include_once $autoloader;
}

register_activation_hook( __FILE__ , array( 'Vendor\Plugin\Setup\Installation', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Vendor\Plugin\Setup\Installation', 'deactivate' ) );
register_uninstall_hook( __FILE__, array( 'Vendor\Plugin\Setup\Installation', 'uninstall' ) );

add_action( 'plugins_loaded', function () {
    container()->set( 'plugin', new Plugin( __FILE__ ) );
    container()->get( 'plugin' )->registerServices( container() )->load();
});

/**
 * Get plugin's container
 *
 * @since  1.1.0
 * @return Container
 */
function container() : Container
{
	static $container;
	if( ! $container ){
		$container = new Container();
	}
	return $container;
}
