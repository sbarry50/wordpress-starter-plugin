<?php
/**
 * Admin controller
 *
 *
 * @package    Vendor\Plugin\Controller
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Controller;

use Vendor\Plugin\Config\Config;
use Vendor\Plugin\Events\EventManager;
use Vendor\Plugin\Controller\Controller;
use Vendor\Plugin\Config\ConfigInterface;

use const Vendor\Plugin\PLUGIN_BASENAME;

class AdminController extends Controller
{
    /**
     * Admin settings configuration parameters
     *
     * @var ConfigInterface
     */
    public $config;

    /**
     * Set the configuration object and parse the admin configuration into their respective arrays for pages, subpages, settings, sections and fields.
     *
     * @since  0.3.0
     * @param  ConfigInterface    $config
     * @return
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Load the admin pages, settings and settings link
     *
     * @since  0.3.0
     * @return
     */
    public function load()
    {
        $this->addAdminSettings();
        $this->registerSettingsLink();
    }

    /**
     * Add the Admin pages configuration and register them with WordPress
     *
     * @since 0.3.0
     * @return
     */
    protected function addAdminSettings()
    {
        $settings_pages = $this->container->get('settings_pages');
        $settings_pages->setPages($this->config['pages'])
                       ->withSubPage('Dashboard')
                       ->setSubPages($this->config['subpages']);

        if (! empty($settings_pages->pages) || ! empty($settings_pages->subpages)) {
            EventManager::addAction('admin_menu', array($settings_pages, 'createAdminPages'));
        }

        $settings_api = $this->container->get('settings_api');
        $settings_api->setSections($this->config['sections'])
                     ->setSettings($this->config['settings']);

        if (! empty($settings_api->settings)) {
            EventManager::addAction('admin_init', array($settings_api, 'registerSettings'));
        }
    }

    /**
     * Register the "Settings" link on the plugin activation page with WordPress
     *
     * @since  0.3.0
     * @return
     */
    protected function registerSettingsLink()
    {
        $settings_link = $this->container->get('settings_link');
        $settings_link->setSettingsURL($this->config['settings_url']);
        EventManager::addFilter('plugin_action_links_' . PLUGIN_BASENAME, array($settings_link, 'createSettingsLink'));
    }
}
