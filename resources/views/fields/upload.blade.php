@component($typeForm, get_defined_vars())
    <div
            data-controller="fields--upload"
            data-fields--upload-storage="{{$storage ?? 'public'}}"
            data-fields--upload-name="{{$name}}"
            data-fields--upload-id="dropzone-{{$id}}"
            data-fields--upload-data='@json($value)'
            data-fields--upload-groups="{{$attributes['groups'] ?? ''}}"
            data-fields--upload-multiple="{{$attributes['multiple']}}"
            data-fields--upload-parallel-uploads="{{$parallelUploads }}"
            data-fields--upload-max-file-size="{{$maxFileSize }}"
            data-fields--upload-max-files="{{$maxFiles}}"
            data-fields--upload-timeout="{{$timeOut}}"
            data-fields--upload-accepted-files="{{$acceptedFiles }}"
            data-fields--upload-resize-quality="{{$resizeQuality }}"
            data-fields--upload-resize-width="{{$resizeWidth }}"
            data-fields--upload-is-media-library="{{ $media }}"
            data-fields--upload-close-on-add="{{ $closeOnAdd }}"
            data-fields--upload-resize-height="{{$resizeHeight }}"
    >
        <div id="dropzone-{{$id}}" class="dropzone-wrapper">
            <div class="fallback">
                <input type="file" value="" multiple/>
            </div>
            <div class="visual-dropzone sortable-dropzone dropzone-previews">
                <div class="dz-message dz-preview dz-processing dz-image-preview">
                    <div class="bg-light d-flex justify-content-center align-items-center border r-2x"
                         style="min-height: 112px;">
                        <div class="pr-1 pl-1 pt-3 pb-3">
                            <x-orchid-icon path="cloud-upload" class="text-2x"/>
                            <small class="text-muted w-b-k text-xs d-block">{{__('Upload file')}}</small>
                        </div>
                    </div>
                </div>

                @if($media)
                    <div class="dz-message dz-preview dz-processing dz-image-preview"
                         data-action="click->fields--upload#openMedia">
                        <div class="bg-light d-flex justify-content-center align-items-center border r-2x"
                             style="min-height: 112px;">
                            <div class="pr-1 pl-1 pt-3 pb-3">
                                <x-orchid-icon path="open" class="text-2x"/>

                                <small class="text-muted w-b-k text-xs d-block">{{__('Media catalog')}}</small>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="attachment modal fade disable-scroll" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog slide-up">
                    <div class="modal-content-wrapper">
                        <div class="modal-content">
                            <div class="modal-header clearfix">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    <x-orchid-icon path="cross"/>
                                </button>
                                <h5>{{__('File Information')}}</h5>
                                <p class="mb-3">{{__('Information to display')}}</p>
                            </div>
                            <div class="modal-body px-4">
                                <div class="form-group">
                                    <label>{{__('System name')}}</label>
                                    <input type="text" class="form-control" data-target="fields--upload.name" readonly
                                           maxlength="255">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Display name') }}</label>
                                    <input type="text" class="form-control" data-target="fields--upload.original"
                                           maxlength="255" placeholder="{{ __('Display Name') }}">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Alternative text') }}</label>
                                    <input type="text" class="form-control" data-target="fields--upload.alt"
                                           maxlength="255" placeholder="{{  __('Alternative Text')  }}">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Description') }}</label>
                                    <textarea class="form-control no-resize"
                                              data-target="fields--upload.description"
                                              placeholder="{{ __('Description') }}"
                                              maxlength="255"
                                              rows="3"></textarea>
                                </div>


                                @if($visibility === 'public')
                                <div class="form-group">
                                    <a href="#" data-action="click->fields--upload#openLink">
                                        <small>
                                            <x-orchid-icon path="link" class="mr-2"/>

                                            {{ __('Link to file') }}
                                        </small>
                                    </a>
                                </div>
                                @endif


                            </div>
                            <div class="modal-footer">
                                <button type="button"
                                        data-dismiss="modal"
                                        class="btn btn-link">
                                    <span>
                                        {{__('Close')}}
                                    </span>
                                </button>
                                <button type="button" data-action="click->fields--upload#save" class="btn btn-default">
                                    {{__('Apply')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="media modal fade disable-scroll" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-xl slide-up">
                    <div class="modal-content-wrapper">
                        <div class="modal-content">
                            <div class="modal-header clearfix">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5>{{__('Media Library')}}</h5>
                                <p class="mb-3">{{__('Previously uploaded files')}}</p>
                            </div>
                            <div class="modal-body">
                                <div class="row justify-content-center">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{__('Search file')}}</label>
                                            <input type="search"
                                                   data-target="fields--upload.search"
                                                   data-action="keydown->fields--upload#loadMedia"
                                                   class="form-control form-control-sm"
                                                   placeholder="{{ __('Search...') }}"
                                            >
                                        </div>

                                        <div class="media-loader spinner-border" role="status">
                                            <span class="sr-only">{{ __('Loading...') }}</span>
                                        </div>


                                        <div class="row media-results"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


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
