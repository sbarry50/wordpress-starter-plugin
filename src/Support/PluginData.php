<?php
/**
 * Helper class for retrieving plugin data
 *
 * @package    Vendor\Plugin\Support
 * @since      0.2.0
 * @author     sbarry
 * @link       http://sb2media.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Support;

use Vendor\Plugin\Container\Container;

class PluginData
{
    
    /**
     * Get the plugin's root directory Paths
     *
     * @since 0.2.0
     * @return string
     */
    public static function root()
    {
        return Container::instance('plugin')->plugin_root_file;
    }

    /**
     * Get the plugin's top level namespace
     *
     * @since 0.2.0
     * @return string
     */
    public static function topLevelNamespace()
    {
        return Container::instance('plugin')->namespace;
    }

    /**
     * Get plugin basename
     *
     * @since  0.2.0
     * @return string
     */
    public static function basename()
    {
        return plugin_basename(self::root());
    }

    /**
     * Get plugin data from the plugin's bootstrap file header comment using WP core's get_file_data function
     *
     * @since  0.2.0
     * @param  string    $id    Plugin header data unique id
     * @return array            Array of plugin data from the bootstrap file header comment
     */
    public static function headerData(string $id)
    {
        $default_headers = array(
            'Name' => 'Plugin Name',
            'PluginURI' => 'Plugin URI',
            'Version' => 'Version',
            'Description' => 'Description',
            'Author' => 'Author',
            'AuthorURI' => 'Author URI',
            'TextDomain' => 'Text Domain',
            'DomainPath' => 'Domain Path',
            'Network' => 'Network',
            // Site Wide Only is deprecated in favor of Network.
            '_sitewide' => 'Site Wide Only',
        );

        return get_file_data(self::root(), $default_headers)[$id];
    }
}
