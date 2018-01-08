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

if (!mix.inProduction()) {
    mix
        .webpackConfig({
            devtool: 'source-map',
        })
        .sourceMaps();
} else {
    mix.version();
}

mix.copy('./node_modules/bootstrap-sass/assets/fonts/bootstrap', 'public/fonts');
mix.copy('./node_modules/font-awesome/fonts/', 'public/fonts');
mix.copy('./node_modules/simple-line-icons/fonts/', 'public/fonts');
mix.copy('./node_modules/tinymce/plugins/', 'public/js/plugins');
mix.copy('./node_modules/tinymce/skins/', 'public/js/skins');
mix.copy('./node_modules/tinymce/themes/', 'public/js/themes');

mix
    .sass('resources/assets/sass/app.scss', 'css/orchid.css')
    .js('resources/assets/js/app.js', 'js/orchid.js');
