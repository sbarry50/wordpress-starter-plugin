<?php
/**
 * The WordPress event manager manages events using the WordPress plugin API.
 *
 * @package    Vendor\Plugin\EventManagement
 * @since      1.0.0
 * @author     Carl Alexander <contact@carlalexander.ca>
 * @link       http://carlalexander.ca
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\EventManagement;

class EventManager
{

    /**
     * The WordPress plugin API manager.
     *
     * @var PluginAPIManager
     */
    private $plugin_api_manager;

    /**
     * Constructor.
     *
     * @param PluginAPIManager $plugin_api_manager
     */
    public function __construct(PluginAPIManager $plugin_api_manager)
    {
        $this->plugin_api_manager = $plugin_api_manager;
    }

    /**
     * Adds the given event listener to the list of event listeners
     * that listen to the given event.
     *
     * @param string   $event_name
     * @param callable $listener
     * @param int      $priority
     * @param int      $accepted_args
     */
    public function addListener($event_name, $listener, $priority = 10, $accepted_args = 1)
    {
        $this->plugin_api_manager->addCallback($event_name, $listener, $priority, $accepted_args);
    }

    /**
     * Adds an event subscriber.
     *
     * The event manager adds the given subscriber to the list of event listeners
     * for all the events that it wants to listen to.
     *
     * @param SubscriberInterface $subscriber
     */
    public function addSubscriber(SubscriberInterface $subscriber)
    {
        if ($subscriber instanceof PluginAPIManagerAwareSubscriberInterface) {
            $subscriber->setPluginAPIManager($this->plugin_api_manager);
        }

        foreach ($subscriber->getSubscribedEvents() as $event_name => $parameters) {
            $this->addSubscriberListener($subscriber, $event_name, $parameters);
        }

    }

    /**
     * Removes the given event listener from the list of event listeners
     * that listen to the given event.
     *
     * @param string   $event_name
     * @param callable $listener
     * @param int      $priority
     */
    public function removeListener($event_name, $listener, $priority = 10)
    {
        $this->plugin_api_manager->removeCallback($event_name, $listener, $priority);
    }

    /**
     * Removes an event subscriber.
     *
     * The event manager removes the given subscriber from the list of event listeners
     * for all the events that it wants to listen to.
     *
     * @param SubscriberInterface $subscriber
     */
    public function remove_subscriber(SubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $event_name => $parameters) {
            $this->removeSubscriberListener($subscriber, $event_name, $parameters);
        }
    }

    /**
     * Adds the given subscriber listener to the list of event listeners
     * that listen to the given event.
     *
     * @param SubscriberInterface $subscriber
     * @param string              $event_name
     * @param mixed               $parameters
     */
    private function addSubscriberListener(SubscriberInterface $subscriber, $event_name, $parameters)
    {
        if (is_string($parameters)) {
            $this->addListener($event_name, array($subscriber, $parameters));
        } elseif (is_array($parameters) && isset($parameters[0])) {
            $this->addListener($event_name, array($subscriber, $parameters[0]), isset($parameters[1]) ? $parameters[1] : 10, isset($parameters[2]) ? $parameters[2] : 1);
        }
    }

    /**
     * Adds the given subscriber listener to the list of event listeners
     * that listen to the given event.
     *
     * @param SubscriberInterface $subscriber
     * @param string              $event_name
     * @param mixed               $parameters
     */
    private function removeSubscriberListener(SubscriberInterface $subscriber, $event_name, $parameters)
    {
        if (is_string($parameters)) {
            $this->removeListener($event_name, array($subscriber, $parameters));
        } elseif (is_array($parameters) && isset($parameters[0])) {
            $this->removeListener($event_name, array($subscriber, $parameters[0]), isset($parameters[1]) ? $parameters[1] : 10);
        }
    }
}
