webpackJsonp([1],{

/***/ 100:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
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
            }, 100);
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 101:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce__ = __webpack_require__(31);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }


// Core


// A theme is also required
// import 'tinymce/themes/modern';
// import 'tinymce/themes/inlite'


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
            // require.context(
            //    'file-loader?name=[path][name].[ext]&context=node_modules/tinymce!tinymce/skins',
            //    true,
            //    /.*/
            // );


            __WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce___default.a.baseURL = '/orchid/js/tinymce';

            var selector = this.element.querySelector('.tinymce').id;
            var input = this.element.querySelector('input');

            var plugins = 'image media table link paste contextmenu textpattern autolink codesample';
            var toolbar1 = '';
            var inline = true;

            if (this.element.dataset.theme === 'modern') {
                plugins = 'print autosave autoresize preview paste code searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern';
                toolbar1 = 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat | ltr rtl';
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

            document.addEventListener('turbolinks:before-cache', function () {
                __WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce___default.a.remove('#' + selector);
            }, { once: true });
        }

        /**
         *
         * @param blobInfo
         * @param success
         */

    }, {
        key: 'upload',
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
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 104:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_dropzone__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_dropzone___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_dropzone__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

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
        key: "openLink",


        /**
         *
         */
        value: function openLink() {
            event.preventDefault();
            window.open(this.data.get('url'));
        }

        /**
         *
         */

    }, {
        key: "connect",
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
            var attach = this.activeAttachment;
            $(this.dropname + " .modal").modal('toggle');

            var name = attach.name + attach.id;

            if (this.attachments.hasOwnProperty(name)) {
                this.attachments[name].name = attach.name;
                this.attachments[name].alt = attach.alt;
                this.attachments[name].description = attach.description;
            }

            axios.put(platform.prefix("/systems/files/post/" + attach.id), attach).then();
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
            $(this.dropname + ' .sortable-dropzone').sortable({
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
            var groups = this.data.get('groups');

            new __WEBPACK_IMPORTED_MODULE_1_dropzone___default.a(dropname, {
                url: platform.prefix('/systems/files'),
                method: 'post',
                uploadMultiple: false,
                parallelUploads: 100,
                maxFilesize: 9999,
                paramName: 'files',
                maxThumbnailFilesize: 99999,
                previewsContainer: dropname + " .visual-dropzone",
                addRemoveLinks: false,
                dictFileTooBig: 'File is big',
                autoDiscover: false,

                init: function init() {
                    var _this2 = this;

                    this.on('addedfile', function (e) {

                        var removeButton = __WEBPACK_IMPORTED_MODULE_1_dropzone___default.a.createElement('<a href="javascript:;" class="btn-remove">&times;</a>');
                        var editButton = __WEBPACK_IMPORTED_MODULE_1_dropzone___default.a.createElement('<a href="javascript:;" class="btn-edit"><i class="icon-note" aria-hidden="true"></i></a>');

                        removeButton.addEventListener('click', function (event) {
                            event.preventDefault();
                            event.stopPropagation();
                            _this2.removeFile(e);
                        });

                        editButton.addEventListener('click', function () {
                            loadInfo(e.data);
                            $(dropname + " .modal").modal('show');
                        });

                        e.previewElement.appendChild(removeButton);
                        e.previewElement.appendChild(editButton);
                    });

                    this.on('completemultiple', function () {
                        $(dropname + ".sortable-dropzone").sortable('enable');
                    });

                    var images = data;

                    if (images) {
                        Object.values(images).forEach(function (item) {
                            var mockFile = {
                                id: item.id,
                                name: item.original_name,
                                size: item.size,
                                type: item.mime,
                                status: __WEBPACK_IMPORTED_MODULE_1_dropzone___default.a.ADDED,
                                url: "" + item.url,
                                data: item
                            };

                            _this2.emit('addedfile', mockFile);
                            _this2.emit('thumbnail', mockFile, mockFile.url);
                            _this2.files.push(mockFile);
                            $(dropname + ".dz-preview:last-child").attr('data-file-id', item.id).addClass('file-sort');
                            $("<input type='hidden' class='files-" + item.id + "' name='" + name + "[]' value='" + item.id + "'  />").appendTo(dropname);
                        });
                    }

                    $(dropname + " .dz-progress").remove();

                    this.on('sending', function (file, xhr, formData) {
                        formData.append('_token', $("meta[name='csrf_token']").attr('content'));
                        formData.append('storage', storage);
                        formData.append('group', groups);
                    });

                    this.on('removedfile', function (file) {
                        $(dropname + ".files-" + file.data.id).remove();
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
                    $(dropname + " .dz-preview:last-child").attr('data-file-id', response.id).addClass('file-sort');
                    $("<input type='hidden' class='files-" + response.id + "' name='" + name + "[]' value='" + response.id + "'  />").appendTo(dropname);
                }
            });
        }
    }, {
        key: "dropname",
        get: function get() {
            return '#' + this.data.get('id');
        }

        /**
         *
         * @returns {string|{id: *}}
         */

    }, {
        key: "activeAttachment",
        get: function get() {
            return {
                'id': this.activeAchivmentId,
                'name': this[this.getAttachmentTargetKey('name')].value,
                'alt': this[this.getAttachmentTargetKey('alt')].value,
                'description': this[this.getAttachmentTargetKey('description')].value
            };
        }

        /**
         *
         * @param data
         */
        ,
        set: function set(data) {
            this.activeAchivmentId = data.id;

            this[this.getAttachmentTargetKey('name')].value = data.name;
            this[this.getAttachmentTargetKey('original')].value = data.original_name;
            this[this.getAttachmentTargetKey('alt')].value = data.alt;
            this[this.getAttachmentTargetKey('description')].value = data.description;

            //this[this.getAttachmentTargetKey('url')].value = data.url;
            this.data.set('url', data.url);
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["name", "original", "alt", "description", "url"];
/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 105:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
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


        /**
         *
         * @type {string[]}
         */

    }, {
        key: "generate",
        value: function generate() {
            var url = new URL(this.urlTarget.value);
            this.urlTarget.value = url.protocol + '//' + url.host + url.pathname;

            this.addParams('source', this.sourceTarget.value);
            this.addParams('medium', this.mediumTarget.value);
            this.addParams('campaign', this.campaignTarget.value);
            this.addParams('term', this.termTarget.value);
            this.addParams('content', this.contentTarget.value);
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
        key: "addParams",
        value: function addParams(name, value) {
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

/***/ 106:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_turbolinks__ = __webpack_require__(33);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_turbolinks___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_turbolinks__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_axios__ = __webpack_require__(34);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_axios__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__platform__ = __webpack_require__(126);
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
        key: 'initialize',

        /**
         *
         */
        value: function initialize() {
            __WEBPACK_IMPORTED_MODULE_1_turbolinks___default.a.start();
            __WEBPACK_IMPORTED_MODULE_1_turbolinks___default.a.setProgressBarDelay(100);
            window.platform = Object(__WEBPACK_IMPORTED_MODULE_3__platform__["a" /* default */])();

            document.addEventListener("turbolinks:request-start", function () {
                document.body.classList.add("load");
            });

            document.addEventListener("turbolinks:load", function () {
                document.body.classList.remove("load");
            });

            document.querySelector("form").addEventListener("submit", function (e) {
                document.body.classList.add("load");
            });
        }

        /**
         *
         */

    }, {
        key: 'connect',
        value: function connect() {
            this.csrf();
        }

        /**
         * We'll load the axios HTTP library which allows us to easily issue requests
         * to our Laravel back-end. This library automatically handles sending the
         * CSRF token as a header based on the value of the "XSRF" token cookie.
         */

    }, {
        key: 'csrf',
        value: function csrf() {
            var token = document.head.querySelector('meta[name="csrf_token"]');
            window.axios = __WEBPACK_IMPORTED_MODULE_2_axios___default.a;

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

/***/ 126:
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

            if (prefix.content.charAt(0) !== '/') {
                prefix = '/' + prefix.content;
            }

            return location.protocol + '//' + location.hostname + (location.port ? ':' + location.port : '') + prefix.content + path;
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
                class: 'alert alert-' + type,
                text: message
            }).append($('<button/>', {
                class: 'close',
                'data-dismiss': 'alert',
                'aria-label': 'Close',
                'aria-hidden': 'true'
            }).append($('<span/>', {
                'aria-hidden': 'true',
                html: '&times;'
            }))), $('<div/>', { class: 'clearfix' }));
        },


        /**
         *
         * @param idForm
         * @param message
         * @returns {boolean}
         */
        validateForm: function validateForm(idForm, message) {
            if (!document.getElementById(idForm).checkValidity()) {
                window.platform.alert(message, 'warning');
                return false;
            }
            return true;
        }
    };
}
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 127:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
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
        key: 'query',


        /**
         * Search Event
         *
         * @param event
         */
        value: function query(event) {

            var element = this.getResultElement;

            if (event.target.value === '') {
                element.classList.remove("show");
            }

            axios.post(platform.prefix('/search/' + event.target.value)).then(function (response) {
                element.classList.add("show");
                element.innerHTML = response.data;
            });
        }

        /**
         * Event for blur
         */

    }, {
        key: 'blur',
        value: function blur() {
            var element = this.getResultElement;
            element.classList.remove("show");
        }

        /**
         * Event for focus
         *
         * @param event
         */

    }, {
        key: 'focus',
        value: function focus(event) {
            if (event.target.value === '') {
                return;
            }

            var element = this.getResultElement;
            element.classList.add("show");
        }

        /**
         *
         * @returns {HTMLElement}
         */

    }, {
        key: 'getResultElement',
        get: function get() {
            return document.getElementById("search-result");
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 128:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
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
        key: 'filter',

        /**
         * Stimulus gives the possibility of a change event when the field loses focus
         */
        value: function filter(event) {
            var search = event.target.value.trim().toLowerCase();

            $('.admin-element-item').hide().filter(function () {
                return $(this).html().trim().toLowerCase().indexOf(search) !== -1;
            }).show();

            $('.admin-element').show().filter(function () {
                return $(this).children('.list-group').children(':visible').length === 0;
            }).hide();
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 129:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
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
                title: event.target.dataset.modalTitle,
                submit: event.target.dataset.modalAction,
                params: event.target.dataset.modalParams
            });

            return event.preventDefault();

            // TODO: $('#screen-modal-type-'+key).addClass($('#show-button-modal-'+key).data('modalType'));
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 130:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_frappe_charts_dist_frappe_charts_esm__ = __webpack_require__(131);
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
            var chart = new __WEBPACK_IMPORTED_MODULE_1_frappe_charts_dist_frappe_charts_esm__["a" /* Chart */](this.data.get('parent'), {
                title: this.data.get('title'),
                data: {
                    labels: JSON.parse(this.data.get('labels')),
                    datasets: JSON.parse(this.data.get('datasets'))
                },
                type: this.data.get('type'),
                height: this.data.get('height'),

                colors: JSON.parse(this.data.get('colors'))
            });

            /*
            let resize = () => setTimeout(() => {
                console.log('test');
                chart.draw(!0)
            }, 1);
             window.addEventListener('resize', () => setTimeout(() => {
                console.log('test');
                chart.draw(!0)
            }, 1));
             window.removeEventListener('resize', () => setTimeout(() => {
                console.log('test');
                chart.draw(!0)
            }, 1))
            */
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 131:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return Chart; });
/* unused harmony export PercentageChart */
/* unused harmony export PieChart */
/* unused harmony export Heatmap */
/* unused harmony export AxisChart */
function $(expr, con) {
	return typeof expr === "string"? (con || document).querySelector(expr) : expr || null;
}



$.create = (tag, o) => {
	var element = document.createElement(tag);

	for (var i in o) {
		var val = o[i];

		if (i === "inside") {
			$(val).appendChild(element);
		}
		else if (i === "around") {
			var ref = $(val);
			ref.parentNode.insertBefore(element, ref);
			element.appendChild(ref);

		} else if (i === "styles") {
			if(typeof val === "object") {
				Object.keys(val).map(prop => {
					element.style[prop] = val[prop];
				});
			}
		} else if (i in element ) {
			element[i] = val;
		}
		else {
			element.setAttribute(i, val);
		}
	}

	return element;
};

function getOffset(element) {
	let rect = element.getBoundingClientRect();
	return {
		// https://stackoverflow.com/a/7436602/6495043
		// rect.top varies with scroll, so we add whatever has been
		// scrolled to it to get absolute distance from actual page top
		top: rect.top + (document.documentElement.scrollTop || document.body.scrollTop),
		left: rect.left + (document.documentElement.scrollLeft || document.body.scrollLeft)
	};
}

function isElementInViewport(el) {
	// Although straightforward: https://stackoverflow.com/a/7557433/6495043
	var rect = el.getBoundingClientRect();

	return (
		rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /*or $(window).height() */
        rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
	);
}

function getElementContentWidth(element) {
	var styles = window.getComputedStyle(element);
	var padding = parseFloat(styles.paddingLeft) +
		parseFloat(styles.paddingRight);

	return element.clientWidth - padding;
}





function fire(target, type, properties) {
	var evt = document.createEvent("HTMLEvents");

	evt.initEvent(type, true, true );

	for (var j in properties) {
		evt[j] = properties[j];
	}

	return target.dispatchEvent(evt);
}

// https://css-tricks.com/snippets/javascript/loop-queryselectorall-matches/

const BASE_MEASURES = {
	margins: {
		top: 10,
		bottom: 10,
		left: 20,
		right: 20
	},
	paddings: {
		top: 20,
		bottom: 40,
		left: 30,
		right: 10
	},

	baseHeight: 240,
	titleHeight: 20,
	legendHeight: 30,

	titleFontSize: 12,
};

function getTopOffset(m) {
	return m.titleHeight + m.margins.top + m.paddings.top;
}

function getLeftOffset(m) {
	return m.margins.left + m.paddings.left;
}

function getExtraHeight(m) {
	let totalExtraHeight = m.margins.top + m.margins.bottom
		+ m.paddings.top + m.paddings.bottom
		+ m.titleHeight + m.legendHeight;
	return totalExtraHeight;
}

function getExtraWidth(m) {
	let totalExtraWidth = m.margins.left + m.margins.right
		+ m.paddings.left + m.paddings.right;

	return totalExtraWidth;
}

const INIT_CHART_UPDATE_TIMEOUT = 700;
const CHART_POST_ANIMATE_TIMEOUT = 400;

const DEFAULT_AXIS_CHART_TYPE = 'line';
const AXIS_DATASET_CHART_TYPES = ['line', 'bar'];

const AXIS_LEGEND_BAR_SIZE = 100;

const BAR_CHART_SPACE_RATIO = 0.5;
const MIN_BAR_PERCENT_HEIGHT = 0.01;

const LINE_CHART_DOT_SIZE = 4;
const DOT_OVERLAY_SIZE_INCR = 4;

const PERCENTAGE_BAR_DEFAULT_HEIGHT = 20;
const PERCENTAGE_BAR_DEFAULT_DEPTH = 2;

// Fixed 5-color theme,
// More colors are difficult to parse visually
const HEATMAP_DISTRIBUTION_SIZE = 5;

const HEATMAP_SQUARE_SIZE = 10;
const HEATMAP_GUTTER_SIZE = 2;

const DEFAULT_CHAR_WIDTH = 7;

const TOOLTIP_POINTER_TRIANGLE_HEIGHT = 5;

const DEFAULT_CHART_COLORS = ['light-blue', 'blue', 'violet', 'red', 'orange',
	'yellow', 'green', 'light-green', 'purple', 'magenta', 'light-grey', 'dark-grey'];
const HEATMAP_COLORS_GREEN = ['#ebedf0', '#c6e48b', '#7bc96f', '#239a3b', '#196127'];



const DEFAULT_COLORS = {
	bar: DEFAULT_CHART_COLORS,
	line: DEFAULT_CHART_COLORS,
	pie: DEFAULT_CHART_COLORS,
	percentage: DEFAULT_CHART_COLORS,
	heatmap: HEATMAP_COLORS_GREEN
};

// Universal constants
const ANGLE_RATIO = Math.PI / 180;
const FULL_ANGLE = 360;

class SvgTip {
	constructor({
		parent = null,
		colors = []
	}) {
		this.parent = parent;
		this.colors = colors;
		this.titleName = '';
		this.titleValue = '';
		this.listValues = [];
		this.titleValueFirst = 0;

		this.x = 0;
		this.y = 0;

		this.top = 0;
		this.left = 0;

		this.setup();
	}

	setup() {
		this.makeTooltip();
	}

	refresh() {
		this.fill();
		this.calcPosition();
	}

	makeTooltip() {
		this.container = $.create('div', {
			inside: this.parent,
			className: 'graph-svg-tip comparison',
			innerHTML: `<span class="title"></span>
				<ul class="data-point-list"></ul>
				<div class="svg-pointer"></div>`
		});
		this.hideTip();

		this.title = this.container.querySelector('.title');
		this.dataPointList = this.container.querySelector('.data-point-list');

		this.parent.addEventListener('mouseleave', () => {
			this.hideTip();
		});
	}

	fill() {
		let title;
		if(this.index) {
			this.container.setAttribute('data-point-index', this.index);
		}
		if(this.titleValueFirst) {
			title = `<strong>${this.titleValue}</strong>${this.titleName}`;
		} else {
			title = `${this.titleName}<strong>${this.titleValue}</strong>`;
		}
		this.title.innerHTML = title;
		this.dataPointList.innerHTML = '';

		this.listValues.map((set, i) => {
			const color = this.colors[i] || 'black';
			let value = set.formatted === 0 || set.formatted ? set.formatted : set.value;

			let li = $.create('li', {
				styles: {
					'border-top': `3px solid ${color}`
				},
				innerHTML: `<strong style="display: block;">${ value === 0 || value ? value : '' }</strong>
					${set.title ? set.title : '' }`
			});

			this.dataPointList.appendChild(li);
		});
	}

	calcPosition() {
		let width = this.container.offsetWidth;

		this.top = this.y - this.container.offsetHeight
			- TOOLTIP_POINTER_TRIANGLE_HEIGHT;
		this.left = this.x - width/2;
		let maxLeft = this.parent.offsetWidth - width;

		let pointer = this.container.querySelector('.svg-pointer');

		if(this.left < 0) {
			pointer.style.left = `calc(50% - ${-1 * this.left}px)`;
			this.left = 0;
		} else if(this.left > maxLeft) {
			let delta = this.left - maxLeft;
			let pointerOffset = `calc(50% + ${delta}px)`;
			pointer.style.left = pointerOffset;

			this.left = maxLeft;
		} else {
			pointer.style.left = `50%`;
		}
	}

	setValues(x, y, title = {}, listValues = [], index = -1) {
		this.titleName = title.name;
		this.titleValue = title.value;
		this.listValues = listValues;
		this.x = x;
		this.y = y;
		this.titleValueFirst = title.valueFirst || 0;
		this.index = index;
		this.refresh();
	}

	hideTip() {
		this.container.style.top = '0px';
		this.container.style.left = '0px';
		this.container.style.opacity = '0';
	}

