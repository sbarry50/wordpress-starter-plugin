<?php
/**
 * Defines the plugin's constants.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/src
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor_Name\Plugin_Name;

/**
 * Defines the plugin's magic constants
 *
 * @since  1.0.0
 * @param  string    $plugin_root_file The root file of the plugin
 */
function define_plugin_constants( $plugin_root_file ) {

    $const = get_plugin_constants( $plugin_root_file );

    foreach ( $const as $constant => $value ) {
        if ( ! defined( $constant ) ) {
            define( __NAMESPACE__ . "\\{$constant}", $value );
        }
    }

}

/**
 * Gets the array of plugin constants and returns them
 *
 * @since  1.0.0
 * @param  string    $plugin_root_file The root file of the plugin
 * @return array                       Array of plugin constants
 */
function get_plugin_constants( $plugin_root_file ) {

    $plugin_data = get_plugin_data( $plugin_root_file );
    $config = include( plugin_dir_path( $plugin_root_file ) . '/config/plugin.php' );

    return array(
        'DIST_ICONS_PATH'        => $config['dist_paths']['icons'],
        'DIST_IMAGES_PATH'       => $config['dist_paths']['images'],
        'DIST_FONTS_PATH'        => $config['dist_paths']['fonts'],
        'DIST_STYLES_PATH'       => $config['dist_paths']['styles'],
        'DIST_SCRIPTS_PATH'      => $config['dist_paths']['scripts'],
        'PLUGIN_BASENAME'        => plugin_basename( $plugin_root_file ),
        'PLUGIN_DIR'             => plugin_dir_path( $plugin_root_file ),
        'PLUGIN_DIR_URL'         => plugin_dir_url( plugin_dir_path( $plugin_root_file ) ),
        'PLUGIN_MIN_PHP_VERSION' => $config['requirements']['min_php'],
        'PLUGIN_MIN_WP_VERSION'  => $config['requirements']['min_wp'],
        'PLUGIN_NAME'            => $plugin_data[ 'Name' ],
        'PLUGIN_ROOT'            => $plugin_root_file,
        'PLUGIN_TEXT_DOMAIN'     => $plugin_data[ 'TextDomain' ],
        'PLUGIN_URL'             => get_plugin_url( $plugin_root_file ),
        'PLUGIN_VERSION'         => $plugin_data[ 'Version' ],
        'WP_VERSION'             => get_bloginfo('version'),
    );
}

/**
 * Gets the plugin URL
 *
 * @since  1.0.0
 * @param  string    $plugin_root_file The root file of the plugin
 * @return string    $plugin_url       The plugin URL
 */
function get_plugin_url( $plugin_root_file ) {
    $plugin_url = plugin_dir_url( $plugin_root_file );
    if ( is_ssl() ) {
        $plugin_url = str_replace( 'http://', 'https://', $plugin_url );
    }
    return $plugin_url;
}

/**
 * Gets plugin data from the plugin's bootstrap file header comment using WP core's get_plugin_data function
 *
 * @since  1.0.0
 * @param  string    $plugin_root_file The root file of the plugin
 * @return array                       Array of plugin data from the bootstrap file header comment
 */
function get_plugin_data( $plugin_root_file ) {
    if ( !function_exists( 'get_plugin_data' ) ) {
        require_once ABSPATH . '/wp-admin/includes/plugin.php';
    }
    return \get_plugin_data( $plugin_root_file );
}
