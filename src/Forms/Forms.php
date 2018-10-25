<?php
/**
 * Class handler for forms and elements
 *
 * @package    Vendor\Plugin\Forms
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Forms;

use Vendor\Plugin\Support\Arr;
use Vendor\Plugin\Support\Paths;
use Vendor\Plugin\Forms\Options;
use Vendor\Plugin\Forms\Attributes;
use Vendor\Plugin\Container\Container;
use Vendor\Plugin\File\LoaderInterface;

class Forms
{
    /**
     * Instance of Loader class
     *
     * @var LoaderInterface
     */
    public $loader;

    /**
     * Instance of Attributes class
     *
     * @var Attributes
     */
    public $attributes;

    /**
     * Instance of Options class
     *
     * @var Options
     */
    public $options;

    /**
     * Configuration parameters
     *
     * @var $args
     */
    public $args = array();

    /**
     * Constructor
     *
     * @param LoaderInterface $loader
     * @param Attributes $attributes
     */
    public function __construct(LoaderInterface $loader, Attributes $attributes, Options $options)
    {
        $this->loader = $loader;
        $this->attributes = $attributes;
        $this->options = $options;
    }

    public function getElement(array $options, string $type)
    {
        if ('multiselect' == $type) {
            return $this->select($options, true);
        }

        if ('checkbox' == $type || 'radio' == $type) {
            $element = 'multiple';
        } elseif ('select' == $type) {
            $element = 'select';
        } elseif ('textarea' == $type) {
            $element = 'textarea';
        } else {
            $element = 'input';
        }

        return $this->$element($options);
    }

    protected function input(array $options)
    {
        $html = '<input ';
        $html .= $this->attributes->print($options);
        $html .= isset($options['checked']) ? checked($options['checked'], true, false) : '';
        $html .= '>';

        return $html;
    }

    protected function options(array $options)
    {
        $html = '';

        foreach ($options as $option) {
            $html .= '<option ';

            if (isset($option['value']) || ! empty($option['value'])) {
                $html .= 'value="' . $option['value'] . '"';
            }

            $html .= isset($option['selected']) ? selected($option['selected'], true, false) : '';

            $html .= '>' . $option['label'] . '</option>';
        }

        return $html;
    }

    protected function multiple(array $options)
    {
        $html = '<fieldset>';

        foreach ($options as $option) {
            $hidden_options = array(
                'name' =>$option['name'],
                'type' => 'hidden',
                'value' => 0,
            );
    
            $html .= '<label for="' . $option['id'] . '">';
            $html .= ($option['type'] == 'checkbox') ? $this->input($hidden_options) : '';
            $html .= $this->input($option);
            $html .= ' ' . $option['label'] . '</label><br>';
        }

        $html .= '</fieldset>';

        return $html;
    }

    protected function select(array $options, $multi = false)
    {
        // d($options);
        $select_tag_attributes = array(
            'id' => $options[0]['id'],
            'name' => $options[0]['name'],
        );

        $hidden_attributes = array(
            'id' => $options[0]['id'],
            'name' => $options[0]['name'],
            'type' => 'hidden',
            'value' => 'none_selected',
        );

        $html = '';
        $html .= $multi ? $this->input($hidden_attributes) : '';
        $html .= '<select';
        $html .= $this->attributes->print($select_tag_attributes);
        $html .= $multi ? ' multiple' : '';
        $html .= '>';
        $html .= $this->options($options);
        $html .= '</select>';

        return $html;
    }

    protected function textarea(array $options)
    {
        $value = Arr::pull($options, 'value');

        $html = '<textarea ';
        $html .= $this->attributes->print($options);
        $html .= '>';
        $html .= $value;
        $html .= '</textarea>';

        return $html;
    }
}
