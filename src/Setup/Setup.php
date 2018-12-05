<?php
/**
 * Class for setting up the plugin
 *
 * @package    SB2Media\Hub\Setup
 * @since      0.5.0
 * @author     sbarry
 * @link       http://sb2media.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Hub\Setup;

use SB2Media\Hub\Container\Container;
use SB2Media\Hub\Config\ConfigFactory;

class Setup
{
    /**
     * The plugin ID
     *
     * @since 0.5.0
     * @var string
     */
    public $plugin_id;

    /**
     * The plugin root file
     *
     * @since 0.5.0
     * @var string
     */
    public $plugin_root_file;

    public function __construct(string $plugin_id, string $plugin_root_file, PluginData $plugin_data)
    {
        $this->plugin_id = $plugin_id;
        $this->plugin_root_file = $plugin_root_file;
        $this->plugin_data = $plugin_data;
    }

    public function init()
    {
        Container::setInstance("{$this->plugin_id}-constants", new Constants($this->plugin_id, $this->plugin_data));
        Container::setInstance("{$this->plugin_id}-compatibility", new Compatibility($this->plugin_data));
        Container::setInstance("{$this->plugin_id}-I18n", new I18n($this->plugin_data));

        return $this;
    }

    public function run()
    {
        Container::getInstance("{$this->plugin_id}-constants")->define();
        Container::getInstance("{$this->plugin_id}-compatibility")->check();
        Container::getInstance("{$this->plugin_id}-I18n")->loadPluginTextDomain();
        Activation::register($this->plugin_root_file);
    }
}
