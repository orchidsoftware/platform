window.$ = window.jQuery = require('jquery');
require('jquery-ui-bundle');


require('bootstrap');
require('bootstrap-tagsinput');


window.Vue = require('vue');
//require('vue-resource');



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


require('select2');
$(() => {
    $('.select2-enable').select2();
});

require('croppie');

require('./modules/post');
require('./modules/datetimepicker');
require('./modules/leftMenu');
require('./modules/open-click');

require('../../../node_modules/tinymce/tinymce.min');


tinyMCE.baseURL = "/orchid/js/";
