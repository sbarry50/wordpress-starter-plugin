<?php
/**
 * Helper class for retrieving plugin data
 *
 * @package    Vendor\Plugin\Support
 * @since      1.1.0
 * @author     sbarry
 * @link       http://sb2media.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Support;

class PluginData
{
    /**
     * Get the plugin's root directory Paths
     *
     * @since 1.1.0
     * @return string
     */
    public static function getPluginRootFile()
    {
        return container()->get( 'plugin' )->plugin_root_file;
    }

    /**
     * Get the plugin's top level namespace
     *
     * @since 1.1.0
     * @return string
     */
    public static function getPluginTopLevelNamespace()
    {
        return container()->get( 'plugin' )->namespace;
    }

    /**
     * Get plugin basename
     *
     * @since  1.1.0
     * @return string
     */
    public static function getPluginBasename()
    {
        return \plugin_basename( self::getPluginRootFile() );
    }


    /**
     * Get plugin data from the plugin's bootstrap file header comment using WP core's get_plugin_data function
     *
     * @since  1.1.0
     * @param  string    $id    Plugin header data unique id
     * @return array            Array of plugin data from the bootstrap file header comment
     */
    public static function getPluginHeaderData( string $id )
    {
        return \get_plugin_data( self::getPluginRootFile() )[ $id ];
    }

}
