<?php
/**
 * Enqueue Contract
 *
 * CSS and Javascript files can either be enqueued via a configuration file, with the enqueueStyles() and enqueueScripts() methods or both.
 *
 * @package    SB2Media\Hub\Enqueue
 * @since      0.1.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Hub\Enqueue;

use SB2Media\Hub\Config\ConfigInterface;

interface EnqueueManagerInterface
{
    /**
     * Enqueue the collection of stylesheets and scripts into WordPress. Callback function to hook into 'wp_enqueue_scripts' and 'admin_enqueue_scripts'.
     *
     * @since  0.1.0
     * @return null
     */
    public function enqueue();

    /**
     * Parse the configuration file and add it to stylesheets and scripts arrays
     *
     * @since  0.2.0
     * @return EnqueueManager
     */
    public function enqueueConfig();

    /**
     * Add a new stylesheet into the collection of stylesheets to enqueue
     *
     * @since  0.1.0
     * @param  string    $file_name         Name of the stylesheet to be enqueued
     * @param  array     $dependencies (Optional) Array of registered stylesheet handles this stylesheet depends on
     * @param  string    $media        (Optional) The media for which this stylesheet has been defined. Accepts media types like 'all', 'print' and 'screen'
     * @return EnqueueManager
     */
    public function enqueueStyles($file_name, array $dependencies = array(), $media = 'all');

    /**
     * Add a new script into the collection of scripts to enqueue
     *
     * @since  0.1.0
     * @param  string    $file_name         Name of the script to be enqueued
     * @param  array     $dependencies (Optional) Array of registered script handles this scripts depends on
     * @param  bool      $in_footer    (Optional) Whether to enqueue the script in the head or the footer
     * @return EnqueueManager
     */
    public function enqueueScripts($file_name, array $dependencies = array(), $in_footer = false);
}
