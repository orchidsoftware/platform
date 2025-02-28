@component($typeForm, get_defined_vars())
    <div data-controller="cropper"
         data-cropper-value="{{ $attributes['value'] }}"
         data-cropper-storage="{{ $storage ?? config('platform.attachment.disk', 'public') }}"
         data-cropper-width="{{ $width }}"
         data-cropper-height="{{ $height }}"
         data-cropper-min-width="{{ $minWidth }}"
         data-cropper-min-height="{{ $minHeight }}"
         data-cropper-max-width="{{ $maxWidth }}"
         data-cropper-max-height="{{ $maxHeight }}"
         data-cropper-target="{{ $target }}"
         data-cropper-url="{{ $url }}"
         data-cropper-accepted-files="{{ $acceptedFiles }}"
         data-cropper-max-file-size="{{ $maxFileSize }}"
         data-cropper-groups="{{ $attributes['groups'] }}"
         data-cropper-path="{{ $attributes['path'] ?? '' }}"
         data-cropper-keep-original-type-value="{{ $keepOriginalType }}"
         data-cropper-max-size-message-value="{{ __($maxSizeValidateMessage) }}"
    >
        <div class="border-dashed text-end p-3 cropper-actions">

            <div class="fields-cropper-container">
                <img src="#" class="cropper-preview img-fluid img-full mb-2 border" alt="" style="--cropper-width: {{ $width }}; --cropper-height: {{ $height }};">
            </div>

            <span class="mt-1 float-start">{{ __('Upload image from your computer:') }}</span>

            <div class="btn-group">
                <label class="btn btn-default m-0">
                    <x-orchid-icon path="bs.cloud-arrow-up" class="me-2"/>

                    {{ __('Browse') }}
                    <input type="file"
                           accept="{{ $acceptedFiles }}"
                           data-cropper-target="upload"
                           data-action="change->cropper#upload click->cropper#openModal"
                           class="d-none">
                </label>

                <button type="button" class="btn btn-outline-danger cropper-remove"
                        data-action="cropper#clear">{{ __('Remove') }}</button>
            </div>

            <input type="file"
                   accept="{{ $acceptedFiles }}"
                   class="d-none">
        </div>

        <input class="cropper-path d-none"
               type="text"
               data-cropper-target="source"
            {{ $attributes }}
        >

        <div class="modal" role="dialog" {{$staticBackdrop ? "data-bs-backdrop=static" : ''}}>
            <div class="modal-dialog modal-fullscreen-md-down modal-lg">
                <div class="modal-content-wrapper">
                    <div class="modal-content">
                        <div class="position-relative">
                            <img class="upload-panel">
                        </div>

                        <div class="modal-footer">

                            <button type="button"
                                    class="btn btn-link"
                                    data-bs-dismiss="modal">
                                {{ __('Close') }}
                            </button>

                            <button type="button"
                                    class="btn btn-default"
                                    data-action="cropper#crop">
                                {{ __('Crop') }}
                            </button>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endcomponent
