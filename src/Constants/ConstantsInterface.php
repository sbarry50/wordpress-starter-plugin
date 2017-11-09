<?php
/**
 * Constants Contract
 *
 * @package    Vendor\Plugin
 * @since      0.1.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Constants;

interface ConstantsInterface
{

    /**
     * Define the plugin's constants
     *
     * @since  0.1.0
     * @return null
     */
    public function define();

    /**
     * Add additional constants to the default constants array
     *
     * @since 0.1.0
     * @return array    $this->constants    The plugin constants
     */
    public function add( array $constants );
}