	showTip() {
		this.container.style.top = this.top + 'px';
		this.container.style.left = this.left + 'px';
		this.container.style.opacity = '1';
	}
}

function floatTwo(d) {
	return parseFloat(d.toFixed(2));
}

/**
 * Returns whether or not two given arrays are equal.
 * @param {Array} arr1 First array
 * @param {Array} arr2 Second array
 */


/**
 * Shuffles array in place. ES6 version
 * @param {Array} array An array containing the items.
 */


/**
 * Fill an array with extra points
 * @param {Array} array Array
 * @param {Number} count number of filler elements
 * @param {Object} element element to fill with
 * @param {Boolean} start fill at start?
 */
function fillArray(array, count, element, start=false) {
	if(!element) {
		element = start ? array[0] : array[array.length - 1];
	}
	let fillerArray = new Array(Math.abs(count)).fill(element);
	array = start ? fillerArray.concat(array) : array.concat(fillerArray);
	return array;
}

/**
 * Returns pixel width of string.
 * @param {String} string
 * @param {Number} charWidth Width of single char in pixels
 */
function getStringWidth(string, charWidth) {
	return (string+"").length * charWidth;
}



// https://stackoverflow.com/a/29325222


function getPositionByAngle(angle, radius) {
	return {
		x: Math.sin(angle * ANGLE_RATIO) * radius,
		y: Math.cos(angle * ANGLE_RATIO) * radius,
	};
}

function getBarHeightAndYAttr(yTop, zeroLine) {
	let height, y;
	if (yTop <= zeroLine) {
		height = zeroLine - yTop;
		y = yTop;
	} else {
		height = yTop - zeroLine;
		y = zeroLine;
	}

	return [height, y];
}

function equilizeNoOfElements(array1, array2,
	extraCount = array2.length - array1.length) {

	// Doesn't work if either has zero elements.
	if(extraCount > 0) {
		array1 = fillArray(array1, extraCount);
	} else {
		array2 = fillArray(array2, extraCount);
	}
	return [array1, array2];
}

const PRESET_COLOR_MAP = {
	'light-blue': '#7cd6fd',
	'blue': '#5e64ff',
	'violet': '#743ee2',
	'red': '#ff5858',
	'orange': '#ffa00a',
	'yellow': '#feef72',
	'green': '#28a745',
	'light-green': '#98d85b',
	'purple': '#b554ff',
	'magenta': '#ffa3ef',
	'black': '#36114C',
	'grey': '#bdd3e6',
	'light-grey': '#f0f4f7',
	'dark-grey': '#b8c2cc'
};

function limitColor(r){
	if (r > 255) return 255;
	else if (r < 0) return 0;
	return r;
}

function lightenDarkenColor(color, amt) {
	let col = getColor(color);
	let usePound = false;
	if (col[0] == "#") {
		col = col.slice(1);
		usePound = true;
	}
	let num = parseInt(col,16);
	let r = limitColor((num >> 16) + amt);
	let b = limitColor(((num >> 8) & 0x00FF) + amt);
	let g = limitColor((num & 0x0000FF) + amt);
	return (usePound?"#":"") + (g | (b << 8) | (r << 16)).toString(16);
}

function isValidColor(string) {
	// https://stackoverflow.com/a/8027444/6495043
	return /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(string);
}

const getColor = (color) => {
	return PRESET_COLOR_MAP[color] || color;
};

const AXIS_TICK_LENGTH = 6;
const LABEL_MARGIN = 4;
const FONT_SIZE = 10;
const BASE_LINE_COLOR = '#dadada';
const FONT_FILL = '#555b51';

function $$1(expr, con) {
	return typeof expr === "string"? (con || document).querySelector(expr) : expr || null;
}

function createSVG(tag, o) {
	var element = document.createElementNS("http://www.w3.org/2000/svg", tag);

	for (var i in o) {
		var val = o[i];

		if (i === "inside") {
			$$1(val).appendChild(element);
		}
		else if (i === "around") {
			var ref = $$1(val);
			ref.parentNode.insertBefore(element, ref);
			element.appendChild(ref);

		} else if (i === "styles") {
			if(typeof val === "object") {
				Object.keys(val).map(prop => {
					element.style[prop] = val[prop];
				});
			}
		} else {
			if(i === "className") { i = "class"; }
			if(i === "innerHTML") {
				element['textContent'] = val;
			} else {
				element.setAttribute(i, val);
			}
		}
	}

	return element;
}

function renderVerticalGradient(svgDefElem, gradientId) {
	return createSVG('linearGradient', {
		inside: svgDefElem,
		id: gradientId,
		x1: 0,
		x2: 0,
		y1: 0,
		y2: 1
	});
}

function setGradientStop(gradElem, offset, color, opacity) {
	return createSVG('stop', {
		'inside': gradElem,
		'style': `stop-color: ${color}`,
		'offset': offset,
		'stop-opacity': opacity
	});
}

function makeSVGContainer(parent, className, width, height) {
	return createSVG('svg', {
		className: className,
		inside: parent,
		width: width,
		height: height
	});
}

function makeSVGDefs(svgContainer) {
	return createSVG('defs', {
		inside: svgContainer,
	});
}

function makeSVGGroup(className, transform='', parent=undefined) {
	let args = {
		className: className,
		transform: transform
	};
	if(parent) args.inside = parent;
	return createSVG('g', args);
}



function makePath(pathStr, className='', stroke='none', fill='none') {
	return createSVG('path', {
		className: className,
		d: pathStr,
		styles: {
			stroke: stroke,
			fill: fill
		}
	});
}

function makeArcPathStr(startPosition, endPosition, center, radius, clockWise=1){
	let [arcStartX, arcStartY] = [center.x + startPosition.x, center.y + startPosition.y];
	let [arcEndX, arcEndY] = [center.x + endPosition.x, center.y + endPosition.y];

	return `M${center.x} ${center.y}
		L${arcStartX} ${arcStartY}
		A ${radius} ${radius} 0 0 ${clockWise ? 1 : 0}
		${arcEndX} ${arcEndY} z`;
}

function makeGradient(svgDefElem, color, lighter = false) {
	let gradientId ='path-fill-gradient' + '-' + color + '-' +(lighter ? 'lighter' : 'default');
	let gradientDef = renderVerticalGradient(svgDefElem, gradientId);
	let opacities = [1, 0.6, 0.2];
	if(lighter) {
		opacities = [0.4, 0.2, 0];
	}

	setGradientStop(gradientDef, "0%", color, opacities[0]);
	setGradientStop(gradientDef, "50%", color, opacities[1]);
	setGradientStop(gradientDef, "100%", color, opacities[2]);

	return gradientId;
}

function percentageBar(x, y, width, height,
	depth=PERCENTAGE_BAR_DEFAULT_DEPTH, fill='none') {

	let args = {
		className: 'percentage-bar',
		x: x,
		y: y,
		width: width,
		height: height,
		fill: fill,
		styles: {
			'stroke': lightenDarkenColor(fill, -25),
			// Diabolically good: https://stackoverflow.com/a/9000859
			// https://developer.mozilla.org/en-US/docs/Web/SVG/Attribute/stroke-dasharray
			'stroke-dasharray': `0, ${height + width}, ${width}, ${height}`,
			'stroke-width': depth
		},
	};

	return createSVG("rect", args);
}

function heatSquare(className, x, y, size, fill='none', data={}) {
	let args = {
		className: className,
		x: x,
		y: y,
		width: size,
		height: size,
		fill: fill
	};

	Object.keys(data).map(key => {
		args[key] = data[key];
	});

	return createSVG("rect", args);
}

function legendBar(x, y, size, fill='none', label) {
	let args = {
		className: 'legend-bar',
		x: 0,
		y: 0,
		width: size,
		height: '2px',
		fill: fill
	};
	let text = createSVG('text', {
		className: 'legend-dataset-text',
		x: 0,
		y: 0,
		dy: (FONT_SIZE * 2) + 'px',
		'font-size': (FONT_SIZE * 1.2) + 'px',
		'text-anchor': 'start',
		fill: FONT_FILL,
		innerHTML: label
	});

	let group = createSVG('g', {
		transform: `translate(${x}, ${y})`
	});
	group.appendChild(createSVG("rect", args));
	group.appendChild(text);

	return group;
}

function legendDot(x, y, size, fill='none', label) {
	let args = {
		className: 'legend-dot',
		cx: 0,
		cy: 0,
		r: size,
		fill: fill
	};
	let text = createSVG('text', {
		className: 'legend-dataset-text',
		x: 0,
		y: 0,
		dx: (FONT_SIZE) + 'px',
		dy: (FONT_SIZE/3) + 'px',
		'font-size': (FONT_SIZE * 1.2) + 'px',
		'text-anchor': 'start',
		fill: FONT_FILL,
		innerHTML: label
	});

	let group = createSVG('g', {
		transform: `translate(${x}, ${y})`
	});
	group.appendChild(createSVG("circle", args));
	group.appendChild(text);

	return group;
}

function makeText(className, x, y, content, options = {}) {
	let fontSize = options.fontSize || FONT_SIZE;
	let dy = options.dy !== undefined ? options.dy : (fontSize / 2);
	let fill = options.fill || FONT_FILL;
	let textAnchor = options.textAnchor || 'start';
	return createSVG('text', {
		className: className,
		x: x,
		y: y,
		dy: dy + 'px',
		'font-size': fontSize + 'px',
		fill: fill,
		'text-anchor': textAnchor,
		innerHTML: content
	});
}

function makeVertLine(x, label, y1, y2, options={}) {
	if(!options.stroke) options.stroke = BASE_LINE_COLOR;
	let l = createSVG('line', {
		className: 'line-vertical ' + options.className,
		x1: 0,
		x2: 0,
		y1: y1,
		y2: y2,
		styles: {
			stroke: options.stroke
		}
	});

	let text = createSVG('text', {
		x: 0,
		y: y1 > y2 ? y1 + LABEL_MARGIN : y1 - LABEL_MARGIN - FONT_SIZE,
		dy: FONT_SIZE + 'px',
		'font-size': FONT_SIZE + 'px',
		'text-anchor': 'middle',
		innerHTML: label + ""
	});

	let line = createSVG('g', {
		transform: `translate(${ x }, 0)`
	});

	line.appendChild(l);
	line.appendChild(text);

	return line;
}

function makeHoriLine(y, label, x1, x2, options={}) {
	if(!options.stroke) options.stroke = BASE_LINE_COLOR;
	if(!options.lineType) options.lineType = '';
	let className = 'line-horizontal ' + options.className +
		(options.lineType === "dashed" ? "dashed": "");

	let l = createSVG('line', {
		className: className,
		x1: x1,
		x2: x2,
		y1: 0,
		y2: 0,
		styles: {
			stroke: options.stroke
		}
	});

	let text = createSVG('text', {
		x: x1 < x2 ? x1 - LABEL_MARGIN : x1 + LABEL_MARGIN,
		y: 0,
		dy: (FONT_SIZE / 2 - 2) + 'px',
		'font-size': FONT_SIZE + 'px',
		'text-anchor': x1 < x2 ? 'end' : 'start',
		innerHTML: label+""
	});

	let line = createSVG('g', {
		transform: `translate(0, ${y})`,
		'stroke-opacity': 1
	});

	if(text === 0 || text === '0') {
		line.style.stroke = "rgba(27, 31, 35, 0.6)";
	}

	line.appendChild(l);
	line.appendChild(text);

	return line;
}

function yLine(y, label, width, options={}) {
	if(!options.pos) options.pos = 'left';
	if(!options.offset) options.offset = 0;
	if(!options.mode) options.mode = 'span';
	if(!options.stroke) options.stroke = BASE_LINE_COLOR;
	if(!options.className) options.className = '';

	let x1 = -1 * AXIS_TICK_LENGTH;
	let x2 = options.mode === 'span' ? width + AXIS_TICK_LENGTH : 0;

	if(options.mode === 'tick' && options.pos === 'right') {
		x1 = width + AXIS_TICK_LENGTH;
		x2 = width;
	}

	// let offset = options.pos === 'left' ? -1 * options.offset : options.offset;

	x1 += options.offset;
	x2 += options.offset;

	return makeHoriLine(y, label, x1, x2, {
		stroke: options.stroke,
		className: options.className,
		lineType: options.lineType
	});
}

function xLine(x, label, height, options={}) {
	if(!options.pos) options.pos = 'bottom';
	if(!options.offset) options.offset = 0;
	if(!options.mode) options.mode = 'span';
	if(!options.stroke) options.stroke = BASE_LINE_COLOR;
	if(!options.className) options.className = '';

	// Draw X axis line in span/tick mode with optional label
	//                        	y2(span)
	// 						|
	// 						|
	//				x line	|
	//						|
	// 					   	|
	// ---------------------+-- y2(tick)
	//						|
	//							y1

	let y1 = height + AXIS_TICK_LENGTH;
	let y2 = options.mode === 'span' ? -1 * AXIS_TICK_LENGTH : height;

	if(options.mode === 'tick' && options.pos === 'top') {
		// top axis ticks
		y1 = -1 * AXIS_TICK_LENGTH;
		y2 = 0;
	}

	return makeVertLine(x, label, y1, y2, {
		stroke: options.stroke,
		className: options.className,
		lineType: options.lineType
	});
}

function yMarker(y, label, width, options={}) {
	if(!options.labelPos) options.labelPos = 'right';
	let x = options.labelPos === 'left' ? LABEL_MARGIN
		: width - getStringWidth(label, 5) - LABEL_MARGIN;

	let labelSvg = createSVG('text', {
		className: 'chart-label',
		x: x,
		y: 0,
		dy: (FONT_SIZE / -2) + 'px',
		'font-size': FONT_SIZE + 'px',
		'text-anchor': 'start',
		innerHTML: label+""
	});

	let line = makeHoriLine(y, '', 0, width, {
		stroke: options.stroke || BASE_LINE_COLOR,
		className: options.className || '',
		lineType: options.lineType
	});

	line.appendChild(labelSvg);

	return line;
}

function yRegion(y1, y2, width, label, options={}) {
	// return a group
	let height = y1 - y2;

	let rect = createSVG('rect', {
		className: `bar mini`, // remove class
		styles: {
			fill: `rgba(228, 234, 239, 0.49)`,
			stroke: BASE_LINE_COLOR,
			'stroke-dasharray': `${width}, ${height}`
		},
		// 'data-point-index': index,
		x: 0,
		y: 0,
		width: width,
		height: height
	});

	if(!options.labelPos) options.labelPos = 'right';
	let x = options.labelPos === 'left' ? LABEL_MARGIN
		: width - getStringWidth(label+"", 4.5) - LABEL_MARGIN;

	let labelSvg = createSVG('text', {
		className: 'chart-label',
		x: x,
		y: 0,
		dy: (FONT_SIZE / -2) + 'px',
		'font-size': FONT_SIZE + 'px',
		'text-anchor': 'start',
		innerHTML: label+""
	});

	let region = createSVG('g', {
		transform: `translate(0, ${y2})`
	});

	region.appendChild(rect);
	region.appendChild(labelSvg);

	return region;
}

function datasetBar(x, yTop, width, color, label='', index=0, offset=0, meta={}) {
	let [height, y] = getBarHeightAndYAttr(yTop, meta.zeroLine);
	y -= offset;

	if(height === 0) {
		height = meta.minHeight;
		y -= meta.minHeight;
	}

	let rect = createSVG('rect', {
		className: `bar mini`,
		style: `fill: ${color}`,
		'data-point-index': index,
		x: x,
		y: y,
		width: width,
		height: height
	});

	label += "";

	if(!label && !label.length) {
		return rect;
	} else {
		rect.setAttribute('y', 0);
		rect.setAttribute('x', 0);
		let text = createSVG('text', {
			className: 'data-point-value',
			x: width/2,
			y: 0,
			dy: (FONT_SIZE / 2 * -1) + 'px',
			'font-size': FONT_SIZE + 'px',
			'text-anchor': 'middle',
			innerHTML: label
		});

		let group = createSVG('g', {
			'data-point-index': index,
			transform: `translate(${x}, ${y})`
		});
		group.appendChild(rect);
		group.appendChild(text);

		return group;
	}
}

function datasetDot(x, y, radius, color, label='', index=0) {
	let dot = createSVG('circle', {
		style: `fill: ${color}`,
		'data-point-index': index,
		cx: x,
		cy: y,
		r: radius
	});

	label += "";

	if(!label && !label.length) {
		return dot;
	} else {
		dot.setAttribute('cy', 0);
		dot.setAttribute('cx', 0);

		let text = createSVG('text', {
			className: 'data-point-value',
			x: 0,
			y: 0,
			dy: (FONT_SIZE / 2 * -1 - radius) + 'px',
			'font-size': FONT_SIZE + 'px',
			'text-anchor': 'middle',
			innerHTML: label
		});

		let group = createSVG('g', {
			'data-point-index': index,
			transform: `translate(${x}, ${y})`
		});
		group.appendChild(dot);
		group.appendChild(text);

		return group;
	}
}

function getPaths(xList, yList, color, options={}, meta={}) {
	let pointsList = yList.map((y, i) => (xList[i] + ',' + y));
	let pointsStr = pointsList.join("L");
	let path = makePath("M"+pointsStr, 'line-graph-path', color);

	// HeatLine
	if(options.heatline) {
		let gradient_id = makeGradient(meta.svgDefs, color);
		path.style.stroke = `url(#${gradient_id})`;
	}

	let paths = {
		path: path
	};

	// Region
	if(options.regionFill) {
		let gradient_id_region = makeGradient(meta.svgDefs, color, true);

		let pathStr = "M" + `${xList[0]},${meta.zeroLine}L` + pointsStr + `L${xList.slice(-1)[0]},${meta.zeroLine}`;
		paths.region = makePath(pathStr, `region-fill`, 'none', `url(#${gradient_id_region})`);
	}

	return paths;
}

let makeOverlay = {
	'bar': (unit) => {
		let transformValue;
		if(unit.nodeName !== 'rect') {
			transformValue = unit.getAttribute('transform');
			unit = unit.childNodes[0];
		}
		let overlay = unit.cloneNode();
		overlay.style.fill = '#000000';
		overlay.style.opacity = '0.4';

		if(transformValue) {
			overlay.setAttribute('transform', transformValue);
		}
		return overlay;
	},

	'dot': (unit) => {
		let transformValue;
		if(unit.nodeName !== 'circle') {
			transformValue = unit.getAttribute('transform');
			unit = unit.childNodes[0];
		}
		let overlay = unit.cloneNode();
		let radius = unit.getAttribute('r');
		let fill = unit.getAttribute('fill');
		overlay.setAttribute('r', parseInt(radius) + DOT_OVERLAY_SIZE_INCR);
		overlay.setAttribute('fill', fill);
		overlay.style.opacity = '0.6';

		if(transformValue) {
			overlay.setAttribute('transform', transformValue);
		}
		return overlay;
	},

	'heat_square': (unit) => {
		let transformValue;
		if(unit.nodeName !== 'circle') {
			transformValue = unit.getAttribute('transform');
			unit = unit.childNodes[0];
		}
		let overlay = unit.cloneNode();
		let radius = unit.getAttribute('r');
		let fill = unit.getAttribute('fill');
		overlay.setAttribute('r', parseInt(radius) + DOT_OVERLAY_SIZE_INCR);
		overlay.setAttribute('fill', fill);
		overlay.style.opacity = '0.6';

		if(transformValue) {
			overlay.setAttribute('transform', transformValue);
		}
		return overlay;
	}
};

