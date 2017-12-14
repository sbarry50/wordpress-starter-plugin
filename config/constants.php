<?php
/**
 * Plugin requirements parameters.
 *
 * @package    Vendor\Plugin
 * @since      0.1.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

return array(

 /*********************************************************
 * Plugin constants to define
 *
 * Format:
 *    $unique_id => $value
 ********************************************************/

    'PLUGIN_ROOT'        => Vendor\Plugin\Support\PluginData::root(),
    'PLUGIN_NAME'        => Vendor\Plugin\Support\PluginData::headerData('Name'),
    'PLUGIN_BASENAME'    => Vendor\Plugin\Support\PluginData::basename(),
    'PLUGIN_DIR_PATH'    => Vendor\Plugin\Support\Paths::pluginDir(),
    'PLUGIN_DIR_URL'     => Vendor\Plugin\Support\URLs::dirURL(),
    'PLUGIN_TEXT_DOMAIN' => Vendor\Plugin\Support\PluginData::headerData('TextDomain'),
    'PLUGIN_VERSION'     => Vendor\Plugin\Support\PluginData::headerData('Version'),
);
