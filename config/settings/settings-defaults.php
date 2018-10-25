<?php
/**
 * Custom WordPress administration pages and settings configuration parameters
 *
 * @package    Vendor\Plugin
 * @since      0.3.0
 * @author     sbarry
 * @link       http: //example.com
 * @license    GNU General Public License 2.0+
 */

return array(

    'pages' => array(
        'page_title'   => '',
        'menu_title'   => '',
        'capability'   => 'manage_options',
        'menu_slug'    => '',
        'option_name'  => '',
        'template'     => '',
        'icon_url'     => '',
        'position'     => 110,
        'register_settings_args' => array(
            'type'              => '',
            'description'       => '',
            'sanitize_callback' => null,
            'show_in_rest'      => false,
            'default'           => array(),
        ),
    ),

    'subpages' => array(
        'parent_slug'  => '',
        'page_title'   => '',
        'menu_title'   => '',
        'capability'   => 'manage_options',
        'menu_slug'    => '',
        'option_name'  => '',
        'template'     => '',
        'register_settings_args' => array(
            'type'              => '',
            'description'       => '',
            'sanitize_callback' => null,
            'show_in_rest'      => false,
            'default'           => array(),
        ),
    ),

    'sections' => array(
        'id'       => '',
        'title'    => '',
        'template' => '',
        'page'     => '',
    ),

    'settings' => array(
        'id'          => '',
        'title'       => '',
        'page'        => '',
        'option_name' => '',
        'section'     => 'default',
        'description' => '',
        'helper'      => '',
        'type'        => '',
        'options'     => array(),
    ),

    'settings_link' => '',
);
