<?php
/**
 * Class that checks if all system requirements are met to run this plugin.
 *
 * @package    SB2Media\Hub\Setup
 * @since      0.1.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Hub\Setup;

use SB2Media\Hub\File\Loader;
use SB2Media\Hub\Support\Paths;
use SB2Media\Hub\Container\Container;
use SB2Media\Hub\Events\EventManager;
use SB2Media\Hub\File\LoaderInterface;
use const SB2Media\Hub\PLUGIN_BASENAME;
use SB2Media\Hub\Config\ConfigInterface;

class Compatibility
{

    /**
     * Current version of WordPress
     *
     * @var string
     */
    public $wp_version;

    /**
     * Minimum version of WordPress required to run plugin
     *
     * @var string
     */
    public $min_wp_version = '4.7';

    /**
     * Current version of PHP
     *
     * @var string
     */
    public $php_version;

    /**
     * Minimum version of PHP required to run plugin
     *
     * @var string
     */
    public $min_php_version = '7.0';

    /**
     * Constructor
     *
     * @since 0.5.0
     */
    public function __construct(PluginData $plugin_data)
    {
        $this->wp_version = get_bloginfo('version');
        $this->php_version = phpversion();
        $this->plugin_data = $plugin_data;
    }

    /**
     * Check if requirements are met to activate and run plugin
     *
     * @since  0.1.0
     * @return null
     */
    public function check()
    {
        if ($this->allCompatible()) {
            return;
        } else {
            $this->addAdminEvents();
        }
    }

    /**
     * Check if all requirements are met
     *
     * @since  0.1.0
     * @return bool
     */
    public function allCompatible()
    {
        return $this->isCompatible($this->wp_version, $this->min_wp_version) &&
               $this->isCompatible($this->php_version, $this->min_php_version);
    }

    /**
     * Check if specific requirement is met
     *
     * @since  0.1.0
     * @param  string    $current Current version
     * @param  string    $minimum Minimum required version
     * @return bool
     */
    public function isCompatible($current, $minimum)
    {
        return version_compare($current, $minimum, '>=');
    }

    /**
     * Disable the plugin and hide the default "Plugin activated" notice
     *
     * @since  0.1.0
     * @return null
     */
    public function disablePlugin()
    {
        if (current_user_can('activate_plugins') && is_plugin_active($this->plugin_data->basename())) {
            deactivate_plugins($this->plugin_data->basename());

            // Hide the default "Plugin activated" notice
            if (isset($_GET[ 'activate' ])) {
                unset($_GET[ 'activate' ]);
            }
        }
    }

    /**
     * Render the "Requirements not met" error notice
     *
     * @since  0.1.0
     * @return null
     */
    public function renderNotice()
    {
        $notice = HUB_DIR_PATH . 'views/errors/compatibility-notice.php';
        printf(Loader::loadOutputFile($notice, $this->plugin_data));
    }

    /**
     * Render the dashicon in the "Requirements not met" error notice
     *
     * @since  0.1.0
     * @param  string    $current Current version
     * @param  string    $minimum Minimum required version
     * @return null
     */
    public function renderDashicon($current, $minimum)
    {
        $this->isCompatible($current, $minimum) ? ($dashicon = 'yes' and $color = '#46b450') : ($dashicon = 'no' and $color = '#dc3232');

        printf('<span class="dashicons dashicons-%s" style="color:%s"></span>', $dashicon, $color);
    }

    /**
     * Add admin event listeners
     *
     * @since 0.1.0
     */
    private function addAdminEvents()
    {
        EventManager::addAction('admin_init', array($this, 'disablePlugin'));
        EventManager::addAction('admin_notices', array($this, 'renderNotice'));
    }
}
