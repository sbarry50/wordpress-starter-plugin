<?php
/**
 * WordPress Settings API class handler
 *
 * @package    Vendor\Plugin\Settings
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Settings;

use Vendor\Plugin\Settings\SettingsCallbacks;
use Vendor\Plugin\Settings\SettingsDefaults;

class Settings
{
    /**
     * The configuration parameters
     *
     * @since    0.3.0
     * @var      ConfigInterface
     */
    public $config;

    /**
     * Page settings configuration
     *
     * @since    0.3.0
     * @var      array
     */
    public $page = array();

    /**
     * Subpage settings configuration
     *
     * @since    0.3.0
     * @var      array
     */
    public $subpage = array();

    /**
     * Section settings configuration
     *
     * @since    0.3.0
     * @var      array
     */
    public $section = array();

    /**
     * Settings configuration
     *
     * @since    0.3.0
     * @var      array
     */
    public $settings = array();

    /**
     * Constructor
     *
     * @since 0.3.0
     * @param SettingsConfig    $config
     */
    public function __construct(SettingsConfig $config)
    {
        $this->config   = $config;
        $this->page     = $config['page'];
        $this->subpage  = $config['subpage'];
        $this->section  = $config['section'];
        $this->settings = $config['settings'];
    }
}
