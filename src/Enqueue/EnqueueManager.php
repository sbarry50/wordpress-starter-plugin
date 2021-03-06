<?php
/**
 * Abstract class that enqueues stylesheets and scripts.
 *
 * @package    SB2Media\Hub\Enqueue
 * @since      0.1.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Hub\Enqueue;

use SB2Media\Hub\Config\ConfigInterface;
use SB2Media\Hub\Setup\PluginData;
use SB2Media\Hub\Events\EventManager;
use SB2Media\Hub\Support\URLs;
use const SB2Media\Hub\PLUGIN_VERSION;

class EnqueueManager implements EnqueueManagerInterface
{
    /**
     * Enqueue configuration
     *
     * @var ConfigInterface
     */
    public $config;

    /**
     * Plugin Data
     *
     * @var PluginData
     */
    public $plugin_data;

    /**
     * Collection of stylesheets
     *
     * @var array
     */
    public $stylesheets;

    /**
     * Collection of scripts
     *
     * @var 0.1.0
     */
    public $scripts;

    /**
     * Constructor
     *
     * @since 0.1.0
     */
    public function __construct(ConfigInterface $config, PluginData $plugin_data)
    {
        $this->config = $config;
        $this->plugin_data = $plugin_data;
        $this->stylesheets = array();
        $this->scripts = array();
    }

    /**
     * Enqueue the collection of stylesheets and scripts into WordPress. Callback function to hook into 'wp_enqueue_scripts' and 'admin_enqueue_scripts'.
     *
     * @since  0.1.0
     * @return null
     */
    public function enqueue()
    {
        if (! empty($this->stylesheets)) {
            foreach ($this->stylesheets as $stylesheet) {
                \wp_enqueue_style(
                    "{$stylesheet['file_name']}",
                    $this->plugin_data->url('dist') . "css/{$stylesheet['file_name']}.css",
                    $stylesheet['dependencies'],
                    $this->plugin_data->plugin_version,
                    $stylesheet['media']
                );
            }
        }

        if (! empty($this->scripts)) {
            foreach ($this->scripts as $script) {
                \wp_enqueue_script(
                    "{$script['file_name']}",
                    $this->plugin_data->url('dist') . "js/{$script['file_name']}.js",
                    $script['dependencies'],
                    $this->plugin_data->plugin_version,
                    $script['in_footer']
                );
            }
        }
    }

    /**
     * Parse the configuration file and add it to stylesheets and scripts arrays
     *
     * @since  0.2.0
     * @param  ConfigInterface    $this->config
     */
    public function enqueueConfig()
    {
        if ($this->config->has('stylesheets')) {
            $stylesheets = $this->config->get('stylesheets');

            foreach ($stylesheets as $stylesheet) {
                $this->enqueueStyles($stylesheet[ 'file_name' ], $stylesheet[ 'dependencies' ], $stylesheet[ 'media' ]);
            }
        }

        if ($this->config->has('scripts')) {
            $scripts = $this->config->get('scripts');

            foreach ($scripts as $script) {
                $this->enqueueScripts($script[ 'file_name' ], $script[ 'dependencies' ], $script[ 'in_footer' ]);
            }
        }

        return $this;
    }

    /**
     * Add a new stylesheet into the collection of stylesheets to enqueue
     *
     * @since  0.1.0
     * @param  string    $file         Name of the stylesheet to be enqueued
     * @param  array     $dependencies (Optional) Array of registered stylesheet handles this stylesheet depends on
     * @param  string    $media        (Optional) The media for which this stylesheet has been defined. Accepts media types like 'all', 'print' and 'screen'
     * @return null
     */
    public function enqueueStyles($file, array $dependencies = array(), $media = 'all')
    {
        $this->stylesheets = $this->addStylesheet($this->stylesheets, $file, $dependencies, $media);

        return $this;
    }

    /**
     * Add a new script into the collection of scripts to enqueue
     *
     * @since  0.1.0
     * @param  string    $file         Name of the script to be enqueued
     * @param  array     $dependencies (Optional) Array of registered script handles this scripts depends on
     * @param  bool      $in_footer    (Optional) Whether to enqueue the script in the head or the footer
     * @return null
     */
    public function enqueueScripts($file, array $dependencies = array(), $in_footer = false)
    {
        $this->scripts = $this->addScript($this->scripts, $file, $dependencies, $in_footer);

        return $this;
    }

    /**
     * Utility function to add stylesheets into a single collection.
     *
     * @since  0.1.0
     * @param  array     $stylesheets  The collection of stylesheets to enqueue
     * @param  string    $file         Name of the stylesheet to be enqueued
     * @param  array     $dependencies Array of registered stylesheet handles this stylesheet depends on
     * @param  string    $media        The media for which this stylesheet has been defined. Accepts media types like 'all', 'print' and 'screen'
     */
    protected function addStylesheet($stylesheets, $file, array $dependencies = array(), $media = 'all')
    {
        $stylesheets[] = array(
            'file_name'    => $file,
            'dependencies' => $dependencies,
            'media'        => $media
        );

        return $stylesheets;
    }

    /**
     * Utility function to add scripts into a single collection.
     *
     * @since  0.1.0
     * @param  array     $scripts      The collection of scripts to enqueue
     * @param  string    $file         Name of the script to be enqueued
     * @param  array     $dependencies Array of registered script handles this script depends on
     * @param  bool      $in_footer    Whether to enqueue the script in the head or the footer
     */
    protected function addScript($scripts, $file, $dependencies, $in_footer)
    {
        $scripts[] = array(
            'file_name'    => $file,
            'dependencies' => $dependencies,
            'in_footer'    => $in_footer
        );

        return $scripts;
    }
}
