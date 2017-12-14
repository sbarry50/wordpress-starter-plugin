<?php
/**
 * Base controller class
 *
 *
 * @package    Vendor\Plugin\Controller
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Controller;

use Vendor\Plugin\Container\ContainerInterface;

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
     * @param ContainerInterface    $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
