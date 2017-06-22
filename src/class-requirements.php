<?php
/**
 * Class that checks if all system requirements are met to run this plugin.
 *
 * @package    PluginName
 * @subpackage PluginName/src
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor_Name\Plugin_Name;

class Requirements {

    public function check() {
        if ( self::all_requirements_met() ) {
            return;
        } else {
            \add_action( 'admin_init', array( $this, 'disable_plugin' ) );
            \add_action( 'admin_notices', array( $this, 'get_notice' ) );
        }
    }

    public static function all_requirements_met() {
        return self::requirement_met( WP_VERSION, PLUGIN_MIN_WP_VERSION ) &&
               self::requirement_met( PHP_VERSION, PLUGIN_MIN_PHP_VERSION );
    }

    public static function requirement_met( $current, $minimum ) {
        return version_compare( $current, $minimum, '>=' );
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

    public function get_notice() {
        return include_once( PLUGIN_DIR . "/views/errors/requirements_notice.php" );
    }

    public static function show_dashicon( $current, $minimum ) {
        self::requirement_met( $current, $minimum ) ? ($dashicon = 'yes' AND $color = '#46b450') : ($dashicon = 'no' AND $color = '#dc3232');

        echo "<span class=\"dashicons dashicons-{$dashicon}\" style=\"color:{$color};\"></span>";
    }

}
