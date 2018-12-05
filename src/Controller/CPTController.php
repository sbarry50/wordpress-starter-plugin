<?php
/**
 * Custom Post Type controller
 *
 *
 * @package    SB2Media\Hub\Controller
 * @since      0.4.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Hub\Controller;

use SB2Media\Hub\CPT\CPT;
use function SB2Media\Hub\container as container;

class CPTController extends Controller
{
    /**
     * Constructor
     *
     * @since 0.5.0
     */
    public function __construct()
    {
        $this->container = container();
    }

    /**
     * Add the custom post types
     *
     * @since 0.5.0
     * @param string $services
     * @return void
     */
    public function bootCustomPostTypes(string $services)
    {
        $services = $this->container->getCollection($services);
        foreach ($services as $service) {
            $service = $this->container->get($service);
            if (is_a($service, 'SB2Media\Hub\CPT\CPT')) {
                $service->addCustomPostType();
            }
        }
    }
}
