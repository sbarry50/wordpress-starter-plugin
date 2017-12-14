<?php
/**
 * Class for handling attributes
 *
 * @package    Vendor\Plugin\Forms
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Forms;

use Vendor\Plugin\Support\Arr;

class Attributes
{

    /**
     * The attributes for the form element
     *
     * @var $attributes
     */
    public $attributes = array();

    /**
     * Boolean attributes
     *
     * @since    0.3.0
     * @var      array    $boolean_atts
     */
    protected $boolean_atts = array('autofocus', 'checked', 'disabled', 'hidden', 'multiple', 'readonly', 'required', 'selected');

    /**
     * Set the attributes property
     *
     * @since    0.3.0
     * @param    array    $attributes    The attributes for the form element
     * @return   void
     */
    public function set(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Prints the array of attributes
     *
     * @since    0.3.0
     * @param    array    $attributes
     * @return   string   $html
     */
    public function print(array $attributes)
    {
        $html = '';

        foreach ($attributes as $key => $value) {
            if ('label' == $key) {
                continue;
            }

            if (in_array($key, $this->boolean_atts) && $attributes[$key]) {
                $html .= ' ' . $key;
                continue;
            } elseif (in_array($key, $this->boolean_atts)) {
                continue;
            }

            if (isset($attributes[$key]) && ! empty($attributes[$key])) {
                $html .= ' ' . $key . '="' . $value . '"';
            }
        }

        return $html;
    }

    /**
     * Compile and return attributes from configuration parameters
     *
     * @since    0.3.0
     * @param    array    $config
     * @return   void
     */
    public function compile(array $config)
    {
        $attributes = $config['attributes'];

        $attributes['id']   = $config['id'];
        $attributes['name'] = $config['id'];
        $attributes['type'] = $config['type'];

        if (isset($config['value'])) {
            $attributes['value'] = $config['value'];
        }

        return $this->sort($attributes);
    }

    /**
     * Sort the attributes array according to predefined key order. Shifts boolean attributes to the end of the array.
     *
     * @since    0.3.0
     * @param    array    $attributes
     * @return   array    $attributes
     */
    protected function sort(array $attributes)
    {
        $order = array(
            'id' => '',
            'class' => '',
            'type' => '',
            'name' => '',
            'placeholder' => '',
        );

        if (isset($attributes['value'])) {
            $order['value'] = '';
            // $attributes = Arr::moveToEnd($attributes, 'value');
        }

        $attributes = array_replace($order, $attributes);

        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->boolean_atts)) {
                $attributes = Arr::moveToEnd($attributes, $key);
            }
        }

        return $attributes;
    }
}
