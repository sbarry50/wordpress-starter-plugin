<?php
/**
 * Constants - define the plugin's magic constants
 *
 * @package     Vendor_Name\Plugin_Name
 * @since       1.0.0
 * @author      author-name
 * @link        https://example.com
 * @license     GNU General Public License 2.0+ and MIT Licence (MIT)
 */

 namespace Vendor_Name\Plugin_Name;

function define_plugin_constants( $plugin_root_file ) {

    $const = get_plugin_constants( $plugin_root_file );

    foreach ( $const as $constant => $value ) {
        if ( ! defined( $constant ) ) {
            define( $constant, $value );
        }
    }
}

function get_plugin_constants( $plugin_root_file ) {

    $plugin_data = get_plugin_data( $plugin_root_file );

    return array(
        'PLUGIN_ROOT'        => $plugin_root_file,
        'PLUGIN_DIR'         => plugin_dir_path( $plugin_root_file ),
        'PLUGIN_URL'         => get_plugin_url( $plugin_root_file ),
        'PLUGIN_VERSION'     => $plugin_data[ 'Version' ],
        'PLUGIN_TEXT_DOMAIN' => $plugin_data[ 'TextDomain' ]
    );
}

function get_plugin_url( $plugin_root_file ) {
    $plugin_url = plugin_dir_url( $plugin_root_file );
    if ( is_ssl() ) {
        $plugin_url = str_replace( 'http://', 'https://', $plugin_url );
    }
    return $plugin_url;
}

function get_plugin_data( $plugin_root_file ) {
    if ( !function_exists( 'get_plugin_data' ) ) {
        require_once ABSPATH . '/wp-admin/includes/plugin.php';
    }
    return \get_plugin_data( $plugin_root_file );
}
