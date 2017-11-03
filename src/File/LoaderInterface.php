<?php
/**
 * Interface for loading files, assets and views.
 *
 * @package    Vendor\Plugin\File
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\File;

use Exception;

interface LoaderInterface
{

    /**
     * Load a file
     *
     * @since  1.1.0
     * @param  string    $file     The direct path and filename of the file to be loaded
     * @return                     The contents of the file
     */
    public function loadFile( $file );

    /**
     * Load a view file or asset that requires output buffering
     *
     * @since  1.1.0
     * @param  string    $file     The direct path and filename of the file to be loaded
     * @return string              The contents of the file
     */
    public function loadOutputFile( $file );

}
