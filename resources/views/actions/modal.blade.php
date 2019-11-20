@component($typeForm, get_defined_vars())
    <button type="button"
            @attributes($attributes)
            data-action="screen--base#targetModal"
            data-modal-title="{{ $modalTitle ?? $title ??  '' }}"
            data-modal-key="{{ $modal ?? '' }}"
            data-modal-async="{{ $async }}"
            data-modal-params='@json($asyncParameters)'
            data-modal-action="{{ $action }}">
        <i class="{{ $icon ?? '' }} m-r-xs"></i>{{ $name ?? '' }}
    </button>
@endcomponent
