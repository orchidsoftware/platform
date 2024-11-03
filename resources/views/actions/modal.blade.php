@component($typeForm, get_defined_vars())
    <button type="button"
            {{ $attributes }}
            data-controller="modal-toggle"
            data-action="click->modal-toggle#targetModal"
            data-modal-toggle-open-value="{{ var_export($open) }}"
            data-modal-toggle-title-value="{{ $modalTitle ?? $title ??  '' }}"
            data-modal-toggle-key-value="{{ $modal ?? '' }}"
            data-modal-toggle-action-value="{{ $action }}"

            @if(!empty($parameters))
                data-modal-toggle-parameters-value='@json($parameters)'
            @endif
    >

        @isset($icon)
            <x-orchid-icon :path="$icon" class="overflow-visible"/>
        @endisset

        {{ $name ?? '' }}
    </button>
@endcomponent
