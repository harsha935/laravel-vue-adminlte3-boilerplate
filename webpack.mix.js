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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('node_modules/jquery-confirm/dist/jquery-confirm.min.js', 'public/js/jquery-confirm.min.js')
   .copy('node_modules/jquery-confirm/dist/jquery-confirm.min.css', 'public/css/jquery-confirm.min.css');
