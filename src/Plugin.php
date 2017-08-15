<?php
/**
 * The core plugin class.
 *
 * @package    Vendor\Plugin
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin;

use Vendor\Plugin\Config\Config;
use Vendor\Plugin\Constants\Constants;
use Vendor\Plugin\Setup\Compatibility;
use Vendor\Plugin\Setup\I18n;
use Vendor\Plugin\Setup\EnqueueManager;
use Vendor\Plugin\Setup\Installation;
use Vendor\Plugin\EventManagement\PluginAPIManager;
use Vendor\Plugin\EventManagement\EventManager;
use Vendor\Plugin\File\Loader;
use Vendor\Plugin\Support\Arr as ArrayHelpers;

class Plugin
{
    /**
     * The plugin root file
     *
     * @var string
     */
    public $plugin_root_file;

    /**
     * Flag to track if the plugin is loaded.
     *
     * @var bool
     */
    private $loaded;

    /**
     * Instance of the Config class
     *
     * @var object
     */
    private $config;

    /**
     * Instance of the Constants class
     *
     * @var object
     */
    private $constants;

    /**
     * Instance of the Compatibility class
     *
     * @var object
     */
    private $compatibility;

    /**
     * Instance of the PluginAPIManager class
     *
     * @var object
     */
    private $plugin_api_manager;

    /**
     * Instance of the EventManager class
     *
     * @var object
     */
    private $event_manager;

    /**
     * Instance of the Enqueue class
     *
     * @var object
     */
    private $enqueue;

    /**
     * Instance of the I18n class
     *
     * @var object
     */
    private $plugin_I18n;

    /**
     * Instance of the Icon class
     *
     * @var object
     */
    private $icon;

    /**
     * Constructor.
     *
     * @since 1.0.0
     * @param string    $plugin_root_file    Root file of the plugin
     */
    public function __construct( $plugin_root_file )
    {
        $this->plugin_root_file = $plugin_root_file;
        $this->loaded = false;
        $config_file = dirname( $this->plugin_root_file ) . '/config/plugin.php';
        $this->config = new Config( $config_file );
        $this->constants = new Constants();
        $this->compatibility = new Compatibility();
        $this->plugin_api_manager = new PluginAPIManager();
        $this->event_manager = new EventManager( $this->plugin_api_manager );
        $this->enqueue_manager = new EnqueueManager();
        $this->plugin_I18n = new I18n();
    }

    /**
     * Load the plugin. Executes all initial tasks necessary to prepare the plugin to perform its objective(s).
     *
     * @since  1.0.0
     * @return object   $this   Instance of this object.
     */
    public function load()
    {
        if( $this->loaded ) {
            return;
        }

        $this->loadConstants();
        $this->checkCompatibility();
        $this->setLocale();
        $this->enqueueAssets();
        $this->install();

        $this->loaded = true;

        return $this;
    }

    /**
     * Run the tasks necessary for the plugin to perform its objective(s).
     *
     * @since  1.0.0
     * @return null
     */
    public function run()
    {

    }

    /**
     * Load plugin constants
     *
     * @since  1.0.0
     * @return null
     */
    private function loadConstants()
    {
        $this->constants->init( $this->plugin_root_file, $this->config )->define();
    }

    /**
     * Check plugin compatibility with current software environment
     *
     * @since  1.0.0
     * @return null
     */
    private function checkCompatibility()
    {
        $this->compatibility->check();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the I18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function setLocale()
    {
        $this->plugin_I18n->setDomain( \Vendor\Plugin\Constants\PLUGIN_TEXT_DOMAIN );
        $this->plugin_I18n->loadPluginTextDomain();
    }

    /**
     * Enqueue stylesheets and scripts into Wordpress via the enqueue manager.
     *
     * For stylesheets pass the file name, any dependecies (optional) and media type (optional) to enqueue_styles()
     * $this->enqueue_manager->enqueue_styles( $file, array $dependencies = array(), $media = 'all' );
     *
     * For scripts pass the file name, any dependecies (optional) and whether it should be placed in the head or footer (optional) to enqueue_scripts()
     * $this->enqueue_manager->enqueue_scripts( $file, array $dependencies = array(), $in_footer = false );
     *
     * @since  [version]
     * @return [type]    [description]
     */
    private function enqueueAssets()
    {
        // $this->enqueue_manager->enqueueStyles( 'plugin-name' );
        // $this->enqueue_manager->enqueueScripts( 'plugin-name' );

        $this->event_manager->addSubscriber( $this->enqueue_manager );
    }

    /**
     * Register installation processes
     *
     * @since  1.0.0
     * @return null
     */
    private function install()
    {
        register_activation_hook( \Vendor\Plugin\Constants\PLUGIN_ROOT, array( 'Vendor\Plugin\Setup\Installation', 'activate' ) );
        register_deactivation_hook( \Vendor\Plugin\Constants\PLUGIN_ROOT, array( 'Vendor\Plugin\Setup\Installation', 'deactivate' ) );
        register_uninstall_hook( \Vendor\Plugin\Constants\PLUGIN_ROOT, array( 'Vendor\Plugin\Setup\Installation', 'uninstall' ) );
    }
}
