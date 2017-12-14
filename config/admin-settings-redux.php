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

    /*********************************************************
    * Top level custom admin pages
    *
    * Format:
    *   array(
    * 'page_title' => $page_title,
    * 'menu_title' => $menu_title,
    * 'capability' => $capability,
    * 'menu_slug'  => $menu_slug,
    * 'callback'   => $callback,
    * 'icon_url'   => $icon_url,
    * 'position'   => $position,
    *   ),
    ********************************************************/

    'pages' => array(
        array(
            'page_title' => 'Starter Plugin',
            'menu_title' => 'Starter Plugin',
            'capability' => 'manage_options',
            'menu_slug'  => 'starter-plugin',
            'template'   => 'starter-plugin',
            'icon_url'   => 'dashicons-external',
            'position'   => 110,
        ),
    ),

    /*********************************************************
    * Custom admin subpages
    *
    * Format:
    *   array(
    * 'parent_slug' => $parent_slug,
    * 'page_title'  => $page_title,
    * 'menu_title'  => $menu_title,
    * 'capability'  => $capability,
    * 'menu_slug'   => $menu_slug,
    * 'callback'    => $callback,
    *   ),
    *
    * The following 'parent_slug' values (case sensitive) may be used to add subpages to the default top-level WordPress settings pages:
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
    'subpages' => array(
        array(
            'parent_slug' => 'starter-plugin',
            'page_title'  => 'CPT Options',
            'menu_title'  => 'CPT',
            'capability'  => 'manage_options',
            'menu_slug'   => 'starter-plugin-cpt',
            'template'    => 'starter-plugin-cpt',
        ),
        array(
            'parent_slug' => 'starter-plugin',
            'page_title'  => 'Taxonomy Options',
            'menu_title'  => 'Taxonomy',
            'capability'  => 'manage_options',
            'menu_slug'   => 'starter-plugin-taxonomy',
            'template'    => 'starter-plugin-taxonomy',
        ),
        array(
            'parent_slug' => 'starter-plugin',
            'page_title'  => 'Other Options',
            'menu_title'  => 'Other',
            'capability'  => 'manage_options',
            'menu_slug'   => 'starter-plugin-other',
            'template'    => 'starter-plugin-other',
        ),
    ),

    /*********************************************************
    * Admin custom sections
    *
    * Format:
    *   array(
    * 'id'       => $id,
    * 'title'    => $title,
    * 'callback' => $callback,
    * 'page'     => $page,
    *   ),
    ********************************************************/

    'sections' => array(
        array(
            'id'       => 'user_profile',
            'title'    => 'User Profile',
            'template' => 'user-profile',
            'page'     => 'starter-plugin',
        ),
        array(
            'id'       => 'user_interests',
            'title'    => 'User Interests',
            'template' => 'user-interests',
            'page'     => 'starter-plugin',
        ),
    ),

    /*********************************************************
    * Admin custom fields
    *
    * Format:
    *   array(
    * 'id'         => $id,
    * 'title'      => $title,
    * 'callback'   => $callback,
    * 'page'       => $page,
    * 'section'    => $section,
    * 'attributes' => $args,
    *   ),
    ********************************************************/

    'settings' => array(

        array(
            'id'          => 'first_name',
            'title'       => 'First Name',
            'page'        => 'starter-plugin',
            'section'     => 'user_profile',
            'description' => '',
            'helper'      => '',
            'type'        => 'text',
            'options'     => array(
                'placeholder' => 'First name',
                'required'    => true,
            ),
        ),

        array(
            'id'         => 'favorite-color',
            'title'      => 'Favorite Color',
            'page'       => 'starter-plugin',
            'section'    => 'user_profile',
            'type'       => 'checkbox',
            'options' => array(
                array(
                    'label'   => 'Blue sky',
                    'checked' => true,
                ),
                array(
                    'label'     => 'Red sun',
                ),
                array(
                    'label'     => 'Green grass',
                ),
                array(
                    'label'     => 'White sand',
                ),
            ),
        ),

        array(
            'id'         => 'user_password',
            'title'      => 'Password',
            'page'       => 'starter-plugin',
            'section'    => 'user_profile',
            'type'       => 'password',
            'options' => array(
                'placeholder' => 'Must contain 8-12 characters',
                'required'    => true,
            ),
        ),

        array(
            'id'          => 'user_bio',
            'title'       => 'User Biography',
            'page'        => 'starter-plugin',
            'section'     => 'user_profile',
            'description' => 'The user should describe themselves here',
            'helper'      => 'This is the helper.',
            'type'        => 'textarea',
            'options'     => array(
                'placeholder' => 'Last name',
            ),
        ),

        array(
            'id'         => 'favorite_car',
            'title'      => 'Favorite Car',
            'page'       => 'starter-plugin',
            'section'    => 'user_profile',
            'type'       => 'radio',
            'options' => array(
                'option_1' => array(
                    'label'     => 'Ford',
                ),
                'option_2' => array(
                    'label'     => 'Chevy',
                    'checked' => true,
                ),
                'option_3' => array(
                    'label'     => 'Toyota',
                ),
            ),
        ),

        array(
            'id'         => 'custom_option',
            'title'      => 'Custom Option',
            'page'       => 'starter-plugin',
            'section'    => 'user_profile',
            'type'       => 'custom',
            'options' => array(
                'file_name' => 'custom.php',
                'callback' => array( 'custom', 'custom'),
            ),
        ),
    ),

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

   'settings_url' => '',

);
