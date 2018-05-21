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

/*
mix.webpackConfig({
    module: {
        loaders: [
            {
                test: require.resolve('tinymce/tinymce'),
                use: [
                    'imports-loader?this=>window',
                    'exports-loader?window.tinymce',
                ]
            },
            {
                test: /tinymce\/(themes|plugins|skins)\//,
                use: [
                    'imports-loader?this=>window'
                ]
            },
        ]
    }
});
*/

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
  .copyDirectory('./node_modules/tinymce/plugins', 'public/js/tinymce/plugins')
  .copyDirectory('./node_modules/tinymce/themes', 'public/js/tinymce/themes')
  .sass('resources/assets/sass/app.scss', 'css/orchid.css')
  .js('resources/assets/js/app.js', 'js/orchid.js');
