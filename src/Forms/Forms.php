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

    // public function Args(array $args)
    // {
    //     $this->args = $args;

    //     return $this;
    // }

    public function getElement(array $args)
    {
        ddd($args);
        if (in_array($args['type'], array('checkbox', 'radio', 'select', 'multiselect')) && isset($args['options'])) {
            $args['options'] = $this->options->compile($args);
        } else {
            $args['attributes'] = $this->attributes->compile($args);
        }

        if ('checkbox' == $args['type'] || 'radio' == $args['type']) {
            $element = 'multiple';
        } elseif ('multiselect' == $args['type'] || 'select' == $args['type']) {
            $element = 'select';
        } elseif ('textarea' == $args['type']) {
            $element = 'textarea';
        } else {
            $element = 'input';
        }

        return $this->$element($args);
    }

    protected function input(array $args)
    {
        if (array_key_exists('attributes', $args)) {
            $attributes = $args['attributes'];
        } else {
            $attributes = $args;
        }

        $html = '<input ';
        $html .= $this->attributes->print($attributes);
        $html .= '>';

        return $html;
    }

    protected function multiple(array $args)
    {
        $html = '';

        foreach ($args['options'] as $option) {
            $html .= '<label for="' . $option['id'] . '">';
            $html .= $this->input($option);
            $html .= ' ' . $option['label'] . '</label><br>';
        }

        return $html;
    }

    protected function select(array $args)
    {
        $html = '<select ';
        $html .= $this->attributes->print($args['attributes']);
        $html .= '>';
        $html .= $this->options->print($args['options']);
        $html .= '</select>';

        return $html;
    }

    protected function textarea(array $args)
    {
        $html = '<textarea ';
        $html .= $this->attributes->print($args['attributes']);
        $html .= '>';
        $html .= get_option($args['id']) ? esc_attr(get_option($args['id'])) : '';
        $html .= '</textarea>';

        return $html;
    }
}
