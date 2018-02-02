let init = id => {
  tinymce.init({
    selector: '.tinymce-' + id,
    theme: 'inlite',
    min_height: 300,
    plugins:
      'image media table link paste contextmenu textpattern autolink codesample',
    insert_toolbar: 'quickimage quicktable media codesample fullscreen',
    selection_toolbar:
      'bold italic | quicklink h2 h3 blockquote | alignleft aligncenter alignright alignjustify | outdent indent | removeformat ',
    inline: true,
    convert_urls: false,
    image_caption: true,
    image_title: true,
    image_class_list: [
      { title: 'None', value: '' },
      { title: 'Responsive', value: 'img-fluid' },
    ],

    setup: function(ed) {
      ed.on('change', function() {
        $('#' + id).val(ed.getContent());
      });
    },
    // we override default upload handler to simulate successful upload
    images_upload_handler: function(blobInfo, success) {
      let data = new FormData();
      data.append('file', blobInfo.blob());

      axios
        .post(dashboard.prefix('/systems/files'), data)
        .then(function(response) {
          success(
            '/storage/' +
              response.data.path +
              response.data.name +
              '.' +
              response.data.extension,
          );
        })
        .catch(function(error) {
          console.log(error);
        });
    },
  });
};

export { init };