let updateOverlay = {
	'bar': (unit, overlay) => {
		let transformValue;
		if(unit.nodeName !== 'rect') {
			transformValue = unit.getAttribute('transform');
			unit = unit.childNodes[0];
		}
		let attributes = ['x', 'y', 'width', 'height'];
		Object.values(unit.attributes)
			.filter(attr => attributes.includes(attr.name) && attr.specified)
			.map(attr => {
				overlay.setAttribute(attr.name, attr.nodeValue);
			});

		if(transformValue) {
			overlay.setAttribute('transform', transformValue);
		}
	},

	'dot': (unit, overlay) => {
		let transformValue;
		if(unit.nodeName !== 'circle') {
			transformValue = unit.getAttribute('transform');
			unit = unit.childNodes[0];
		}
		let attributes = ['cx', 'cy'];
		Object.values(unit.attributes)
			.filter(attr => attributes.includes(attr.name) && attr.specified)
			.map(attr => {
				overlay.setAttribute(attr.name, attr.nodeValue);
			});

		if(transformValue) {
			overlay.setAttribute('transform', transformValue);
		}
	},

	'heat_square': (unit, overlay) => {
		let transformValue;
		if(unit.nodeName !== 'circle') {
			transformValue = unit.getAttribute('transform');
			unit = unit.childNodes[0];
		}
		let attributes = ['cx', 'cy'];
		Object.values(unit.attributes)
			.filter(attr => attributes.includes(attr.name) && attr.specified)
			.map(attr => {
				overlay.setAttribute(attr.name, attr.nodeValue);
			});

		if(transformValue) {
			overlay.setAttribute('transform', transformValue);
		}
	},
};

const UNIT_ANIM_DUR = 350;
const PATH_ANIM_DUR = 350;
const MARKER_LINE_ANIM_DUR = UNIT_ANIM_DUR;
const REPLACE_ALL_NEW_DUR = 250;

const STD_EASING = 'easein';

function translate(unit, oldCoord, newCoord, duration) {
	let old = typeof oldCoord === 'string' ? oldCoord : oldCoord.join(', ');
	return [
		unit,
		{transform: newCoord.join(', ')},
		duration,
		STD_EASING,
		"translate",
		{transform: old}
	];
}

function translateVertLine(xLine, newX, oldX) {
	return translate(xLine, [oldX, 0], [newX, 0], MARKER_LINE_ANIM_DUR);
}

function translateHoriLine(yLine, newY, oldY) {
	return translate(yLine, [0, oldY], [0, newY], MARKER_LINE_ANIM_DUR);
}

function animateRegion(rectGroup, newY1, newY2, oldY2) {
	let newHeight = newY1 - newY2;
	let rect = rectGroup.childNodes[0];
	let width = rect.getAttribute("width");
	let rectAnim = [
		rect,
		{ height: newHeight, 'stroke-dasharray': `${width}, ${newHeight}` },
		MARKER_LINE_ANIM_DUR,
		STD_EASING
	];

	let groupAnim = translate(rectGroup, [0, oldY2], [0, newY2], MARKER_LINE_ANIM_DUR);
	return [rectAnim, groupAnim];
}

function animateBar(bar, x, yTop, width, offset=0, meta={}) {
	let [height, y] = getBarHeightAndYAttr(yTop, meta.zeroLine);
	y -= offset;
	if(bar.nodeName !== 'rect') {
		let rect = bar.childNodes[0];
		let rectAnim = [
			rect,
			{width: width, height: height},
			UNIT_ANIM_DUR,
			STD_EASING
		];

		let oldCoordStr = bar.getAttribute("transform").split("(")[1].slice(0, -1);
		let groupAnim = translate(bar, oldCoordStr, [x, y], MARKER_LINE_ANIM_DUR);
		return [rectAnim, groupAnim];
	} else {
		return [[bar, {width: width, height: height, x: x, y: y}, UNIT_ANIM_DUR, STD_EASING]];
	}
	// bar.animate({height: args.newHeight, y: yTop}, UNIT_ANIM_DUR, mina.easein);
}

function animateDot(dot, x, y) {
	if(dot.nodeName !== 'circle') {
		let oldCoordStr = dot.getAttribute("transform").split("(")[1].slice(0, -1);
		let groupAnim = translate(dot, oldCoordStr, [x, y], MARKER_LINE_ANIM_DUR);
		return [groupAnim];
	} else {
		return [[dot, {cx: x, cy: y}, UNIT_ANIM_DUR, STD_EASING]];
	}
	// dot.animate({cy: yTop}, UNIT_ANIM_DUR, mina.easein);
}

function animatePath(paths, newXList, newYList, zeroLine) {
	let pathComponents = [];

	let pointsStr = newYList.map((y, i) => (newXList[i] + ',' + y));
	let pathStr = pointsStr.join("L");

	const animPath = [paths.path, {d:"M"+pathStr}, PATH_ANIM_DUR, STD_EASING];
	pathComponents.push(animPath);

	if(paths.region) {
		let regStartPt = `${newXList[0]},${zeroLine}L`;
		let regEndPt = `L${newXList.slice(-1)[0]}, ${zeroLine}`;

		const animRegion = [
			paths.region,
			{d:"M" + regStartPt + pathStr + regEndPt},
			PATH_ANIM_DUR,
			STD_EASING
		];
		pathComponents.push(animRegion);
	}

	return pathComponents;
}

function animatePathStr(oldPath, pathStr) {
	return [oldPath, {d: pathStr}, UNIT_ANIM_DUR, STD_EASING];
}

// Leveraging SMIL Animations

const EASING = {
	ease: "0.25 0.1 0.25 1",
	linear: "0 0 1 1",
	// easein: "0.42 0 1 1",
	easein: "0.1 0.8 0.2 1",
	easeout: "0 0 0.58 1",
	easeinout: "0.42 0 0.58 1"
};

function animateSVGElement(element, props, dur, easingType="linear", type=undefined, oldValues={}) {

	let animElement = element.cloneNode(true);
	let newElement = element.cloneNode(true);

	for(var attributeName in props) {
		let animateElement;
		if(attributeName === 'transform') {
			animateElement = document.createElementNS("http://www.w3.org/2000/svg", "animateTransform");
		} else {
			animateElement = document.createElementNS("http://www.w3.org/2000/svg", "animate");
		}
		let currentValue = oldValues[attributeName] || element.getAttribute(attributeName);
		let value = props[attributeName];

		let animAttr = {
			attributeName: attributeName,
			from: currentValue,
			to: value,
			begin: "0s",
			dur: dur/1000 + "s",
			values: currentValue + ";" + value,
			keySplines: EASING[easingType],
			keyTimes: "0;1",
			calcMode: "spline",
			fill: 'freeze'
		};

		if(type) {
			animAttr["type"] = type;
		}

		for (var i in animAttr) {
			animateElement.setAttribute(i, animAttr[i]);
		}

		animElement.appendChild(animateElement);

		if(type) {
			newElement.setAttribute(attributeName, `translate(${value})`);
		} else {
			newElement.setAttribute(attributeName, value);
		}
	}

	return [animElement, newElement];
}

function transform(element, style) { // eslint-disable-line no-unused-vars
	element.style.transform = style;
	element.style.webkitTransform = style;
	element.style.msTransform = style;
	element.style.mozTransform = style;
	element.style.oTransform = style;
}

function animateSVG(svgContainer, elements) {
	let newElements = [];
	let animElements = [];

	elements.map(element => {
		let unit = element[0];
		let parent = unit.parentNode;

		let animElement, newElement;

		element[0] = unit;
		[animElement, newElement] = animateSVGElement(...element);

		newElements.push(newElement);
		animElements.push([animElement, parent]);

		parent.replaceChild(animElement, unit);
	});

	let animSvg = svgContainer.cloneNode(true);

	animElements.map((animElement, i) => {
		animElement[1].replaceChild(newElements[i], animElement[0]);
		elements[i][0] = newElements[i];
	});

	return animSvg;
}

function runSMILAnimation(parent, svgElement, elementsToAnimate) {
	if(elementsToAnimate.length === 0) return;

	let animSvgElement = animateSVG(svgElement, elementsToAnimate);
	if(svgElement.parentNode == parent) {
		parent.removeChild(svgElement);
		parent.appendChild(animSvgElement);

	}

	// Replace the new svgElement (data has already been replaced)
	setTimeout(() => {
		if(animSvgElement.parentNode == parent) {
			parent.removeChild(animSvgElement);
			parent.appendChild(svgElement);
		}
	}, REPLACE_ALL_NEW_DUR);
}

const CSSTEXT = ".chart-container{position:relative;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Oxygen','Ubuntu','Cantarell','Fira Sans','Droid Sans','Helvetica Neue',sans-serif}.chart-container .axis,.chart-container .chart-label{fill:#555b51}.chart-container .axis line,.chart-container .chart-label line{stroke:#dadada}.chart-container .dataset-units circle{stroke:#fff;stroke-width:2}.chart-container .dataset-units path{fill:none;stroke-opacity:1;stroke-width:2px}.chart-container .dataset-path{stroke-width:2px}.chart-container .path-group path{fill:none;stroke-opacity:1;stroke-width:2px}.chart-container line.dashed{stroke-dasharray:5,3}.chart-container .axis-line .specific-value{text-anchor:start}.chart-container .axis-line .y-line{text-anchor:end}.chart-container .axis-line .x-line{text-anchor:middle}.chart-container .legend-dataset-text{fill:#6c7680;font-weight:600}.graph-svg-tip{position:absolute;z-index:99999;padding:10px;font-size:12px;color:#959da5;text-align:center;background:rgba(0,0,0,.8);border-radius:3px}.graph-svg-tip ul{padding-left:0;display:flex}.graph-svg-tip ol{padding-left:0;display:flex}.graph-svg-tip ul.data-point-list li{min-width:90px;flex:1;font-weight:600}.graph-svg-tip strong{color:#dfe2e5;font-weight:600}.graph-svg-tip .svg-pointer{position:absolute;height:5px;margin:0 0 0 -5px;content:' ';border:5px solid transparent;border-top-color:rgba(0,0,0,.8)}.graph-svg-tip.comparison{padding:0;text-align:left;pointer-events:none}.graph-svg-tip.comparison .title{display:block;padding:10px;margin:0;font-weight:600;line-height:1;pointer-events:none}.graph-svg-tip.comparison ul{margin:0;white-space:nowrap;list-style:none}.graph-svg-tip.comparison li{display:inline-block;padding:5px 10px}";

function downloadFile(filename, data) {
	var a = document.createElement('a');
	a.style = "display: none";
	var blob = new Blob(data, {type: "image/svg+xml; charset=utf-8"});
	var url = window.URL.createObjectURL(blob);
	a.href = url;
	a.download = filename;
	document.body.appendChild(a);
	a.click();
	setTimeout(function(){
		document.body.removeChild(a);
		window.URL.revokeObjectURL(url);
	}, 300);
}

function prepareForExport(svg) {
	let clone = svg.cloneNode(true);
	clone.classList.add('chart-container');
	clone.setAttribute('xmlns', "http://www.w3.org/2000/svg");
	clone.setAttribute('xmlns:xlink', "http://www.w3.org/1999/xlink");
	let styleEl = $.create('style', {
		'innerHTML': CSSTEXT
	});
	clone.insertBefore(styleEl, clone.firstChild);

	let container = $.create('div');
	container.appendChild(clone);

	return container.innerHTML;
}

let BOUND_DRAW_FN;

class BaseChart {
	constructor(parent, options) {

		this.parent = typeof parent === 'string'
			? document.querySelector(parent)
			: parent;

		if (!(this.parent instanceof HTMLElement)) {
			throw new Error('No `parent` element to render on was provided.');
		}

		this.rawChartArgs = options;

		this.title = options.title || '';
		this.type = options.type || '';

		this.realData = this.prepareData(options.data);
		this.data = this.prepareFirstData(this.realData);

		this.colors = this.validateColors(options.colors, this.type);

		this.config = {
			showTooltip: 1, // calculate
			showLegend: 1, // calculate
			isNavigable: options.isNavigable || 0,
			animate: 1
		};

		this.measures = JSON.parse(JSON.stringify(BASE_MEASURES));
		let m = this.measures;
		this.setMeasures(options);
		if(!this.title.length) { m.titleHeight = 0; }
		if(!this.config.showLegend) m.legendHeight = 0;
		this.argHeight = options.height || m.baseHeight;

		this.state = {};
		this.options = {};

		this.initTimeout = INIT_CHART_UPDATE_TIMEOUT;

		if(this.config.isNavigable) {
			this.overlays = [];
		}

		this.configure(options);
	}

	prepareData(data) {
		return data;
	}

	prepareFirstData(data) {
		return data;
	}

	validateColors(colors, type) {
		const validColors = [];
		colors = (colors || []).concat(DEFAULT_COLORS[type]);
		colors.forEach((string) => {
			const color = getColor(string);
			if(!isValidColor(color)) {
				console.warn('"' + string + '" is not a valid color.');
			} else {
				validColors.push(color);
			}
		});
		return validColors;
	}

	setMeasures() {
		// Override measures, including those for title and legend
		// set config for legend and title
	}

	configure() {
		let height = this.argHeight;
		this.baseHeight = height;
		this.height = height - getExtraHeight(this.measures);

		// Bind window events
		BOUND_DRAW_FN = this.boundDrawFn.bind(this);
		window.addEventListener('resize', BOUND_DRAW_FN);
		window.addEventListener('orientationchange', this.boundDrawFn.bind(this));
	}

	boundDrawFn() {
		this.draw(true);
	}

	unbindWindowEvents() {
		window.removeEventListener('resize', BOUND_DRAW_FN);
		window.removeEventListener('orientationchange', this.boundDrawFn.bind(this));
	}

	// Has to be called manually
	setup() {
		this.makeContainer();
		this.updateWidth();
		this.makeTooltip();

		this.draw(false, true);
	}

	makeContainer() {
		// Chart needs a dedicated parent element
		this.parent.innerHTML = '';

		let args = {
			inside: this.parent,
			className: 'chart-container'
		};

		if(this.independentWidth) {
			args.styles = { width: this.independentWidth + 'px' };
		}

		this.container = $.create('div', args);
	}

	makeTooltip() {
		this.tip = new SvgTip({
			parent: this.container,
			colors: this.colors
		});
		this.bindTooltip();
	}

	bindTooltip() {}

	draw(onlyWidthChange=false, init=false) {
		this.updateWidth();

		this.calc(onlyWidthChange);
		this.makeChartArea();
		this.setupComponents();

		this.components.forEach(c => c.setup(this.drawArea));
		// this.components.forEach(c => c.make());
		this.render(this.components, false);

		if(init) {
			this.data = this.realData;
			setTimeout(() => {this.update(this.data);}, this.initTimeout);
		}

		this.renderLegend();

		this.setupNavigation(init);
	}

	calc() {} // builds state

	updateWidth() {
		this.baseWidth = getElementContentWidth(this.parent);
		this.width = this.baseWidth - getExtraWidth(this.measures);
	}

	makeChartArea() {
		if(this.svg) {
			this.container.removeChild(this.svg);
		}
		let m = this.measures;

		this.svg = makeSVGContainer(
			this.container,
			'frappe-chart chart',
			this.baseWidth,
			this.baseHeight
		);
		this.svgDefs = makeSVGDefs(this.svg);

		if(this.title.length) {
			this.titleEL = makeText(
				'title',
				m.margins.left,
				m.margins.top,
				this.title,
				{
					fontSize: m.titleFontSize,
					fill: '#666666',
					dy: m.titleFontSize
				}
			);
		}

		let top = getTopOffset(m);
		this.drawArea = makeSVGGroup(
			this.type + '-chart chart-draw-area',
			`translate(${getLeftOffset(m)}, ${top})`
		);

		if(this.config.showLegend) {
			top += this.height + m.paddings.bottom;
			this.legendArea = makeSVGGroup(
				'chart-legend',
				`translate(${getLeftOffset(m)}, ${top})`
			);
		}

		if(this.title.length) { this.svg.appendChild(this.titleEL); }
		this.svg.appendChild(this.drawArea);
		if(this.config.showLegend) { this.svg.appendChild(this.legendArea); }

		this.updateTipOffset(getLeftOffset(m), getTopOffset(m));
	}

	updateTipOffset(x, y) {
		this.tip.offset = {
			x: x,
			y: y
		};
	}

	setupComponents() { this.components = new Map(); }

	update(data) {
		if(!data) {
			console.error('No data to update.');
		}
		this.data = this.prepareData(data);
		this.calc(); // builds state
		this.render();
	}

	render(components=this.components, animate=true) {
		if(this.config.isNavigable) {
			// Remove all existing overlays
			this.overlays.map(o => o.parentNode.removeChild(o));
			// ref.parentNode.insertBefore(element, ref);
		}
		let elementsToAnimate = [];
		// Can decouple to this.refreshComponents() first to save animation timeout
		components.forEach(c => {
			elementsToAnimate = elementsToAnimate.concat(c.update(animate));
		});
		if(elementsToAnimate.length > 0) {
			runSMILAnimation(this.container, this.svg, elementsToAnimate);
			setTimeout(() => {
				components.forEach(c => c.make());
				this.updateNav();
			}, CHART_POST_ANIMATE_TIMEOUT);
		} else {
			components.forEach(c => c.make());
			this.updateNav();
		}
	}

	updateNav() {
		if(this.config.isNavigable) {
			this.makeOverlay();
			this.bindUnits();
		}
	}

	renderLegend() {}

	setupNavigation(init=false) {
		if(!this.config.isNavigable) return;

		if(init) {
			this.bindOverlay();

			this.keyActions = {
				'13': this.onEnterKey.bind(this),
				'37': this.onLeftArrow.bind(this),
				'38': this.onUpArrow.bind(this),
				'39': this.onRightArrow.bind(this),
				'40': this.onDownArrow.bind(this),
			};

			document.addEventListener('keydown', (e) => {
				if(isElementInViewport(this.container)) {
					e = e || window.event;
					if(this.keyActions[e.keyCode]) {
						this.keyActions[e.keyCode]();
					}
				}
			});
		}
	}

	makeOverlay() {}
	updateOverlay() {}
	bindOverlay() {}
	bindUnits() {}

	onLeftArrow() {}
	onRightArrow() {}
	onUpArrow() {}
	onDownArrow() {}
	onEnterKey() {}

	addDataPoint() {}
	removeDataPoint() {}

	getDataPoint() {}
	setCurrentDataPoint() {}

	updateDataset() {}

