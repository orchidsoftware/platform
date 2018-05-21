@component('platform::partials.fields.group',get_defined_vars())
<div data-controller="fields--picture"
     data-fields--picture-image="{{$attributes['value']}}"
     data-fields--picture-width="{{$width}}"
     data-fields--picture-height="{{$height}}">
    <div class="b text-center wrapper-lg picture-actions">

        <div class="picture-container m-b-md">
            <img src="#" class="picture-preview img-fluid img-thumbnail" alt=""/>
        </div>

        <label class="btn btn-link">
            <i class="icon-cloud-upload"></i> {{trans('platform::field.picture.Browse')}}
            <input type="file"
                   accept="image/*"
                   data-target="picture.upload"
                   data-action="fields--picture#upload"
                   class="picture-input-file-{{$lang}}-{{$slug}} d-none">
        </label>

        <button type="button" class="btn btn-danger picture-remove" data-action="fields--picture#clear">{{trans('platform::field.picture.Remove')}}</button>

        <input type="file" class="picture-input-file-{{$lang}}-{{$slug}} d-none">
    </div>

    <input class="picture-path"
           type="hidden"
           data-target="picture.source"
           @include('platform::partials.fields.attributes', ['attributes' => $attributes])
    >

    <div id="picture-crop-modal-{{$lang}}-{{$slug}}" class="modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix">
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span
                                    aria-hidden="true">×</span></button>
                        <h5>{{trans('platform::field.picture.Crop image')}}</h5>
                    </div>
                    <div>
                        <div class="upload-panel"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-action="fields--picture#crop">{{trans('platform::field.picture.Crop')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('platform::field.Close')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endcomponent