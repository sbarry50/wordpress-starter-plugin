<?php
/**
 * Service Providers
 *
 * @package    SB2Media\Hub
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

return [
    'controller' => [
        'class' => SB2Media\Hub\Controller\Controller::class,
    ],
    'enqueue-controller' => [
        'class' => SB2Media\Hub\Controller\EnqueueController::class,
    ],
    'events' => [
        'class' => DownShift\WordPress\EventEmitter::class,
    ],
    'attributes' => [
        'class' => SB2Media\Hub\Forms\Attributes::class,
    ],
    'options' => [
        'class' => SB2Media\Hub\Forms\Options::class,
    ],
    'forms' => [
        'class' => SB2Media\Hub\Forms\Forms::class,
        'dependencies' => [
            'attributes',
            'options',
        ],
    ],
    'settings-config' => [
        'class' => SB2Media\Hub\Settings\SettingsConfig::class,
        'params' => [
            HUB_DIR_PATH . 'config/settings/settings.php',
            HUB_DIR_PATH . 'config/settings/settings-defaults.php',
        ],
    ],
    'settings-callbacks' => [
        'class' => SB2Media\Hub\Settings\SettingsCallbacks::class,
        'dependencies' => [
            'forms',
            'plugin-data',
        ],
    ],
    'settings' => [
        'class' => SB2Media\Hub\Settings\Settings::class,
        'dependencies' => [
            'settings-config',
            'settings-callbacks',
        ],
    ],
    'settings-api' => [
        'class' => SB2Media\Hub\Settings\SettingsAPI::class,
        'dependencies' => [
            'settings-config',
            'settings-callbacks',
        ],
    ],
    'settings-pages' => [
        'class' => SB2Media\Hub\Settings\SettingsPages::class,
        'dependencies' => [
            'settings-config',
            'settings-callbacks',
        ],
    ],
    'settings-link' => [
        'class' => SB2Media\Hub\Settings\SettingsLink::class,
    ],
    'admin-controller' => [
        'class' => SB2Media\Hub\Controller\AdminController::class,
        'dependencies' => [
            'settings',
        ],
    ],
    'enqueue-manager' => [
        'class' => SB2Media\Hub\Enqueue\EnqueueManager::class,
        'dependencies' => [
            'enqueue-config',
            'plugin-data',
        ],
    ],
    'admin-enqueue-manager' => [
        'class' => SB2Media\Hub\Enqueue\EnqueueManager::class,
        'dependencies' => [
            'admin-enqueue-config',
            'plugin-data',
        ],
    ],
    'cpt-controller' => [
        'class' => SB2Media\Hub\Controller\CPTController::class,
    ],
];
