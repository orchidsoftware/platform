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

/* Orchid mix config start */

if (!mix.inProduction()) {
    mix
        .webpackConfig({
            devtool: 'source-map',
        })
        .sourceMaps();
} else {
    mix.options({
        clearConsole: true,
        terser: {
            terserOptions: {
                compress: {
                    drop_console: true,
                },
            },
        },
    });
}

mix
    .copy('./node_modules/orchid-icons/src/svg/', 'public/icons')
    .copyDirectory('./node_modules/tinymce/plugins', 'public/js/tinymce/plugins')
    .copyDirectory('./node_modules/tinymce/themes', 'public/js/tinymce/themes')
    .copyDirectory('./node_modules/tinymce/skins', 'public/js/tinymce/skins')
    .sass('resources/sass/app.scss', 'css/orchid.css', {
        implementation: require('node-sass'),
    })
    .options({
        processCssUrls: false,
    })
    .js('resources/js/app.js', 'js/orchid.js')
    .extract([
        'stimulus', 'turbolinks', 'stimulus/webpack-helpers',
        'jquery', 'popper.js', 'bootstrap',
        'dropzone', 'select2', 'cropperjs', 'frappe-charts', 'inputmask',
        'simplemde', 'tinymce', 'axios', 'leaflet', 'codeflask', 'stimulus-flatpickr',
        'flatpickr', 'quill', 'codemirror', 'typo-js', 'sortablejs',
    ])
    .autoload({
        jquery: [
            '$', 'window.jQuery', 'jQuery', 'jquery',
            'bootstrap', 'select2',
        ],
    })
    .setPublicPath('public')
    .version();

/* Orchid mix config end */
