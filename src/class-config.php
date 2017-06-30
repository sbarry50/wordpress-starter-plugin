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
    protected $config = [];

    /**
     * The name of the file that contains the configuration array.
     * @var string     $file     Configuration file name
     */
    public $filename;

    /**
     * Accept the configuration file and create a new instance of the the configuration object
     *
     * @since 1.0.0
     * @param string   $filename    Name of the configuration file
     */
    public function __construct( $filename ) {
        $this->filename = $filename;
        $this->init();
    }

    /**
     * Initialize the configuration values of the instance
     *
     * @since  1.0.0
     */
    private function init() {
        $config_file = plugin_dir_path( dirname( __FILE__ ) ) . 'config/' . $this->filename;
        if( file_exists( $config_file ) ) {
            $this->config = include( $config_file );
        }
    }

    /**
     * Get all of the configuration data
     * 
     * @since  1.0.0
     * @return array    $this->config    This instance of the configuration
     */
    public function all() {
        return $this->config;
    }

    /**
     * Parse the main configuration array by key
     *
     * @since  1.0.0
     * @param  string    $key                     The key to be parsed
     * @return array     $this->config[ $key ]    Array after parsed
     */
    public function parse( $key ) {
        return isset( $this->config[ $key ] ) ? $this->config[ $key ] : NULL;
    }
}
