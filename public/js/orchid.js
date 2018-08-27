webpackJsonp([1],{

/***/ 100:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce__ = __webpack_require__(34);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }


// Core


// A theme is also required
//import 'tinymce/themes/modern';
//import 'tinymce/themes/inlite'


// Plugins

/*
import 'tinymce/plugins/advlist'
import 'tinymce/plugins/anchor'
import 'tinymce/plugins/autolink'
import 'tinymce/plugins/autoresize'
import 'tinymce/plugins/autosave'
import 'tinymce/plugins/bbcode'
import 'tinymce/plugins/charmap'
import 'tinymce/plugins/code'
import 'tinymce/plugins/codesample'
import 'tinymce/plugins/colorpicker'
import 'tinymce/plugins/contextmenu'
import 'tinymce/plugins/directionality'
import 'tinymce/plugins/emoticons'
import 'tinymce/plugins/fullpage'
import 'tinymce/plugins/fullscreen'
import 'tinymce/plugins/help'
import 'tinymce/plugins/hr'
import 'tinymce/plugins/image'
import 'tinymce/plugins/imagetools'
import 'tinymce/plugins/importcss'
import 'tinymce/plugins/insertdatetime'
import 'tinymce/plugins/legacyoutput'
import 'tinymce/plugins/link'
import 'tinymce/plugins/lists'
import 'tinymce/plugins/media'
import 'tinymce/plugins/nonbreaking'
import 'tinymce/plugins/noneditable'
import 'tinymce/plugins/pagebreak'
import 'tinymce/plugins/paste'
import 'tinymce/plugins/preview'
import 'tinymce/plugins/print'
import 'tinymce/plugins/save'
import 'tinymce/plugins/searchreplace'
import 'tinymce/plugins/spellchecker'
import 'tinymce/plugins/tabfocus'
import 'tinymce/plugins/table'
import 'tinymce/plugins/template'
import 'tinymce/plugins/textcolor'
import 'tinymce/plugins/textpattern'
import 'tinymce/plugins/toc'
import 'tinymce/plugins/visualblocks'
import 'tinymce/plugins/visualchars'
import 'tinymce/plugins/wordcount'
*/

var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: 'connect',


        /**
         *
         */
        value: function connect() {

            //require.context(
            //    'file-loader?name=[path][name].[ext]&context=node_modules/tinymce!tinymce/skins',
            //    true,
            //    /.*/
            //);


            __WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce___default.a.baseURL = '/orchid/js/tinymce';

            var selector = this.element.querySelector('.tinymce').id;
            var input = this.element.querySelector('input');

            var plugins = 'image media table link paste contextmenu textpattern autolink codesample';
            var toolbar1 = '';
            var inline = true;

            if (this.element.dataset.theme === 'modern') {
                plugins = 'print autosave autoresize preview paste code searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern';
                toolbar1 = 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat';
                inline = false;
            }

            __WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce___default.a.init({
                branding: false,
                selector: '#' + selector,
                theme: this.element.dataset.theme,
                min_height: 300,
                height: 300,
                max_height: 600,
                plugins: plugins,
                toolbar1: toolbar1,
                insert_toolbar: 'quickimage quicktable media codesample fullscreen',
                selection_toolbar: 'bold italic | quicklink h2 h3 blockquote | alignleft aligncenter alignright alignjustify | outdent indent | removeformat ',
                inline: inline,
                convert_urls: false,
                image_caption: true,
                image_title: true,
                image_class_list: [{
                    title: 'None',
                    value: ''
                }, {
                    title: 'Responsive',
                    value: 'img-fluid'
                }],
                setup: function setup(element) {
                    element.on('change', function () {
                        $(input).val(element.getContent());
                    });
                },
                images_upload_handler: this.upload
            });
        }
    }, {
        key: 'upload',


        /**
         *
         * @param blobInfo
         * @param success
         */
        value: function upload(blobInfo, success) {
            var data = new FormData();
            data.append('file', blobInfo.blob());

            axios.post(platform.prefix('/systems/files'), data).then(function (response) {
                success(response.data.url);
            }).catch(function (error) {
                console.warn(error);
            });
        }
    }, {
        key: 'disconnect',
        value: function disconnect() {
            __WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce___default.a.remove('#' + this.element.querySelector('.tinymce').id);
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 101:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_dropzone__ = __webpack_require__(35);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_dropzone___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_dropzone__);
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var _class = function (_Controller) {
    _inherits(_class, _Controller);

    /**
     *
     * @param props
     */
    function _class(props) {
        _classCallCheck(this, _class);

        var _this = _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).call(this, props));

        _this.attachments = {};
        return _this;
    }

    /**
     *
     * @returns {string}
     */


    /**
     *
     * @type {string[]}
     */


    _createClass(_class, [{
        key: "connect",


        /**
         *
         */
        value: function connect() {
            this.initDropZone();
            this.initSortable();
        }

        /**
         *
         */

    }, {
        key: "save",
        value: function save() {
            var data = this.activeAttachment;

            $('#modalUploadAttachment').modal('toggle');
            axios.put(platform.prefix("/systems/files/post/" + data.id), data).then();
        }

        /**
         *
         * @param dataKey
         * @returns {string}
         */

    }, {
        key: "getAttachmentTargetKey",
        value: function getAttachmentTargetKey(dataKey) {
            return dataKey + "Target";
        }

        /**
         *
         * @param data
         */

    }, {
        key: "loadInfo",
        value: function loadInfo(data) {
            var name = data.name + data.id;
            data.url = '/storage/' + data.path + data.name + '.' + data.extension;
            if (!this.attachments.hasOwnProperty(name)) {
                this.attachments[name] = data;
            }
            this.activeAttachment = data;
        }

        /**
         *
         */

    }, {
        key: "initSortable",
        value: function initSortable() {
            $(this.dropname + '.sortable-dropzone').sortable({
                scroll: false,
                containment: "parent",
                update: function update() {
                    var items = {};
                    $('.file-sort').each(function (index, value) {
                        var id = $(value).attr('data-file-id');
                        items[id] = index;
                    });

                    axios.post(platform.prefix('/systems/files/sort'), {
                        files: items
                    }).then();
                }
            });
        }

        /**
         *
         */

    }, {
        key: "initDropZone",
        value: function initDropZone() {
            var data = this.data.get('data') && JSON.parse(this.data.get('data'));
            var storage = this.data.get('storage');
            var name = this.data.get('name');
            var loadInfo = this.loadInfo.bind(this);
            var dropname = this.dropname;

            __WEBPACK_IMPORTED_MODULE_1_dropzone___default.a.autoDiscover = false;
            new __WEBPACK_IMPORTED_MODULE_1_dropzone___default.a(dropname, {
                url: platform.prefix('/systems/files'),
                method: 'post',
                uploadMultiple: false,
                parallelUploads: 100,
                maxFilesize: 9999,
                paramName: 'files',
                maxThumbnailFilesize: 99999,
                previewsContainer: dropname + '.visual-dropzone',
                addRemoveLinks: false,
                dictFileTooBig: 'File is big',

                init: function init() {
                    this.on('addedfile', function (e) {
                        var n = __WEBPACK_IMPORTED_MODULE_1_dropzone___default.a.createElement('<a href="javascript:;" class="btn-remove">&times;</a>'),
                            t = this;
                        n.addEventListener('click', function (n) {
                            n.preventDefault(), n.stopPropagation(), t.removeFile(e);
                        }), e.previewElement.appendChild(n);

                        var n = __WEBPACK_IMPORTED_MODULE_1_dropzone___default.a.createElement('<a href="javascript:;" class="btn-edit"><i class="icon - note" aria-hidden="true"></i></a>'),
                            t = this;
                        n.addEventListener('click', function (n) {
                            loadInfo(e.data);
                            $('#modalUploadAttachment').modal('show');
                        }), e.previewElement.appendChild(n);
                    });

                    this.on('completemultiple', function (file, json) {
                        $(dropname + '.sortable-dropzone').sortable('enable');
                    });

                    var instanceDropZone = this;
                    var images = data;
                    if (images) {
                        images.forEach(function (item, i, arr) {
                            var mockFile = {
                                id: item.id,
                                name: item.original_name,
                                size: item.size,
                                type: item.mime,
                                status: __WEBPACK_IMPORTED_MODULE_1_dropzone___default.a.ADDED,
                                url: '/storage/' + item.path + item.name + '.' + item.extension,
                                data: item
                            };

                            instanceDropZone.emit('addedfile', mockFile);
                            instanceDropZone.emit('thumbnail', mockFile, mockFile.url);
                            instanceDropZone.files.push(mockFile);
                            $(dropname + '.dz-preview:last-child').attr('data-file-id', item.id).addClass('file-sort');
                            $("<input type='hidden' class='files-" + item.id + "' name='" + name + "[]' value='" + item.id + "'  />").appendTo(dropname);
                        });
                    }

                    $(dropname + '.dz-progress').remove();

                    this.on('sending', function (file, xhr, formData) {
                        formData.append('_token', $("meta[name='csrf_token']").attr('content'));
                        formData.append('storage', storage);
                    });

                    this.on('removedfile', function (file) {
                        $(dropname + '.files-' + file.data.id).remove();
                        axios.delete(platform.prefix("/systems/files/" + file.data.id), {
                            storage: $('#post-attachment-dropzone').data('storage')
                        }).then();
                    });
                },
                error: function error(file, response) {
                    if ($.type(response) === 'string') {
                        return response; //dropzone sends it's own error messages in string
                    }
                    return response.message;
                },
                success: function success(file, response) {
                    file.data = response;
                    $(dropname + '.dz-preview:last-child').attr('data-file-id', response.id).addClass('file-sort');
                    $("<input type='hidden' class='files-" + response.id + "' name='" + name + "[]' value='" + response.id + "'  />").appendTo(dropname);
                }
            });
        }
    }, {
        key: "dropname",
        get: function get() {
            return '#dropzone-' + this.data.get('name') + ' ';
        }

        /**
         *
         * @returns {string|{id: *}}
         */

    }, {
        key: "activeAttachment",
        get: function get() {
            var _this2 = this;

            var id = this.activeAchivmentId;
            return ['name', 'original_name', 'alt', 'url', 'description'].reduce(function (res, key) {
                var targetKey = _this2.getAttachmentTargetKey(key);
                var target = _this2[targetKey];
                if (key === 'url') {
                    return _extends({}, res, _defineProperty({}, key, target.href));
                }
                return _extends({}, res, _defineProperty({}, key, target.value));
            }, { id: id });
        }

        /**
         *
         * @param data
         */
        ,
        set: function set(data) {
            var _this3 = this;

            this.activeAchivmentId = data.id;
            Object.keys(data).map(function (key) {
                var value = data[key];
                var targetKey = _this3.getAttachmentTargetKey(key);
                var target = _this3[targetKey];

                if (!target) {
                    return;
                }

                if (key === 'url') {
                    target.href = value;
                    return;
                }
                target.value = value;
            });
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["name", "original_name", "alt", "description", "url", "active"];
/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 103:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "connect",


        /**
         *
         */
        value: function connect() {
            if (!this.urlTarget.value) {
                return;
            }

            var url = new URL(this.urlTarget.value);

            this.sourceTarget.value = this.loadParam(url, 'source');
            this.mediumTarget.value = this.loadParam(url, 'medium');
            this.campaignTarget.value = this.loadParam(url, 'campaign');
            this.termTarget.value = this.loadParam(url, 'term');
            this.contentTarget.value = this.loadParam(url, 'content');
        }

        /**
         *
         */

    }, {
        key: "generate",
        value: function generate() {
            var url = new URL(this.urlTarget.value);
            this.urlTarget.value = url.protocol + '//' + url.host + url.pathname;

            this.addParms('source', this.sourceTarget.value);
            this.addParms('medium', this.mediumTarget.value);
            this.addParms('campaign', this.campaignTarget.value);
            this.addParms('term', this.termTarget.value);
            this.addParms('content', this.contentTarget.value);
        }

        /**
         *
         * @param text
         * @returns {string}
         */

    }, {
        key: "slugify",
        value: function slugify(text) {
            return text.toString().toLowerCase().trim().replace(/\s+/g, '-') // Replace spaces with -
            .replace(/&/g, '-and-') // Replace & with 'and'
            .replace(/[^\w\-]+/g, '') // Remove all non-word chars
            .replace(/\-\-+/g, '-'); // Replace multiple - with single -
        }

        /**
         *
         * @param replace
         * @param name
         * @param value
         */

    }, {
        key: "add",
        value: function add(replace, name, value) {
            this.urlTarget.value += replace + name + "=" + encodeURIComponent(value);
        }

        /**
         *
         * @param replace
         * @param value
         */

    }, {
        key: "change",
        value: function change(replace, value) {
            this.urlTarget.value = this.urlTarget.value.replace(replace, "$1" + encodeURIComponent(value));
        }

        /**
         *
         * @param name
         * @param value
         */

    }, {
        key: "addParms",
        value: function addParms(name, value) {
            name = "utm_" + name;
            value = this.slugify(value);

            if (value.trim().length === 0) {
                return;
            }

            var replace = new RegExp("([?&]" + name + "=)[^&]+", "");

            if (this.urlTarget.value.indexOf("?") === -1) {
                this.add("?", name, value);
                return;
            }

            if (replace.test(this.link)) {
                this.change(replace, value);
                return;
            }

            this.add("&", name, value);
        }

        /**
         *
         * @param url
         * @param param
         * @returns {string | null}
         */

    }, {
        key: "loadParam",
        value: function loadParam(url, param) {
            return url.searchParams.get('utm_' + param);
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["url", "source", "medium", "campaign", "term", "content"];
/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 104:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_frappe_charts__ = __webpack_require__(36);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_frappe_charts___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_frappe_charts__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "connect",
        value: function connect() {
            // TODO:

            var data = {
                labels: ["12am-3am", "3am-6pm", "6am-9am", "9am-12am", "12pm-3pm", "3pm-6pm", "6pm-9pm", "9am-12am"],
                datasets: [{
                    name: "Some Data", type: "bar",
                    values: [25, 40, 30, 35, 8, 52, 17, -4]
                }, {
                    name: "Another Set", type: "line",
                    values: [25, 50, -10, 15, 18, 32, 27, 14]
                }]
            };

            new __WEBPACK_IMPORTED_MODULE_1_frappe_charts__["Chart"]("#chart", { // or a DOM element,
                // new Chart() in case of ES6 module with above usage
                title: "My Awesome Chart",
                data: data,
                type: 'axis-mixed', // or 'bar', 'line', 'scatter', 'pie', 'percentage'
                height: 250,
                colors: ['#7cd6fd', '#743ee2']
            });
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 105:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_turbolinks__ = __webpack_require__(37);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_turbolinks___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_turbolinks__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__platform__ = __webpack_require__(107);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_axios__ = __webpack_require__(38);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_axios__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }






var _class = function (_Controller) {
  _inherits(_class, _Controller);

  function _class() {
    _classCallCheck(this, _class);

    return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
  }

  _createClass(_class, [{
    key: "initialize",


    /**
     *
     */
    value: function initialize() {
      __WEBPACK_IMPORTED_MODULE_1_turbolinks___default.a.start();
      window.platform = Object(__WEBPACK_IMPORTED_MODULE_2__platform__["a" /* platform */])();
    }

    /**
     *
     */

  }, {
    key: "connect",
    value: function connect() {
      this.csrf();
    }

    /**
     * We'll load the axios HTTP library which allows us to easily issue requests
     * to our Laravel back-end. This library automatically handles sending the
     * CSRF token as a header based on the value of the "XSRF" token cookie.
     */

  }, {
    key: "csrf",
    value: function csrf() {
      var token = document.head.querySelector('meta[name="csrf_token"]');
      window.axios = __WEBPACK_IMPORTED_MODULE_3_axios___default.a;

      /**
       * Next we will register the CSRF Token as a common header with Axios so that
       * all outgoing HTTP requests automatically have it attached. This is just
       * a simple convenience so we don't have to attach every token manually.
       */
      window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
      window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    }
  }]);

  return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 107:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function($) {/* harmony export (immutable) */ __webpack_exports__["a"] = platform;
function platform() {
    return {

        /**
         *
         * @param path
         * @returns {*}
         */
        prefix: function prefix(path) {
            var prefix = document.head.querySelector('meta[name="dashboard-prefix"]');

            if (prefix) {
                if (prefix.content.charAt(0) !== '/') {
                    prefix = '/' + prefix.content;
                } else if (prefix) {
                    prefix = prefix.content;
                } else {
                    return path;
                }
            }
            return prefix + path;
        },


        /**
         *
         * @param message
         * @param type
         * @param target
         */
        alert: function alert(message) {
            var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'danger';
            var target = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '#dashboard-alerts';

            $(target).append($('<div/>', {
                class: 'alert m-b-none alert-' + type,
                text: message
            }).append($('<button/>', {
                class: 'close',
                'data-dismiss': 'alert',
                'aria-label': 'Close',
                'aria-hidden': 'true'
            }).append($('<span/>', { 'aria-hidden': 'true', html: '&times;' }))), $('<div/>', { class: 'clearfix' }));
        },


        /**
         *
         * @param idForm
         * @param message
         * @returns {boolean}
         */
        validateForm: function validateForm(idForm, message) {
            if (!document.getElementById(idForm).checkValidity()) {
                window.platform.alert(message, 'warning b-b');
                return false;
            }
            return true;
        }
    };
}
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 126:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: 'connect',


        /**
         *
         */
        value: function connect() {
            var activeMenu = false;

            $('#aside-wrap-list').children('.tab-pane').each(function () {
                if ($(this).hasClass('active')) {
                    activeMenu = true;
                }
            });

            if (!activeMenu) {
                $('#menu-default').addClass('active');
            }

            $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                $(this).parent().siblings().removeClass('open');
                $(this).parent().toggleClass('open');
            });
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 127:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "filter",


        /**
         * Stimulus gives the possibility of a change event when the field loses focus
         */
        value: function filter(event) {

            var search = event.target.value.trim().toLowerCase();

            $(".admin-element-item").hide().filter(function () {
                return $(this).html().trim().toLowerCase().indexOf(search) !== -1;
            }).show();

            $(".admin-element").show().filter(function () {
                return $(this).children('.list-group').children(":visible").length === 0;
            }).hide();
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 128:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: 'targetModal',


        /**
         *
         * @param event
         * @returns {*}
         */
        value: function targetModal(event) {
            var key = event.target.dataset.modalKey;

            this.application.getControllerForElementAndIdentifier(document.getElementById('screen-modal-' + key), 'screen--modal').open({
                'title': event.target.dataset.modalTitle,
                'submit': event.target.dataset.modalAction,
                'params': event.target.dataset.modalParams
            });

            return event.preventDefault();

            //TODO: $('#screen-modal-type-'+key).addClass($('#show-button-modal-'+key).data('modalType'));
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 129:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "open",


        /**
         *
         * @param options
         */
        value: function open(options) {
            this.titleTarget.textContent = options.title;
            this.element.querySelector('form').action = options.submit;

            if (this.data.get('async')) {
                this.asyncLoadData(JSON.parse(options.params));
            }

            $(this.element).modal('toggle');
        }

        /**
         *
         * @param params
         */


        /**
         *
         * @type {string[]}
         */

    }, {
        key: "asyncLoadData",
        value: function asyncLoadData(params) {
            var modal = this;
            axios.post(this.data.get('url') + '/' + this.data.get('method') + '/' + this.data.get('slug'), params).then(function (response) {
                modal.element.querySelector('[data-async]').innerHTML = response.data;
            });
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["title"];
/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 130:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: 'connect',


        /**
         *
         */
        value: function connect() {
            var tabs = this.tabs();

            var activeId = tabs[window.location.href][this.data.get('slug')];

            console.log(activeId);

            if (activeId !== null) {
                $('#' + activeId).tab('show');
            }
        }

        /**
         *
         * @param event
         */

    }, {
        key: 'setActiveTab',
        value: function setActiveTab(event) {

            var activeId = event.target.id;
            var tabs = this.tabs();

            tabs[window.location.href][this.data.get('slug')] = activeId;
            localStorage.setItem('tabs', JSON.stringify(tabs));
            $('#' + activeId).tab('show');

            return event.preventDefault();
        }

        /**
         *
         * @returns {any}
         */

    }, {
        key: 'tabs',
        value: function tabs() {
            var tabs = JSON.parse(localStorage.getItem('tabs'));

            if (tabs === null) {
                tabs = {};
            }

            if (tabs[window.location.href] === undefined) {
                tabs[window.location.href] = {};
            }

            if (tabs[window.location.href][this.data.get('slug')] === undefined) {
                tabs[window.location.href][this.data.get('slug')] = null;
            }

            return tabs;
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 131:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 44:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(45);
module.exports = __webpack_require__(131);


/***/ }),

/***/ 45:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_stimulus_webpack_helpers__ = __webpack_require__(18);



__webpack_require__(62);

window.application = __WEBPACK_IMPORTED_MODULE_0_stimulus__["Application"].start();
var context = __webpack_require__(64);
application.load(Object(__WEBPACK_IMPORTED_MODULE_1_stimulus_webpack_helpers__["definitionsFromContext"])(context));

/***/ }),

/***/ 62:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(__webpack_provided_window_dot_jQuery, $) {window.$ = __webpack_provided_window_dot_jQuery = __webpack_require__(0);

__webpack_require__(19);

__webpack_require__(20);
__webpack_require__(22);

__webpack_require__(23);
$.fn.select2.defaults.set('theme', 'bootstrap');

__webpack_require__(63);

//require('./components/attachment');
//require('./components/filemanager');
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0), __webpack_require__(0)))

/***/ }),

/***/ 63:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {document.addEventListener('turbolinks:load', function () {
  $('.click').click(function () {
    var target = $(this).data('target');
    var toggle = $(this).data('toggle');

    if ($(target).hasClass(toggle)) {
      $(target).removeClass(toggle);
      return;
    }

    $(target).addClass(toggle);
  });
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ }),

/***/ 64:
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./components/boot_controller.js": 65,
	"./components/menu_controller.js": 67,
	"./fields/code_controller.js": 68,
	"./fields/datetime_controller.js": 70,
	"./fields/input_controller.js": 75,
	"./fields/picture_controller.js": 80,
	"./fields/select_controller.js": 82,
	"./fields/simplemde_controller.js": 83,
	"./fields/tag_controller.js": 99,
	"./fields/tinymce_controller.js": 100,
	"./fields/upload_controller.js": 101,
	"./fields/utm_controller.js": 103,
	"./layouts/charts_controller.js": 104,
	"./layouts/html_load_controller.js": 105,
	"./layouts/left_menu_controller.js": 126,
	"./layouts/systems_controller.js": 127,
	"./screen/base_controller.js": 128,
	"./screen/modal_controller.js": 129,
	"./screen/tabs_controller.js": 130
};
function webpackContext(req) {
	return __webpack_require__(webpackContextResolve(req));
};
function webpackContextResolve(req) {
	var id = map[req];
	if(!(id + 1)) // check for number or string
		throw new Error("Cannot find module '" + req + "'.");
	return id;
};
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = 64;

/***/ }),

