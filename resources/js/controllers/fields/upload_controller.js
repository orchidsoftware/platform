import {Controller} from "stimulus"
import Dropzone     from 'dropzone';

export default class extends Controller {

    /**
     *
     * @type {string[]}
     */
    static targets = [
        "name",
        "original",
        "alt",
        "description",
        "url",
    ];

    /**
     *
     * @param props
     */
    constructor(props) {
        super(props);
        this.attachments = {}
    }

    /**
     *
     * @returns {string}
     */
    get dropname() {
        return '#' + this.data.get('id');
    }

    /**
     *
     * @returns {string|{id: *}}
     */
    get activeAttachment() {
        return {
            'id': this.activeAchivmentId,
            'name': this[this.getAttachmentTargetKey('name')].value,
            'alt':this[this.getAttachmentTargetKey('alt')].value,
            'description': this[this.getAttachmentTargetKey('description')].value,
        };
    }

    /**
     *
     * @param data
     */
    set activeAttachment(data) {
        this.activeAchivmentId = data.id;

        this[this.getAttachmentTargetKey('name')].value = data.name;
        this[this.getAttachmentTargetKey('original')].value = data.original_name;
        this[this.getAttachmentTargetKey('alt')].value = data.alt;
        this[this.getAttachmentTargetKey('description')].value = data.description;


        //this[this.getAttachmentTargetKey('url')].value = data.url;
        this.data.set('url',data.url);

    }

    /**
     *
     */
    openLink() {
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
        $(`${this.dropname} .modal`).modal('toggle');

        const name = attach.name + attach.id;

        if (this.attachments.hasOwnProperty(name)) {
            this.attachments[name].name = attach.name;
            this.attachments[name].alt = attach.alt;
            this.attachments[name].description = attach.description;
        }

        axios
            .put(platform.prefix(`/systems/files/post/${attach.id}`), attach)
            .then();
    }

    /**
     *
     * @param dataKey
     * @returns {string}
     */
    getAttachmentTargetKey(dataKey) {
        return `${dataKey}Target`
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
        this.activeAttachment = data
    }

    /**
     *
     */
    initSortable() {
        $(this.dropname + ' .sortable-dropzone').sortable({
            scroll: false,
            containment: "parent",
            update: function () {
                const items = {};
                $('.file-sort').each( (index, value) => {
                    const id = $(value).attr('data-file-id');
                    items[id] = index;
                });

                axios
                    .post(platform.prefix('/systems/files/sort'), {
                        files: items,
                    })
                    .then();

            },
        });
    }

    /**
     *
     */
    initDropZone() {
        const data = this.data.get('data') && JSON.parse(this.data.get('data'));
        const storage = this.data.get('storage');
        const name = this.data.get('name');
        const loadInfo = this.loadInfo.bind(this);
        const dropname = this.dropname;
        const groups = this.data.get('groups');

        new Dropzone(dropname, {
                url: platform.prefix('/systems/files'),
                method: 'post',
                uploadMultiple: this.data.get('multiple'),
                parallelUploads: this.data.get('parallelUploads'),
                maxFilesize: this.data.get('maxFileSize'),
                maxFiles: this.data.get('maxFiles'),
                acceptedFiles: this.data.get('acceptedFiles'),
                resizeQuality: this.data.get('resizeQuality'),
                resizeWidth: this.data.get('resizeWidth'),
                resizeHeight: this.data.get('resizeHeight'),
                paramName: 'files',

                previewsContainer: `${dropname} .visual-dropzone`,
                addRemoveLinks: false,
                dictFileTooBig: 'File is big',
                autoDiscover: false,

                init() {
                    this.on('addedfile', (e) => {

                        let removeButton = Dropzone.createElement('<a href="javascript:;" class="btn-remove">&times;</a>');
                        let editButton = Dropzone.createElement('<a href="javascript:;" class="btn-edit"><i class="icon-note" aria-hidden="true"></i></a>');


                        removeButton.addEventListener('click', (event) => {
                            event.preventDefault();
                            event.stopPropagation();
                            this.removeFile(e);
                        });

                        editButton.addEventListener('click', () => {
                            loadInfo(e.data);
                            $(`${dropname} .modal`).modal('show');
                        });

                        e.previewElement.appendChild(removeButton);
                        e.previewElement.appendChild(editButton);
                    });

                    this.on('completemultiple', () => {
                        $(`${dropname}.sortable-dropzone`).sortable('enable');
                    });

                    const images = data;

                    if (images) {
                        Object.values(images).forEach((item) => {
                            const mockFile = {
                                id: item.id,
                                name: item.original_name,
                                size: item.size,
                                type: item.mime,
                                status: Dropzone.ADDED,
                                url: `${item.url}`,
                                data: item,
                            };

                            this.emit('addedfile', mockFile);
                            this.emit('thumbnail', mockFile, mockFile.url);
                            this.files.push(mockFile);
                            $(`${dropname}.dz-preview:last-child`)
                                .attr('data-file-id', item.id)
                                .addClass('file-sort');
                            $(
                                `<input type='hidden' class='files-${item.id}' name='${name}[]' value='${item.id}'  />`
                            ).appendTo(dropname);
                        });
                    }

                    $(`${dropname} .dz-progress`).remove();

                    this.on('sending', (file, xhr, formData) => {
                        formData.append('_token', $("meta[name='csrf_token']").attr('content'));
                        formData.append('storage', storage);
                        formData.append('group', groups);
                    });

                    this.on('removedfile', file => {
                        $(`${dropname}.files-${file.data.id}`).remove();
                        axios
                            .delete(platform.prefix(`/systems/files/${file.data.id}`), {
                                storage: $('#post-attachment-dropzone').data('storage'),
                            })
                            .then();
                    });
                },
                error(file, response) {
                    if ($.type(response) === 'string') {
                        return response; //dropzone sends it's own error messages in string
                    }
                    return response.message;
                },

                success(file, response) {
                    file.data = response;
                    $(`${dropname} .dz-preview:last-child`)
                        .attr('data-file-id', response.id)
                        .addClass('file-sort');
                    $(
                        `<input type='hidden' class='files-${response.id}' name='${name}[]' value='${response.id}'  />`
                    ).appendTo(dropname);
                },
            });
    }
}