<?php
/**
 * Helper class for fetching folder paths
 *
 * @package    Vendor\Plugin\Support
 * @since      1.1.0
 * @author     sbarry
 * @link       http://sb2media.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Support;

use Vendor\Plugin\Support\PluginData;

class Paths
{

    /**
     * Get the plugin's root directory Paths
     *
     * @since 1.1.0
     * @return string
     */
    public static function getPluginDirPath()
    {
        if ( ! function_exists( 'plugin_dir_path' ) ) {
            require_once ABSPATH . '/wp-admin/includes/plugin.php';
        }

        return \plugin_dir_path( PluginData::getPluginRootFile() );
    }

    /**
     * Get assets folder path
     *
     * @since 1.1.0
     * @return string
     */
    public static function getAssetsPath()
    {
        return self::getPluginDirPath() . 'assets/';
    }

    /**
     * Get config folder path
     *
     * @since 1.1.0
     * @return string
     */
    public static function getConfigPath()
    {
        return self::getPluginDirPath() . 'config/';
    }

    /**
     * Get dist folder path
     *
     * @since 1.1.0
     * @return string
     */
    public static function getDistPath()
    {
        return self::getPluginDirPath() . 'dist/';
    }
    /**
     * Get lang folder path
     *
     * @since 1.1.0
     * @return string
     */
    public static function getLangPath()
    {
        return self::getPluginDirPath() . 'lang/';
    }

    /**
     * Get src folder path
     *
     * @since 1.1.0
     * @return string
     */
    public static function getSrcPath()
    {
        return self::getPluginDirPath() . 'src/';
    }

    /**
     * Get test folder path
     *
     * @since 1.1.0
     * @return string
     */
    public static function getTestPath()
    {
        return self::getPluginDirPath() . 'test/';
    }

    /**
     * Get views folder path
     *
     * @since 1.1.0
     * @return string
     */
    public static function getViewsPath()
    {
        return self::getPluginDirPath() . 'views/';
    }
    
}
