<?php
/**
 * Class for registering WordPress custom post types
 *
 * @package    SB2Media\Hub\CPT
 * @since      0.4.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Hub\CPT;

use SB2Media\Hub\Events\EventManager;
use SB2Media\Hub\Config\ConfigInterface;

class CPT
{
    /**
     * Contructor
     *
     * @param ConfigInterface $config
     * @since 0.4.1
     */
    public function __construct(ConfigInterface $post_type)
    {
        $this->post_type = $post_type;
    }
    
    /**
     * Register the custom post types
     *
     * @since 0.4.0
     * @return void
     */
    public function register()
    {
        register_post_type($this->post_type['id'], $this->post_type);
    }

    /**
     * Add the custom post types
     *
     * @since 0.4.0
     * @return void
     */
    public function addCustomPostType()
    {
        EventManager::addAction('init', array($this, 'register'));
    }
}
