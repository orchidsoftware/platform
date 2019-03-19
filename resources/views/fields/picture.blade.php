@component($typeForm,get_defined_vars())
    <div data-controller="fields--picture"
         data-fields--picture-image="{{$attributes['value']}}"
         data-fields--picture-storage="{{$storage ?? 'public'}}"
         data-fields--picture-width="{{$width}}"
         data-fields--picture-height="{{$height}}">
        <div class="b text-right wrapper picture-actions">

            <div class="fields--picture-container">
                <img src="#" class="picture-preview img-fluid img-full m-b-md b" alt="">
            </div>

            <span class="mt-1 float-left">{{ __('Upload image from your computer:') }}</span>

            <label class="btn btn-default m-n">
                <i class="icon-cloud-upload"></i> {{ __('Browse') }}
                <input type="file"
                       accept="image/*"
                       data-target="fields--picture.upload"
                       data-action="change->fields--picture#upload click->fields--picture#openModal"
                       class="d-none">
            </label>

            <button type="button" class="btn btn-outline-danger picture-remove"
                    data-action="fields--picture#clear">{{ __('Remove') }}</button>

            <input type="file" class="d-none">
        </div>

        <input class="picture-path"
               type="hidden"
               data-target="fields--picture.source"
                @include('platform::partials.fields.attributes', ['attributes' => $attributes])
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
                                    data-action="fields--picture#crop">
                                {{ __('Crop') }}
                            </button>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endcomponent