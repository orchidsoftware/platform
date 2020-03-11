@if(!empty($group))
    <button class="btn btn-link dropdown-item" data-toggle="dropdown" aria-expanded="false">
        {!! \Orchid\Support\Facades\Dashboard::icon( $icon ?? '') !!}{{ $name ?? '' }}
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
            data-modal-action="{{ $action }}">
        {!! \Orchid\Support\Facades\Dashboard::icon( $icon ?? '') !!}{{ $name ?? '' }}
    </button>
@elseif(!is_null($method))
    <button type="submit"
            formaction="{{ $action }}"
            form="post-form"
            @if(!is_null($confirm))onclick="return confirm('{{$confirm}}');" @endif
            class="btn btn-link dropdown-item">
        @isset($icon){!! \Orchid\Support\Facades\Dashboard::icon( $icon ?? '') !!}@endisset
        {{ $name ?? '' }}
    </button>
@else

    <a href="{{ $link ?? '' }}" class="btn btn-link dropdown-item">
        {!! \Orchid\Support\Facades\Dashboard::icon( $icon ?? '') !!}{{ $name ?? '' }}
    </a>
@endif