	export() {
		let chartSvg = prepareForExport(this.svg);
		downloadFile(this.title || 'Chart', [chartSvg]);
	}
}

class AggregationChart extends BaseChart {
	constructor(parent, args) {
		super(parent, args);
	}

	configure(args) {
		super.configure(args);

		this.config.maxSlices = args.maxSlices || 20;
		this.config.maxLegendPoints = args.maxLegendPoints || 20;
	}

	calc() {
		let s = this.state;
		let maxSlices = this.config.maxSlices;
		s.sliceTotals = [];

		let allTotals = this.data.labels.map((label, i) => {
			let total = 0;
			this.data.datasets.map(e => {
				total += e.values[i];
			});
			return [total, label];
		}).filter(d => { return d[0] >= 0; }); // keep only positive results

		let totals = allTotals;
		if(allTotals.length > maxSlices) {
			// Prune and keep a grey area for rest as per maxSlices
			allTotals.sort((a, b) => { return b[0] - a[0]; });

			totals = allTotals.slice(0, maxSlices-1);
			let remaining = allTotals.slice(maxSlices-1);

			let sumOfRemaining = 0;
			remaining.map(d => {sumOfRemaining += d[0];});
			totals.push([sumOfRemaining, 'Rest']);
			this.colors[maxSlices-1] = 'grey';
		}

		s.labels = [];
		totals.map(d => {
			s.sliceTotals.push(d[0]);
			s.labels.push(d[1]);
		});

		s.grandTotal = s.sliceTotals.reduce((a, b) => a + b, 0);

		this.center = {
			x: this.width / 2,
			y: this.height / 2
		};
	}

	renderLegend() {
		let s = this.state;
		this.legendArea.textContent = '';
		this.legendTotals = s.sliceTotals.slice(0, this.config.maxLegendPoints);

		let count = 0;
		let y = 0;
		this.legendTotals.map((d, i) => {
			let barWidth = 110;
			let divisor = Math.floor(
				(this.width - getExtraWidth(this.measures))/barWidth
			);
			if(count > divisor) {
				count = 0;
				y += 20;
			}
			let x = barWidth * count + 5;
			let dot = legendDot(
				x,
				y,
				5,
				this.colors[i],
				`${s.labels[i]}: ${d}`
			);
			this.legendArea.appendChild(dot);
			count++;
		});
	}
}

// Playing around with dates

const NO_OF_YEAR_MONTHS = 12;
const NO_OF_DAYS_IN_WEEK = 7;

const NO_OF_MILLIS = 1000;
const SEC_IN_DAY = 86400;

const MONTH_NAMES = ["January", "February", "March", "April", "May",
	"June", "July", "August", "September", "October", "November", "December"];


const DAY_NAMES_SHORT = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];


// https://stackoverflow.com/a/11252167/6495043
function treatAsUtc(date) {
	let result = new Date(date);
	result.setMinutes(result.getMinutes() - result.getTimezoneOffset());
	return result;
}

function getYyyyMmDd(date) {
	let dd = date.getDate();
	let mm = date.getMonth() + 1; // getMonth() is zero-based
	return [
		date.getFullYear(),
		(mm>9 ? '' : '0') + mm,
		(dd>9 ? '' : '0') + dd
	].join('-');
}

function clone(date) {
	return new Date(date.getTime());
}





// export function getMonthsBetween(startDate, endDate) {}

function getWeeksBetween(startDate, endDate) {
	let weekStartDate = setDayToSunday(startDate);
	return Math.ceil(getDaysBetween(weekStartDate, endDate) / NO_OF_DAYS_IN_WEEK);
}

function getDaysBetween(startDate, endDate) {
	let millisecondsPerDay = SEC_IN_DAY * NO_OF_MILLIS;
	return (treatAsUtc(endDate) - treatAsUtc(startDate)) / millisecondsPerDay;
}

function areInSameMonth(startDate, endDate) {
	return startDate.getMonth() === endDate.getMonth()
		&& startDate.getFullYear() === endDate.getFullYear();
}

function getMonthName(i, short=false) {
	let monthName = MONTH_NAMES[i];
	return short ? monthName.slice(0, 3) : monthName;
}

function getLastDateInMonth (month, year) {
	return new Date(year, month + 1, 0); // 0: last day in previous month
}

// mutates
function setDayToSunday(date) {
	let newDate = clone(date);
	const day = newDate.getDay();
	if(day !== 0) {
		addDays(newDate, (-1) * day);
	}
	return newDate;
}

// mutates
function addDays(date, numberOfDays) {
	date.setDate(date.getDate() + numberOfDays);
}

class ChartComponent {
	constructor({
		layerClass = '',
		layerTransform = '',
		constants,

		getData,
		makeElements,
		animateElements
	}) {
		this.layerTransform = layerTransform;
		this.constants = constants;

		this.makeElements = makeElements;
		this.getData = getData;

		this.animateElements = animateElements;

		this.store = [];
		this.labels = [];

		this.layerClass = layerClass;
		this.layerClass = typeof(this.layerClass) === 'function'
			? this.layerClass() : this.layerClass;

		this.refresh();
	}

	refresh(data) {
		this.data = data || this.getData();
	}

	setup(parent) {
		this.layer = makeSVGGroup(this.layerClass, this.layerTransform, parent);
	}

	make() {
		this.render(this.data);
		this.oldData = this.data;
	}

	render(data) {
		this.store = this.makeElements(data);

		this.layer.textContent = '';
		this.store.forEach(element => {
			this.layer.appendChild(element);
		});
		this.labels.forEach(element => {
			this.layer.appendChild(element);
		});
	}

	update(animate = true) {
		this.refresh();
		let animateElements = [];
		if(animate) {
			animateElements = this.animateElements(this.data) || [];
		}
		return animateElements;
	}
}

let componentConfigs = {
	pieSlices: {
		layerClass: 'pie-slices',
		makeElements(data) {
			return data.sliceStrings.map((s, i) =>{
				let slice = makePath(s, 'pie-path', 'none', data.colors[i]);
				slice.style.transition = 'transform .3s;';
				return slice;
			});
		},

		animateElements(newData) {
			return this.store.map((slice, i) =>
				animatePathStr(slice, newData.sliceStrings[i])
			);
		}
	},
	percentageBars: {
		layerClass: 'percentage-bars',
		makeElements(data) {
			return data.xPositions.map((x, i) =>{
				let y = 0;
				let bar = percentageBar(x, y, data.widths[i],
					this.constants.barHeight, this.constants.barDepth, data.colors[i]);
				return bar;
			});
		},

		animateElements(newData) {
			if(newData) return [];
		}
	},
	yAxis: {
		layerClass: 'y axis',
		makeElements(data) {
			return data.positions.map((position, i) =>
				yLine(position, data.labels[i], this.constants.width,
					{mode: this.constants.mode, pos: this.constants.pos})
			);
		},

		animateElements(newData) {
			let newPos = newData.positions;
			let newLabels = newData.labels;
			let oldPos = this.oldData.positions;
			let oldLabels = this.oldData.labels;

			[oldPos, newPos] = equilizeNoOfElements(oldPos, newPos);
			[oldLabels, newLabels] = equilizeNoOfElements(oldLabels, newLabels);

			this.render({
				positions: oldPos,
				labels: newLabels
			});

			return this.store.map((line, i) => {
				return translateHoriLine(
					line, newPos[i], oldPos[i]
				);
			});
		}
	},

	xAxis: {
		layerClass: 'x axis',
		makeElements(data) {
			return data.positions.map((position, i) =>
				xLine(position, data.calcLabels[i], this.constants.height,
					{mode: this.constants.mode, pos: this.constants.pos})
			);
		},

		animateElements(newData) {
			let newPos = newData.positions;
			let newLabels = newData.calcLabels;
			let oldPos = this.oldData.positions;
			let oldLabels = this.oldData.calcLabels;

			[oldPos, newPos] = equilizeNoOfElements(oldPos, newPos);
			[oldLabels, newLabels] = equilizeNoOfElements(oldLabels, newLabels);

			this.render({
				positions: oldPos,
				calcLabels: newLabels
			});

			return this.store.map((line, i) => {
				return translateVertLine(
					line, newPos[i], oldPos[i]
				);
			});
		}
	},

	yMarkers: {
		layerClass: 'y-markers',
		makeElements(data) {
			return data.map(m =>
				yMarker(m.position, m.label, this.constants.width,
					{labelPos: m.options.labelPos, mode: 'span', lineType: 'dashed'})
			);
		},
		animateElements(newData) {
			[this.oldData, newData] = equilizeNoOfElements(this.oldData, newData);

			let newPos = newData.map(d => d.position);
			let newLabels = newData.map(d => d.label);
			let newOptions = newData.map(d => d.options);

			let oldPos = this.oldData.map(d => d.position);

			this.render(oldPos.map((pos, i) => {
				return {
					position: oldPos[i],
					label: newLabels[i],
					options: newOptions[i]
				};
			}));

			return this.store.map((line, i) => {
				return translateHoriLine(
					line, newPos[i], oldPos[i]
				);
			});
		}
	},

	yRegions: {
		layerClass: 'y-regions',
		makeElements(data) {
			return data.map(r =>
				yRegion(r.startPos, r.endPos, this.constants.width,
					r.label, {labelPos: r.options.labelPos})
			);
		},
		animateElements(newData) {
			[this.oldData, newData] = equilizeNoOfElements(this.oldData, newData);

			let newPos = newData.map(d => d.endPos);
			let newLabels = newData.map(d => d.label);
			let newStarts = newData.map(d => d.startPos);
			let newOptions = newData.map(d => d.options);

			let oldPos = this.oldData.map(d => d.endPos);
			let oldStarts = this.oldData.map(d => d.startPos);

			this.render(oldPos.map((pos, i) => {
				return {
					startPos: oldStarts[i],
					endPos: oldPos[i],
					label: newLabels[i],
					options: newOptions[i]
				};
			}));

			let animateElements = [];

			this.store.map((rectGroup, i) => {
				animateElements = animateElements.concat(animateRegion(
					rectGroup, newStarts[i], newPos[i], oldPos[i]
				));
			});

			return animateElements;
		}
	},

	heatDomain: {
		layerClass: function() { return 'heat-domain domain-' + this.constants.index; },
		makeElements(data) {
			let {index, colWidth, rowHeight, squareSize, xTranslate} = this.constants;
			let monthNameHeight = -12;
			let x = xTranslate, y = 0;

			this.serializedSubDomains = [];

			data.cols.map((week, weekNo) => {
				if(weekNo === 1) {
					this.labels.push(
						makeText('domain-name', x, monthNameHeight, getMonthName(index, true).toUpperCase(),
							{
								fontSize: 9
							}
						)
					);
				}
				week.map((day, i) => {
					if(day.fill) {
						let data = {
							'data-date': day.yyyyMmDd,
							'data-value': day.dataValue,
							'data-day': i
						};
						let square = heatSquare('day', x, y, squareSize, day.fill, data);
						this.serializedSubDomains.push(square);
					}
					y += rowHeight;
				});
				y = 0;
				x += colWidth;
			});

			return this.serializedSubDomains;
		},

		animateElements(newData) {
			if(newData) return [];
		}
	},

	barGraph: {
		layerClass: function() { return 'dataset-units dataset-bars dataset-' + this.constants.index; },
		makeElements(data) {
			let c = this.constants;
			this.unitType = 'bar';
			this.units = data.yPositions.map((y, j) => {
				return datasetBar(
					data.xPositions[j],
					y,
					data.barWidth,
					c.color,
					data.labels[j],
					j,
					data.offsets[j],
					{
						zeroLine: data.zeroLine,
						barsWidth: data.barsWidth,
						minHeight: c.minHeight
					}
				);
			});
			return this.units;
		},
		animateElements(newData) {
			let newXPos = newData.xPositions;
			let newYPos = newData.yPositions;
			let newOffsets = newData.offsets;
			let newLabels = newData.labels;

			let oldXPos = this.oldData.xPositions;
			let oldYPos = this.oldData.yPositions;
			let oldOffsets = this.oldData.offsets;
			let oldLabels = this.oldData.labels;

			[oldXPos, newXPos] = equilizeNoOfElements(oldXPos, newXPos);
			[oldYPos, newYPos] = equilizeNoOfElements(oldYPos, newYPos);
			[oldOffsets, newOffsets] = equilizeNoOfElements(oldOffsets, newOffsets);
			[oldLabels, newLabels] = equilizeNoOfElements(oldLabels, newLabels);

			this.render({
				xPositions: oldXPos,
				yPositions: oldYPos,
				offsets: oldOffsets,
				labels: newLabels,

				zeroLine: this.oldData.zeroLine,
				barsWidth: this.oldData.barsWidth,
				barWidth: this.oldData.barWidth,
			});

			let animateElements = [];

			this.store.map((bar, i) => {
				animateElements = animateElements.concat(animateBar(
					bar, newXPos[i], newYPos[i], newData.barWidth, newOffsets[i],
					{zeroLine: newData.zeroLine}
				));
			});

			return animateElements;
		}
	},

	lineGraph: {
		layerClass: function() { return 'dataset-units dataset-line dataset-' + this.constants.index; },
		makeElements(data) {
			let c = this.constants;
			this.unitType = 'dot';
			this.paths = {};
			if(!c.hideLine) {
				this.paths = getPaths(
					data.xPositions,
					data.yPositions,
					c.color,
					{
						heatline: c.heatline,
						regionFill: c.regionFill
					},
					{
						svgDefs: c.svgDefs,
						zeroLine: data.zeroLine
					}
				);
			}

			this.units = [];
			if(!c.hideDots) {
				this.units = data.yPositions.map((y, j) => {
					return datasetDot(
						data.xPositions[j],
						y,
						data.radius,
						c.color,
						(c.valuesOverPoints ? data.values[j] : ''),
						j
					);
				});
			}

			return Object.values(this.paths).concat(this.units);
		},
		animateElements(newData) {
			let newXPos = newData.xPositions;
			let newYPos = newData.yPositions;
			let newValues = newData.values;

			let oldXPos = this.oldData.xPositions;
			let oldYPos = this.oldData.yPositions;
			let oldValues = this.oldData.values;

			[oldXPos, newXPos] = equilizeNoOfElements(oldXPos, newXPos);
			[oldYPos, newYPos] = equilizeNoOfElements(oldYPos, newYPos);
			[oldValues, newValues] = equilizeNoOfElements(oldValues, newValues);

			this.render({
				xPositions: oldXPos,
				yPositions: oldYPos,
				values: newValues,

				zeroLine: this.oldData.zeroLine,
				radius: this.oldData.radius,
			});

			let animateElements = [];

			if(Object.keys(this.paths).length) {
				animateElements = animateElements.concat(animatePath(
					this.paths, newXPos, newYPos, newData.zeroLine));
			}

			if(this.units.length) {
				this.units.map((dot, i) => {
					animateElements = animateElements.concat(animateDot(
						dot, newXPos[i], newYPos[i]));
				});
			}

			return animateElements;
		}
	}
};

function getComponent(name, constants, getData) {
	let keys = Object.keys(componentConfigs).filter(k => name.includes(k));
	let config = componentConfigs[keys[0]];
	Object.assign(config, {
		constants: constants,
		getData: getData
	});
	return new ChartComponent(config);
}

class PercentageChart extends AggregationChart {
	constructor(parent, args) {
		super(parent, args);
		this.type = 'percentage';
		this.setup();
	}

	setMeasures(options) {
		let m = this.measures;
		this.barOptions = options.barOptions || {};

		let b = this.barOptions;
		b.height = b.height || PERCENTAGE_BAR_DEFAULT_HEIGHT;
		b.depth = b.depth || PERCENTAGE_BAR_DEFAULT_DEPTH;

		m.paddings.right = 30;
		m.legendHeight = 80;
		m.baseHeight = (b.height + b.depth * 0.5) * 8;
	}

	setupComponents() {
		let s = this.state;

		let componentConfigs = [
			[
				'percentageBars',
				{
					barHeight: this.barOptions.height,
					barDepth: this.barOptions.depth,
				},
				function() {
					return {
						xPositions: s.xPositions,
						widths: s.widths,
						colors: this.colors
					};
				}.bind(this)
			]
		];

		this.components = new Map(componentConfigs
			.map(args => {
				let component = getComponent(...args);
				return [args[0], component];
			}));
	}

	calc() {
		super.calc();
		let s = this.state;

		s.xPositions = [];
		s.widths = [];

		let xPos = 0;
		s.sliceTotals.map((value) => {
			let width = this.width * value / s.grandTotal;
			s.widths.push(width);
			s.xPositions.push(xPos);
			xPos += width;
		});
	}

	makeDataByIndex() { }

	bindTooltip() {
		let s = this.state;
		this.container.addEventListener('mousemove', (e) => {
			let bars = this.components.get('percentageBars').store;
			let bar = e.target;
			if(bars.includes(bar)) {

				let i = bars.indexOf(bar);
				let gOff = getOffset(this.container), pOff = getOffset(bar);

				let x = pOff.left - gOff.left + parseInt(bar.getAttribute('width'))/2;
				let y = pOff.top - gOff.top;
				let title = (this.formattedLabels && this.formattedLabels.length>0
					? this.formattedLabels[i] : this.state.labels[i]) + ': ';
				let fraction = s.sliceTotals[i]/s.grandTotal;

				this.tip.setValues(x, y, {name: title, value: (fraction*100).toFixed(1) + "%"});
				this.tip.showTip();
			}
		});
	}
}

class PieChart extends AggregationChart {
	constructor(parent, args) {
		super(parent, args);
		this.type = 'pie';
		this.initTimeout = 0;
		this.init = 1;

		this.setup();
	}

	configure(args) {
		super.configure(args);
		this.mouseMove = this.mouseMove.bind(this);
		this.mouseLeave = this.mouseLeave.bind(this);

		this.hoverRadio = args.hoverRadio || 0.1;
		this.config.startAngle = args.startAngle || 0;

		this.clockWise = args.clockWise || false;
	}

	calc() {
		super.calc();
		let s = this.state;
		this.radius = (this.height > this.width ? this.center.x : this.center.y);

		const { radius, clockWise } = this;

		const prevSlicesProperties = s.slicesProperties || [];
		s.sliceStrings = [];
		s.slicesProperties = [];
		let curAngle = 180 - this.config.startAngle;

		s.sliceTotals.map((total, i) => {
			const startAngle = curAngle;
			const originDiffAngle = (total / s.grandTotal) * FULL_ANGLE;
			const diffAngle = clockWise ? -originDiffAngle : originDiffAngle;
			const endAngle = curAngle = curAngle + diffAngle;
			const startPosition = getPositionByAngle(startAngle, radius);
			const endPosition = getPositionByAngle(endAngle, radius);

			const prevProperty = this.init && prevSlicesProperties[i];

			let curStart,curEnd;
			if(this.init) {
				curStart = prevProperty ? prevProperty.startPosition : startPosition;
				curEnd = prevProperty ? prevProperty.endPosition : startPosition;
			} else {
				curStart = startPosition;
				curEnd = endPosition;
			}
			const curPath = makeArcPathStr(curStart, curEnd, this.center, this.radius, this.clockWise);

			s.sliceStrings.push(curPath);
			s.slicesProperties.push({
				startPosition,
				endPosition,
				value: total,
				total: s.grandTotal,
				startAngle,
				endAngle,
				angle: diffAngle
			});

		});
		this.init = 0;
	}

