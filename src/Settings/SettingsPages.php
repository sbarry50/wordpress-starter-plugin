<?php
/**
 * WordPress Settings API class handler for building settings pages and subpages
 *
 * @package    Vendor\Plugin\Settings
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace Vendor\Plugin\Settings;

use Vendor\Plugin\Config\Config;
use Vendor\Plugin\Settings\Settings;
use Vendor\Plugin\Container\Container;
use Vendor\Plugin\Config\ConfigInterface;

class SettingsPages extends Settings
{

    // /**
    //  * Admin pages
    //  *
    //  * @var array
    //  */
    // public $pages = array();

    // /**
    //  * Admin subpages
    //  *
    //  * @var array
    //  */
    // public $subpages = array();

    // /**
    //  * Set the Admin configuration to the pages property
    //  *
    //  * @since 0.3.0
    //  * @param array $pages
    //  */
    // public function setPages(array $pages)
    // {
    //     $this->pages = $this->defaults->merge($pages, 'page');

    //     return $this;
    // }

    // public function getPages()
    // {
    //     return $this->pages;
    // }

    // /**
    //  * Set the Admin configuration to the subpages property
    //  *
    //  * @since 0.3.0
    //  * @param array $subpages
    //  */
    // public function setSubPages(array $subpages)
    // {
    //     $this->subpages = $this->defaults->merge($subpages, 'subpage');

    //     return $this;
    // }

    // public function getSubPages()
    // {
    //     return $this->subpages;
    // }

    // public function __construct(SettingsCallbacks $callbacks)
    // {
    //     $this->callbacks = $callbacks;
    // }

    /**
     * Add a primary subpage (ie. "Dashboard") to the parent Admin page.
     *
     * @since  0.3.0
     * @param  string    $title    The title of the subpage
     * @return
     */
    public function withSubPage(string $title = null)
    {
        if (empty($this->pages)) {
            return $this;
        }

        $page = $this->pages[0];

        $subpage = [
            [
                'parent_slug' => $page['menu_slug'],
                'page_title'  => $page['page_title'],
                'menu_title'  => ($title) ? $title : $page['menu_title'],
                'capability'  => $page['capability'],
                'menu_slug'   => $page['menu_slug']
            ],
        ];

        $this->subpages = $subpage;

        return $this;
    }

    /**
     * Add the arrays of Admin pages and subpages to WordPress
     *
     * @since 0.3.0
     */
    public function createAdminPages()
    {
        if (! empty($this->pages)) {
            foreach ($this->pages as $page) {
                add_menu_page(
                    $page['page_title'],
                    $page['menu_title'],
                    $page['capability'],
                    $page['menu_slug'],
                    ! empty($page['template']) ? function () use ($page) {
                        return $this->settings_callbacks->page($page['template']);
                    } : '',
                    $page['icon_url'],
                    $page['position']
                );

                if (false == get_option($page['menu_slug'] . '-settings')) {
                    add_option($page['menu_slug'] . '-settings');
                }
            }
        }

        if (! empty($this->subpages)) {
            foreach ($this->subpages as $subpage) {
                switch ($subpage['parent_slug']) {
                    case 'Dashboard':
                        $func = 'add_dashboard_page';
                        break;
                    case 'Posts':
                        $func = 'add_posts_page';
                        break;
                    case 'Media':
                        $func = 'add_media_page';
                        break;
                    case 'Pages':
                        $func = 'add_pages_page';
                        break;
                    case 'Comments':
                        $func = 'add_comments_page';
                        break;
                    case 'Appearance':
                        $func = 'add_theme_page';
                        break;
                    case 'Plugins':
                        $func = 'add_plugins_page';
                        break;
                    case 'Users':
                        $func = 'add_users_page';
                        break;
                    case 'Tools':
                        $func = 'add_management_page';
                        break;
                    case 'Settings':
                        $func = 'add_options_page';
                        break;
                    default:
                        $func = 'add_submenu_page';
                        break;
                }

                if ('add_submenu_page' == $func) {
                    $func(
                        $subpage['parent_slug'],
                        $subpage['page_title'],
                        $subpage['menu_title'],
                        $subpage['capability'],
                        $subpage['menu_slug'],
                        ! empty($subpage['template']) ? function () use ($subpage) {
                            return $this->settings_callbacks->page($subpage['template']);
                        } : ''
                    );
                } else {
                    $func(
                        $subpage['page_title'],
                        $subpage['menu_title'],
                        $subpage['capability'],
                        $subpage['menu_slug'],
                        ! empty($subpage['template']) ? function () use ($subpage) {
                            return $this->settings_callbacks->page($subpage['template']);
                        } : ''
                    );
                }

                if (false == get_option($subpage['menu_slug'] . '-settings')) {
                    add_option($subpage['menu_slug'] . '-settings');
                }
            }
        }
    }
}
