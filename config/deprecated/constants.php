<?php
/**
 * Plugin constants parameters.
 *
 * @package    SB2Media\Hub
 * @since      0.1.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

$plugin_name = 'HUB';
$plugin_data = \SB2Media\Hub\container()->get('hub-plugin-data');

return [

 /*********************************************************
 * Plugin constants to define
 *
 * Format:
 *    $unique_id => $value
 ********************************************************/

    "{$plugin_name}_ROOT"        => $plugin_data->plugin_root_file,
    "{$plugin_name}_NAME"        => $plugin_data->headerData('Name'),
    "{$plugin_name}_BASENAME"    => $plugin_data->basename(),
    "{$plugin_name}_DIR_PATH"    => $plugin_data->path(),
    "{$plugin_name}_DIR_URL"     => $plugin_data->url(),
    "{$plugin_name}_TEXT_DOMAIN" => $plugin_data->headerData('TextDomain'),
    "{$plugin_name}_VERSION"     => $plugin_data->headerData('Version'),
];
