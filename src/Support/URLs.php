<?php
/**
 * Helper class for retrieving plugin directory URL's
 *
 * @package    Vendor\Plugin\Support
 * @since      1.1.0
 * @author     sbarry
 * @link       http://sb2media.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Support;

use Vendor\Plugin\Support\PluginData;

class URLs
{
    /**
     * Get the plugin's root directory Paths
     *
     * @since 1.1.0
     * @return string
     */
    public static function getPluginDirURL()
    {
        $plugin_dir_url = \plugin_dir_url( PluginData::getPluginRootFile() );
        if ( is_ssl() ) {
            $plugin_dir_url = str_replace( 'http://', 'https://', $plugin_dir_url );
        }

        return $plugin_dir_url;
    }

    /**
     * Get assets folder url
     *
     * @since 1.1.0
     * @return string
     */
    public static function getAssetsURL()
    {
        return self::getPluginDirURL() . 'assets/';
    }

    /**
     * Get config folder url
     *
     * @since 1.1.0
     * @return string
     */
    public static function getConfigURL()
    {
        return self::getPluginDirURL() . 'config/';
    }

    /**
     * Get dist folder url
     *
     * @since 1.1.0
     * @return string
     */
    public static function getDistURL()
    {
        return self::getPluginDirURL() . 'dist/';
    }
    /**
     * Get lang folder url
     *
     * @since 1.1.0
     * @return string
     */
    public static function getLangURL()
    {
        return self::getPluginDirURL() . 'lang/';
    }

    /**
     * Get src folder url
     *
     * @since 1.1.0
     * @return string
     */
    public static function getSrcURL()
    {
        return self::getPluginDirURL() . 'src/';
    }

    /**
     * Get test folder url
     *
     * @since 1.1.0
     * @return string
     */
    public static function getTestURL()
    {
        return self::getPluginDirURL() . 'test/';
    }

    /**
     * Get views folder url
     *
     * @since 1.1.0
     * @return string
     */
    public static function getViewsURL()
    {
        return self::getPluginDirURL() . 'views/';
    }

}
