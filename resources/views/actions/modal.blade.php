@component($typeForm, get_defined_vars())
    <button type="button"
            @attributes($attributes)
            data-action="screen--base#targetModal"
            data-modal-title="{{ $modalTitle ?? $title ??  '' }}"
            data-modal-key="{{ $modal ?? '' }}"
            data-modal-async="{{ $async }}"
            data-modal-params='@json($parameters)'
            data-modal-action="{{ $action }}">

        @isset($icon)
            <x-orchid-icon :path="$icon" class="mr-2"/>
        @endisset

        {{ $name ?? '' }}
    </button>
@endcomponent
