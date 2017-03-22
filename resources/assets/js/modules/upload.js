$(function () {

    var postDropzone = new Dropzone(".dropzone", {
        url: '/dashboard/tools/files',
        method: "post",
        uploadMultiple: false,
        parallelUploads: 100,
        maxFilesize: 9999,
        paramName: "files",
        maxThumbnailFilesize: 99999,
        previewsContainer: '.visual-dropzone',
        addRemoveLinks: true,
        dictFileTooBig: 'File is big',

        init: function () {
            this.on('completemultiple', function (file, json) {
                $('.sortable-dropzone').sortable('enable');
            });

            var instanceDropZone = this;


            var id = $('#post').data('post-id');
            if (id !== undefined) {

                $.ajax({
                    type: 'get',
                    url: '/dashboard/tools/files/post/' + id,
                    data: {_token: $("meta[name='csrf_token']").attr('content')},
                    dataType: 'html',
                    success: function (data) {
                        var images = JSON.parse(data);

                        images.forEach(function (item, i, arr) {
                            var mockFile = {
                                id: item.id,
                                name: item.original_name,
                                size: item.size,
                                type: item.mime,
                                status: Dropzone.ADDED,
                                url: '/storage/' + item.path + '/' + item.name + '.' + item.extension,
                                data: item
                            };


                            instanceDropZone.emit("addedfile", mockFile);
                            instanceDropZone.emit("thumbnail", mockFile, mockFile.url);
                            instanceDropZone.files.push(mockFile);
                            $(".dz-preview:last-child").attr('data-file-id', item.id).addClass('file-sort');

                        });


                        $('.dz-progress').remove();
                    }
                });
            }


            this.on("sending", function (file, xhr, formData) {
                formData.append("_token", $("meta[name='csrf_token']").attr('content'))
            });

            this.on("removedfile", function (file) {


                $(".files-" + file.data.id).remove();


                $.ajax({
                    type: 'delete',
                    url: '/dashboard/tools/files/' + file.data.id,
                    data: {_token: $("meta[name='csrf_token']").attr('content')},
                    dataType: 'html',
                    success: function (data) {
                        //
                    }
                });

            });
        },
        error: function (file, response) {
            if ($.type(response) === "string") {
                return response; //dropzone sends it's own error messages in string
            }
            return response.message;
        },
        success: function (file, response) {
            file.data = response;
            $(".dz-preview:last-child").attr('data-file-id', response.id).addClass('file-sort');
            $("<input type='hidden' class='files-" + response.id + "' name='files[]' value='" + response.id + "'  />").appendTo('.dropzone');
        },
    });


    $('.sortable-dropzone').sortable({
        update: function () {

            var items = {};
            $('.file-sort').each(function (index, value) {
                var id = $(this).attr('data-file-id');
                items[id] = index;
            });

            $.ajax({
                type: 'post',
                url: '/dashboard/tools/files/sort',
                data: {
                    _token: $("meta[name='csrf_token']").attr('content'),
                    files: items
                },
                dataType: 'html',
                success: function (response) {
                    console.log(response);
                }
            });


        }
    });


});







