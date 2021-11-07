@push('modals-container')
    <div class="modal fade center-scale"
         id="screen-modal-{{$key}}"
         role="dialog"
         aria-labelledby="screen-modal-{{$key}}"
         data-controller="modal"
         data-modal-slug="{{$templateSlug}}"
         data-modal-async-enable="{{$asyncEnable}}"
         data-modal-async-route="{{$asyncRoute}}"
         data-modal-open="{{$open}}"
        {{$staticBackdrop ? "data-bs-backdrop=static" : ''}}
    >
        <div class="modal-dialog modal-fullscreen-md-down {{$size}} {{$type}}" role="document" id="screen-modal-type-{{$key}}">
            <form class="modal-content"
                  id="screen-modal-form-{{$key}}"
                  method="post"
                  enctype="multipart/form-data"
                  data-controller="form"
                  data-action="form#submit"
                  data-form-button-animate="#submit-modal-{{$key}}"
                  data-form-button-text="{{ __('Loading...') }}"
            >
                <div class="modal-header">
                    <h4 class="modal-title text-black fw-light" data-target="modal.title">{{$title}}</h4>
                    <button type="button" class="btn-close" title="Close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body layout-wrapper">
                    <div data-async>
                        @foreach($manyForms as $formKey => $modal)
                            @foreach($modal as $item)
                                {!! $item ?? '' !!}
                            @endforeach
                        @endforeach
                    </div>

                    @csrf
                </div>
                <div class="modal-footer">

                    @if(!$withoutCloseButton)
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">
                            {{ $close }}
                        </button>
                    @endif

                    @empty($commandBar)
                        @if(!$withoutApplyButton)
                            <button type="submit"
                                    id="submit-modal-{{$key}}"
                                    data-turbo="{{ var_export($turbo) }}"
                                    class="btn btn-default">
                                {{ $apply }}
                            </button>
                        @endif
                    @else
                        {!! $commandBar !!}
                    @endempty

                </div>
            </form>
        </div>
    </div>
@endpush
