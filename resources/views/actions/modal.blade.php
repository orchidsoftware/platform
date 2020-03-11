@component($typeForm, get_defined_vars())
    <button type="button"
            @attributes($attributes)
            data-action="screen--base#targetModal"
            data-modal-title="{{ $modalTitle ?? $title ??  '' }}"
            data-modal-key="{{ $modal ?? '' }}"
            data-modal-async="{{ $async }}"
            data-modal-params='@json($asyncParameters)'
            data-modal-action="{{ $action }}">
        {!! \Orchid\Support\Facades\Dashboard::icon( $icon ?? '') !!}{{ $name ?? '' }}
    </button>
@endcomponent
