@component($typeForm, get_defined_vars())
    <div data-controller="attach"
         class="attach"
         data-attach-name-value="{{ $name }}"
         data-attach-size-value="{{ $maxSize }}"
         data-attach-count-value="{{ $maxCount }}"
         data-attach-loading-value="0"
         data-attach-attachment-value='@json($value ?? [])'
         data-action="
             drop->attach#dropFiles:prevent
             dragenter->attach#preventDefaults
             dragover->attach#preventDefaults
             dragleave->attach#preventDefaults
         "
    >
        <div data-target="attach.preview" class="row row-cols-lg-6 gy-3 sortable-dropzone">
            <div class="col order-last" data-attach-target="container">
                <label for="{{$id}}" class="border rounded bg-light attach-image-placeholder pointer-event h-100">
                    <input class="form-control d-none"
                           type="file"
                           multiple
                           data-attach-target="files"
                           data-action="change->attach#selectFiles"
                        {{ $attributes }}
                    >

                    <span class="d-block text-center fw-normal small text-muted p-3 mx-auto">
                    <span class="choose d-flex align-items-center">
                            <x-orchid-icon path="bs.cloud-arrow-up" class="h3"/>
                            <small class="text-muted d-block ms-2">{{ __($placeholder) }}</small>
                    </span>

                    <span class="spinner-border" role="status">
                        <span class="visually-hidden">{{ __('Loading...') }}</span>
                    </span>
                </span>
                </label>
            </div>
        </div>


        <template data-target="attach.template">
            <div class="pip col position-relative">
                <input type="hidden" name="{name}" value="{id}">
                <img class="attach-image rounded border user-select-none" src="{url}"/>
                <button class="btn-close rounded-circle bg-white border shadow position-absolute end-0 top-0" type="button" data-action="click->attach#remove" data-index="{id}"></button>
            </div>
        </template>

    </div>
@endcomponent
