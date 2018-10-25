# WordPress Starter Plugin

An object-oriented foundation with a modern file architecture, standards and build tools for crafting high-quality WordPress Plugins.

## Features

* Pimple container dependency injection
* Built-in initialization tasks
   - System environment compatibility check
   - Plugin constants with ability to add more
   - Enqueue manager for enqueuing styles and scripts into WordPress
   - Localization - includes a `.pot` file as a starting point for internationalization
   - Class to handle all activation/deactivation/installation tasks
* Modules
   - Config - abstracts the runtime configuration out of the modules and into the `config` folder
   - Event Management - interact with the WordPress Plugin API
   - File and template loader
* Composer autoloader
* Follows PSR-4 coding standards
* Includes Laravel Mix for simple webpack implementation
* Custom post type functionality - configured via config file

## Requirements

Make sure all dependencies have been installed before moving on:

* [WordPress](https://wordpress.org/) >= 4.7
* [PHP](http://php.net/manual/en/install.php) >= 7.0
* [Composer](https://getcomposer.org/download/)
* [Node.js](http://nodejs.org/) >= 6.9.x

## Installation

1. From the command line navigate to your WordPress `plugins` directory.
2. Run this command: `composer create-project sb2-media/wordpress-starter-plugin`.
3. Rename the `wordpress-starter-plugin` directory to `your-plugin-name`.
3. Change into the plugin directory: `cd your-plugin-name`.
4. Update the `package.json` file with your info.
5. Update the main plugin header in `plugin.php` with your plugin info.
6. Run `npm install`.
7. Run `npm run dev`.
8. Global search and replace `Vendor\Plugin` namespaces with `YourCompanyName\YourPluginName`.
9. Update `composer.json` with relevant information including the namespaces defined in the `autoload` section. They must match the namespaces used in the previous step.
10. Run `composer dump-autoload -o`.
11. In the WordPress dashboard, navigate to the *Plugins* page and locate the menu item that reads “Your Plugin Name.”
12. Click on *Activate.*

Note that this will activate the source code of the starter plugin, but because it has no real functionality no menu items, meta boxes, or custom post types will be added.

## Usage

### Enqueuing Assets

Default behavior for enqueueing assets is via two configuration files found in the `config` folder. Front-end and back-end assets can be defined in `enqueue.php` and `admin-enqueue.php`, respectively. Adding multiple files is as simple as adding another entry in the configuration array. This is well-documented in each file.

Alternatively (or in conjunction with), assets can be enqueued via the `EnqueueManager` class' `enqueueStyles` and `enqueueScripts` methods. These are best called in the `Plugin` class' `enqueueAssets` and `enqueueAdminAssets` methods.

Each asset to be enqueued should be placed in the appropriate `assets/sass` (default for css), `assets/css` and/or `assets/js` subfolders. These filed must also be defined in `webpack.mix.js` in the plugin's root directory and compiled into the appropriate `dist/` subfolder by executing `npm run dev` or `npm run production` on the command line.

## Recommended Tools

### i18n Tools

The WordPress Starter Plugin uses a variable to store the text domain used when internationalizing strings throughout. To take advantage of this method, there are tools that are recommended for providing correct, translatable files:

* [Poedit](http://www.poedit.net/)
* [makepot](http://i18n.svn.wordpress.org/tools/trunk/)
* [i18n](https://github.com/grappler/i18n)

Any of the above tools should provide you with the proper tooling to internationalize the plugin.

## License

The WordPress Starter Plugin is licensed under the GPL v2 or later.

> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

> You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

A copy of the license is included in the root of the plugin’s directory. The file is named `LICENSE`.

## Assets

The `assets/images` directory contains three files.

1. `banner-772x250.png` is used to represent the plugin’s header image.
2. `icon-256x256.png` is a used to represent the plugin’s icon image (which is new as of WordPress 4.0).
3. `screenshot-1.png` is used to represent a single screenshot of the plugin that corresponds to the “Screenshots” heading in your plugin `README.txt`.

# Credits

This starter plugin was originally based on The WordPress Plugin Boilerplate which was started in 2011 by [Tom McFarlin](http://twitter.com/tommcfarlin/). The current version of the Boilerplate was developed in conjunction with [Josh Eaton](https://twitter.com/jjeaton), [Ulrich Pogson](https://twitter.com/grapplerulrich), and [Brad Vincent](https://twitter.com/themergency). The fork which this is directly forked from was developed by [Luís Rodrigues](https://github.com/goblindegook).

This plugin also uses code and concepts adapted from [Carl Alexander](https://carlalexander.ca/) and Tonya Mork's [Fulcrum plugin](https://github.com/hellofromtonya/Fulcrum).
