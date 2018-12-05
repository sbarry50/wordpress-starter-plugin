<?php

/**
 * Constants factory
 *
 * @package    SB2Media\Hub\Constants
 * @since      0.5.0
 * @author     sbarry
 * @link       https://example.com
 * @license    GNU General Public License 2.0+
 */

 namespace SB2Media\Hub\Constants;

 use function SB2Media\Hub\container;

class ConstantsFactory
{
    /**
     * Create the constants instance
     *
     * @since  0.5.0
     * @param  string $id    Plugin id
     * @param  PluginData $plugin_data
     * @return void
     */
    
    public static function set(string $id, PluginData $plugin_data)
    {
        container()->set($id . '-constants', new Constants(strtoupper($id), $plugin_data));
    }
}
