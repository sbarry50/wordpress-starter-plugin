<?php

/**
 * Configuration factory
 *
 * @package    Vendor\Plugin\Config
 * @since      1.0.0
 * @author     hellofromTonya, Alain Schlesser, Gary Jones
 * @link       https://UpTechLabs.io
 * @license    GNU General Public License 2.0+
 */

 /**
  * This class has been adapted from Tonya Mork's Fulcrum plugin which has a GPL v2 license.
  */

 namespace Vendor\Plugin\Config;

class ConfigFactory
{
	/**
	 * Load and return the Config object
	 *
	 * @since  1.0.0
	 * @param  string|array $config     File path and filename to the config array; or it is the configuration array.
	 * @param  string|array $defaults   Specify a defaults array, which is then merged together with the initial config array before creating the object.
	 * @return Returns the Config object
	 */
	public static function create( $config, $defaults = '' )
    {
		return new Config( $config, $defaults );
	}
}
