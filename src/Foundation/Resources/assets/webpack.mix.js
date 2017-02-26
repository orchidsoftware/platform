const { mix } = require('laravel-mix');

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

mix.less('./less/app.less', 'dist/css/orchid.css');


mix.copy('./img/', 'dist/img');
mix.copy('./node_modules/bootstrap/dist/fonts/', 'dist/fonts');
mix.copy('./node_modules/font-awesome/fonts/', 'dist/fonts');
mix.copy('./node_modules/simple-line-icons/fonts/', 'dist/fonts');
mix.copy('./node_modules/summernote/dist/font/', 'dist/fonts');


mix.js([
    './js/app.js',
    ]
, 'dist/js/orchid.js');