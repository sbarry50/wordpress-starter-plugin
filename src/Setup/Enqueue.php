<?php
/**
 * Class enqueues stylesheets and scripts.
 *
 * @package    Plugin
 * @subpackage Plugin/src
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Setup;

use Vendor\Plugin\EventManagement\SubscriberInterface;
use Vendor\Plugin\Constants as Constants;

class EnqueueManager implements SubscriberInterface
{
    /**
     * Collection of stylesheets
     *
     * @var array
     */
    public $stylesheets;

    /**
     * Collection of scripts
     *
     * @var 1.0.0
     */
    public $scripts;

    /**
     * Constructor
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->stylesheets = array();
        $this->scripts = array();
    }

    /**
     * Returns an array of events that this subscriber wants to listen to.
     *
     * The array key is the event name. The value can be:
     *
     *  * The method name
     *  * An array with the method name and priority
     *  * An array with the method name, priority and number of accepted arguments
     *
     * For instance:
     *
     *  * array('event_name' => 'method_name')
     *  * array('event_name' => array('method_name', $priority))
     *  * array('event_name' => array('method_name', $priority, $accepted_args))
     *
     * @return array
     */
    public static function get_subscribed_events()
    {
        return array(
            'wp_enqueue_scripts' => 'enqueue'
        );
    }

    /**
     * Enqueue the collection of stylesheets and scripts into WordPress
     *
     * @since  1.0.0
     * @return null
     */
    public function enqueue()
    {
        if ( ! empty($this->stylesheets) ) {
            foreach( $this->stylesheets as $stylesheet ) {
                \wp_enqueue_style(
                    Constants\PLUGIN_TEXT_DOMAIN . "/{$stylesheet['file_name']}.css",
                    Constants\PLUGIN_DIST_PATH . "css/{$stylesheet['file_name']}.css",
                    $stylesheet['dependencies'],
                    Constants\PLUGIN_VERSION,
                    $stylesheet['media']
                );
            }
        }

        if ( ! empty($this->scripts) ) {
            foreach( $this->scripts as $script ) {
                \wp_enqueue_script(
                    Constants\PLUGIN_TEXT_DOMAIN . "/{$script['file_name']}.js",
                    Constants\PLUGIN_DIST_PATH . "js/{$script['file_name']}.js",
                    $script['dependencies'],
                    Constants\PLUGIN_VERSION,
                    $script['in_footer']
                );
            }
        }
    }

    /**
     * Add a new stylesheet into the collection of stylesheets to enqueue
     *
     * @since  1.0.0
     * @param  string    $file         Name of the stylesheet to be enqueued
     * @param  array     $dependencies Array of registered stylesheet handles this stylesheet depends on
     * @param  string    $media        The media for which this stylesheet has been defined. Accepts media types like 'all', 'print' and 'screen'
     * @return null
     */
    public function enqueue_styles( $file, array $dependencies = array(), $media = 'all' ) {
        $this->stylesheets = $this->add_stylesheet( $this->stylesheets, $file, $dependencies, $media );
    }


    /**
     * Add a new script into the collection of scripts to enqueue
     *
     * @since  1.0.0
     * @param  string    $file         Name of the script to be enqueued
     * @param  array     $dependencies Array of registered script handles this scripts depends on
     * @param  bool      $in_footer    Whether to enqueue the script in the head or the footer
     * @return null
     */
    public function enqueue_scripts( $file, array $dependencies = array(), $in_footer = false ) {
        $this->scripts = $this->add_script( $this->scripts, $file, $dependencies, $in_footer );
    }

    /**
     * Utility function to add stylesheets into a single collection.
     *
     * @since  1.0.0
     * @param  array     $stylesheets  The collection of stylesheets to enqueue
     * @param  string    $file         Name of the stylesheet to be enqueued
     * @param  array     $dependencies Array of registered stylesheet handles this stylesheet depends on
     * @param  string    $media        The media for which this stylesheet has been defined. Accepts media types like 'all', 'print' and 'screen'
     */
    protected function add_stylesheet( $stylesheets, $file, array $dependencies = array(), $media = 'all' )
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
     * @since  1.0.0
     * @param  array     $scripts      The collection of scripts to enqueue
     * @param  string    $file         Name of the script to be enqueued
     * @param  array     $dependencies Array of registered script handles this script depends on
     * @param  bool      $in_footer    Whether to enqueue the script in the head or the footer
     */
    protected function add_script( $scripts, $file, $dependencies, $in_footer )
    {
        $scripts[] = array(
            'file_name'    => $file,
            'dependencies' => $dependencies,
            'in_footer'    => $in_footer
        );

        return $scripts;
    }
}
