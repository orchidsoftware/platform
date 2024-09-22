@component($typeForm, get_defined_vars())
    <div data-controller="attach"
         class="attach"
         data-attach-name-value="{{ $name }}"
         data-attach-size-value="{{ $maxSize }}"
         data-attach-count-value="{{ $maxCount }}"
         data-attach-loading-value="0"
         data-attach-attachment-value='@json($value ?? [])'

         data-attach-storage-value="{{ $storage ?? 'public' }}"
         data-attach-path-value="{{ $path }}"
         data-attach-group-value="{{ $group }}"

         data-attach-upload-url-value="{{ $uploadUrl ?? route('platform.systems.files.upload') }}"
         data-attach-sort-url-value="{{ $sortUrl ?? route('platform.systems.files.sort') }}"

         data-uploader-error-size-value="{{ __('File ":name" is too large to upload') }}"
         data-uploader-error-type-value="{{ __('The attached file must be an image') }}"

         data-action="
             drop->attach#dropFiles:prevent
             dragenter->attach#preventDefaults
             dragover->attach#preventDefaults
             dragleave->attach#preventDefaults
         "
    >
        <div data-target="attach.preview" class="row row-cols-4 row-cols-lg-6 gy-3 sortable-dropzone">
            <div class="col order-last attach-file-uploader" data-attach-target="container">
                <label for="{{$id}}" class="border rounded bg-light attach-image-placeholder pointer-event h-100">
                    <input class="form-control d-none"
                           type="file"
                           data-attach-target="files"
                           data-action="change->attach#selectFiles"
                           disabled
                        {{ $attributes }}
                    >

                    <span class="d-block text-center fw-normal small text-muted p-3 mx-auto">
                    <span class="choose d-flex flex-column gap-2 align-items-center text-balance text-wrap">
                            <x-orchid-icon path="bs.cloud-arrow-up" class="h3"/>
                            <small class="text-muted d-block">{{ __($placeholder) }}</small>
                    </span>

                    <span class="spinner-border" role="status">
                        <span class="visually-hidden">{{ __('Loading...') }}</span>
                    </span>
                </span>
                </label>
                <input type="hidden" name="{{ $name }}" data-attach-target="nullable" value="0">
            </div>
        </div>


        <template data-attach-target="template">
            <div class="pip col position-relative">
                <input type="hidden" name="{name}" value="{id}">


                <img class="attach-image rounded border user-select-none overflow-hidden" src="{url}" title="{original_name}"/>

                {{--
                    <object class="attach-image rounded border user-select-none" border="0" data="{url}" type="{mime}" title="test"  load="lazy" controls allowfullscreen autoplay="false">
                    </object>
                --}}

                <button class="btn-close rounded-circle bg-white border shadow position-absolute end-0 top-0"
                        type="button" data-action="click->attach#remove" data-index="{id}"></button>
            </div>
        </template>

    </div>
@endcomponent
