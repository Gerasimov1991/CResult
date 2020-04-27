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

mix.js('resources/js/company/app.js', 'public/company/js')
    .js('resources/js/admin/app.js', 'public/admin/js')
    .sass('resources/sass/app.scss', 'public/company/css');
