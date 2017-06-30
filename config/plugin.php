<?php
/**
 * Plugin runtime configuration parameters.
 *
 * @package    Plugin
 * @subpackage Plugin/config
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license     GNU General Public License 2.0+
 */

namespace Vendor\Plugin;

$plugin_root_dir = plugin_dir_path( dirname(__FILE__) );

return [

    /*********************************************************
    * Minimum version requirements to run this software
    *
    * Format:
    *    $unique_id => $value
    ********************************************************/
    'requirements' => [
        'min_wp'  => '4.7',
        'min_php' => '5.3',
    ],

    /*********************************************************
    * Main plugin folder paths
    *
    * Format:
    *    $unique_id => $value
    ********************************************************/
    'paths' => [
        'assets' => $plugin_root_dir . 'assets/',
        'config' => $plugin_root_dir . 'config/',
        'dist'   => $plugin_root_dir . 'dist/',
        'lang'   => $plugin_root_dir . 'lang/',
        'src'    => $plugin_root_dir . 'src/',
        'test'   => $plugin_root_dir . 'test/',
        'views'  => $plugin_root_dir . 'views/',
    ],

];
