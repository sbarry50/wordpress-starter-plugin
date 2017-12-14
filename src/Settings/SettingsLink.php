<?php
/**
 * Class for building the "Settings" link on the WordPress plugin activation page
 *
 * @package    Vendor\Plugin\Settings
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Settings;

use Vendor\Plugin\Config\Config;
use Vendor\Plugin\Container\Container;
use Vendor\Plugin\Config\ConfigInterface;

class SettingsLink
{
    /**
     * "Settings" link URL
     *
     * @var string
     */
    public $settings_url;

    /**
     * Set the "Settings" link URL
     *
     * @since 0.3.0
     * @param string    $settings_url    Settings URL
     */
    public function setSettingsURL(string $settings_url)
    {
        $this->settings_url = $settings_url;

        return $this;
    }

    /**
     * Get the plugin's default "Settings" link URL.
     *
     * @since 0.3.0
     * @param string    $settings_url    Settings URL
     */
    protected function getDefaultSettingsURL()
    {
        $settings_pages = Container::instance('settings_pages');

        if (! empty($settings_pages->pages)) {
            return "admin.php?page={$settings_pages->pages[0]['menu_slug']}";
        }

        switch ($settings_pages->subpages[0]['parent_slug']) {
            case 'Dashboard':
                $url = 'index.php?page=';
                break;
            case 'Posts':
                $url = 'edit.php?page=';
                break;
            case 'Media':
                $url = 'uploads.php?page=';
                break;
            case 'Pages':
                $url = 'edit.php?post_type=page&page=';
                break;
            case 'Comments':
                $url = 'edit-comments.php?page=';
                break;
            case 'Appearance':
                $url = 'themes.php?page=';
                break;
            case 'Plugins':
                $url = 'plugins.php?page=';
                break;
            case 'Users':
                $url = 'users.php?page=';
                break;
            case 'Tools':
                $url = 'tools.php?page=';
                break;
            case 'Settings':
                $url = 'options-general.php?page=';
                break;
            default:
                $url = 'admin.php';
                break;
        }

        return $url . $settings->subpages[0]['menu_slug'];
    }

    /**
     * Add a "Settings" links to the plugin listing on the WordPress plugin activation page
     *
     * @since  0.3.0
     * @param  array    $links       Links under each plugin listing on the WordPress activation page
     * @return array    $links       Links under each plugin listing on the WordPress activation page
     */
    public function createSettingsLink($links)
    {
        if (! empty($this->settings_url)) {
            $url = $this->settings_url;
        } else {
            $url = $this->getDefaultSettingsURL();
        }

        $settings_link = "<a href=\"{$url}\">Settings</a>";
        array_push($links, $settings_link);
        return $links;
    }
}
