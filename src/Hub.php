<?php
/**
 * The core plugin class.
 *
 * @package    SB2Media\Hub
 * @since      0.1.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Hub;

use SB2Media\Hub\Setup\PluginData;
use SB2Media\Hub\Container\Container;
use SB2Media\Hub\Config\ConfigFactory;

class Hub
{

    /**
     * Container instance
     * @var Container
     */
    public $container;

    /**
     * The plugin data
     *
     * @var PluginData
     */
    public $plugin_data;

    /**
     * Flag to track if the plugin is loaded.
     *
     * @var bool
     */
    public $loaded = false;

    /**
     * Constructor.
     *
     * @since 0.1.0
     * @param string    plugin_root_folder    Root folder of the plugin
     */
    public function __construct(Container $container, PluginData $plugin_data)
    {
        $this->container = $container;
        $this->plugin_data = $plugin_data;
    }

    /**
     * Add default services to our Container
     *
     * @since 0.2.0
     */
    public function registerServices()
    {
        $service_providers = $this->container->get(Container::id($this->plugin_data->plugin_id, 'service-providers', '', true))->config;
        $keys = [];

        foreach ($service_providers as $key => $value) {
            $args = [];
            $key = Container::id($this->plugin_data->plugin_id, $key, '');

            if (array_key_exists('dependencies', $value)) {
                $args = $this->resolveDependencies($value['dependencies']);
            }

            if (array_key_exists('params', $value)) {
                $args = array_merge($args, $value['params']);
            }

            if (!empty($args)) {
                $this->container->set($key, new $value['class'](...$args));
            } else {
                $this->container->set($key, new $value['class']());
            }

            array_push($keys, $key);
        }

        $this->container->setCollection("{$this->plugin_data->plugin_id}-services", $keys);

        return $this;

        // $this->container->set('loader', new Loader());
        // $this->container->setWithConfig('constants', __NAMESPACE__ . '\Constants\Constants', 'constants');
        // $this->container->set('controller', new Controller($this->container));
        // $this->container->set('enqueue_controller', new EnqueueController($this->container));
        // $this->container->set('events', new EventEmitter());
        // $this->container->set('plugin_I18n', new I18n());
        // $this->container->set('attributes', new Attributes());
        // $this->container->set('options', new Options());
        // $this->container->set('forms', new Forms($this->container->get('loader'), $this->container->get('attributes'), $this->container->get('options')));

        // $settings_config = Paths::config() . "admin-settings-redux.php";
        // $settings_defaults = Paths::config() . "admin-settings-defaults.php";
        // $this->container->set('settings_config', new SettingsConfig($settings_config, $settings_defaults));
        // $this->container->set('settings_callbacks', new SettingsCallbacks($this->container->get('loader'), $this->container->get('forms')));
        // $this->container->set('settings', new Settings($this->container->get('settings_config'), $this->container->get('settings_callbacks')));
        // $this->container->set('settings_api', new SettingsAPI($this->container->get('settings_config'), $this->container->get('settings_callbacks')));
        // $this->container->set('settings_pages', new SettingsPages($this->container->get('settings_config'), $this->container->get('settings_callbacks')));
        // $this->container->set('settings_link', new SettingsLink());
        // $this->container->set('admin_controller', new AdminController($this->container, $this->container->get('settings')));
        // // $this->container->setWithConfig('admin_controller', __NAMESPACE__ . '\Controller\AdminController', 'admin-settings-redux', true, array($this->container));
        // $this->container->setWithConfig('enqueue_manager', __NAMESPACE__ . '\Enqueue\EnqueueManager', 'enqueue', true);
        // $this->container->setWithConfig('admin_enqueue_manager', __NAMESPACE__ . '\Enqueue\EnqueueManager', 'admin-enqueue', true);
        // $this->container->setWithConfig('compatibility', __NAMESPACE__ . '\Setup\Compatibility', 'requirements', false, array($this->container->get('loader')));
    }

    /**
     * Resolve the dependencies from the configuration file
     *
     * @since 0.5.0
     * @param array    $dependencies
     * @return array
     */
    protected function resolveDependencies(array $dependencies)
    {
        foreach ($dependencies as $key => $value) {
            $dependencies[$key] = $this->container->get(Container::id($this->plugin_data->plugin_id, $value));
        }

        return $dependencies;
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

        ConfigFactory::initConfigs($this->plugin_data->plugin_id, $this->plugin_data->plugin_root_file);
        $this->registerServices();
        $this->container->get("{$this->plugin_data->plugin_id}-enqueue-controller")->enqueueAssets();
        $this->container->get("{$this->plugin_data->plugin_id}-enqueue-controller")->enqueueAdminAssets();
        $this->container->get("{$this->plugin_data->plugin_id}-admin-controller")->load();

        $this->loaded = true;

        return $this;
    }
}
