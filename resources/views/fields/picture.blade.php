@component($typeForm, get_defined_vars())
    <div data-controller="fields--picture"
         data-fields--picture-value="{{ $attributes['value'] }}"
         data-fields--picture-storage="{{ $storage ?? 'public' }}"
         data-fields--picture-target="{{ $target }}"
         data-fields--picture-url="{{ $url }}"
    >
        <div class="b text-right wrapper picture-actions">

            <div class="fields-picture-container">
                <img src="#" class="picture-preview img-fluid img-full m-b-md b" alt="">
            </div>

            <span class="mt-1 float-left">{{ __('Upload image from your computer:') }}</span>

            <label class="btn btn-default m-n">
                <i class="icon-cloud-upload mr-2"></i> {{ __('Browse') }}
                <input type="file"
                       accept="image/*"
                       data-target="fields--picture.upload"
                       data-action="change->fields--picture#upload"
                       class="d-none">
            </label>

            <button type="button" class="btn btn-outline-danger picture-remove"
                    data-action="fields--picture#clear">{{ __('Remove') }}</button>

            <input type="file"
                   accept="image/*"
                   class="d-none">
        </div>

        <input class="picture-path"
               type="hidden"
               data-target="fields--picture.source"
            @attributes($attributes)
        >
    </div>
@endcomponent
