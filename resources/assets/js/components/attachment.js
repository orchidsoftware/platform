document.addEventListener('turbolinks:load', function() {
  if (document.getElementById('post-attachment-dropzone') === null) {
    return;
  }

  const attachmentDescription = new Vue({
    el: '#modalAttachment',
    data: {
      attachment: {},
      active: null,
    },
    methods: {
      loadInfo: function(data) {
        let name = data.name + data.id;

        data.url = '/storage/' + data.path + data.name + '.' + data.extension;

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

  $('.sortable-dropzone').sortable({
    update: function() {
      const items = {};
      $('.file-sort').each(function(index, value) {
        const id = $(this).attr('data-file-id');
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
