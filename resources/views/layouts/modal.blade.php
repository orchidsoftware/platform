@push('modals-container')
    <div class="modal fade in {{$type}}"
             id="screen-modal-{{$key}}"
         role="dialog"
         tabindex="-1"
         aria-labelledby="screen-modal-{{$key}}"
             data-controller="screen--modal"
             data-screen--modal-slug="{{$templateSlug}}"
             data-screen--modal-async="{{$templateAsync}}"
             data-screen--modal-method="{{$templateAsyncMethod}}"
             data-screen--modal-url="{{ url()->current() }}"
        >
            <div class="modal-dialog {{$size}}" role="document" id="screen-modal-type-{{$key}}">
                <form class="modal-content"
                      id="screen-modal-form-{{$key}}"
                      method="post"
                      enctype="multipart/form-data"
                      data-controller="layouts--form"
                      data-action="layouts--form#submit"
                      data-layouts--form-button-animate="#submit-modal-{{$key}}"
                      data-layouts--form-button-text="{{ __('Loading...') }}"
                >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="icon-cross icons"></i></button>
                        <h4 class="modal-title text-black font-thin" data-target="screen--modal.title">{{$title}}</h4>
                    </div>
                    <div class="modal-body">
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

                        <button type="button" class="btn btn-link" data-dismiss="modal">
                            {{ $close }}
                        </button>

                        @empty($commandBar)
                            @if(!$withoutApplyButton)
                                <button type="submit"
                                        id="submit-modal-{{$key}}"
                                        data-turbolinks="{{ var_export($turbolinks) }}"
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
