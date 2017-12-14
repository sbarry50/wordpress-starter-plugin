<?php
/**
 * Custom WordPress administration pages and settings configuration parameters
 *
 * @package    Vendor\Plugin
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */


return [

    /*********************************************************
    * Top level custom admin pages
    *
    * Format:
    *   [
    *       'page_title' => $page_title,
    *       'menu_title' => $menu_title,
    *       'capability' => $capability,
    *       'menu_slug'  => $menu_slug,
    *       'callback'   => $callback,
    *       'icon_url'   => $icon_url,
    *       'position'   => $position,
    *   ],
    ********************************************************/

    'pages' => [
        // [
        //     'page_title' => 'Starter Plugin',
        //     'menu_title' => 'Starter Plugin',
        //     'capability' => 'manage_options',
        //     'menu_slug'  => 'starter-plugin',
        //     'callback'   => function () { return Vendor\Plugin\Container\Container::instance()->get( 'callbacks' )->loadView( 'starter-plugin' ); },
        //     'icon_url'   => 'dashicons-external',
        //     'position'   => 110,
        // ],
    ],

    /*********************************************************
    * Custom admin subpages
    *
    * Format:
    *   [
    *       'parent_slug' => $parent_slug,
    *       'page_title'  => $page_title,
    *       'menu_title'  => $menu_title,
    *       'capability'  => $capability,
    *       'menu_slug'   => $menu_slug,
    *       'callback'    => $callback,
    *   ],
    *
    * The following 'parent_slug' values (case sensitive) may be used to add subpages to the default top-level WordPress settings pages:
    *
    *       Dashboard:  'parent_slug' => 'Dashboard',
    *       Posts:      'parent_slug' => 'Posts',
    *       Media:      'parent_slug' => 'Media',
    *       Pages:      'parent_slug' => 'Pages',
    *       Comments:   'parent_slug' => 'Comments',
    *       Appearance: 'parent_slug' => 'Appearance',
    *       Plugins:    'parent_slug' => 'Plugins',
    *       Users:      'parent_slug' => 'Users',
    *       Tools:      'parent_slug' => 'Tools',
    *       Settings:   'parent_slug' => 'Settings',
    *
    ********************************************************/
    'subpages' => [
        [
            'parent_slug' => 'Dashboard',
            'page_title'  => 'CPT Options',
            'menu_title'  => 'CPT',
            'capability'  => 'manage_options',
            'menu_slug'   => 'starter-plugin-cpt',
            'callback'    => function () { return Vendor\Plugin\Container\Container::instance()->get( 'callbacks' )->loadView( 'starter-plugin-cpt' ); },
        ],
        [
            'parent_slug' => 'Dashboard',
            'page_title'  => 'Taxonomy Options',
            'menu_title'  => 'Taxonomy',
            'capability'  => 'manage_options',
            'menu_slug'   => 'starter-plugin-taxonomy',
            'callback'    => function () { return Vendor\Plugin\Container\Container::instance()->get( 'callbacks' )->loadView( 'starter-plugin-taxonomy' ); },
        ],
        [
            'parent_slug' => 'Dashboard',
            'page_title'  => 'Other Options',
            'menu_title'  => 'Other',
            'capability'  => 'manage_options',
            'menu_slug'   => 'starter-plugin-other',
            'callback'    => function () { return Vendor\Plugin\Container\Container::instance()->get( 'callbacks' )->loadView( 'starter-plugin-other' ); },
        ],
    ],

    /*********************************************************
    * Admin registered settings
    *
    * Format:
    *   [
    *       'option_group' => $option_group,
    *       'option_name'  => $option_name,
    *       'callback'     => $callback,
    *   ],
    ********************************************************/

    'settings' => [
        [
            'option_group' => '',
            'option_name'  => '',
            'callback'     => '',
        ],
    ],

    /*********************************************************
    * Admin custom sections
    *
    * Format:
    *   [
    *       'id'         => $id,
    *       'title'      => $title,
    *       'callback'   => $callback,
    *       'page'       => $page,
    *   ],
    ********************************************************/

    'sections' => [
        [
            'id'        => '',
            'title'     => '',
            'callback'  => '',
            'page'      => '',
        ],
    ],

    /*********************************************************
    * Admin custom fields
    *
    * Format:
    *   [
    *       'id'         => $id,
    *       'title'      => $title,
    *       'callback'   => $callback,
    *       'page'       => $page,
    *       'section'    => $section,
    *       'args'       => $args,
    *   ],
    ********************************************************/

    'fields' => [
        [
            'id'         => '',
            'title'      => '',
            'callback'   => '',
            'page'       => '',
            'section'    => '',
            'args'       => '',
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
    *   'settings_url' => $settings_url,
    *
    ********************************************************/

   'settings_url' => '',

];
