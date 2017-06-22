<?php
/**
 * Class that checks if all system requirements are met to run this plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    PluginName
 * @subpackage PluginName/src
 *
 */

namespace Vendor_Name\Plugin_Name;

class Requirements {

    public function check() {
        if ( self::requirements_met() ) {
            return;
        } else {
            \add_action( 'admin_init', array( $this, 'disable_plugin' ) );
            \add_action( 'admin_notices', array( $this, 'show_notice' ) );
        }
    }

    public static function requirements_met() {
        return self::is_wp_compatible() && self::is_php_compatible();
    }

    public static function is_wp_compatible() {
        return version_compare( WP_VERSION, PLUGIN_MIN_WP_VERSION, '>' );
    }

    public static function is_php_compatible() {
        return version_compare( PHP_VERSION, PLUGIN_MIN_PHP_VERSION, '>' );
    }

    public function disable_plugin() {

        // return "This plugin is being disabled";
        if ( current_user_can( 'activate_plugins' ) && is_plugin_active( PLUGIN_BASENAME ) ) {
            deactivate_plugins( PLUGIN_BASENAME );

            // Hide the default "Plugin activated" notice
            if ( isset( $_GET[ 'activate' ] ) ) {
                unset( $_GET[ 'activate' ] );
            }
        }
    }

    public function show_notice() {
        // echo "Show notice is running!";
        return include_once( PLUGIN_DIR . "/views/errors/requirements_notice.php" );
    }

}
