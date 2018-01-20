//Code editor
window.ace = require('brace');
require('brace/mode/javascript');
require('brace/theme/monokai');

//Tinymce editor
require('../../../node_modules/tinymce/tinymce.min');
tinyMCE.baseURL = '/orchid/js/';

//SimpleMDE editor
window.SimpleMDE = require('../../../node_modules/simplemde/dist/simplemde.min.js');
