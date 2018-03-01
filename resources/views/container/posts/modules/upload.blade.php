<div class="dropzone" id="post-attachment-dropzone" data-storage="{{$storage ?? 'public'}}">
    <div class="fallback">
        <input type="file" value="" multiple/>
    </div>
    <div class="visual-dropzone sortable-dropzone dropzone-previews">
    </div>
    <div class="dz-message">
        <hr>
        <p><span class="fa-2x icon-cloud-upload"></span></p>
        <p class="font-bold">{{trans('dashboard::post/uploads.title')}}</p>
        <small>{{trans('dashboard::post/uploads.description')}}</small>
    </div>
</div>


<div class="modal fade slide-up disable-scroll" id="modalAttachment" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-times"></i>
                    </button>
                    <h5>{{trans('dashboard::post/uploads.information.title')}}</h5>
                    <p class="m-b-md">{{trans('dashboard::post/uploads.information.sub_title')}}</p>
                </div>
                <div class="modal-body" v-if="active != null">
                    <div class="row justify-content-center">
                        <div class="col-sm-10">
                            <div class="wrapper">

                                <div class="form-group">
                                    <label>{{trans('dashboard::post/uploads.information.system_name')}}</label>
                                    <input type="text" class="form-control" v-model="attachment[active].name" readonly
                                           maxlength="255"
                                           placeholder="{{trans('dashboard::post/uploads.information.system_name')}}">
                                </div>
                                <div class="form-group">
                                    <label>{{trans('dashboard::post/uploads.information.name')}}</label>
                                    <input type="text" class="form-control" v-model="attachment[active].original_name"
                                           maxlength="255"
                                           placeholder="{{trans('dashboard::post/uploads.information.name')}}">
                                </div>
                                <div class="form-group">
                                    <label>{{trans('dashboard::post/uploads.information.alt')}}</label>
                                    <input type="text" class="form-control" v-model="attachment[active].alt"
                                           maxlength="255"
                                           placeholder="{{trans('dashboard::post/uploads.information.alt')}}">
                                </div>
                                <div class="form-group">
                                    <label>{{trans('dashboard::post/uploads.information.description')}}</label>
                                    <textarea class="form-control no-resize" v-model="attachment[active].description"
                                              placeholder="{{trans('dashboard::post/uploads.information.description')}}"
                                              maxlength="255"
                                              rows="3"></textarea>
                                </div>


                                <p class="text-right">
                                    <a v-bind:href="attachment[active].url" target="_blank" class="btn btn-link pull-left"><i class="icon-link"></i>
                                        {{trans('dashboard::post/uploads.information.link')}}
                                    </a>

                                    <button type="button" v-on:click="save"
                                            class="btn btn-default">{{trans('dashboard::common.Apply')}}</button>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    document.addEventListener('turbolinks:load', function() {
      const postDropzone = new Dropzone('.dropzone', {
        url: dashboard.prefix('/systems/files'),
        method: 'post',
        uploadMultiple: false,
        parallelUploads: 100,
        maxFilesize: 9999,
        paramName: 'files',
    	acceptedFiles: '{{ $mime }}',
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

          const instanceDropZone = this;

          const id = $('#post').data('post-id');
          if (id !== undefined) {
            $.ajax({
              type: 'get',
              url: dashboard.prefix('/systems/files/post/' + id),
              data: { _token: $("meta[name='csrf_token']").attr('content') },
              dataType: 'html',
              success: function(data) {
                const images = JSON.parse(data);

                images.forEach(function(item, i, arr) {
                  const mockFile = {
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
    });
</script>