	setupComponents() {
		let s = this.state;

		let componentConfigs = [
			[
				'pieSlices',
				{ },
				function() {
					return {
						sliceStrings: s.sliceStrings,
						colors: this.colors
					};
				}.bind(this)
			]
		];

		this.components = new Map(componentConfigs
			.map(args => {
				let component = getComponent(...args);
				return [args[0], component];
			}));
	}

	calTranslateByAngle(property){
		const{radius,hoverRadio} = this;
		const position = getPositionByAngle(property.startAngle+(property.angle / 2),radius);
		return `translate3d(${(position.x) * hoverRadio}px,${(position.y) * hoverRadio}px,0)`;
	}

	hoverSlice(path,i,flag,e){
		if(!path) return;
		const color = this.colors[i];
		if(flag) {
			transform(path, this.calTranslateByAngle(this.state.slicesProperties[i]));
			path.style.fill = lightenDarkenColor(color, 50);
			let g_off = getOffset(this.svg);
			let x = e.pageX - g_off.left + 10;
			let y = e.pageY - g_off.top - 10;
			let title = (this.formatted_labels && this.formatted_labels.length > 0
				? this.formatted_labels[i] : this.state.labels[i]) + ': ';
			let percent = (this.state.sliceTotals[i] * 100 / this.state.grandTotal).toFixed(1);
			this.tip.setValues(x, y, {name: title, value: percent + "%"});
			this.tip.showTip();
		} else {
			transform(path,'translate3d(0,0,0)');
			this.tip.hideTip();
			path.style.fill = color;
		}
	}

	bindTooltip() {
		this.container.addEventListener('mousemove', this.mouseMove);
		this.container.addEventListener('mouseleave', this.mouseLeave);
	}

	mouseMove(e){
		const target = e.target;
		let slices = this.components.get('pieSlices').store;
		let prevIndex = this.curActiveSliceIndex;
		let prevAcitve = this.curActiveSlice;
		if(slices.includes(target)) {
			let i = slices.indexOf(target);
			this.hoverSlice(prevAcitve, prevIndex,false);
			this.curActiveSlice = target;
			this.curActiveSliceIndex = i;
			this.hoverSlice(target, i, true, e);
		} else {
			this.mouseLeave();
		}
	}

	mouseLeave(){
		this.hoverSlice(this.curActiveSlice,this.curActiveSliceIndex,false);
	}
}

function normalize(x) {
	// Calculates mantissa and exponent of a number
	// Returns normalized number and exponent
	// https://stackoverflow.com/q/9383593/6495043

	if(x===0) {
		return [0, 0];
	}
	if(isNaN(x)) {
		return {mantissa: -6755399441055744, exponent: 972};
	}
	var sig = x > 0 ? 1 : -1;
	if(!isFinite(x)) {
		return {mantissa: sig * 4503599627370496, exponent: 972};
	}

	x = Math.abs(x);
	var exp = Math.floor(Math.log10(x));
	var man = x/Math.pow(10, exp);

	return [sig * man, exp];
}

function getChartRangeIntervals(max, min=0) {
	let upperBound = Math.ceil(max);
	let lowerBound = Math.floor(min);
	let range = upperBound - lowerBound;

	let noOfParts = range;
	let partSize = 1;

	// To avoid too many partitions
	if(range > 5) {
		if(range % 2 !== 0) {
			upperBound++;
			// Recalc range
			range = upperBound - lowerBound;
		}
		noOfParts = range/2;
		partSize = 2;
	}

	// Special case: 1 and 2
	if(range <= 2) {
		noOfParts = 4;
		partSize = range/noOfParts;
	}

	// Special case: 0
	if(range === 0) {
		noOfParts = 5;
		partSize = 1;
	}

	let intervals = [];
	for(var i = 0; i <= noOfParts; i++){
		intervals.push(lowerBound + partSize * i);
	}
	return intervals;
}

function getChartIntervals(maxValue, minValue=0) {
	let [normalMaxValue, exponent] = normalize(maxValue);
	let normalMinValue = minValue ? minValue/Math.pow(10, exponent): 0;

	// Allow only 7 significant digits
	normalMaxValue = normalMaxValue.toFixed(6);

	let intervals = getChartRangeIntervals(normalMaxValue, normalMinValue);
	intervals = intervals.map(value => value * Math.pow(10, exponent));
	return intervals;
}

function calcChartIntervals(values, withMinimum=false) {
	//*** Where the magic happens ***

	// Calculates best-fit y intervals from given values
	// and returns the interval array

	let maxValue = Math.max(...values);
	let minValue = Math.min(...values);

	// Exponent to be used for pretty print
	let exponent = 0, intervals = []; // eslint-disable-line no-unused-vars

	function getPositiveFirstIntervals(maxValue, absMinValue) {
		let intervals = getChartIntervals(maxValue);

		let intervalSize = intervals[1] - intervals[0];

		// Then unshift the negative values
		let value = 0;
		for(var i = 1; value < absMinValue; i++) {
			value += intervalSize;
			intervals.unshift((-1) * value);
		}
		return intervals;
	}

	// CASE I: Both non-negative

	if(maxValue >= 0 && minValue >= 0) {
		exponent = normalize(maxValue)[1];
		if(!withMinimum) {
			intervals = getChartIntervals(maxValue);
		} else {
			intervals = getChartIntervals(maxValue, minValue);
		}
	}

	// CASE II: Only minValue negative

	else if(maxValue > 0 && minValue < 0) {
		// `withMinimum` irrelevant in this case,
		// We'll be handling both sides of zero separately
		// (both starting from zero)
		// Because ceil() and floor() behave differently
		// in those two regions

		let absMinValue = Math.abs(minValue);

		if(maxValue >= absMinValue) {
			exponent = normalize(maxValue)[1];
			intervals = getPositiveFirstIntervals(maxValue, absMinValue);
		} else {
			// Mirror: maxValue => absMinValue, then change sign
			exponent = normalize(absMinValue)[1];
			let posIntervals = getPositiveFirstIntervals(absMinValue, maxValue);
			intervals = posIntervals.map(d => d * (-1));
		}

	}

	// CASE III: Both non-positive

	else if(maxValue <= 0 && minValue <= 0) {
		// Mirrored Case I:
		// Work with positives, then reverse the sign and array

		let pseudoMaxValue = Math.abs(minValue);
		let pseudoMinValue = Math.abs(maxValue);

		exponent = normalize(pseudoMaxValue)[1];
		if(!withMinimum) {
			intervals = getChartIntervals(pseudoMaxValue);
		} else {
			intervals = getChartIntervals(pseudoMaxValue, pseudoMinValue);
		}

		intervals = intervals.reverse().map(d => d * (-1));
	}

	return intervals;
}

function getZeroIndex(yPts) {
	let zeroIndex;
	let interval = getIntervalSize(yPts);
	if(yPts.indexOf(0) >= 0) {
		// the range has a given zero
		// zero-line on the chart
		zeroIndex = yPts.indexOf(0);
	} else if(yPts[0] > 0) {
		// Minimum value is positive
		// zero-line is off the chart: below
		let min = yPts[0];
		zeroIndex = (-1) * min / interval;
	} else {
		// Maximum value is negative
		// zero-line is off the chart: above
		let max = yPts[yPts.length - 1];
		zeroIndex = (-1) * max / interval + (yPts.length - 1);
	}
	return zeroIndex;
}



function getIntervalSize(orderedArray) {
	return orderedArray[1] - orderedArray[0];
}

function getValueRange(orderedArray) {
	return orderedArray[orderedArray.length-1] - orderedArray[0];
}

function scale(val, yAxis) {
	return floatTwo(yAxis.zeroLine - val * yAxis.scaleMultiplier);
}





function getClosestInArray(goal, arr, index = false) {
	let closest = arr.reduce(function(prev, curr) {
		return (Math.abs(curr - goal) < Math.abs(prev - goal) ? curr : prev);
	});

	return index ? arr.indexOf(closest) : closest;
}

function calcDistribution(values, distributionSize) {
	// Assume non-negative values,
	// implying distribution minimum at zero

	let dataMaxValue = Math.max(...values);

	let distributionStep = 1 / (distributionSize - 1);
	let distribution = [];

	for(var i = 0; i < distributionSize; i++) {
		let checkpoint = dataMaxValue * (distributionStep * i);
		distribution.push(checkpoint);
	}

	return distribution;
}

function getMaxCheckpoint(value, distribution) {
	return distribution.filter(d => d < value).length;
}

const COL_WIDTH = HEATMAP_SQUARE_SIZE + HEATMAP_GUTTER_SIZE;
const ROW_HEIGHT = COL_WIDTH;
// const DAY_INCR = 1;

class Heatmap extends BaseChart {
	constructor(parent, options) {
		super(parent, options);
		this.type = 'heatmap';

		this.countLabel = options.countLabel || '';

		let validStarts = ['Sunday', 'Monday'];
		let startSubDomain = validStarts.includes(options.startSubDomain)
			? options.startSubDomain : 'Sunday';
		this.startSubDomainIndex = validStarts.indexOf(startSubDomain);

		this.setup();
	}

	setMeasures(options) {
		let m = this.measures;
		this.discreteDomains = options.discreteDomains === 0 ? 0 : 1;

		m.paddings.top = ROW_HEIGHT * 3;
		m.paddings.bottom = 0;
		m.legendHeight = ROW_HEIGHT * 2;
		m.baseHeight = ROW_HEIGHT * NO_OF_DAYS_IN_WEEK
			+ getExtraHeight(m);

		let d = this.data;
		let spacing = this.discreteDomains ? NO_OF_YEAR_MONTHS : 0;
		this.independentWidth = (getWeeksBetween(d.start, d.end)
			+ spacing) * COL_WIDTH + getExtraWidth(m);
	}

	updateWidth() {
		let spacing = this.discreteDomains ? NO_OF_YEAR_MONTHS : 0;
		let noOfWeeks = this.state.noOfWeeks ? this.state.noOfWeeks : 52;
		this.baseWidth = (noOfWeeks + spacing) * COL_WIDTH
			+ getExtraWidth(this.measures);
	}

	prepareData(data=this.data) {
		if(data.start && data.end && data.start > data.end) {
			throw new Error('Start date cannot be greater than end date.');
		}

		if(!data.start) {
			data.start = new Date();
			data.start.setFullYear( data.start.getFullYear() - 1 );
		}
		if(!data.end) { data.end = new Date(); }
		data.dataPoints = data.dataPoints || {};

		if(parseInt(Object.keys(data.dataPoints)[0]) > 100000) {
			let points = {};
			Object.keys(data.dataPoints).forEach(timestampSec$$1 => {
				let date = new Date(timestampSec$$1 * NO_OF_MILLIS);
				points[getYyyyMmDd(date)] = data.dataPoints[timestampSec$$1];
			});
			data.dataPoints = points;
		}

		return data;
	}

	calc() {
		let s = this.state;

		s.start = clone(this.data.start);
		s.end = clone(this.data.end);

		s.firstWeekStart = clone(s.start);
		s.noOfWeeks = getWeeksBetween(s.start, s.end);
		s.distribution = calcDistribution(
			Object.values(this.data.dataPoints), HEATMAP_DISTRIBUTION_SIZE);

		s.domainConfigs = this.getDomains();
	}

	setupComponents() {
		let s = this.state;
		let lessCol = this.discreteDomains ? 0 : 1;

		let componentConfigs = s.domainConfigs.map((config, i) => [
			'heatDomain',
			{
				index: config.index,
				colWidth: COL_WIDTH,
				rowHeight: ROW_HEIGHT,
				squareSize: HEATMAP_SQUARE_SIZE,
				xTranslate: s.domainConfigs
					.filter((config, j) => j < i)
					.map(config => config.cols.length - lessCol)
					.reduce((a, b) => a + b, 0)
					* COL_WIDTH
			},
			function() {
				return s.domainConfigs[i];
			}.bind(this)

		]);

		this.components = new Map(componentConfigs
			.map((args, i) => {
				let component = getComponent(...args);
				return [args[0] + '-' + i, component];
			})
		);

		let y = 0;
		DAY_NAMES_SHORT.forEach((dayName, i) => {
			if([1, 3, 5].includes(i)) {
				let dayText = makeText('subdomain-name', -COL_WIDTH/2, y, dayName,
					{
						fontSize: HEATMAP_SQUARE_SIZE,
						dy: 8,
						textAnchor: 'end'
					}
				);
				this.drawArea.appendChild(dayText);
			}
			y += ROW_HEIGHT;
		});
	}

	update(data) {
		if(!data) {
			console.error('No data to update.');
		}

		this.data = this.prepareData(data);
		this.draw();
		this.bindTooltip();
	}

	bindTooltip() {
		this.container.addEventListener('mousemove', (e) => {
			this.components.forEach(comp => {
				let daySquares = comp.store;
				let daySquare = e.target;
				if(daySquares.includes(daySquare)) {

					let count = daySquare.getAttribute('data-value');
					let dateParts = daySquare.getAttribute('data-date').split('-');

					let month = getMonthName(parseInt(dateParts[1])-1, true);

					let gOff = this.container.getBoundingClientRect(), pOff = daySquare.getBoundingClientRect();

					let width = parseInt(e.target.getAttribute('width'));
					let x = pOff.left - gOff.left + width/2;
					let y = pOff.top - gOff.top;
					let value = count + ' ' + this.countLabel;
					let name = ' on ' + month + ' ' + dateParts[0] + ', ' + dateParts[2];

					this.tip.setValues(x, y, {name: name, value: value, valueFirst: 1}, []);
					this.tip.showTip();
				}
			});
		});
	}

	renderLegend() {
		this.legendArea.textContent = '';
		let x = 0;
		let y = ROW_HEIGHT;

		let lessText = makeText('subdomain-name', x, y, 'Less',
			{
				fontSize: HEATMAP_SQUARE_SIZE + 1,
				dy: 9
			}
		);
		x = (COL_WIDTH * 2) + COL_WIDTH/2;
		this.legendArea.appendChild(lessText);

		this.colors.slice(0, HEATMAP_DISTRIBUTION_SIZE).map((color, i) => {
			const square = heatSquare('heatmap-legend-unit', x + (COL_WIDTH + 3) * i,
				y, HEATMAP_SQUARE_SIZE, color);
			this.legendArea.appendChild(square);
		});

		let moreTextX = x + HEATMAP_DISTRIBUTION_SIZE * (COL_WIDTH + 3) + COL_WIDTH/4;
		let moreText = makeText('subdomain-name', moreTextX, y, 'More',
			{
				fontSize: HEATMAP_SQUARE_SIZE + 1,
				dy: 9
			}
		);
		this.legendArea.appendChild(moreText);
	}

	getDomains() {
		let s = this.state;
		const [startMonth, startYear] = [s.start.getMonth(), s.start.getFullYear()];
		const [endMonth, endYear] = [s.end.getMonth(), s.end.getFullYear()];

		const noOfMonths = (endMonth - startMonth + 1) + (endYear - startYear) * 12;

		let domainConfigs = [];

		let startOfMonth = clone(s.start);
		for(var i = 0; i < noOfMonths; i++) {
			let endDate = s.end;
			if(!areInSameMonth(startOfMonth, s.end)) {
				let [month, year] = [startOfMonth.getMonth(), startOfMonth.getFullYear()];
				endDate = getLastDateInMonth(month, year);
			}
			domainConfigs.push(this.getDomainConfig(startOfMonth, endDate));

			addDays(endDate, 1);
			startOfMonth = endDate;
		}

		return domainConfigs;
	}

	getDomainConfig(startDate, endDate='') {
		let [month, year] = [startDate.getMonth(), startDate.getFullYear()];
		let startOfWeek = setDayToSunday(startDate); // TODO: Monday as well
		endDate = clone(endDate) || getLastDateInMonth(month, year);

		let domainConfig = {
			index: month,
			cols: []
		};

		addDays(endDate, 1);
		let noOfMonthWeeks = getWeeksBetween(startOfWeek, endDate);

		let cols = [], col;
		for(var i = 0; i < noOfMonthWeeks; i++) {
			col = this.getCol(startOfWeek, month);
			cols.push(col);

			startOfWeek = new Date(col[NO_OF_DAYS_IN_WEEK - 1].yyyyMmDd);
			addDays(startOfWeek, 1);
		}

		if(col[NO_OF_DAYS_IN_WEEK - 1].dataValue !== undefined) {
			addDays(startOfWeek, 1);
			cols.push(this.getCol(startOfWeek, month, true));
		}

		domainConfig.cols = cols;

		return domainConfig;
	}

	getCol(startDate, month, empty = false) {
		let s = this.state;

		// startDate is the start of week
		let currentDate = clone(startDate);
		let col = [];

		for(var i = 0; i < NO_OF_DAYS_IN_WEEK; i++, addDays(currentDate, 1)) {
			let config = {};

			// Non-generic adjustment for entire heatmap, needs state
			let currentDateWithinData = currentDate >= s.start && currentDate <= s.end;

			if(empty || currentDate.getMonth() !== month || !currentDateWithinData) {
				config.yyyyMmDd = getYyyyMmDd(currentDate);
			} else {
				config = this.getSubDomainConfig(currentDate);
			}
			col.push(config);
		}

		return col;
	}

	getSubDomainConfig(date) {
		let yyyyMmDd = getYyyyMmDd(date);
		let dataValue = this.data.dataPoints[yyyyMmDd];
		let config = {
			yyyyMmDd: yyyyMmDd,
			dataValue: dataValue || 0,
			fill: this.colors[getMaxCheckpoint(dataValue, this.state.distribution)]
		};
		return config;
	}
}

function dataPrep(data, type) {
	data.labels = data.labels || [];

	let datasetLength = data.labels.length;

	// Datasets
	let datasets = data.datasets;
	let zeroArray = new Array(datasetLength).fill(0);
	if(!datasets) {
		// default
		datasets = [{
			values: zeroArray
		}];
	}

	datasets.map(d=> {
		// Set values
		if(!d.values) {
			d.values = zeroArray;
		} else {
			// Check for non values
			let vals = d.values;
			vals = vals.map(val => (!isNaN(val) ? val : 0));

			// Trim or extend
			if(vals.length > datasetLength) {
				vals = vals.slice(0, datasetLength);
			} else {
				vals = fillArray(vals, datasetLength - vals.length, 0);
			}
		}

		// Set labels
		//

		// Set type
		if(!d.chartType ) {
			if(!AXIS_DATASET_CHART_TYPES.includes(type)) type === DEFAULT_AXIS_CHART_TYPE;
			d.chartType = type;
		}

	});

	// Markers

	// Regions
	// data.yRegions = data.yRegions || [];
	if(data.yRegions) {
		data.yRegions.map(d => {
			if(d.end < d.start) {
				[d.start, d.end] = [d.end, d.start];
			}
		});
	}

	return data;
}

