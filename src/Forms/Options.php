<?php
/**
 * Class for handling options
 *
 * @package    Vendor\Plugin\Forms
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Forms;

class Options
{
    /**
     * The options for the form element
     *
     * @var $options
     */
    public $options = array();

    /**
     * Set the options property
     *
     * @since    0.3.0
     * @param    array    $options    The options for the form element
     * @return   void
     */
    public function set(array $options)
    {
        $this->options = $options;

        return $this;
    }

    public function print(array $options)
    {
        $html = '';

        foreach ($options as $option) {
            $html .= '<option ';

            if (isset($option['value']) || ! empty($option['value'])) {
                $html .= 'value="' . $option['value'] . '"';
            }

            if ($option['selected']) {
                $html .= ' selected';
            }

            $html .= '>' . $option['label'] . '</option>/n';
        }

        return $html;
    }

    public function compile(array $config)
    {
        $compiled = array();
        $options = $config['options'];
        $count = 1;

        foreach ($options as $option) {
            if (empty($option['id'])) {
                $option['id'] = $config['id'] . '-' . $count;
                $count++;
            }

            if (empty($option['class'])) {
                $option['class'] = $config['attributes']['class'];
            }

            $option['type'] = $config['type'];

            if (empty($option['name']) && 'checkbox' == $config['type']) {
                $option['name'] = 'checkbox-' . str_replace(' ', '-', strtolower($option['label']));
            } elseif (empty($option['name']) && 'radio' == $config['type']) {
                $option['name'] = 'radio-' . $config['id'];
            }

            if (empty($config['value']) && 'checkbox' != $config['type']) {
                $option['value'] = str_replace(' ', '-', strtolower($option['label']));
            }

            array_push($compiled, $option);
        }

        return $compiled;
    }
}
