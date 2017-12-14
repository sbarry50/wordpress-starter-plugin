<?php
/**
 * Helper class for retrieving plugin directory URL's
 *
 * @package    Vendor\Plugin\Support
 * @since      0.2.0
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
     * @since 0.2.0
     * @return string
     */
    public static function dirURL()
    {
        $plugin_dir_url = \plugin_dir_url(PluginData::root());
        if (is_ssl()) {
            $plugin_dir_url = str_replace('http://', 'https://', $plugin_dir_url);
        }

        return $plugin_dir_url;
    }

    /**
     * Get assets folder url
     *
     * @since 0.2.0
     * @return string
     */
    public static function assets()
    {
        return self::dirURL() . 'assets/';
    }

    /**
     * Get config folder url
     *
     * @since 0.2.0
     * @return string
     */
    public static function config()
    {
        return self::dirURL() . 'config/';
    }

    /**
     * Get dist folder url
     *
     * @since 0.2.0
     * @return string
     */
    public static function dist()
    {
        return self::dirURL() . 'dist/';
    }
    /**
     * Get lang folder url
     *
     * @since 0.2.0
     * @return string
     */
    public static function lang()
    {
        return self::dirURL() . 'lang/';
    }

    /**
     * Get src folder url
     *
     * @since 0.2.0
     * @return string
     */
    public static function src()
    {
        return self::dirURL() . 'src/';
    }

    /**
     * Get test folder url
     *
     * @since 0.2.0
     * @return string
     */
    public static function test()
    {
        return self::dirURL() . 'test/';
    }

    /**
     * Get views folder url
     *
     * @since 0.2.0
     * @return string
     */
    public static function views()
    {
        return self::dirURL() . 'views/';
    }
}