function zeroDataPrep(realData) {
	let datasetLength = realData.labels.length;
	let zeroArray = new Array(datasetLength).fill(0);

	let zeroData = {
		labels: realData.labels.slice(0, -1),
		datasets: realData.datasets.map(d => {
			return {
				name: '',
				values: zeroArray.slice(0, -1),
				chartType: d.chartType
			};
		}),
	};

	if(realData.yMarkers) {
		zeroData.yMarkers = [
			{
				value: 0,
				label: ''
			}
		];
	}

	if(realData.yRegions) {
		zeroData.yRegions = [
			{
				start: 0,
				end: 0,
				label: ''
			}
		];
	}

	return zeroData;
}

function getShortenedLabels(chartWidth, labels=[], isSeries=true) {
	let allowedSpace = chartWidth / labels.length;
	if(allowedSpace <= 0) allowedSpace = 1;
	let allowedLetters = allowedSpace / DEFAULT_CHAR_WIDTH;

	let calcLabels = labels.map((label, i) => {
		label += "";
		if(label.length > allowedLetters) {

			if(!isSeries) {
				if(allowedLetters-3 > 0) {
					label = label.slice(0, allowedLetters-3) + " ...";
				} else {
					label = label.slice(0, allowedLetters) + '..';
				}
			} else {
				let multiple = Math.ceil(label.length/allowedLetters);
				if(i % multiple !== 0) {
					label = "";
				}
			}
		}
		return label;
	});

	return calcLabels;
}

class AxisChart extends BaseChart {
	constructor(parent, args) {
		super(parent, args);

		this.barOptions = args.barOptions || {};
		this.lineOptions = args.lineOptions || {};

		this.type = args.type || 'line';
		this.init = 1;

		this.setup();
	}

	setMeasures() {
		if(this.data.datasets.length <= 1) {
			this.config.showLegend = 0;
			this.measures.paddings.bottom = 30;
		}
	}

	configure(options) {
		super.configure(options);

		options.axisOptions = options.axisOptions || {};
		options.tooltipOptions = options.tooltipOptions || {};

		this.config.xAxisMode = options.axisOptions.xAxisMode || 'span';
		this.config.yAxisMode = options.axisOptions.yAxisMode || 'span';
		this.config.xIsSeries = options.axisOptions.xIsSeries || 0;

		this.config.formatTooltipX = options.tooltipOptions.formatTooltipX;
		this.config.formatTooltipY = options.tooltipOptions.formatTooltipY;

		this.config.valuesOverPoints = options.valuesOverPoints;
	}

	prepareData(data=this.data) {
		return dataPrep(data, this.type);
	}

	prepareFirstData(data=this.data) {
		return zeroDataPrep(data);
	}

	calc(onlyWidthChange = false) {
		this.calcXPositions();
		if(!onlyWidthChange) {
			this.calcYAxisParameters(this.getAllYValues(), this.type === 'line');
		}
		this.makeDataByIndex();
	}

	calcXPositions() {
		let s = this.state;
		let labels = this.data.labels;
		s.datasetLength = labels.length;

		s.unitWidth = this.width/(s.datasetLength);
		// Default, as per bar, and mixed. Only line will be a special case
		s.xOffset = s.unitWidth/2;

		// // For a pure Line Chart
		// s.unitWidth = this.width/(s.datasetLength - 1);
		// s.xOffset = 0;

		s.xAxis = {
			labels: labels,
			positions: labels.map((d, i) =>
				floatTwo(s.xOffset + i * s.unitWidth)
			)
		};
	}

	calcYAxisParameters(dataValues, withMinimum = 'false') {
		const yPts = calcChartIntervals(dataValues, withMinimum);
		const scaleMultiplier = this.height / getValueRange(yPts);
		const intervalHeight = getIntervalSize(yPts) * scaleMultiplier;
		const zeroLine = this.height - (getZeroIndex(yPts) * intervalHeight);

		this.state.yAxis = {
			labels: yPts,
			positions: yPts.map(d => zeroLine - d * scaleMultiplier),
			scaleMultiplier: scaleMultiplier,
			zeroLine: zeroLine,
		};

		// Dependent if above changes
		this.calcDatasetPoints();
		this.calcYExtremes();
		this.calcYRegions();
	}

	calcDatasetPoints() {
		let s = this.state;
		let scaleAll = values => values.map(val => scale(val, s.yAxis));

		s.datasets = this.data.datasets.map((d, i) => {
			let values = d.values;
			let cumulativeYs = d.cumulativeYs || [];
			return {
				name: d.name,
				index: i,
				chartType: d.chartType,

				values: values,
				yPositions: scaleAll(values),

				cumulativeYs: cumulativeYs,
				cumulativeYPos: scaleAll(cumulativeYs),
			};
		});
	}

	calcYExtremes() {
		let s = this.state;
		if(this.barOptions.stacked) {
			s.yExtremes = s.datasets[s.datasets.length - 1].cumulativeYPos;
			return;
		}
		s.yExtremes = new Array(s.datasetLength).fill(9999);
		s.datasets.map(d => {
			d.yPositions.map((pos, j) => {
				if(pos < s.yExtremes[j]) {
					s.yExtremes[j] = pos;
				}
			});
		});
	}

	calcYRegions() {
		let s = this.state;
		if(this.data.yMarkers) {
			this.state.yMarkers = this.data.yMarkers.map(d => {
				d.position = scale(d.value, s.yAxis);
				if(!d.options) d.options = {};
				// if(!d.label.includes(':')) {
				// 	d.label += ': ' + d.value;
				// }
				return d;
			});
		}
		if(this.data.yRegions) {
			this.state.yRegions = this.data.yRegions.map(d => {
				d.startPos = scale(d.start, s.yAxis);
				d.endPos = scale(d.end, s.yAxis);
				if(!d.options) d.options = {};
				return d;
			});
		}
	}

	getAllYValues() {
		let key = 'values';

		if(this.barOptions.stacked) {
			key = 'cumulativeYs';
			let cumulative = new Array(this.state.datasetLength).fill(0);
			this.data.datasets.map((d, i) => {
				let values = this.data.datasets[i].values;
				d[key] = cumulative = cumulative.map((c, i) => c + values[i]);
			});
		}

		let allValueLists = this.data.datasets.map(d => d[key]);
		if(this.data.yMarkers) {
			allValueLists.push(this.data.yMarkers.map(d => d.value));
		}
		if(this.data.yRegions) {
			this.data.yRegions.map(d => {
				allValueLists.push([d.end, d.start]);
			});
		}

		return [].concat(...allValueLists);
	}

	setupComponents() {
		let componentConfigs = [
			[
				'yAxis',
				{
					mode: this.config.yAxisMode,
					width: this.width,
					// pos: 'right'
				},
				function() {
					return this.state.yAxis;
				}.bind(this)
			],

			[
				'xAxis',
				{
					mode: this.config.xAxisMode,
					height: this.height,
					// pos: 'right'
				},
				function() {
					let s = this.state;
					s.xAxis.calcLabels = getShortenedLabels(this.width,
						s.xAxis.labels, this.config.xIsSeries);

					return s.xAxis;
				}.bind(this)
			],

			[
				'yRegions',
				{
					width: this.width,
					pos: 'right'
				},
				function() {
					return this.state.yRegions;
				}.bind(this)
			],
		];

		let barDatasets = this.state.datasets.filter(d => d.chartType === 'bar');
		let lineDatasets = this.state.datasets.filter(d => d.chartType === 'line');

		let barsConfigs = barDatasets.map(d => {
			let index = d.index;
			return [
				'barGraph' + '-' + d.index,
				{
					index: index,
					color: this.colors[index],
					stacked: this.barOptions.stacked,

					// same for all datasets
					valuesOverPoints: this.config.valuesOverPoints,
					minHeight: this.height * MIN_BAR_PERCENT_HEIGHT,
				},
				function() {
					let s = this.state;
					let d = s.datasets[index];
					let stacked = this.barOptions.stacked;

					let spaceRatio = this.barOptions.spaceRatio || BAR_CHART_SPACE_RATIO;
					let barsWidth = s.unitWidth * (1 - spaceRatio);
					let barWidth = barsWidth/(stacked ? 1 : barDatasets.length);

					let xPositions = s.xAxis.positions.map(x => x - barsWidth/2);
					if(!stacked) {
						xPositions = xPositions.map(p => p + barWidth * index);
					}

					let labels = new Array(s.datasetLength).fill('');
					if(this.config.valuesOverPoints) {
						if(stacked && d.index === s.datasets.length - 1) {
							labels = d.cumulativeYs;
						} else {
							labels = d.values;
						}
					}

					let offsets = new Array(s.datasetLength).fill(0);
					if(stacked) {
						offsets = d.yPositions.map((y, j) => y - d.cumulativeYPos[j]);
					}

					return {
						xPositions: xPositions,
						yPositions: d.yPositions,
						offsets: offsets,
						// values: d.values,
						labels: labels,

						zeroLine: s.yAxis.zeroLine,
						barsWidth: barsWidth,
						barWidth: barWidth,
					};
				}.bind(this)
			];
		});

		let lineConfigs = lineDatasets.map(d => {
			let index = d.index;
			return [
				'lineGraph' + '-' + d.index,
				{
					index: index,
					color: this.colors[index],
					svgDefs: this.svgDefs,
					heatline: this.lineOptions.heatline,
					regionFill: this.lineOptions.regionFill,
					hideDots: this.lineOptions.hideDots,
					hideLine: this.lineOptions.hideLine,

					// same for all datasets
					valuesOverPoints: this.config.valuesOverPoints,
				},
				function() {
					let s = this.state;
					let d = s.datasets[index];
					let minLine = s.yAxis.positions[0] < s.yAxis.zeroLine
						? s.yAxis.positions[0] : s.yAxis.zeroLine;

					return {
						xPositions: s.xAxis.positions,
						yPositions: d.yPositions,

						values: d.values,

						zeroLine: minLine,
						radius: this.lineOptions.dotSize || LINE_CHART_DOT_SIZE,
					};
				}.bind(this)
			];
		});

		let markerConfigs = [
			[
				'yMarkers',
				{
					width: this.width,
					pos: 'right'
				},
				function() {
					return this.state.yMarkers;
				}.bind(this)
			]
		];

		componentConfigs = componentConfigs.concat(barsConfigs, lineConfigs, markerConfigs);

		let optionals = ['yMarkers', 'yRegions'];
		this.dataUnitComponents = [];

		this.components = new Map(componentConfigs
			.filter(args => !optionals.includes(args[0]) || this.state[args[0]])
			.map(args => {
				let component = getComponent(...args);
				if(args[0].includes('lineGraph') || args[0].includes('barGraph')) {
					this.dataUnitComponents.push(component);
				}
				return [args[0], component];
			}));
	}

	makeDataByIndex() {
		this.dataByIndex = {};

		let s = this.state;
		let formatX = this.config.formatTooltipX;
		let formatY = this.config.formatTooltipY;
		let titles = s.xAxis.labels;

		titles.map((label, index) => {
			let values = this.state.datasets.map((set, i) => {
				let value = set.values[index];
				return {
					title: set.name,
					value: value,
					yPos: set.yPositions[index],
					color: this.colors[i],
					formatted: formatY ? formatY(value) : value,
				};
			});

			this.dataByIndex[index] = {
				label: label,
				formattedLabel: formatX ? formatX(label) : label,
				xPos: s.xAxis.positions[index],
				values: values,
				yExtreme: s.yExtremes[index],
			};
		});
	}

	bindTooltip() {
		// NOTE: could be in tooltip itself, as it is a given functionality for its parent
		this.container.addEventListener('mousemove', (e) => {
			let m = this.measures;
			let o = getOffset(this.container);
			let relX = e.pageX - o.left - getLeftOffset(m);
			let relY = e.pageY - o.top;

			if(relY < this.height + getTopOffset(m)
				&& relY >  getTopOffset(m)) {
				this.mapTooltipXPosition(relX);
			} else {
				this.tip.hideTip();
			}
		});
	}

	mapTooltipXPosition(relX) {
		let s = this.state;
		if(!s.yExtremes) return;

		let index = getClosestInArray(relX, s.xAxis.positions, true);
		let dbi = this.dataByIndex[index];

		this.tip.setValues(
			dbi.xPos + this.tip.offset.x,
			dbi.yExtreme + this.tip.offset.y,
			{name: dbi.formattedLabel, value: ''},
			dbi.values,
			index
		);

		this.tip.showTip();
	}

	renderLegend() {
		let s = this.data;
		if(s.datasets.length > 1) {
			this.legendArea.textContent = '';
			s.datasets.map((d, i) => {
				let barWidth = AXIS_LEGEND_BAR_SIZE;
				// let rightEndPoint = this.baseWidth - this.measures.margins.left - this.measures.margins.right;
				// let multiplier = s.datasets.length - i;
				let rect = legendBar(
					// rightEndPoint - multiplier * barWidth,	// To right align
					barWidth * i,
					'0',
					barWidth,
					this.colors[i],
					d.name);
				this.legendArea.appendChild(rect);
			});
		}
	}



	// Overlay
	makeOverlay() {
		if(this.init) {
			this.init = 0;
			return;
		}
		if(this.overlayGuides) {
			this.overlayGuides.forEach(g => {
				let o = g.overlay;
				o.parentNode.removeChild(o);
			});
		}

		this.overlayGuides = this.dataUnitComponents.map(c => {
			return {
				type: c.unitType,
				overlay: undefined,
				units: c.units,
			};
		});

		if(this.state.currentIndex === undefined) {
			this.state.currentIndex = this.state.datasetLength - 1;
		}

		// Render overlays
		this.overlayGuides.map(d => {
			let currentUnit = d.units[this.state.currentIndex];

			d.overlay = makeOverlay[d.type](currentUnit);
			this.drawArea.appendChild(d.overlay);
		});
	}

	updateOverlayGuides() {
		if(this.overlayGuides) {
			this.overlayGuides.forEach(g => {
				let o = g.overlay;
				o.parentNode.removeChild(o);
			});
		}
	}

	bindOverlay() {
		this.parent.addEventListener('data-select', () => {
			this.updateOverlay();
		});
	}

	bindUnits() {
		this.dataUnitComponents.map(c => {
			c.units.map(unit => {
				unit.addEventListener('click', () => {
					let index = unit.getAttribute('data-point-index');
					this.setCurrentDataPoint(index);
				});
			});
		});

		// Note: Doesn't work as tooltip is absolutely positioned
		this.tip.container.addEventListener('click', () => {
			let index = this.tip.container.getAttribute('data-point-index');
			this.setCurrentDataPoint(index);
		});
	}

	updateOverlay() {
		this.overlayGuides.map(d => {
			let currentUnit = d.units[this.state.currentIndex];
			updateOverlay[d.type](currentUnit, d.overlay);
		});
	}

	onLeftArrow() {
		this.setCurrentDataPoint(this.state.currentIndex - 1);
	}

	onRightArrow() {
		this.setCurrentDataPoint(this.state.currentIndex + 1);
	}

	getDataPoint(index=this.state.currentIndex) {
		let s = this.state;
		let data_point = {
			index: index,
			label: s.xAxis.labels[index],
			values: s.datasets.map(d => d.values[index])
		};
		return data_point;
	}

	setCurrentDataPoint(index) {
		let s = this.state;
		index = parseInt(index);
		if(index < 0) index = 0;
		if(index >= s.xAxis.labels.length) index = s.xAxis.labels.length - 1;
		if(index === s.currentIndex) return;
		s.currentIndex = index;
		fire(this.parent, "data-select", this.getDataPoint());
	}



	// API
	addDataPoint(label, datasetValues, index=this.state.datasetLength) {
		super.addDataPoint(label, datasetValues, index);
		this.data.labels.splice(index, 0, label);
		this.data.datasets.map((d, i) => {
			d.values.splice(index, 0, datasetValues[i]);
		});
		this.update(this.data);
	}

	removeDataPoint(index = this.state.datasetLength-1) {
		if (this.data.labels.length <= 1) {
			return;
		}
		super.removeDataPoint(index);
		this.data.labels.splice(index, 1);
		this.data.datasets.map(d => {
			d.values.splice(index, 1);
		});
		this.update(this.data);
	}

	updateDataset(datasetValues, index=0) {
		this.data.datasets[index].values = datasetValues;
		this.update(this.data);
	}
	// addDataset(dataset, index) {}
	// removeDataset(index = 0) {}

	updateDatasets(datasets) {
		this.data.datasets.map((d, i) => {
			if(datasets[i]) {
				d.values = datasets[i];
			}
		});
		this.update(this.data);
	}

	// updateDataPoint(dataPoint, index = 0) {}
	// addDataPoint(dataPoint, index = 0) {}
	// removeDataPoint(index = 0) {}
}

const chartTypes = {
	bar: AxisChart,
	line: AxisChart,
	// multiaxis: MultiAxisChart,
	percentage: PercentageChart,
	heatmap: Heatmap,
	pie: PieChart
};

function getChartByType(chartType = 'line', parent, options) {
	if (chartType === 'axis-mixed') {
		options.type = 'line';
		return new AxisChart(parent, options);
	}

	if (!chartTypes[chartType]) {
		console.error("Undefined chart type: " + chartType);
		return;
	}

	return new chartTypes[chartType](parent, options);
}

class Chart {
	constructor(parent, options) {
		return getChartByType(options.type, parent, options);
	}
}




/***/ }),

/***/ 132:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
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
        value: function connect() {}

        /**
         *
         * @param event
         */

    }, {
        key: 'submit',
        value: function submit(event) {
            this.setAllFilter();

            event.preventDefault();
        }

        /**
         *
         */

    }, {
        key: 'setAllFilter',
        value: function setAllFilter() {
            var params = {};

            document.querySelectorAll('[form="filters"]').forEach(function (element) {

                var name = element.name.trim();
                var value = element.value.trim();

                if (name !== '' && value !== null && value !== '' && value !== undefined) {

                    params[name] = value;
                }
            });

            var url = this.buildGetUrlParams(params);

            window.Turbolinks.visit(url, { action: 'replace' });
        }

        /**
         *
         * @param paramsObj
         * @returns {string}
         */

    }, {
        key: 'buildGetUrlParams',
        value: function buildGetUrlParams(paramsObj) {
            var builtUrl = window.location.origin + window.location.pathname + '?';
            Object.keys(paramsObj).forEach(function (key) {
                builtUrl += key + '=' + paramsObj[key] + '&';
            });
            return builtUrl.substr(0, builtUrl.length - 1);
        }

        /**
         *
         * @param event
         */

    }, {
        key: 'clear',
        value: function clear(event) {
            window.Turbolinks.visit(window.location.origin + window.location.pathname, { action: 'replace' });
            event.preventDefault();
        }

        /**
         *
         * @param event
         */

    }, {
        key: 'clearFilter',
        value: function clearFilter(event) {
            var filter = event.target.dataset.filter;
            document.querySelector('input[name=\'filter[' + filter + ']\']').value = '';

            this.element.remove();
            this.setAllFilter();
            event.preventDefault();
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 133:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
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
            var _this2 = this;

            axios.post(this.data.get('url') + '/' + this.data.get('method') + '/' + this.data.get('slug'), params).then(function (response) {
                _this2.element.querySelector('[data-async]').innerHTML = response.data;
            });
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["title"];
/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 134:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
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
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 135:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 41:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(42);
module.exports = __webpack_require__(135);


/***/ }),

