<?php
/**
 * Class that loads files and assets. (ie. SVG icons)
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/src
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor_Name\Plugin_Name;

class Loader {

    public function __construct( Plugin $plugin, $path, $file ) {
        $this->plugin = $plugin;
        $this->path = $path;
        $this->file = $file;
    }

    private function get() {
         return $this->path . $this->file;
    }

    public function require() {
        $file = $this->get();

        if ( file_exists( $file ) ) {
    		require_once( $file );
    	}
    }

}
