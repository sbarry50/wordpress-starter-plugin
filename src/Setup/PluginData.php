<?php
/**
 * Helper class for retrieving plugin data
 *
 * @package    SB2Media\Hub\Support
 * @since      0.2.0
 * @author     sbarry
 * @link       http://sb2media.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\Hub\Setup;

use function SB2Media\Hub\getPluginData;

class PluginData
{
    /**
     * The plugin ID
     *
     * @since 0.5.0
     * @var string
     */
    public $plugin_id;

    /**
     * The plugin name
     *
     * @since 0.5.0
     * @var string
     */
    public $plugin_name;

    /**
     * The plugin name
     *
     * @since 0.5.0
     * @var string
     */
    public $plugin_version;

    /**
     * The plugin root file
     *
     * @var string
     */
    public $plugin_root_file;

    /**
     * Contructor
     *
     * @since 0.5.0
     * @param string $plugin_root_file
     * @return void
     */
    public function __construct(string $plugin_root_file)
    {
        $this->plugin_root_file = $plugin_root_file;
        $this->plugin_name = getPluginData('name', $plugin_root_file);
        $this->plugin_id = strtolower(str_replace(' ', '-', $this->plugin_name));
        $this->plugin_version = getPluginData('version', $plugin_root_file);
    }

    /**
     * Get plugin basename
     *
     * @since  0.2.0
     * @return string
     */
    public function basename()
    {
        return plugin_basename($this->plugin_root_file);
    }
    
    /**
     * Get root plugin path or subdirectory path
     *
     * @param string    $subdir    Directory to return path of
     * @since 0.2.0
     * @return string   By default, returns root file path of plugin. Returns subdirectory file path if subdirectory parameter passed.
     */
    public function path(string $subdir = '')
    {
        if (! function_exists('plugin_dir_path')) {
            require_once ABSPATH . '/wp-admin/includes/plugin.php';
        }
        
        $plugin_root_path = \plugin_dir_path($this->plugin_root_file);
        
        if (!empty($subdir)) {
            return $plugin_root_path . $subdir . '/';
        }
        
        return $plugin_root_path;
    }
    
    /**
     * Get the plugin's root directory Paths
     *
     * @since 0.2.0
     * @return string
     */
    public function url(string $subdir = '')
    {
        $plugin_dir_url = \plugin_dir_url($this->plugin_root_file);
        
        if (is_ssl()) {
            $plugin_dir_url = str_replace('http://', 'https://', $plugin_dir_url);
        }
        
        if (!empty($subdir)) {
            return $plugin_dir_url . $subdir . '/';
        }
        
        return $plugin_dir_url;
    }

    /**
     * Get plugin data from the plugin's bootstrap file header comment using WP core's get_file_data function
     *
     * @since  0.2.0
     * @param  string    $id    Plugin header data unique id
     * @return array            Array of plugin data from the bootstrap file header comment
     */
    public function headerData(string $id)
    {
        $default_headers = array(
            'name' => 'Plugin Name',
            'plugin-uri' => 'Plugin URI',
            'version' => 'Version',
            'description' => 'Description',
            'author' => 'Author',
            'authorURI' => 'Author URI',
            'text-domain' => 'Text Domain',
            'domain-path' => 'Domain Path',
            'network' => 'Network',
            // Site Wide Only is deprecated in favor of Network.
            '_sitewide' => 'Site Wide Only',
        );

        return get_file_data($this->plugin_root_file, $default_headers)[$id];
    }
}
