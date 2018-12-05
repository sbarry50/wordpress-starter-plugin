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
 * @since             0.1.0
 * @package           Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Hub
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Central repository for crafting plugins to extend and customize WordPress
 * Version:           0.5.0
 * Author:            sbarry50
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       hub
 * Domain Path:       /resources/lang/
 */

use SB2Media\Hub\Hub;
use SB2Media\Hub\Container\Container;
use function SB2Media\Hub\{container, pluginID, setupPlugin};

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
     die;
}

$autoloader = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloader)) {
    include_once $autoloader;
}

$container = container();
$plugin_id = pluginID(__FILE__);
setupPlugin($container, $plugin_id, __FILE__);

add_action('plugins_loaded', function () use ($container, $plugin_id) {
    $container->set($plugin_id, new Hub($container, $container->get("{$plugin_id}-plugin-data")));
    $container->get($plugin_id)->init();
});
