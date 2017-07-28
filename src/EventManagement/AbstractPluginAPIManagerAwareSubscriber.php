<?php
/**
 * An event subscriber who stores an instance of the WordPress plugin API
 * manager so that it can trigger additional events.
 *
 * @author Carl Alexander <contact@carlalexander.ca>
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
    public function set_plugin_api_manager(PluginAPIManager $plugin_api_manager)
    {
        $this->plugin_api_manager = $plugin_api_manager;
    }
}
