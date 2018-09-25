document.addEventListener('turbolinks:load', () => {
    if (document.getElementById('filemanager') === null) {
        return;
    }

    const manager = new Vue({
        el: '#filemanager',
        data: {
            files: '',
            folders: [],
            selected_file: '',
            directories: [],
            new_filename: '',
        },
    });

    CSRF_TOKEN = $('meta[name="csrf_token"]').attr('content');

    const managerMedia = function (o) {
        const files = $('#files');
        const options = $.extend(true, {}, o);
        this.init = () => {
            const DropzoneOptions = {
                url: `${options.baseUrl}/media/upload`,
                previewsContainer: '#uploadPreview',
                totaluploadprogress(uploadProgress, totalBytes, totalBytesSent) {
                    $('#uploadProgress .progress-bar').css('width', `${uploadProgress}%`);
                    if (uploadProgress == 100) {
                        $('#uploadProgress')
                            .delay(1500)
                            .slideUp(() => {
                                $('#uploadProgress .progress-bar').css('width', '0%');
                            });
                    }
                },
                processing() {
                    // $('#uploadProgress').fadeIn();
                },
                sending(file, xhr, formData) {
                    formData.append('_token', CSRF_TOKEN);
                    formData.append('upload_path', manager.folders);
                },
                success(e, { success, message }) {
                    if (success) {
                        // alert("Sweet Success!");
                    } else {
                        alert(message);
                    }
                },
                error(e, { message }, xhr) {
                    alert(message);
                },
                queuecomplete() {
                    getFiles(manager.folders);
                },
            };

            Dropzone.autoDiscover = false;

            const filemanagerDropzone = new Dropzone('#filemanager', DropzoneOptions);
            const fileuploadDropzone = new Dropzone('#upload', DropzoneOptions);

            getFiles('/');

            files.on('dblclick', 'li .file_link', function () {
                if (
                    !$(this)
                        .children('.details')
                        .hasClass('folder')
                ) {
                    return false;
                }
                manager.folders.push(this.dataset.folder);
                getFiles(manager.folders);
            });

            files.on('click', 'li', ({ target }) => {
                let clicked = target;
                if (!$(clicked).hasClass('file_link')) {
                    clicked = $(target).closest('.file_link');
                }
                setCurrentSelected(clicked);
            });

            $('.breadcrumb').on('click', 'li', function () {
                const index = $(this).data('index');
                manager.folders = manager.folders.splice(0, index);
                getFiles(manager.folders);
            });

            /** ******** TOOLBAR BUTTONS ********* */
            $('#refresh').click(() => {
                getFiles(manager.folders);
            });

            $('#new_folder_modal').on('shown.bs.modal', () => {
                $('#new_folder_name').focus();
            });

            $('#new_folder_name').keydown(({ which }) => {
                if (which == 13) {
                    $('#new_folder_submit').trigger('click');
                }
            });

            $('#move_file_modal').on('hidden.bs.modal', () => {
                $('#s2id_move_folder_dropdown').select2('close');
            });

            $('#new_folder_submit').click(() => {
                new_folder_path = `${manager.files.path}/${$('#new_folder_name').val()}`;
                $.post(
                    `${options.baseUrl}/media/new_folder`,
                    {
                        new_folder: new_folder_path,
                        _token: CSRF_TOKEN,
                    },
                    ({ success }) => {
                        if (success == true) {
                            // alert('successfully created ' + $('#new_folder_name').val(), "Sweet Success!");
                            getFiles(manager.folders);
                        } else {
                            alert('Whoops!');
                        }
                        $('#new_folder_name').val('');
                        $('#new_folder_modal').modal('hide');
                    },
                );
            });

            $('#delete').click(() => {
                if (manager.selected_file.type == 'directory') {
                    $('.folder_warning').show();
                } else {
                    $('.folder_warning').hide();
                }
                $('.confirm_delete_name').text(manager.selected_file.name);
                $('#confirm_delete_modal').modal('show');
            });

            $('#confirm_delete').click(() => {
                $.post(
                    `${options.baseUrl}/media/delete_file_folder`,
                    {
                        folder_location: manager.folders,
                        file_folder: manager.selected_file.name,
                        type: manager.selected_file.type,
                        _token: CSRF_TOKEN,
                    },
                    ({ success }) => {
                        if (success == true) {
                            // alert('successfully deleted ' + manager.selected_file.name, "Sweet Success!");
                            getFiles(manager.folders);
                            $('#confirm_delete_modal').modal('hide');
                        } else {
                            alert('Whoops!');
                        }
                    },
                );
            });

            $('#move').click(() => {
                $('#move_file_modal').modal('show');
            });

            $('#rename').click(() => {
                if (typeof manager.selected_file !== 'undefined') {
                    $('#rename_file').val(manager.selected_file.name);
                }
                $('#rename_file_modal').modal('show');
            });

            $('#move_folder_dropdown').keydown(({ which }) => {
                if (which == 13) {
                    $('#move_btn').trigger('click');
                }
            });

            $('#move_btn').click(() => {
                source = manager.selected_file.name;
                destination = `${$('#move_folder_dropdown').val()}/${manager.selected_file.name}`;
                $('#move_file_modal').modal('hide');
                $.post(
                    `${options.baseUrl}/media/move_file`,
                    {
                        folder_location: manager.folders,
                        source,
                        destination,
                        _token: CSRF_TOKEN,
                    },
                    ({ success, error }) => {
                        if (success == true) {
                            // alert('Successfully moved file/folder', "Sweet Success!");
                            getFiles(manager.folders);
                        } else {
                            alert(error, 'Whoops!');
                        }
                    },
                );
            });

            $('#rename_btn').click(() => {
                source = manager.selected_file.path;
                filename = manager.selected_file.name;
                new_filename = manager.new_filename;
                $('#rename_file_modal').modal('hide');
                $.post(
                    `${options.baseUrl}/media/rename_file`,
                    {
                        folder_location: manager.folders,
                        filename,
                        new_filename,
                        _token: CSRF_TOKEN,
                    },
                    ({ success, error }) => {
                        if (success == true) {
                            // alert('Successfully renamed file/folder', "Sweet Success!");
                            getFiles(manager.folders);
                        } else {
                            alert(error, 'Whoops!');
                        }
                    },
                );
            });

            /** ******** END TOOLBAR BUTTONS ********* */

            manager.$watch('files', ({ items }, oldVal) => {
                setCurrentSelected($('*[data-index="0"]'));
                $('#filemanager #content #files').hide();
                $('#filemanager #content #files').fadeIn('fast');
                $('#filemanager .loader').fadeOut(() => {
                    $('#filemanager #content').fadeIn();
                });

                if (items.length < 1) {
                    $('#no_files').show();
                } else {
                    $('#no_files').hide();
                }
            });

            manager.$watch('directories', (newVal, oldVal) => {
                if ($('#move_folder_dropdown').select2()) {
                    $('#move_folder_dropdown').select2('destroy');
                }
                $('#move_folder_dropdown').select2();
            });

            manager.$watch('selected_file', (newVal, oldVal) => {
                if (typeof newVal === 'undefined') {
                    $('.right_details').hide();
                    $('.right_none_selected').show();
                    $('#move').attr('disabled', true);
                    $('#delete').attr('disabled', true);
                } else {
                    $('.right_details').show();
                    $('.right_none_selected').hide();
                    $('#move').removeAttr('disabled');
                    $('#delete').removeAttr('disabled');
                }
            });

            function getFiles(folders) {
                var folder_location = '/';

                if (folders != '/') {
                    var folder_location = `/${folders.join('/')}`;
                }

                $('#file_loader').fadeIn();

                $.post(
                    `${options.baseUrl}/media/directories`,
                    {
                        folder_location: manager.folders,
                        _token: CSRF_TOKEN,
                    },
                    (data) => {
                        manager.directories = data;
                    },
                );

                $.post(
                    `${options.baseUrl}/media/files`,
                    {
                        folder: folder_location,
                        _token: CSRF_TOKEN,
                        _token: CSRF_TOKEN,
                    },
                    (data) => {
                        $('#file_loader').hide();
                        manager.files = data;
                        files.trigger('click');
                        for (let i = 0; i < manager.files.items.length; i++) {
                            if (typeof manager.files.items[i].size !== undefined) {
                                manager.files.items[i].size = bytesToSize(
                                    manager.files.items[i].size,
                                );
                            }
                        }
                    },
                );
            }

            function setCurrentSelected(cur) {
                $('#files li .selected').removeClass('selected');
                $(cur).addClass('selected');
                manager.selected_file = manager.files.items[$(cur).data('index')];
                manager.new_filename = manager.selected_file.name;
            }

            function bytesToSize(bytes) {
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                if (bytes == 0) return '0 Bytes';
                const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                return `${Math.round(bytes / (1024 ** i), 2)} ${sizes[i]}`;
            }
        };
    };

    const media = new managerMedia({
        baseUrl: $('#filemanager').data('url'),
    });

    media.init();
});
