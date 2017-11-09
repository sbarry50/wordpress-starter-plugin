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

    'PLUGIN_ROOT'            => (function () {
        return Vendor\Plugin\Support\PluginData::getPluginRootFile();
    })(),
    'PLUGIN_NAME'            => (function () {
        return Vendor\Plugin\Support\PluginData::getPluginHeaderData( 'Name' );
    })(),
    'PLUGIN_BASENAME'        => (function () {
        return Vendor\Plugin\Support\PluginData::getPluginBasename();
    })(),
    'PLUGIN_DIR_PATH'        => (function () {
        return Vendor\Plugin\Support\Paths::getPluginDirPath();
    })(),
    'PLUGIN_DIR_URL'         => (function () {
        return Vendor\Plugin\Support\URLs::getPluginDirURL();
    })(),
    'PLUGIN_TEXT_DOMAIN'     => (function () {
        return Vendor\Plugin\Support\PluginData::getPluginHeaderData( 'TextDomain' );
    })(),
    'PLUGIN_VERSION'         => (function () {
        return Vendor\Plugin\Support\PluginData::getPluginHeaderData( 'Version' );
    })(),
);
