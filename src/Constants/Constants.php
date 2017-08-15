<?php
/**
 * Class that defines the plugin's constants.
 *
 * @package    Vendor\Plugin\Constants
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */
namespace Vendor\Plugin\Constants;

use Vendor\Plugin\Config\ConfigInterface;

class Constants implements ConstantsInterface
{
    /**
     * The root file of the plugin
     *
     * @var string   $plugin_root_file    The plugin's root file
     */
    public $plugin_root_file;

    /**
     * The configuration parameters
     *
     * @var array    $config    Plugin configuration parameters
     */
    public $config = array();

    /**
     * The constants defined for this plugin
     *
     * @var array    $constants    The array of constants
     */
    protected $constants = array();

    /**
     * Initiliazes the values of the instance data.
     *
     * @since  1.0.0
     * @param  string             $plugin_root_file   The root file of the plugin
     * @param  ConfigInterface    $config             Instance of the configuration interface
     * @return object             $this
     */
    public function init( $plugin_root_file, ConfigInterface $config )
    {
        $this->plugin_root_file = $plugin_root_file;
        $this->config = $config;
        $this->constants = $this->getInitConstants();

        return $this;
    }

    /**
     * Defines the plugin's constants
     *
     * @since  1.0.0
     */
    public function define()
    {
        foreach ( $this->constants as $constant => $value ) {
            if ( ! defined( __NAMESPACE__ . "\\{$constant}" ) ) {
                define( __NAMESPACE__ . "\\{$constant}", $value );
            }
        }
    }

    /**
     * Add additional constants to the default constants array
     *
     * @since 1.0.0
     * @return array    $this->constants    The plugin constants
     */
    public function add( array $constants )
    {
        $this->constants = array_merge( $this->constants, $constants );

        return $this;
    }

    /**
     * Gets the initial array of plugin constants
     *
     * @since  1.0.0
     */
    public function getInitConstants()
    {
        $plugin_header_data = $this->getPluginHeaderData();
        $plugin_url = $this->getPluginURL();
        $path_config = $this->config->get( 'paths' );
        $requirements_config = $this->config->get( 'requirements' );

        return array(
            'PLUGIN_ROOT'            => $this->plugin_root_file,
            'PLUGIN_NAME'            => $plugin_header_data[ 'Name' ],
            'PLUGIN_BASENAME'        => plugin_basename( $this->plugin_root_file ),
            'PLUGIN_DIR'             => plugin_dir_path( $this->plugin_root_file ),
            'PLUGIN_DIR_URL'         => plugin_dir_url( plugin_dir_path( $this->plugin_root_file ) ),
            'PLUGIN_URL'             => $plugin_url,
            'PLUGIN_TEXT_DOMAIN'     => $plugin_header_data[ 'TextDomain' ],
            'PLUGIN_VERSION'         => $plugin_header_data[ 'Version' ],
            'PLUGIN_MIN_PHP_VERSION' => $requirements_config[ 'min_php' ],
            'PLUGIN_MIN_WP_VERSION'  => $requirements_config[ 'min_wp' ],
            'PLUGIN_ASSETS_PATH'     => $path_config[ 'assets' ],
            'PLUGIN_CONFIG_PATH'     => $path_config[ 'config' ],
            'PLUGIN_DIST_PATH'       => $path_config[ 'dist' ],
            'PLUGIN_LANG_PATH'       => $path_config[ 'lang' ],
            'PLUGIN_SRC_PATH'        => $path_config[ 'src' ],
            'PLUGIN_TEST_PATH'       => $path_config[ 'test' ],
            'PLUGIN_VIEWS_PATH'      => $path_config[ 'views' ],
            'WP_VERSION'             => get_bloginfo('version'),
        );
    }

    /**
     * Get the array of constants
     * @since  1.0.0
     * @return array    $this->constants    Plugin constants
     */
    public function getConstants()
    {
        return $this->constants;
    }

    /**
     * Get the plugin URL
     *
     * @since  1.0.0
     * @return string    $plugin_url       The plugin URL
     */
    protected function getPluginURL()
    {
        $plugin_url = plugin_dir_url( $this->plugin_root_file );
        if ( is_ssl() ) {
            $plugin_url = str_replace( 'http://', 'https://', $plugin_url );
        }

        return $plugin_url;
    }

    /**
     * Get plugin data from the plugin's bootstrap file header comment using WP core's get_plugin_data function
     *
     * @since  1.0.0
     * @return array                       Array of plugin data from the bootstrap file header comment
     */
    protected function getPluginHeaderData()
    {
        if ( ! function_exists( 'get_plugin_data' ) ) {
            require_once ABSPATH . '/wp-admin/includes/plugin.php';
        }
        return \get_plugin_data( $this->plugin_root_file );
    }
}
