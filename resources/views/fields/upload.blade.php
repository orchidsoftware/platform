@component('platform::partials.fields.group',get_defined_vars())
<div data-controller="fields--upload" data-upload-storage="{{$storage ?? 'public'}}" data-upload-name="{{$name}}" data-upload-data="{!!htmlspecialchars(json_encode($value), ENT_QUOTES, 'UTF-8')!!}">
  <div class="dropzone">
    <div class="fallback">
      <input type="file" value="" multiple/>
    </div>
    <div class="visual-dropzone sortable-dropzone dropzone-previews">
    </div>
    <div class="dz-message">
      <hr>
      <p>
        <span class="text-2x icon-cloud-upload"></span>
      </p>
      <p class="font-bold">{{trans('platform::post/uploads.title')}}</p>
      <small>{{trans('platform::post/uploads.description')}}</small>
    </div>
  </div>
  <div class="modal fade slide-up disable-scroll" id="modalUploadAttachment" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
      <div class="modal-content-wrapper">
        <div class="modal-content">
          <div class="modal-header clearfix">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <span aria-hidden="true">&times;</span>
            </button>
            <h5>{{trans('platform::post/uploads.information.title')}}</h5>
            <p class="m-b-md">{{trans('platform::post/uploads.information.sub_title')}}</p>
          </div>
          <div class="modal-body">
            <div class="row justify-content-center">
              <div class="col-sm-10">
                <div class="wrapper">

                  <div class="form-group">
                    <label>{{trans('platform::post/uploads.information.system_name')}}</label>
                    <input type="text" class="form-control" data-target="upload.attachment_name" readonly maxlength="255" placeholder="{{trans('platform::post/uploads.information.system_name')}}">
                  </div>
                  <div class="form-group">
                    <label>{{trans('platform::post/uploads.information.name')}}</label>
                    <input type="text" class="form-control" data-target="upload.attachment_original_name" maxlength="255" placeholder="{{trans('platform::post/uploads.information.name')}}">
                  </div>
                  <div class="form-group">
                    <label>{{trans('platform::post/uploads.information.alt')}}</label>
                    <input type="text" class="form-control" data-target="upload.attachment_alt" maxlength="255" placeholder="{{trans('platform::post/uploads.information.alt')}}">
                  </div>
                  <div class="form-group">
                    <label>{{trans('platform::post/uploads.information.description')}}</label>
                    <textarea class="form-control no-resize" data-target="upload.attachment_description" placeholder="{{trans('platform::post/uploads.information.description')}}"
                      maxlength="255" rows="3"></textarea>
                  </div>


                  <p class="text-right">
                    <a data-target="upload.attachment_url" target="_blank " class="btn btn-link pull-left ">
                      <i class="icon-link "></i>
                      {{trans('platform::post/uploads.information.link')}}
                    </a>

                    <button type="button " data-action="click->upload#save" class="btn btn-default ">{{trans('platform::common.apply')}}</button>
                  </p>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endcomponent
