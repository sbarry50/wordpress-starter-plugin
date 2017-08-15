const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const src    = 'src';
const config = 'config';
const assets = 'assets';
const dist   = 'dist';

mix.setPublicPath(dist);
mix.setResourceRoot('../');

// Browser Sync
mix.browserSync({
  host: 'localhost',
  proxy: 'http://example.dev',
  port: 3000,
  browser: ['chrome.exe'],

  files: [
    `${src}/**/*.php`,
    `${src}/*.php`,
    `${config}/*.php`,
    `${dist}/**/*.css`,
    `${dist}/**/*.js`
  ]
});

// Sass
mix.sass(`${assets}/sass/plugin-name.scss`, `${dist}/css/`);

// Javascript
// mix.autoload({
//    jquery: ['$', 'window.jQuery', 'jQuery']
// });

mix.js(`${assets}/js/plugin-name.js`, `${dist}/js/`);

// Assets
mix.copy(`${assets}/fonts`, `${dist}/fonts`, false)
   .copy(`${assets}/icons`, `${dist}/icons`, false)
   .copy(`${assets}/images`, `${dist}/images`, false);

// PostCSS
mix.options({
  processCssUrls: false,
  postCss: [
    require('rucksack-css')()
  ]
});

// Source maps when not in production.
if (!mix.inProduction()) {
  mix.sourceMaps();
}

// Hash and version files in production.
if (mix.inProduction()) {
  mix.version();
}
// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.standaloneSass('src', output); <-- Faster, but isolated from Webpack.
// mix.fastSass('src', output); <-- Alias for mix.standaloneSass().
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.dev');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   uglify: {}, // Uglify-specific options. https://webpack.github.io/docs/list-of-plugins.html#uglifyjsplugin
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });
