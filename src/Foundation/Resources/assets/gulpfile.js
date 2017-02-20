var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('./less/app.less', '../dist/css/orchid.css');
    mix.copy('./img/', '../dist/img');
    mix.copy('./vendor/bootstrap/dist/fonts/', '../dist/fonts');
    mix.copy('./vendor/font-awesome/fonts/', '../dist/fonts');
    mix.copy('./vendor/simple-line-icons/fonts/', '../dist/fonts');
    mix.copy('./vendor/summernote/dist/font/', '../dist/fonts');



    mix.scripts([
        "./vendor/jquery/dist/jquery.min.js",
        "./vendor/jquery-ui/jquery-ui.min.js",
        "./vendor/bootstrap/dist/js/bootstrap.min.js",
        "./vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.js",
        "./vendor/vue/dist/vue.js",
        "./vendor/vue-resource/dist/vue-resource.js",
        "./vendor/chosen/chosen.jquery.js",
        "./vendor/summernote/dist/summernote.js",
        "./vendor/dropzone/dist/min/dropzone.min.js",


        "./vendor/nestable/jquery.nestable.js",

        './vendor/moment/min/moment.min.js',
        './vendor/moment/min/locales.js',
        './vendor/moment/min/moment-with-locales.js',
        './vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',

        './vendor/ace-builds/src-noconflict/ace.js',
        './vendor/ace-builds/src-noconflict/mode-html.js',
        './vendor/ace-builds/src-noconflict/theme-monokai.js',
        './vendor/ace-builds/src-noconflict/worker-javascript.js',

        "./js/app.js",
        "./js/modules/**",
        "./js/components/**",
        "./js/directives/**",
    ], '../dist/js/orchid.js');

});
