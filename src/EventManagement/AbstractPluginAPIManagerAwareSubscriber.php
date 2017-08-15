<?php
/**
 * An event subscriber who stores an instance of the WordPress plugin API
 * manager so that it can trigger additional events.
 *
 * @package    Vendor\Plugin\EventManagement
 * @since      1.0.0
 * @author     Carl Alexander <contact@carlalexander.ca>
 * @link       http://carlalexander.ca
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\EventManagement;

abstract class AbstractPluginAPIManagerAwareSubscriber implements PluginAPIManagerAwareSubscriberInterface
{

    /**
     * WordPress Plugin API manager.
     *
     * @var PluginAPIManager
     */
    protected $plugin_api_manager;

    /**
     * Set the WordPress Plugin API manager for the subscriber.
     *
     * @param PluginAPIManager $plugin_api_manager
     */
    public function setPluginAPIManager(PluginAPIManager $plugin_api_manager)
    {
        $this->plugin_api_manager = $plugin_api_manager;
    }
}
