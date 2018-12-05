<?php

namespace SB2Media\Hub;

use SB2Media\Hub\Setup\Setup;
use SB2Media\Hub\Setup\Constants;
use SB2Media\Hub\Setup\PluginData;
use SB2Media\Hub\Container\Container;

/**
 * Return instance of plugin's Pimple container
 *
 * @since  0.2.0
 * @return Container
 */
function container() : Container
{
    static $container;
    if (! $container) {
        $container = new Container();
    }
    return $container;
}

/**
 * Set up the plugin
 *
 * @since 0.5.0
 * @param Container $container
 * @param string $plugin_id
 * @param string $plugin_root_file
 * @return void
 */
function setupPlugin(Container $container, string $plugin_id, string $plugin_root_file)
{
    $container->set("{$plugin_id}-plugin-data", new PluginData($plugin_root_file));
    $container->set("{$plugin_id}-setup", new Setup($plugin_id, $plugin_root_file, $container->get("{$plugin_id}-plugin-data")));
    $container->get("{$plugin_id}-setup")->init()->run();
}

function pluginID(string $plugin_root_file)
{
    return strtolower(str_replace(' ', '-', getPluginData('name', $plugin_root_file)));
}

/**
 * Get plugin data from the plugin's bootstrap file header comment using WP core's get_file_data function
 *
 * @since  0.2.0
 * @param  string    $id    Plugin header data unique id
 * @return array            Array of plugin data from the bootstrap file header comment
 */
function getPluginData(string $id, string $plugin_root_file)
{
    $default_headers = array(
        'name' => 'Plugin Name',
        'plugin-uri' => 'Plugin URI',
        'version' => 'Version',
        'description' => 'Description',
        'author' => 'Author',
        'authorURI' => 'Author URI',
        'text-domain' => 'Text Domain',
        'domain-path' => 'Domain Path',
        'network' => 'Network',
        // Site Wide Only is deprecated in favor of Network.
        '_sitewide' => 'Site Wide Only',
    );

    return get_file_data($plugin_root_file, $default_headers)[$id];
}

// /**
//  * Initialize the plugin data
//  *
//  * @since 0.5.0
//  * @param string $id
//  * @param string $plugin_root_file
//  * @return void
//  */
// function initPluginData(string $id, string $plugin_root_file)
// {
//     $container = container();
//     $container->set("{$id}-plugin-data", new PluginData($plugin_root_file));
// }

// /**
//  * Define constants
//  *
//  * @since 0.5.0
//  * @param string $id
//  * @param string $plugin_root_file
//  * @return void
//  */
// function defineConstants(string $id)
// {
//     $container = container();
//     $container->set("{$id}-constants", new Constants(strtoupper($id), $container->get("{$id}-plugin-data")));
//     $container->get("{$id}-constants")->define();
// }
