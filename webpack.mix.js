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


mix.webpackConfig({
    module: {
        loaders: [
            {
                test: require.resolve('tinymce/tinymce'),
                loaders: [
                    'imports?this=>window',
                    'exports?window.tinymce'
                ]
            },
            {
                test: /tinymce\/(themes|plugins|skins)\//,
                loaders: [
                    'imports?this=>window'
                ]
            }
        ]
    }
});


if (!mix.inProduction()) {
  mix
    .webpackConfig({
      devtool: 'source-map',
    })
    .sourceMaps();
} else {
  mix.version();
}

mix
  .copy('./node_modules/orchid-icons/src/fonts/', 'public/fonts')
  //.copyDirectory('./node_modules/tinymce', 'public/js/tinymce')
  .sass('resources/assets/sass/app.scss', 'css/orchid.css')
  .js('resources/assets/js/app.js', 'js/orchid.js');
