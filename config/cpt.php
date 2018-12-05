<?php
/**
 * Custom Post Type configurations.
 *
 * @package    SB2Media\Hub
 * @since      0.4.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

$text_domain = get_file_data(__FILE__, ['TextDomain' => 'Text Domain'], 'plugin')['TextDomain'];

return [
    'id' => 'custom',
    'labels'      => [
        'name'               => _x('Customs', 'post type general name', $text_domain),
        'singular_name'      => _x('Custom', 'post type singular name', $text_domain),
        'menu_name'          => _x('Customs', 'admin menu', $text_domain),
        'name_admin_bar'     => _x('Manufacturer', 'add new on admin bar', $text_domain),
        'add_new'            => _x('Add New', 'custom', $text_domain),
        'add_new_item'       => __('Add New Custom', $text_domain),
        'new_item'           => __('New Custom', $text_domain),
        'edit_item'          => __('Edit Custom', $text_domain),
        'view_item'          => __('View Custom', $text_domain),
        'all_items'          => __('All Customs', $text_domain),
        'search_items'       => __('Search Customs', $text_domain),
        'parent_item_colon'  => __('Parent Customs:', $text_domain),
        'not_found'          => __('No customs found.', $text_domain),
        'not_found_in_trash' => __('No customs found in Trash.', $text_domain)
    ],
    'post_type'   => 'page',
    'public'      => true,
    'supports'    => array('title', 'editor', 'thumbnail', 'page-attributes'),
    'has_archive' => false,
    'rewrite'     => array('slug' => 'customs'),   // my custom slug
];
