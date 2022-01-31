import ApplicationController     from "./application_controller"
import {Dropzone}                from 'dropzone';
import Sortable                  from 'sortablejs';
import {debounce, has as objHas} from "lodash";

export default class extends ApplicationController {

    /**
     *
     * @type {string[]}
     */
    static targets = [
        'search',
        'name',
        'original',
        'alt',
        'description',
        'url',
        'loadmore',
    ];

    /**
     *
     * @param props
     */
    constructor(props) {
        super(props);
        this.attachments = {};
        this.mediaList = {};
        this.allMediaList = {};
    }

    initialize() {
        this.loadMedia = debounce(this.loadMedia, 500);
        this.page = 1
    }

    /**
     *
     * @returns {string}
     */
    get dropname() {
        return this.element.querySelector('#' + this.data.get('id'));
    }

    /**
     *
     * @returns {string|{id: *}}
     */
    get activeAttachment() {
        return {
            id: this.activeAchivmentId,
            name: this[this.getAttachmentTargetKey('name')].value || '',
            alt: this[this.getAttachmentTargetKey('alt')].value || '',
            description: this[this.getAttachmentTargetKey('description')].value || '',
            original_name: this[this.getAttachmentTargetKey('original')].value || '',
        };
    }

    /**
     *
     * @param data
     */
    set activeAttachment(data) {
        this.activeAchivmentId = data.id;

        this[this.getAttachmentTargetKey('name')].value = data.name || '';
        this[this.getAttachmentTargetKey('original')].value = data.original_name || '';
        this[this.getAttachmentTargetKey('alt')].value = data.alt || '';
        this[this.getAttachmentTargetKey('description')].value = data.description || '';

        this.data.set('url', data.url);
    }

    /**
     *
     */
    openLink(event) {
        event.preventDefault();
        window.open(this.data.get('url'));
    }

    /**
     *
     */
    connect() {
        this.initDropZone();
        this.initSortable();
    }

    /**
     *
     */
    save() {
        const attach = this.activeAttachment;
        $(this.dropname).find(`.attachment.modal`).modal('toggle');

        const name = attach.name + attach.id;

        if (this.attachments.hasOwnProperty(name)) {
            this.attachments[name].name = attach.name;
            this.attachments[name].alt = attach.alt;
            this.attachments[name].description = attach.description;
            this.attachments[name].original_name = attach.original_name;
        }

        axios
            .put(this.prefix(`/systems/files/post/${attach.id}`), attach)
            .then();
    }

    /**
     *
     * @param dataKey
     * @returns {string}
     */
    getAttachmentTargetKey(dataKey) {
        return `${dataKey}Target`;
    }

    /**
     *
     * @param data
     */
    loadInfo(data) {
        const name = data.name + data.id;

        if (!this.attachments.hasOwnProperty(name)) {
            this.attachments[name] = data;
        }
        this.activeAttachment = data;
    }

    /**
     *
     */
    resortElement() {
        const items = {};
        const self = this;
        const dropname = this.dropname;
        const CancelToken = axios.CancelToken;

        if (typeof this.cancelRequest === 'function') {
            this.cancelRequest();
        }

        $(dropname).find(`.file-sort`).each((index, value) => {
            const id = $(value).attr('data-file-id');
            items[id] = index;
        });

        axios
            .post(this.prefix('/systems/files/sort'), {
                files: items,
            }, {
                cancelToken: new CancelToken(function executor(c) {
                    self.cancelRequest = c;
                }),
            })
            .then();
    }

    /**
     *
     */
    initSortable() {
        new Sortable(this.element.querySelector('.sortable-dropzone'), {
            animation: 150,
            onEnd: () => {
                this.resortElement();
            },
        });
    }

    /**
     *
     * @param dropname
     * @param name
     * @param file
     */
    addSortDataAtributes(dropname, name, file) {
        $(dropname).find(`.dz-complete:last-child`)
            .attr('data-file-id', file.id)
            .addClass('file-sort');
        $(
            `<input type="hidden" class="files-${file.id}" name="${name}[]" value="${file.id}"  />`
        ).appendTo(dropname);
    }

