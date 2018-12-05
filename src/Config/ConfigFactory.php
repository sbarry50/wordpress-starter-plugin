<?php

/**
 * Configuration factory
 *
 * @package    SB2Media\Hub\Config
 * @since      0.1.0
 * @author     sbarry
 * @link       https://example.com
 * @license    GNU General Public License 2.0+
 */

 /**
  * This class has been adapted from Tonya Mork's Fulcrum plugin which has a GPL v2 license.
  */

namespace SB2Media\Hub\Config;

use SB2Media\Hub\File\Loader;
use SB2Media\Hub\Container\Container;
use function SB2Media\Hub\container as container;

class ConfigFactory
{
    /**
     * Instantiate the plugin configuration objects
     *
     * @param string    $subdir    Optional. If registering configs from a subdirectory
     * @since 0.3.0
     * @return void
     */
    public static function initConfigs($plugin_id, $plugin_root_file, string $subdir = '', string $class = 'SB2Media\Hub\Config\Config')
    {
        $config_dir_path = plugin_dir_path($plugin_root_file) . 'config/';
        $config_dir_path = !empty($subdir) ? $config_dir_path . $subdir . '/' : $config_dir_path;
        $config_dir = scandir($config_dir_path);
        $config_files = self::filterConfigDir($config_dir);
        $config_ids = [];

        foreach ($config_files as $config_id => $config_file) {
            $config_file = $config_dir_path . $config_file;
            $config_id = Container::id($plugin_id, $config_id, $subdir, true);
            $config = Loader::loadFile($config_file);
            if (array_key_exists('defaults', $config)) {
                self::create($config_id, $config, $class, $config['defaults']);
            } else {
                self::create($config_id, $config, $class);
            }
            array_push($config_ids, $config_id);
        }

        $collection = !empty($subdir) ? "{$plugin_id}-{$subdir}-config" : "{$plugin_id}-config";
        container()->setCollection($collection, $config_ids);
    }

    /**
     * Load and return the Config object
     *
     * @since  0.1.0
     * @param  string       $plugin_id  The plugin id
     * @param  string       $config_id  The config id
     * @param  string|array $config     The config array.
     * @param  string       $class      Fully qualified namespaced class
     * @param  string|array $defaults   Specify a defaults array, which is then merged together with the initial config array 
     *                                  before creating the object.
     * @return Config Returns the Config object
     */
    
    public static function create(string $id, $config, string $class = 'SB2Media\Hub\Config\Config', $defaults = '')
    {
        if (!empty($defaults)) {
            Container::setInstance($id, new $class($config, $defaults));
        } else {
            Container::setInstance($id, new $class($config));
        }
    }


    /**
     * Filter out unwanted files from the config directory
     *
     * @since 0.5.0
     * @param array $config_dir
     * @return array
     */
    protected static function filterConfigDir(array $config_dir)
    {
        foreach ($config_dir as $key => $value) {
            if (in_array($value, array('.','..','index.php')) || strpos($value, '.php') == false) {
                unset($config_dir[$key]);
            }
        }

        foreach ($config_dir as $config_file) {
            $config_id = str_replace('.php', '', $config_file);
            $config[$config_id] = $config_file;
        }

        return $config;
    }
}
