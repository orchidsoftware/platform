@component($typeForm,get_defined_vars())
    <button type="button"
            @include('platform::partials.fields.attributes', ['attributes' => $attributes])
            data-action="screen--base#targetModal"
            data-modal-title="{{ $title ?? '' }}"
            data-modal-key="{{ $modal ?? '' }}"
            data-modal-params='@json($asyncParams)'
            data-modal-action="{{ $action }}">
        <i class="{{ $icon ?? '' }} m-r-xs"></i>{{ $name ?? '' }}
    </button>
@endcomponent
