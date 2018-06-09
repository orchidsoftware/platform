window.$ = window.jQuery = require('jquery');

window.Vue = require('vue');

require('jquery-ui-bundle');

window.Popper = require('popper.js');

require('bootstrap');
require('bootstrap-tagsinput');

document.addEventListener('turbolinks:load', function() {
  $("input[data-role='tagsinput']").tagsinput('refresh');
});

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

require('./modules/csrf_token');

window.Dropzone = require('dropzone');
Dropzone.autoDiscover = false;

require('nestable');

window.moment = require('moment');

$.fn.datetimepicker = require('./modules/bootstrap-datetimepicker.js');

require('./modules/select');

window.Inputmask = require('inputmask');

require('select2');
$(() => {
  $('.select2-enable').select2({
    theme: 'bootstrap',
  });
});

$.fn.select2.defaults.set('theme', 'bootstrap');
require('croppie');

require('./modules/datetimepicker');
require('./modules/leftMenu');
require('./modules/open-click');
require('./modules/inputmask');

window.Chart = require('frappe-charts');

//Code editor
window.ace = require('brace');
require('brace/mode/javascript');
require('brace/theme/monokai');

//Tinymce editor
require('tinymce');
tinyMCE.baseURL = '/orchid/js/tinymce';

//SimpleMDE editor
window.SimpleMDE = require('simplemde');

require('./components/attachment');
require('./components/filemanager');
require('./components/menu');

require('./dashboard');
