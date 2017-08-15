<?php
/**
 * Class that checks if all system requirements are met to run this plugin.
 *
 * @package    Vendor\Plugin\Setup
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Setup;

use Vendor\Plugin\EventManagement\PluginAPIManager;
use Vendor\Plugin\EventManagement\EventManager;
use Vendor\Plugin\File\TemplateLoader;
use Vendor\Plugin\Constants as Constants;

class Compatibility
{
    /**
     * Check if requirements are met to activate and run plugin
     *
     * @since  1.0.0
     * @return null
     */
    public function check()
    {
        if ( self::allCompatible() ) {
            return;
        } else {
            $this->add_admin_listeners();
        }
    }

    /**
     * Check if all requirements are met
     *
     * @since  1.0.0
     * @return bool
     */
    public static function allCompatible()
    {
        return self::isCompatible( Constants\WP_VERSION, Constants\PLUGIN_MIN_WP_VERSION ) &&
               self::isCompatible( PHP_VERSION, Constants\PLUGIN_MIN_PHP_VERSION );
    }

    /**
     * Check if specific requirement is met
     *
     * @since  1.0.0
     * @param  string    $current Current version
     * @param  string    $minimum Minimum required version
     * @return bool
     */
    public static function isCompatible( $current, $minimum )
    {
        return version_compare( $current, $minimum, '>=' );
    }

    /**
     * Disable the plugin and hide the default "Plugin activated" notice
     *
     * @since  1.0.0
     * @return null
     */
    public function disablePlugin()
    {
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
    public function renderNotice()
    {
        $template = new TemplateLoader(
            Constants\PLUGIN_VIEWS_PATH . '/errors/compatibility-notice.php',
            'compatibility_notice_template_path',
            'compatibility-notice'
        );
        printf( $template->loadTemplate() );
    }

    /**
     * Add admin event listeners
     *
     * @since 1.0.0
     */
    private function add_admin_listeners()
    {
        $plugin_api_manager = new PluginAPIManager();
        $event_manager = new EventManager( $plugin_api_manager );
        $event_manager->addListener( 'admin_init', array( $this, 'disablePlugin' ) );
        $event_manager->addListener( 'admin_notices', array( $this, 'renderNotice' ) );
    }

    /**
     * Render the dashicon in the "Requirements not met" error notice
     *
     * @since  1.0.0
     * @param  string    $current Current version
     * @param  string    $minimum Minimum required version
     * @return null
     */
    public static function renderDashicon( $current, $minimum )
    {
        self::isCompatible( $current, $minimum ) ? ($dashicon = 'yes' AND $color = '#46b450') : ($dashicon = 'no' AND $color = '#dc3232');

        printf('<span class="dashicons dashicons-%s" style="color:%s"></span>', $dashicon, $color);
    }

}
