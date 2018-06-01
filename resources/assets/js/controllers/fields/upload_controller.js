import {Controller} from "stimulus"

export default class extends Controller {

    static targets = [
        "name",
        "original_name",
        "alt",
        "description",
        "url",
        "active"
    ]

    constructor(props) {
        super(props);
        this.attachments = {}
    }


    connect() {
        this.initDropZone()
        this.initSortable()
    }

    get dropname() {
        return '#dropzone-'+this.data.get('name')+' ';
    }
    
    save() {
        const data = this.activeAttachment;

        $('#modalUploadAttachment').modal('toggle');
        axios
            .put(platform.prefix(`/systems/files/post/${data.id}`), data)
            .then();
    }

    getAttachmentTargetKey(dataKey) {
        return `${dataKey}Target`
    }

    get activeAttachment() {
        const id = this.activeAchivmentId
        return ([
            'name',
            'original_name',
            'alt',
            'url',
            'description'
        ]).reduce((res, key) => {
            const targetKey = this.getAttachmentTargetKey(key)
            const target = this[targetKey]
            if (key === 'url') {
                return {
                    ...res,
                    [key]: target.href
                }
            }
            return {
                ...res,
                [key]: target.value
            }
        }, {id})
    }

    set activeAttachment(data) {
        this.activeAchivmentId = data.id
        Object.keys(data).map((key) => {
            const value = data[key]
            const targetKey = this.getAttachmentTargetKey(key)
            const target = this[targetKey]

            if (!target) {
                return
            }

            if (key === 'url') {
                target.href = value
                return
            }
            target.value = value
        })
    }

    loadInfo(data) {
        const name = data.name + data.id;
        data.url = '/storage/' + data.path + data.name + '.' + data.extension;
        if (!this.attachments.hasOwnProperty(name)) {
            this.attachments[name] = data;
        }
        this.activeAttachment = data
    }

    initSortable() {
        $(this.dropname+'.sortable-dropzone').sortable({
            scroll: false,
            containment: "parent",
            update: function () {
                const items = {};
                $('.file-sort').each(function (index, value) {
                    const id = $(this).attr('data-file-id');
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

    initDropZone() {
        const data = this.data.get('data') && JSON.parse(this.data.get('data'))
        const storage = this.data.get('storage')
        const name = this.data.get('name')
        const loadInfo = this.loadInfo.bind(this)
        const dropname = this.dropname
        
        Dropzone.autoDiscover = false;
        var UploadDropzone = new Dropzone(dropname, {
            url: platform.prefix('/systems/files'),
            method: 'post',
            uploadMultiple: false,
            parallelUploads: 100,
            maxFilesize: 9999,
            paramName: 'files',
            maxThumbnailFilesize: 99999,
            previewsContainer: dropname+'.visual-dropzone',
            addRemoveLinks: false,
            dictFileTooBig: 'File is big',

            init: function () {
                this.on('addedfile', function (e) {
                    var n = Dropzone.createElement('<a href="javascript:;" class="btn-remove">&times;</a>'),
                        t = this;
                    n.addEventListener('click', function (n) {
                        n.preventDefault(), n.stopPropagation(), t.removeFile(e);
                    }),
                        e.previewElement.appendChild(n);

                    var n = Dropzone.createElement('<a href="javascript:;" class="btn-edit"><i class="icon - note" aria-hidden="true"></i></a>'),
                        t = this;
                    n.addEventListener('click', function (n) {
                        loadInfo(e.data);
                        $('#modalUploadAttachment').modal('show');
                    }),
                        e.previewElement.appendChild(n);
                });

                this.on('completemultiple', function (file, json) {
                    $(dropname+'.sortable-dropzone').sortable('enable');
                });

                const instanceDropZone = this;
                const images = data
                images.forEach(function (item, i, arr) {
                    const mockFile = {
                        id: item.id,
                        name: item.original_name,
                        size: item.size,
                        type: item.mime,
                        status: Dropzone.ADDED,
                        url: '/storage/' + item.path + item.name + '.' + item.extension,
                        data: item,
                    };

                    instanceDropZone.emit('addedfile', mockFile);
                    instanceDropZone.emit('thumbnail', mockFile, mockFile.url);
                    instanceDropZone.files.push(mockFile);
                    $(dropname+'.dz-preview:last-child')
                        .attr('data-file-id', item.id)
                        .addClass('file-sort');
                    $(
                        "<input type='hidden' class='files-" +
                        item.id +
                        "' name='" + name + "[]' value='" +
                        item.id +
                        "'  />"
                    ).appendTo(dropname);

                });

                $(dropname+'.dz-progress').remove();

                this.on('sending', function (file, xhr, formData) {
                    formData.append('_token', $("meta[name='csrf_token']").attr('content'));
                    formData.append(
                        'storage',
                        storage
                    );
                });

                this.on('removedfile', function (file) {
                    $(dropname+'.files-' + file.data.id).remove();
                    axios
                        .delete(platform.prefix(`/systems/files/${file.data.id}`), {
                            storage: $('#post-attachment-dropzone').data('storage'),
                        })
                        .then();
                });
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    return response; //dropzone sends it's own error messages in string
                }
                return response.message;
            },
            success: function (file, response) {
                file.data = response;
                $(dropname+'.dz-preview:last-child')
                    .attr('data-file-id', response.id)
                    .addClass('file-sort');
                $(
                    "<input type='hidden' class='files-" +
                    response.id +
                    "' name='" + name + "[]' value='" +
                    response.id +
                    "'  />"
                ).appendTo(dropname);
            },
        });
    }
}