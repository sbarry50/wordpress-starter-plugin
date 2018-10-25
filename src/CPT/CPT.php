<?php
/**
 * Class for registering WordPress custom post types
 *
 * @package    Vendor\Plugin\CPT
 * @since      0.4.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\CPT;

class CPT
{
    /**
     * Register the custom post types
     *
     * @since 0.4.0
     * @return void
     */
    public static function register()
    {
        $post_types = include(plugin_dir_path(dirname(dirname(__FILE__))) . 'config/cpt.php');

        foreach ($post_types as $post_type) {
            register_post_type($post_type['id'], $post_type);
        }
    }
}
