let init = (id, theme) => {
  if (theme == 'modern') {
    plugins =
      'print autosave autoresize preview fullpage paste code searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help';
    toolbar1 =
      'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat';
    inline = false;
  } else {
    plugins =
      'image media table link paste contextmenu textpattern autolink codesample';
    toolbar1 = '';
    inline = true;
  }

  tinymce.init({
    selector: '.tinymce-' + id,
    theme: theme,
    min_height: 300,
    plugins: plugins,
    toolbar1: toolbar1,
    insert_toolbar: 'quickimage quicktable media codesample fullscreen',
    selection_toolbar:
      'bold italic | quicklink h2 h3 blockquote | alignleft aligncenter alignright alignjustify | outdent indent | removeformat ',
    inline: inline,
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
