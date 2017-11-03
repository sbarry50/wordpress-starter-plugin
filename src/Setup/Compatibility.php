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

use Vendor\Plugin\Config\ConfigInterface;
use Vendor\Plugin\Events\EventManager;
use Vendor\Plugin\File\Loader;
use Vendor\Plugin\Support\Paths;
use const Vendor\Plugin\PLUGIN_BASENAME;

class Compatibility
{

    /**
     * Current version of WordPress
     *
     * @var string
     */
    private $wp_version;

    /**
     * Minimum version of WordPress required to run plugin
     *
     * @var string
     */
    private $min_wp_version;

    /**
     * Current version of PHP
     *
     * @var string
     */
    private $php_version;

    /**
     * Minimum version of PHP required to run plugin
     *
     * @var string
     */
    private $min_php_version;

    public function __construct( ConfigInterface $config )
    {
        $this->config = $config;
    }

    /**
     * Get the current version of WordPress
     *
     * @since  1.1.0
     * @return string
     */
    public function currentWPVersion()
    {
        return get_bloginfo( 'version' );
    }

    /**
     * Get the minimum version of WordPress required to run this plugin
     *
     * @since  1.1.0
     * @return string
     */
    public function minWPVersion()
    {
        return $this->config['min_wp_version'];
    }

    /**
     * Get the current version of PHP
     *
     * @since  1.1.0
     * @return string
     */
    public function currentPHPVersion()
    {
        return phpversion();
    }

    /**
     * Get the minimum version of PHP required to run this plugin
     *
     * @since  1.1.0
     * @return string
     */
    public function minPHPVersion()
    {
        return $this->config['min_php_version'];
    }

    /**
     * Check if requirements are met to activate and run plugin
     *
     * @since  1.0.0
     * @return null
     */
    public function check()
    {
        if ( $this->allCompatible() ) {
            return;
        } else {
            $this->addAdminEvents();
        }
    }

    /**
     * Check if all requirements are met
     *
     * @since  1.0.0
     * @return bool
     */
    public function allCompatible()
    {
        return $this->isCompatible( $this->currentWPVersion(), $this->minWPVersion() ) &&
               $this->isCompatible( $this->currentPHPVersion(), $this->minPHPVersion() );
    }

    /**
     * Check if specific requirement is met
     *
     * @since  1.0.0
     * @param  string    $current Current version
     * @param  string    $minimum Minimum required version
     * @return bool
     */
    public function isCompatible( $current, $minimum )
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
        if ( current_user_can( 'activate_plugins' ) && is_plugin_active( PLUGIN_BASENAME ) ) {
            deactivate_plugins( PLUGIN_BASENAME );

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
        $compatibility_notice_loader = container()->get( 'loader' );
        $compatibility_notice_loader->setCompatibility( $this );
        $notice = Paths::getViewsPath() . 'errors/compatibility-notice.php';
        printf( $compatibility_notice_loader->loadOutputFile( $notice ) );
    }

    /**
     * Render the dashicon in the "Requirements not met" error notice
     *
     * @since  1.0.0
     * @param  string    $current Current version
     * @param  string    $minimum Minimum required version
     * @return null
     */
    public function renderDashicon( $current, $minimum )
    {
        $this->isCompatible( $current, $minimum ) ? ($dashicon = 'yes' AND $color = '#46b450') : ($dashicon = 'no' AND $color = '#dc3232');

        printf('<span class="dashicons dashicons-%s" style="color:%s"></span>', $dashicon, $color);
    }

    /**
     * Add admin event listeners
     *
     * @since 1.0.0
     */
    private function addAdminEvents()
    {
        EventManager::addAction( 'admin_init', array( $this, 'disablePlugin' ) );
        EventManager::addAction( 'admin_notices', array( $this, 'renderNotice' ) );
    }

}
