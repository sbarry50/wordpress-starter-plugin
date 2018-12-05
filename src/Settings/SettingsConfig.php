<?php
/**
 * Class handler for the plugin's configuration files.
 * Loads a specified configuration file or array and provides several
 * public methods to access and modify the configuration array.
 *
 * @package    SB2Media\Hub\Settings
 * @since      0.1.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Hub\Settings;

use SB2Media\Hub\Support\Arr;
use SB2Media\Hub\Config\Config;

class SettingsConfig extends Config
{
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

        foreach ($config as $key => $value) {
            $merged[$key] = $this->mergeDefault($defaults, $key, $value, $slugs);
        }

        return $merged;
    }

    protected function mergeDefault(array $defaults, $key, $value, array $slugs)
    {
        $merged = array();

        if (! is_array($value) && ! empty($value)) {
            return $value;
        } elseif (! is_array($value)) {
            return $defaults[$key];
        }

        foreach ($value as $param) {
            $param = array_replace_recursive($defaults[$key], $param);

            if ('pages' == $key || 'subpages' == $key) {
                $param['option_name'] = str_replace('-', '_', $param['menu_slug']) . '_settings';
            }

            if ('settings' ==  $key) {
                $param['option_name'] = str_replace('-', '_', $param['page']) . '_settings';
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

        if (in_array($parameter['type'], array('checkbox', 'radio', 'multiselect', 'select'))) {
            if (! Arr::isMultiDimensional($parameter['options'])) {
                $parameter['options'][] =  Arr::pull($parameter, 'options');
            }

            $count = 1;

            foreach ($parameter['options'] as $option) {
                $option = array_replace_recursive($this->getDefaultOptions($parameter, $option, $count), $option);
                $count++;
                array_push($merged, $option);
            }
    
            return $merged;
        }

        return array_replace_recursive($this->getDefaultOptions($parameter), $parameter['options']);
    }

    /**
     * Default args array
     *
     * @since    0.3.0
     * @param    array    $parameter
     * @return   array
     */
    protected function getDefaultOptions(array $parameter, $option = null, int $count = null)
    {
        $option_name = str_replace('-', '_', $parameter['page']) . '_settings';
        $name = $option_name . '[' . $parameter['id'] . ']';
        $checkbox_id = $parameter['id'] . '_' . $count;
        $formatted_label = str_replace(' ', '_', strtolower($option['label']));

        switch ($parameter['type']) {
            case 'tel':
            case 'text':
            case 'url':
            case 'email':
            case 'password':
                return array(
                    'id' => $parameter['id'],
                    'class' => 'regular-text',
                    'name' => $name,
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
                    'name' => $name,
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
                    'name' => $name,
                    'type' => $parameter['type'],
                    'placeholder' => '',
                    'rows' => 7,
                    'cols' => 50,
                    'value' => null,
                    'required' => false,
                );
            case 'checkbox':
                return array(
                    'label' => '',
                    'id' => $checkbox_id,
                    'name' => $name . '[' . $checkbox_id . ']',
                    'type' => $parameter['type'],
                    'value' => 1,
                    'checked' => false,
                    'required' => false,
                );
            case 'radio':
                return array(
                    'label' => '',
                    'id' => $parameter['id'] . '_' . $count,
                    'name' => $name,
                    'type' => $parameter['type'],
                    'value' => $parameter['id'] . '_' . $count,
                    'checked' => false,
                    'required' => false,
                );
            case 'select':
                return array(
                    'label' => '',
                    'id' => $parameter['id'],
                    'name' => $name,
                    'value' => $parameter['id'] . '_' . $count,
                    'selected' => false,
                    'required' => false,
                );
            case 'multiselect':
                return array(
                    'label' => '',
                    'id' => $parameter['id'] . '_' . $count,
                    'name' => $name . '[]',
                    'value' => $parameter['id'] . '_' . $count,
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

    protected function getValue($parameter, $option_name, $formatted_label = null)
    {
        $values = get_option($option_name);
        d($option_name);
        ddd($values);
        if ('checkbox' == $parameter['type']) {
            $key = $parameter['id'] . '[' . $formatted_label . ']';
        } else {
            $key = $parameter['id'];
        }

        if ($this->inCustomPage($parameter)) {
            return array_key_exists($key, $values) ? esc_attr($values[$key]) : null;
        } else {
            return get_option($key) ? esc_attr(get_option($key)) : null;
        }
    }
}
