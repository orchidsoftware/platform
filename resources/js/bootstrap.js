window.$ = window.jQuery = require('jquery');

window.Vue = require('vue');

require('popper.js');

require('jquery-ui-bundle');

require('bootstrap');

window.Dropzone = require('dropzone');
Dropzone.autoDiscover = false; 

require('nestable');

require('./modules/select');

require('select2');

$(() => {
  $('.select2-enable').select2({
    theme: 'bootstrap',
  });
});

$.fn.select2.defaults.set('theme', 'bootstrap');

require('croppie');

require('./modules/open-click');


require('./components/attachment');
require('./components/filemanager');
// require('./components/menu');

