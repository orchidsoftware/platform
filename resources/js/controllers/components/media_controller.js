import {Controller} from "stimulus"
import Dropzone     from 'dropzone';

export default class extends Controller {
    /**
     *
     * @type {string[]}
     */
    static targets = [
        "src",
        "type",
        "name",
        "size",
        "modified",
    ];

    /**
     *
     */
    connect() {
        let media = this;
        this.path = this.data.get('path');
        this.baseUrl = this.data.get('baseurl');
        this.CSRF_TOKEN = $('meta[name="csrf_token"]').attr('content');

        $('.media-file').on('click', '.media-view', (event) => {
            media.view(event.target);
        });

        $('.media-file').on('click', '.media-getlink', (event) => {
            media.get_link(event.target);
        });

        $('.media-file').on('click', '.media-delete', (event) => {
            media.delete(event.target);
        });

        $('.media-file').on('click', '.media-rename', (event) => {
            media.rename(event.target);
        });

        $('.media-file').on('click', '.media-move', (event) => {
            media.move(event.target);
        });

        $('#new_folder').click(() => {
            media.new_folder();
        });

        const DropzoneOptions = media.dropzone_options();
        Dropzone.autoDiscover = false;

        const filemanagerDropzone = new Dropzone('#filemanager', DropzoneOptions);
        const fileuploadDropzone = new Dropzone('#upload', DropzoneOptions);

    }

    /**
     *
     * @param element
     */
    view(element) {
        let data = $(element)
            .closest('.media-file')
            .data();

        if (data.type == 'directory') {
            data.src = "https://sun1-1.userapi.com/c830400/v830400092/caa37/Oavd1uZzq4Q.jpg";
        }
        this.load_view(data);
    }

    /**
     *
     * @param object
     */
    load_view(object) {
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
            elems[i].style.display = `none`;
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
        elems.style.display = `initial`;
    }

    /**
     * @param element
     */
    get_link(element) {
        let data = $(element)
            .closest('.media-file')
            .data();

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
    delete(element) {
        let data = $(element)
            .closest('.media-file')
            .data();

        $('#confirm_delete_modal .folder_warning').hide();
        $('#confirm_delete_modal .confirm_delete_name').text(data.name);
        $('#confirm_delete_modal').data(data);
        $('#confirm_delete_modal').modal('show');
    }

    /**
     *
     */
    confirm_delete() {
        let data = $('#confirm_delete_modal').data();

        $('#confirm_delete_modal').modal('hide');
        $.post(
            `${this.baseUrl}/delete_file_folder`,
            {
                folder_location: this.path,
                file_folder: data.name,
                type: data.type,
                _token: this.CSRF_TOKEN,
            },
            ({success}) => {
                window.Turbolinks.visit(window.location.toString(), {action: 'replace'});
            },
        );
    }

    /**
     * @param element
     */
    rename(element) {
        let data = $(element)
            .closest('.media-file')
            .data();

        $('#rename_file_modal').data(data);
        $('#rename_file_modal .new_filename').val(data.name);
        $('#rename_file_modal').modal('show');
    }

    /**
     *
     */
    confirm_rename() {
        let data = $('#rename_file_modal').data();
        let new_filename = $('#rename_file_modal .new_filename').val();

        $('#rename_file_modal').modal('hide');
        $.post(
            `${this.baseUrl}/rename_file`,
            {
                folder_location: this.path,
                filename: data.name,
                new_filename: new_filename,
                _token: this.CSRF_TOKEN,
            },
            ({success, error}) => {
                window.Turbolinks.visit(window.location.toString(), {action: 'replace'});
            },
        );
    }

    /**
     * @param element
     */
    move(element) {
        let data = $(element)
            .closest('.media-file')
            .data();

        $('#move_file_modal').data(data);
        $('#move_file_modal .move_file_name').text(data.name);
        $('#move_file_modal .move_folder').val(this.path);
        $('#move_file_modal').modal('show');
    }

    /**
     *
     */
    confirm_move() {
        let data = $('#move_file_modal').data();
        let destination = `${$('#move_file_modal .move_folder').val()}/${data.name}`;

        $('#move_file_modal').modal('hide');
        $.post(
            `${this.baseUrl}/move_file`,
            {
                folder_location: this.path,
                source: data.name,
                destination: destination,
                _token: this.CSRF_TOKEN,
            },
            ({success, error}) => {
                window.Turbolinks.visit(window.location.toString(), {action: 'replace'});
            },
        );

    }

    /**
     *
     */
    new_folder() {
        $('#new_folder_modal').modal('show');
    }

    /**
     *
     */
    confirm_new_folder() {

        let new_folder_path = `${this.path}/${$('#new_folder_modal .new_folder_name').val()}`;

        $('#new_folder_modal').modal('hide');
        $.post(
            `${this.baseUrl}/new_folder`,
            {
                new_folder: new_folder_path,
                _token: this.CSRF_TOKEN,
            },
            ({success}) => {
                window.Turbolinks.visit(window.location.toString(), {action: 'replace'});
                $('#new_folder_modal .new_folder_name').val('');
            },
        );
    }

    /**
     *
     */
    dropzone_options() {
        const CSRF_TOKEN = this.CSRF_TOKEN;
        const path = this.path;
        let previewTemplate = '<table><tr class="media-preview">' +
            '<td class="text-center no-padder media-view"><img class="img-responsive b" data-dz-thumbnail></td>' +
            '<td class="text-left media-view" data-dz-name></td><td></td>' +
            '<td class="text-right media-view" data-dz-size></td>' +
            '<td class="text-center dz-progress">' +
            '<div id="uploadProgress" class="progress active progress-striped" style="display: flex;">' +
            '<div class="progress-bar progress-bar-success" style="width: 0"></div></div></td>' +
            '</tr></table>';
        var loadProgress = document.createElement("div");

        return {
            url: `${this.baseUrl}/upload`,
            previewsContainer: '#filemanager table.table tbody',
            previewTemplate: previewTemplate,

            init: function () {

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
                    loadProgress.style.width = `${uploadProgress}%`;
                });

                this.on('sending', function (file, xhr, formData) {
                    formData.append('_token', CSRF_TOKEN);
                    formData.append('upload_path', path);
                });
            },
            success(e, {success, message}) {
                window.Turbolinks.visit(window.location.toString(), {action: 'replace'});
                $('.media-preview').fadeOut();

            },
            error(e, {message}, xhr) {
                window.Turbolinks.visit(window.location.toString(), {action: 'replace'});
            },
        }
    }
}
