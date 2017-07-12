<?php
/**
 * The core plugin class.
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * @package    Plugin
 * @subpackage Plugin/src
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin;

use Vendor\Plugin\Constants as Constants;

class Plugin {

	/**
	 * The hook registrar that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Register    $register    Maintains and registers all hooks for the plugin.
	 */
	protected $register;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Create an instance of the hook registrar which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->register = new Register();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new I18n();
		$plugin_i18n->set_domain( Constants\PLUGIN_TEXT_DOMAIN );
		$plugin_i18n->load_plugin_textdomain();

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_admin_hooks() {

		$plugin_admin = new Admin( $this );

		$this->register->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->register->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_frontend_hooks() {

		$plugin_frontend = new Frontend( $this );

		$this->register->add_action( 'wp_enqueue_scripts', $plugin_frontend, 'enqueue_styles' );
		$this->register->add_action( 'wp_enqueue_scripts', $plugin_frontend, 'enqueue_scripts' );

	}

	/**
	 * Loads a file such as an SVG
	 *
	 * @since    1.0.0
	 * @param	   string 				$path			  Path to the file
	 * @param	   string 				$file 			  Name of the file to be loaded
	 * @param      string               $hook             The name of the WordPress filter that is being registered.
	 * @param      string               $callback         The name of the function definition on the $component.
	 * @param      int      Optional    $priority         The priority at which the function should be fired.
	 * @param      int      Optional    $accepted_args    The number of arguments that should be passed to the $callback.
	 */
	private function load_file( $path, $file, $hook, $callback, $priority = 10, $accepted_args = 1 ) {
		$file = new Loader( $this, $path, $file );

		$this->register->add_action( $hook, $file, $callback, $priority, $accepted_args );
	}

	/**
	 * Run the hooks loader to execute all of the hooks with WordPress.
	 *
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->set_locale();
		// $this->register_admin_hooks();
		// $this->register_frontend_hooks();
		$this->register->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Register    Orchestrates the hooks of the plugin.
	 */
	public function get_register() {
		return $this->register;
	}

}
