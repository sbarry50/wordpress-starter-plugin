<?php
/**
 * Enqueue manager controller
 *
 *
 * @package    Vendor\Plugin\Controller
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Controller;

use Vendor\Plugin\Controller\Controller;
use Vendor\Plugin\Events\EventManager;

class EnqueueController extends Controller
{

    /**
     * Enqueue front end stylesheets and scripts into Wordpress via the enqueue manager.
     *
     * Recommend adding stylesheets and scripts via the enqueue config file.
     *
     * The alternative way to add stylesheets and scripts
     *
     * For stylesheets pass the file name, any dependecies (optional) and media type (optional) to enqueueStyles()
     * $enqueue_manager->enqueueStyles($file, array $dependencies = array(), $media = 'all');
     *
     * For scripts pass the file name, any dependecies (optional) and whether it should be placed in the head or footer (optional) to enqueueScripts()
     * $enqueue_manager->enqueueScripts($file, array $dependencies = array(), $in_footer = false);
     *
     * @since  0.1.0
     * @return
     */
    public function enqueueAssets()
    {
        $enqueue_manager = $this->container->get('enqueue_manager');
        $enqueue_manager->enqueueConfig();
                        // ->enqueueStyles('another-name', array(), 'all')
                        // ->enqueueScripts('another-name', array(), true);
        EventManager::addAction('wp_enqueue_scripts', array($enqueue_manager, 'enqueue'));
    }

    /**
     * Enqueue admin stylesheets and scripts into Wordpress via the enqueue manager.
     *
     * Recommend adding stylesheets and scripts via the admin-enqueue config file.
     *
     * The alternative way to add stylesheets and scripts
     *
     * For stylesheets pass the file name, any dependecies (optional) and media type (optional) to enqueueStyles()
     * $admin_enqueue_manager->enqueueStyles($file, array $dependencies = array(), $media = 'all');
     *
     * For scripts pass the file name, any dependecies (optional) and whether it should be placed in the head or footer (optional) to enqueueScripts()
     * $admin_enqueue_manager->enqueueScripts($file, array $dependencies = array(), $in_footer = false);
     *
     * @since  0.2.0
     * @return
     */
    public function enqueueAdminAssets()
    {
        $admin_enqueue_manager = $this->container->get('admin_enqueue_manager');
        $admin_enqueue_manager->enqueueConfig();
                            //   ->enqueueStyles('another-name-admin', array(), 'all')
                            //   ->enqueueScripts('another-name-admin', array(), true);
        EventManager::addAction('admin_enqueue_scripts', array($admin_enqueue_manager, 'enqueue'));
    }
}
