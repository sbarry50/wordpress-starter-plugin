<?php
/**
 * The core plugin class.
 *
 * @package    Vendor\Plugin
 * @since      0.1.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin;

use Vendor\Plugin\Setup\I18n;
use Vendor\Plugin\Forms\Forms;
use Vendor\Plugin\File\Loader;
use Vendor\Plugin\Config\Config;
use Vendor\Plugin\Forms\Options;
use Vendor\Plugin\Support\Paths;
use Vendor\Plugin\Forms\Attributes;
use NetRivet\WordPress\EventEmitter;
use const Vendor\Plugin\PLUGIN_ROOT;
use Vendor\Plugin\Setup\Installation;
use Vendor\Plugin\Events\EventManager;
use Vendor\Plugin\Container\Container;
use Vendor\Plugin\Settings\SettingsAPI;
use const Vendor\Plugin\PLUGIN_BASENAME;
use Vendor\Plugin\Controller\Controller;
use Vendor\Plugin\Settings\SettingsLink;
use Vendor\Plugin\Settings\SettingsPages;
use Vendor\Plugin\Settings\SettingsConfig;
use Vendor\Plugin\Settings\SettingsDefaults;
use Vendor\Plugin\Controller\AdminController;
use Vendor\Plugin\Settings\SettingsCallbacks;
use Vendor\Plugin\Controller\EnqueueController;

final class Plugin
{

    /**
     * Container instance
     * @var Container
     */
    public $container;

    /**
     * The plugin root file
     *
     * @var string
     */
    public $plugin_root_file;

    /**
     * The plugin top level namespace
     *
     * @var string
     */
    public $namespace;

    /**
     * Flag to track if the plugin is loaded.
     *
     * @var bool
     */
    private $loaded = false;

    /**
     * Constructor.
     *
     * @since 0.1.0
     * @param string    plugin_root_folder    Root folder of the plugin
     */
    public function __construct(Container $container, $plugin_root_file)
    {
        $this->container = $container;
        $this->plugin_root_file = $plugin_root_file;
        $this->namespace = __NAMESPACE__;
    }

    /**
     * Add default services to our Container
     *
     * @since 0.2.0
     */
    public function registerServices()
    {
        $this->container->set('controller', new Controller($this->container));
        $this->container->set('enqueue_controller', new EnqueueController($this->container));
        $this->container->set('events', new EventEmitter());
        $this->container->set('loader', new Loader());
        $this->container->set('plugin_I18n', new I18n());
        $this->container->set('attributes', new Attributes());
        $this->container->set('options', new Options());
        $this->container->set('forms', new Forms($this->container->get('loader'), $this->container->get('attributes'), $this->container->get('options')));

        $settings_config = Paths::config() . "admin-settings-redux.php";
        $settings_defaults = Paths::config() . "admin-settings-defaults.php";
        $this->container->set('settings_config', new SettingsConfig($settings_config, $settings_defaults));
        $this->container->set('settings', new Settings($this->container->get('settings_config')));
        $this->container->set('settings_callbacks', new SettingsCallbacks($this->container->get('loader'), $this->container->get('forms')));
        $this->container->set('settings_api', new SettingsAPI($this->container->get('settings_callbacks'), $this->container->get('settings_defaults')));
        $this->container->set('settings_pages', new SettingsPages($this->container->get('settings_callbacks'), $this->container->get('settings_defaults')));
        $this->container->set('settings_link', new SettingsLink());
        $this->container->setWithConfig('admin_controller', __NAMESPACE__ . '\Controller\AdminController', 'admin-settings-redux', true, array($this->container));
        $this->container->setWithConfig('enqueue_manager', __NAMESPACE__ . '\Enqueue\EnqueueManager', 'enqueue', true);
        $this->container->setWithConfig('admin_enqueue_manager', __NAMESPACE__ . '\Enqueue\EnqueueManager', 'admin-enqueue', true);
        $this->container->setWithConfig('constants', __NAMESPACE__ . '\Constants\Constants', 'constants');
        $this->container->setWithConfig('compatibility', __NAMESPACE__ . '\Setup\Compatibility', 'requirements', false, array($this->container->get('loader')));


        return $this;
    }

    /**
     * Initialize the plugin. Executes all initial tasks necessary to prepare the plugin to perform its objective(s).
     *
     * @since  0.1.0
     * @return object   $this   Instance of this object.
     */
    public function init()
    {
        if ($this->loaded) {
            return;
        }

        $this->container->get('constants')->define();
        $this->container->get('compatibility')->check();
        $this->container->get('plugin_I18n')->loadPluginTextDomain();
        $this->container->get('enqueue_controller')->enqueueAssets();
        $this->container->get('enqueue_controller')->enqueueAdminAssets();
        $this->container->get('admin_controller')->load();

        $this->loaded = true;

        return $this;
    }
}
