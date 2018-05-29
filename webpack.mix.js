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

const vendor = [
    'jquery', 'vue', 'jquery-ui-bundle', 'bootstrap', 'bootstrap-tagsinput', 'axios', 'dropzone', 'nestable', 'moment',
    'inputmask', 'select2', 'croppie', 'frappe-charts', 'brace', 'brace/mode/javascript', 'brace/theme/monokai',
    'tinymce', 'simplemde', 'popper.js', 'turbolinks',
];

mix
  .copy('./node_modules/orchid-icons/src/fonts/', 'public/fonts')
  .copyDirectory('./node_modules/tinymce', 'public/js/tinymce')
  .sass('resources/assets/sass/app.scss', 'css/orchid.css')
  .js('resources/assets/js/app.js', 'js/orchid.js')
  .extract(vendor)
  .autoload({
      jquery: ['$', 'window.jQuery', 'jQuery', 'jquery'],
  });
