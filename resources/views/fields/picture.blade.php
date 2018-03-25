@component('dashboard::partials.fields.group',get_defined_vars())
<div data-controller="picture"
     data-picture-image="{{$attributes['value']}}"
     data-picture-width="{{$width}}"
     data-picture-height="{{$height}}">
    <div class="b text-center wrapper-lg picture-actions">

        <div class="picture-container m-b-md">
                <img src="#" class="picture-preview img-fluid img-thumbnail" alt=""/>
        </div>

        <label class="btn btn-link">
            <i class="icon-cloud-upload"></i> Browse
            <input type="file"
                   accept="image/*"
                   data-target="picture.upload"
                   data-action="picture#upload"
                   class="picture-input-file-{{$lang}}-{{$slug}} d-none">
        </label>

        <button type="button" class="btn btn-danger picture-remove" data-action="picture#clear">Remove</button>

        <input type="file" class="picture-input-file-{{$lang}}-{{$slug}} d-none">
    </div>

    <input class="picture-path"
           type="hidden"
           data-target="picture.source"
           @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])
    >

    <div id="picture-crop-modal-{{$lang}}-{{$slug}}" class="modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="fa fa-times"></i>
                        </button>
                        <h5>Crop image</h5>
                    </div>
                    <div>
                        <div class="upload-panel">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-action="picture#crop">Crop</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endcomponent