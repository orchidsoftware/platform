@component($typeForm,get_defined_vars())
    @if(!is_null($modal))
        <button type="button"
                class="{{ $class }}"
                data-action="screen--base#targetModal"
                data-modal-title="{{ $title ?? '' }}"
                data-modal-key="{{ $modal ?? '' }}"
                data-modal-action="{{ url()->current() }}/{{ $method }}"
                @include('platform::partials.fields.attributes', ['attributes' => $attributes])
        >
            <i class="{{ $icon ?? '' }} m-r-xs"></i>{{ $title ?? '' }}
        </button>
    @else
        <a class="{{ $class }}" @include('platform::partials.fields.attributes', ['attributes' => $attributes])>
            <i class="{{ $icon ?? '' }} m-r-xs"></i>{{ $title }}
        </a>
    @endif
@endcomponent