/***/ 65:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_blueimp_tmpl__ = __webpack_require__(66);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_blueimp_tmpl___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_blueimp_tmpl__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "connect",


        /**
         *
         */
        value: function connect() {
            document.querySelector("#post-form").addEventListener('change', this.saveModel);
        }

        /**
         *
         * @param event
         * @returns {*}
         */


        /**
         *
         * @type {string[]}
         */

    }, {
        key: "addColumn",
        value: function addColumn(event) {

            if (event.which !== 13 && event.which !== 1) {
                return;
            }

            if (this.columnTarget.value.trim() === '') {
                return;
            }

            if (document.querySelector("input[name=\"columns[" + this.columnTarget.value + "][name]\"]") !== null) {
                return;
            }

            var element = this.createTrFromHTML(__WEBPACK_IMPORTED_MODULE_1_blueimp_tmpl___default()("boot-template-column", {
                "field": this.columnTarget.value
            }));

            document.getElementById('boot-container-column').appendChild(element);
            this.columnTarget.value = '';
            this.saveModel();

            return event.preventDefault();
        }

        /**
         *
         * @param event
         */

    }, {
        key: "removeColumn",
        value: function removeColumn(event) {
            event.path.forEach(function (element) {
                if (element.nodeName === 'TR') {
                    element.remove();
                    return event.preventDefault();
                }
            });
            this.saveModel();
        }

        /**
         *
         */

    }, {
        key: "addRelation",
        value: function addRelation(event) {
            var _this2 = this;

            if (event.which !== 13 && event.which !== 1) {
                return;
            }

            if (this.relationTarget.value.trim() === '') {
                return;
            }

            if (document.querySelector("input[name=\"relations[" + this.relationTarget.value + "][name]\"]") !== null) {
                return;
            }

            var element = this.createTrFromHTML(__WEBPACK_IMPORTED_MODULE_1_blueimp_tmpl___default()("boot-template-relationship", {
                "field": this.relationTarget.value
            }));

            axios.post(platform.prefix("/boot/" + this.relationTarget.value + "/getRelated")).then(function (response) {
                document.querySelector("select[name=\"relations[" + _this2.relationTarget.value + "][related]\"]").innerHTML = response.data;
            });

            document.getElementById('boot-container-relationship').appendChild(element);
            this.saveModel();

            return event.preventDefault();
        }

        /**
         *
         * @param htmlString
         * @returns {Node | null}
         */

    }, {
        key: "createTrFromHTML",
        value: function createTrFromHTML(htmlString) {
            var tr = document.createElement('tr');
            tr.innerHTML = htmlString.trim();

            return tr;
        }

        /**
         * Save model for background
         */

    }, {
        key: "saveModel",
        value: function saveModel() {
            var oData = new FormData(document.querySelector("#post-form"));

            axios.post(window.location.toString() + "/save", oData);
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["column", "relation"];
/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 66:
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_RESULT__;/*
 * JavaScript Templates
 * https://github.com/blueimp/JavaScript-Templates
 *
 * Copyright 2011, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 *
 * Inspired by John Resig's JavaScript Micro-Templating:
 * http://ejohn.org/blog/javascript-micro-templating/
 */

/* global define */

;(function ($) {
  'use strict'
  var tmpl = function (str, data) {
    var f = !/[^\w\-.:]/.test(str)
      ? (tmpl.cache[str] = tmpl.cache[str] || tmpl(tmpl.load(str)))
      : new Function( // eslint-disable-line no-new-func
        tmpl.arg + ',tmpl',
        'var _e=tmpl.encode' +
            tmpl.helper +
            ",_s='" +
            str.replace(tmpl.regexp, tmpl.func) +
            "';return _s;"
      )
    return data
      ? f(data, tmpl)
      : function (data) {
        return f(data, tmpl)
      }
  }
  tmpl.cache = {}
  tmpl.load = function (id) {
    return document.getElementById(id).innerHTML
  }
  tmpl.regexp = /([\s'\\])(?!(?:[^{]|\{(?!%))*%\})|(?:\{%(=|#)([\s\S]+?)%\})|(\{%)|(%\})/g
  tmpl.func = function (s, p1, p2, p3, p4, p5) {
    if (p1) {
      // whitespace, quote and backspace in HTML context
      return (
        {
          '\n': '\\n',
          '\r': '\\r',
          '\t': '\\t',
          ' ': ' '
        }[p1] || '\\' + p1
      )
    }
    if (p2) {
      // interpolation: {%=prop%}, or unescaped: {%#prop%}
      if (p2 === '=') {
        return "'+_e(" + p3 + ")+'"
      }
      return "'+(" + p3 + "==null?'':" + p3 + ")+'"
    }
    if (p4) {
      // evaluation start tag: {%
      return "';"
    }
    if (p5) {
      // evaluation end tag: %}
      return "_s+='"
    }
  }
  tmpl.encReg = /[<>&"'\x00]/g // eslint-disable-line no-control-regex
  tmpl.encMap = {
    '<': '&lt;',
    '>': '&gt;',
    '&': '&amp;',
    '"': '&quot;',
    "'": '&#39;'
  }
  tmpl.encode = function (s) {
    return (s == null ? '' : '' + s).replace(tmpl.encReg, function (c) {
      return tmpl.encMap[c] || ''
    })
  }
  tmpl.arg = 'o'
  tmpl.helper =
    ",print=function(s,e){_s+=e?(s==null?'':s):_e(s);}" +
    ',include=function(s,d){_s+=tmpl(s,d);}'
  if (true) {
    !(__WEBPACK_AMD_DEFINE_RESULT__ = (function () {
      return tmpl
    }).call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__))
  } else if (typeof module === 'object' && module.exports) {
    module.exports = tmpl
  } else {
    $.tmpl = tmpl
  }
})(this)


/***/ }),

/***/ 67:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "connect",


        /**
         *
         */
        value: function connect() {

            var menu = this;

            $('.dd').nestable({}).on('change', function () {
                menu.sort();

                menu.send();
            }).on('click', '.edit', function (event) {
                menu.edit(event.target);
            });

            menu.sort();

            this.checkExist();
        }

        /**
         *
         * @param object
         */


        /**
         *
         * @type {string[]}
         */

    }, {
        key: "load",
        value: function load(object) {
            this.id = object.id;
            this.labelTarget.value = object.label;
            this.slugTarget.value = object.slug;
            this.authTarget.value = object.auth;
            this.robotTarget.value = object.robot;
            this.styleTarget.value = object.style;
            this.targetTarget.value = object.target;
            this.titleTarget.value = object.title;

            this.checkExist();
        }

        /**
         *
         */

    }, {
        key: "sort",
        value: function sort() {
            $('.dd-item').each(function (i, item) {
                $(item).data({
                    sort: i
                });
            });
        }

        /**
         *
         * @param element
         */

    }, {
        key: "edit",
        value: function edit(element) {
            var data = $(element).parent().data();

            data.label = $(element).prev().text();
            this.load(data);
        }

        /**
         *
         * @returns {{label: *, title: *, auth: *, slug: *, robot: *, style: *, target: *}}
         */

    }, {
        key: "getFormData",
        value: function getFormData() {
            return {
                label: this.labelTarget.value,
                title: this.titleTarget.value,
                auth: this.authTarget.value,
                slug: this.slugTarget.value,
                robot: this.robotTarget.value,
                style: this.styleTarget.value,
                target: this.targetTarget.value
            };
        }

        /**
         *
         */

    }, {
        key: "add",
        value: function add() {
            if (!this.checkForm()) {
                return;
            }

            var $menu = this,
                $dd = $('.dd'),
                data = {
                menu: $dd.attr('data-name'),
                lang: $dd.attr('data-lang'),
                data: this.getFormData()
            };

            axios.get(this.getUri('create/'), { params: data }).then(function (response) {
                $menu.add2Dom(response.data.id);
            });
        }

        /**
         *
         * @param id
         */

    }, {
        key: "add2Dom",
        value: function add2Dom(id) {
            $('.dd > .dd-list').append("<li class=\"dd-item dd3-item\" data-id=\"" + id + "\"> <div  class=\"dd-handle dd3-handle\">Drag</div><div  class=\"dd3-content\">" + this.labelTarget.value + "</div> <div  class=\"edit icon-pencil\"></div></li>");

            $("li[data-id=" + id + "]").data(this.getFormData());

            this.sort();
            this.clear();
            this.send();
        }

        /**
         *
         */

    }, {
        key: "save",
        value: function save() {
            if (!this.checkForm()) {
                return;
            }

            $("li[data-id=" + this.id + "]").data(this.getFormData());
            $("li[data-id=" + this.id + "] > .dd3-content").html(this.labelTarget.value);

            this.clear();
            this.send();
        }

        /**
         *
         * @param id
         */

    }, {
        key: "destroy",
        value: function destroy(id) {
            axios.delete(this.getUri(id)).then(function (response) {});
        }

        /**
         *
         */

    }, {
        key: "remove",
        value: function remove() {
            $("li[data-id=" + this.id + "]").remove();
            this.destroy(this.id);
            this.clear();
        }

        /**
         *
         */

    }, {
        key: "clear",
        value: function clear() {
            this.labelTarget.value = '';
            this.titleTarget.value = '';
            this.authTarget.value = 0;
            this.slugTarget.value = '';
            this.robotTarget.value = 'follow';
            this.styleTarget.value = '';
            this.targetTarget.value = '_self';
            this.id = '';

            this.checkExist();
            window.Turbolinks.visit(window.location, { action: 'replace' });
        }

        /**
         *
         */

    }, {
        key: "send",
        value: function send() {
            var $dd = $('.dd'),
                name = $dd.attr('data-name'),
                data = {
                lang: $dd.attr('data-lang'),
                data: $dd.nestable('serialize')
            };

            axios.put(this.getUri(name), data).then(function (response) {});
        }

        /**
         *
         * @returns {boolean}
         */

    }, {
        key: "checkForm",
        value: function checkForm() {
            if (!this.labelTarget.value) {
                this.showBlocks('errors.label');
                return false;
            }

            if (!this.titleTarget.value) {
                this.showBlocks('errors.title');
                return false;
            }

            if (!this.slugTarget.value) {
                this.showBlocks('errors.slug');
                return false;
            }

            this.hiddenBlocks(['errors.slug', 'errors.label', 'errors.title']);

            return true;
        }

        /**
         *
         */

    }, {
        key: "checkExist",
        value: function checkExist() {
            if (this.exist()) {

                this.showBlocks(['menu.remove', 'menu.reset', 'menu.save']);

                this.hiddenBlocks('menu.create');
                return;
            }

            this.showBlocks(['menu.create']);

            this.hiddenBlocks(['menu.remove', 'menu.reset', 'menu.save']);
        }

        /**
         *
         * @returns {boolean}
         */

    }, {
        key: "exist",
        value: function exist() {
            return Number.isInteger(this.id) && $("li[data-id=" + this.id + "]").length > 0;
        }

        /**
         *
         * @param path
         * @returns {*}
         */

    }, {
        key: "getUri",
        value: function getUri() {
            var path = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';

            return platform.prefix("/press/menu/" + path);
        }

        /**
         *
         * @param blocks
         */

    }, {
        key: "hiddenBlocks",
        value: function hiddenBlocks(blocks) {
            if (!Array.isArray(blocks)) {
                blocks = [blocks];
            }
            blocks.forEach(function (element) {
                document.getElementById(element).classList.add("none");
            });
        }

        /**
         *
         * @param blocks
         */

    }, {
        key: "showBlocks",
        value: function showBlocks(blocks) {
            if (!Array.isArray(blocks)) {
                blocks = [blocks];
            }
            blocks.forEach(function (element) {
                document.getElementById(element).classList.remove("none");
            });
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["id", "label", "slug", "auth", "robot", "style", "target", "title"];
/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 68:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_codeflask__ = __webpack_require__(69);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: 'connect',


        /**
         *
         */
        value: function connect() {
            var input = this.element.querySelector('input');

            var flask = new __WEBPACK_IMPORTED_MODULE_1_codeflask__["a" /* default */](this.element.querySelector('.code'), {
                language: this.data.get('language'),
                lineNumbers: this.data.get('lineNumbers'),
                defaultTheme: this.data.get('defaultTheme')
            });

            flask.updateCode(input.value);

            flask.onUpdate(function (code) {
                input.value = code;
            });
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 69:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(global) {var BACKGROUND_COLOR="#fff",LINE_HEIGHT="20px",FONT_SIZE="13px",default_css_theme="\n.codeflask {\n  background: "+BACKGROUND_COLOR+";\n  color: #4f559c;\n}\n\n.codeflask .token.punctuation {\n  color: #4a4a4a;\n}\n\n.codeflask .token.keyword {\n  color: #8500ff;\n}\n\n.codeflask .token.operator {\n  color: #ff5598;\n}\n\n.codeflask .token.string {\n  color: #41ad8f;\n}\n\n.codeflask .token.comment {\n  color: #9badb7;\n}\n\n.codeflask .token.function {\n  color: #8500ff;\n}\n\n.codeflask .token.boolean {\n  color: #8500ff;\n}\n\n.codeflask .token.number {\n  color: #8500ff;\n}\n\n.codeflask .token.selector {\n  color: #8500ff;\n}\n\n.codeflask .token.property {\n  color: #8500ff;\n}\n\n.codeflask .token.tag {\n  color: #8500ff;\n}\n\n.codeflask .token.attr-value {\n  color: #8500ff;\n}\n",FONT_FAMILY='"SFMono-Regular", Consolas, "Liberation Mono", Menlo, Courier, monospace',COLOR=CSS.supports("caret-color","#000")?BACKGROUND_COLOR:"#ccc",LINE_NUMBER_WIDTH="40px",editor_css="\n  .codeflask {\n    position: absolute;\n    width: 100%;\n    height: 100%;\n    overflow: hidden;\n  }\n\n  .codeflask, .codeflask * {\n    box-sizing: border-box;\n  }\n\n  .codeflask__pre {\n    pointer-events: none;\n    z-index: 3;\n    overflow: hidden;\n  }\n\n  .codeflask__textarea {\n    background: none;\n    border: none;\n    color: "+COLOR+";\n    z-index: 1;\n    resize: none;\n    font-family: "+FONT_FAMILY+";\n    -webkit-appearance: pre;\n    caret-color: #111;\n    z-index: 2;\n    width: 100%;\n    height: 100%;\n  }\n\n  .codeflask--has-line-numbers .codeflask__textarea {\n    width: calc(100% - "+LINE_NUMBER_WIDTH+");\n  }\n\n  .codeflask__code {\n    display: block;\n    font-family: "+FONT_FAMILY+";\n    overflow: hidden;\n  }\n\n  .codeflask__flatten {\n    padding: 10px;\n    font-size: "+FONT_SIZE+";\n    line-height: "+LINE_HEIGHT+";\n    white-space: pre;\n    position: absolute;\n    top: 0;\n    left: 0;\n    overflow: auto;\n    margin: 0 !important;\n    outline: none;\n    text-align: left;\n  }\n\n  .codeflask--has-line-numbers .codeflask__flatten {\n    width: calc(100% - "+LINE_NUMBER_WIDTH+");\n    left: "+LINE_NUMBER_WIDTH+";\n  }\n\n  .codeflask__line-highlight {\n    position: absolute;\n    top: 10px;\n    left: 0;\n    width: 100%;\n    height: "+LINE_HEIGHT+";\n    background: rgba(0,0,0,0.1);\n    z-index: 1;\n  }\n\n  .codeflask__lines {\n    padding: 10px 4px;\n    font-size: 12px;\n    line-height: "+LINE_HEIGHT+";\n    font-family: 'Cousine', monospace;\n    position: absolute;\n    left: 0;\n    top: 0;\n    width: "+LINE_NUMBER_WIDTH+";\n    height: 100%;\n    text-align: right;\n    color: #999;\n    z-index: 2;\n  }\n\n  .codeflask__lines__line {\n    display: block;\n  }\n\n  .codeflask.codeflask--has-line-numbers {\n    padding-left: "+LINE_NUMBER_WIDTH+";\n  }\n\n  .codeflask.codeflask--has-line-numbers:before {\n    content: '';\n    position: absolute;\n    left: 0;\n    top: 0;\n    width: "+LINE_NUMBER_WIDTH+";\n    height: 100%;\n    background: #eee;\n    z-index: 1;\n  }\n";function inject_css(e,t,n){var a=t||"codeflask-style",s=n||document.head;if(!e)return!1;if(document.getElementById(a))return!0;var o=document.createElement("style");return o.innerHTML=e,o.id=a,s.appendChild(o),!0}var entityMap={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;","/":"&#x2F;","`":"&#x60;","=":"&#x3D;"};function escape_html(e){return String(e).replace(/[&<>"'`=\/]/g,function(e){return entityMap[e]})}var commonjsGlobal="undefined"!=typeof window?window:"undefined"!=typeof global?global:"undefined"!=typeof self?self:{};function createCommonjsModule(e,t){return e(t={exports:{}},t.exports),t.exports}var prism=createCommonjsModule(function(e){var t="undefined"!=typeof window?window:"undefined"!=typeof WorkerGlobalScope&&self instanceof WorkerGlobalScope?self:{},n=function(){var e=/\blang(?:uage)?-([\w-]+)\b/i,n=0,a=t.Prism={manual:t.Prism&&t.Prism.manual,disableWorkerMessageHandler:t.Prism&&t.Prism.disableWorkerMessageHandler,util:{encode:function(e){return e instanceof s?new s(e.type,a.util.encode(e.content),e.alias):"Array"===a.util.type(e)?e.map(a.util.encode):e.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/\u00a0/g," ")},type:function(e){return Object.prototype.toString.call(e).match(/\[object (\w+)\]/)[1]},objId:function(e){return e.__id||Object.defineProperty(e,"__id",{value:++n}),e.__id},clone:function(e,t){var n=a.util.type(e);switch(t=t||{},n){case"Object":if(t[a.util.objId(e)])return t[a.util.objId(e)];var s={};for(var o in t[a.util.objId(e)]=s,e)e.hasOwnProperty(o)&&(s[o]=a.util.clone(e[o],t));return s;case"Array":if(t[a.util.objId(e)])return t[a.util.objId(e)];s=[];return t[a.util.objId(e)]=s,e.forEach(function(e,n){s[n]=a.util.clone(e,t)}),s}return e}},languages:{extend:function(e,t){var n=a.util.clone(a.languages[e]);for(var s in t)n[s]=t[s];return n},insertBefore:function(e,t,n,s){var o=(s=s||a.languages)[e];if(2==arguments.length){for(var r in n=arguments[1])n.hasOwnProperty(r)&&(o[r]=n[r]);return o}var i={};for(var l in o)if(o.hasOwnProperty(l)){if(l==t)for(var r in n)n.hasOwnProperty(r)&&(i[r]=n[r]);i[l]=o[l]}return a.languages.DFS(a.languages,function(t,n){n===s[e]&&t!=e&&(this[t]=i)}),s[e]=i},DFS:function(e,t,n,s){for(var o in s=s||{},e)e.hasOwnProperty(o)&&(t.call(e,o,e[o],n||o),"Object"!==a.util.type(e[o])||s[a.util.objId(e[o])]?"Array"!==a.util.type(e[o])||s[a.util.objId(e[o])]||(s[a.util.objId(e[o])]=!0,a.languages.DFS(e[o],t,o,s)):(s[a.util.objId(e[o])]=!0,a.languages.DFS(e[o],t,null,s)))}},plugins:{},highlightAll:function(e,t){a.highlightAllUnder(document,e,t)},highlightAllUnder:function(e,t,n){var s={callback:n,selector:'code[class*="language-"], [class*="language-"] code, code[class*="lang-"], [class*="lang-"] code'};a.hooks.run("before-highlightall",s);for(var o,r=s.elements||e.querySelectorAll(s.selector),i=0;o=r[i++];)a.highlightElement(o,!0===t,s.callback)},highlightElement:function(n,s,o){for(var r,i,l=n;l&&!e.test(l.className);)l=l.parentNode;l&&(r=(l.className.match(e)||[,""])[1].toLowerCase(),i=a.languages[r]),n.className=n.className.replace(e,"").replace(/\s+/g," ")+" language-"+r,n.parentNode&&(l=n.parentNode,/pre/i.test(l.nodeName)&&(l.className=l.className.replace(e,"").replace(/\s+/g," ")+" language-"+r));var c={element:n,language:r,grammar:i,code:n.textContent};if(a.hooks.run("before-sanity-check",c),!c.code||!c.grammar)return c.code&&(a.hooks.run("before-highlight",c),c.element.textContent=c.code,a.hooks.run("after-highlight",c)),void a.hooks.run("complete",c);if(a.hooks.run("before-highlight",c),s&&t.Worker){var d=new Worker(a.filename);d.onmessage=function(e){c.highlightedCode=e.data,a.hooks.run("before-insert",c),c.element.innerHTML=c.highlightedCode,o&&o.call(c.element),a.hooks.run("after-highlight",c),a.hooks.run("complete",c)},d.postMessage(JSON.stringify({language:c.language,code:c.code,immediateClose:!0}))}else c.highlightedCode=a.highlight(c.code,c.grammar,c.language),a.hooks.run("before-insert",c),c.element.innerHTML=c.highlightedCode,o&&o.call(n),a.hooks.run("after-highlight",c),a.hooks.run("complete",c)},highlight:function(e,t,n){var o={code:e,grammar:t,language:n};return a.hooks.run("before-tokenize",o),o.tokens=a.tokenize(o.code,o.grammar),a.hooks.run("after-tokenize",o),s.stringify(a.util.encode(o.tokens),o.language)},matchGrammar:function(e,t,n,s,o,r,i){var l=a.Token;for(var c in n)if(n.hasOwnProperty(c)&&n[c]){if(c==i)return;var d=n[c];d="Array"===a.util.type(d)?d:[d];for(var u=0;u<d.length;++u){var p=d[u],h=p.inside,g=!!p.lookbehind,f=!!p.greedy,m=0,b=p.alias;if(f&&!p.pattern.global){var k=p.pattern.toString().match(/[imuy]*$/)[0];p.pattern=RegExp(p.pattern.source,k+"g")}p=p.pattern||p;for(var y=s,v=o;y<t.length;v+=t[y].length,++y){var x=t[y];if(t.length>e.length)return;if(!(x instanceof l)){if(f&&y!=t.length-1){if(p.lastIndex=v,!(N=p.exec(e)))break;for(var C=N.index+(g?N[1].length:0),F=N.index+N[0].length,_=y,w=v,L=t.length;_<L&&(w<F||!t[_].type&&!t[_-1].greedy);++_)C>=(w+=t[_].length)&&(++y,v=w);if(t[y]instanceof l)continue;T=_-y,x=e.slice(v,w),N.index-=v}else{p.lastIndex=0;var N=p.exec(x),T=1}if(N){g&&(m=N[1]?N[1].length:0);F=(C=N.index+m)+(N=N[0].slice(m)).length;var E=x.slice(0,C),A=x.slice(F),S=[y,T];E&&(++y,v+=E.length,S.push(E));var I=new l(c,h?a.tokenize(N,h):N,b,N,f);if(S.push(I),A&&S.push(A),Array.prototype.splice.apply(t,S),1!=T&&a.matchGrammar(e,t,n,y,v,!0,c),r)break}else if(r)break}}}}},tokenize:function(e,t,n){var s=[e],o=t.rest;if(o){for(var r in o)t[r]=o[r];delete t.rest}return a.matchGrammar(e,s,t,0,0,!1),s},hooks:{all:{},add:function(e,t){var n=a.hooks.all;n[e]=n[e]||[],n[e].push(t)},run:function(e,t){var n=a.hooks.all[e];if(n&&n.length)for(var s,o=0;s=n[o++];)s(t)}}},s=a.Token=function(e,t,n,a,s){this.type=e,this.content=t,this.alias=n,this.length=0|(a||"").length,this.greedy=!!s};if(s.stringify=function(e,t,n){if("string"==typeof e)return e;if("Array"===a.util.type(e))return e.map(function(n){return s.stringify(n,t,e)}).join("");var o={type:e.type,content:s.stringify(e.content,t,n),tag:"span",classes:["token",e.type],attributes:{},language:t,parent:n};if(e.alias){var r="Array"===a.util.type(e.alias)?e.alias:[e.alias];Array.prototype.push.apply(o.classes,r)}a.hooks.run("wrap",o);var i=Object.keys(o.attributes).map(function(e){return e+'="'+(o.attributes[e]||"").replace(/"/g,"&quot;")+'"'}).join(" ");return"<"+o.tag+' class="'+o.classes.join(" ")+'"'+(i?" "+i:"")+">"+o.content+"</"+o.tag+">"},!t.document)return t.addEventListener?(a.disableWorkerMessageHandler||t.addEventListener("message",function(e){var n=JSON.parse(e.data),s=n.language,o=n.code,r=n.immediateClose;t.postMessage(a.highlight(o,a.languages[s],s)),r&&t.close()},!1),t.Prism):t.Prism;var o=document.currentScript||[].slice.call(document.getElementsByTagName("script")).pop();return o&&(a.filename=o.src,a.manual||o.hasAttribute("data-manual")||("loading"!==document.readyState?window.requestAnimationFrame?window.requestAnimationFrame(a.highlightAll):window.setTimeout(a.highlightAll,16):document.addEventListener("DOMContentLoaded",a.highlightAll))),t.Prism}();e.exports&&(e.exports=n),void 0!==commonjsGlobal&&(commonjsGlobal.Prism=n),n.languages.markup={comment:/<!--[\s\S]*?-->/,prolog:/<\?[\s\S]+?\?>/,doctype:/<!DOCTYPE[\s\S]+?>/i,cdata:/<!\[CDATA\[[\s\S]*?]]>/i,tag:{pattern:/<\/?(?!\d)[^\s>\/=$<%]+(?:\s+[^\s>\/=]+(?:=(?:("|')(?:\\[\s\S]|(?!\1)[^\\])*\1|[^\s'">=]+))?)*\s*\/?>/i,greedy:!0,inside:{tag:{pattern:/^<\/?[^\s>\/]+/i,inside:{punctuation:/^<\/?/,namespace:/^[^\s>\/:]+:/}},"attr-value":{pattern:/=(?:("|')(?:\\[\s\S]|(?!\1)[^\\])*\1|[^\s'">=]+)/i,inside:{punctuation:[/^=/,{pattern:/(^|[^\\])["']/,lookbehind:!0}]}},punctuation:/\/?>/,"attr-name":{pattern:/[^\s>\/]+/,inside:{namespace:/^[^\s>\/:]+:/}}}},entity:/&#?[\da-z]{1,8};/i},n.languages.markup.tag.inside["attr-value"].inside.entity=n.languages.markup.entity,n.hooks.add("wrap",function(e){"entity"===e.type&&(e.attributes.title=e.content.replace(/&amp;/,"&"))}),n.languages.xml=n.languages.markup,n.languages.html=n.languages.markup,n.languages.mathml=n.languages.markup,n.languages.svg=n.languages.markup,n.languages.css={comment:/\/\*[\s\S]*?\*\//,atrule:{pattern:/@[\w-]+?.*?(?:;|(?=\s*\{))/i,inside:{rule:/@[\w-]+/}},url:/url\((?:(["'])(?:\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1|.*?)\)/i,selector:/[^{}\s][^{};]*?(?=\s*\{)/,string:{pattern:/("|')(?:\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1/,greedy:!0},property:/[-_a-z\xA0-\uFFFF][-\w\xA0-\uFFFF]*(?=\s*:)/i,important:/\B!important\b/i,function:/[-a-z0-9]+(?=\()/i,punctuation:/[(){};:]/},n.languages.css.atrule.inside.rest=n.languages.css,n.languages.markup&&(n.languages.insertBefore("markup","tag",{style:{pattern:/(<style[\s\S]*?>)[\s\S]*?(?=<\/style>)/i,lookbehind:!0,inside:n.languages.css,alias:"language-css",greedy:!0}}),n.languages.insertBefore("inside","attr-value",{"style-attr":{pattern:/\s*style=("|')(?:\\[\s\S]|(?!\1)[^\\])*\1/i,inside:{"attr-name":{pattern:/^\s*style/i,inside:n.languages.markup.tag.inside},punctuation:/^\s*=\s*['"]|['"]\s*$/,"attr-value":{pattern:/.+/i,inside:n.languages.css}},alias:"language-css"}},n.languages.markup.tag)),n.languages.clike={comment:[{pattern:/(^|[^\\])\/\*[\s\S]*?(?:\*\/|$)/,lookbehind:!0},{pattern:/(^|[^\\:])\/\/.*/,lookbehind:!0,greedy:!0}],string:{pattern:/(["'])(?:\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1/,greedy:!0},"class-name":{pattern:/((?:\b(?:class|interface|extends|implements|trait|instanceof|new)\s+)|(?:catch\s+\())[\w.\\]+/i,lookbehind:!0,inside:{punctuation:/[.\\]/}},keyword:/\b(?:if|else|while|do|for|return|in|instanceof|function|new|try|throw|catch|finally|null|break|continue)\b/,boolean:/\b(?:true|false)\b/,function:/[a-z0-9_]+(?=\()/i,number:/\b0x[\da-f]+\b|(?:\b\d+\.?\d*|\B\.\d+)(?:e[+-]?\d+)?/i,operator:/--?|\+\+?|!=?=?|<=?|>=?|==?=?|&&?|\|\|?|\?|\*|\/|~|\^|%/,punctuation:/[{}[\];(),.:]/},n.languages.javascript=n.languages.extend("clike",{keyword:/\b(?:as|async|await|break|case|catch|class|const|continue|debugger|default|delete|do|else|enum|export|extends|finally|for|from|function|get|if|implements|import|in|instanceof|interface|let|new|null|of|package|private|protected|public|return|set|static|super|switch|this|throw|try|typeof|var|void|while|with|yield)\b/,number:/\b(?:0[xX][\dA-Fa-f]+|0[bB][01]+|0[oO][0-7]+|NaN|Infinity)\b|(?:\b\d+\.?\d*|\B\.\d+)(?:[Ee][+-]?\d+)?/,function:/[_$a-z\xA0-\uFFFF][$\w\xA0-\uFFFF]*(?=\s*\()/i,operator:/-[-=]?|\+[+=]?|!=?=?|<<?=?|>>?>?=?|=(?:==?|>)?|&[&=]?|\|[|=]?|\*\*?=?|\/=?|~|\^=?|%=?|\?|\.{3}/}),n.languages.insertBefore("javascript","keyword",{regex:{pattern:/((?:^|[^$\w\xA0-\uFFFF."'\])\s])\s*)\/(\[[^\]\r\n]+]|\\.|[^/\\\[\r\n])+\/[gimyu]{0,5}(?=\s*($|[\r\n,.;})\]]))/,lookbehind:!0,greedy:!0},"function-variable":{pattern:/[_$a-z\xA0-\uFFFF][$\w\xA0-\uFFFF]*(?=\s*=\s*(?:function\b|(?:\([^()]*\)|[_$a-z\xA0-\uFFFF][$\w\xA0-\uFFFF]*)\s*=>))/i,alias:"function"},constant:/\b[A-Z][A-Z\d_]*\b/}),n.languages.insertBefore("javascript","string",{"template-string":{pattern:/`(?:\\[\s\S]|\${[^}]+}|[^\\`])*`/,greedy:!0,inside:{interpolation:{pattern:/\${[^}]+}/,inside:{"interpolation-punctuation":{pattern:/^\${|}$/,alias:"punctuation"},rest:null}},string:/[\s\S]+/}}}),n.languages.javascript["template-string"].inside.interpolation.inside.rest=n.languages.javascript,n.languages.markup&&n.languages.insertBefore("markup","tag",{script:{pattern:/(<script[\s\S]*?>)[\s\S]*?(?=<\/script>)/i,lookbehind:!0,inside:n.languages.javascript,alias:"language-javascript",greedy:!0}}),n.languages.js=n.languages.javascript,"undefined"!=typeof self&&self.Prism&&self.document&&document.querySelector&&(self.Prism.fileHighlight=function(){var e={js:"javascript",py:"python",rb:"ruby",ps1:"powershell",psm1:"powershell",sh:"bash",bat:"batch",h:"c",tex:"latex"};Array.prototype.slice.call(document.querySelectorAll("pre[data-src]")).forEach(function(t){for(var a,s=t.getAttribute("data-src"),o=t,r=/\blang(?:uage)?-([\w-]+)\b/i;o&&!r.test(o.className);)o=o.parentNode;if(o&&(a=(t.className.match(r)||[,""])[1]),!a){var i=(s.match(/\.(\w+)$/)||[,""])[1];a=e[i]||i}var l=document.createElement("code");l.className="language-"+a,t.textContent="",l.textContent="Loading…",t.appendChild(l);var c=new XMLHttpRequest;c.open("GET",s,!0),c.onreadystatechange=function(){4==c.readyState&&(c.status<400&&c.responseText?(l.textContent=c.responseText,n.highlightElement(l)):c.status>=400?l.textContent="✖ Error "+c.status+" while fetching file: "+c.statusText:l.textContent="✖ Error: File does not exist or is empty")},c.send(null)}),n.plugins.toolbar&&n.plugins.toolbar.registerButton("download-file",function(e){var t=e.element.parentNode;if(t&&/pre/i.test(t.nodeName)&&t.hasAttribute("data-src")&&t.hasAttribute("data-download-link")){var n=t.getAttribute("data-src"),a=document.createElement("a");return a.textContent=t.getAttribute("data-download-link-label")||"Download",a.setAttribute("download",""),a.href=n,a}})},document.addEventListener("DOMContentLoaded",self.Prism.fileHighlight))}),CodeFlask=function(e,t){if(!e)throw Error("CodeFlask expects a parameter which is Element or a String selector");if(!t)throw Error("CodeFlask expects an object containing options as second parameter");if(e.nodeType)this.editorRoot=e;else{var n=document.querySelector(e);n&&(this.editorRoot=n)}this.opts=t,this.startEditor()};CodeFlask.prototype.startEditor=function(){if(!inject_css(editor_css,null,this.opts.styleParent))throw Error("Failed to inject CodeFlask CSS.");this.createWrapper(),this.createTextarea(),this.createPre(),this.createCode(),this.runOptions(),this.listenTextarea(),this.populateDefault(),this.updateCode(this.code)},CodeFlask.prototype.createWrapper=function(){this.code=this.editorRoot.innerHTML,this.editorRoot.innerHTML="",this.elWrapper=this.createElement("div",this.editorRoot),this.elWrapper.classList.add("codeflask")},CodeFlask.prototype.createTextarea=function(){this.elTextarea=this.createElement("textarea",this.elWrapper),this.elTextarea.classList.add("codeflask__textarea","codeflask__flatten")},CodeFlask.prototype.createPre=function(){this.elPre=this.createElement("pre",this.elWrapper),this.elPre.classList.add("codeflask__pre","codeflask__flatten")},CodeFlask.prototype.createCode=function(){this.elCode=this.createElement("code",this.elPre),this.elCode.classList.add("codeflask__code","language-"+(this.opts.language||"html"))},CodeFlask.prototype.createLineNumbers=function(){this.elLineNumbers=this.createElement("div",this.elWrapper),this.elLineNumbers.classList.add("codeflask__lines"),this.setLineNumber()},CodeFlask.prototype.createElement=function(e,t){var n=document.createElement(e);return t.appendChild(n),n},CodeFlask.prototype.runOptions=function(){this.opts.rtl=this.opts.rtl||!1,this.opts.tabSize=this.opts.tabSize||2,this.opts.enableAutocorrect=this.opts.enableAutocorrect||!1,this.opts.lineNumbers=this.opts.lineNumbers||!1,this.opts.defaultTheme=!1!==this.opts.defaultTheme,this.opts.areaId=this.opts.areaId||null,this.opts.ariaLabelledby=this.opts.ariaLabelledby||null,!0===this.opts.rtl&&(this.elTextarea.setAttribute("dir","rtl"),this.elPre.setAttribute("dir","rtl")),!1===this.opts.enableAutocorrect&&(this.elTextarea.setAttribute("spellcheck","false"),this.elTextarea.setAttribute("autocapitalize","off"),this.elTextarea.setAttribute("autocomplete","off"),this.elTextarea.setAttribute("autocorrect","off")),this.opts.lineNumbers&&(this.elWrapper.classList.add("codeflask--has-line-numbers"),this.createLineNumbers()),this.opts.defaultTheme&&inject_css(default_css_theme,"theme-default",this.opts.styleParent),this.opts.areaId&&this.elTextarea.setAttribute("id",this.opts.areaId),this.opts.ariaLabelledby&&this.elTextarea.setAttribute("aria-labelledby",this.opts.ariaLabelledby)},CodeFlask.prototype.updateLineNumbersCount=function(){for(var e="",t=1;t<=this.lineNumber;t++)e=e+'<span class="codeflask__lines__line">'+t+"</span>";this.elLineNumbers.innerHTML=e},CodeFlask.prototype.listenTextarea=function(){var e=this;this.elTextarea.addEventListener("input",function(t){e.code=t.target.value,e.elCode.innerHTML=escape_html(t.target.value),e.highlight(),setTimeout(function(){e.runUpdate(),e.setLineNumber()},1)}),this.elTextarea.addEventListener("keydown",function(t){e.handleTabs(t),e.handleSelfClosingCharacters(t),e.handleNewLineIndentation(t)}),this.elTextarea.addEventListener("scroll",function(t){e.elPre.style.transform="translate3d(-"+t.target.scrollLeft+"px, -"+t.target.scrollTop+"px, 0)",e.elLineNumbers&&(e.elLineNumbers.style.transform="translate3d(0, -"+t.target.scrollTop+"px, 0)")})},CodeFlask.prototype.handleTabs=function(e){if(9===e.keyCode){e.preventDefault();e.keyCode;var t=this.elTextarea.selectionStart,n=this.elTextarea.selectionEnd,a=""+this.code.substring(0,t)+" ".repeat(this.opts.tabSize)+this.code.substring(n);this.updateCode(a),this.elTextarea.selectionEnd=n+this.opts.tabSize}},CodeFlask.prototype.handleSelfClosingCharacters=function(e){var t=e.key;if(["(","[","{","<"].includes(t))switch(t){case"(":this.closeCharacter(")");break;case"[":this.closeCharacter("]");break;case"{":this.closeCharacter("}");break;case"<":this.closeCharacter(">")}},CodeFlask.prototype.setLineNumber=function(){this.lineNumber=this.code.split("\n").length,this.opts.lineNumbers&&this.updateLineNumbersCount()},CodeFlask.prototype.handleNewLineIndentation=function(e){e.keyCode},CodeFlask.prototype.closeCharacter=function(e){var t=this.elTextarea.selectionStart,n=this.elTextarea.selectionEnd,a=""+this.code.substring(0,t)+e+this.code.substring(n);this.updateCode(a),this.elTextarea.selectionEnd=n},CodeFlask.prototype.updateCode=function(e){this.code=e,this.elTextarea.value=e,this.elCode.innerHTML=escape_html(e),this.highlight(),setTimeout(this.runUpdate.bind(this),1)},CodeFlask.prototype.updateLanguage=function(e){var t=this.opts.language;this.elCode.classList.remove("language-"+t),this.elCode.classList.add("language-"+e),this.opts.language=e,this.highlight()},CodeFlask.prototype.addLanguage=function(e,t){prism.languages[e]=t},CodeFlask.prototype.populateDefault=function(){this.updateCode(this.code)},CodeFlask.prototype.highlight=function(){prism.highlightElement(this.elCode,!1)},CodeFlask.prototype.onUpdate=function(e){if(e&&"[object Function]"!=={}.toString.call(e))throw Error("CodeFlask expects callback of type Function");this.updateCallBack=e},CodeFlask.prototype.getCode=function(){return this.code},CodeFlask.prototype.runUpdate=function(){this.updateCallBack&&this.updateCallBack(this.code)};/* harmony default export */ __webpack_exports__["a"] = (CodeFlask);

/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(4)))

/***/ }),

/***/ 70:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus_flatpickr__ = __webpack_require__(71);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus_flatpickr___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_stimulus_flatpickr__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_flatpickr_dist_plugins_rangePlugin_js__ = __webpack_require__(73);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_flatpickr_dist_plugins_rangePlugin_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_flatpickr_dist_plugins_rangePlugin_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_flatpickr_dist_l10n__ = __webpack_require__(74);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_flatpickr_dist_l10n___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_flatpickr_dist_l10n__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }





var _class = function (_Flatpickr) {
    _inherits(_class, _Flatpickr);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "initialize",


        /**
         *
         */
        value: function initialize() {
            var plugins = [];
            if (this.data.get('range')) {
                plugins.push(new __WEBPACK_IMPORTED_MODULE_1_flatpickr_dist_plugins_rangePlugin_js___default.a({ input: this.data.get('range') }));
            }

            this.config = {
                locale: document.documentElement.lang,
                "plugins": plugins
            };
        }

        /**
         *
         */

    }, {
        key: "connect",
        value: function connect() {
            _get(_class.prototype.__proto__ || Object.getPrototypeOf(_class.prototype), "connect", this).call(this);
        }

        /**
         *
         * @param selectedDates
         * @param dateStr
         * @param instance
         * @returns {*}
         */

    }, {
        key: "change",
        value: function change(selectedDates, dateStr, instance) {
            return dateStr;
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus_flatpickr___default.a);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 71:
/***/ (function(module, exports, __webpack_require__) {

var t,e=__webpack_require__(1),n=(t=__webpack_require__(72))&&"object"==typeof t&&"default"in t?t.default:t,o={string:["altFormat","altInputClass","ariaDateFormat","dateFormat","defaultDate","mode","nextArrow","prevArrow"],boolean:["altInput","allowInput","clickOpens","disableMobile","enableTime","enableSeconds","inline","noCalendar","shorthandCurrentMonth","static","time_24hr","weekNumbers","wrap"],date:["maxDate","minDate"],array:["disable","enable"],number:["defaultHour","defaultMinute","hourIncrement","minuteIncrement"]},a=["change","open","close","monthChange","yearChange","ready","valueUpdate","dayCreate"],r=["input","calendarContainer","prevMonthNav","nextMonthNav","currentMonthElement","currentYearElement","days"],i=function(t){function e(){t.apply(this,arguments)}return t&&(e.__proto__=t),(e.prototype=Object.create(t&&t.prototype)).constructor=e,e.prototype.initialize=function(){this.config={}},e.prototype.connect=function(){this.initializeEvents(),this.initializeOptions(),this.fp=n(this.element,Object.assign({},this.config)),this.initializeElements()},e.prototype.disconnect=function(){this.fp.destroy()},e.prototype.initializeEvents=function(){var t=this;a.forEach(function(e){var n,o="on"+((n=e).charAt(0).toUpperCase()+n.slice(1));t.config[o]=t[e].bind(t)})},e.prototype.initializeOptions=function(){var t=this;Object.keys(o).forEach(function(e){o[e].forEach(function(n){var o=n.replace(/([a-z])([A-Z])/g,"$1-$2").replace(/\s+/g,"-").toLowerCase();t.data.has(o)&&(t.config[n]=t[e](o))})})},e.prototype.initializeElements=function(){var t=this;r.forEach(function(e){t[e+"Target"]=t.fp[e]})},e.prototype.change=function(){},e.prototype.open=function(){},e.prototype.close=function(){},e.prototype.monthChange=function(){},e.prototype.yearChange=function(){},e.prototype.ready=function(){},e.prototype.valueUpdate=function(){},e.prototype.dayCreate=function(){},e.prototype.string=function(t){return this.data.get(t)},e.prototype.date=function(t){return this.data.get(t)},e.prototype.boolean=function(t){return"true"===this.data.get(t)},e.prototype.array=function(t){return JSON.parse(this.data.get(t))},e.prototype.number=function(t){return parseInt(this.data.get(t))},e}(e.Controller);module.exports=i;
//# sourceMappingURL=stimulus-flatpickr.js.map


/***/ }),

/***/ 72:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(jQuery) {/* flatpickr v4.5.1, @license MIT */
(function (global, factory) {
     true ? module.exports = factory() :
    typeof define === 'function' && define.amd ? define(factory) :
    (global.flatpickr = factory());
}(this, (function () { 'use strict';

    var pad = function pad(number) {
      return ("0" + number).slice(-2);
    };
    var int = function int(bool) {
      return bool === true ? 1 : 0;
    };
    function debounce(func, wait, immediate) {
      if (immediate === void 0) {
        immediate = false;
      }

      var timeout;
      return function () {
        var context = this,
            args = arguments;
        timeout !== null && clearTimeout(timeout);
        timeout = window.setTimeout(function () {
          timeout = null;
          if (!immediate) func.apply(context, args);
        }, wait);
        if (immediate && !timeout) func.apply(context, args);
      };
    }
    var arrayify = function arrayify(obj) {
      return obj instanceof Array ? obj : [obj];
    };

    var do_nothing = function do_nothing() {
      return undefined;
    };

    var monthToStr = function monthToStr(monthNumber, shorthand, locale) {
      return locale.months[shorthand ? "shorthand" : "longhand"][monthNumber];
    };
    var revFormat = {
      D: do_nothing,
      F: function F(dateObj, monthName, locale) {
        dateObj.setMonth(locale.months.longhand.indexOf(monthName));
      },
      G: function G(dateObj, hour) {
        dateObj.setHours(parseFloat(hour));
      },
      H: function H(dateObj, hour) {
        dateObj.setHours(parseFloat(hour));
      },
      J: function J(dateObj, day) {
        dateObj.setDate(parseFloat(day));
      },
      K: function K(dateObj, amPM, locale) {
        dateObj.setHours(dateObj.getHours() % 12 + 12 * int(new RegExp(locale.amPM[1], "i").test(amPM)));
      },
      M: function M(dateObj, shortMonth, locale) {
        dateObj.setMonth(locale.months.shorthand.indexOf(shortMonth));
      },
      S: function S(dateObj, seconds) {
        dateObj.setSeconds(parseFloat(seconds));
      },
      U: function U(_, unixSeconds) {
        return new Date(parseFloat(unixSeconds) * 1000);
      },
      W: function W(dateObj, weekNum) {
        var weekNumber = parseInt(weekNum);
        return new Date(dateObj.getFullYear(), 0, 2 + (weekNumber - 1) * 7, 0, 0, 0, 0);
      },
      Y: function Y(dateObj, year) {
        dateObj.setFullYear(parseFloat(year));
      },
      Z: function Z(_, ISODate) {
        return new Date(ISODate);
      },
      d: function d(dateObj, day) {
        dateObj.setDate(parseFloat(day));
      },
      h: function h(dateObj, hour) {
        dateObj.setHours(parseFloat(hour));
      },
      i: function i(dateObj, minutes) {
        dateObj.setMinutes(parseFloat(minutes));
      },
      j: function j(dateObj, day) {
        dateObj.setDate(parseFloat(day));
      },
      l: do_nothing,
      m: function m(dateObj, month) {
        dateObj.setMonth(parseFloat(month) - 1);
      },
      n: function n(dateObj, month) {
        dateObj.setMonth(parseFloat(month) - 1);
      },
      s: function s(dateObj, seconds) {
        dateObj.setSeconds(parseFloat(seconds));
      },
      w: do_nothing,
      y: function y(dateObj, year) {
        dateObj.setFullYear(2000 + parseFloat(year));
      }
    };
    var tokenRegex = {
      D: "(\\w+)",
      F: "(\\w+)",
      G: "(\\d\\d|\\d)",
      H: "(\\d\\d|\\d)",
      J: "(\\d\\d|\\d)\\w+",
      K: "",
      M: "(\\w+)",
      S: "(\\d\\d|\\d)",
      U: "(.+)",
      W: "(\\d\\d|\\d)",
      Y: "(\\d{4})",
      Z: "(.+)",
      d: "(\\d\\d|\\d)",
      h: "(\\d\\d|\\d)",
      i: "(\\d\\d|\\d)",
      j: "(\\d\\d|\\d)",
      l: "(\\w+)",
      m: "(\\d\\d|\\d)",
      n: "(\\d\\d|\\d)",
      s: "(\\d\\d|\\d)",
      w: "(\\d\\d|\\d)",
      y: "(\\d{2})"
    };
    var formats = {
      Z: function Z(date) {
        return date.toISOString();
      },
      D: function D(date, locale, options) {
        return locale.weekdays.shorthand[formats.w(date, locale, options)];
      },
      F: function F(date, locale, options) {
        return monthToStr(formats.n(date, locale, options) - 1, false, locale);
      },
      G: function G(date, locale, options) {
        return pad(formats.h(date, locale, options));
      },
      H: function H(date) {
        return pad(date.getHours());
      },
      J: function J(date, locale) {
        return locale.ordinal !== undefined ? date.getDate() + locale.ordinal(date.getDate()) : date.getDate();
      },
      K: function K(date, locale) {
        return locale.amPM[int(date.getHours() > 11)];
      },
      M: function M(date, locale) {
        return monthToStr(date.getMonth(), true, locale);
      },
      S: function S(date) {
        return pad(date.getSeconds());
      },
      U: function U(date) {
        return date.getTime() / 1000;
      },
      W: function W(date, _, options) {
        return options.getWeek(date);
      },
      Y: function Y(date) {
        return date.getFullYear();
      },
      d: function d(date) {
        return pad(date.getDate());
      },
      h: function h(date) {
        return date.getHours() % 12 ? date.getHours() % 12 : 12;
      },
      i: function i(date) {
        return pad(date.getMinutes());
      },
      j: function j(date) {
        return date.getDate();
      },
      l: function l(date, locale) {
        return locale.weekdays.longhand[date.getDay()];
      },
      m: function m(date) {
        return pad(date.getMonth() + 1);
      },
      n: function n(date) {
        return date.getMonth() + 1;
      },
      s: function s(date) {
        return date.getSeconds();
      },
      w: function w(date) {
        return date.getDay();
      },
      y: function y(date) {
        return String(date.getFullYear()).substring(2);
      }
    };

    var english = {
      weekdays: {
        shorthand: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        longhand: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
      },
      months: {
        shorthand: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        longhand: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
      },
      daysInMonth: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
      firstDayOfWeek: 0,
      ordinal: function ordinal(nth) {
        var s = nth % 100;
        if (s > 3 && s < 21) return "th";

        switch (s % 10) {
          case 1:
            return "st";

          case 2:
            return "nd";

          case 3:
            return "rd";

          default:
            return "th";
        }
      },
      rangeSeparator: " to ",
      weekAbbreviation: "Wk",
      scrollTitle: "Scroll to increment",
      toggleTitle: "Click to toggle",
      amPM: ["AM", "PM"],
      yearAriaLabel: "Year"
    };

    var createDateFormatter = function createDateFormatter(_ref) {
      var _ref$config = _ref.config,
          config = _ref$config === void 0 ? defaults : _ref$config,
          _ref$l10n = _ref.l10n,
          l10n = _ref$l10n === void 0 ? english : _ref$l10n;
      return function (dateObj, frmt, overrideLocale) {
        if (config.formatDate !== undefined) return config.formatDate(dateObj, frmt);
        var locale = overrideLocale || l10n;
        return frmt.split("").map(function (c, i, arr) {
          return formats[c] && arr[i - 1] !== "\\" ? formats[c](dateObj, locale, config) : c !== "\\" ? c : "";
        }).join("");
      };
    };
    var createDateParser = function createDateParser(_ref2) {
      var _ref2$config = _ref2.config,
          config = _ref2$config === void 0 ? defaults : _ref2$config,
          _ref2$l10n = _ref2.l10n,
          l10n = _ref2$l10n === void 0 ? english : _ref2$l10n;
      return function (date, givenFormat, timeless, customLocale) {
        if (date !== 0 && !date) return undefined;
        var locale = customLocale || l10n;
        var parsedDate;
        var date_orig = date;
        if (date instanceof Date) parsedDate = new Date(date.getTime());else if (typeof date !== "string" && date.toFixed !== undefined) parsedDate = new Date(date);else if (typeof date === "string") {
          var format = givenFormat || (config || defaults).dateFormat;
          var datestr = String(date).trim();

          if (datestr === "today") {
            parsedDate = new Date();
            timeless = true;
          } else if (/Z$/.test(datestr) || /GMT$/.test(datestr)) parsedDate = new Date(date);else if (config && config.parseDate) parsedDate = config.parseDate(date, format);else {
            parsedDate = !config || !config.noCalendar ? new Date(new Date().getFullYear(), 0, 1, 0, 0, 0, 0) : new Date(new Date().setHours(0, 0, 0, 0));
            var matched,
                ops = [];

            for (var i = 0, matchIndex = 0, regexStr = ""; i < format.length; i++) {
              var token = format[i];
              var isBackSlash = token === "\\";
              var escaped = format[i - 1] === "\\" || isBackSlash;

              if (tokenRegex[token] && !escaped) {
                regexStr += tokenRegex[token];
                var match = new RegExp(regexStr).exec(date);

                if (match && (matched = true)) {
                  ops[token !== "Y" ? "push" : "unshift"]({
                    fn: revFormat[token],
                    val: match[++matchIndex]
                  });
                }
              } else if (!isBackSlash) regexStr += ".";

              ops.forEach(function (_ref3) {
                var fn = _ref3.fn,
                    val = _ref3.val;
                return parsedDate = fn(parsedDate, val, locale) || parsedDate;
              });
            }

            parsedDate = matched ? parsedDate : undefined;
          }
        }

        if (!(parsedDate instanceof Date && !isNaN(parsedDate.getTime()))) {
          config.errorHandler(new Error("Invalid date provided: " + date_orig));
          return undefined;
        }

        if (timeless === true) parsedDate.setHours(0, 0, 0, 0);
        return parsedDate;
      };
    };
    function compareDates(date1, date2, timeless) {
      if (timeless === void 0) {
        timeless = true;
      }

      if (timeless !== false) {
        return new Date(date1.getTime()).setHours(0, 0, 0, 0) - new Date(date2.getTime()).setHours(0, 0, 0, 0);
      }

      return date1.getTime() - date2.getTime();
    }
    var getWeek = function getWeek(givenDate) {
      var date = new Date(givenDate.getTime());
      date.setHours(0, 0, 0, 0);
      date.setDate(date.getDate() + 3 - (date.getDay() + 6) % 7);
      var week1 = new Date(date.getFullYear(), 0, 4);
      return 1 + Math.round(((date.getTime() - week1.getTime()) / 86400000 - 3 + (week1.getDay() + 6) % 7) / 7);
    };
    var isBetween = function isBetween(ts, ts1, ts2) {
      return ts > Math.min(ts1, ts2) && ts < Math.max(ts1, ts2);
    };
    var duration = {
      DAY: 86400000
    };

    var defaults = {
      _disable: [],
      _enable: [],
      allowInput: false,
      altFormat: "F j, Y",
      altInput: false,
      altInputClass: "form-control input",
      animate: typeof window === "object" && window.navigator.userAgent.indexOf("MSIE") === -1,
      ariaDateFormat: "F j, Y",
      clickOpens: true,
      closeOnSelect: true,
      conjunction: ", ",
      dateFormat: "Y-m-d",
      defaultHour: 12,
      defaultMinute: 0,
      defaultSeconds: 0,
      disable: [],
      disableMobile: false,
      enable: [],
      enableSeconds: false,
      enableTime: false,
      errorHandler: function errorHandler(err) {
        return typeof console !== "undefined" && console.warn(err);
      },
      getWeek: getWeek,
      hourIncrement: 1,
      ignoredFocusElements: [],
      inline: false,
      locale: "default",
      minuteIncrement: 5,
      mode: "single",
      nextArrow: "<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 17 17'><g></g><path d='M13.207 8.472l-7.854 7.854-0.707-0.707 7.146-7.146-7.146-7.148 0.707-0.707 7.854 7.854z' /></svg>",
      noCalendar: false,
      now: new Date(),
      onChange: [],
      onClose: [],
      onDayCreate: [],
      onDestroy: [],
      onKeyDown: [],
      onMonthChange: [],
      onOpen: [],
      onParseConfig: [],
      onReady: [],
      onValueUpdate: [],
      onYearChange: [],
      onPreCalendarPosition: [],
      plugins: [],
      position: "auto",
      positionElement: undefined,
      prevArrow: "<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 17 17'><g></g><path d='M5.207 8.471l7.146 7.147-0.707 0.707-7.853-7.854 7.854-7.853 0.707 0.707-7.147 7.146z' /></svg>",
      shorthandCurrentMonth: false,
      showMonths: 1,
      static: false,
      time_24hr: false,
      weekNumbers: false,
      wrap: false
    };

    function toggleClass(elem, className, bool) {
      if (bool === true) return elem.classList.add(className);
      elem.classList.remove(className);
    }
    function createElement(tag, className, content) {
      var e = window.document.createElement(tag);
      className = className || "";
      content = content || "";
      e.className = className;
      if (content !== undefined) e.textContent = content;
      return e;
    }
    function clearNode(node) {
      while (node.firstChild) {
        node.removeChild(node.firstChild);
      }
    }
    function findParent(node, condition) {
      if (condition(node)) return node;else if (node.parentNode) return findParent(node.parentNode, condition);
      return undefined;
    }
    function createNumberInput(inputClassName, opts) {
      var wrapper = createElement("div", "numInputWrapper"),
          numInput = createElement("input", "numInput " + inputClassName),
          arrowUp = createElement("span", "arrowUp"),
          arrowDown = createElement("span", "arrowDown");
      numInput.type = "text";
      numInput.pattern = "\\d*";
      if (opts !== undefined) for (var key in opts) {
        numInput.setAttribute(key, opts[key]);
      }
      wrapper.appendChild(numInput);
      wrapper.appendChild(arrowUp);
      wrapper.appendChild(arrowDown);
      return wrapper;
    }

    if (typeof Object.assign !== "function") {
      Object.assign = function (target) {
        if (!target) {
          throw TypeError("Cannot convert undefined or null to object");
        }

        for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
          args[_key - 1] = arguments[_key];
        }

        var _loop = function _loop() {
          var source = args[_i];

          if (source) {
            Object.keys(source).forEach(function (key) {
              return target[key] = source[key];
            });
          }
        };

        for (var _i = 0; _i < args.length; _i++) {
          _loop();
        }

        return target;
      };
    }

    var DEBOUNCED_CHANGE_MS = 300;

    function FlatpickrInstance(element, instanceConfig) {
      var self = {
        config: Object.assign({}, flatpickr.defaultConfig),
        l10n: english
      };
      self.parseDate = createDateParser({
        config: self.config,
        l10n: self.l10n
      });
      self._handlers = [];
      self._bind = bind;
      self._setHoursFromDate = setHoursFromDate;
      self._positionCalendar = positionCalendar;
      self.changeMonth = changeMonth;
      self.changeYear = changeYear;
      self.clear = clear;
      self.close = close;
      self._createElement = createElement;
      self.destroy = destroy;
      self.isEnabled = isEnabled;
      self.jumpToDate = jumpToDate;
      self.open = open;
      self.redraw = redraw;
      self.set = set;
      self.setDate = setDate;
      self.toggle = toggle;

      function setupHelperFunctions() {
        self.utils = {
          getDaysInMonth: function getDaysInMonth(month, yr) {
            if (month === void 0) {
              month = self.currentMonth;
            }

            if (yr === void 0) {
              yr = self.currentYear;
            }

            if (month === 1 && (yr % 4 === 0 && yr % 100 !== 0 || yr % 400 === 0)) return 29;
            return self.l10n.daysInMonth[month];
          }
        };
      }

      function init() {
        self.element = self.input = element;
        self.isOpen = false;
        parseConfig();
        setupLocale();
        setupInputs();
        setupDates();
        setupHelperFunctions();
        if (!self.isMobile) build();
        bindEvents();

        if (self.selectedDates.length || self.config.noCalendar) {
          if (self.config.enableTime) {
            setHoursFromDate(self.config.noCalendar ? self.latestSelectedDateObj || self.config.minDate : undefined);
          }

          updateValue(false);
        }

        setCalendarWidth();
        self.showTimeInput = self.selectedDates.length > 0 || self.config.noCalendar;
        var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

        if (!self.isMobile && isSafari) {
          positionCalendar();
        }

        triggerEvent("onReady");
      }

      function bindToInstance(fn) {
        return fn.bind(self);
      }

      function setCalendarWidth() {
        var config = self.config;
        if (config.weekNumbers === false && config.showMonths === 1) return;else if (config.noCalendar !== true) {
          window.requestAnimationFrame(function () {
            self.calendarContainer.style.visibility = "hidden";
            self.calendarContainer.style.display = "block";

            if (self.daysContainer !== undefined) {
              var daysWidth = (self.days.offsetWidth + 1) * config.showMonths;
              self.daysContainer.style.width = daysWidth + "px";
              self.calendarContainer.style.width = daysWidth + (self.weekWrapper !== undefined ? self.weekWrapper.offsetWidth : 0) + "px";
              self.calendarContainer.style.removeProperty("visibility");
              self.calendarContainer.style.removeProperty("display");
            }
          });
        }
      }

      function updateTime(e) {
        if (self.selectedDates.length === 0) return;

        if (e !== undefined && e.type !== "blur") {
          timeWrapper(e);
        }

        var prevValue = self._input.value;
        setHoursFromInputs();
        updateValue();

        if (self._input.value !== prevValue) {
          self._debouncedChange();
        }
      }

      function ampm2military(hour, amPM) {
        return hour % 12 + 12 * int(amPM === self.l10n.amPM[1]);
      }

      function military2ampm(hour) {
        switch (hour % 24) {
          case 0:
          case 12:
            return 12;

          default:
            return hour % 12;
        }
      }

      function setHoursFromInputs() {
        if (self.hourElement === undefined || self.minuteElement === undefined) return;
        var hours = (parseInt(self.hourElement.value.slice(-2), 10) || 0) % 24,
            minutes = (parseInt(self.minuteElement.value, 10) || 0) % 60,
            seconds = self.secondElement !== undefined ? (parseInt(self.secondElement.value, 10) || 0) % 60 : 0;

        if (self.amPM !== undefined) {
          hours = ampm2military(hours, self.amPM.textContent);
        }

        var limitMinHours = self.config.minTime !== undefined || self.config.minDate && self.minDateHasTime && self.latestSelectedDateObj && compareDates(self.latestSelectedDateObj, self.config.minDate, true) === 0;
        var limitMaxHours = self.config.maxTime !== undefined || self.config.maxDate && self.maxDateHasTime && self.latestSelectedDateObj && compareDates(self.latestSelectedDateObj, self.config.maxDate, true) === 0;

        if (limitMaxHours) {
          var maxTime = self.config.maxTime !== undefined ? self.config.maxTime : self.config.maxDate;
          hours = Math.min(hours, maxTime.getHours());
          if (hours === maxTime.getHours()) minutes = Math.min(minutes, maxTime.getMinutes());
          if (minutes === maxTime.getMinutes()) seconds = Math.min(seconds, maxTime.getSeconds());
        }

        if (limitMinHours) {
          var minTime = self.config.minTime !== undefined ? self.config.minTime : self.config.minDate;
          hours = Math.max(hours, minTime.getHours());
          if (hours === minTime.getHours()) minutes = Math.max(minutes, minTime.getMinutes());
          if (minutes === minTime.getMinutes()) seconds = Math.max(seconds, minTime.getSeconds());
        }

        setHours(hours, minutes, seconds);
      }

      function setHoursFromDate(dateObj) {
        var date = dateObj || self.latestSelectedDateObj;
        if (date) setHours(date.getHours(), date.getMinutes(), date.getSeconds());
      }

      function setDefaultHours() {
        var hours = self.config.defaultHour;
        var minutes = self.config.defaultMinute;
        var seconds = self.config.defaultSeconds;

        if (self.config.minDate !== undefined) {
          var min_hr = self.config.minDate.getHours();
          var min_minutes = self.config.minDate.getMinutes();
          hours = Math.max(hours, min_hr);
          if (hours === min_hr) minutes = Math.max(min_minutes, minutes);
          if (hours === min_hr && minutes === min_minutes) seconds = self.config.minDate.getSeconds();
        }

        if (self.config.maxDate !== undefined) {
          var max_hr = self.config.maxDate.getHours();
          var max_minutes = self.config.maxDate.getMinutes();
          hours = Math.min(hours, max_hr);
          if (hours === max_hr) minutes = Math.min(max_minutes, minutes);
          if (hours === max_hr && minutes === max_minutes) seconds = self.config.maxDate.getSeconds();
        }

        setHours(hours, minutes, seconds);
      }

      function setHours(hours, minutes, seconds) {
        if (self.latestSelectedDateObj !== undefined) {
          self.latestSelectedDateObj.setHours(hours % 24, minutes, seconds || 0, 0);
        }

        if (!self.hourElement || !self.minuteElement || self.isMobile) return;
        self.hourElement.value = pad(!self.config.time_24hr ? (12 + hours) % 12 + 12 * int(hours % 12 === 0) : hours);
        self.minuteElement.value = pad(minutes);
        if (self.amPM !== undefined) self.amPM.textContent = self.l10n.amPM[int(hours >= 12)];
        if (self.secondElement !== undefined) self.secondElement.value = pad(seconds);
      }

      function onYearInput(event) {
        var year = parseInt(event.target.value) + (event.delta || 0);

        if (year / 1000 > 1 || event.key === "Enter" && !/[^\d]/.test(year.toString())) {
          changeYear(year);
        }
      }

      function bind(element, event, handler, options) {
        if (event instanceof Array) return event.forEach(function (ev) {
          return bind(element, ev, handler, options);
        });
        if (element instanceof Array) return element.forEach(function (el) {
          return bind(el, event, handler, options);
        });
        element.addEventListener(event, handler, options);

        self._handlers.push({
          element: element,
          event: event,
          handler: handler,
          options: options
        });
      }

      function onClick(handler) {
        return function (evt) {
          evt.which === 1 && handler(evt);
        };
      }

      function triggerChange() {
        triggerEvent("onChange");
      }

      function bindEvents() {
        if (self.config.wrap) {
          ["open", "close", "toggle", "clear"].forEach(function (evt) {
            Array.prototype.forEach.call(self.element.querySelectorAll("[data-" + evt + "]"), function (el) {
              return bind(el, "click", self[evt]);
            });
          });
        }

        if (self.isMobile) {
          setupMobile();
          return;
        }

        var debouncedResize = debounce(onResize, 50);
        self._debouncedChange = debounce(triggerChange, DEBOUNCED_CHANGE_MS);
        if (self.daysContainer && !/iPhone|iPad|iPod/i.test(navigator.userAgent)) bind(self.daysContainer, "mouseover", function (e) {
          if (self.config.mode === "range") onMouseOver(e.target);
        });
        bind(window.document.body, "keydown", onKeyDown);
        if (!self.config.static) bind(self._input, "keydown", onKeyDown);
        if (!self.config.inline && !self.config.static) bind(window, "resize", debouncedResize);
        if (window.ontouchstart !== undefined) bind(window.document, "click", documentClick);else bind(window.document, "mousedown", onClick(documentClick));
        bind(window.document, "focus", documentClick, {
          capture: true
        });

        if (self.config.clickOpens === true) {
          bind(self._input, "focus", self.open);
          bind(self._input, "mousedown", onClick(self.open));
        }

        if (self.daysContainer !== undefined) {
          bind(self.monthNav, "mousedown", onClick(onMonthNavClick));
          bind(self.monthNav, ["keyup", "increment"], onYearInput);
          bind(self.daysContainer, "mousedown", onClick(selectDate));
        }

        if (self.timeContainer !== undefined && self.minuteElement !== undefined && self.hourElement !== undefined) {
          var selText = function selText(e) {
            return e.target.select();
          };

          bind(self.timeContainer, ["increment"], updateTime);
          bind(self.timeContainer, "blur", updateTime, {
            capture: true
          });
          bind(self.timeContainer, "mousedown", onClick(timeIncrement));
          bind([self.hourElement, self.minuteElement], ["focus", "click"], selText);
          if (self.secondElement !== undefined) bind(self.secondElement, "focus", function () {
            return self.secondElement && self.secondElement.select();
          });

          if (self.amPM !== undefined) {
            bind(self.amPM, "mousedown", onClick(function (e) {
              updateTime(e);
              triggerChange();
            }));
          }
        }
      }

      function jumpToDate(jumpDate) {
        var jumpTo = jumpDate !== undefined ? self.parseDate(jumpDate) : self.latestSelectedDateObj || (self.config.minDate && self.config.minDate > self.now ? self.config.minDate : self.config.maxDate && self.config.maxDate < self.now ? self.config.maxDate : self.now);

        try {
          if (jumpTo !== undefined) {
            self.currentYear = jumpTo.getFullYear();
            self.currentMonth = jumpTo.getMonth();
          }
        } catch (e) {
          e.message = "Invalid date supplied: " + jumpTo;
          self.config.errorHandler(e);
        }

        self.redraw();
      }

      function timeIncrement(e) {
        if (~e.target.className.indexOf("arrow")) incrementNumInput(e, e.target.classList.contains("arrowUp") ? 1 : -1);
      }

      function incrementNumInput(e, delta, inputElem) {
        var target = e && e.target;
        var input = inputElem || target && target.parentNode && target.parentNode.firstChild;
        var event = createEvent("increment");
        event.delta = delta;
        input && input.dispatchEvent(event);
      }

      function build() {
        var fragment = window.document.createDocumentFragment();
        self.calendarContainer = createElement("div", "flatpickr-calendar");
        self.calendarContainer.tabIndex = -1;

        if (!self.config.noCalendar) {
          fragment.appendChild(buildMonthNav());
          self.innerContainer = createElement("div", "flatpickr-innerContainer");

          if (self.config.weekNumbers) {
            var _buildWeeks = buildWeeks(),
                weekWrapper = _buildWeeks.weekWrapper,
                weekNumbers = _buildWeeks.weekNumbers;

            self.innerContainer.appendChild(weekWrapper);
            self.weekNumbers = weekNumbers;
            self.weekWrapper = weekWrapper;
          }

          self.rContainer = createElement("div", "flatpickr-rContainer");
          self.rContainer.appendChild(buildWeekdays());

          if (!self.daysContainer) {
            self.daysContainer = createElement("div", "flatpickr-days");
            self.daysContainer.tabIndex = -1;
          }

          buildDays();
          self.rContainer.appendChild(self.daysContainer);
          self.innerContainer.appendChild(self.rContainer);
          fragment.appendChild(self.innerContainer);
        }

        if (self.config.enableTime) {
          fragment.appendChild(buildTime());
        }

        toggleClass(self.calendarContainer, "rangeMode", self.config.mode === "range");
        toggleClass(self.calendarContainer, "animate", self.config.animate === true);
        toggleClass(self.calendarContainer, "multiMonth", self.config.showMonths > 1);
        self.calendarContainer.appendChild(fragment);
        var customAppend = self.config.appendTo !== undefined && self.config.appendTo.nodeType !== undefined;

        if (self.config.inline || self.config.static) {
          self.calendarContainer.classList.add(self.config.inline ? "inline" : "static");

          if (self.config.inline) {
            if (!customAppend && self.element.parentNode) self.element.parentNode.insertBefore(self.calendarContainer, self._input.nextSibling);else if (self.config.appendTo !== undefined) self.config.appendTo.appendChild(self.calendarContainer);
          }

          if (self.config.static) {
            var wrapper = createElement("div", "flatpickr-wrapper");
            if (self.element.parentNode) self.element.parentNode.insertBefore(wrapper, self.element);
            wrapper.appendChild(self.element);
            if (self.altInput) wrapper.appendChild(self.altInput);
            wrapper.appendChild(self.calendarContainer);
          }
        }

        if (!self.config.static && !self.config.inline) (self.config.appendTo !== undefined ? self.config.appendTo : window.document.body).appendChild(self.calendarContainer);
      }

      function createDay(className, date, dayNumber, i) {
        var dateIsEnabled = isEnabled(date, true),
            dayElement = createElement("span", "flatpickr-day " + className, date.getDate().toString());
        dayElement.dateObj = date;
        dayElement.$i = i;
        dayElement.setAttribute("aria-label", self.formatDate(date, self.config.ariaDateFormat));

        if (className.indexOf("hidden") === -1 && compareDates(date, self.now) === 0) {
          self.todayDateElem = dayElement;
          dayElement.classList.add("today");
          dayElement.setAttribute("aria-current", "date");
        }

        if (dateIsEnabled) {
          dayElement.tabIndex = -1;

          if (isDateSelected(date)) {
            dayElement.classList.add("selected");
            self.selectedDateElem = dayElement;

            if (self.config.mode === "range") {
              toggleClass(dayElement, "startRange", self.selectedDates[0] && compareDates(date, self.selectedDates[0], true) === 0);
              toggleClass(dayElement, "endRange", self.selectedDates[1] && compareDates(date, self.selectedDates[1], true) === 0);
              if (className === "nextMonthDay") dayElement.classList.add("inRange");
            }
          }
        } else {
          dayElement.classList.add("disabled");
        }

        if (self.config.mode === "range") {
          if (isDateInRange(date) && !isDateSelected(date)) dayElement.classList.add("inRange");
        }

        if (self.weekNumbers && self.config.showMonths === 1 && className !== "prevMonthDay" && dayNumber % 7 === 1) {
          self.weekNumbers.insertAdjacentHTML("beforeend", "<span class='flatpickr-day'>" + self.config.getWeek(date) + "</span>");
        }

        triggerEvent("onDayCreate", dayElement);
        return dayElement;
      }

      function focusOnDayElem(targetNode) {
        targetNode.focus();
        if (self.config.mode === "range") onMouseOver(targetNode);
      }

      function getFirstAvailableDay(delta) {
        var startMonth = delta > 0 ? 0 : self.config.showMonths - 1;
        var endMonth = delta > 0 ? self.config.showMonths : -1;

        for (var m = startMonth; m != endMonth; m += delta) {
          var month = self.daysContainer.children[m];
          var startIndex = delta > 0 ? 0 : month.children.length - 1;
          var endIndex = delta > 0 ? month.children.length : -1;

          for (var i = startIndex; i != endIndex; i += delta) {
            var c = month.children[i];
            if (c.className.indexOf("hidden") === -1 && isEnabled(c.dateObj)) return c;
          }
        }

        return undefined;
      }

      function getNextAvailableDay(current, delta) {
        var givenMonth = current.className.indexOf("Month") === -1 ? current.dateObj.getMonth() : self.currentMonth;
        var endMonth = delta > 0 ? self.config.showMonths : -1;
        var loopDelta = delta > 0 ? 1 : -1;

        for (var m = givenMonth - self.currentMonth; m != endMonth; m += loopDelta) {
          var month = self.daysContainer.children[m];
          var startIndex = givenMonth - self.currentMonth === m ? current.$i + delta : delta < 0 ? month.children.length - 1 : 0;
          var numMonthDays = month.children.length;

          for (var i = startIndex; i >= 0 && i < numMonthDays && i != (delta > 0 ? numMonthDays : -1); i += loopDelta) {
            var c = month.children[i];
            if (c.className.indexOf("hidden") === -1 && isEnabled(c.dateObj) && Math.abs(current.$i - i) >= Math.abs(delta)) return focusOnDayElem(c);
          }
        }

        self.changeMonth(loopDelta);
        focusOnDay(getFirstAvailableDay(loopDelta), 0);
        return undefined;
      }

      function focusOnDay(current, offset) {
        var dayFocused = isInView(document.activeElement);
        var startElem = current !== undefined ? current : dayFocused ? document.activeElement : self.selectedDateElem !== undefined && isInView(self.selectedDateElem) ? self.selectedDateElem : self.todayDateElem !== undefined && isInView(self.todayDateElem) ? self.todayDateElem : getFirstAvailableDay(offset > 0 ? 1 : -1);
        if (startElem === undefined) return self._input.focus();
        if (!dayFocused) return focusOnDayElem(startElem);
        getNextAvailableDay(startElem, offset);
      }

      function buildMonthDays(year, month) {
        var firstOfMonth = (new Date(year, month, 1).getDay() - self.l10n.firstDayOfWeek + 7) % 7;
        var prevMonthDays = self.utils.getDaysInMonth((month - 1 + 12) % 12);
        var daysInMonth = self.utils.getDaysInMonth(month),
            days = window.document.createDocumentFragment(),
            isMultiMonth = self.config.showMonths > 1,
            prevMonthDayClass = isMultiMonth ? "prevMonthDay hidden" : "prevMonthDay",
            nextMonthDayClass = isMultiMonth ? "nextMonthDay hidden" : "nextMonthDay";
        var dayNumber = prevMonthDays + 1 - firstOfMonth,
            dayIndex = 0;

        for (; dayNumber <= prevMonthDays; dayNumber++, dayIndex++) {
          days.appendChild(createDay(prevMonthDayClass, new Date(year, month - 1, dayNumber), dayNumber, dayIndex));
        }

        for (dayNumber = 1; dayNumber <= daysInMonth; dayNumber++, dayIndex++) {
          days.appendChild(createDay("", new Date(year, month, dayNumber), dayNumber, dayIndex));
        }

        for (var dayNum = daysInMonth + 1; dayNum <= 42 - firstOfMonth && (self.config.showMonths === 1 || dayIndex % 7 !== 0); dayNum++, dayIndex++) {
          days.appendChild(createDay(nextMonthDayClass, new Date(year, month + 1, dayNum % daysInMonth), dayNum, dayIndex));
        }

        var dayContainer = createElement("div", "dayContainer");
        dayContainer.appendChild(days);
        return dayContainer;
      }

      function buildDays() {
        if (self.daysContainer === undefined) {
          return;
        }

        clearNode(self.daysContainer);
        if (self.weekNumbers) clearNode(self.weekNumbers);
        var frag = document.createDocumentFragment();

        for (var i = 0; i < self.config.showMonths; i++) {
          var d = new Date(self.currentYear, self.currentMonth, 1);
          d.setMonth(self.currentMonth + i);
          frag.appendChild(buildMonthDays(d.getFullYear(), d.getMonth()));
        }

        self.daysContainer.appendChild(frag);
        self.days = self.daysContainer.firstChild;

        if (self.config.mode === "range" && self.selectedDates.length === 1) {
          onMouseOver();
        }
      }

      function buildMonth() {
        var container = createElement("div", "flatpickr-month");
        var monthNavFragment = window.document.createDocumentFragment();
        var monthElement = createElement("span", "cur-month");
        var yearInput = createNumberInput("cur-year", {
          tabindex: "-1"
        });
        var yearElement = yearInput.childNodes[0];
        yearElement.setAttribute("aria-label", self.l10n.yearAriaLabel);
        if (self.config.minDate) yearElement.setAttribute("data-min", self.config.minDate.getFullYear().toString());

        if (self.config.maxDate) {
          yearElement.setAttribute("data-max", self.config.maxDate.getFullYear().toString());
          yearElement.disabled = !!self.config.minDate && self.config.minDate.getFullYear() === self.config.maxDate.getFullYear();
        }

        var currentMonth = createElement("div", "flatpickr-current-month");
        currentMonth.appendChild(monthElement);
        currentMonth.appendChild(yearInput);
        monthNavFragment.appendChild(currentMonth);
        container.appendChild(monthNavFragment);
        return {
          container: container,
          yearElement: yearElement,
          monthElement: monthElement
        };
      }

      function buildMonths() {
        clearNode(self.monthNav);
        self.monthNav.appendChild(self.prevMonthNav);

        for (var m = self.config.showMonths; m--;) {
          var month = buildMonth();
          self.yearElements.push(month.yearElement);
          self.monthElements.push(month.monthElement);
          self.monthNav.appendChild(month.container);
        }

        self.monthNav.appendChild(self.nextMonthNav);
      }

      function buildMonthNav() {
        self.monthNav = createElement("div", "flatpickr-months");
        self.yearElements = [];
        self.monthElements = [];
        self.prevMonthNav = createElement("span", "flatpickr-prev-month");
        self.prevMonthNav.innerHTML = self.config.prevArrow;
        self.nextMonthNav = createElement("span", "flatpickr-next-month");
        self.nextMonthNav.innerHTML = self.config.nextArrow;
        buildMonths();
        Object.defineProperty(self, "_hidePrevMonthArrow", {
          get: function get() {
            return self.__hidePrevMonthArrow;
          },
          set: function set(bool) {
            if (self.__hidePrevMonthArrow !== bool) {
              toggleClass(self.prevMonthNav, "disabled", bool);
              self.__hidePrevMonthArrow = bool;
            }
          }
        });
        Object.defineProperty(self, "_hideNextMonthArrow", {
          get: function get() {
            return self.__hideNextMonthArrow;
          },
          set: function set(bool) {
            if (self.__hideNextMonthArrow !== bool) {
              toggleClass(self.nextMonthNav, "disabled", bool);
              self.__hideNextMonthArrow = bool;
            }
          }
        });
        self.currentYearElement = self.yearElements[0];
        updateNavigationCurrentMonth();
        return self.monthNav;
      }

      function buildTime() {
        self.calendarContainer.classList.add("hasTime");
        if (self.config.noCalendar) self.calendarContainer.classList.add("noCalendar");
        self.timeContainer = createElement("div", "flatpickr-time");
        self.timeContainer.tabIndex = -1;
        var separator = createElement("span", "flatpickr-time-separator", ":");
        var hourInput = createNumberInput("flatpickr-hour");
        self.hourElement = hourInput.childNodes[0];
        var minuteInput = createNumberInput("flatpickr-minute");
        self.minuteElement = minuteInput.childNodes[0];
        self.hourElement.tabIndex = self.minuteElement.tabIndex = -1;
        self.hourElement.value = pad(self.latestSelectedDateObj ? self.latestSelectedDateObj.getHours() : self.config.time_24hr ? self.config.defaultHour : military2ampm(self.config.defaultHour));
        self.minuteElement.value = pad(self.latestSelectedDateObj ? self.latestSelectedDateObj.getMinutes() : self.config.defaultMinute);
        self.hourElement.setAttribute("data-step", self.config.hourIncrement.toString());
        self.minuteElement.setAttribute("data-step", self.config.minuteIncrement.toString());
        self.hourElement.setAttribute("data-min", self.config.time_24hr ? "0" : "1");
        self.hourElement.setAttribute("data-max", self.config.time_24hr ? "23" : "12");
        self.minuteElement.setAttribute("data-min", "0");
        self.minuteElement.setAttribute("data-max", "59");
        self.timeContainer.appendChild(hourInput);
        self.timeContainer.appendChild(separator);
        self.timeContainer.appendChild(minuteInput);
        if (self.config.time_24hr) self.timeContainer.classList.add("time24hr");

        if (self.config.enableSeconds) {
          self.timeContainer.classList.add("hasSeconds");
          var secondInput = createNumberInput("flatpickr-second");
          self.secondElement = secondInput.childNodes[0];
          self.secondElement.value = pad(self.latestSelectedDateObj ? self.latestSelectedDateObj.getSeconds() : self.config.defaultSeconds);
          self.secondElement.setAttribute("data-step", self.minuteElement.getAttribute("data-step"));
          self.secondElement.setAttribute("data-min", self.minuteElement.getAttribute("data-min"));
          self.secondElement.setAttribute("data-max", self.minuteElement.getAttribute("data-max"));
          self.timeContainer.appendChild(createElement("span", "flatpickr-time-separator", ":"));
          self.timeContainer.appendChild(secondInput);
        }

        if (!self.config.time_24hr) {
          self.amPM = createElement("span", "flatpickr-am-pm", self.l10n.amPM[int((self.latestSelectedDateObj ? self.hourElement.value : self.config.defaultHour) > 11)]);
          self.amPM.title = self.l10n.toggleTitle;
          self.amPM.tabIndex = -1;
          self.timeContainer.appendChild(self.amPM);
        }

        return self.timeContainer;
      }

      function buildWeekdays() {
        if (!self.weekdayContainer) self.weekdayContainer = createElement("div", "flatpickr-weekdays");else clearNode(self.weekdayContainer);

        for (var i = self.config.showMonths; i--;) {
          var container = createElement("div", "flatpickr-weekdaycontainer");
          self.weekdayContainer.appendChild(container);
        }

        updateWeekdays();
        return self.weekdayContainer;
      }

      function updateWeekdays() {
        var firstDayOfWeek = self.l10n.firstDayOfWeek;
        var weekdays = self.l10n.weekdays.shorthand.concat();

        if (firstDayOfWeek > 0 && firstDayOfWeek < weekdays.length) {
          weekdays = weekdays.splice(firstDayOfWeek, weekdays.length).concat(weekdays.splice(0, firstDayOfWeek));
        }

        for (var i = self.config.showMonths; i--;) {
          self.weekdayContainer.children[i].innerHTML = "\n      <span class=flatpickr-weekday>\n        " + weekdays.join("</span><span class=flatpickr-weekday>") + "\n      </span>\n      ";
        }
      }

      function buildWeeks() {
        self.calendarContainer.classList.add("hasWeeks");
        var weekWrapper = createElement("div", "flatpickr-weekwrapper");
        weekWrapper.appendChild(createElement("span", "flatpickr-weekday", self.l10n.weekAbbreviation));
        var weekNumbers = createElement("div", "flatpickr-weeks");
        weekWrapper.appendChild(weekNumbers);
        return {
          weekWrapper: weekWrapper,
          weekNumbers: weekNumbers
        };
      }

      function changeMonth(value, is_offset) {
        if (is_offset === void 0) {
          is_offset = true;
        }

        var delta = is_offset ? value : value - self.currentMonth;
        if (delta < 0 && self._hidePrevMonthArrow === true || delta > 0 && self._hideNextMonthArrow === true) return;
        self.currentMonth += delta;

        if (self.currentMonth < 0 || self.currentMonth > 11) {
          self.currentYear += self.currentMonth > 11 ? 1 : -1;
          self.currentMonth = (self.currentMonth + 12) % 12;
          triggerEvent("onYearChange");
        }

        buildDays();
        triggerEvent("onMonthChange");
        updateNavigationCurrentMonth();
      }

      function clear(triggerChangeEvent) {
        if (triggerChangeEvent === void 0) {
          triggerChangeEvent = true;
        }

        self.input.value = "";
        if (self.altInput !== undefined) self.altInput.value = "";
        if (self.mobileInput !== undefined) self.mobileInput.value = "";
        self.selectedDates = [];
        self.latestSelectedDateObj = undefined;
        self.showTimeInput = false;

        if (self.config.enableTime === true) {
          setDefaultHours();
        }

        self.redraw();
        if (triggerChangeEvent) triggerEvent("onChange");
      }

      function close() {
        self.isOpen = false;

        if (!self.isMobile) {
          self.calendarContainer.classList.remove("open");

          self._input.classList.remove("active");
        }

        triggerEvent("onClose");
      }

      function destroy() {
        if (self.config !== undefined) triggerEvent("onDestroy");

        for (var i = self._handlers.length; i--;) {
          var h = self._handlers[i];
          h.element.removeEventListener(h.event, h.handler, h.options);
        }

        self._handlers = [];

        if (self.mobileInput) {
          if (self.mobileInput.parentNode) self.mobileInput.parentNode.removeChild(self.mobileInput);
          self.mobileInput = undefined;
        } else if (self.calendarContainer && self.calendarContainer.parentNode) {
          if (self.config.static && self.calendarContainer.parentNode) {
            var wrapper = self.calendarContainer.parentNode;
            wrapper.lastChild && wrapper.removeChild(wrapper.lastChild);

            while (wrapper.firstChild) {
              wrapper.parentNode.insertBefore(wrapper.firstChild, wrapper);
            }

            wrapper.parentNode.removeChild(wrapper);
          } else self.calendarContainer.parentNode.removeChild(self.calendarContainer);
        }

        if (self.altInput) {
          self.input.type = "text";
          if (self.altInput.parentNode) self.altInput.parentNode.removeChild(self.altInput);
          delete self.altInput;
        }

        if (self.input) {
          self.input.type = self.input._type;
          self.input.classList.remove("flatpickr-input");
          self.input.removeAttribute("readonly");
          self.input.value = "";
        }

        ["_showTimeInput", "latestSelectedDateObj", "_hideNextMonthArrow", "_hidePrevMonthArrow", "__hideNextMonthArrow", "__hidePrevMonthArrow", "isMobile", "isOpen", "selectedDateElem", "minDateHasTime", "maxDateHasTime", "days", "daysContainer", "_input", "_positionElement", "innerContainer", "rContainer", "monthNav", "todayDateElem", "calendarContainer", "weekdayContainer", "prevMonthNav", "nextMonthNav", "currentMonthElement", "currentYearElement", "navigationCurrentMonth", "selectedDateElem", "config"].forEach(function (k) {
          try {
            delete self[k];
          } catch (_) {}
        });
      }

      function isCalendarElem(elem) {
        if (self.config.appendTo && self.config.appendTo.contains(elem)) return true;
        return self.calendarContainer.contains(elem);
      }

      function documentClick(e) {
        if (self.isOpen && !self.config.inline) {
          var isCalendarElement = isCalendarElem(e.target);
          var isInput = e.target === self.input || e.target === self.altInput || self.element.contains(e.target) || e.path && e.path.indexOf && (~e.path.indexOf(self.input) || ~e.path.indexOf(self.altInput));
          var lostFocus = e.type === "blur" ? isInput && e.relatedTarget && !isCalendarElem(e.relatedTarget) : !isInput && !isCalendarElement;
          var isIgnored = !self.config.ignoredFocusElements.some(function (elem) {
            return elem.contains(e.target);
          });

          if (lostFocus && isIgnored) {
            self.close();

            if (self.config.mode === "range" && self.selectedDates.length === 1) {
              self.clear(false);
              self.redraw();
            }
          }
        }
      }

      function changeYear(newYear) {
        if (!newYear || self.config.minDate && newYear < self.config.minDate.getFullYear() || self.config.maxDate && newYear > self.config.maxDate.getFullYear()) return;
        var newYearNum = newYear,
            isNewYear = self.currentYear !== newYearNum;
        self.currentYear = newYearNum || self.currentYear;

        if (self.config.maxDate && self.currentYear === self.config.maxDate.getFullYear()) {
          self.currentMonth = Math.min(self.config.maxDate.getMonth(), self.currentMonth);
        } else if (self.config.minDate && self.currentYear === self.config.minDate.getFullYear()) {
          self.currentMonth = Math.max(self.config.minDate.getMonth(), self.currentMonth);
        }

        if (isNewYear) {
          self.redraw();
          triggerEvent("onYearChange");
        }
      }

      function isEnabled(date, timeless) {
        if (timeless === void 0) {
          timeless = true;
        }

        var dateToCheck = self.parseDate(date, undefined, timeless);
        if (self.config.minDate && dateToCheck && compareDates(dateToCheck, self.config.minDate, timeless !== undefined ? timeless : !self.minDateHasTime) < 0 || self.config.maxDate && dateToCheck && compareDates(dateToCheck, self.config.maxDate, timeless !== undefined ? timeless : !self.maxDateHasTime) > 0) return false;
        if (self.config.enable.length === 0 && self.config.disable.length === 0) return true;
        if (dateToCheck === undefined) return false;
        var bool = self.config.enable.length > 0,
            array = bool ? self.config.enable : self.config.disable;

        for (var i = 0, d; i < array.length; i++) {
          d = array[i];
          if (typeof d === "function" && d(dateToCheck)) return bool;else if (d instanceof Date && dateToCheck !== undefined && d.getTime() === dateToCheck.getTime()) return bool;else if (typeof d === "string" && dateToCheck !== undefined) {
            var parsed = self.parseDate(d, undefined, true);
            return parsed && parsed.getTime() === dateToCheck.getTime() ? bool : !bool;
          } else if (typeof d === "object" && dateToCheck !== undefined && d.from && d.to && dateToCheck.getTime() >= d.from.getTime() && dateToCheck.getTime() <= d.to.getTime()) return bool;
        }

        return !bool;
      }

      function isInView(elem) {
        if (self.daysContainer !== undefined) return elem.className.indexOf("hidden") === -1 && self.daysContainer.contains(elem);
        return false;
      }

      function onKeyDown(e) {
        var isInput = e.target === self._input;
        var allowInput = self.config.allowInput;
        var allowKeydown = self.isOpen && (!allowInput || !isInput);
        var allowInlineKeydown = self.config.inline && isInput && !allowInput;

        if (e.keyCode === 13 && isInput) {
          if (allowInput) {
            self.setDate(self._input.value, true, e.target === self.altInput ? self.config.altFormat : self.config.dateFormat);
            return e.target.blur();
          } else self.open();
        } else if (isCalendarElem(e.target) || allowKeydown || allowInlineKeydown) {
          var isTimeObj = !!self.timeContainer && self.timeContainer.contains(e.target);

          switch (e.keyCode) {
            case 13:
              if (isTimeObj) updateTime();else selectDate(e);
              break;

            case 27:
              e.preventDefault();
              focusAndClose();
              break;

            case 8:
            case 46:
              if (isInput && !self.config.allowInput) {
                e.preventDefault();
                self.clear();
              }

              break;

            case 37:
            case 39:
              if (!isTimeObj) {
                e.preventDefault();

                if (self.daysContainer !== undefined && (allowInput === false || isInView(document.activeElement))) {
                  var _delta = e.keyCode === 39 ? 1 : -1;

                  if (!e.ctrlKey) focusOnDay(undefined, _delta);else {
                    changeMonth(_delta);
                    focusOnDay(getFirstAvailableDay(1), 0);
                  }
                }
              } else if (self.hourElement) self.hourElement.focus();

              break;

            case 38:
            case 40:
              e.preventDefault();
              var delta = e.keyCode === 40 ? 1 : -1;

              if (self.daysContainer) {
                if (e.ctrlKey) {
                  changeYear(self.currentYear - delta);
                  focusOnDay(getFirstAvailableDay(1), 0);
                } else if (!isTimeObj) focusOnDay(undefined, delta * 7);
              } else if (self.config.enableTime) {
                if (!isTimeObj && self.hourElement) self.hourElement.focus();
                updateTime(e);

                self._debouncedChange();
              }

              break;

            case 9:
              if (!isTimeObj) break;
              var elems = [self.hourElement, self.minuteElement, self.secondElement, self.amPM].filter(function (x) {
                return x;
              });
              var i = elems.indexOf(e.target);

              if (i !== -1) {
                var target = elems[i + (e.shiftKey ? -1 : 1)];

                if (target !== undefined) {
                  e.preventDefault();
                  target.focus();
                }
              }

              break;

            default:
              break;
          }
        }

        if (self.amPM !== undefined && e.target === self.amPM) {
          switch (e.key) {
            case self.l10n.amPM[0].charAt(0):
            case self.l10n.amPM[0].charAt(0).toLowerCase():
              self.amPM.textContent = self.l10n.amPM[0];
              setHoursFromInputs();
              updateValue();
              break;

            case self.l10n.amPM[1].charAt(0):
            case self.l10n.amPM[1].charAt(0).toLowerCase():
              self.amPM.textContent = self.l10n.amPM[1];
              setHoursFromInputs();
              updateValue();
              break;
          }
        }

        triggerEvent("onKeyDown", e);
      }

      function onMouseOver(elem) {
        if (self.selectedDates.length !== 1 || elem && (!elem.classList.contains("flatpickr-day") || elem.classList.contains("disabled"))) return;
        var hoverDate = elem ? elem.dateObj.getTime() : self.days.firstElementChild.dateObj.getTime(),
            initialDate = self.parseDate(self.selectedDates[0], undefined, true).getTime(),
            rangeStartDate = Math.min(hoverDate, self.selectedDates[0].getTime()),
            rangeEndDate = Math.max(hoverDate, self.selectedDates[0].getTime()),
            lastDate = self.daysContainer.lastChild.lastChild.dateObj.getTime();
        var containsDisabled = false;
        var minRange = 0,
            maxRange = 0;

        for (var t = rangeStartDate; t < lastDate; t += duration.DAY) {
          if (!isEnabled(new Date(t), true)) {
            containsDisabled = containsDisabled || t > rangeStartDate && t < rangeEndDate;
            if (t < initialDate && (!minRange || t > minRange)) minRange = t;else if (t > initialDate && (!maxRange || t < maxRange)) maxRange = t;
          }
        }

        for (var m = 0; m < self.config.showMonths; m++) {
          var month = self.daysContainer.children[m];
          var prevMonth = self.daysContainer.children[m - 1];

          var _loop = function _loop(i, l) {
            var dayElem = month.children[i],
                date = dayElem.dateObj;
            var timestamp = date.getTime();
            var outOfRange = minRange > 0 && timestamp < minRange || maxRange > 0 && timestamp > maxRange;

            if (outOfRange) {
              dayElem.classList.add("notAllowed");
              ["inRange", "startRange", "endRange"].forEach(function (c) {
                dayElem.classList.remove(c);
              });
              return "continue";
            } else if (containsDisabled && !outOfRange) return "continue";

            ["startRange", "inRange", "endRange", "notAllowed"].forEach(function (c) {
              dayElem.classList.remove(c);
            });

            if (elem !== undefined) {
              elem.classList.add(hoverDate < self.selectedDates[0].getTime() ? "startRange" : "endRange");

              if (month.contains(elem) || !(m > 0 && prevMonth && prevMonth.lastChild.dateObj.getTime() >= timestamp)) {
                if (initialDate < hoverDate && timestamp === initialDate) dayElem.classList.add("startRange");else if (initialDate > hoverDate && timestamp === initialDate) dayElem.classList.add("endRange");
                if (timestamp >= minRange && (maxRange === 0 || timestamp <= maxRange) && isBetween(timestamp, initialDate, hoverDate)) dayElem.classList.add("inRange");
              }
            }
          };

          for (var i = 0, l = month.children.length; i < l; i++) {
            var _ret = _loop(i, l);

            if (_ret === "continue") continue;
          }
        }
      }

      function onResize() {
        if (self.isOpen && !self.config.static && !self.config.inline) positionCalendar();
      }

      function open(e, positionElement) {
        if (positionElement === void 0) {
          positionElement = self._positionElement;
        }

        if (self.isMobile === true) {
          if (e) {
            e.preventDefault();
            e.target && e.target.blur();
          }

          setTimeout(function () {
            self.mobileInput !== undefined && self.mobileInput.focus();
          }, 0);
          triggerEvent("onOpen");
          return;
        }

        if (self._input.disabled || self.config.inline) return;
        var wasOpen = self.isOpen;
        self.isOpen = true;

        if (!wasOpen) {
          self.calendarContainer.classList.add("open");

          self._input.classList.add("active");

          triggerEvent("onOpen");
          positionCalendar(positionElement);
        }

        if (self.config.enableTime === true && self.config.noCalendar === true) {
          if (self.selectedDates.length === 0) {
            self.setDate(self.config.minDate !== undefined ? new Date(self.config.minDate.getTime()) : new Date(), false);
            setDefaultHours();
            updateValue();
          }

          if (self.config.allowInput === false && (e === undefined || !self.timeContainer.contains(e.relatedTarget))) {
            setTimeout(function () {
              return self.hourElement.select();
            }, 50);
          }
        }
      }

      function minMaxDateSetter(type) {
        return function (date) {
          var dateObj = self.config["_" + type + "Date"] = self.parseDate(date, self.config.dateFormat);
          var inverseDateObj = self.config["_" + (type === "min" ? "max" : "min") + "Date"];

          if (dateObj !== undefined) {
            self[type === "min" ? "minDateHasTime" : "maxDateHasTime"] = dateObj.getHours() > 0 || dateObj.getMinutes() > 0 || dateObj.getSeconds() > 0;
          }

          if (self.selectedDates) {
            self.selectedDates = self.selectedDates.filter(function (d) {
              return isEnabled(d);
            });
            if (!self.selectedDates.length && type === "min") setHoursFromDate(dateObj);
            updateValue();
          }

          if (self.daysContainer) {
            redraw();
            if (dateObj !== undefined) self.currentYearElement[type] = dateObj.getFullYear().toString();else self.currentYearElement.removeAttribute(type);
            self.currentYearElement.disabled = !!inverseDateObj && dateObj !== undefined && inverseDateObj.getFullYear() === dateObj.getFullYear();
          }
        };
      }

      function parseConfig() {
        var boolOpts = ["wrap", "weekNumbers", "allowInput", "clickOpens", "time_24hr", "enableTime", "noCalendar", "altInput", "shorthandCurrentMonth", "inline", "static", "enableSeconds", "disableMobile"];
        var hooks = ["onChange", "onClose", "onDayCreate", "onDestroy", "onKeyDown", "onMonthChange", "onOpen", "onParseConfig", "onReady", "onValueUpdate", "onYearChange", "onPreCalendarPosition"];
        var userConfig = Object.assign({}, instanceConfig, JSON.parse(JSON.stringify(element.dataset || {})));
        var formats$$1 = {};
        self.config.parseDate = userConfig.parseDate;
        self.config.formatDate = userConfig.formatDate;
        Object.defineProperty(self.config, "enable", {
          get: function get() {
            return self.config._enable;
          },
          set: function set(dates) {
            self.config._enable = parseDateRules(dates);
          }
        });
        Object.defineProperty(self.config, "disable", {
          get: function get() {
            return self.config._disable;
          },
          set: function set(dates) {
            self.config._disable = parseDateRules(dates);
          }
        });
        var timeMode = userConfig.mode === "time";

        if (!userConfig.dateFormat && (userConfig.enableTime || timeMode)) {
          formats$$1.dateFormat = userConfig.noCalendar || timeMode ? "H:i" + (userConfig.enableSeconds ? ":S" : "") : flatpickr.defaultConfig.dateFormat + " H:i" + (userConfig.enableSeconds ? ":S" : "");
        }

        if (userConfig.altInput && (userConfig.enableTime || timeMode) && !userConfig.altFormat) {
          formats$$1.altFormat = userConfig.noCalendar || timeMode ? "h:i" + (userConfig.enableSeconds ? ":S K" : " K") : flatpickr.defaultConfig.altFormat + (" h:i" + (userConfig.enableSeconds ? ":S" : "") + " K");
        }

        Object.defineProperty(self.config, "minDate", {
          get: function get() {
            return self.config._minDate;
          },
          set: minMaxDateSetter("min")
        });
        Object.defineProperty(self.config, "maxDate", {
          get: function get() {
            return self.config._maxDate;
          },
          set: minMaxDateSetter("max")
        });

        var minMaxTimeSetter = function minMaxTimeSetter(type) {
          return function (val) {
            self.config[type === "min" ? "_minTime" : "_maxTime"] = self.parseDate(val, "H:i");
          };
        };

        Object.defineProperty(self.config, "minTime", {
          get: function get() {
            return self.config._minTime;
          },
          set: minMaxTimeSetter("min")
        });
        Object.defineProperty(self.config, "maxTime", {
          get: function get() {
            return self.config._maxTime;
          },
          set: minMaxTimeSetter("max")
        });

        if (userConfig.mode === "time") {
          self.config.noCalendar = true;
          self.config.enableTime = true;
        }

        Object.assign(self.config, formats$$1, userConfig);

        for (var i = 0; i < boolOpts.length; i++) {
          self.config[boolOpts[i]] = self.config[boolOpts[i]] === true || self.config[boolOpts[i]] === "true";
        }

        for (var _i = hooks.length; _i--;) {
          if (self.config[hooks[_i]] !== undefined) {
            self.config[hooks[_i]] = arrayify(self.config[hooks[_i]] || []).map(bindToInstance);
          }
        }

        self.isMobile = !self.config.disableMobile && !self.config.inline && self.config.mode === "single" && !self.config.disable.length && !self.config.enable.length && !self.config.weekNumbers && /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

        for (var _i2 = 0; _i2 < self.config.plugins.length; _i2++) {
          var pluginConf = self.config.plugins[_i2](self) || {};

          for (var key in pluginConf) {
            if (~hooks.indexOf(key)) {
              self.config[key] = arrayify(pluginConf[key]).map(bindToInstance).concat(self.config[key]);
            } else if (typeof userConfig[key] === "undefined") self.config[key] = pluginConf[key];
          }
        }

        triggerEvent("onParseConfig");
      }

      function setupLocale() {
        if (typeof self.config.locale !== "object" && typeof flatpickr.l10ns[self.config.locale] === "undefined") self.config.errorHandler(new Error("flatpickr: invalid locale " + self.config.locale));
        self.l10n = Object.assign({}, flatpickr.l10ns.default, typeof self.config.locale === "object" ? self.config.locale : self.config.locale !== "default" ? flatpickr.l10ns[self.config.locale] : undefined);
        tokenRegex.K = "(" + self.l10n.amPM[0] + "|" + self.l10n.amPM[1] + "|" + self.l10n.amPM[0].toLowerCase() + "|" + self.l10n.amPM[1].toLowerCase() + ")";
        self.formatDate = createDateFormatter(self);
        self.parseDate = createDateParser({
          config: self.config,
          l10n: self.l10n
        });
      }

      function positionCalendar(customPositionElement) {
        if (self.calendarContainer === undefined) return;
        triggerEvent("onPreCalendarPosition");
        var positionElement = customPositionElement || self._positionElement;
        var calendarHeight = Array.prototype.reduce.call(self.calendarContainer.children, function (acc, child) {
          return acc + child.offsetHeight;
        }, 0),
            calendarWidth = self.calendarContainer.offsetWidth,
            configPos = self.config.position.split(" "),
            configPosVertical = configPos[0],
            configPosHorizontal = configPos.length > 1 ? configPos[1] : null,
            inputBounds = positionElement.getBoundingClientRect(),
            distanceFromBottom = window.innerHeight - inputBounds.bottom,
            showOnTop = configPosVertical === "above" || configPosVertical !== "below" && distanceFromBottom < calendarHeight && inputBounds.top > calendarHeight;
        var top = window.pageYOffset + inputBounds.top + (!showOnTop ? positionElement.offsetHeight + 2 : -calendarHeight - 2);
        toggleClass(self.calendarContainer, "arrowTop", !showOnTop);
        toggleClass(self.calendarContainer, "arrowBottom", showOnTop);
        if (self.config.inline) return;
        var left = window.pageXOffset + inputBounds.left - (configPosHorizontal != null && configPosHorizontal === "center" ? (calendarWidth - inputBounds.width) / 2 : 0);
        var right = window.document.body.offsetWidth - inputBounds.right;
        var rightMost = left + calendarWidth > window.document.body.offsetWidth;
        toggleClass(self.calendarContainer, "rightMost", rightMost);
        if (self.config.static) return;
        self.calendarContainer.style.top = top + "px";

        if (!rightMost) {
          self.calendarContainer.style.left = left + "px";
          self.calendarContainer.style.right = "auto";
        } else {
          self.calendarContainer.style.left = "auto";
          self.calendarContainer.style.right = right + "px";
        }
      }

      function redraw() {
        if (self.config.noCalendar || self.isMobile) return;
        updateNavigationCurrentMonth();
        buildDays();
      }

      function focusAndClose() {
        self._input.focus();

        if (window.navigator.userAgent.indexOf("MSIE") !== -1 || navigator.msMaxTouchPoints !== undefined) {
          setTimeout(self.close, 0);
        } else {
          self.close();
        }
      }

      function selectDate(e) {
        e.preventDefault();
        e.stopPropagation();

        var isSelectable = function isSelectable(day) {
          return day.classList && day.classList.contains("flatpickr-day") && !day.classList.contains("disabled") && !day.classList.contains("notAllowed");
        };

        var t = findParent(e.target, isSelectable);
        if (t === undefined) return;
        var target = t;
        var selectedDate = self.latestSelectedDateObj = new Date(target.dateObj.getTime());
        var shouldChangeMonth = (selectedDate.getMonth() < self.currentMonth || selectedDate.getMonth() > self.currentMonth + self.config.showMonths - 1) && self.config.mode !== "range";
        self.selectedDateElem = target;
        if (self.config.mode === "single") self.selectedDates = [selectedDate];else if (self.config.mode === "multiple") {
          var selectedIndex = isDateSelected(selectedDate);
          if (selectedIndex) self.selectedDates.splice(parseInt(selectedIndex), 1);else self.selectedDates.push(selectedDate);
        } else if (self.config.mode === "range") {
          if (self.selectedDates.length === 2) self.clear(false);
          self.selectedDates.push(selectedDate);
          if (compareDates(selectedDate, self.selectedDates[0], true) !== 0) self.selectedDates.sort(function (a, b) {
            return a.getTime() - b.getTime();
          });
        }
        setHoursFromInputs();

        if (shouldChangeMonth) {
          var isNewYear = self.currentYear !== selectedDate.getFullYear();
          self.currentYear = selectedDate.getFullYear();
          self.currentMonth = selectedDate.getMonth();
          if (isNewYear) triggerEvent("onYearChange");
          triggerEvent("onMonthChange");
        }

        updateNavigationCurrentMonth();
        buildDays();
        updateValue();
        if (self.config.enableTime) setTimeout(function () {
          return self.showTimeInput = true;
        }, 50);
        if (!shouldChangeMonth && self.config.mode !== "range" && self.config.showMonths === 1) focusOnDayElem(target);else self.selectedDateElem && self.selectedDateElem.focus();
        if (self.hourElement !== undefined) setTimeout(function () {
          return self.hourElement !== undefined && self.hourElement.select();
        }, 451);

        if (self.config.closeOnSelect) {
          var single = self.config.mode === "single" && !self.config.enableTime;
          var range = self.config.mode === "range" && self.selectedDates.length === 2 && !self.config.enableTime;

          if (single || range) {
            focusAndClose();
          }
        }

        triggerChange();
      }

      var CALLBACKS = {
        locale: [setupLocale, updateWeekdays],
        showMonths: [buildMonths, setCalendarWidth, buildWeekdays]
      };

      function set(option, value) {
        if (option !== null && typeof option === "object") Object.assign(self.config, option);else {
          self.config[option] = value;
          if (CALLBACKS[option] !== undefined) CALLBACKS[option].forEach(function (x) {
            return x();
          });
        }
        self.redraw();
        jumpToDate();
      }

      function setSelectedDate(inputDate, format) {
        var dates = [];
        if (inputDate instanceof Array) dates = inputDate.map(function (d) {
          return self.parseDate(d, format);
        });else if (inputDate instanceof Date || typeof inputDate === "number") dates = [self.parseDate(inputDate, format)];else if (typeof inputDate === "string") {
          switch (self.config.mode) {
            case "single":
            case "time":
              dates = [self.parseDate(inputDate, format)];
              break;

            case "multiple":
              dates = inputDate.split(self.config.conjunction).map(function (date) {
                return self.parseDate(date, format);
              });
              break;

            case "range":
              dates = inputDate.split(self.l10n.rangeSeparator).map(function (date) {
                return self.parseDate(date, format);
              });
              break;

            default:
              break;
          }
        } else self.config.errorHandler(new Error("Invalid date supplied: " + JSON.stringify(inputDate)));
        self.selectedDates = dates.filter(function (d) {
          return d instanceof Date && isEnabled(d, false);
        });
        if (self.config.mode === "range") self.selectedDates.sort(function (a, b) {
          return a.getTime() - b.getTime();
        });
      }

      function setDate(date, triggerChange, format) {
        if (triggerChange === void 0) {
          triggerChange = false;
        }

        if (format === void 0) {
          format = self.config.dateFormat;
        }

        if (date !== 0 && !date || date instanceof Array && date.length === 0) return self.clear(triggerChange);
        setSelectedDate(date, format);
        self.showTimeInput = self.selectedDates.length > 0;
        self.latestSelectedDateObj = self.selectedDates[0];
        self.redraw();
        jumpToDate();
        setHoursFromDate();
        updateValue(triggerChange);
        if (triggerChange) triggerEvent("onChange");
      }

      function parseDateRules(arr) {
        return arr.slice().map(function (rule) {
          if (typeof rule === "string" || typeof rule === "number" || rule instanceof Date) {
            return self.parseDate(rule, undefined, true);
          } else if (rule && typeof rule === "object" && rule.from && rule.to) return {
            from: self.parseDate(rule.from, undefined),
            to: self.parseDate(rule.to, undefined)
          };

          return rule;
        }).filter(function (x) {
          return x;
        });
      }

      function setupDates() {
        self.selectedDates = [];
        self.now = self.parseDate(self.config.now) || new Date();
        var preloadedDate = self.config.defaultDate || ((self.input.nodeName === "INPUT" || self.input.nodeName === "TEXTAREA") && self.input.placeholder && self.input.value === self.input.placeholder ? null : self.input.value);
        if (preloadedDate) setSelectedDate(preloadedDate, self.config.dateFormat);
        var initialDate = self.selectedDates.length > 0 ? self.selectedDates[0] : self.config.minDate && self.config.minDate.getTime() > self.now.getTime() ? self.config.minDate : self.config.maxDate && self.config.maxDate.getTime() < self.now.getTime() ? self.config.maxDate : self.now;
        self.currentYear = initialDate.getFullYear();
        self.currentMonth = initialDate.getMonth();
        if (self.selectedDates.length > 0) self.latestSelectedDateObj = self.selectedDates[0];
        if (self.config.minTime !== undefined) self.config.minTime = self.parseDate(self.config.minTime, "H:i");
        if (self.config.maxTime !== undefined) self.config.maxTime = self.parseDate(self.config.maxTime, "H:i");
        self.minDateHasTime = !!self.config.minDate && (self.config.minDate.getHours() > 0 || self.config.minDate.getMinutes() > 0 || self.config.minDate.getSeconds() > 0);
        self.maxDateHasTime = !!self.config.maxDate && (self.config.maxDate.getHours() > 0 || self.config.maxDate.getMinutes() > 0 || self.config.maxDate.getSeconds() > 0);
        Object.defineProperty(self, "showTimeInput", {
          get: function get() {
            return self._showTimeInput;
          },
          set: function set(bool) {
            self._showTimeInput = bool;
            if (self.calendarContainer) toggleClass(self.calendarContainer, "showTimeInput", bool);
            self.isOpen && positionCalendar();
          }
        });
      }

      function setupInputs() {
        self.input = self.config.wrap ? element.querySelector("[data-input]") : element;

        if (!self.input) {
          self.config.errorHandler(new Error("Invalid input element specified"));
          return;
        }

        self.input._type = self.input.type;
        self.input.type = "text";
        self.input.classList.add("flatpickr-input");
        self._input = self.input;

        if (self.config.altInput) {
          self.altInput = createElement(self.input.nodeName, self.input.className + " " + self.config.altInputClass);
          self._input = self.altInput;
          self.altInput.placeholder = self.input.placeholder;
          self.altInput.disabled = self.input.disabled;
          self.altInput.required = self.input.required;
          self.altInput.tabIndex = self.input.tabIndex;
          self.altInput.type = "text";
          self.input.setAttribute("type", "hidden");
          if (!self.config.static && self.input.parentNode) self.input.parentNode.insertBefore(self.altInput, self.input.nextSibling);
        }

        if (!self.config.allowInput) self._input.setAttribute("readonly", "readonly");
        self._positionElement = self.config.positionElement || self._input;
      }

      function setupMobile() {
        var inputType = self.config.enableTime ? self.config.noCalendar ? "time" : "datetime-local" : "date";
        self.mobileInput = createElement("input", self.input.className + " flatpickr-mobile");
        self.mobileInput.step = self.input.getAttribute("step") || "any";
        self.mobileInput.tabIndex = 1;
        self.mobileInput.type = inputType;
        self.mobileInput.disabled = self.input.disabled;
        self.mobileInput.required = self.input.required;
        self.mobileInput.placeholder = self.input.placeholder;
        self.mobileFormatStr = inputType === "datetime-local" ? "Y-m-d\\TH:i:S" : inputType === "date" ? "Y-m-d" : "H:i:S";

        if (self.selectedDates.length > 0) {
          self.mobileInput.defaultValue = self.mobileInput.value = self.formatDate(self.selectedDates[0], self.mobileFormatStr);
        }

        if (self.config.minDate) self.mobileInput.min = self.formatDate(self.config.minDate, "Y-m-d");
        if (self.config.maxDate) self.mobileInput.max = self.formatDate(self.config.maxDate, "Y-m-d");
        self.input.type = "hidden";
        if (self.altInput !== undefined) self.altInput.type = "hidden";

        try {
          if (self.input.parentNode) self.input.parentNode.insertBefore(self.mobileInput, self.input.nextSibling);
        } catch (_a) {}

        bind(self.mobileInput, "change", function (e) {
          self.setDate(e.target.value, false, self.mobileFormatStr);
          triggerEvent("onChange");
          triggerEvent("onClose");
        });
      }

      function toggle(e) {
        if (self.isOpen === true) return self.close();
        self.open(e);
      }

      function triggerEvent(event, data) {
        var hooks = self.config[event];

        if (hooks !== undefined && hooks.length > 0) {
          for (var i = 0; hooks[i] && i < hooks.length; i++) {
            hooks[i](self.selectedDates, self.input.value, self, data);
          }
        }

        if (event === "onChange") {
          self.input.dispatchEvent(createEvent("change"));
          self.input.dispatchEvent(createEvent("input"));
        }
      }

      function createEvent(name) {
        var e = document.createEvent("Event");
        e.initEvent(name, true, true);
        return e;
      }

      function isDateSelected(date) {
        for (var i = 0; i < self.selectedDates.length; i++) {
          if (compareDates(self.selectedDates[i], date) === 0) return "" + i;
        }

        return false;
      }

      function isDateInRange(date) {
        if (self.config.mode !== "range" || self.selectedDates.length < 2) return false;
        return compareDates(date, self.selectedDates[0]) >= 0 && compareDates(date, self.selectedDates[1]) <= 0;
      }

      function updateNavigationCurrentMonth() {
        if (self.config.noCalendar || self.isMobile || !self.monthNav) return;
        self.yearElements.forEach(function (yearElement, i) {
          var d = new Date(self.currentYear, self.currentMonth, 1);
          d.setMonth(self.currentMonth + i);
          self.monthElements[i].textContent = monthToStr(d.getMonth(), self.config.shorthandCurrentMonth, self.l10n) + " ";
          yearElement.value = d.getFullYear().toString();
        });
        self._hidePrevMonthArrow = self.config.minDate !== undefined && (self.currentYear === self.config.minDate.getFullYear() ? self.currentMonth <= self.config.minDate.getMonth() : self.currentYear < self.config.minDate.getFullYear());
        self._hideNextMonthArrow = self.config.maxDate !== undefined && (self.currentYear === self.config.maxDate.getFullYear() ? self.currentMonth + 1 > self.config.maxDate.getMonth() : self.currentYear > self.config.maxDate.getFullYear());
      }

      function updateValue(triggerChange) {
        if (triggerChange === void 0) {
          triggerChange = true;
        }

        if (self.selectedDates.length === 0) return self.clear(triggerChange);

        if (self.mobileInput !== undefined && self.mobileFormatStr) {
          self.mobileInput.value = self.latestSelectedDateObj !== undefined ? self.formatDate(self.latestSelectedDateObj, self.mobileFormatStr) : "";
        }

        var joinChar = self.config.mode !== "range" ? self.config.conjunction : self.l10n.rangeSeparator;
        self.input.value = self.selectedDates.map(function (dObj) {
          return self.formatDate(dObj, self.config.dateFormat);
        }).join(joinChar);

        if (self.altInput !== undefined) {
          self.altInput.value = self.selectedDates.map(function (dObj) {
            return self.formatDate(dObj, self.config.altFormat);
          }).join(joinChar);
        }

        if (triggerChange !== false) triggerEvent("onValueUpdate");
      }

      function onMonthNavClick(e) {
        e.preventDefault();
        var isPrevMonth = self.prevMonthNav.contains(e.target);
        var isNextMonth = self.nextMonthNav.contains(e.target);

        if (isPrevMonth || isNextMonth) {
          changeMonth(isPrevMonth ? -1 : 1);
        } else if (self.yearElements.indexOf(e.target) >= 0) {
          e.target.select();
        } else if (e.target.classList.contains("arrowUp")) {
          self.changeYear(self.currentYear + 1);
        } else if (e.target.classList.contains("arrowDown")) {
          self.changeYear(self.currentYear - 1);
        }
      }

      function timeWrapper(e) {
        e.preventDefault();
        var isKeyDown = e.type === "keydown",
            input = e.target;

        if (self.amPM !== undefined && e.target === self.amPM) {
          self.amPM.textContent = self.l10n.amPM[int(self.amPM.textContent === self.l10n.amPM[0])];
        }

        var min = parseFloat(input.getAttribute("data-min")),
            max = parseFloat(input.getAttribute("data-max")),
            step = parseFloat(input.getAttribute("data-step")),
            curValue = parseInt(input.value, 10),
            delta = e.delta || (isKeyDown ? e.which === 38 ? 1 : -1 : 0);
        var newValue = curValue + step * delta;

        if (typeof input.value !== "undefined" && input.value.length === 2) {
          var isHourElem = input === self.hourElement,
              isMinuteElem = input === self.minuteElement;

          if (newValue < min) {
            newValue = max + newValue + int(!isHourElem) + (int(isHourElem) && int(!self.amPM));
            if (isMinuteElem) incrementNumInput(undefined, -1, self.hourElement);
          } else if (newValue > max) {
            newValue = input === self.hourElement ? newValue - max - int(!self.amPM) : min;
            if (isMinuteElem) incrementNumInput(undefined, 1, self.hourElement);
          }

          if (self.amPM && isHourElem && (step === 1 ? newValue + curValue === 23 : Math.abs(newValue - curValue) > step)) {
            self.amPM.textContent = self.l10n.amPM[int(self.amPM.textContent === self.l10n.amPM[0])];
          }

          input.value = pad(newValue);
        }
      }

      init();
      return self;
    }

    function _flatpickr(nodeList, config) {
      var nodes = Array.prototype.slice.call(nodeList);
      var instances = [];

      for (var i = 0; i < nodes.length; i++) {
        var node = nodes[i];

        try {
          if (node.getAttribute("data-fp-omit") !== null) continue;

          if (node._flatpickr !== undefined) {
            node._flatpickr.destroy();

            node._flatpickr = undefined;
          }

          node._flatpickr = FlatpickrInstance(node, config || {});
          instances.push(node._flatpickr);
        } catch (e) {
          console.error(e);
        }
      }

      return instances.length === 1 ? instances[0] : instances;
    }

    if (typeof HTMLElement !== "undefined") {
      HTMLCollection.prototype.flatpickr = NodeList.prototype.flatpickr = function (config) {
        return _flatpickr(this, config);
      };

      HTMLElement.prototype.flatpickr = function (config) {
        return _flatpickr([this], config);
      };
    }

    var flatpickr = function flatpickr(selector, config) {
      if (selector instanceof NodeList) return _flatpickr(selector, config);else if (typeof selector === "string") return _flatpickr(window.document.querySelectorAll(selector), config);
      return _flatpickr([selector], config);
    };

    flatpickr.defaultConfig = defaults;
    flatpickr.l10ns = {
      en: Object.assign({}, english),
      default: Object.assign({}, english)
    };

    flatpickr.localize = function (l10n) {
      flatpickr.l10ns.default = Object.assign({}, flatpickr.l10ns.default, l10n);
    };

    flatpickr.setDefaults = function (config) {
      flatpickr.defaultConfig = Object.assign({}, flatpickr.defaultConfig, config);
    };

    flatpickr.parseDate = createDateParser({});
    flatpickr.formatDate = createDateFormatter({});
    flatpickr.compareDates = compareDates;

    if (typeof jQuery !== "undefined") {
      jQuery.fn.flatpickr = function (config) {
        return _flatpickr(this, config);
      };
    }

    Date.prototype.fp_incr = function (days) {
      return new Date(this.getFullYear(), this.getMonth(), this.getDate() + (typeof days === "string" ? parseInt(days, 10) : days));
    };

    if (typeof window !== "undefined") {
      window.flatpickr = flatpickr;
    }

    return flatpickr;

})));

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ }),

