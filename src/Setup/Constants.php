<?php
/**
 * Class that defines the plugin's constants.
 *
 * @package    SB2Media\Hub
 * @since      0.1.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */
namespace SB2Media\Hub\Setup;

class Constants implements ConstantsInterface
{

    /**
     * The constants prefix
     *
     * @var string
     */
    public $constants_prefix;

    /**
     * The constants array
     *
     * @var array
     */
    public $constants = [];

    /**
     * Constructor
     *
     * @since  0.1.0
     */
    public function __construct(string $plugin_id, PluginData $plugin_data)
    {
        $this->constants_prefix = $this->getConstantsPrefix($plugin_id);
        $this->constants = $this->build($plugin_data);
    }

    /**
     * Defines the plugin's constants
     *
     * @since  0.1.0
     */
    public function define()
    {
        foreach ($this->constants as $constant => $value) {
            if (! defined($constant)) {
                define($constant, $value);
            }
        }
    }

    /**
     * Add additional constants to the default constants array
     *
     * @since 0.1.0
     * @return array    $this->constants    The plugin constants
     */
    public function add(array $constants)
    {
        $this->constants = array_merge($this->constants, $constants);

        return $this;
    }

    /**
     * Get the array of constants
     * @since  0.1.0
     * @return array    $this->constants    Plugin constants
     */
    public function get()
    {
        return $this->constants;
    }

    /**
     * Build the constants configuration array
     *
     * @since   0.5.0
     * @param string    $constants_prefix
     * @param PluginData    $plugin_data
     * @return array
     */
    protected function build(PluginData $plugin_data)
    {
        return [
            "{$this->constants_prefix}_ROOT"        => $plugin_data->plugin_root_file,
            "{$this->constants_prefix}_NAME"        => $plugin_data->headerData('name'),
            "{$this->constants_prefix}_BASENAME"    => $plugin_data->basename(),
            "{$this->constants_prefix}_DIR_PATH"    => $plugin_data->path(),
            "{$this->constants_prefix}_DIR_URL"     => $plugin_data->url(),
            "{$this->constants_prefix}_TEXT_DOMAIN" => $plugin_data->headerData('text-domain'),
            "{$this->constants_prefix}_VERSION"     => $plugin_data->headerData('version'),
        ];
    }

    /**
     * Convert the plugin id to the constants prefix
     *
     * @since 0.5.0
     * @param string $plugin_id
     * @return string
     */
    protected function getConstantsPrefix($plugin_id)
    {
        return strtoupper(str_replace('-', '_', $plugin_id));
    }
}
