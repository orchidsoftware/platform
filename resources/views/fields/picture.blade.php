@component($typeForm, get_defined_vars())
    <div data-controller="fields--picture"
         data-fields--picture-value="{{ $attributes['value'] }}"
         data-fields--picture-storage="{{ $storage ?? 'public' }}"
         data-fields--picture-target="{{ $target }}"
         data-fields--picture-url="{{ $url }}"
         data-fields--picture-max-file-size="{{ $maxFileSize }}"
         data-fields--picture-groups="{{$attributes['groups'] ?? ''}}"
    >
        <div class="border-dashed text-right p-3 picture-actions">

            <div class="fields-picture-container">
                <img src="#" class="picture-preview img-fluid img-full mb-2 border" alt="">
            </div>

            <span class="mt-1 float-left">{{ __('Upload image from your computer:') }}</span>

            <div class="btn-group">
                <label class="btn btn-default m-0">
                    <x-orchid-icon path="cloud-upload" class="mr-2"/>

                    {{ __('Browse') }}
                    <input type="file"
                           accept="image/*"
                           data-target="fields--picture.upload"
                           data-action="change->fields--picture#upload"
                           class="d-none">
                </label>

                <button type="button" class="btn btn-outline-danger picture-remove"
                        data-action="fields--picture#clear">{{ __('Remove') }}</button>
            </div>

            <input type="file"
                   accept="image/*"
                   class="d-none">
        </div>

        <input class="picture-path d-none"
               type="text"
               data-target="fields--picture.source"
               {{ $attributes }}
        >
    </div>
@endcomponent