/***/ 73:
/***/ (function(module, exports, __webpack_require__) {

/* flatpickr v4.5.1, @license MIT */
(function (global, factory) {
     true ? module.exports = factory() :
    typeof define === 'function' && define.amd ? define(factory) :
    (global.rangePlugin = factory());
}(this, (function () { 'use strict';

    function rangePlugin(config) {
      if (config === void 0) {
        config = {};
      }

      return function (fp) {
        var dateFormat = "",
            secondInput,
            _secondInputFocused,
            _prevDates;

        var createSecondInput = function createSecondInput() {
          if (config.input) {
            secondInput = config.input instanceof Element ? config.input : window.document.querySelector(config.input);
          } else {
            secondInput = fp._input.cloneNode();
            secondInput.removeAttribute("id");
            secondInput._flatpickr = undefined;
          }

          if (secondInput.value) {
            var parsedDate = fp.parseDate(secondInput.value);
            if (parsedDate) fp.selectedDates.push(parsedDate);
          }

          secondInput.setAttribute("data-fp-omit", "");

          fp._bind(secondInput, ["focus", "click"], function () {
            if (fp.selectedDates[1]) {
              fp.latestSelectedDateObj = fp.selectedDates[1];

              fp._setHoursFromDate(fp.selectedDates[1]);

              fp.jumpToDate(fp.selectedDates[1]);
            }
            _secondInputFocused = true;
            fp.isOpen = false;
            fp.open(undefined, secondInput);
          });

          fp._bind(fp._input, ["focus", "click"], function (e) {
            e.preventDefault();
            fp.isOpen = false;
            fp.open();
          });

          if (fp.config.allowInput) fp._bind(secondInput, "keydown", function (e) {
            if (e.key === "Enter") {
              fp.setDate([fp.selectedDates[0], secondInput.value], true, dateFormat);
              secondInput.click();
            }
          });
          if (!config.input) fp._input.parentNode && fp._input.parentNode.insertBefore(secondInput, fp._input.nextSibling);
        };

        var plugin = {
          onParseConfig: function onParseConfig() {
            fp.config.mode = "range";
            dateFormat = fp.config.altInput ? fp.config.altFormat : fp.config.dateFormat;
          },
          onReady: function onReady() {
            createSecondInput();
            fp.config.ignoredFocusElements.push(secondInput);

            if (fp.config.allowInput) {
              fp._input.removeAttribute("readonly");

              secondInput.removeAttribute("readonly");
            } else {
              secondInput.setAttribute("readonly", "readonly");
            }

            fp._bind(fp._input, "focus", function () {
              fp.latestSelectedDateObj = fp.selectedDates[0];

              fp._setHoursFromDate(fp.selectedDates[0]);
              _secondInputFocused = false;
              fp.jumpToDate(fp.selectedDates[0]);
            });

            if (fp.config.allowInput) fp._bind(fp._input, "keydown", function (e) {
              if (e.key === "Enter") fp.setDate([fp._input.value, fp.selectedDates[1]], true, dateFormat);
            });
            fp.setDate(fp.selectedDates, false);
            plugin.onValueUpdate(fp.selectedDates);
          },
          onPreCalendarPosition: function onPreCalendarPosition() {
            if (_secondInputFocused) {
              fp._positionElement = secondInput;
              setTimeout(function () {
                fp._positionElement = fp._input;
              }, 0);
            }
          },
          onChange: function onChange() {
            if (!fp.selectedDates.length) {
              setTimeout(function () {
                if (fp.selectedDates.length) return;
                secondInput.value = "";
                _prevDates = [];
              }, 10);
            }

            if (_secondInputFocused) {
              setTimeout(function () {
                secondInput.focus();
              }, 0);
            }
          },
          onDestroy: function onDestroy() {
            if (!config.input) secondInput.parentNode && secondInput.parentNode.removeChild(secondInput);
          },
          onValueUpdate: function onValueUpdate(selDates) {
            if (!secondInput) return;
            _prevDates = !_prevDates || selDates.length >= _prevDates.length ? selDates.concat() : _prevDates;

            if (_prevDates.length > selDates.length) {
              var newSelectedDate = selDates[0];
              var newDates = _secondInputFocused ? [_prevDates[0], newSelectedDate] : [newSelectedDate, _prevDates[1]];
              fp.setDate(newDates, false);
              _prevDates = newDates.concat();
            }

            var _fp$selectedDates$map = fp.selectedDates.map(function (d) {
              return fp.formatDate(d, dateFormat);
            });

            var _fp$selectedDates$map2 = _fp$selectedDates$map[0];
            fp._input.value = _fp$selectedDates$map2 === void 0 ? "" : _fp$selectedDates$map2;
            var _fp$selectedDates$map3 = _fp$selectedDates$map[1];
            secondInput.value = _fp$selectedDates$map3 === void 0 ? "" : _fp$selectedDates$map3;
          }
        };
        return plugin;
      };
    }

    return rangePlugin;

})));


/***/ }),

