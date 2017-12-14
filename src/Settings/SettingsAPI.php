<?php
/**
 * Class for interacting with the WordPress Settings API
 *
 * @package    Vendor\Plugin\Settings
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Settings;

use Vendor\Plugin\Support\Arr;
use Vendor\Plugin\Config\Config;
use Vendor\Plugin\Settings\Settings;
use Vendor\Plugin\Container\Container;
use Vendor\Plugin\Config\ConfigInterface;

class SettingsAPI extends Settings
{

    /**
     * Admin sections
     *
     * @var array
     */
    public $sections = array();

    /**
     * Admin settings
     *
     * @var array
     */
    public $settings = array();

    /**
     * Set the sections configuration to the sections property
     *
     * @since 0.3.0
     * @param array $sections
     */
    public function setSections(array $sections)
    {
        $this->sections = $this->defaults->merge($sections, 'section');

        return $this;
    }

    /**
     * Set the settings configuration to the settings property
     *
     * @since 0.3.0
     * @param array $settings
     */
    public function setSettings(array $settings)
    {
        $this->settings = $this->defaults->merge($settings, 'setting');

        return $this;
    }

    /**
     * Register Admin sections and settings
     *
     * @since  0.3.0
     * @return
     */
    public function registerSettings()
    {
        $settings_pages = Container::instance('settings_pages');

        if (! empty($this->sections)) {
            foreach ($this->sections as $section) {
                add_settings_section(
                    $section['id'],
                    $section['title'],
                    function () use ($section) {
                        return $this->callbacks->section($section['template']);
                    },
                    $section['page']
                );
            }
        }

        if (! empty($this->settings)) {
            foreach ($this->settings as $setting) {
                if (! $settings_pages->inCustomPage($setting)) {
                    register_setting(
                        $setting['page'],
                        $setting['id'],
                        $setting['register_setting_args']
                    );
                }

                add_settings_field(
                    $setting['id'],
                    $setting['title'],
                    array($this->callbacks, 'setting'),
                    $setting['page'],
                    $setting['section'],
                    $setting
                );
            }
        }

        if (! empty($settings_pages->pages)) {
            foreach ($settings_pages->pages as $page) {
                register_setting(
                    $page['menu_slug'],
                    $page['menu_slug'] . '-settings',
                    $page['args']
                );
            }
        }

        if (! empty($settings_pages->subpages)) {
            foreach ($settings_pages->subpages as $subpage) {
                register_setting(
                    $subpage['menu_slug'],
                    $subpage['menu_slug'] . '-settings',
                    $subpage['args']
                );
            }
        }
    }

    /**
     * Filter, flatten and return the settings callback arguments from the configuration array
     *
     * @since    0.3.0
     * @param    array    $config    The configuration parameters
     * @return   void
     */
    protected function filterArgs(array $config)
    {
        Arr::drop($config, array('group', 'page', 'section', 'register_setting_args'));
        return $config;
    }
}
