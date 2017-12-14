<?php
/**
 * Configuration Contract
 *
 * @package    Vendor\Plugin\Config
 * @since      0.1.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

 /**
  * This interface has been adapted from Tonya Mork's Fulcrum plugin which has a GPL v2 license.
  */

namespace Vendor\Plugin\Config;

interface ConfigInterface
{
    /**
     * Retrieves all of the runtime configuration parameters
     *
     * @since 0.1.0
     *
     * @return array
     */
    public function all();

    /**
     * Get the specified configuration value.
     *
     * @param  string  $parameter_key
     * @param  mixed   $default
     * @return mixed
     */
    public function get($parameter_key, $default = null);

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string  $parameter_key
     * @return bool
     */
    public function has($parameter_key);

    /**
     * Push a configuration in via the key
     *
     * @since 0.1.0
     *
     * @param string $parameter_key Key to be assigned, which also becomes the property
     * @param mixed  $value         Value to be assigned to the parameter key
     * @return null
     */
    public function push($parameter_key, $value);
}
