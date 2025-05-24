<div data-controller="picture"
     data-picture-value="{{ $attributes['value'] }}"
     data-picture-storage="{{ $storage ?? config('platform.attachment.disk', 'public') }}"
     data-picture-target="{{ $target }}"
     data-picture-url="{{ $url }}"
     data-picture-max-file-size="{{ $maxFileSize }}"
     data-picture-accepted-files="{{ $acceptedFiles }}"
     data-picture-groups="{{$attributes['groups'] ?? ''}}"
     data-picture-path="{{ $attributes['path'] ?? '' }}"
>
    <div class="border-dashed text-end p-3 picture-actions">

        <div class="fields-picture-container">
            <img src="#" class="picture-preview img-fluid img-full mb-2 border" alt="">
        </div>

        <span class="mt-1 float-start">{{ __('Upload image from your computer:') }}</span>

        <div class="btn-group">
            <label class="btn btn-default m-0">
                <x-orchid-icon path="bs.cloud-arrow-up" class="me-2"/>

                {{ __('Browse') }}
                <input type="file"
                       accept="{{ $acceptedFiles }}"
                       data-picture-target="upload"
                       data-action="change->picture#upload"
                       class="picture-input d-none">
            </label>

            <button type="button" class="btn btn-outline-danger picture-remove"
                    data-action="picture#clear">{{ __('Remove') }}</button>
        </div>

        <input type="file"
               accept="image/*"
               class="d-none">
    </div>

    <input class="picture-path d-none"
           type="text"
           data-picture-target="source"
           {{ $attributes }}
    >
</div>
