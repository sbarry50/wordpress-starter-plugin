<?php
/**
 * Handler for the plugin's configuration files.
 *
 * @package    Plugin
 * @subpackage Plugin/src
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */
namespace Vendor\Plugin;

class Config {

    /**
     * The plugin's configuration data
     * @var array    $config    Configuration data
     */
    protected $config = array();

    /**
     * The file that contains the configuration array.
     * @var string     $file     Configuration file
     */
    public $config_file;

    public function __construct( $config_file ) {
        $this->config_file = $config_file;
        $this->set_config();
    }

    private function set_config() {
        $this->config = include( plugin_dir_path( dirname( __FILE__ ) ) . '/config/' . $this->config_file );
    }

    public function get_config() {
        return $this->config;
    }

    public function get_config_index( $index ) {
        if( isset( $this->config[ $index ] ) ) {
            return $this->config[ $index ];
        } else {
            return $this->config;
        }
    }

}
