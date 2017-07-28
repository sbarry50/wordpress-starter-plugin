<?php
/**
 * An event subscriber who can use the WordPress plugin API manager to
 * trigger additional event.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */

namespace Vendor\Plugin\EventManagement;

interface PluginAPIManagerAwareSubscriberInterface extends SubscriberInterface
{
    /**
     * Set the WordPress Plugin API manager for the subscriber.
     *
     * @param PluginAPIManager $plugin_api_manager
     */
    public function set_plugin_api_manager(PluginAPIManager $plugin_api_manager);
}
