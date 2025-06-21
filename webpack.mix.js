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

// Scripts

mix
  .js('resources/js/app.js', 'public/js/')
  .js('resources/js/app-deferred.js', 'public/js/')
  .sass('resources/sass/app.scss', 'public/css')
  .minify([
    'public/js/app-deferred.js',
    'public/css/app.css',
    'public/js/app.js']
  ).vue();
