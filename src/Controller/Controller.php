<?php
/**
 * Base controller class
 *
 *
 * @package    SB2Media\Hub\Controller
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Hub\Controller;

use function SB2Media\Hub\container;

class Controller
{
    /**
     * Container instance
     * @var Container
     */
    public $container;

    /**
     * Constructor
     *
     * @since 0.3.0
     */
    public function __construct()
    {
        $this->container = container();
    }
}
