<?php
/**
 * Custom WordPress administration pages and settings configuration parameters
 *
 * @package    SB2Media\Hub
 * @since      0.3.0
 * @author     sbarry
 * @link       http: //example.com
 * @license    GNU General Public License 2.0+
 */

return [

    'pages' => [
        'page_title'   => '',
        'menu_title'   => '',
        'capability'   => 'manage_options',
        'menu_slug'    => '',
        'option_name'  => '',
        'template'     => '',
        'icon_url'     => '',
        'position'     => 110,
        'register_settings_args' => [
            'type'              => '',
            'description'       => '',
            'sanitize_callback' => null,
            'show_in_rest'      => false,
            'default'           => [],
        ],
    ],

    'subpages' => [
        'parent_slug'  => '',
        'page_title'   => '',
        'menu_title'   => '',
        'capability'   => 'manage_options',
        'menu_slug'    => '',
        'option_name'  => '',
        'template'     => '',
        'register_settings_args' => [
            'type'              => '',
            'description'       => '',
            'sanitize_callback' => null,
            'show_in_rest'      => false,
            'default'           => [],
        ],
    ],

    'sections' => [
        'id'       => '',
        'title'    => '',
        'template' => '',
        'page'     => '',
    ],

    'settings' => [
        'id'          => '',
        'title'       => '',
        'page'        => '',
        'option_name' => '',
        'section'     => 'default',
        'description' => '',
        'helper'      => '',
        'type'        => '',
        'options'     => [],
    ],

    'settings_link' => '',
];
