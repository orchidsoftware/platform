@component($typeForm, get_defined_vars())
    <div
        data-controller="upload"
        data-upload-storage="{{$storage ?? config('platform.attachment.disk', 'public')}}"
        data-upload-name="{{$name}}"
        data-upload-id="dropzone-{{$id}}"
        data-upload-data='@json($value)'
        data-upload-groups="{{$attributes['groups'] ?? ''}}"
        data-upload-multiple="{{$attributes['multiple']}}"
        data-upload-parallel-uploads="{{$parallelUploads }}"
        data-upload-max-file-size="{{$maxFileSize }}"
        data-upload-max-files="{{$maxFiles}}"
        data-upload-timeout="{{$timeOut}}"
        data-upload-accepted-files="{{$acceptedFiles }}"
        data-upload-resize-quality="{{$resizeQuality }}"
        data-upload-resize-width="{{$resizeWidth }}"
        data-upload-is-media-library="{{ $media }}"
        data-upload-close-on-add="{{ $closeOnAdd }}"
        data-upload-resize-height="{{$resizeHeight }}"
        data-upload-path="{{ $attributes['path'] ?? '' }}"
    >
        <div id="dropzone-{{$id}}" class="dropzone-wrapper">
            <div class="fallback">
                <input type="file" value="" multiple/>
            </div>
            <div class="visual-dropzone sortable-dropzone dropzone-previews">
                <div class="dz-message dz-preview dz-processing dz-image-preview">
                    <div class="bg-light d-flex justify-content-center align-items-center border r-2x"
                         style="min-height: 112px;">
                        <div class="pe-1 ps-1 pt-3 pb-3">
                            <x-orchid-icon path="cloud-upload" class="h3"/>
                            <small class="text-muted w-b-k d-block">{{__('Upload file')}}</small>
                        </div>
                    </div>
                </div>

                @if($media)
                    <div class="dz-message dz-preview dz-processing dz-image-preview"
                         data-action="click->upload#openMedia">
                        <div class="bg-light d-flex justify-content-center align-items-center border r-2x"
                             style="min-height: 112px;">
                            <div class="pe-1 ps-1 pt-3 pb-3">
                                <x-orchid-icon path="open" class="h3"/>

                                <small class="text-muted w-b-k d-block">{{__('Media catalog')}}</small>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="attachment modal fade center-scale" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-black fw-light">
                                {{__('File Information')}}
                                <small class="text-muted d-block">{{__('Information to display')}}</small>
                            </h4>

                            <button type="button" class="btn-close" title="Close" data-bs-dismiss="modal"
                                    aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="form-group">
                                <label>{{__('System name')}}</label>
                                <input type="text" class="form-control" data-upload-target="name" readonly
                                       maxlength="255">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Display name') }}</label>
                                <input type="text" class="form-control" data-upload-target="original"
                                       maxlength="255" placeholder="{{ __('Display name') }}">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Alternative text') }}</label>
                                <input type="text" class="form-control" data-upload-target="alt"
                                       maxlength="255" placeholder="{{  __('Alternative text')  }}">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Description') }}</label>
                                <textarea class="form-control no-resize"
                                          data-upload-target="description"
                                          placeholder="{{ __('Description') }}"
                                          maxlength="255"
                                          rows="3"></textarea>
                            </div>


                            @if($visibility === 'public')
                                <div class="form-group">
                                    <a href="#" data-action="click->upload#openLink">
                                        <small>
                                            <x-orchid-icon path="link" class="me-2"/>

                                            {{ __('Link to file') }}
                                        </small>
                                    </a>
                                </div>
                            @endif


                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    data-bs-dismiss="modal"
                                    class="btn btn-link">
                                    <span>
                                        {{__('Close')}}
                                    </span>
                            </button>
                            <button type="button" data-action="click->upload#save" class="btn btn-default">
                                {{__('Apply')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @if($media)
                <div class="media modal fade enter-scale disable-scroll" tabindex="-1" role="dialog"
                     aria-hidden="false">
                    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down slide-up">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title text-black fw-light">
                                    {{__('Media Library')}}
                                    <small class="text-muted d-block">{{__('Previously uploaded files')}}</small>
                                </h4>
                                <button type="button" class="btn-close" title="Close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row justify-content-center">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{__('Search file')}}</label>
                                            <input type="search"
                                                   data-upload-target="search"
                                                   data-action="keydown->upload#resetPage keydown->upload#loadMedia"
                                                   class="form-control"
                                                   placeholder="{{ __('Search...') }}"
                                            >
                                        </div>

                                        <div class="media-loader spinner-border" role="status">
                                            <span class="visually-hidden">{{ __('Loading...') }}</span>
                                        </div>

                                        <div class="row media-results m-0"></div>

                                        <div class="mt-2">
                                            <button class="btn btn-sm btn-link d-block w-100"
                                                    data-upload-target="loadmore"
                                                    data-action="click->upload#loadMore">{{ __('Load more') }}</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <template id="dropzone-{{$id}}-media">
                    <div class="col-4 col-sm-3 my-3 position-relative media-item">
                      <div data-action="click->upload#addFile" data-key="{index}">
                         <img src="{element.url}" class="rounded mw-100" style="height: 50px;width: 100%;object-fit: cover;">
                          <p class="text-ellipsis small text-muted mt-1 mb-0" title="{element.original_name}">{element.original_name}</p>
                        </div>
                      </div>
                </template>
            @endif


            <template id="dropzone-{{$id}}-remove-button">
                <a href="javascript:;" class="btn-remove">&times;</a>
            </template>

            <template id="dropzone-{{$id}}-edit-button">
                <a href="javascript:;" class="btn-edit">
                    <x-orchid-icon path="note" class="mb-1"/>
                </a>
            </template>


        </div>
    </div>
@endcomponent
