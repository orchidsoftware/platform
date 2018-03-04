document.addEventListener('turbolinks:load', () => {
    if (document.getElementById('post-attachment-dropzone') === null) {
        return;
    }

    const attachmentDescription = new Vue({
        el: '#modalAttachment',
        data: {
            attachment: {},
            active: null,
        },
        methods: {
            loadInfo(data) {
                let name = data.name + data.id;

                data.url = `/storage/${data.path}${data.name}.${data.extension}`;

                if (!this.attachment.hasOwnProperty(name)) {
                    this.attachment[name] = data;
                }
                this.active = name;
            },
            save() {
                let data = this.attachment[this.active];

                $('#modalAttachment').modal('toggle');

                $.ajax({
                    type: 'POST',
                    url: dashboard.prefix(`/systems/files/post/${data.id}`),
                    data: {
                        _token: $("meta[name='csrf_token']").attr('content'),
                        attachment: data,
                        _method: 'PUT',
                    },
                    dataType: 'html',
                    success(data) {
                        console.log('file update');
                    },
                });
            },
        },
    });

    new Dropzone('.dropzone', {
        url: dashboard.prefix('/systems/files'),
        method: 'post',
        uploadMultiple: false,
        parallelUploads: 100,
        maxFilesize: 9999,
        paramName: 'files',
        acceptedFiles: $('#post-attachment-dropzone').data('accepted'),
        maxThumbnailFilesize: 99999,
        previewsContainer: '.visual-dropzone',
        addRemoveLinks: false,
        dictFileTooBig: 'File is big',

        init() {
            this.on('addedfile', function(e) {
                var n = Dropzone.createElement(
                    "<a href='javascript:;' class='btn-remove'><i class='icon-cross' aria-hidden='true'></i></a>",
                );

                var t = this;
                n.addEventListener('click', n => {
                    n.preventDefault(), n.stopPropagation(), t.removeFile(e);
                }),
                    e.previewElement.appendChild(n);

                var n = Dropzone.createElement(
                    "<a href='javascript:;'' class='btn-edit'><i class='icon-note' aria-hidden='true'></i></a>",
                );

                var t = this;
                n.addEventListener('click', n => {
                    attachmentDescription.loadInfo(e.data);
                    $('#modalAttachment').modal('show');
                }),
                    e.previewElement.appendChild(n);
            });

            this.on('completemultiple', (file, json) => {
                $('.sortable-dropzone').sortable('enable');
            });

            const instanceDropZone = this;

            const id = $('#post').data('post-id');
            if (id !== undefined) {
                $.ajax({
                    type: 'get',
                    url: dashboard.prefix(`/systems/files/post/${id}`),
                    data: { _token: $("meta[name='csrf_token']").attr('content') },
                    dataType: 'html',
                    success(data) {
                        const images = JSON.parse(data);

                        images.forEach((item, i, arr) => {
                            const mockFile = {
                                id: item.id,
                                name: item.original_name,
                                size: item.size,
                                type: item.mime,
                                status: Dropzone.ADDED,
                                url: `/storage/${item.path}${item.name}.${item.extension}`,
                                data: item,
                            };

                            instanceDropZone.emit('addedfile', mockFile);
                            instanceDropZone.emit('thumbnail', mockFile, mockFile.url);
                            instanceDropZone.files.push(mockFile);
                            $('.dz-preview:last-child')
                                .attr('data-file-id', item.id)
                                .addClass('file-sort');
                        });

                        $('.dz-progress').remove();
                    },
                });
            }

            this.on('sending', (file, xhr, formData) => {
                formData.append('_token', $("meta[name='csrf_token']").attr('content'));
                formData.append(
                    'storage',
                    $('#post-attachment-dropzone').data('storage'),
                );
            });

            this.on('removedfile', ({data}) => {
                $(`.files-${data.id}`).remove();

                $.ajax({
                    type: 'delete',
                    url: dashboard.prefix(`/systems/files/${data.id}`),
                    data: {
                        _token: $("meta[name='csrf_token']").attr('content'),
                        storage: $('#post-attachment-dropzone').data('storage'),
                    },
                    dataType: 'html',
                    success(data) {
                        //
                    },
                });
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
            $('.dz-preview:last-child')
                .attr('data-file-id', response.id)
                .addClass('file-sort');
            $(
                `<input type='hidden' class='files-${response.id}' name='files[]' value='${response.id}'  />`,
            ).appendTo('.dropzone');
        },
    });

    $('.sortable-dropzone').sortable({
        update() {
            const items = {};
            $('.file-sort').each(function(index, value) {
                const id = $(this).attr('data-file-id');
                items[id] = index;
            });

            $.ajax({
                type: 'post',
                url: dashboard.prefix('/systems/files/sort'),
                data: {
                    _token: $("meta[name='csrf_token']").attr('content'),
                    files: items,
                },
                dataType: 'html',
                success(response) {
                    console.log(response);
                },
            });
        },
    });
});
