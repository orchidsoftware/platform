@if(!is_null($method))

    <button type="submit"
            formaction="{{route(Route::currentRouteName(),$arguments)}}/{{$method}}"
            form="post-form"
            class="btn btn-sm btn-link">
                    <i class="{{$icon or ''}}"></i>{{$name or ''}}
    </button>

@elseif(!is_null($modal))

    <button type="button"
            data-toggle="modal"
            data-target="#screen-modal-{{$modal or ''}}"
            class="btn btn-sm btn-link">
                    <i class="{{$icon or ''}}"></i>{{$name or ''}}
    </button>

@else

    <a href="{{$link or ''}}" class="btn btn-sm btn-link">
         <i class="{{$icon or ''}}"></i>{{$name or ''}}
    </a>

@endif
