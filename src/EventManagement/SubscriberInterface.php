<?php
/**
 * A Subscriber knows what specific WordPress events it wants to listen to.
 *
 * When an EventManager adds a Subscriber, it gets all the WordPress events that
 * it wants to listen to. It then adds the subscriber as a listener for each of them.
 *
 * @package    Vendor\Plugin\EventManagement
 * @since      1.0.0
 * @author     Carl Alexander <contact@carlalexander.ca>
 * @link       http://carlalexander.ca
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\EventManagement;

interface SubscriberInterface
{
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
    public static function getSubscribedEvents();
}
