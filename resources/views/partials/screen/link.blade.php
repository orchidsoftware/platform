@if(!is_null($modal))

    <button type="button"
            class="btn btn-link"
            data-action="screen--base#targetModal"
            data-modal-title="{{$title ?? ''}}"
            data-modal-key="{{$modal ?? ''}}"
            data-modal-action="{{route(Route::currentRouteName(),$arguments)}}/{{$method}}"
    >
        <i class="{{$icon ?? ''}} m-r-xs"></i>{{$name ?? ''}}
    </button>
@elseif(!is_null($method))

    <button type="submit"
            formaction="{{route(Route::currentRouteName(),$arguments)}}/{{$method}}"
            form="post-form"
            class="btn btn-link">
            @isset($icon)<i class="{{$icon}} m-r-xs"></i>@endisset
            {{$name ?? ''}}
    </button>
@else

    <a href="{{$link ?? ''}}" class="btn btn-link">
        <i class="{{$icon ?? ''}} m-r-xs"></i>{{$name ?? ''}}
    </a>
@endif
