@component($typeForm, get_defined_vars())
    <div data-controller="fields--cropper"
         data-fields--cropper-value="{{ $attributes['value'] }}"
         data-fields--cropper-storage="{{ $storage ?? 'public' }}"
         data-fields--cropper-width="{{ $width }}"
         data-fields--cropper-height="{{ $height }}"
         data-fields--cropper-target="{{ $target }}"
         data-fields--cropper-url="{{ $url }}"
    >
        <div class="b text-right wrapper cropper-actions">

            <div class="fields-cropper-container">
                <img src="#" class="cropper-preview img-fluid img-full m-b-md b" alt="">
            </div>

            <span class="mt-1 float-left">{{ __('Upload image from your computer:') }}</span>

            <label class="btn btn-default m-n">
                <i class="icon-cloud-upload"></i> {{ __('Browse') }}
                <input type="file"
                       accept="image/*"
                       data-target="fields--cropper.upload"
                       data-action="change->fields--cropper#upload click->fields--cropper#openModal"
                       class="d-none">
            </label>

            <button type="button" class="btn btn-outline-danger cropper-remove"
                    data-action="fields--cropper#clear">{{ __('Remove') }}</button>

            <input type="file"
                   accept="image/*"
                   class="d-none">
        </div>

        <input class="cropper-path"
               type="hidden"
               data-target="fields--cropper.source"
            @attributes($attributes)
        >

        <div class="modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content-wrapper">
                    <div class="modal-content">
                        <div class="position-relative">
                            <img class="upload-panel">
                        </div>

                        <div class="modal-footer">

                            <button type="button"
                                    class="btn btn-link"
                                    data-dismiss="modal">
                                {{ __('Close') }}
                            </button>

                            <button type="button"
                                    class="btn btn-default"
                                    data-action="fields--cropper#crop">
                                {{ __('Crop') }}
                            </button>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endcomponent