/***/ 42:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_stimulus_webpack_helpers__ = __webpack_require__(19);



// remove
$.fn.select2.defaults.set('theme', 'bootstrap');

window.application = __WEBPACK_IMPORTED_MODULE_0_stimulus__["Application"].start();
var context = __webpack_require__(63);
application.load(Object(__WEBPACK_IMPORTED_MODULE_1_stimulus_webpack_helpers__["definitionsFromContext"])(context));
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 63:
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./components/boot_controller.js": 64,
	"./components/media_controller.js": 66,
	"./components/menu_controller.js": 68,
	"./fields/code_controller.js": 69,
	"./fields/datetime_controller.js": 70,
	"./fields/input_controller.js": 74,
	"./fields/map_controller.js": 79,
	"./fields/picture_controller.js": 80,
	"./fields/place_controller.js": 81,
	"./fields/relationship_controller.js": 82,
	"./fields/select_controller.js": 83,
	"./fields/simplemde_controller.js": 84,
	"./fields/tag_controller.js": 100,
	"./fields/tinymce_controller.js": 101,
	"./fields/upload_controller.js": 104,
	"./fields/utm_controller.js": 105,
	"./layouts/html_load_controller.js": 106,
	"./layouts/search_controller.js": 127,
	"./layouts/systems_controller.js": 128,
	"./screen/base_controller.js": 129,
	"./screen/chart_controller.js": 130,
	"./screen/filter_controller.js": 132,
	"./screen/modal_controller.js": 133,
	"./screen/tabs_controller.js": 134
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
webpackContext.id = 63;

/***/ }),

/***/ 64:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_blueimp_tmpl__ = __webpack_require__(65);
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

/***/ 65:
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

