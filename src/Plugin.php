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

use Vendor\Plugin\Config\Config;
use Vendor\Plugin\Container\Container;

use const Vendor\Plugin\PLUGIN_ROOT;
use const Vendor\Plugin\PLUGIN_BASENAME;

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
        $service_providers = $this->container->get('service-providers-config')->config;

        foreach ($service_providers as $key => $value) {
            $args = [];

            if (array_key_exists('dependencies', $value)) {
                $args = $this->filterDependencies($value['dependencies']);
            }

            if (array_key_exists('params', $value)) {
                $args = array_merge($args, $value['params']);
            }

            if (!empty($args)) {
                $this->container->set($key, new $value['class'](...$args));
            } else {
                $this->container->set($key, new $value['class']());
            }
        }

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


        return $this;
    }

    protected function filterDependencies(array $dependencies)
    {
        foreach ($dependencies as $key => $value) {
            if ($value == 'container') {
                $dependencies[$key] = $this->container;
                continue;
            }
            $dependencies[$key] = $this->container->get($value);
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

        $this->registerConfigs();
        $this->registerServices();
        $this->container->get('constants')->define();
        $this->container->get('compatibility')->check();
        $this->container->get('plugin_I18n')->loadPluginTextDomain();
        $this->container->get('enqueue_controller')->enqueueAssets();
        $this->container->get('enqueue_controller')->enqueueAdminAssets();
        $this->container->get('admin_controller')->load();
        $this->container->get('cpt_controller')->addCustomPostTypes();

        $this->loaded = true;

        return $this;
    }

    /**
     * Register and instantiate the plugin configuration objects
     *
     * @since 0.3.0
     * @return void
     */
    protected function registerConfigs()
    {
        $config_dir_path = plugin_dir_path($this->plugin_root_file) . 'config/';
        $config_dir = scandir($config_dir_path);

        $config_files = $this->filterConfigDir($config_dir);

        foreach ($config_files as $config_id => $config_file) {
            $config_file = $config_dir_path . $config_file;
            $this->container->set($config_id . '-config', new Config($config_file));
        }

        return $this;
    }

    protected function filterConfigDir($config_dir)
    {
        foreach ($config_dir as $key => $value) {
            if (in_array($value, array('.','..','index.php')) || strpos($value, '.php') == false) {
                unset($config_dir[$key]);
            }
        }

        foreach ($config_dir as $config_file) {
            $config_id = str_replace('.php', '', $config_file);
            $config[$config_id] = $config_file;
        }

        return $config;
    }
}
