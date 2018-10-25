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

    // /**
    //  * Admin sections
    //  *
    //  * @var array
    //  */
    // public $sections = array();

    // /**
    //  * Admin settings
    //  *
    //  * @var array
    //  */
    // public $settings = array();

    // /**
    //  * Set the sections configuration to the sections property
    //  *
    //  * @since 0.3.0
    //  * @param array $sections
    //  */
    // public function setSections(array $sections)
    // {
    //     $this->sections = $this->defaults->merge($sections, 'section');

    //     return $this;
    // }

    // /**
    //  * Set the settings configuration to the settings property
    //  *
    //  * @since 0.3.0
    //  * @param array $settings
    //  */
    // public function setSettings(array $settings)
    // {
    //     $this->settings = $this->defaults->merge($settings, 'setting');

    //     return $this;
    // }

    // public function __construct(SettingsCallbacks $callbacks)
    // {
    //     $this->callbacks = $callbacks;
    // }

    /**
     * Register Admin sections and settings
     *
     * @since  0.3.0
     * @return
     */
    public function registerSettings()
    {
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
                    ('custom' == $setting['type']) ? array($this->settings_callbacks, 'custom') : array($this->settings_callbacks, 'setting'),
                    $setting['page'],
                    $setting['section'],
                    $setting['options']
                );
            }
        }

        if (! empty($this->pages)) {
            foreach ($this->pages as $page) {
                register_setting(
                    $page['menu_slug'],
                    $page['menu_slug'] . '-settings',
                    $page['register_settings_args']
                );
            }
        }

        if (! empty($this->subpages)) {
            foreach ($this->subpages as $subpage) {
                register_setting(
                    $subpage['menu_slug'],
                    $subpage['menu_slug'] . '-settings',
                    $subpage['register_settings_args']
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
