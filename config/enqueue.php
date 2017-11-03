<?php
/**
 * CSS and Javascript files to enqueue with WordPress.
 *
 * @package    Vendor\Plugin
 * @since      1.1.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */


 return array(

     /*********************************************************
     * Front-end stylesheets and scripts to enqueue
     *
     * Format:
     * 'stylesheets' => array(
     *     'plugin-name' => array(
     *         'file_name'    => 'plugin-name',
     *         'dependencies' => array(),
     *         'media'        => 'all',
     *     ),
     * ),
     * 'scripts' => array(
     *     'plugin-name' => array(
     *         'file_name'    => 'plugin-name',
     *         'dependencies' => array(),
     *         'in_footer'    => true,
     *     ),
     * ),
     ********************************************************/

    'stylesheets' => array(
        array(
            'file_name'    => 'plugin-name',
            'dependencies' => array(),
            'media'        => 'all',
        ),
        // array(
        //     'file_name'    => 'other-name',
        //     'dependencies' => array(),
        //     'media'        => 'all',
        // ),
    ),
    'scripts' => array(
        array(
            'file_name'    => 'plugin-name',
            'dependencies' => array(),
            'in_footer'    => true,
        ),
        // array(
        //     'file_name'    => 'other-name',
        //     'dependencies' => array(),
        //     'in_footer'    => true,
        // ),
    ),
);
