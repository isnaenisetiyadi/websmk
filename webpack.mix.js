const mix = require('laravel-mix');
const { findIndex } = require('lodash');

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
    .copy([
        'vendor/softland/assets/vendor/jquery/jquery.min.js',
        'vendor/softland/assets/vendor/jquery/jquery.min.map',
        'vendor/softland/assets/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'vendor/softland/assets/vendor/jquery.easing/jquery.easing.min.js',
        'vendor/softland/assets/vendor/php-email-form/validate.js',
        'vendor/softland/assets/vendor/aos/aos.js',
        'vendor/softland/assets/vendor/owl.carousel/owl.carousel.min.js',
        'vendor/softland/assets/vendor/jquery-sticky/jquery.sticky.js',
        'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js.map',
        'vendor/softland/assets/js/main.js',
        'node_modules/bootstrap/js/dist/index.js',
    ], 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.styles([
        'vendor/softland/assets/vendor/bootstrap/css/bootstrap.min.css',
        'vendor/softland/assets/vendor/aos/aos.css',
        'vendor/softland/assets/vendor/owl.carousel/assets/owl.carousel.min.css',
        'vendor/softland/assets/css/style.css',
        'resources/css/style.css',
    ], 'public/css/all.css')
    .copy([
        'vendor/softland/assets/vendor/icofont/icofont.min.css',
        'vendor/softland/assets/vendor/line-awesome/css/line-awesome.min.css',
        'node_modules/bootstrap/dist/css/bootstrap.min.css.map'
    ], 'public/css');