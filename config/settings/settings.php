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

    /*********************************************************
    * Top level custom admin pages
    *
    * Format:
    *   [
    * 'page_title' => $page_title,
    * 'menu_title' => $menu_title,
    * 'capability' => $capability,
    * 'menu_slug'  => $menu_slug,
    * 'callback'   => $callback,
    * 'icon_url'   => $icon_url,
    * 'position'   => $position,
    *   ],
    ********************************************************/

    'pages' => [
        [
            'page_title' => 'Starter Plugin',
            'menu_title' => 'Starter Plugin',
            'capability' => 'manage_options',
            'menu_slug'  => 'starter-plugin',
            'template'   => 'starter-plugin',
            'icon_url'   => 'dashicons-external',
            'position'   => 110,
        ],
    ],

    /*********************************************************
    * Custom admin subpages
    *
    * Format:
    *   [
    * 'parent_slug' => $parent_slug,
    * 'page_title'  => $page_title,
    * 'menu_title'  => $menu_title,
    * 'capability'  => $capability,
    * 'menu_slug'   => $menu_slug,
    * 'callback'    => $callback,
    *   ],
    *
    * The following 'parent_slug' values (case sensitive] may be used to add subpages to the default top-level WordPress settings pages:
    *
    * Dashboard : 'parent_slug' => 'Dashboard',
    * Posts     : 'parent_slug' => 'Posts',
    * Media     : 'parent_slug' => 'Media',
    * Pages     : 'parent_slug' => 'Pages',
    * Comments  : 'parent_slug' => 'Comments',
    * Appearance: 'parent_slug' => 'Appearance',
    * Plugins   : 'parent_slug' => 'Plugins',
    * Users     : 'parent_slug' => 'Users',
    * Tools     : 'parent_slug' => 'Tools',
    * Settings  : 'parent_slug' => 'Settings',
    *
    ********************************************************/
    'subpages' => [
        [
            'parent_slug' => 'starter-plugin',
            'page_title'  => 'CPT Options',
            'menu_title'  => 'CPT',
            'capability'  => 'manage_options',
            'menu_slug'   => 'starter-plugin-cpt',
            'template'    => 'starter-plugin-cpt',
        ],
        [
            'parent_slug' => 'starter-plugin',
            'page_title'  => 'Taxonomy Options',
            'menu_title'  => 'Taxonomy',
            'capability'  => 'manage_options',
            'menu_slug'   => 'starter-plugin-taxonomy',
            'template'    => 'starter-plugin-taxonomy',
        ],
        [
            'parent_slug' => 'starter-plugin',
            'page_title'  => 'Other Options',
            'menu_title'  => 'Other',
            'capability'  => 'manage_options',
            'menu_slug'   => 'starter-plugin-other',
            'template'    => 'starter-plugin-other',
        ],
    ],

    /*********************************************************
    * Admin custom sections
    *
    * Format:
    *   [
    * 'id'       => $id,
    * 'title'    => $title,
    * 'callback' => $callback,
    * 'page'     => $page,
    *   ],
    ********************************************************/

    'sections' => [
        [
            'id'       => 'user_profile',
            'title'    => 'User Profile',
            'template' => 'user-profile',
            'page'     => 'starter-plugin',
        ],
        [
            'id'       => 'user_interests',
            'title'    => 'User Interests',
            'template' => 'user-interests',
            'page'     => 'starter-plugin',
        ],
    ],

    /*********************************************************
    * Admin custom fields
    *
    * Format:
    *   [
    * 'id'         => $id,
    * 'title'      => $title,
    * 'callback'   => $callback,
    * 'page'       => $page,
    * 'section'    => $section,
    * 'attributes' => $args,
    *   ],
    ********************************************************/

    'settings' => [
        [
            'id'          => 'user_bio',
            'title'       => 'User Biography',
            'page'        => 'starter-plugin',
            'section'     => 'user_profile',
            'description' => 'The user should describe themselves here',
            'helper'      => 'This is the helper.',
            'type'        => 'textarea',
            'options'     => [
                'placeholder' => 'Last name',
            ],
        ],

        [
            'id'          => 'first_name',
            'title'       => 'First Name',
            'page'        => 'starter-plugin',
            'section'     => 'user_profile',
            'description' => '',
            'helper'      => '',
            'type'        => 'text',
            'options'     => [
                'placeholder' => 'First name',
                'required'    => true,
            ],
        ],

        [
            'id'         => 'favorite_movie',
            'title'      => 'Favorite Movie',
            'page'       => 'starter-plugin',
            'section'    => 'user_profile',
            'type'       => 'checkbox',
            'options' => [
                'label'   => 'The Dark Knight',
                'checked' => true,
            ],
        ],

        [
            'id'         => 'favorite_color',
            'title'      => 'Favorite Color',
            'page'       => 'starter-plugin',
            'section'    => 'user_profile',
            'type'       => 'checkbox',
            'options' => [
                [
                    'label'   => 'Blue sky',
                    'checked' => true,
                ],
                [
                    'label'     => 'Red sun',
                ],
                [
                    'label'     => 'Green grass',
                ],
                [
                    'label'     => 'White sand',
                ],
            ],
        ],

        [
            'id'         => 'favorite_foods',
            'title'      => 'Favorite Foods',
            'page'       => 'starter-plugin',
            'section'    => 'user_profile',
            'type'       => 'select',
            'options' => [
                'option_1' => [
                    'label'     => 'Pizza',
                ],
                'option_2' => [
                    'label'     => 'Cheeseburgers',
                    'selected' => true,
                ],
                'option_3' => [
                    'label'     => 'French Fries',
                ],
            ],
        ],

        [
            'id'         => 'favorite_car',
            'title'      => 'Favorite Car',
            'page'       => 'starter-plugin',
            'section'    => 'user_profile',
            'type'       => 'radio',
            'options' => [
                'option_1' => [
                    'label'     => 'Ford',
                ],
                'option_2' => [
                    'label'     => 'Chevy',
                    'checked' => true,
                ],
                'option_3' => [
                    'label'     => 'Toyota',
                ],
            ],
        ],
        
        [
            'id'         => 'user_password',
            'title'      => 'Password',
            'page'       => 'starter-plugin',
            'section'    => 'user_profile',
            'type'       => 'password',
            'options' => [
                'placeholder' => 'Must contain 8-12 characters',
                'required'    => true,
            ],
        ],

        [
            'id'         => 'favorite_sports',
            'title'      => 'Favorite Sports',
            'page'       => 'starter-plugin',
            'section'    => 'user_profile',
            'type'       => 'multiselect',
            'options' => [
                'option_1' => [
                    'label'     => 'Football',
                ],
                'option_2' => [
                    'label'     => 'Baseball',
                    'selected' => true,
                ],
                'option_3' => [
                    'label'     => 'Basketball',
                ],
            ],
        ],

        [
            'id'         => 'favorite_city',
            'title'      => 'Favorite City',
            'page'       => 'starter-plugin',
            'section'    => 'user_profile',
            'type'       => 'select',
            'options' => [
                'option_1' => [
                    'label'     => 'New York',
                ],
                'option_2' => [
                    'label'     => 'Boston',
                ],
                'option_3' => [
                    'label'     => 'Los Angeles',
                ],
            ],
        ],

        [
            'id'         => 'custom_option',
            'title'      => 'Custom Option',
            'page'       => 'starter-plugin',
            'section'    => 'user_profile',
            'type'       => 'custom',
            'options' => [
                'file_name' => 'custom.php',
                'callback' => '',
            ],
        ],
    ],

    /*********************************************************
    * The URL for the plugin's "Settings" link on the WordPress plugins activation page.
    *
    * By default, the "Settings" link URL will be set to the first page defined below in this configuration array. If no page is set, the URL will then default
    * to the first subpage defined below in this configuration array.
    *
    * These defaults will be overrided if a 'settings_url' is defined here.
    *
    * Format:
    * 'settings_url' => $settings_url,
    *
    ********************************************************/

    'settings_link' => 'options.php',

    /*********************************************************
    *
    * The default settings configuration.
    *
    ********************************************************/
    // 'defaults' => [
    //     'pages' => [
    //         'page_title'   => '',
    //         'menu_title'   => '',
    //         'capability'   => 'manage_options',
    //         'menu_slug'    => '',
    //         'option_name'  => '',
    //         'template'     => '',
    //         'icon_url'     => '',
    //         'position'     => 110,
    //         'register_settings_args' => [
    //             'type'              => '',
    //             'description'       => '',
    //             'sanitize_callback' => null,
    //             'show_in_rest'      => false,
    //             'default'           => [],
    //         ],
    //     ],
    
    //     'subpages' => [
    //         'parent_slug'  => '',
    //         'page_title'   => '',
    //         'menu_title'   => '',
    //         'capability'   => 'manage_options',
    //         'menu_slug'    => '',
    //         'option_name'  => '',
    //         'template'     => '',
    //         'register_settings_args' => [
    //             'type'              => '',
    //             'description'       => '',
    //             'sanitize_callback' => null,
    //             'show_in_rest'      => false,
    //             'default'           => [],
    //         ],
    //     ],
    
    //     'sections' => [
    //         'id'       => '',
    //         'title'    => '',
    //         'template' => '',
    //         'page'     => '',
    //     ],
    
    //     'settings' => [
    //         'id'          => '',
    //         'title'       => '',
    //         'page'        => '',
    //         'option_name' => '',
    //         'section'     => 'default',
    //         'description' => '',
    //         'helper'      => '',
    //         'type'        => '',
    //         'options'     => [],
    //     ],
    
    //     'settings_link' => '',
    // ],
];
