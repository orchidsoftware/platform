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

            this.on("sending", function (file, xhr, formData) {
                formData.append("_token", $("meta[name='csrf_token']").attr('content'))
            });

            this.on("removedfile", function (file) {

                $.ajax({
                    type: 'POST',
                    url: 'upload/delete',
                    data: {id: file.name, _token: $("meta[name='csrf_token']").attr('content')},
                    dataType: 'html',
                    success: function (data) {
                        var rep = JSON.parse(data);
                        if (rep.code == 200) {
                            photo_counter--;
                            $("#photoCounter").text("(" + photo_counter + ")");
                        }

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
        success: function (file, done) {
            photo_counter++;
            $("#photoCounter").text("(" + photo_counter + ")");
        },
    }

}