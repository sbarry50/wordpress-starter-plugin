<?php
/**
 * WordPress Settings API class handler
 *
 * @package    Vendor\Plugin\Settings
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Settings;

use Vendor\Plugin\Config\ConfigInterface;
use Vendor\Plugin\Settings\SettingsCallbacks;
use Vendor\Plugin\Settings\SettingsDefaults;

class Settings
{
    /**
     * The configuration parameters
     *
     * @since    0.3.0
     * @var      ConfigInterface
     */
    public $config;

    /**
     * Page settings configuration
     *
     * @since    0.3.0
     * @var      array
     */
    public $pages = array();

    /**
     * Subpage settings configuration
     *
     * @since    0.3.0
     * @var      array
     */
    public $subpages = array();

    /**
     * Section settings configuration
     *
     * @since    0.3.0
     * @var      array
     */
    public $sections = array();

    /**
     * Settings configuration
     *
     * @since    0.3.0
     * @var      array
     */
    public $settings = array();

    /**
     * Settings link configuration
     *
     * @since    0.3.0
     * @var      array
     */
    public $settings_link = array();

    /**
     * Settings callbacks
     *
     * @since    0.3.0
     * @var      array
     */
    public $settings_callbacks = array();

    /**
     * Predefined setting types accepted by the Forms class
     *
     * @since    0.3.0
     */
    const SETTING_TYPES = array('tel', 'text', 'url', 'email', 'password', 'date', 'month', 'week', 'time', 'datetime-local', 'number', 'range', 'textarea', 'checkbox', 'radio', 'select', 'multiselect');

    /**
     * Constructor
     *
     * @since    0.3.0
     * @param    ConfigInterface    $config
     */
    public function __construct(ConfigInterface $config, SettingsCallbacks $settings_callbacks)
    {
        // d($config);
        $this->config             = $config;
        $this->pages              = $this->config->get('pages');
        $this->subpages           = $this->config->get('subpages');
        $this->sections           = $this->config->get('sections');
        $this->settings           = $this->config->get('settings');
        $this->settings_link      = $this->config->get('settings_link');
        $this->settings_callbacks = $settings_callbacks;
        
        // d($this->subpages);
        // ddd($this->settings);
    }

    /**
     * Add a primary subpage (ie. "Dashboard") to the parent Admin page.
     *
     * @since  0.3.0
     * @param  string    $title    The title of the subpage
     * @return
     */
    public function withSubPage(string $title = null)
    {
        if (empty($this->pages)) {
            return $this;
        }

        $page = $this->pages[0];

        $subpage = [
            'parent_slug'            => $page['menu_slug'],
            'page_title'             => $page['page_title'],
            'menu_title'             => ($title) ? $title : $page['menu_title'],
            'capability'             => $page['capability'],
            'menu_slug'              => $page['menu_slug'],
            'option_name'            => $page['option_name'],
            'register_settings_args' => $page['register_settings_args'],
        ];

        array_unshift($this->subpages, $subpage);

        return $this;
    }

    /**
     * Add the arrays of Admin pages and subpages to WordPress
     *
     * @since 0.3.0
     */
    public function createAdminPages()
    {
        if (! empty($this->pages)) {
            foreach ($this->pages as $page) {
                add_menu_page(
                    $page['page_title'],
                    $page['menu_title'],
                    $page['capability'],
                    $page['menu_slug'],
                    ! empty($page['template']) ? function () use ($page) {
                        return $this->settings_callbacks->page($page['template']);
                    } : '',
                    $page['icon_url'],
                    $page['position']
                );
            }
        }

        if (! empty($this->subpages)) {
            foreach ($this->subpages as $subpage) {
                switch ($subpage['parent_slug']) {
                    case 'Dashboard':
                        $func = 'add_dashboard_page';
                        break;
                    case 'Posts':
                        $func = 'add_posts_page';
                        break;
                    case 'Media':
                        $func = 'add_media_page';
                        break;
                    case 'Pages':
                        $func = 'add_pages_page';
                        break;
                    case 'Comments':
                        $func = 'add_comments_page';
                        break;
                    case 'Appearance':
                        $func = 'add_theme_page';
                        break;
                    case 'Plugins':
                        $func = 'add_plugins_page';
                        break;
                    case 'Users':
                        $func = 'add_users_page';
                        break;
                    case 'Tools':
                        $func = 'add_management_page';
                        break;
                    case 'Settings':
                        $func = 'add_options_page';
                        break;
                    default:
                        $func = 'add_submenu_page';
                        break;
                }

                if ('add_submenu_page' == $func) {
                    $func(
                        $subpage['parent_slug'],
                        $subpage['page_title'],
                        $subpage['menu_title'],
                        $subpage['capability'],
                        $subpage['menu_slug'],
                        ! empty($subpage['template']) ? function () use ($subpage) {
                            return $this->settings_callbacks->page($subpage['template']);
                        } : ''
                    );
                } else {
                    $func(
                        $subpage['page_title'],
                        $subpage['menu_title'],
                        $subpage['capability'],
                        $subpage['menu_slug'],
                        ! empty($subpage['template']) ? function () use ($subpage) {
                            return $this->settings_callbacks->page($subpage['template']);
                        } : ''
                    );
                }
            }
        }
    }

    /**
     * Register Admin sections and settings
     *
     * @since  0.3.0
     * @return
     */
    public function registerSettings()
    {
        if (! empty($this->pages)) {
            foreach ($this->pages as $page) {
                if (false == get_option(str_replace('-', '_', $page['menu_slug']) . '_settings')) {
                    add_option(str_replace('-', '_', $page['menu_slug']) . '_settings');
                }
            }
        }

        if (! empty($this->subpages)) {
            foreach ($this->subpages as $subpage) {
                if (false == get_option(str_replace('-', '_', $subpage['menu_slug']) . '_settings')) {
                    add_option(str_replace('-', '_', $subpage['menu_slug']) . '_settings');
                }
            }
        }

        if (! empty($this->sections)) {
            foreach ($this->sections as $section) {
                add_settings_section(
                    $section['id'],
                    $section['title'],
                    function () use ($section) {
                        return $this->settings_callbacks->section($section['template']);
                    },
                    $section['page']
                );
            }
        }

        if (! empty($this->settings)) {
            foreach ($this->settings as $setting) {
                if (! $this->inCustomPage($setting)) {
                    register_setting(
                        $setting['page'],
                        $setting['id'],
                        $setting['register_settings_args']
                    );
                }
                // ddd($setting['options']);
                add_settings_field(
                    $setting['id'],
                    $setting['title'],
                    (in_array($setting['type'], self::SETTING_TYPES)) ? array($this->settings_callbacks, 'setting') : array($this->settings_callbacks, 'custom'),
                    $setting['page'],
                    $setting['section'],
                    $setting
                );
            }
        }

        if (! empty($this->pages)) {
            foreach ($this->pages as $page) {
                register_setting(
                    $page['menu_slug'],
                    $page['option_name'],
                    $page['register_settings_args']
                );
            }
        }

        if (! empty($this->subpages)) {
            foreach ($this->subpages as $subpage) {
                register_setting(
                    $subpage['menu_slug'],
                    $subpage['option_name'],
                    $subpage['register_settings_args']
                );
            }
        }
    }

    protected function inCustomPage(array $setting)
    {
        return in_array($setting['page'], $this->getPageSlugs());
    }

    protected function getPageSlugs()
    {
        $page_slugs = array_column($this->config['pages'], 'menu_slug');
        $subpage_slugs = array_column($this->config['subpages'], 'menu_slug');

        return array_merge($page_slugs, $subpage_slugs);
    }
}
