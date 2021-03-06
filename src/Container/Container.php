<?php
/**
 * Dependency injection container class which extends Pimple
 *
 * @package    SB2Media\Hub\Container
 * @since      0.2.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Hub\Container;

use SB2Media\Hub\File\Loader;
use SB2Media\Hub\Config\Config;
use SB2Media\Hub\Support\Paths;
use Pimple\Container as Pimple;

class Container extends Pimple implements ContainerInterface
{
    /**
     * Instance of Container
     *
     * @var Container
     */
    public static $instance;

    /**
     * Collection of config keys
     *
     * @since 0.5.0
     * @var array
     */
    public $collection = [];

    /**
     * Contructor
     *
     * @since 0.3.0
     */
    public function __construct()
    {
        self::$instance = $this;
    }

    /**
     * Get instance of Container
     *
     * @since    0.3.0
     * @param    string    $plugin_id   The unique identifier for the plugin
     * @param    string    $id          The unique identifier for the parameter or object
     * @return   Container
     */
    public static function getInstance(string $id)
    {
        return self::$instance->get($id);
    }

    /**
     * Set instance of Container
     *
     * @since    0.5.0
     * @param    string    $plugin_id   The unique identifier for the plugin
     * @param    string    $id          The unique identifier for the parameter or object
     * @param    mixed     $value
     */
    public static function setInstance(string $id, $value)
    {
        return self::$instance->set($id, $value);
    }

    /**
     * Get item from container
     *
     * @since    0.3.0
     * @param    string    $plugin_id   The unique identifier for the plugin
     * @param    string    $id          The unique identifier for the parameter or object
     * @return   mixed
     */
    public function get(string $id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Set item in container
     *
     * @param    string    $plugin_id   The unique identifier for the plugin
     * @param    string    $id          The unique identifier for the parameter or object
     * @param mixed  $value
     */
    public function set(string $id, $value)
    {
        return $this->offsetSet($id, $value);
    }

    /**
     * Checks if a parameter or an object is set.
     *
     * @since 0.1.0
     *
     * @param    string    $plugin_id   The unique identifier for the plugin
     * @param    string    $id          The unique identifier for the parameter or object
     * @return   bool
     */
    public function has(string $id)
    {
        return $this->offsetExists($id);
    }

    /**
     * Set the collection
     *
     * @since 0.5.0
     * @param string $collection_key
     * @param array $collection_id
     * @return void
     */
    public function setCollection(string $collection_key, array $collection_id)
    {
        $this->collection[$collection_key] = $collection_id;
    }

    /**
     * Get the config keys
     *
     * @since 0.5.0
     * @param string $key
     * @return void
     */
    public function getCollection(string $collection_key)
    {
        return $this->collection[$collection_key];
    }

    /**
     * Build and return the full unique identifier for the parameter or object
     *
     * @since 0.5.0
     * @param    string    $plugin_id   The unique identifier for the plugin
     * @param    string    $id          The unique identifier for the parameter or object
     * @return   string
     */
    public static function id(string $plugin_id, string $object_id = '', string $subdir = '', bool $config = false)
    {
        if (empty($plugin_id) && empty($id)) {
            return;
        }

        if (!empty($plugin_id)) {
            $id = $plugin_id;
        }

        if (!empty($object_id)) {
            $id .= "-{$object_id}";
        }

        if (!empty($subdir)) {
            $id .= "-{$subdir}";
        }

        if ($config) {
            $id .= "-config";
        }
        
        return $id;
    }

    /**
     * Set item in container with Config dependency
     *
     * @since 0.2.0
     * @param string    $id          The unique identifier for the parameter or object
     * @param string    $class       Fully qualified class name to instantiate
     * @param string    $config_file The name of the config file
     * @param boolean   $setter      (Optional) Constructor or setter injection
     * @param array     $params      (Optional) Array of parameters to pass to the class
     */
    public function setWithConfig(string $id, $class, $config_file, $setter = false, $params = [])
    {
        $file = Paths::config() . "{$config_file}.php";

        if (! Loader::isFileValid($file)) {
            return;
        }

        $config_id = str_replace('-', '_', $config_file) . '_config';
        $this->set($config_id, new Config($file));

        if (! empty($params) && $setter) {
            $this->set($id, new $class(...$params));
            return $this[ $id ]->setConfig($this[ $config_id ]);
        } elseif ($setter) {
            $this->set($id, new $class());
            return $this[ $id ]->setConfig($this[ $config_id ]);
        } elseif (! empty($params)) {
            array_unshift($params, $this[ $config_id ]);
            return $this->set($id, new $class(...$params));
        } else {
            return $this->set($id, new $class($this[ $config_id ]));
        }
    }
}
