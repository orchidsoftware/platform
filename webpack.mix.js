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
    .sass('resources/sass/app.scss', 'css/orchid.css', {
        implementation: require('sass'),
    })
    .options({
        processCssUrls: false,
    })
    .postCss('public/css/orchid.css', 'css/orchid.rtl.css', [
        require('rtlcss'),
    ])
    .js('resources/js/app.js', 'js/orchid.js')
    .extract([
        'stimulus', 'stimulus/webpack-helpers', 'turbo',
        'popper.js', 'bootstrap',
        'dropzone', 'cropperjs', 'tom-select', 'frappe-charts', 'inputmask',
        'simplemde', 'axios', 'leaflet', 'codeflask',
        'flatpickr', 'quill', 'codemirror', 'typo-js', 'sortablejs',
    ])
    .setPublicPath('public')
    .version();

/* Orchid mix config end */
