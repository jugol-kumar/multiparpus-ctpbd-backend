const mix = require('laravel-mix');
const path = require('path');

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
    .vue(3)
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/js/'),
            }
        },
    })
    .sass('resources/sass/app.scss', 'public/css');


// mix.styles([
//     'public/css/main.css',
//     'public/css/grid.min.css'
// ], 'public/css/all.css')

// mix.styles([
//     'public/css/all.css',
//     'public/css/app.css'
// ], 'public/css/all.css');
mix.disableNotifications()
