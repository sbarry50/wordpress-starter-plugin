<?php
/**
 * Collection of callback methods for the Settings class
 *
 * @package    Vendor\Plugin\Settings
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Settings;

use Exception;
use Vendor\Plugin\Support\Arr;
use Vendor\Plugin\Forms\Forms;
use Vendor\Plugin\Support\Paths;
use Vendor\Plugin\Settings\Settings;
use Vendor\Plugin\Container\Container;
use Vendor\Plugin\File\LoaderInterface;
use const Vendor\Plugin\PLUGIN_TEXT_DOMAIN;

class SettingsCallbacks
{
    /**
     * Instance of Loader class
     * @var Loader
     */
    public $loader;

    /**
     * Constructor
     *
     * @since 0.3.0
     * @param LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader, Forms $forms)
    {
        $this->loader = $loader;
        $this->forms = $forms;
    }

    // /**
    //  * Get the appropriate callback function
    //  *
    //  * @since  0.3.0
    //  * @param  string    $type         Type of callback. Possible values 'page', 'section' or 'option'
    //  * @param  string    $file_name    Name of the view file
    //  * @param  string    $id           (Opt) Option id
    //  * @param  string    $class        (Opt) Option class
    //  * @param  array     $args         (Opt) Option arguments
    //  * @return
    //  */
    // public function callback(string $callback_type, string $option_type, string $file_name = '', string $id = '', array $args = array())
    // {
    //     if ('page' != $callback_type && 'section' != $callback_type && 'option' != $callback_type) {
    //         throw new Exception(sprintf(__('\'%s\' is not a valid type. Must be \'page\', \'section\' or \'option\'.', PLUGIN_TEXT_DOMAIN), $callback_type));
    //     }

    //     ('option' == $callback_type) ? $this->$callback_type($option_type, $id, $args) : $this->$callback_type($file_name);
    // }

    /**
     * Load the page view template
     *
     * @since  0.3.0
     * @param  string    $file_name View file to load
     * @return
     */
    public function page(string $file_name)
    {
        $file = Paths::views() . "admin/pages/{$file_name}.php";
        // ddd($this->loader->loadOutputFile($file));
        // d($file);
        printf($this->loader->loadOutputFile($file));
    }

    /**
     * Load the section view template
     *
     * @since  0.3.0
     * @param  string    $file_name View file to load
     * @return
     */
    public function section(string $file_name)
    {
        $file = Paths::views() . "admin/sections/{$file_name}.php";
        printf($this->loader->loadOutputFile($file));
    }

    /**
     * Load the option view template
     *
     * @since  0.3.0
     * @param  array    $parameter    The configuration parameters
     * @return
     */
    public function setting(array $parameter)
    {
        $parameter = $this->updateValues($parameter);

        printf($this->forms->getElement($parameter['options'], $parameter['type']));
    }

    public function custom(array $options)
    {
        // if (empty($options['custom_options'])) {
        //     throw new Exception(sprintf(__('The \'custom_options\' field must be set and properly configured in the admin-settings configuration file.', PLUGIN_TEXT_DOMAIN)));
        // }

        // do stuff
    }

    protected function updateValues($parameter)
    {
        if (! get_option($parameter['option_name'])) {
            return $parameter;
        }

        $values = get_option($parameter['option_name']);
        // ddd($values);
        if (! array_key_exists($parameter['id'], $values)) {
            return $parameter;
        }

        if (! in_array($parameter['type'], array('checkbox', 'radio', 'select', 'multiselect'))) {
            $parameter['options']['value'] = $values[$parameter['id']];
            return $parameter;
        }

        return $this->updateBooleanValues($parameter, $values);
    }

    protected function updateBooleanValues($parameter, $values)
    {
        $merged_options = array();
        
        foreach ($parameter['options'] as $option) {
            switch ($parameter['type']) {
                case ('checkbox'):
                    $option['checked'] = ($option['value'] == $values[$parameter['id']][$option['id']]) ? true : false;
                    break;
                case ('radio'):
                    $option['checked'] = ($option['value'] == $values[$parameter['id']]) ? true : false;
                    break;
                case ('select'):
                    $option['selected'] = ($option['value'] == $values[$parameter['id']]) ? true : false;
                    break;
                case ('multiselect'):
                    $option['selected'] = in_array($option['value'], $values[$parameter['id']]) ? true : false;
                    break;
            }

            array_push($merged_options, $option);
        }

        $parameter['options'] = $merged_options;

        return $parameter;
    }
}
