window.$ = window.jQuery = require('jquery');
window.Vue = require('vue');

require('jquery-ui-bundle');

require('bootstrap-sass');
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

$.fn.datetimepicker = require('eonasdan-bootstrap-datetimepicker');

require('./modules/select');
window.ace = require('brace');
require('brace/mode/javascript');
require('brace/theme/monokai');

window.Inputmask = require('inputmask');

require('../../../node_modules/select2/dist/js/select2.full.min');
$(() => {
    $('.select2-enable').select2({
        theme: 'bootstrap',
    });
});

$.fn.select2.defaults.set('theme', 'bootstrap');
require('croppie');

require('./dashboard');
require('./modules/datetimepicker');
require('./modules/leftMenu');
require('./modules/open-click');
require('./modules/inputmask');

require('../../../node_modules/tinymce/tinymce.min');
tinyMCE.baseURL = '/orchid/js/';

window.SimpleMDE = require('../../../node_modules/simplemde/dist/simplemde.min.js');

window.Chart = require('../../../node_modules/frappe-charts/dist/frappe-charts.min.cjs');
