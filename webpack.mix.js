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

const webpack = require("webpack");
mix.webpackConfig({
    resolve: {
    },
	plugins: [
		new webpack.ContextReplacementPlugin(/moment[\/\\]locale/,/(de|en|en-gb|fr|ru|th)\.js/)
	],
	module: {
		noParse: [
			/brace/
		],
	}
}); 

mix.setPublicPath('public');

mix.sass('resources/assets/sass/app.scss', 'public/css/orchid.css').sourceMaps().version();

mix.copy('./node_modules/font-awesome/fonts/', 'public/fonts');
mix.copy('./node_modules/simple-line-icons/fonts/', 'public/fonts');
mix.copy('./node_modules/tinymce/plugins/', 'public/js/plugins');
mix.copy('./node_modules/tinymce/skins/', 'public/js/skins');
mix.copy('./node_modules/tinymce/themes/', 'public/js/themes');

mix.js([
    'resources/assets/js/app.js',
], 'public/js/orchid.js').sourceMaps().version();

mix.js('resources/assets/js/editors.js', 'public/js/editors.js');


