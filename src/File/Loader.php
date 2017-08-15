<?php
/**
 * Class that loads files and assets.
 *
 * @package    Vendor\Plugin\File
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\File;

class Loader
{
    /**
     * File or asset to load
     *
     * @var string
     */
    public $file;

    /**
     * Constructor
     *
     * @since 1.0.0
     * @param string    $file    File or asset to load
     */
    public function __construct( $file )
    {
        $this->file = $file;
    }

    /**
     * Load the file or asset
     *
     * @since  1.0.0
     * @return string
     */
    public function loadFile()
    {
        if ( ! file_exists( $this->file ) ) {
            return;
    	}

        ob_start();

        include $this->file;

        return ob_get_clean();
    }
}
