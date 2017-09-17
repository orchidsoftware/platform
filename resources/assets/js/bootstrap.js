window.$ = window.jQuery = require('jquery');
require('jquery-ui-bundle');


require('bootstrap');
require('bootstrap-tagsinput');


window.Vue = require('vue');
require('vue-resource');


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

require('./modules/post');
require('./modules/datetimepicker');
require('./modules/leftMenu');
require('./modules/open-click');
