@if(!empty($group))
    <button class="btn btn-link dropdown-item" data-toggle="dropdown" aria-expanded="false">
        <i class="{{ $icon ?? '' }} m-r-xs"></i>{{ $name ?? '' }}
    </button>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow bg-white" x-placement="bottom-end">
        @foreach($group as $item)

            {!!  $item->build($query, $arguments) !!}

        @endforeach
    </div>
@elseif(!is_null($modal))
    <button type="button"
            class="btn btn-link dropdown-item"
            data-action="screen--base#targetModal"
            data-modal-title="{{ $title ?? '' }}"
            data-modal-key="{{ $modal ?? '' }}"
            data-modal-action="{{ route(Route::currentRouteName(),$arguments) }}/{{ $method }}"
    >
        <i class="{{ $icon ?? '' }} m-r-xs"></i>{{ $name ?? '' }}
    </button>
@elseif(!is_null($method))

    <div data-controller="layouts--submit">
        <button type="button"
                data-action="layouts--submit#send"
                formaction="{{ route(Route::currentRouteName(),$arguments )}}/{{ $method }}"
                data-text-validation="{{__('Please check the entered data, it may be necessary to specify in other languages.')}}"
                form="post-form"
                class="btn btn-link dropdown-item">
            @isset($icon)<i class="{{ $icon }} m-r-xs"></i>@endisset
            {{ $name ?? '' }}
        </button>
    </div>
@else

    <a href="{{ $link ?? '' }}" class="btn btn-link dropdown-item">
        <i class="{{ $icon ?? '' }} m-r-xs"></i>{{ $name ?? '' }}
    </a>
@endif
