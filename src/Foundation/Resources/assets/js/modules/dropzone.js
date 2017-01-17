
/*
$("#dropzone").dropzone({
    paramName: "file",
    maxFilesize: 2,
    url: "/dashboard/tools/files",
    clickable: true,
    acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
    addRemoveLinks: true,
    init:function(){
        var self = this;



        this.on("removedfile", function(file) {

            console.log(file);


            $.ajax({
                type: 'delete',
                url: '/dashboard/tools/files',
                data: {id: file.name, _token: $('#csrf-token').val()},
                dataType: 'html',
                success: function(data){

                }
            });

        } );




        // config
       // self.options.addRemoveLinks = true;
        //self.options.dictRemoveFile = "Delete";
        //New file added

        /*
        self.on("addedfile", function (file) {
            console.log('new file added ', file);
        });
        // Send file starts
        self.on("sending", function (file) {
            console.log('upload started', file);
            $('.meter').show();
        });

        // File upload Progress
        self.on("totaluploadprogress", function (progress) {
            console.log("progress ", progress);
            $('.roller').width(progress + '%');
        });

        self.on("queuecomplete", function (progress) {
            $('.meter').delay(999).slideUp(999);
        });
         */


        // On removing file
/*
        self.on("removedfile", function (file) {
            console.log(file);
        });

    }
});
*/