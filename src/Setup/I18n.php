<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @package    SB2Media\Hub\Setup
 * @since      0.1.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Hub\Setup;

use SB2Media\Hub\Support\Paths;
use const SB2Media\Hub\PLUGIN_TEXT_DOMAIN;

class I18n
{
    /**
     * The domain specified for this plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string    $domain    The domain identifier for this plugin.
     */
    private $domain;

    /**
     * Constructor
     *
     * @since 0.5.0
     * @param PluginData $plugin_data
     */
    public function __construct(PluginData $plugin_data)
    {
        $this->plugin_data = $plugin_data;
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since    0.1.0
     */
    public function loadPluginTextDomain()
    {
        \load_plugin_textdomain(
            $this->plugin_data->headerData('text-domain'),
            false,
            $this->plugin_data->path('lang')
        );
    }
}
