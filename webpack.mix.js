const {mix} = require('laravel-mix');

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

mix.setPublicPath('public');
mix.less('resources/assets/less/app.less', 'public/css/orchid.css');

mix.copy('resources/assets/img/', 'public/img');
mix.copy('./node_modules/bootstrap/dist/fonts/', 'public/fonts');
mix.copy('./node_modules/font-awesome/fonts/', 'public/fonts');
mix.copy('./node_modules/simple-line-icons/fonts/', 'public/fonts');
mix.copy('./node_modules/summernote/dist/', 'public/summernote');

mix.js([
    'resources/assets/js/app.js',
], 'public/js/orchid.js');
