@component($typeForm,get_defined_vars())
    @if(!is_null($modal))
        <button type="button"
                class="{{ $class }}"
                data-action="screen--base#targetModal"
                data-async="{{ ($async ? 'true' : 'false') }}"
                @if($async)data-modal-params="@json($async_params)"@endif
                data-modal-title="{{ $title ?? '' }}"
                data-modal-key="{{ $modal ?? '' }}"
                data-modal-action="{{ url()->current() }}/{{ $method }}"
                @include('platform::partials.fields.attributes', ['attributes' => $attributes])
        >
            @isset($icon)<i class="{{ $icon }} m-r-xs"></i>@endisset
            {{ $title ?? '' }}
        </button>
    @elseif(!is_null($method))
        <button type="submit"
                formaction="{{ url()->current() }}/{{ $method }}"
                form="post-form"
                class="{{ $class }}"
                @include('platform::partials.fields.attributes', ['attributes' => $attributes])>
            @isset($icon)<i class="{{ $icon }} m-r-xs"></i>@endisset
            {{ $title ?? '' }}
        </button>
    @else
        <a class="{{ $class }}" @include('platform::partials.fields.attributes', ['attributes' => $attributes])>
            @isset($icon)<i class="{{ $icon }} m-r-xs"></i>@endisset
            {{ $title ?? '' }}
        </a>
    @endif
@endcomponent
