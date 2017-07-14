<?php
/**
 * Class that defines plugin activation/deactivation/uninstall callbacks.
 *
 * @package    Plugin
 * @subpackage Plugin/src
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 *
 * Heavily based on this Stack Exchange Q&A
 * @author Franz Josef Kaiser/wecodemore
 * @link   https://wordpress.stackexchange.com/questions/25910/uninstall-activate-deactivate-a-plugin-typical-features-how-to/25979#25979
 */

namespace Vendor\Plugin\Setup;

class Installation {

    protected static $instance;

    public static function init() {
        is_null( self::$instance ) AND self::$instance = new self;
        return self::$instance;
    }

    public static function activate() {

        if ( ! current_user_can( 'activate_plugins' ) )
            return;

        $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
        check_admin_referer( "activate-plugin_{$plugin}" );


        // register_custom_post_types();
        // flush_rewrite_rules();

        // Uncomment the following line to see the function in action
        // exit( var_dump( $_GET ) );
    }

    public static function deactivate() {
        if ( ! current_user_can( 'activate_plugins' ) )
            return;

        // This feels like a workaround. Produces "Are you sure you want to do this?" error if deactivated due to failed requirements check.
        if( Requirements::all_requirements_met() ) {
            $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
            check_admin_referer( "deactivate-plugin_{$plugin}" );
        }

        // @link https://knowthecode.io/labs/custom-post-type-basics/episode-8
        // flush_rewrite_rules() results in weird behavior. Use this instead...
        // delete_option( 'rewrite_rules' );

        // Uncomment the following line to see the function in action
        // exit( var_dump( $_GET ) );
    }

    public static function uninstall() {
        if ( ! current_user_can( 'activate_plugins' ) )
            return;
        check_admin_referer( 'bulk-plugins' );

        // Important: Check if the file is the one
        // that was registered during the uninstall hook.
        if ( __FILE__ != WP_UNINSTALL_PLUGIN )
            return;

        // Remove files and database tables here

        # Uncomment the following line to see the function in action
        # exit( var_dump( $_GET ) );
    }
}
