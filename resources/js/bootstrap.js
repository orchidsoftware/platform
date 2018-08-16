window.$ = window.jQuery = require('jquery');

require('jquery-ui-bundle');

require('bootstrap');
require('nestable');

require('./modules/select');

require('select2');

$(() => {
  $('.select2-enable').select2({
    theme: 'bootstrap',
  });
});

$.fn.select2.defaults.set('theme', 'bootstrap');

require('./modules/open-click');

//require('./components/attachment');
//require('./components/filemanager');

