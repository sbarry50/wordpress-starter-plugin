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
use Vendor\Plugin\Container\Container;
use Vendor\Plugin\Setup\I18n;
use Vendor\Plugin\Events\EventManager;
use Vendor\Plugin\File\Loader;
use Vendor\Plugin\Setup\Installation;
use Vendor\Plugin\Support\Paths;
use Vendor\Plugin\Support\Arr as ArrayHelpers;
use const Vendor\Plugin\PLUGIN_ROOT;

use NetRivet\WordPress\EventEmitter;

class Plugin
{
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
     * @since 1.0.0
     * @param string    plugin_root_folder    Root folder of the plugin
     */
    public function __construct( $plugin_root_file )
    {
        $this->plugin_root_file = $plugin_root_file;
        $this->namespace = __NAMESPACE__;
    }

    /**
     * Add default services to our Container
     *
     * @since 1.1.0
     * @param Container $container
     */
    public function registerServices( Container $container )
    {
        $container->set( 'events', new EventEmitter() );
        $container->set( 'loader', new Loader() );
        $container->set( 'plugin_I18n', new I18n() );
        $container->setWithConfig( 'enqueue_manager', __NAMESPACE__ . '\Enqueue\EnqueueManager', 'enqueue', true );
        $container->setWithConfig( 'admin_enqueue_manager', __NAMESPACE__ . '\Enqueue\EnqueueManager', 'admin-enqueue', true );
        $container->setWithConfig( 'constants', __NAMESPACE__ . '\Constants\Constants', 'constants' );
        $container->setWithConfig( 'compatibility', __NAMESPACE__ . '\Setup\Compatibility', 'requirements' );

        return $this;
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

        container()->get( 'constants' )->define();
        container()->get( 'compatibility' )->check();
        container()->get( 'plugin_I18n' )->loadPluginTextDomain();
        // $this->enqueueAssets();
        // $this->enqueueAdminAssets();
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
        // Tasks to perform here
        return;
    }

    /**
     * Enqueue front end stylesheets and scripts into Wordpress via the enqueue manager.
     *
     * Recommend adding stylesheets and scripts via the enqueue config file.
     *
     * The alternative way to add stylesheets and scripts
     *
     * For stylesheets pass the file name, any dependecies (optional) and media type (optional) to enqueueStyles()
     * $enqueue_manager->enqueueStyles( $file, array $dependencies = array(), $media = 'all' );
     *
     * For scripts pass the file name, any dependecies (optional) and whether it should be placed in the head or footer (optional) to enqueueScripts()
     * $enqueue_manager->enqueueScripts( $file, array $dependencies = array(), $in_footer = false );
     *
     * @since  1.0.0
     * @return
     */
    protected function enqueueAssets()
    {
        $enqueue_manager = container()->get( 'enqueue_manager' );
        $enqueue_manager->enqueueConfig();
                        // ->enqueueStyles( 'another-name', array(), 'all' )
                        // ->enqueueScripts( 'another-name', array(), true );
        EventManager::addAction( 'wp_enqueue_scripts', array( $enqueue_manager, 'enqueue' ) );
    }

    /**
     * Enqueue admin stylesheets and scripts into Wordpress via the enqueue manager.
     *
     * Recommend adding stylesheets and scripts via the admin-enqueue config file.
     *
     * The alternative way to add stylesheets and scripts
     *
     * For stylesheets pass the file name, any dependecies (optional) and media type (optional) to enqueueStyles()
     * $admin_enqueue_manager->enqueueStyles( $file, array $dependencies = array(), $media = 'all' );
     *
     * For scripts pass the file name, any dependecies (optional) and whether it should be placed in the head or footer (optional) to enqueueScripts()
     * $admin_enqueue_manager->enqueueScripts( $file, array $dependencies = array(), $in_footer = false );
     *
     * @since  1.1.0
     * @return
     */
    protected function enqueueAdminAssets()
    {
        $admin_enqueue_manager = container()->get( 'admin_enqueue_manager' );
        $admin_enqueue_manager->enqueueConfig();
                            //   ->enqueueStyles( 'another-name-admin', array(), 'all' )
                            //   ->enqueueScripts( 'another-name-admin', array(), true );
        EventManager::addAction( 'admin_enqueue_scripts', array( $admin_enqueue_manager, 'enqueue' ) );
    }

    /**
     * Register installation processes
     *
     * @since  1.0.0
     * @return null
     */
    protected function install()
    {
        $install_class = __NAMESPACE__ . '\Setup\Installation';
        register_activation_hook( PLUGIN_ROOT, array( $install_class, 'activate' ) );
        register_deactivation_hook( PLUGIN_ROOT, array( $install_class, 'deactivate' ) );
        register_uninstall_hook( PLUGIN_ROOT, array( $install_class, 'uninstall' ) );
    }

}
