$('.form-image-upload').dropzone({
    url: '/dashboard/tools/filemanager/upload',
    method: "post",
    uploadMultiple: true,
    parallelUploads: 10,
    clickable: true,
    maxFilesize: 100,
    //previewsContainer: '.dropzonePreview',
    addRemoteLinks: true,
    paramName: "images",
    acceptedFiles: 'image/*',
    init: function () {
    },
    error: function (file,response) {
        console.log(response);
    },
    success:function (file,response) {
        photo_counter++;
        console.log(file);
    }
});
