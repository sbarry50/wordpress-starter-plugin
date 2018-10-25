<?php
/**
 * Custom Post Type controller
 *
 *
 * @package    Vendor\Plugin\Controller
 * @since      0.4.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Controller;

use Vendor\Plugin\CPT\CPT;
use Vendor\Plugin\Events\EventManager;
use Vendor\Plugin\Controller\Controller;
use Vendor\Plugin\Container\ContainerInterface;

class CPTController extends Controller
{
    /**
     * Constructor
     *
     * @since    0.4.0
     * @param    ContainerInterface    $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    /**
     * Add the custom post types
     *
     * @since 0.4.0
     * @return void
     */
    public function addCustomPostTypes()
    {
        EventManager::addAction('init', array(CPT::class, 'register'));
    }
}
