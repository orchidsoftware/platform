import {Controller} from "stimulus"
import Dropzone     from 'dropzone';

export default class extends Controller {
    /**
     *
     * @type {string[]}
     */
    static targets = [
        "img",
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
        //console.log(DropzoneOptions);
        Dropzone.autoDiscover = false;

        const filemanagerDropzone = new Dropzone('#filemanager', DropzoneOptions);
        const fileuploadDropzone = new Dropzone('#upload', DropzoneOptions);

/*
        $('#confirm_delete').click(() => {
            media.confirm_delete();
        });

        $('#confirm_rename').click(() => {
            media.confirm_rename();
        });

        $('#confirm_move').click(() => {
            media.confirm_move();
        });
*/

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
            data.img = "https://sun1-1.userapi.com/c830400/v830400092/caa37/Oavd1uZzq4Q.jpg";
        }

        this.load_view(data);
    }

    /**
     *
     * @param object
     */
    load_view(object) {
        this.imgTarget.src = object.img;
        this.typeTarget.textContent  = object.type;
        this.nameTarget.textContent  = object.name;
        this.sizeTarget.textContent  = object.size;
        this.modifiedTarget.textContent  = object.modified;
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
        tempInput.value = data.img;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        //console.log(tempInput.value);
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
    confirm_delete () {
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
             ({ success }) => {
                 window.location.reload();
                 /*
                 if (success == true) {
                    // alert('successfully deleted ' + manager.selected_file.name, "Sweet Success!");
                    //getFiles(manager.folders);
                 } else {
                    alert('Whoops!');
                 }
                 */
             },
        );
        //console.log($('#confirm_delete_modal').data());
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
    confirm_rename () {
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
            ({ success, error }) => {
                window.location.reload();
                /*
                if (success == true) {
                    //alert('Successfully renamed file/folder', "Sweet Success!");
                    //getFiles(manager.folders);

                } else {
                    alert(error, 'Whoops!');
                }
                */
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
    confirm_move () {
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
            ({ success, error }) => {
                window.location.reload();
            },
        );

    }

    /**
     *
     */
    new_folder () {
        $('#new_folder_modal').modal('show');
    }

    /**
     *
     */
    confirm_new_folder(){

        let new_folder_path = `${this.path}/${$('#new_folder_modal .new_folder_name').val()}`;

        $('#new_folder_modal').modal('hide');
        $.post(
            `${this.baseUrl}/new_folder`,
            {
                new_folder: new_folder_path,
                _token: this.CSRF_TOKEN,
            },
            ({ success }) => {
                /*
                if (success == true) {
                    // alert('successfully created ' + $('#new_folder_name').val(), "Sweet Success!");
                    getFiles(manager.folders);
                } else {
                    alert('Whoops!');
                }
                 */
                window.location.reload();
                $('#new_folder_modal .new_folder_name').val('');
            },
        );
    }

    /**
     *
     */
    dropzone_options () {
        const CSRF_TOKEN = this.CSRF_TOKEN;
        const path = this.path;
        let previewTemplate='<table><tr class="media-preview">' +
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
                /*
                this.on('processing', function (e) {
                    $('#uploadPreview').fadeIn();
                    $('#uploadProgress').fadeIn();
                });
                */
            },
            success(e, {success, message}) {
                window.location.reload();

                $('.media-preview').fadeOut();
                /*
                if (success) {
                    alert("Sweet Success!");
                } else {
                    alert(message);
                }
                */
            },
            error(e, {message}, xhr) {
                /*
                alert(message);
                $('.media-preview').fadeOut();
                 */
            },
        }
    }
}
