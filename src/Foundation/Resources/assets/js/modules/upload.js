if (document.getElementsByClassName('dropzone')) {

    var photo_counter = 0;
    Dropzone.options.realDropzone = {
        url: '/dashboard/tools/files',
        method: "post",
        uploadMultiple: false,
        parallelUploads: 100,
        maxFilesize: 20,
        paramName: "images",
        //previewsContainer: '.dropzonePreview',
        //previewTemplate: document.querySelector('.preview-template').innerHTML,
        addRemoveLinks: true,
       // dictRemoveFile: 'Remove',
        dictFileTooBig: 'Image is bigger than 20MB',

        // The setting up of the dropzone
        init: function () {
            var instanceDropZone = this;

            var id = $('#post').data('post-id');
            if(id !== undefined){

                $.ajax({
                    type: 'get',
                    url: '/dashboard/tools/files/post/' + id,
                    data: { _token: $("meta[name='csrf_token']").attr('content')},
                    dataType: 'html',
                    success: function (data) {
                        var images = JSON.parse(data);

                        images.forEach(function(item, i, arr) {
                            var mockFile = {
                                name: item.original_name,
                                size: item.size,
                                type: item.mime,
                                status: Dropzone.ADDED,
                                url: '/storage/'+ item.path + '/' + item.name + '.' + item.extension,
                                data: item
                            };

                            // Call the default addedfile event handler
                            instanceDropZone.emit("addedfile", mockFile);

                            // And optionally show the thumbnail of the file:
                            instanceDropZone.emit("thumbnail", mockFile, mockFile.url);

                            instanceDropZone.files.push(mockFile);




                            /*
                            this.options.addedfile.call(this, mockFile);
                            this.options.thumbnail.call(this, mockFile, '/storage/'+ item.path + '/' + item.name);
                            mockFile.previewElement.classList.add('dz-success');
                            */
                        });


                        $('.dz-progress').remove();
                        console.log(JSON.parse(data));
                    }
                });
            }







            //mockFile.previewElement.classList.add('dz-complete');



            this.on("sending", function (file, xhr, formData) {
                formData.append("_token", $("meta[name='csrf_token']").attr('content'))
            });

            this.on("removedfile", function (file) {


                $( ".files-"+file.data.id).remove();


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
            if ($.type(response) === "string")
                var message = response; //dropzone sends it's own error messages in string
            else
                var message = response.message;
            file.previewElement.classList.add("dz-error");
            _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i];
                _results.push(node.textContent = message);
            }
            return _results;
        },
        success: function (file, response) {
            file.data = response;



            $("<input type='hidden' class='files-"+ response.id+"' name='files[]' value='"+ response.id +"'  />").appendTo('.dropzone');

/*
            var value = $( "#files" ).val() || [];
            value.push(response.id);
            $( "#files" ).val(value);
            */
        },
    }

}