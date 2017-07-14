<?php
/**
 * Class that checks if all system requirements are met to run this plugin.
 *
 * @package    Plugin
 * @subpackage Plugin/src
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Setup;

use Vendor\Plugin\Constants as Constants;

class Requirements {

    /**
     * Check if requirements are met to activate and run plugin
     *
     * @since  1.0.0
     * @return null
     */
    public function check() {
        if ( self::all_requirements_met() ) {
            return;
        } else {
            \add_action( 'admin_init', array( $this, 'disable_plugin' ) );
            \add_action( 'admin_notices', array( $this, 'render_notice' ) );
        }
    }

    /**
     * Check if all requirements are met
     *
     * @since  1.0.0
     * @return bool
     */
    public static function all_requirements_met() {
        return self::requirement_met( Constants\WP_VERSION, Constants\PLUGIN_MIN_WP_VERSION ) &&
               self::requirement_met( PHP_VERSION, Constants\PLUGIN_MIN_PHP_VERSION );
    }

    /**
     * Check if specific requirement is met
     *
     * @since  1.0.0
     * @param  string    $current Current version
     * @param  string    $minimum Minimum required version
     * @return bool
     */
    public static function requirement_met( $current, $minimum ) {
        return version_compare( $current, $minimum, '>=' );
    }

    /**
     * Disable the plugin and hide the default "Plugin activated" notice
     *
     * @since  1.0.0
     * @return null
     */
    public function disable_plugin() {
        if ( current_user_can( 'activate_plugins' ) && is_plugin_active( Constants\PLUGIN_BASENAME ) ) {
            deactivate_plugins( Constants\PLUGIN_BASENAME );

            // Hide the default "Plugin activated" notice
            if ( isset( $_GET[ 'activate' ] ) ) {
                unset( $_GET[ 'activate' ] );
            }
        }
    }

    /**
     * Render the "Requirements not met" error notice
     *
     * @since  1.0.0
     * @return null
     */
    public function render_notice() {
        ob_start();

        include_once Constants\PLUGIN_DIR . '/views/errors/requirements_notice.php';

        echo ob_get_clean();
    }

    /**
     * Render the dashicon in the "Requirements not met" error notice
     * 
     * @since  1.0.0
     * @param  string    $current Current version
     * @param  string    $minimum Minimum required version
     * @return null
     */
    public static function render_dashicon( $current, $minimum ) {
        self::requirement_met( $current, $minimum ) ? ($dashicon = 'yes' AND $color = '#46b450') : ($dashicon = 'no' AND $color = '#dc3232');

        printf('<span class="dashicons dashicons-%s" style="color:%s"></span>', $dashicon, $color);
    }

}
