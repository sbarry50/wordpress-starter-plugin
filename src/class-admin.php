<?php
/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Plugin
 * @subpackage Plugin/src
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin;

class Admin {

 	/**
 	 * The plugin's instance.
 	 *
 	 * @since  1.0.0
 	 * @access private
 	 * @var    Plugin $plugin This plugin's instance.
 	 */
 	private $plugin;

 	/**
 	 * Initialize the class and set its properties.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @param Plugin $plugin This plugin's instance.
 	 */
 	public function __construct( Plugin $plugin ) {
 		$this->plugin = $plugin;
 	}

 	/**
 	 * Register the stylesheets for the Dashboard.
 	 *
 	 * @since    1.0.0
 	 */
 	public function enqueue_styles() {

 		/**
 		 * This function is provided for demonstration purposes only.
 		 *
 		 * An instance of this class should be passed to the run() function
 		 * defined in Register as all of the hooks are defined
 		 * in that particular class.
 		 *
 		 * The Register will then create the relationship
 		 * between the defined hooks and the functions defined in this
 		 * class.
 		 */

 		\wp_enqueue_style(
 			PLUGIN_TEXT_DOMAIN,
 			PLUGIN_DIR_URL . 'dist/styles/plugin-name-admin.css',
 			array(),
 			PLUGIN_VERSION,
 			'all' );

 	}

 	/**
 	 * Register the JavaScript for the dashboard.
 	 *
 	 * @since    1.0.0
 	 */
 	public function enqueue_scripts() {

 		/**
 		 * This function is provided for demonstration purposes only.
 		 *
 		 * An instance of this class should be passed to the run() function
 		 * defined in SVGIcons_Loader as all of the hooks are defined
 		 * in that particular class.
 		 *
 		 * The SVGIcons_Loader will then create the relationship
 		 * between the defined hooks and the functions defined in this
 		 * class.
 		 */

 		\wp_enqueue_script(
 			PLUGIN_TEXT_DOMAIN,
 			PLUGIN_DIR_URL . 'dist/scripts/plugin-name-admin.js',
 			array( 'jquery' ),
 			PLUGIN_VERSION,
 			false );

	}

}
