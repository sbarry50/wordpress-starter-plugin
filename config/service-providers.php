<?php
/**
 * Service Providers
 *
 * @package    Vendor\Plugin
 * @since      0.3.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

return [
    'loader' => [
        'class' => Vendor\Plugin\File\Loader::class,
    ],
    'constants' => [
        'class' => Vendor\Plugin\Constants\Constants::class,
        'dependencies' => [
            'constants-config',
        ],
    ],
    'controller' => [
        'class' => Vendor\Plugin\Controller\Controller::class,
        'dependencies' => [
            'container',
        ],
    ],
    'enqueue_controller' => [
        'class' => Vendor\Plugin\Controller\EnqueueController::class,
        'dependencies' => [
            'container',
        ],
    ],
    'events' => [
        'class' => NetRivet\WordPress\EventEmitter::class,
    ],
    'plugin_I18n' => [
        'class' => Vendor\Plugin\Setup\I18n::class,
    ],
    'attributes' => [
        'class' => Vendor\Plugin\Forms\Attributes::class,
    ],
    'options' => [
        'class' => Vendor\Plugin\Forms\Options::class,
    ],
    'forms' => [
        'class' => Vendor\Plugin\Forms\Forms::class,
        'dependencies' => [
            'loader',
            'attributes',
            'options',
        ],
    ],
    'settings_config' => [
        'class' => Vendor\Plugin\Settings\SettingsConfig::class,
        'params' => [
            Vendor\Plugin\Support\Paths::config() . 'settings/settings.php',
            Vendor\Plugin\Support\Paths::config() . 'settings/settings-defaults.php',
        ],
    ],
    'settings_callbacks' => [
        'class' => Vendor\Plugin\Settings\SettingsCallbacks::class,
        'dependencies' => [
            'loader',
            'forms',
        ],
    ],
    'settings' => [
        'class' => Vendor\Plugin\Settings\Settings::class,
        'dependencies' => [
            'settings_config',
            'settings_callbacks',
        ],
    ],
    'settings_api' => [
        'class' => Vendor\Plugin\Settings\SettingsAPI::class,
        'dependencies' => [
            'settings_config',
            'settings_callbacks',
        ],
    ],
    'settings_pages' => [
        'class' => Vendor\Plugin\Settings\SettingsPages::class,
        'dependencies' => [
            'settings_config',
            'settings_callbacks',
        ],
    ],
    'settings_link' => [
        'class' => Vendor\Plugin\Settings\SettingsLink::class,
    ],
    'admin_controller' => [
        'class' => Vendor\Plugin\Controller\AdminController::class,
        'dependencies' => [
            'container',
            'settings',
        ],
    ],
    'enqueue_manager' => [
        'class' => Vendor\Plugin\Enqueue\EnqueueManager::class,
        'dependencies' => [
            'enqueue-config',
        ],
    ],
    'admin_enqueue_manager' => [
        'class' => Vendor\Plugin\Enqueue\EnqueueManager::class,
        'dependencies' => [
            'admin-enqueue-config',
        ],
    ],
    'compatibility' => [
        'class' => Vendor\Plugin\Setup\Compatibility::class,
        'dependencies' => [
            'requirements-config',
            'loader',
        ],
    ],
    'cpt' => [
        'class' => Vendor\Plugin\CPT\CPT::class,
    ],
    'cpt_controller' => [
        'class' => Vendor\Plugin\Controller\CPTController::class,
        'dependencies' => [
            'container',
        ],
    ],
];
