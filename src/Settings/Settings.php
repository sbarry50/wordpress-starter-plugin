<?php
/**
 * Class for interacting with the WordPress Settings API
 *
 *
 * @package    Vendor\Plugin\Settings
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

class Settings
{
    /**
     * Add a "Settings" links to the plugin listing on the WordPress plugin activation page
     *
     * @since  0.3.0
     * @param  array    $links       Links under each plugin listing on the WordPress activation page
     * @return array    $links       Links under each plugin listing on the WordPress activation page
     */
    public function settingsLink( $links )
    {
        $settings_link = '<a href="admin.php?page=wp_starter_plugin">Settings</a>';
        array_push( $links, $settings_link );
        return $links;
    }
}
