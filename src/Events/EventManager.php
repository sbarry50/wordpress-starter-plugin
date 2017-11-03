<?php
/**
 * The WordPress event manager wrapper for NetRivet's Wordpress EventEmitter Interface.
 *
 * @package    Vendor\Plugin\Events
 * @since      1.1.0
 * @author     sbarry
 * @link       http://sb2media.com
 * @license    GNU General Public License 2.0+
 */

 /**
  * This class has been adapted from Josh Pollack's tutorial on Using Pimple as a Service Container in WordPress Development.
  * @link https://torquemag.io/2017/10/using-pimple-service-container-wordpress-development/
  */

namespace Vendor\Plugin\Events;

use NetRivet\WordPress\EventEmitterInterface;

class EventManager {

	/**
	 * Add an action to an event hook through the WordPress Plugin API
	 *
	 * @since 1.1.0
	 * @param string $event           The event hook
	 * @param        $function_to_add The function to add to the event hook
	 * @param int    $priority        Used to specify the order in which the functions associated with a particular action are executed.
	 * @param int    $acceptedArgs    The number of arguments the function accepts.
	 *
	 * @return EventEmitterInterface
	 */
	public static function addAction( string $event, $function_to_add, int $priority = 10, int $acceptedArgs = 1 ) : EventEmitterInterface
	{
		return self::getEventManager()->on( $event, $function_to_add, $priority, $acceptedArgs );
	}

	/**
	 * Add a filter through the WordPress Plugin API
	 *
	 * @since 1.1.0
	 * @param string $name            The name of the filter
	 * @param        $function_to_add The callback function to be run when the filter is applied.
	 * @param int    $priority        Used to specify the order in which the functions associated with a particular action are executed.
	 * @param int    $acceptedArgs    The number of arguments the function accepts.
	 * @return EventEmitterInterface
	 */
	public static function addFilter( string $name, $function_to_add, int $priority = 10, int $acceptedArgs = 1 ) : EventEmitterInterface
	{
		return self::getEventManager()->filter( $name, $function_to_add, $priority, $acceptedArgs );
	}

	/**
	 * Remove an action from an event hook already registered through the WordPress Plugin API
	 *
	 * @since  1.1.0
	 * @param string $event           The event hook
	 * @param        $function_to_add The function to add to the event hook
	 * @param int    $priority        Used to specify the order in which the functions associated with a particular action are executed.
	 * @param int    $acceptedArgs    The number of arguments the function accepts.
	 * @return EventEmitterInterface
	 */
	public static function removeAction( string $event, $function_to_remove, $priority = 10 ) : EventEmitterInterface
	{
		return self::getEventManager()->off( $event, $function_to_remove, $priority );
	}

    /**
     * Get an instance of the Event Emitter class
     *
     * @since  1.1.0
     * @param  string    $id   Name of the instance to retrieve
     * @return EventEmitterInterface
     */
    public static function getEventManager() : EventEmitterInterface
    {
        return container()->get( 'events' );
    }

}
