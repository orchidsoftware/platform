document.addEventListener('turbolinks:load', function() {
  if (document.getElementById('post-attachment-dropzone') === null) {
    return;
  }

  var attachmentDescription = new Vue({
    el: '#modalAttachment',
    data: {
      attachment: {},
      active: null,
    },
    methods: {
      loadInfo: function(data) {
        let name = data.name + data.id;

        if (!this.attachment.hasOwnProperty(name)) {
          this.attachment[name] = data;
        }
        this.active = name;
      },
      save: function() {
        let data = this.attachment[this.active];

        $('#modalAttachment').modal('toggle');

        $.ajax({
          type: 'POST',
          url: dashboard.prefix('/systems/files/post/' + data.id),
          data: {
            _token: $("meta[name='csrf_token']").attr('content'),
            attachment: data,
            _method: 'PUT',
          },
          dataType: 'html',
          success: function(data) {
            console.log('file update');
          },
        });
      },
    },
  });

  var postDropzone = new Dropzone('.dropzone', {
    url: dashboard.prefix('/systems/files'),
    method: 'post',
    uploadMultiple: false,
    parallelUploads: 100,
    maxFilesize: 9999,
    paramName: 'files',
    maxThumbnailFilesize: 99999,
    previewsContainer: '.visual-dropzone',
    //previewTemplate: document.getElementById('preview-template').innerHTML,
    addRemoveLinks: false,
    dictFileTooBig: 'File is big',

    init: function() {
      this.on('addedfile', function(e) {
        var n = Dropzone.createElement(
            "<a href='javascript:;'' class='btn-remove'><i class='fa fa-times' aria-hidden='true'></i></a>",
          ),
          t = this;
        n.addEventListener('click', function(n) {
          n.preventDefault(), n.stopPropagation(), t.removeFile(e);
        }),
          e.previewElement.appendChild(n);

        var n = Dropzone.createElement(
            "<a href='javascript:;'' class='btn-edit'><i class='icon-note' aria-hidden='true'></i></a>",
          ),
          t = this;
        n.addEventListener('click', function(n) {
          attachmentDescription.loadInfo(e.data);
          $('#modalAttachment').modal('show');
        }),
          e.previewElement.appendChild(n);
      });

      this.on('completemultiple', function(file, json) {
        $('.sortable-dropzone').sortable('enable');
      });

      var instanceDropZone = this;

      var id = $('#post').data('post-id');
      if (id !== undefined) {
        $.ajax({
          type: 'get',
          url: dashboard.prefix('/systems/files/post/' + id),
          data: { _token: $("meta[name='csrf_token']").attr('content') },
          dataType: 'html',
          success: function(data) {
            var images = JSON.parse(data);

            images.forEach(function(item, i, arr) {
              var mockFile = {
                id: item.id,
                name: item.original_name,
                size: item.size,
                type: item.mime,
                status: Dropzone.ADDED,
                url: '/storage/' + item.path + item.name + '.' + item.extension,
                data: item,
              };

              instanceDropZone.emit('addedfile', mockFile);
              instanceDropZone.emit('thumbnail', mockFile, mockFile.url);
              instanceDropZone.files.push(mockFile);
              $('.dz-preview:last-child')
                .attr('data-file-id', item.id)
                .addClass('file-sort');
            });

            $('.dz-progress').remove();
          },
        });
      }

      this.on('sending', function(file, xhr, formData) {
        formData.append('_token', $("meta[name='csrf_token']").attr('content'));
        formData.append(
          'storage',
          $('#post-attachment-dropzone').data('storage'),
        );
      });

      this.on('removedfile', function(file) {
        $('.files-' + file.data.id).remove();

        $.ajax({
          type: 'delete',
          url: dashboard.prefix('/systems/files/' + file.data.id),
          data: {
            _token: $("meta[name='csrf_token']").attr('content'),
            storage: $('#post-attachment-dropzone').data('storage'),
          },
          dataType: 'html',
          success: function(data) {
            //
          },
        });
      });
    },
    error: function(file, response) {
      if ($.type(response) === 'string') {
        return response; //dropzone sends it's own error messages in string
      }
      return response.message;
    },
    success: function(file, response) {
      file.data = response;
      $('.dz-preview:last-child')
        .attr('data-file-id', response.id)
        .addClass('file-sort');
      $(
        "<input type='hidden' class='files-" +
          response.id +
          "' name='files[]' value='" +
          response.id +
          "'  />",
      ).appendTo('.dropzone');
    },
  });

  $('.sortable-dropzone').sortable({
    update: function() {
      var items = {};
      $('.file-sort').each(function(index, value) {
        var id = $(this).attr('data-file-id');
        items[id] = index;
      });

      $.ajax({
        type: 'post',
        url: dashboard.prefix('/systems/files/sort'),
        data: {
          _token: $("meta[name='csrf_token']").attr('content'),
          files: items,
        },
        dataType: 'html',
        success: function(response) {
          console.log(response);
        },
      });
    },
  });
});
