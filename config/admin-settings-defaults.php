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
        'page_title' => 'Starter Plugin',
        'menu_title' => 'Starter Plugin',
        'capability' => 'manage_options',
        'menu_slug'  => 'starter-plugin',
        'template'   => 'starter-plugin',
        'icon_url'   => 'dashicons-external',
        'position'   => 110,
        'register_settings_args' => array(
            'type'              => '',
            'description'       => '',
            'sanitize_callback' => null,
            'show_in_rest'      => false,
            'default'           => array(),
        ),
    ),

    'subpages' => array(
        'parent_slug' => '',
        'page_title'  => '',
        'menu_title'  => '',
        'capability'  => '',
        'menu_slug'   => '',
        'template'    => '',
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
        'section'     => 'default',
        'description' => '',
        'helper'      => '',
        'type'        => '',
        'options'     => array(),
    ),

    'settings_url' => '',
);
