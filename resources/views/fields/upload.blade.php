@component($typeForm,get_defined_vars())

<div
        data-controller="fields--upload"
        data-fields--upload-storage="{{$storage ?? 'public'}}"
        data-fields--upload-name="{{$name}}"
        data-fields--upload-id="dropzone-{{$id}}"
        data-fields--upload-data="{!!htmlspecialchars(json_encode($value), ENT_QUOTES, 'UTF-8')!!}"
        data-fields--upload-groups="{{$attributes['groups'] ?? ''}}"
        data-fields--upload-multiple="{{$attributes['multiple']}}"
        data-fields--upload-parallelUploads="{{$attributes['parallelUploads']}}"
        data-fields--upload-maxFileSize="{{$attributes['maxFileSize']}}"
        data-fields--upload-maxFiles="{{$attributes['maxFiles']}}"
        data-fields--upload-acceptedFiles="{{$attributes['acceptedFiles']}}"
        data-fields--upload-resizeQuality="{{$attributes['resizeQuality']}}"
        data-fields--upload-resizeWidth="{{$attributes['resizeWidth']}}"
        data-fields--upload-resizeHeight="{{$attributes['resizeHeight']}}"

>
 <div id="dropzone-{{$id}}" class="dropzone-wrapper">
    <div class="fallback">
      <input type="file" value="" multiple/>
    </div>
    <div class="visual-dropzone sortable-dropzone dropzone-previews">
    </div>
    <div class="dz-message">
      <hr>
      <p class="m-t-md">
        <span class="text-2x icon-cloud-upload"></span>
      </p>
      <p class="font-bold">{{__('Drag files here or click to download.')}}</p>
      <small class="w-b-k">{{__('(Files are processed automatically, you just need to specify their order)')}}</small>
    </div>


     <div class="modal fade slide-up disable-scroll" tabindex="-1" role="dialog" aria-hidden="false">
         <div class="modal-dialog">
             <div class="modal-content-wrapper">
                 <div class="modal-content">
                     <div class="modal-header clearfix">
                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                             <span aria-hidden="true">&times;</span>
                         </button>
                         <h5>{{__('File Information')}}</h5>
                         <p class="m-b-md">{{__('Information to display')}}</p>
                     </div>
                     <div class="modal-body">
                         <div class="row justify-content-center">
                             <div class="col-sm-10">
                                 <div class="wrapper">

                                     <div class="form-group">
                                         <label>{{__('System Name')}}</label>
                                         <input type="text" class="form-control" data-target="fields--upload.name" readonly maxlength="255">
                                     </div>
                                     <div class="form-group">
                                         <label>{{ __('Display Name') }}</label>
                                         <input type="text" class="form-control" data-target="fields--upload.original" maxlength="255" placeholder="{{ __('Display Name') }}">
                                     </div>
                                     <div class="form-group">
                                         <label>{{ __('Alternative Text') }}</label>
                                         <input type="text" class="form-control" data-target="fields--upload.alt" maxlength="255" placeholder="{{  __('Alternative Text')  }}">
                                     </div>
                                     <div class="form-group">
                                         <label>{{ __('Description') }}</label>
                                         <textarea class="form-control no-resize"
                                                   data-target="fields--upload.description"
                                                   placeholder="{{ __('Description') }}"
                                                   maxlength="255"
                                                   rows="3">

                    </textarea>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="modal-footer">
                         <button type="button" data-action="click->fields--upload#openLink" class="btn btn-link ">
                             <i class="icon-link"></i>
                             {{__('Link')}}
                         </button>
                         <button type="button" data-action="click->fields--upload#save" class="btn btn-default">
                             {{__('Apply')}}
                         </button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
</div>
@endcomponent
