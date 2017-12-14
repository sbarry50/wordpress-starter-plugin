<?php
/**
 * Class handler for the plugin's configuration files.
 * Loads a specified configuration file or array and provides several public methods to access and modify the configuration array.
 *
 * @package    Vendor\Plugin\Settings
 * @since      0.1.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Settings;

use Vendor\Plugin\Support\Arr;
use Vendor\Plugin\Config\Config;

class SettingsConfig extends Config
{

    // public function __construct($config, $defaults = '')
    // {
    //     $defaults = $this->loadFile($defaults);
    //     $this->config = $this->mergeDefaults($defaults, $this->getParameters($config));
    // }

    /**
     * Merge the default parameters with the configuration parameters
     *
     * @since    0.3.0
     * @param    array    $params    The configuration parameters
     * @param    string   $type      The type of configuration (page, subpage, section or setting)
     * @return   array    $merged    The configuration parameters with the default parameters merged in
     */
    public function mergeDefaults(array $defaults, $config)
    {
        $merged = array();
        $slugs = $this->getPageSlugs($config);
        
        // foreach ($config as $key => $value) {
        //     $keys[] = $key;
        // }
        // d($keys);

        // foreach ($keys as $key) {
        //     ${"params_$key"} = $config[$key];
        // }
        // d($params_settings);
        
        // foreach ($defaults as $default_key => $default_value) {
        //     $default_keys[] = $default_key;
        // }
        // d($default_keys);

        // foreach ($default_keys as $default_key) {
        //     ${"defaults_$default_key"} = $defaults[$default_key];
        // }
        // ddd($defaults_settings);



        // $page_merged = array();
        // $subpage_merged = array();
        // $section_merged = array();
        // $setting_merged = array();

        // $page_params = $params['page'];
        // $subpage_params = $params['subpage'];
        // $section_params = $params['section'];
        // $setting_params = $params['setting'];

        // $page_defaults = $this->defaults()['page'];
        // $subpage_defaults = $this->defaults()['subpage'];
        // $section_defaults = $this->defaults()['section'];
        // $setting_defaults = $this->defaults()['setting'];

        foreach ($config as $key => $value) {
            // d($param);
            $param = $this->mergeDefault($defaults, $key, $value, $slugs);
            // d($param);
            array_push($merged, $param);
        }

        // ddd('done');

        // foreach ($merged['settings'] as $setting) {
        //     foreach ($setting['options'] as $option) {
        //         if (in_array($option['page'], $this->getPageSlugs($merged['pages'])) || in_array($option['page'], $this->getPageSlugs($merged['subpages']))) {
        //             $option['register_setting_args'] = $this->registerSettingArgs();
        //         }
        //     }
        // }

        // foreach ($page_params as $page_param) {
        //     $page_param = array_replace_recursive($page_defaults, $page_param);
        //     array_push($page_merged, $page_param);
        // }

        // foreach ($subpage_params as $subpage_param) {
        //     $subpage_param = array_replace_recursive($subpage_defaults, $subpage_param);
        //     array_push($subpage_merged, $subpage_param);
        // }

        // foreach ($section_params as $section_param) {
        //     $section_param = array_replace_recursive($section_defaults, $section_param);
        //     array_push($section_merged, $section_param);
        // }

        // foreach ($setting_params as $setting_param) {
        //     $setting_param = array_replace_recursive($setting_defaults, $setting_param);

        //     if (in_array($param['type'], array('checkbox', 'radio', 'select', 'multiselect')) && isset($param['args'])) {
        //         $count = 1;
        //         foreach ($param['args'] as $key => $default_) {
        //             $param['args'][$key] = array_replace_recursive($this->options(), $value);
        //             $count++;
        //         }
        //     }

        //     if ($settings_pages->inCustomPage($param)) {
        //         $param['register_settings_args'] = $this->registerSettingsArgs();
        //     }

        //     array_push($setting_merged, $setting_param);
        // }

        // array_push($merged, $page_merged, $subpage_merged, $section_merged, $setting_merged);
        
        ddd($merged);

        return $merged;
    }

    protected function mergeDefault(array $defaults, $key, $value, array $slugs)
    {
        if (! is_array($value)) {
            return;
        }

        $merged = array();

        foreach ($value as $param) {
            $param = array_replace_recursive($defaults[$key], $param);

            if ('settings' ==  $key) {
                $param['options'] = $this->mergeDefaultOptions($param);
                
                if (! in_array($param['page'], $slugs)) {
                    $param['register_settings_args'] = $this->registerSettingsArgs();
                }
            }

            array_push($merged, $param);
        }

        return $merged;
    }

    protected function mergeDefaultOptions(array $parameter)
    {
        $merged = array();
        d($parameter['options']);
        if (! Arr::isMultiArray($parameter['options'])) {
            $parameter['options'] = array_replace_recursive($this->getDefaultOptions($parameter), $parameter['options']);
            array_push($merged, $parameter['options']);
            return $merged;
        }

        $count = 1;
        foreach ($parameter['options'] as $option) {
            $option = array_replace_recursive($this->getDefaultOptions($parameter, $count), $option);
            $count++;
            array_push($merged, $option);
        }

        return $merged;
    }

    /**
     * Default args array
     *
     * @since    0.3.0
     * @param    array    $parameter
     * @return   array
     */
    protected function getDefaultOptions(array $parameter, int $count = null)
    {
        switch ($parameter['type']) {
            case 'tel':
            case 'text':
            case 'url':
            case 'email':
            case 'password':
                return array(
                    'id' => $parameter['id'],
                    'class' => 'regular-text',
                    'name' => $parameter['id'],
                    'type' => $parameter['type'],
                    'placeholder' => '',
                    'value' => null,
                    'required' => false,
                );
            case 'date':
            case 'month':
            case 'week':
            case 'time':
            case 'datetime-local':
            case 'number':
            case 'range':
                return array(
                    'id' => $parameter['id'],
                    'class' => 'regular-text',
                    'name' => $parameter['id'],
                    'type' => $parameter['type'],
                    'placeholder' => '',
                    'min' => null,
                    'max' => null,
                    'step' => null,
                    'value' => null,
                    'required' => false,
                );
            case 'textarea':
                return array(
                    'id' => $parameter['id'],
                    'class' => 'regular-text',
                    'name' => $parameter['id'],
                    'type' => $parameter['type'],
                    'placeholder' => '',
                    'rows' => 7,
                    'cols' => 50,
                    'required' => false,
                );
            case 'checkbox':
                return array(
                    'label' => '',
                    'id' => $parameter['id'] . '-' . $count,
                    // 'name' => 'checkbox-' . str_replace(' ', '-', strtolower($parameter['options']['label'])),
                    'type' => $parameter['type'],
                    'value' => null,
                    'checked' => false,
                    'required' => false,
                );
            case 'radio':
                return array(
                    'label' => '',
                    'id' => $parameter['id'] . '-' . $count,
                    'name' => $parameter['id'],
                    'type' => $parameter['type'],
                    // 'value' => str_replace(' ', '-', strtolower($parameter['options']['label'])) . '-' . $count,
                    'checked' => false,
                    'required' => false,
                );
            case 'select':
            case 'multiselect':
                return array(
                    'label' => '',
                    // 'value' => str_replace(' ', '-', strtolower($parameter['options']['label'])),
                    'selected' => false,
                    'required' => false,
                );
            case 'custom':
                return array(
                    'callback'  => '',
                    'file_name' => '',
                    'args'      => array(),
                );
            default:
                return array();
        }
    }

    /**
     * Default register_setting $args
     *
     * @since    0.3.0
     * @return   void
     */
    protected function registerSettingsArgs()
    {
        return array(
            'type'              => '',
            'description'       => '',
            'sanitize_callback' => null,
            'show_in_rest'      => false,
            'default'           => array(),
        );
    }

    protected function getPageSlugs(array $config)
    {
        $page_slugs = array_column($config['pages'], 'menu_slug');
        $subpage_slugs = array_column($config['subpages'], 'menu_slug');

        return array_merge($page_slugs, $subpage_slugs);
    }
}
