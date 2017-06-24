<?php
/**
 * Plugin runtime configuration parameters.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/config
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license     GNU General Public License 2.0+
 */

namespace Vendor_Name\Plugin_Name;

$plugin_dist_dir = plugin_dir_path( dirname(dirname(__FILE__) ) . '/plugin.php' ) . 'dist/';

return array(

    /*********************************************************
    * Minimum version requirements to run this software
    *
    * Format:
    *    $unique_id => $value
    ********************************************************/
    'requirements' => array(
        'min_wp'  => '4.7',
        'min_php' => '5.3',
    ),

    /*********************************************************
    * Distribution paths to asset files
    *
    * Format:
    *    $unique_id => $value
    ********************************************************/
    'dist_paths' => array(
        'icons'   => $plugin_dist_dir . 'icons/',
        'images'  => $plugin_dist_dir . 'images/',
        'fonts'   => $plugin_dist_dir . 'fonts/',
        'styles'  => $plugin_dist_dir . 'css/',
        'scripts' => $plugin_dist_dir . 'js/',
    ),

);