/***/ 74:
/***/ (function(module, exports, __webpack_require__) {

/* flatpickr v4.5.1, @license MIT */
(function (global, factory) {
     true ? factory(exports) :
    typeof define === 'function' && define.amd ? define(['exports'], factory) :
    (factory((global.index = {})));
}(this, (function (exports) { 'use strict';

    var fp = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Arabic = {
      weekdays: {
        shorthand: ["أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت"],
        longhand: ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"]
      },
      months: {
        shorthand: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
        longhand: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"]
      }
    };
    fp.l10ns.ar = Arabic;
    fp.l10ns;

    var fp$1 = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Austria = {
      weekdays: {
        shorthand: ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"],
        longhand: ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"]
      },
      months: {
        shorthand: ["Jän", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"],
        longhand: ["Jänner", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"]
      },
      firstDayOfWeek: 1,
      weekAbbreviation: "KW",
      rangeSeparator: " bis ",
      scrollTitle: "Zum Ändern scrollen",
      toggleTitle: "Zum Umschalten klicken"
    };
    fp$1.l10ns.at = Austria;
    fp$1.l10ns;

    var fp$2 = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Belarusian = {
      weekdays: {
        shorthand: ["Нд", "Пн", "Аў", "Ср", "Чц", "Пт", "Сб"],
        longhand: ["Нядзеля", "Панядзелак", "Аўторак", "Серада", "Чацвер", "Пятніца", "Субота"]
      },
      months: {
        shorthand: ["Сту", "Лют", "Сак", "Кра", "Тра", "Чэр", "Ліп", "Жні", "Вер", "Кас", "Ліс", "Сне"],
        longhand: ["Студзень", "Люты", "Сакавік", "Красавік", "Травень", "Чэрвень", "Ліпень", "Жнівень", "Верасень", "Кастрычнік", "Лістапад", "Снежань"]
      },
      firstDayOfWeek: 1,
      ordinal: function ordinal() {
        return "";
      },
      rangeSeparator: " — ",
      weekAbbreviation: "Тыд.",
      scrollTitle: "Пракруціце для павелічэння",
      toggleTitle: "Націсніце для пераключэння",
      amPM: ["ДП", "ПП"],
      yearAriaLabel: "Год"
    };
    fp$2.l10ns.be = Belarusian;
    fp$2.l10ns;

    var fp$3 = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Bulgarian = {
      weekdays: {
        shorthand: ["Нд", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
        longhand: ["Неделя", "Понеделник", "Вторник", "Сряда", "Четвъртък", "Петък", "Събота"]
      },
      months: {
        shorthand: ["Яну", "Фев", "Март", "Апр", "Май", "Юни", "Юли", "Авг", "Сеп", "Окт", "Ное", "Дек"],
        longhand: ["Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември"]
      }
    };
    fp$3.l10ns.bg = Bulgarian;
    fp$3.l10ns;

    var fp$4 = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Bangla = {
      weekdays: {
        shorthand: ["রবি", "সোম", "মঙ্গল", "বুধ", "বৃহস্পতি", "শুক্র", "শনি"],
        longhand: ["রবিবার", "সোমবার", "মঙ্গলবার", "বুধবার", "বৃহস্পতিবার", "শুক্রবার", "শনিবার"]
      },
      months: {
        shorthand: ["জানু", "ফেব্রু", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগ", "সেপ্টে", "অক্টো", "নভে", "ডিসে"],
        longhand: ["জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর"]
      }
    };
    fp$4.l10ns.bn = Bangla;
    fp$4.l10ns;

    var fp$5 = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Catalan = {
      weekdays: {
        shorthand: ["Dg", "Dl", "Dt", "Dc", "Dj", "Dv", "Ds"],
        longhand: ["Diumenge", "Dilluns", "Dimarts", "Dimecres", "Dijous", "Divendres", "Dissabte"]
      },
      months: {
        shorthand: ["Gen", "Febr", "Març", "Abr", "Maig", "Juny", "Jul", "Ag", "Set", "Oct", "Nov", "Des"],
        longhand: ["Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre"]
      },
      ordinal: function ordinal(nth) {
        var s = nth % 100;
        if (s > 3 && s < 21) return "è";

        switch (s % 10) {
          case 1:
            return "r";

          case 2:
            return "n";

          case 3:
            return "r";

          case 4:
            return "t";

          default:
            return "è";
        }
      },
      firstDayOfWeek: 1
    };
    fp$5.l10ns.cat = Catalan;
    fp$5.l10ns;

    var fp$6 = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Czech = {
      weekdays: {
        shorthand: ["Ne", "Po", "Út", "St", "Čt", "Pá", "So"],
        longhand: ["Neděle", "Pondělí", "Úterý", "Středa", "Čtvrtek", "Pátek", "Sobota"]
      },
      months: {
        shorthand: ["Led", "Ún", "Bře", "Dub", "Kvě", "Čer", "Čvc", "Srp", "Zář", "Říj", "Lis", "Pro"],
        longhand: ["Leden", "Únor", "Březen", "Duben", "Květen", "Červen", "Červenec", "Srpen", "Září", "Říjen", "Listopad", "Prosinec"]
      },
      firstDayOfWeek: 1,
      ordinal: function ordinal() {
        return ".";
      },
      rangeSeparator: " do ",
      weekAbbreviation: "Týd.",
      scrollTitle: "Rolujte pro změnu",
      toggleTitle: "Přepnout dopoledne/odpoledne",
      amPM: ["dop.", "odp."],
      yearAriaLabel: "Rok"
    };
    fp$6.l10ns.cs = Czech;
    fp$6.l10ns;

    var fp$7 = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Welsh = {
      weekdays: {
        shorthand: ["Sul", "Llun", "Maw", "Mer", "Iau", "Gwe", "Sad"],
        longhand: ["Dydd Sul", "Dydd Llun", "Dydd Mawrth", "Dydd Mercher", "Dydd Iau", "Dydd Gwener", "Dydd Sadwrn"]
      },
      months: {
        shorthand: ["Ion", "Chwef", "Maw", "Ebr", "Mai", "Meh", "Gorff", "Awst", "Medi", "Hyd", "Tach", "Rhag"],
        longhand: ["Ionawr", "Chwefror", "Mawrth", "Ebrill", "Mai", "Mehefin", "Gorffennaf", "Awst", "Medi", "Hydref", "Tachwedd", "Rhagfyr"]
      },
      firstDayOfWeek: 1,
      ordinal: function ordinal(nth) {
        if (nth === 1) return "af";
        if (nth === 2) return "ail";
        if (nth === 3 || nth === 4) return "ydd";
        if (nth === 5 || nth === 6) return "ed";
        if (nth >= 7 && nth <= 10 || nth == 12 || nth == 15 || nth == 18 || nth == 20) return "fed";
        if (nth == 11 || nth == 13 || nth == 14 || nth == 16 || nth == 17 || nth == 19) return "eg";
        if (nth >= 21 && nth <= 39) return "ain";
        return "";
      }
    };
    fp$7.l10ns.cy = Welsh;
    fp$7.l10ns;

    var fp$8 = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Danish = {
      weekdays: {
        shorthand: ["søn", "man", "tir", "ons", "tors", "fre", "lør"],
        longhand: ["søndag", "mandag", "tirsdag", "onsdag", "torsdag", "fredag", "lørdag"]
      },
      months: {
        shorthand: ["jan", "feb", "mar", "apr", "maj", "jun", "jul", "aug", "sep", "okt", "nov", "dec"],
        longhand: ["januar", "februar", "marts", "april", "maj", "juni", "juli", "august", "september", "oktober", "november", "december"]
      },
      ordinal: function ordinal() {
        return ".";
      },
      firstDayOfWeek: 1,
      rangeSeparator: " til ",
      weekAbbreviation: "uge"
    };
    fp$8.l10ns.da = Danish;
    fp$8.l10ns;

    var fp$9 = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var German = {
      weekdays: {
        shorthand: ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"],
        longhand: ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"]
      },
      months: {
        shorthand: ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"],
        longhand: ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"]
      },
      firstDayOfWeek: 1,
      weekAbbreviation: "KW",
      rangeSeparator: " bis ",
      scrollTitle: "Zum Ändern scrollen",
      toggleTitle: "Zum Umschalten klicken"
    };
    fp$9.l10ns.de = German;
    fp$9.l10ns;

    var english = {
      weekdays: {
        shorthand: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        longhand: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
      },
      months: {
        shorthand: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        longhand: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
      },
      daysInMonth: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
      firstDayOfWeek: 0,
      ordinal: function ordinal(nth) {
        var s = nth % 100;
        if (s > 3 && s < 21) return "th";

        switch (s % 10) {
          case 1:
            return "st";

          case 2:
            return "nd";

          case 3:
            return "rd";

          default:
            return "th";
        }
      },
      rangeSeparator: " to ",
      weekAbbreviation: "Wk",
      scrollTitle: "Scroll to increment",
      toggleTitle: "Click to toggle",
      amPM: ["AM", "PM"],
      yearAriaLabel: "Year"
    };

    var fp$a = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Esperanto = {
      firstDayOfWeek: 1,
      rangeSeparator: " ĝis ",
      weekAbbreviation: "Sem",
      scrollTitle: "Rulumu por pligrandigi la valoron",
      toggleTitle: "Klaku por ŝalti",
      weekdays: {
        shorthand: ["Dim", "Lun", "Mar", "Mer", "Ĵaŭ", "Ven", "Sab"],
        longhand: ["dimanĉo", "lundo", "mardo", "merkredo", "ĵaŭdo", "vendredo", "sabato"]
      },
      months: {
        shorthand: ["Jan", "Feb", "Mar", "Apr", "Maj", "Jun", "Jul", "Aŭg", "Sep", "Okt", "Nov", "Dec"],
        longhand: ["januaro", "februaro", "marto", "aprilo", "majo", "junio", "julio", "aŭgusto", "septembro", "oktobro", "novembro", "decembro"]
      },
      ordinal: function ordinal() {
        return "-a";
      }
    };
    fp$a.l10ns.eo = Esperanto;
    fp$a.l10ns;

    var fp$b = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Spanish = {
      weekdays: {
        shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
        longhand: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"]
      },
      months: {
        shorthand: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        longhand: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
      },
      ordinal: function ordinal() {
        return "º";
      },
      firstDayOfWeek: 1,
      rangeSeparator: " a "
    };
    fp$b.l10ns.es = Spanish;
    fp$b.l10ns;

    var fp$c = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Estonian = {
      weekdays: {
        shorthand: ["P", "E", "T", "K", "N", "R", "L"],
        longhand: ["Pühapäev", "Esmaspäev", "Teisipäev", "Kolmapäev", "Neljapäev", "Reede", "Laupäev"]
      },
      months: {
        shorthand: ["Jaan", "Veebr", "Märts", "Apr", "Mai", "Juuni", "Juuli", "Aug", "Sept", "Okt", "Nov", "Dets"],
        longhand: ["Jaanuar", "Veebruar", "Märts", "Aprill", "Mai", "Juuni", "Juuli", "August", "September", "Oktoober", "November", "Detsember"]
      },
      firstDayOfWeek: 1,
      ordinal: function ordinal() {
        return ".";
      },
      weekAbbreviation: "Näd",
      rangeSeparator: " kuni ",
      scrollTitle: "Keri, et suurendada",
      toggleTitle: "Klõpsa, et vahetada"
    };
    fp$c.l10ns.et = Estonian;
    fp$c.l10ns;

    var fp$d = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Persian = {
      weekdays: {
        shorthand: ["یک", "دو", "سه", "چهار", "پنج", "جمعه", "شنبه"],
        longhand: ["یک‌شنبه", "دوشنبه", "سه‌شنبه", "چهارشنبه", "پنچ‌شنبه", "جمعه", "شنبه"]
      },
      months: {
        shorthand: ["ژانویه", "فوریه", "مارس", "آوریل", "مه", "ژوئن", "ژوئیه", "اوت", "سپتامبر", "اکتبر", "نوامبر", "دسامبر"],
        longhand: ["ژانویه", "فوریه", "مارس", "آوریل", "مه", "ژوئن", "ژوئیه", "اوت", "سپتامبر", "اکتبر", "نوامبر", "دسامبر"]
      },
      firstDayOfWeek: 6,
      ordinal: function ordinal() {
        return "";
      }
    };
    fp$d.l10ns.fa = Persian;
    fp$d.l10ns;

    var fp$e = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Finnish = {
      firstDayOfWeek: 1,
      weekdays: {
        shorthand: ["Su", "Ma", "Ti", "Ke", "To", "Pe", "La"],
        longhand: ["Sunnuntai", "Maanantai", "Tiistai", "Keskiviikko", "Torstai", "Perjantai", "Lauantai"]
      },
      months: {
        shorthand: ["Tammi", "Helmi", "Maalis", "Huhti", "Touko", "Kesä", "Heinä", "Elo", "Syys", "Loka", "Marras", "Joulu"],
        longhand: ["Tammikuu", "Helmikuu", "Maaliskuu", "Huhtikuu", "Toukokuu", "Kesäkuu", "Heinäkuu", "Elokuu", "Syyskuu", "Lokakuu", "Marraskuu", "Joulukuu"]
      },
      ordinal: function ordinal() {
        return ".";
      }
    };
    fp$e.l10ns.fi = Finnish;
    fp$e.l10ns;

    var fp$f = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var French = {
      firstDayOfWeek: 1,
      weekdays: {
        shorthand: ["dim", "lun", "mar", "mer", "jeu", "ven", "sam"],
        longhand: ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"]
      },
      months: {
        shorthand: ["janv", "févr", "mars", "avr", "mai", "juin", "juil", "août", "sept", "oct", "nov", "déc"],
        longhand: ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"]
      },
      ordinal: function ordinal(nth) {
        if (nth > 1) return "";
        return "er";
      },
      rangeSeparator: " au ",
      weekAbbreviation: "Sem",
      scrollTitle: "Défiler pour augmenter la valeur",
      toggleTitle: "Cliquer pour basculer"
    };
    fp$f.l10ns.fr = French;
    fp$f.l10ns;

    var fp$g = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Greek = {
      weekdays: {
        shorthand: ["Κυ", "Δε", "Τρ", "Τε", "Πέ", "Πα", "Σά"],
        longhand: ["Κυριακή", "Δευτέρα", "Τρίτη", "Τετάρτη", "Πέμπτη", "Παρασκευή", "Σάββατο"]
      },
      months: {
        shorthand: ["Ιαν", "Φεβ", "Μάρ", "Απρ", "Μάι", "Ιού", "Ιού", "Αύγ", "Σεπ", "Οκτ", "Νοέ", "Δεκ"],
        longhand: ["Ιανουάριος", "Φεβρουάριος", "Μάρτιος", "Απρίλιος", "Μάιος", "Ιούνιος", "Ιούλιος", "Αύγουστος", "Σεπτέμβριος", "Οκτώβριος", "Νοέμβριος", "Δεκέμβριος"]
      },
      firstDayOfWeek: 1,
      ordinal: function ordinal() {
        return "";
      },
      weekAbbreviation: "Εβδ",
      rangeSeparator: " έως ",
      scrollTitle: "Μετακυλήστε για προσαύξηση",
      toggleTitle: "Κάντε κλικ για αλλαγή",
      amPM: ["ΠΜ", "ΜΜ"]
    };
    fp$g.l10ns.gr = Greek;
    fp$g.l10ns;

    var fp$h = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Hebrew = {
      weekdays: {
        shorthand: ["א", "ב", "ג", "ד", "ה", "ו", "ז"],
        longhand: ["ראשון", "שני", "שלישי", "רביעי", "חמישי", "שישי", "שבת"]
      },
      months: {
        shorthand: ["ינו׳", "פבר׳", "מרץ", "אפר׳", "מאי", "יוני", "יולי", "אוג׳", "ספט׳", "אוק׳", "נוב׳", "דצמ׳"],
        longhand: ["ינואר", "פברואר", "מרץ", "אפריל", "מאי", "יוני", "יולי", "אוגוסט", "ספטמבר", "אוקטובר", "נובמבר", "דצמבר"]
      }
    };
    fp$h.l10ns.he = Hebrew;
    fp$h.l10ns;

    var fp$i = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Hindi = {
      weekdays: {
        shorthand: ["रवि", "सोम", "मंगल", "बुध", "गुरु", "शुक्र", "शनि"],
        longhand: ["रविवार", "सोमवार", "मंगलवार", "बुधवार", "गुरुवार", "शुक्रवार", "शनिवार"]
      },
      months: {
        shorthand: ["जन", "फर", "मार्च", "अप्रेल", "मई", "जून", "जूलाई", "अग", "सित", "अक्ट", "नव", "दि"],
        longhand: ["जनवरी ", "फरवरी", "मार्च", "अप्रेल", "मई", "जून", "जूलाई", "अगस्त ", "सितम्बर", "अक्टूबर", "नवम्बर", "दिसम्बर"]
      }
    };
    fp$i.l10ns.hi = Hindi;
    fp$i.l10ns;

    var fp$j = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Croatian = {
      firstDayOfWeek: 1,
      weekdays: {
        shorthand: ["Ned", "Pon", "Uto", "Sri", "Čet", "Pet", "Sub"],
        longhand: ["Nedjelja", "Ponedjeljak", "Utorak", "Srijeda", "Četvrtak", "Petak", "Subota"]
      },
      months: {
        shorthand: ["Sij", "Velj", "Ožu", "Tra", "Svi", "Lip", "Srp", "Kol", "Ruj", "Lis", "Stu", "Pro"],
        longhand: ["Siječanj", "Veljača", "Ožujak", "Travanj", "Svibanj", "Lipanj", "Srpanj", "Kolovoz", "Rujan", "Listopad", "Studeni", "Prosinac"]
      }
    };
    fp$j.l10ns.hr = Croatian;
    fp$j.l10ns;

    var fp$k = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Hungarian = {
      firstDayOfWeek: 1,
      weekdays: {
        shorthand: ["V", "H", "K", "Sz", "Cs", "P", "Szo"],
        longhand: ["Vasárnap", "Hétfő", "Kedd", "Szerda", "Csütörtök", "Péntek", "Szombat"]
      },
      months: {
        shorthand: ["Jan", "Feb", "Már", "Ápr", "Máj", "Jún", "Júl", "Aug", "Szep", "Okt", "Nov", "Dec"],
        longhand: ["Január", "Február", "Március", "Április", "Május", "Június", "Július", "Augusztus", "Szeptember", "Október", "November", "December"]
      },
      ordinal: function ordinal() {
        return ".";
      },
      weekAbbreviation: "Hét",
      scrollTitle: "Görgessen",
      toggleTitle: "Kattintson a váltáshoz"
    };
    fp$k.l10ns.hu = Hungarian;
    fp$k.l10ns;

    var fp$l = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Indonesian = {
      weekdays: {
        shorthand: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
        longhand: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"]
      },
      months: {
        shorthand: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        longhand: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]
      },
      firstDayOfWeek: 1,
      ordinal: function ordinal() {
        return "";
      }
    };
    fp$l.l10ns.id = Indonesian;
    fp$l.l10ns;

    var fp$m = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Italian = {
      weekdays: {
        shorthand: ["Dom", "Lun", "Mar", "Mer", "Gio", "Ven", "Sab"],
        longhand: ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"]
      },
      months: {
        shorthand: ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"],
        longhand: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"]
      },
      firstDayOfWeek: 1,
      ordinal: function ordinal() {
        return "°";
      },
      rangeSeparator: " al ",
      weekAbbreviation: "Se",
      scrollTitle: "Scrolla per aumentare",
      toggleTitle: "Clicca per cambiare"
    };
    fp$m.l10ns.it = Italian;
    fp$m.l10ns;

    var fp$n = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Japanese = {
      weekdays: {
        shorthand: ["日", "月", "火", "水", "木", "金", "土"],
        longhand: ["日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日"]
      },
      months: {
        shorthand: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
        longhand: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"]
      }
    };
    fp$n.l10ns.ja = Japanese;
    fp$n.l10ns;

    var fp$o = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Korean = {
      weekdays: {
        shorthand: ["일", "월", "화", "수", "목", "금", "토"],
        longhand: ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"]
      },
      months: {
        shorthand: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
        longhand: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"]
      },
      ordinal: function ordinal() {
        return "일";
      }
    };
    fp$o.l10ns.ko = Korean;
    fp$o.l10ns;

    var fp$p = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Kazakh = {
      weekdays: {
        shorthand: ["Жс", "Дс", "Сc", "Ср", "Бс", "Жм", "Сб"],
        longhand: ["Жексенбi", "Дүйсенбi", "Сейсенбi", "Сәрсенбi", "Бейсенбi", "Жұма", "Сенбi"]
      },
      months: {
        shorthand: ["Қаң", "Ақп", "Нау", "Сәу", "Мам", "Мау", "Шiл", "Там", "Қыр", "Қаз", "Қар", "Жел"],
        longhand: ["Қаңтар", "Ақпан", "Наурыз", "Сәуiр", "Мамыр", "Маусым", "Шiлде", "Тамыз", "Қыркүйек", "Қазан", "Қараша", "Желтоқсан"]
      },
      firstDayOfWeek: 1,
      ordinal: function ordinal() {
        return "";
      },
      rangeSeparator: " — ",
      weekAbbreviation: "Апта",
      scrollTitle: "Үлкейту үшін айналдырыңыз",
      toggleTitle: "Ауыстыру үшін басыңыз",
      amPM: ["ТД", "ТК"],
      yearAriaLabel: "Жыл"
    };
    fp$p.l10ns.kz = Kazakh;
    fp$p.l10ns;

    var fp$q = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Lithuanian = {
      weekdays: {
        shorthand: ["S", "Pr", "A", "T", "K", "Pn", "Š"],
        longhand: ["Sekmadienis", "Pirmadienis", "Antradienis", "Trečiadienis", "Ketvirtadienis", "Penktadienis", "Šeštadienis"]
      },
      months: {
        shorthand: ["Sau", "Vas", "Kov", "Bal", "Geg", "Bir", "Lie", "Rgp", "Rgs", "Spl", "Lap", "Grd"],
        longhand: ["Sausis", "Vasaris", "Kovas", "Balandis", "Gegužė", "Birželis", "Liepa", "Rugpjūtis", "Rugsėjis", "Spalis", "Lapkritis", "Gruodis"]
      },
      firstDayOfWeek: 1,
      ordinal: function ordinal() {
        return "-a";
      },
      weekAbbreviation: "Sav",
      scrollTitle: "Keisti laiką pelės rateliu",
      toggleTitle: "Perjungti laiko formatą"
    };
    fp$q.l10ns.lt = Lithuanian;
    fp$q.l10ns;

    var fp$r = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Latvian = {
      firstDayOfWeek: 1,
      weekdays: {
        shorthand: ["Sv", "P", "Ot", "Tr", "Ce", "Pk", "Se"],
        longhand: ["Svētdiena", "Pirmdiena", "Otrdiena", "Trešdiena", "Ceturtdiena", "Piektdiena", "Sestdiena"]
      },
      months: {
        shorthand: ["Jan", "Feb", "Mar", "Mai", "Apr", "Jūn", "Jūl", "Aug", "Sep", "Okt", "Nov", "Dec"],
        longhand: ["Janvāris", "Februāris", "Marts", "Aprīlis", "Maijs", "Jūnijs", "Jūlijs", "Augusts", "Septembris", "Oktobris", "Novembris", "Decembris"]
      },
      rangeSeparator: " līdz "
    };
    fp$r.l10ns.lv = Latvian;
    fp$r.l10ns;

    var fp$s = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Macedonian = {
      weekdays: {
        shorthand: ["Не", "По", "Вт", "Ср", "Че", "Пе", "Са"],
        longhand: ["Недела", "Понеделник", "Вторник", "Среда", "Четврток", "Петок", "Сабота"]
      },
      months: {
        shorthand: ["Јан", "Фев", "Мар", "Апр", "Мај", "Јун", "Јул", "Авг", "Сеп", "Окт", "Ное", "Дек"],
        longhand: ["Јануари", "Февруари", "Март", "Април", "Мај", "Јуни", "Јули", "Август", "Септември", "Октомври", "Ноември", "Декември"]
      },
      firstDayOfWeek: 1,
      weekAbbreviation: "Нед.",
      rangeSeparator: " до "
    };
    fp$s.l10ns.mk = Macedonian;
    fp$s.l10ns;

    var fp$t = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Mongolian = {
      firstDayOfWeek: 1,
      weekdays: {
        shorthand: ["Да", "Мя", "Лх", "Пү", "Ба", "Бя", "Ня"],
        longhand: ["Даваа", "Мягмар", "Лхагва", "Пүрэв", "Баасан", "Бямба", "Ням"]
      },
      months: {
        shorthand: ["1-р сар", "2-р сар", "3-р сар", "4-р сар", "5-р сар", "6-р сар", "7-р сар", "8-р сар", "9-р сар", "10-р сар", "11-р сар", "12-р сар"],
        longhand: ["Нэгдүгээр сар", "Хоёрдугаар сар", "Гуравдугаар сар", "Дөрөвдүгээр сар", "Тавдугаар сар", "Зургаадугаар сар", "Долдугаар сар", "Наймдугаар сар", "Есдүгээр сар", "Аравдугаар сар", "Арваннэгдүгээр сар", "Арванхоёрдугаар сар"]
      },
      rangeSeparator: "-с "
    };
    fp$t.l10ns.mn = Mongolian;
    fp$t.l10ns;

    var fp$u = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Malaysian = {
      weekdays: {
        shorthand: ["Min", "Isn", "Sel", "Rab", "Kha", "Jum", "Sab"],
        longhand: ["Minggu", "Isnin", "Selasa", "Rabu", "Khamis", "Jumaat", "Sabtu"]
      },
      months: {
        shorthand: ["Jan", "Feb", "Mac", "Apr", "Mei", "Jun", "Jul", "Ogo", "Sep", "Okt", "Nov", "Dis"],
        longhand: ["Januari", "Februari", "Mac", "April", "Mei", "Jun", "Julai", "Ogos", "September", "Oktober", "November", "Disember"]
      },
      firstDayOfWeek: 1,
      ordinal: function ordinal() {
        return "";
      }
    };
    fp$u.l10ns;

    var fp$v = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Burmese = {
      weekdays: {
        shorthand: ["နွေ", "လာ", "ဂါ", "ဟူး", "ကြာ", "သော", "နေ"],
        longhand: ["တနင်္ဂနွေ", "တနင်္လာ", "အင်္ဂါ", "ဗုဒ္ဓဟူး", "ကြာသပတေး", "သောကြာ", "စနေ"]
      },
      months: {
        shorthand: ["ဇန်", "ဖေ", "မတ်", "ပြီ", "မေ", "ဇွန်", "လိုင်", "သြ", "စက်", "အောက်", "နို", "ဒီ"],
        longhand: ["ဇန်နဝါရီ", "ဖေဖော်ဝါရီ", "မတ်", "ဧပြီ", "မေ", "ဇွန်", "ဇူလိုင်", "သြဂုတ်", "စက်တင်ဘာ", "အောက်တိုဘာ", "နိုဝင်ဘာ", "ဒီဇင်ဘာ"]
      },
      firstDayOfWeek: 1,
      ordinal: function ordinal() {
        return "";
      }
    };
    fp$v.l10ns.my = Burmese;
    fp$v.l10ns;

    var fp$w = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Dutch = {
      weekdays: {
        shorthand: ["zo", "ma", "di", "wo", "do", "vr", "za"],
        longhand: ["zondag", "maandag", "dinsdag", "woensdag", "donderdag", "vrijdag", "zaterdag"]
      },
      months: {
        shorthand: ["jan", "feb", "mrt", "apr", "mei", "jun", "jul", "aug", "sept", "okt", "nov", "dec"],
        longhand: ["januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december"]
      },
      firstDayOfWeek: 1,
      weekAbbreviation: "wk",
      rangeSeparator: " tot ",
      scrollTitle: "Scroll voor volgende / vorige",
      toggleTitle: "Klik om te wisselen",
      ordinal: function ordinal(nth) {
        if (nth === 1 || nth === 8 || nth >= 20) return "ste";
        return "de";
      }
    };
    fp$w.l10ns.nl = Dutch;
    fp$w.l10ns;

    var fp$x = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Norwegian = {
      weekdays: {
        shorthand: ["Søn", "Man", "Tir", "Ons", "Tor", "Fre", "Lør"],
        longhand: ["Søndag", "Mandag", "Tirsdag", "Onsdag", "Torsdag", "Fredag", "Lørdag"]
      },
      months: {
        shorthand: ["Jan", "Feb", "Mar", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"],
        longhand: ["Januar", "Februar", "Mars", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Desember"]
      },
      firstDayOfWeek: 1,
      rangeSeparator: " til ",
      weekAbbreviation: "Uke",
      scrollTitle: "Scroll for å endre",
      toggleTitle: "Klikk for å veksle",
      ordinal: function ordinal() {
        return ".";
      }
    };
    fp$x.l10ns.no = Norwegian;
    fp$x.l10ns;

    var fp$y = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Punjabi = {
      weekdays: {
        shorthand: ["ਐਤ", "ਸੋਮ", "ਮੰਗਲ", "ਬੁੱਧ", "ਵੀਰ", "ਸ਼ੁੱਕਰ", "ਸ਼ਨਿੱਚਰ"],
        longhand: ["ਐਤਵਾਰ", "ਸੋਮਵਾਰ", "ਮੰਗਲਵਾਰ", "ਬੁੱਧਵਾਰ", "ਵੀਰਵਾਰ", "ਸ਼ੁੱਕਰਵਾਰ", "ਸ਼ਨਿੱਚਰਵਾਰ"]
      },
      months: {
        shorthand: ["ਜਨ", "ਫ਼ਰ", "ਮਾਰ", "ਅਪ੍ਰੈ", "ਮਈ", "ਜੂਨ", "ਜੁਲਾ", "ਅਗ", "ਸਤੰ", "ਅਕ", "ਨਵੰ", "ਦਸੰ"],
        longhand: ["ਜਨਵਰੀ", "ਫ਼ਰਵਰੀ", "ਮਾਰਚ", "ਅਪ੍ਰੈਲ", "ਮਈ", "ਜੂਨ", "ਜੁਲਾਈ", "ਅਗਸਤ", "ਸਤੰਬਰ", "ਅਕਤੂਬਰ", "ਨਵੰਬਰ", "ਦਸੰਬਰ"]
      }
    };
    fp$y.l10ns.pa = Punjabi;
    fp$y.l10ns;

    var fp$z = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Polish = {
      weekdays: {
        shorthand: ["Nd", "Pn", "Wt", "Śr", "Cz", "Pt", "So"],
        longhand: ["Niedziela", "Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota"]
      },
      months: {
        shorthand: ["Sty", "Lut", "Mar", "Kwi", "Maj", "Cze", "Lip", "Sie", "Wrz", "Paź", "Lis", "Gru"],
        longhand: ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"]
      },
      rangeSeparator: " do ",
      weekAbbreviation: "tydz.",
      scrollTitle: "Przwiń aby zwiększyć",
      toggleTitle: "Kliknij aby przełączyć",
      firstDayOfWeek: 1,
      ordinal: function ordinal() {
        return ".";
      }
    };
    fp$z.l10ns.pl = Polish;
    fp$z.l10ns;

    var fp$A = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Portuguese = {
      weekdays: {
        shorthand: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
        longhand: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"]
      },
      months: {
        shorthand: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
        longhand: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"]
      },
      rangeSeparator: " até "
    };
    fp$A.l10ns.pt = Portuguese;
    fp$A.l10ns;

    var fp$B = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Romanian = {
      weekdays: {
        shorthand: ["Dum", "Lun", "Mar", "Mie", "Joi", "Vin", "Sam"],
        longhand: ["Duminică", "Luni", "Marți", "Miercuri", "Joi", "Vineri", "Sâmbătă"]
      },
      months: {
        shorthand: ["Ian", "Feb", "Mar", "Apr", "Mai", "Iun", "Iul", "Aug", "Sep", "Oct", "Noi", "Dec"],
        longhand: ["Ianuarie", "Februarie", "Martie", "Aprilie", "Mai", "Iunie", "Iulie", "August", "Septembrie", "Octombrie", "Noiembrie", "Decembrie"]
      },
      firstDayOfWeek: 1,
      ordinal: function ordinal() {
        return "";
      }
    };
    fp$B.l10ns.ro = Romanian;
    fp$B.l10ns;

    var fp$C = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Russian = {
      weekdays: {
        shorthand: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
        longhand: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"]
      },
      months: {
        shorthand: ["Янв", "Фев", "Март", "Апр", "Май", "Июнь", "Июль", "Авг", "Сен", "Окт", "Ноя", "Дек"],
        longhand: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"]
      },
      firstDayOfWeek: 1,
      ordinal: function ordinal() {
        return "";
      },
      rangeSeparator: " — ",
      weekAbbreviation: "Нед.",
      scrollTitle: "Прокрутите для увеличения",
      toggleTitle: "Нажмите для переключения",
      amPM: ["ДП", "ПП"],
      yearAriaLabel: "Год"
    };
    fp$C.l10ns.ru = Russian;
    fp$C.l10ns;

    var fp$D = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Sinhala = {
      weekdays: {
        shorthand: ["ඉ", "ස", "අ", "බ", "බ්‍ර", "සි", "සෙ"],
        longhand: ["ඉරිදා", "සඳුදා", "අඟහරුවාදා", "බදාදා", "බ්‍රහස්පතින්දා", "සිකුරාදා", "සෙනසුරාදා"]
      },
      months: {
        shorthand: ["ජන", "පෙබ", "මාර්", "අප්‍රේ", "මැයි", "ජුනි", "ජූලි", "අගෝ", "සැප්", "ඔක්", "නොවැ", "දෙසැ"],
        longhand: ["ජනවාරි", "පෙබරවාරි", "මාර්තු", "අප්‍රේල්", "මැයි", "ජුනි", "ජූලි", "අගෝස්තු", "සැප්තැම්බර්", "ඔක්තෝබර්", "නොවැම්බර්", "දෙසැම්බර්"]
      }
    };
    fp$D.l10ns.si = Sinhala;
    fp$D.l10ns;

    var fp$E = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Slovak = {
      weekdays: {
        shorthand: ["Ned", "Pon", "Ut", "Str", "Štv", "Pia", "Sob"],
        longhand: ["Nedeľa", "Pondelok", "Utorok", "Streda", "Štvrtok", "Piatok", "Sobota"]
      },
      months: {
        shorthand: ["Jan", "Feb", "Mar", "Apr", "Máj", "Jún", "Júl", "Aug", "Sep", "Okt", "Nov", "Dec"],
        longhand: ["Január", "Február", "Marec", "Apríl", "Máj", "Jún", "Júl", "August", "September", "Október", "November", "December"]
      },
      firstDayOfWeek: 1,
      rangeSeparator: " do ",
      ordinal: function ordinal() {
        return ".";
      }
    };
    fp$E.l10ns.sk = Slovak;
    fp$E.l10ns;

    var fp$F = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Slovenian = {
      weekdays: {
        shorthand: ["Ned", "Pon", "Tor", "Sre", "Čet", "Pet", "Sob"],
        longhand: ["Nedelja", "Ponedeljek", "Torek", "Sreda", "Četrtek", "Petek", "Sobota"]
      },
      months: {
        shorthand: ["Jan", "Feb", "Mar", "Apr", "Maj", "Jun", "Jul", "Avg", "Sep", "Okt", "Nov", "Dec"],
        longhand: ["Januar", "Februar", "Marec", "April", "Maj", "Junij", "Julij", "Avgust", "September", "Oktober", "November", "December"]
      },
      firstDayOfWeek: 1,
      rangeSeparator: " do ",
      ordinal: function ordinal() {
        return ".";
      }
    };
    fp$F.l10ns.sl = Slovenian;
    fp$F.l10ns;

    var fp$G = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Albanian = {
      weekdays: {
        shorthand: ["Di", "Hë", "Ma", "Më", "En", "Pr", "Sh"],
        longhand: ["E Diel", "E Hënë", "E Martë", "E Mërkurë", "E Enjte", "E Premte", "E Shtunë"]
      },
      months: {
        shorthand: ["Jan", "Shk", "Mar", "Pri", "Maj", "Qer", "Kor", "Gus", "Sht", "Tet", "Nën", "Dhj"],
        longhand: ["Janar", "Shkurt", "Mars", "Prill", "Maj", "Qershor", "Korrik", "Gusht", "Shtator", "Tetor", "Nëntor", "Dhjetor"]
      }
    };
    fp$G.l10ns.sq = Albanian;
    fp$G.l10ns;

    var fp$H = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Serbian = {
      weekdays: {
        shorthand: ["Ned", "Pon", "Uto", "Sre", "Čet", "Pet", "Sub"],
        longhand: ["Nedelja", "Ponedeljak", "Utorak", "Sreda", "Četvrtak", "Petak", "Subota"]
      },
      months: {
        shorthand: ["Jan", "Feb", "Mar", "Apr", "Maj", "Jun", "Jul", "Avg", "Sep", "Okt", "Nov", "Dec"],
        longhand: ["Januar", "Februar", "Mart", "April", "Maj", "Jun", "Jul", "Avgust", "Septembar", "Oktobar", "Novembar", "Decembar"]
      },
      firstDayOfWeek: 1,
      weekAbbreviation: "Ned.",
      rangeSeparator: " do "
    };
    fp$H.l10ns.sr = Serbian;
    fp$H.l10ns;

    var fp$I = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Swedish = {
      firstDayOfWeek: 1,
      weekAbbreviation: "v",
      weekdays: {
        shorthand: ["Sön", "Mån", "Tis", "Ons", "Tor", "Fre", "Lör"],
        longhand: ["Söndag", "Måndag", "Tisdag", "Onsdag", "Torsdag", "Fredag", "Lördag"]
      },
      months: {
        shorthand: ["Jan", "Feb", "Mar", "Apr", "Maj", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec"],
        longhand: ["Januari", "Februari", "Mars", "April", "Maj", "Juni", "Juli", "Augusti", "September", "Oktober", "November", "December"]
      },
      ordinal: function ordinal() {
        return ".";
      }
    };
    fp$I.l10ns.sv = Swedish;
    fp$I.l10ns;

    var fp$J = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Thai = {
      weekdays: {
        shorthand: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"],
        longhand: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"]
      },
      months: {
        shorthand: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."],
        longhand: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"]
      },
      firstDayOfWeek: 1,
      rangeSeparator: " ถึง ",
      scrollTitle: "เลื่อนเพื่อเพิ่มหรือลด",
      toggleTitle: "คลิกเพื่อเปลี่ยน",
      ordinal: function ordinal() {
        return "";
      }
    };
    fp$J.l10ns.th = Thai;
    fp$J.l10ns;

    var fp$K = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Turkish = {
      weekdays: {
        shorthand: ["Paz", "Pzt", "Sal", "Çar", "Per", "Cum", "Cmt"],
        longhand: ["Pazar", "Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi"]
      },
      months: {
        shorthand: ["Oca", "Şub", "Mar", "Nis", "May", "Haz", "Tem", "Ağu", "Eyl", "Eki", "Kas", "Ara"],
        longhand: ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"]
      },
      firstDayOfWeek: 1,
      ordinal: function ordinal() {
        return ".";
      },
      rangeSeparator: " - ",
      weekAbbreviation: "Hf",
      scrollTitle: "Artırmak için kaydırın",
      toggleTitle: "Aç/Kapa",
      amPM: ["ÖÖ", "ÖS"]
    };
    fp$K.l10ns.tr = Turkish;
    fp$K.l10ns;

    var fp$L = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Ukrainian = {
      firstDayOfWeek: 1,
      weekdays: {
        shorthand: ["Нд", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
        longhand: ["Неділя", "Понеділок", "Вівторок", "Середа", "Четвер", "П'ятниця", "Субота"]
      },
      months: {
        shorthand: ["Січ", "Лют", "Бер", "Кві", "Тра", "Чер", "Лип", "Сер", "Вер", "Жов", "Лис", "Гру"],
        longhand: ["Січень", "Лютий", "Березень", "Квітень", "Травень", "Червень", "Липень", "Серпень", "Вересень", "Жовтень", "Листопад", "Грудень"]
      }
    };
    fp$L.l10ns.uk = Ukrainian;
    fp$L.l10ns;

    var fp$M = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Vietnamese = {
      weekdays: {
        shorthand: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
        longhand: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"]
      },
      months: {
        shorthand: ["Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12"],
        longhand: ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng 11", "Tháng 12"]
      },
      firstDayOfWeek: 1
    };
    fp$M.l10ns.vn = Vietnamese;
    fp$M.l10ns;

    var fp$N = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
      l10ns: {}
    };
    var Mandarin = {
      weekdays: {
        shorthand: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
        longhand: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"]
      },
      months: {
        shorthand: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        longhand: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"]
      },
      rangeSeparator: " 至 ",
      weekAbbreviation: "周",
      scrollTitle: "滚动切换",
      toggleTitle: "点击切换 12/24 小时时制"
    };
    fp$N.l10ns.zh = Mandarin;
    fp$N.l10ns;

    var l10n = {
      ar: Arabic,
      at: Austria,
      be: Belarusian,
      bg: Bulgarian,
      bn: Bangla,
      cat: Catalan,
      cs: Czech,
      cy: Welsh,
      da: Danish,
      de: German,
      default: Object.assign({}, english),
      en: english,
      eo: Esperanto,
      es: Spanish,
      et: Estonian,
      fa: Persian,
      fi: Finnish,
      fr: French,
      gr: Greek,
      he: Hebrew,
      hi: Hindi,
      hr: Croatian,
      hu: Hungarian,
      id: Indonesian,
      it: Italian,
      ja: Japanese,
      ko: Korean,
      kz: Kazakh,
      lt: Lithuanian,
      lv: Latvian,
      mk: Macedonian,
      mn: Mongolian,
      ms: Malaysian,
      my: Burmese,
      nl: Dutch,
      no: Norwegian,
      pa: Punjabi,
      pl: Polish,
      pt: Portuguese,
      ro: Romanian,
      ru: Russian,
      si: Sinhala,
      sk: Slovak,
      sl: Slovenian,
      sq: Albanian,
      sr: Serbian,
      sv: Swedish,
      th: Thai,
      tr: Turkish,
      uk: Ukrainian,
      vn: Vietnamese,
      zh: Mandarin
    };

    exports.default = l10n;

    Object.defineProperty(exports, '__esModule', { value: true });

})));


/***/ }),

/***/ 75:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_inputmask__ = __webpack_require__(24);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_inputmask___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_inputmask__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "connect",


        /**
         *
         */
        value: function connect() {
            var element = this.element.querySelector('input');
            __WEBPACK_IMPORTED_MODULE_1_inputmask___default()(element.dataset.mask).mask(element);
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 80:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_croppie__ = __webpack_require__(27);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_croppie___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_croppie__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "connect",


        /**
         *
         */
        value: function connect() {
            var image = this.data.get('image');

            if (image) {
                this.element.querySelector('.picture-preview').src = image;
            } else {
                this.element.querySelector('.picture-preview').classList.add('none');
                this.element.querySelector('.picture-remove').classList.add('none');
            }

            var cropPanel = this.element.querySelector('.upload-panel');
            this.croppie = new __WEBPACK_IMPORTED_MODULE_1_croppie__["Croppie"](cropPanel, {
                viewport: {
                    width: this.data.get('width'),
                    height: this.data.get('height')
                },
                boundary: {
                    width: '100%',
                    height: 500
                },
                enforceBoundary: true
            });
        }

        /**
         * Event for uploading image
         *
         * @param event
         */


        /**
         *
         * @type {string[]}
         */

    }, {
        key: "upload",
        value: function upload(event) {
            var _this2 = this;

            if (!event.target.files[0]) {
                return;
            }

            var reader = new FileReader();
            reader.readAsDataURL(event.target.files[0]);

            reader.onloadend = function () {
                _this2.croppie.bind({
                    url: reader.result
                });
            };

            $(this.element.querySelector('.modal')).modal('show');
        }

        /**
         * Action on click button "Crop"
         */

    }, {
        key: "crop",
        value: function crop() {
            var _this3 = this;

            this.croppie.result('result', {
                type: 'blob',
                size: 'viewport',
                format: 'png'
            }).then(function (blob) {

                var data = new FormData();
                data.append('file', blob);
                data.append('storage', 'public');

                var element = _this3.element;
                axios.post(platform.prefix('/systems/files'), data).then(function (response) {

                    var image = "/storage/" + response.data.path + response.data.name + "." + response.data.extension;

                    element.querySelector('.picture-preview').src = image;
                    element.querySelector('.picture-preview').classList.remove('none');
                    element.querySelector('.picture-remove').classList.remove('none');
                    element.querySelector('.picture-path').value = image;
                    $(element.querySelector('.modal')).modal('hide');
                });
            });
        }

        /**
         *
         */

    }, {
        key: "clear",
        value: function clear() {
            this.element.querySelector('.picture-path').value = '';
            this.element.querySelector('.picture-preview').src = '';
            this.element.querySelector('.picture-preview').classList.add('none');
            this.element.querySelector('.picture-remove').classList.add('none');
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["source", "upload"];
/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 82:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: 'connect',


        /**
         *
         */
        value: function connect() {
            var select = this.element.querySelector('select');

            if (select.getAttribute('multiple') === null) {
                return;
            }

            setTimeout(function () {
                $(select).select2({
                    width: '100%',
                    theme: 'bootstrap'
                });
            }, 500);
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 83:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_simplemde__ = __webpack_require__(30);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_simplemde___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_simplemde__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "connect",


        /**
         *
         */
        value: function connect() {
            var _this2 = this;

            this.editor = new __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a({
                autoDownloadFontAwesome: false,
                forceSync: true,
                element: this.textarea,
                toolbar: [{
                    name: "bold",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleBold,
                    className: "icon-bold",
                    title: "Bold"
                }, {
                    name: "italic",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleItalic,
                    className: "icon-italic",
                    title: "Italic"
                }, {
                    name: "heading",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleHeadingSmaller,
                    className: "icon-font",
                    title: "Heading"
                }, '|', {
                    name: "quote",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleBlockquote,
                    className: "icon-quote",
                    title: "Quote"
                }, {
                    name: "code",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleCodeBlock,
                    className: "icon-code",
                    title: "Code"
                }, {
                    name: "unordered-list",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleUnorderedList,
                    className: "icon-list",
                    title: "Generic List"
                }, {
                    name: "ordered-list",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleOrderedList,
                    className: "icon-number-list",
                    title: "Numbered List"
                }, '|', {
                    name: "link",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.drawLink,
                    className: "icon-link",
                    title: "Link"
                }, {
                    name: "image",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.drawImage,
                    className: "icon-picture",
                    title: "Insert Image"
                }, {
                    name: "upload",
                    action: function action() {
                        return _this2.showDialogUpload();
                    },
                    className: "icon-cloud-upload",
                    title: "Upload File"
                }, {
                    name: "table",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.drawTable,
                    className: "icon-table",
                    title: "Insert Table"
                }, '|', {
                    name: "preview",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.togglePreview,
                    className: "icon-eye no-disable",
                    title: "Toggle Preview"
                }, {
                    name: "side-by-side",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleSideBySide,
                    className: "icon-browser no-disable no-mobile",
                    title: "Toggle Side by Side"
                }, {
                    name: "fullscreen",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleFullScreen,
                    className: "icon-full-screen no-disable no-mobile",
                    title: "Toggle Fullscreen"
                }, '|', {
                    name: "horizontal-rule",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.drawHorizontalRule,
                    className: "icon-options",
                    title: "Insert Horizontal Line"
                }, {
                    name: "guide",
                    action: function action() {
                        return _this2.showModal();
                    },
                    className: "icon-help",
                    title: "Markdown Guide"
                }],
                placeholder: this.textarea.placeholder,
                spellChecker: false
            });
        }

        /**
         *
         * @returns {Element}
         */

    }, {
        key: "showModal",
        value: function showModal() {
            $(this.element.querySelector('.modal')).modal('show');
        }

        /**
         *
         */

    }, {
        key: "showDialogUpload",
        value: function showDialogUpload() {
            this.uploadInput.click();
        }

        /**
         *
         * @param editor
         * @param event
         */

    }, {
        key: "upload",
        value: function upload(event) {
            var file = event.target.files[0];

            if (file === undefined || file === null) {
                return;
            }

            var cm = this.editor.codemirror;
            var formData = new FormData();
            formData.append("file", file);

            axios.post(platform.prefix('/systems/files'), formData).then(function (response) {
                cm.replaceSelection(response.data.url);
                event.target.value = null;
            }).catch(function (error) {
                console.warn(error);
                event.target.value = null;
            });
        }
    }, {
        key: "textarea",


        /**
         *
         * @returns {Element}
         */
        get: function get() {
            return this.element.querySelector('textarea');
        }

        /**
         *
         */

    }, {
        key: "uploadInput",
        get: function get() {
            return this.element.querySelector('.upload');
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 99:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(1);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: 'connect',
        value: function connect() {

            var select = this.element.querySelector('select');

            setTimeout(function () {
                $(select).select2({
                    templateResult: function templateResult(state) {
                        if (!state.id || !state.count) {
                            return state.text;
                        }
                        return $('<span>' + state.text + '</span><span class="pull-right badge bg-info">' + state.count + '</span>');
                    },
                    createTag: function createTag(tag) {
                        return {
                            id: tag.term,
                            text: tag.term
                        };
                    },
                    escapeMarkup: function escapeMarkup(m) {
                        return m;
                    },

                    width: '100%',
                    tags: true,
                    cache: true,
                    ajax: {
                        url: function url(params) {
                            return platform.prefix('/systems/tags/' + params.term);
                        },

                        delay: 340,
                        processResults: function processResults(data) {
                            return {
                                results: data
                            };
                        }
                    }
                });
            }, 500);
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ })

},[44]);
//# sourceMappingURL=orchid.js.map