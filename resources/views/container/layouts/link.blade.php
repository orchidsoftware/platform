@if(!empty($group))
    <button class="btn btn-link dropdown-item" data-toggle="dropdown" aria-expanded="false">
        <i class="{{ $icon ?? '' }} m-r-xs"></i>{{ $name ?? '' }}
    </button>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow bg-white" x-placement="bottom-end">
        @foreach($group as $item)

            {!!  $item->build($query) !!}

        @endforeach
    </div>
@elseif(!is_null($modal))
    <button type="button"
            class="btn btn-link dropdown-item"
            data-action="screen--base#targetModal"
            data-modal-title="{{ $title ?? '' }}"
            data-modal-key="{{ $modal ?? '' }}"
            data-modal-action="{{ url()->current() }}/{{ $method }}"
    >
        <i class="{{ $icon ?? '' }} m-r-xs"></i>{{ $name ?? '' }}
    </button>
@elseif(!is_null($method))

        <button type="submit"
                formaction="{{ url()->current() }}/{{ $method }}"
                form="post-form"
                class="btn btn-link dropdown-item">
            @isset($icon)<i class="{{ $icon }} m-r-xs"></i>@endisset
            {{ $name ?? '' }}
        </button>
@else

    <a href="{{ $link ?? '' }}" class="btn btn-link dropdown-item">
        <i class="{{ $icon ?? '' }} m-r-xs"></i>{{ $name ?? '' }}
    </a>
@endif
