# WordPress Starter Plugin

An object-oriented foundation with a modern file architecture, standards and build tools for crafting high-quality WordPress Plugins.

## Features

* Built-in initialization tasks
   - System environment compatibility check
   - Plugin constants with ability to add more
   - Enqueue manager for enqueuing styles and scripts into WordPress
   - Localization - includes a `.pot` file as a starting point for internationalization
   - Class to handle all activation/deactivation/installation tasks
* API's
   - Config - abstracts the runtime configuration out of the modules and into the `config` folder
   - Event Management -
   - File and template loader -
* Composer autoloader
* Follows PSR-4 coding standards
* Includes Laravel Mix for simple webpack implementation

## Requirements

Make sure all dependencies have been installed before moving on:

* [WordPress](https://wordpress.org/) >= 4.7
* [PHP](http://php.net/manual/en/install.php) >= 5.3
* [Composer](https://getcomposer.org/download/)
* [Node.js](http://nodejs.org/) >= 6.9.x

## Installation

1. Clone the directory into your `plugins` directory.
2. Change into the cloned directory and execute `composer install` and `npm install` for UpGulp.
3. In the WordPress dashboard, navigate to the *Plugins* page and locate the menu item that reads “The WordPress Plugin Boilerplate.”
4. Click on *Activate.*

Note that this will activate the source code of the Boilerplate, but because the Boilerplate has no real functionality so no menu items, meta boxes, or custom post types will be added.

## Recommended Tools

### i18n Tools

The WordPress Plugin Boilerplate uses a variable to store the text domain used when internationalizing strings throughout the Boilerplate. To take advantage of this method, there are tools that are recommended for providing correct, translatable files:

* [Poedit](http://www.poedit.net/)
* [makepot](http://i18n.svn.wordpress.org/tools/trunk/)
* [i18n](https://github.com/grappler/i18n)

Any of the above tools should provide you with the proper tooling to internationalize the plugin.

## License

The WordPress Plugin Boilerplate is licensed under the GPL v2 or later.

> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

> You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

A copy of the license is included in the root of the plugin’s directory. The file is named `LICENSE`.

## Important Notes

### Licensing

The WordPress Plugin Boilerplate is licensed under the GPL v2 or later; however, if you opt to use third-party code that is not compatible with v2, then you may need to switch to using code that is GPL v3 compatible.

For reference, [here's a discussion](http://make.wordpress.org/themes/2013/03/04/licensing-note-apache-and-gpl/) that covers the Apache 2.0 License used by [Bootstrap](http://twitter.github.io/bootstrap/).

### Includes

Note that if you include your own classes, or third-party libraries, there are three locations in which said files may go:

* `src/Common` is where functionality shared between the dashboard and the public-facing parts of the side reside.
* `src/Admin` is for all dashboard-specific functionality.
* `src/Frontend` is for all public-facing functionality.

The example code provided shows how to register your hooks with the `Loader` class. More information will be provided in the upcoming documentation on the website.

### Assets

The `assets/images` directory contains three files.

1. `banner-772x250.png` is used to represent the plugin’s header image.
2. `icon-256x256.png` is a used to represent the plugin’s icon image (which is new as of WordPress 4.0).
3. `screenshot-1.png` is used to represent a single screenshot of the plugin that corresponds to the “Screenshots” heading in your plugin `README.txt`.

# Credits

The WordPress Plugin Boilerplate was started in 2011 by [Tom McFarlin](http://twitter.com/tommcfarlin/) and has since included a number of great contributions.

The current version of the Boilerplate was developed in conjunction with [Josh Eaton](https://twitter.com/jjeaton), [Ulrich Pogson](https://twitter.com/grapplerulrich), and [Brad Vincent](https://twitter.com/themergency).

The fork which this is directly forked from was developed by [Luís Rodrigues](https://github.com/goblindegook).

The homepage is based on a design as provided by [HTML5Up](http://html5up.net), the Boilerplate logo was designed by  Rob McCaskill of [BungaWeb](http://bungaweb.com), and the site `favicon` was created by [Mickey Kay](https://twitter.com/McGuive7).