    /**
     *
     */
    initDropZone() {
        const self = this;
        const data = this.data.get('data') && JSON.parse(this.data.get('data'));
        const storage = this.data.get('storage');
        const name = this.data.get('name');
        const loadInfo = this.loadInfo.bind(this);
        const dropname = this.dropname;
        const groups = this.data.get('groups');
        const multiple = !!this.data.get('multiple');
        const isMediaLibrary = this.data.get('is-media-library');

        const removeButtonTemplate = this.element.querySelector('#' + this.data.get('id') + '-remove-button').innerHTML.trim();
        const editButtonTemplate = this.element.querySelector('#' + this.data.get('id') + '-edit-button').innerHTML.trim();

        const controller = this;

        const urlDelete = this.prefix(`/systems/files/`);

        this.dropZone = new Dropzone(this.element.querySelector('#' + this.data.get('id')), {
            url: this.prefix('/systems/files'),
            method: 'post',
            uploadMultiple: true,
            maxFilesize: this.data.get('max-file-size'),
            maxFiles: multiple ? this.data.get('max-files') : 1,
            timeout: this.data.get('timeout'),
            acceptedFiles: this.data.get('accepted-files'),
            resizeQuality: this.data.get('resize-quality'),
            resizeWidth: this.data.get('resize-width'),
            resizeHeight: this.data.get('resize-height'),
            paramName: 'files',

            previewsContainer: dropname.querySelector('.visual-dropzone'),
            addRemoveLinks: false,
            dictFileTooBig: 'File is big',
            autoDiscover: false,

            init: function () {

                this.on('addedfile', (e) => {
                    console.log('dropzone.addedfile');

                    if (this.files.length > this.options.maxFiles) {
                        controller.alert('Validation error', 'Max files');
                        this.removeFile(e);
                    }

                    const editButton = Dropzone.createElement(editButtonTemplate);
                    const removeButton = Dropzone.createElement(removeButtonTemplate);

                    removeButton.addEventListener('click', (event) => {
                        event.preventDefault();
                        event.stopPropagation();
                        this.removeFile(e);
                    });

                    editButton.addEventListener('click', () => {
                        loadInfo(e.data);
                        $(dropname).find(`.attachment.modal`).modal('show');
                    });

                    e.previewElement.appendChild(removeButton);
                    e.previewElement.appendChild(editButton);
                });

                this.on("maxfilesexceeded", (file) => {
                    controller.alert('Validation error', 'Max files exceeded');
                    this.removeFile(file);
                });

                this.on('sending', (file, xhr, formData) => {
                    formData.append('_token', $('meta[name=\'csrf_token\']').attr('content'));
                    formData.append('storage', storage);
                    formData.append('group', groups);
                });

                this.on('removedfile', file => {
                    if (objHas(file, 'data.id')) {
                        $(dropname).find(`.files-${file.data.id}`).remove();
                        !isMediaLibrary && axios
                            .delete(urlDelete + file.data.id, {
                                storage: storage,
                            })
                            .then();
                    }
                });

                if (!multiple) {
                    this.hiddenFileInput.removeAttribute('multiple');
                }

                const images = data;

                if (images) {
                    Object.values(images).forEach((item) => {
                        const file = {
                            id: item.id,
                            name: item.original_name,
                            size: item.size,
                            type: item.mime,
                            status: Dropzone.ADDED,
                            url: `${item.url}`,
                            data: item,
                        };

                        this.emit('addedfile', file);
                        this.emit('thumbnail', file, file.url);
                        this.emit('complete', file);
                        this.files.push(file);
                        self.addSortDataAtributes(dropname, name, item);
                    });
                }

                $(dropname).find(`.dz-progress`).remove();
            },
            error(file, response) {
                controller.alert('Validation error', 'File upload error');

                this.removeFile(file);

                if ($.type(response) === 'string') {
                    return response;
                }
                return response.message;
            },
            success(file, response) {

                if (!Array.isArray(response)) {
                    response = [response];
                }

                response.forEach((item) => {
                    if (file.name === item.original_name) {
                        file.data = item;
                        return false;
                    }
                });

                self.addSortDataAtributes(dropname, name, file.data);
                self.resortElement();
            },
        });
    }

    /**
     *
     */
    openMedia() {
        $(this.dropname).find('.media-loader').show();
        $(this.dropname).find('.media-results').hide();

        this.loadMedia();
    }

    /**
     *
     */
    loadMore(event) {
        event.preventDefault();
        this.page++;
        this.loadMedia();
    }

    /**
     *
     */
    resetPage() {
        this.allMediaList = {}; // Reset all media list
        this.page = 1; // Reset page

        $(this.dropname).find(`.media-results`).html('');
    }

    /**
     *
     */
    loadMedia() {
        const self = this;
        const CancelToken = axios.CancelToken;

        if (typeof this.cancelRequest === 'function') {
            this.cancelRequest();
        }

        $(this.dropname).find(`.media.modal`).modal('show');

        axios
            .post(this.prefix(`/systems/media?page=${this.page}`), {
                filter: {
                    disk: this.data.get('storage'),
                    original_name: this.searchTarget.value,
                },
            }, {
                cancelToken: new CancelToken(function executor(c) {
                    self.cancelRequest = c;
                }),
            })
            .then((response) => {
                this.mediaList = response.data.data;
                // show/hide load more
                this.loadmoreTarget.classList.toggle('d-none', response.data.last_page === this.page);
                this.renderMedia();
            });
    }

    /**
     *
     */
    renderMedia() {
        this.mediaList.forEach((element, key) => {
            const index = this.page + '-' + key;

            const template = this.element
                .querySelector('#' + this.data.get('id') + '-media')
                .content
                .querySelector('.media-item')
                .cloneNode(true);

            template.innerHTML = template.innerHTML
                .replace(/{index}/, index)
                .replace(/{element.url}/, element.url)
                .replace(/{element.original_name}/, element.original_name)
                .replace(/{element.original_name}/, element.original_name);

            $(this.dropname).find(`.media-results`).append(template);
            this.allMediaList[index] = element;
        });

        $(this.dropname).find(`.media-loader`).hide();
        $(this.dropname).find(`.media-results`).show();
    }

    /**
     *
     */
    addFile(event) {
        const key = event.currentTarget.dataset.key;
        const file = this.allMediaList[key]

        this.addedExistFile(file);

        if (this.data.get('close-on-add')) {
            $(this.dropname).find(`.media.modal`).modal('hide');
        }
    }

    /**
     *
     * @param attachment
     */
    addedExistFile(attachment) {
        const multiple = !!this.data.get('multiple');
        const maxFiles = multiple ? this.data.get('max-files') : 1;

        if (this.dropZone.files.length >= maxFiles) {
            this.alert('Max files exceeded');
            return;
        }

        /** todo: Дублируется дважды */
        const file = {
            id: attachment.id,
            name: attachment.original_name,
            size: attachment.size,
            type: attachment.mime,
            status: Dropzone.ADDED,
            url: `${attachment.url}`,
            data: attachment,
        };

        this.dropZone.emit('addedfile', file);
        this.dropZone.emit('thumbnail', file, file.url);
        this.dropZone.emit('complete', file);
        this.dropZone.files.push(file);
        this.addSortDataAtributes(this.dropname, this.data.get('name'), file);
        this.resortElement();
    }
}
