@if(!is_null($modal))

    <button type="button"
            class="btn btn-link"
            data-action="screens--base#targetModal"
            data-modal-title="{{$title or ''}}"
            data-modal-key="{{$modal or ''}}"
            data-modal-action="{{route(Route::currentRouteName(),$arguments)}}/{{$method}}"
    >
        <i class="{{$icon or ''}} m-r-xs"></i>{{$name or ''}}
    </button>
@elseif(!is_null($method))

    <button type="submit"
            formaction="{{route(Route::currentRouteName(),$arguments)}}/{{$method}}"
            form="post-form"
            class="btn btn-link">
            @isset($icon)<i class="{{$icon}} m-r-xs"></i>@endisset
            {{$name or ''}}
    </button>
@else

    <a href="{{$link or ''}}" class="btn btn-link">
        <i class="{{$icon or ''}} m-r-xs"></i>{{$name or ''}}
    </a>
@endif
