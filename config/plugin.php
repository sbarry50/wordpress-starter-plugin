<?php
/**
 * Plugin runtime configuration parameters.
 *
 * @package    Vendor\Plugin
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

 $plugin_dir_path = plugin_dir_path( dirname(__FILE__) );

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
         'assets' => $plugin_dir_path . 'assets/',
         'config' => $plugin_dir_path . 'config/',
         'dist'   => $plugin_dir_path . 'dist/',
         'lang'   => $plugin_dir_path . 'lang/',
         'src'    => $plugin_dir_path . 'src/',
         'test'   => $plugin_dir_path . 'test/',
         'views'  => $plugin_dir_path . 'views/',
     ],

 ];
