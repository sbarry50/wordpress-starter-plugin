<?php
/**
 * Class that defines the plugin's constants.
 *
 * @package    Plugin
 * @subpackage Plugin/src
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */
namespace Vendor\Plugin;

class Constants {

    /**
     * The root file of the plugin
     * @var string   $plugin_root_file    The plugin's root file
     */
    public $plugin_root_file;

    /**
     * The metadata from the plugin's header comment doc block.
     * @var array    $plugin_header_data    The plugin's header metadata
     */
    protected $plugin_header_data = [];

    /**
     * The plugin's URL
     * @var string    $plugin_url    The plugin url
     */
    protected $plugin_url;

    /**
     * The plugin's distribution path configuration
     * @var array    $dist_path_config    Distribution path config
     */
    protected $path_config = [];

    /**
     * The plugin's miniumum requirements configuration
     * @var array    $requirements_config    Miniumum requirements config
     */
    protected $requirements_config = [];

    /**
     * The constants defined for this plugin
     * @var array    $constants    The array of constants
     */
    protected $constants = [];

    /**
     * Initializes the class by taking in and setting the value of the plugin's root file
     * @since 1.0.0
     * @param string    $plugin_root_file  The plugin's root file
     */
    public function __construct( $plugin_root_file ) {
        $this->plugin_root_file = $plugin_root_file;
    }

    /**
     * Initiliazes the values of the instance data.
     * @since  1.0.0
     * @return object    $this    Instance of this object
     */
    public function init() {
        $this->plugin_header_data = $this->get_plugin_header_data();
        $this->plugin_url = $this->get_plugin_url();

        $config = new Config( 'plugin.php' );
        $this->path_config = $config->parse( 'paths' );
        $this->requirements_config = $config->parse( 'requirements' );

        $this->constants = $this->get_constants();

        return $this;
    }

    /**
     * Defines the plugin's constants
     *
     * @since  1.0.0
     */
    public function define() {

        foreach ( $this->constants as $constant => $value ) {
            if ( ! defined( $constant ) ) {
                define( __NAMESPACE__ . "\\{$constant}", $value );
            }
        }

    }

    /**
     * Gets the array of plugin constants
     *
     * @since  1.0.0
     */
    public function get_constants() {
        return array(
            'PLUGIN_ROOT'            => $this->plugin_root_file,
            'PLUGIN_NAME'            => $this->plugin_header_data[ 'Name' ],
            'PLUGIN_BASENAME'        => plugin_basename( $this->plugin_root_file ),
            'PLUGIN_DIR'             => plugin_dir_path( $this->plugin_root_file ),
            'PLUGIN_DIR_URL'         => plugin_dir_url( plugin_dir_path( $this->plugin_root_file ) ),
            'PLUGIN_URL'             => $this->get_plugin_url(),
            'PLUGIN_TEXT_DOMAIN'     => $this->plugin_header_data[ 'TextDomain' ],
            'PLUGIN_VERSION'         => $this->plugin_header_data[ 'Version' ],
            'PLUGIN_MIN_PHP_VERSION' => $this->requirements_config[ 'min_php' ],
            'PLUGIN_MIN_WP_VERSION'  => $this->requirements_config[ 'min_wp' ],
            'PLUGIN_ASSETS_PATH'     => $this->path_config[ 'assets' ],
            'PLUGIN_CONFIG_PATH'     => $this->path_config[ 'config' ],
            'PLUGIN_DIST_PATH'       => $this->path_config[ 'dist' ],
            'PLUGIN_LANG_PATH'       => $this->path_config[ 'lang' ],
            'PLUGIN_SRC_PATH'        => $this->path_config[ 'src' ],
            'PLUGIN_TEST_PATH'       => $this->path_config[ 'test' ],
            'PLUGIN_VIEWS_PATH'      => $this->path_config[ 'views' ],
            'WP_VERSION'             => get_bloginfo('version'),
        );

    }

    /**
     * Gets the plugin URL
     *
     * @since  1.0.0
     * @return string    $plugin_url       The plugin URL
     */
    private function get_plugin_url() {
        $plugin_url = plugin_dir_url( $this->plugin_root_file );
        if ( is_ssl() ) {
            $plugin_url = str_replace( 'http://', 'https://', $plugin_url );
        }

        return $plugin_url;
    }

    /**
     * Gets plugin data from the plugin's bootstrap file header comment using WP core's get_plugin_data function
     *
     * @since  1.0.0
     * @return array                       Array of plugin data from the bootstrap file header comment
     */
    private function get_plugin_header_data() {
        if ( ! function_exists( 'get_plugin_data' ) ) {
            require_once ABSPATH . '/wp-admin/includes/plugin.php';
        }
        return \get_plugin_data( $this->plugin_root_file );
    }
}