/***/ 66:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_dropzone__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_dropzone___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_dropzone__);
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
            var media = this;
            this.path = this.data.get('path');
            this.baseUrl = this.data.get('baseurl');
            this.CSRF_TOKEN = $('meta[name="csrf_token"]').attr('content');

            $('.media-file').on('click', '.media-view', function (event) {
                media.view(event.target);
            });

            $('.media-file').on('click', '.media-getlink', function (event) {
                media.get_link(event.target);
            });

            $('.media-file').on('click', '.media-delete', function (event) {
                media.delete(event.target);
            });

            $('.media-file').on('click', '.media-rename', function (event) {
                media.rename(event.target);
            });

            $('.media-file').on('click', '.media-move', function (event) {
                media.move(event.target);
            });

            $('#new_folder').click(function () {
                media.new_folder();
            });

            var DropzoneOptions = media.dropzone_options();
            __WEBPACK_IMPORTED_MODULE_1_dropzone___default.a.autoDiscover = false;

            var filemanagerDropzone = new __WEBPACK_IMPORTED_MODULE_1_dropzone___default.a('#filemanager', DropzoneOptions);
            var fileuploadDropzone = new __WEBPACK_IMPORTED_MODULE_1_dropzone___default.a('#upload', DropzoneOptions);
        }

        /**
         *
         * @param element
         */

        /**
         *
         * @type {string[]}
         */

    }, {
        key: "view",
        value: function view(element) {
            var data = $(element).closest('.media-file').data();

            if (data.type == 'directory') {
                data.src = "https://sun1-1.userapi.com/c830400/v830400092/caa37/Oavd1uZzq4Q.jpg";
            }
            this.load_view(data);
        }

        /**
         *
         * @param object
         */

    }, {
        key: "load_view",
        value: function load_view(object) {
            this.typeTarget.textContent = object.type;
            this.nameTarget.textContent = object.name;
            this.sizeTarget.textContent = object.size;
            this.modifiedTarget.textContent = object.modified;

            var elems = this.srcTarget.querySelectorAll("[src]");
            for (var i = 0; i < elems.length; i++) {
                elems[i].src = object.src;
            }

            elems = this.srcTarget.querySelectorAll("[href]");
            for (var i = 0; i < elems.length; i++) {
                elems[i].href = object.src;
            }

            this.srcTarget.querySelector('audio').load();
            this.srcTarget.querySelector('video').load();

            elems = this.srcTarget.querySelectorAll(".media-preview");
            for (var i = 0; i < elems.length; i++) {
                elems[i].style.display = "none";
            }

            var types = ["video", "audio", "directory", "image"];
            var yesType = false;
            var type = object.type;
            for (var i = 0; i < types.length; i++) {
                if (type.includes(types[i])) {
                    elems = this.srcTarget.querySelector('.media-' + types[i]);
                    yesType = true;
                }
            }
            if (!yesType) {
                elems = this.srcTarget.querySelector('.media-doc');
            }
            elems.style.display = "initial";
        }

        /**
         * @param element
         */

    }, {
        key: "get_link",
        value: function get_link(element) {
            var data = $(element).closest('.media-file').data();

            var tempInput = document.createElement("input");
            tempInput.style = "position: absolute; left: -1000px; top: -1000px";
            tempInput.value = data.src;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
        }
        /**
         * @param element
         */

    }, {
        key: "delete",
        value: function _delete(element) {
            var data = $(element).closest('.media-file').data();

            $('#confirm_delete_modal .folder_warning').hide();
            $('#confirm_delete_modal .confirm_delete_name').text(data.name);
            $('#confirm_delete_modal').data(data);
            $('#confirm_delete_modal').modal('show');
        }

        /**
         *
         */

    }, {
        key: "confirm_delete",
        value: function confirm_delete() {
            var data = $('#confirm_delete_modal').data();

            $('#confirm_delete_modal').modal('hide');
            $.post(this.baseUrl + "/delete_file_folder", {
                folder_location: this.path,
                file_folder: data.name,
                type: data.type,
                _token: this.CSRF_TOKEN
            }, function (_ref) {
                var success = _ref.success;

                window.Turbolinks.visit(window.location.toString(), { action: 'replace' });
            });
        }

        /**
         * @param element
         */

    }, {
        key: "rename",
        value: function rename(element) {
            var data = $(element).closest('.media-file').data();

            $('#rename_file_modal').data(data);
            $('#rename_file_modal .new_filename').val(data.name);
            $('#rename_file_modal').modal('show');
        }

        /**
         *
         */

    }, {
        key: "confirm_rename",
        value: function confirm_rename() {
            var data = $('#rename_file_modal').data();
            var new_filename = $('#rename_file_modal .new_filename').val();

            $('#rename_file_modal').modal('hide');
            $.post(this.baseUrl + "/rename_file", {
                folder_location: this.path,
                filename: data.name,
                new_filename: new_filename,
                _token: this.CSRF_TOKEN
            }, function (_ref2) {
                var success = _ref2.success,
                    error = _ref2.error;

                window.Turbolinks.visit(window.location.toString(), { action: 'replace' });
            });
        }

        /**
         * @param element
         */

    }, {
        key: "move",
        value: function move(element) {
            var data = $(element).closest('.media-file').data();

            $('#move_file_modal').data(data);
            $('#move_file_modal .move_file_name').text(data.name);
            $('#move_file_modal .move_folder').val(this.path);
            $('#move_file_modal').modal('show');
        }

        /**
         *
         */

    }, {
        key: "confirm_move",
        value: function confirm_move() {
            var data = $('#move_file_modal').data();
            var destination = $('#move_file_modal .move_folder').val() + "/" + data.name;

            $('#move_file_modal').modal('hide');
            $.post(this.baseUrl + "/move_file", {
                folder_location: this.path,
                source: data.name,
                destination: destination,
                _token: this.CSRF_TOKEN
            }, function (_ref3) {
                var success = _ref3.success,
                    error = _ref3.error;

                window.Turbolinks.visit(window.location.toString(), { action: 'replace' });
            });
        }

        /**
         *
         */

    }, {
        key: "new_folder",
        value: function new_folder() {
            $('#new_folder_modal').modal('show');
        }

        /**
         *
         */

    }, {
        key: "confirm_new_folder",
        value: function confirm_new_folder() {

            var new_folder_path = this.path + "/" + $('#new_folder_modal .new_folder_name').val();

            $('#new_folder_modal').modal('hide');
            $.post(this.baseUrl + "/new_folder", {
                new_folder: new_folder_path,
                _token: this.CSRF_TOKEN
            }, function (_ref4) {
                var success = _ref4.success;

                window.Turbolinks.visit(window.location.toString(), { action: 'replace' });
                $('#new_folder_modal .new_folder_name').val('');
            });
        }

        /**
         *
         */

    }, {
        key: "dropzone_options",
        value: function dropzone_options() {
            var CSRF_TOKEN = this.CSRF_TOKEN;
            var path = this.path;
            var previewTemplate = '<table><tr class="media-preview">' + '<td class="text-center no-padder media-view"><img class="img-responsive b" data-dz-thumbnail></td>' + '<td class="text-left media-view" data-dz-name></td><td></td>' + '<td class="text-right media-view" data-dz-size></td>' + '<td class="text-center dz-progress">' + '<div id="uploadProgress" class="progress active progress-striped" style="display: flex;">' + '<div class="progress-bar progress-bar-success" style="width: 0"></div></div></td>' + '</tr></table>';
            var loadProgress = document.createElement("div");

            return {
                url: this.baseUrl + "/upload",
                previewsContainer: '#filemanager table.table tbody',
                previewTemplate: previewTemplate,

                init: function init() {

                    this.on('addedfile', function (e) {
                        var div = document.createElement("div");
                        div.innerHTML = previewTemplate;
                        e.previewElement.parentNode.replaceChild(e.previewElement.childNodes[0].children[0], e.previewElement);
                        loadProgress = document.getElementById('uploadProgress').childNodes[0];
                    });
                    this.on('thumbnail', function (file, dataUrl) {
                        var thumbnailElements = document.querySelector('.media-preview').querySelectorAll("[data-dz-thumbnail]");
                        thumbnailElements[0].src = dataUrl;
                    });
                    this.on('totaluploadprogress', function (uploadProgress, totalBytes, totalBytesSent) {
                        loadProgress.style.width = uploadProgress + "%";
                    });

                    this.on('sending', function (file, xhr, formData) {
                        formData.append('_token', CSRF_TOKEN);
                        formData.append('upload_path', path);
                    });
                },
                success: function success(e, _ref5) {
                    var success = _ref5.success,
                        message = _ref5.message;

                    window.Turbolinks.visit(window.location.toString(), { action: 'replace' });
                    $('.media-preview').fadeOut();
                },
                error: function error(e, _ref6, xhr) {
                    var message = _ref6.message;

                    window.Turbolinks.visit(window.location.toString(), { action: 'replace' });
                }
            };
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["src", "type", "name", "size", "modified"];
/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 68:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
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

            $('#menuModal').modal('toggle');
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
            //window.Turbolinks.visit(window.location, {action: 'replace'});

            $('#menuModal').modal('toggle');
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
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 69:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_codeflask__ = __webpack_require__(20);
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

            var flask = new __WEBPACK_IMPORTED_MODULE_1_codeflask__["default"](this.element.querySelector('.code'), {
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

/***/ 70:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus_flatpickr__ = __webpack_require__(21);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus_flatpickr___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_stimulus_flatpickr__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_flatpickr_dist_plugins_rangePlugin_js__ = __webpack_require__(72);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_flatpickr_dist_plugins_rangePlugin_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_flatpickr_dist_plugins_rangePlugin_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_flatpickr_dist_l10n__ = __webpack_require__(73);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_flatpickr_dist_l10n___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_flatpickr_dist_l10n__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

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
        key: 'initialize',

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
                plugins: plugins
            };
        }

        /**
         *
         * @param selectedDates
         * @param dateStr
         * @param instance
         * @returns {*}
         */

    }, {
        key: 'change',
        value: function change(selectedDates, dateStr, instance) {
            return dateStr;
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus_flatpickr___default.a);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 72:
/***/ (function(module, exports, __webpack_require__) {

/* flatpickr v4.5.2, @license MIT */
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

/***/ 73:
/***/ (function(module, exports, __webpack_require__) {

/* flatpickr v4.5.2, @license MIT */
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
    var Khmer = {
      weekdays: {
        shorthand: ["អាទិត្យ", "ចន្ទ", "អង្គារ", "ពុធ", "ព្រហស.", "សុក្រ", "សៅរ៍"],
        longhand: ["អាទិត្យ", "ចន្ទ", "អង្គារ", "ពុធ", "ព្រហស្បតិ៍", "សុក្រ", "សៅរ៍"]
      },
      months: {
        shorthand: ["មករា", "កុម្ភះ", "មីនា", "មេសា", "ឧសភា", "មិថុនា", "កក្កដា", "សីហា", "កញ្ញា", "តុលា", "វិច្ឆិកា", "ធ្នូ"],
        longhand: ["មករា", "កុម្ភះ", "មីនា", "មេសា", "ឧសភា", "មិថុនា", "កក្កដា", "សីហា", "កញ្ញា", "តុលា", "វិច្ឆិកា", "ធ្នូ"]
      },
      ordinal: function ordinal() {
        return "";
      },
      firstDayOfWeek: 1,
      rangeSeparator: " ដល់ ",
      weekAbbreviation: "សប្តាហ៍",
      scrollTitle: "រំកិលដើម្បីបង្កើន",
      toggleTitle: "ចុចដើម្បីផ្លាស់ប្ដូរ",
      yearAriaLabel: "ឆ្នាំ"
    };
    fp$p.l10ns.km = Khmer;
    fp$p.l10ns;

    var fp$q = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$q.l10ns.kz = Kazakh;
    fp$q.l10ns;

    var fp$r = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$r.l10ns.lt = Lithuanian;
    fp$r.l10ns;

    var fp$s = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$s.l10ns.lv = Latvian;
    fp$s.l10ns;

    var fp$t = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$t.l10ns.mk = Macedonian;
    fp$t.l10ns;

    var fp$u = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$u.l10ns.mn = Mongolian;
    fp$u.l10ns;

    var fp$v = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$v.l10ns;

    var fp$w = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$w.l10ns.my = Burmese;
    fp$w.l10ns;

    var fp$x = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$x.l10ns.nl = Dutch;
    fp$x.l10ns;

    var fp$y = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$y.l10ns.no = Norwegian;
    fp$y.l10ns;

    var fp$z = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$z.l10ns.pa = Punjabi;
    fp$z.l10ns;

    var fp$A = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$A.l10ns.pl = Polish;
    fp$A.l10ns;

    var fp$B = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$B.l10ns.pt = Portuguese;
    fp$B.l10ns;

    var fp$C = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$C.l10ns.ro = Romanian;
    fp$C.l10ns;

    var fp$D = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$D.l10ns.ru = Russian;
    fp$D.l10ns;

    var fp$E = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$E.l10ns.si = Sinhala;
    fp$E.l10ns;

    var fp$F = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$F.l10ns.sk = Slovak;
    fp$F.l10ns;

    var fp$G = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$G.l10ns.sl = Slovenian;
    fp$G.l10ns;

    var fp$H = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$H.l10ns.sq = Albanian;
    fp$H.l10ns;

    var fp$I = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$I.l10ns.sr = Serbian;
    fp$I.l10ns;

    var fp$J = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$J.l10ns.sv = Swedish;
    fp$J.l10ns;

    var fp$K = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$K.l10ns.th = Thai;
    fp$K.l10ns;

    var fp$L = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$L.l10ns.tr = Turkish;
    fp$L.l10ns;

    var fp$M = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$M.l10ns.uk = Ukrainian;
    fp$M.l10ns;

    var fp$N = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$N.l10ns.vn = Vietnamese;
    fp$N.l10ns;

    var fp$O = typeof window !== "undefined" && window.flatpickr !== undefined ? window.flatpickr : {
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
    fp$O.l10ns.zh = Mandarin;
    fp$O.l10ns;

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
      km: Khmer,
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

/***/ 74:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_inputmask__ = __webpack_require__(22);
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
        key: 'connect',

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

/***/ 79:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_leaflet__ = __webpack_require__(25);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_leaflet___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_leaflet__);
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

            var default_lat = document.getElementById("marker__latitude").value;
            var default_lng = document.getElementById("marker__longitude").value;
            var copyright = '<a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>';
            var default_zoom = '4';
            var max_zoom = '18';
            var updateCoords = this.updateCoords.bind(this);

            var leafletMap = __WEBPACK_IMPORTED_MODULE_1_leaflet___default.a.map('osmap', {
                center: [default_lat, default_lng],
                zoom: default_zoom
            });

            __WEBPACK_IMPORTED_MODULE_1_leaflet___default.a.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: copyright,
                maxZoom: max_zoom
            }).addTo(leafletMap);

            var base64icon = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAApCAYAAADAk4LOAAAGmklEQVRYw7VXeUyTZxjvNnfELFuyIzOabermMZEeQC/OclkO49CpOHXOLJl/CAURuYbQi3KLgEhbrhZ1aDwmaoGqKII6odATmH/scDFbdC7LvFqOCc+e95s2VG50X/LLm/f4/Z7neY/ne18aANCmAr5E/xZf1uDOkTcGcWR6hl9247tT5U7Y6SNvWsKT63P58qbfeLJG8M5qcgTknrvvrdDbsT7Ml+tv82X6vVxJE33aRmgSyYtcWVMqX97Yv2JvW39UhRE2HuyBL+t+gK1116ly06EeWFNlAmHxlQE0OMiV6mQCScusKRlhS3QLeVJdl1+23h5dY4FNB3thrbYboqptEFlphTC1hSpJnbRvxP4NWgsE5Jyz86QNNi/5qSUTGuFk1gu54tN9wuK2wc3o+Wc13RCmsoBwEqzGcZsxsvCSy/9wJKf7UWf1mEY8JWfewc67UUoDbDjQC+FqK4QqLVMGGR9d2wurKzqBk3nqIT/9zLxRRjgZ9bqQgub+DdoeCC03Q8j+0QhFhBHR/eP3U/zCln7Uu+hihJ1+bBNffLIvmkyP0gpBZWYXhKussK6mBz5HT6M1Nqpcp+mBCPXosYQfrekGvrjewd59/GvKCE7TbK/04/ZV5QZYVWmDwH1mF3xa2Q3ra3DBC5vBT1oP7PTj4C0+CcL8c7C2CtejqhuCnuIQHaKHzvcRfZpnylFfXsYJx3pNLwhKzRAwAhEqG0SpusBHfAKkxw3w4627MPhoCH798z7s0ZnBJ/MEJbZSbXPhER2ih7p2ok/zSj2cEJDd4CAe+5WYnBCgR2uruyEw6zRoW6/DWJ/OeAP8pd/BGtzOZKpG8oke0SX6GMmRk6GFlyAc59K32OTEinILRJRchah8HQwND8N435Z9Z0FY1EqtxUg+0SO6RJ/mmXz4VuS+DpxXC3gXmZwIL7dBSH4zKE50wESf8qwVgrP1EIlTO5JP9Igu0aexdh28F1lmAEGJGfh7jE6ElyM5Rw/FDcYJjWhbeiBYoYNIpc2FT/SILivp0F1ipDWk4BIEo2VuodEJUifhbiltnNBIXPUFCMpthtAyqws/BPlEF/VbaIxErdxPphsU7rcCp8DohC+GvBIPJS/tW2jtvTmmAeuNO8BNOYQeG8G/2OzCJ3q+soYB5i6NhMaKr17FSal7GIHheuV3uSCY8qYVuEm1cOzqdWr7ku/R0BDoTT+DT+ohCM6/CCvKLKO4RI+dXPeAuaMqksaKrZ7L3FE5FIFbkIceeOZ2OcHO6wIhTkNo0ffgjRGxEqogXHYUPHfWAC/lADpwGcLRY3aeK4/oRGCKYcZXPVoeX/kelVYY8dUGf8V5EBRbgJXT5QIPhP9ePJi428JKOiEYhYXFBqou2Guh+p/mEB1/RfMw6rY7cxcjTrneI1FrDyuzUSRm9miwEJx8E/gUmqlyvHGkneiwErR21F3tNOK5Tf0yXaT+O7DgCvALTUBXdM4YhC/IawPU+2PduqMvuaR6eoxSwUk75ggqsYJ7VicsnwGIkZBSXKOUww73WGXyqP+J2/b9c+gi1YAg/xpwck3gJuucNrh5JvDPvQr0WFXf0piyt8f8/WI0hV4pRxxkQZdJDfDJNOAmM0Ag8jyT6hz0WGXWuP94Yh2jcfjmXAGvHCMslRimDHYuHuDsy2QtHuIavznhbYURq5R57KpzBBRZKPJi8eQg48h4j8SDdowifdIrEVdU+gbO6QNvRRt4ZBthUaZhUnjlYObNagV3keoeru3rU7rcuceqU1mJBxy+BWZYlNEBH+0eH4vRiB+OYybU2hnblYlTvkHinM4m54YnxSyaZYSF6R3jwgP7udKLGIX6r/lbNa9N6y5MFynjWDtrHd75ZvTYAPO/6RgF0k76mQla3FGq7dO+cH8sKn0Vo7nDllwAhqwLPkxrHwWmHJOo+AKJ4rab5OgrM7rVu8eWb2Pu0Dh4eDgXoOfvp7Y7QeqknRmvcTBEyq9m/HQQSCSz6LHq3z0yzsNySRfMS253wl2KyRDbcZPcfJKjZmSEOjcxyi+Y8dUOtsIEH6R2wNykdqrkYJ0RV92H0W58pkfQk7cKevsLK10Py8SdMGfXNXATY+pPbyJR/ET6n9nIfztNtZYRV9XniQu9IA2vOVgy4ir7GCLVmmd+zjkH0eAF9Po6K61pmCXHxU5rHMYd1ftc3owjwRSVRzLjKvqZEty6cRUD7jGqiOdu5HG6MdHjNcNYGqfDm5YRzLBBCCDl/2bk8a8gdbqcfwECu62Fg/HrggAAAABJRU5ErkJggg==';
            var base64shadow = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACkAAAApCAYAAACoYAD2AAAC5ElEQVRYw+2YW4/TMBCF45S0S1luXZCABy5CgLQgwf//S4BYBLTdJLax0fFqmB07nnQfEGqkIydpVH85M+NLjPe++dcPc4Q8Qh4hj5D/AaQJx6H/4TMwB0PeBNwU7EGQAmAtsNfAzoZkgIa0ZgLMa4Aj6CxIAsjhjOCoL5z7Glg1JAOkaicgvQBXuncwJAWjksLtBTWZe04CnYRktUGdilALppZBOgHGZcBzL6OClABvMSVIzyBjazOgrvACf1ydC5mguqAVg6RhdkSWQFj2uxfaq/BrIZOLEWgZdALIDvcMcZLD8ZbLC9de4yR1sYMi4G20S4Q/PWeJYxTOZn5zJXANZHIxAd4JWhPIloTJZhzMQduM89WQ3MUVAE/RnhAXpTycqys3NZALOBbB7kFrgLesQl2h45Fcj8L1tTSohUwuxhy8H/Qg6K7gIs+3kkaigQCOcyEXCHN07wyQazhrmIulvKMQAwMcmLNqyCVyMAI+BuxSMeTk3OPikLY2J1uE+VHQk6ANrhds+tNARqBeaGc72cK550FP4WhXmFmcMGhTwAR1ifOe3EvPqIegFmF+C8gVy0OfAaWQPMR7gF1OQKqGoBjq90HPMP01BUjPOqGFksC4emE48tWQAH0YmvOgF3DST6xieJgHAWxPAHMuNhrImIdvoNOKNWIOcE+UXE0pYAnkX6uhWsgVXDxHdTfCmrEEmMB2zMFimLVOtiiajxiGWrbU52EeCdyOwPEQD8LqyPH9Ti2kgYMf4OhSKB7qYILbBv3CuVTJ11Y80oaseiMWOONc/Y7kJYe0xL2f0BaiFTxknHO5HaMGMublKwxFGzYdWsBF174H/QDknhTHmHHN39iWFnkZx8lPyM8WHfYELmlLKtgWNmFNzQcC1b47gJ4hL19i7o65dhH0Negbca8vONZoP7doIeOC9zXm8RjuL0Gf4d4OYaU5ljo3GYiqzrWQHfJxA6ALhDpVKv9qYeZA8eM3EhfPSCmpuD0AAAAASUVORK5CYII=';
            var markerIcon = __WEBPACK_IMPORTED_MODULE_1_leaflet___default.a.icon({
                iconUrl: base64icon,
                iconAnchor: [12, 41],
                iconSize: [25, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41],
                shadowUrl: base64shadow
            });

            var leafletMarker = __WEBPACK_IMPORTED_MODULE_1_leaflet___default.a.marker([default_lat, default_lng], {
                icon: markerIcon,
                draggable: true
            }).addTo(leafletMap);

            leafletMarker.on('dragend', function (e) {
                updateCoords();
            });

            leafletMap.on('click', function (e) {
                leafletMarker.setLatLng(e.latlng);
                updateCoords();
                leafletMap.panTo(e.latlng);
            });
        }

        /**
         *
         */


        /**
         *
         * @type {string[]}
         */

    }, {
        key: "updateCoords",
        value: function updateCoords() {
            document.getElementById('marker__latitude').value = leafletMarker.getLatLng().lat;
            document.getElementById('marker__longitude').value = leafletMarker.getLatLng().lng;
        }

        /**
         *
         */

    }, {
        key: "search",
        value: function search() {

            var results = document.getElementById('marker__results');

            if (this.addressTarget.value.length >= 3) {

                $.getJSON('http://nominatim.openstreetmap.org/search?format=json&limit=5&q=' + this.addressTarget.value, function (data) {

                    var items = [];

                    $.each(data, function (key, val) {
                        var bb = val.boundingbox;
                        var lat = val.lat;
                        var lng = val.lon;
                        var name = val.display_name;
                        items.push("<li style='cursor:pointer' data-name='" + name + "' data-lat='" + lat + "' data-lng='" + lng + "' data-lat1='" + bb[0] + "' data-lat2='" + bb[1] + "' data-lng1='" + bb[2] + "' data-lng2='" + bb[3] + "' data-type='" + val.osm_type + "' data-action='click->fields--place#chooseAddr'>" + val.display_name + "</li>");
                    });

                    results.innerHTML = null;

                    if (items.length !== 0) {
                        $('<ul/>', {
                            'class': 'osm-list',
                            html: items.join('')
                        }).appendTo(results);
                    } else {
                        $('<p>', { html: "No results found" }).appendTo(results);
                    }
                });
            }
        }
    }, {
        key: "chooseAddr",
        value: function chooseAddr(e) {

            var name = e.target.getAttribute("data-name");
            var lat = e.target.getAttribute("data-lat"); //for centering marker
            var lng = e.target.getAttribute("data-lng"); //for centering marker
            var lat1 = e.target.getAttribute("data-lat1");
            var lat2 = e.target.getAttribute("data-lat2");
            var lng1 = e.target.getAttribute("data-lng1");
            var lng2 = e.target.getAttribute("data-lng2");
            var loc1 = new __WEBPACK_IMPORTED_MODULE_1_leaflet___default.a.LatLng(lat1, lng1);
            var loc2 = new __WEBPACK_IMPORTED_MODULE_1_leaflet___default.a.LatLng(lat2, lng2);
            var bounds = new __WEBPACK_IMPORTED_MODULE_1_leaflet___default.a.LatLngBounds(loc1, loc2);
            var updateCoords = this.updateCoords.bind(this);

            leafletMap.fitBounds(bounds);
            leafletMarker.setLatLng([lat, lng]);
            updateCoords();
            this.addressTarget.value = name;
        }
    }, {
        key: "getCurrentLocation",
        get: function get() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    return {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    };
                });
            }

            return {
                latitude: 0,
                longitude: 0
            };
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["address"];
/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 80:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_cropperjs__ = __webpack_require__(26);
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
            var previews = this.element.querySelectorAll('.preview');

            var dataX = this.element.querySelector('.picture-dataX');
            var dataY = this.element.querySelector('.picture-dataY');
            var dataHeight = this.element.querySelector('.picture-dataHeight');
            var dataWidth = this.element.querySelector('.picture-dataWidth');
            var dataRotate = this.element.querySelector('.picture-dataRotate');
            var dataScaleX = this.element.querySelector('.picture-dataScaleX');
            var dataScaleY = this.element.querySelector('.picture-dataScaleY');

            cropPanel.width = this.data.get('width');
            cropPanel.height = this.data.get('height');

            this.cropper = new __WEBPACK_IMPORTED_MODULE_1_cropperjs__["default"](cropPanel, {
                aspectRatio: this.data.get('width') / this.data.get('height'),
                preview: '.preview',

                ready: function ready() {
                    console.log("ready");
                },
                crop: function crop(event) {

                    var data = event.detail;
                    dataX.value = Math.round(data.x);
                    dataY.value = Math.round(data.y);
                    dataHeight.value = Math.round(data.height);
                    dataWidth.value = Math.round(data.width);
                    dataRotate.value = typeof data.rotate !== 'undefined' ? data.rotate : '';
                    dataScaleX.value = typeof data.scaleX !== 'undefined' ? data.scaleX : '';
                    dataScaleY.value = typeof data.scaleY !== 'undefined' ? data.scaleY : '';
                }
            });

            var cropper = this.cropper;

            $(this.element.querySelectorAll('.picture-datas')).bind("change", function () {
                cropper.setData({
                    x: Math.round(dataX.value),
                    y: Math.round(dataY.value),
                    width: Math.round(dataWidth.value),
                    height: Math.round(dataHeight.value),
                    rotate: Math.round(dataRotate.value),
                    scaleX: Math.round(dataScaleX.value),
                    scaleY: Math.round(dataScaleY.value)
                });
            });
        }

        /**
         * Event for uploading image
         *
         * @param event
         */


        /**
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
                _this2.cropper.replace(reader.result);
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

            this.cropper.getCroppedCanvas({
                width: this.data.get('width'),
                height: this.data.get('height'),
                imageSmoothingQuality: 'medium'
            }).toBlob(function (blob) {
                var formData = new FormData();

                formData.append('file', blob);
                formData.append('storage', _this3.data.get('storage'));

                var element = _this3.element;
                axios.post(platform.prefix('/systems/files'), formData).then(function (response) {
                    var image = response.data.url;

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

        /**
         * Action on click buttons
         */

    }, {
        key: "moveleft",
        value: function moveleft() {
            this.cropper.move(-10, 0);
        }
    }, {
        key: "moveright",
        value: function moveright() {
            this.cropper.move(10, 0);
        }
    }, {
        key: "moveup",
        value: function moveup() {
            this.cropper.move(0, -10);
        }
    }, {
        key: "movedown",
        value: function movedown() {
            this.cropper.move(0, 10);
        }
    }, {
        key: "zoomin",
        value: function zoomin() {
            this.cropper.zoom(0.1);
        }
    }, {
        key: "zoomout",
        value: function zoomout() {
            this.cropper.zoom(-0.1);
        }
    }, {
        key: "rotateleft",
        value: function rotateleft() {
            this.cropper.rotate(-5);
        }
    }, {
        key: "rotateright",
        value: function rotateright() {
            this.cropper.rotate(5);
        }
    }, {
        key: "scalex",
        value: function scalex() {
            var dataScaleX = this.element.querySelector('.picture-dataScaleX');
            this.cropper.scaleX(-dataScaleX.value);
        }
    }, {
        key: "scaley",
        value: function scaley() {
            var dataScaleY = this.element.querySelector('.picture-dataScaleY');
            this.cropper.scaleY(-dataScaleY.value);
        }
    }, {
        key: "aspectratiowh",
        value: function aspectratiowh() {
            this.cropper.setAspectRatio(this.data.get('width') / this.data.get('height'));
        }
    }, {
        key: "aspectratiofree",
        value: function aspectratiofree() {
            this.cropper.setAspectRatio(NaN);
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["source", "upload"];
/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 81:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
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

            var slug = this.data.get('slug');
            var key = this.data.get('key');

            window.loadGoogleMaps = {
                "load": function load() {
                    if (window.google === undefined || window.google.maps === undefined) {
                        window.loadGoogleMaps.status = true;
                        $.getScript('https://maps.googleapis.com/maps/api/js?libraries=places&key=' + key, function () {
                            document.documentElement.dispatchEvent(new Event("googleMapsLoad"));
                        });
                    }
                },
                "status": false
            };

            if (!window.loadGoogleMaps.status) {
                window.loadGoogleMaps.load();
            }

            document.addEventListener('turbolinks:load', function () {
                if (!window.loadGoogleMaps.status) {
                    window.loadGoogleMaps.load();
                }
            });

            document.documentElement.addEventListener('googleMapsLoad', function () {
                var input = document.getElementById('place-' + slug);
                var autocomplete = new google.maps.places.Autocomplete(input);

                autocomplete.addListener('place_changed', function () {
                    var cors = autocomplete.getPlace().geometry.location;
                    $('#lat-' + slug).val(cors.lat());
                    $('#lng-' + slug).val(cors.lng());
                });

                $('#map-place-' + slug).on('show.bs.modal', function () {

                    setTimeout(function () {
                        var myLatLng = {
                            lat: parseFloat($('#lat-' + slug).val()),
                            lng: parseFloat($('#lng-' + slug).val())
                        };

                        var map = new google.maps.Map(document.getElementById('map-place-' + slug + '-canvas'), {
                            center: myLatLng,
                            zoom: 12
                        });

                        new google.maps.Marker({
                            map: map,
                            position: myLatLng,
                            title: $('#place-' + slug).val()
                        });
                    }, 300);
                });
            });
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 82:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
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
            var _this2 = this;

            var select = this.element.querySelector('select');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                }
            });

            $(select).select2({
                theme: "bootstrap",
                ajax: {
                    type: "POST",
                    cache: true,
                    delay: 250,
                    url: function url() {
                        return _this2.data.get('url');
                    },
                    dataType: 'json'
                },
                selectOnClose: true,
                placeholder: this.data.get('placeholder')
            });

            if (!this.data.get('value')) {
                return;
            }

            axios.post(this.data.get('url-value')).then(function (response) {
                $(select).append(new Option(response.data.text, response.data.id, true, true)).trigger('change');
            });

            document.addEventListener('turbolinks:before-cache', function () {
                $(select).select2('destroy');
            }, { once: true });
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 83:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
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

            $(select).select2({
                width: '100%',
                theme: 'bootstrap'
            });
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 84:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_simplemde__ = __webpack_require__(27);
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
        key: 'connect',


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
                    name: 'bold',
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleBold,
                    className: 'icon-bold',
                    title: 'Bold'
                }, {
                    name: 'italic',
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleItalic,
                    className: 'icon-italic',
                    title: 'Italic'
                }, {
                    name: 'heading',
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleHeadingSmaller,
                    className: 'icon-font',
                    title: 'Heading'
                }, '|', {
                    name: 'quote',
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleBlockquote,
                    className: 'icon-quote',
                    title: 'Quote'
                }, {
                    name: 'code',
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleCodeBlock,
                    className: 'icon-code',
                    title: 'Code'
                }, {
                    name: 'unordered-list',
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleUnorderedList,
                    className: 'icon-list',
                    title: 'Generic List'
                }, {
                    name: 'ordered-list',
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleOrderedList,
                    className: 'icon-number-list',
                    title: 'Numbered List'
                }, '|', {
                    name: 'link',
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.drawLink,
                    className: 'icon-link',
                    title: 'Link'
                }, {
                    name: 'image',
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.drawImage,
                    className: 'icon-picture',
                    title: 'Insert Image'
                }, {
                    name: 'upload',
                    action: function action() {
                        return _this2.showDialogUpload();
                    },
                    className: 'icon-cloud-upload',
                    title: 'Upload File'
                }, {
                    name: 'table',
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.drawTable,
                    className: 'icon-table',
                    title: 'Insert Table'
                }, '|', {
                    name: 'preview',
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.togglePreview,
                    className: 'icon-eye no-disable',
                    title: 'Toggle Preview'
                }, {
                    name: 'side-by-side',
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleSideBySide,
                    className: 'icon-browser no-disable no-mobile',
                    title: 'Toggle Side by Side'
                }, {
                    name: 'fullscreen',
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleFullScreen,
                    className: 'icon-full-screen no-disable no-mobile',
                    title: 'Toggle Fullscreen'
                }, '|', {
                    name: 'horizontal-rule',
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.drawHorizontalRule,
                    className: 'icon-options',
                    title: 'Insert Horizontal Line'
                }, {
                    name: 'guide',
                    action: function action() {
                        return _this2.showModal();
                    },
                    className: 'icon-help',
                    title: 'Markdown Guide'
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
        key: 'showModal',
        value: function showModal() {
            $(this.element.querySelector('.modal')).modal('show');
        }

        /**
         *
         */

    }, {
        key: 'showDialogUpload',
        value: function showDialogUpload() {
            this.uploadInput.click();
        }

        /**
         *
         * @param event
         */

    }, {
        key: 'upload',
        value: function upload(event) {
            var _this3 = this;

            var file = event.target.files[0];

            if (file === undefined || file === null) {
                return;
            }

            var formData = new FormData();
            formData.append('file', file);

            axios.post(platform.prefix('/systems/files'), formData).then(function (response) {
                _this3.editor.codemirror.replaceSelection(response.data.url);
                event.target.value = null;
            }).catch(function (error) {
                console.warn(error);
                event.target.value = null;
            });
        }
    }, {
        key: 'textarea',

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
        key: 'uploadInput',
        get: function get() {
            return this.element.querySelector('.upload');
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ })

},[41]);
//# sourceMappingURL=orchid.js.map