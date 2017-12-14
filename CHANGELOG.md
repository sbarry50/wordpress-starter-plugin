# Change Log

## November 10, 2017 - 0.3.0
* Controller classes added
* Settings classes added to interact with WordPress' Settings API
* Container instance() static method added to easily return the main instance of Container

## November 8, 2017 - 0.2.1
* Container `setWithConfig()` now handles optional parameters
* `register_activation_hook`, `register_deactivation_hook` and `register_uninstall_hook` moved to plugin root file since they cannot be called from within `plugins_loaded` or `init` wordpress hooks.

## November 3, 2017 - 0.2.0
* Implemented Pimple dependency injection container to better manage dependencies
* Added Container class as a wrapper class for Pimple
* Event Manager class overhauled. Now just a wrapper for NetRivet's WordPress Event Emitter.
* Major rewrites to many other classes
* Added Config file support for enqueuing stylesheets and scripts in the WordPress front and back-ends. This is default behavior.
* Defined plugin constants moved to config file.
* Constants now defined in the main `Vendor\Plugin` namespace.
* Added utility classes -- `PluginData`, `Paths` and `URLs` -- to simplify retrieving data, file and folder paths and URLs within the plugin.

## August 15, 2017 - 0.1.2
* Update method names to camelCase to follow PSR-4 naming convention standards.

## August 6, 2017
* Add `ConfigFactory` class for creating Config objects

## August 3, 2017
* Update `$plugin_root_dir` in `config/plugin.php`.

## August 1, 2017
* Major rewrite and refactoring complete
* Replaced UpGulp with Laravel Mix for module bundling and asset compilation

## June 22, 2017
* Refactored class-requirements and requirements notice error view
* Added main config file. Minimum system requirements config.
* Clean up

## June 21, 2017

* Added Setup class for activation/deactivation/uninstall processes
* Added system requirements check

## June 20, 2017

* Fork of the WordPress Plugin Boilerplate NS.
* Restructured directories and plugin architecture
* Added plugin constants
* UpGulp starter module added
