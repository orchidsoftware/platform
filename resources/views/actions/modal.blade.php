@component($typeForm, get_defined_vars())
    <button type="button"
            {{ $attributes }}
            data-controller="screen--modal-toggle"
            data-action="click->screen--modal-toggle#targetModal"
            data-screen--modal-toggle-title="{{ $modalTitle ?? $title ??  '' }}"
            data-screen--modal-toggle-key="{{ $modal ?? '' }}"
            data-screen--modal-toggle-async="{{ $async }}"
            data-screen--modal-toggle-params='@json($parameters)'
            data-screen--modal-toggle-action="{{ $action }}"
            data-screen--modal-toggle-open="{{ $open }}"
    >

        @isset($icon)
            <x-orchid-icon :path="$icon" class="{{ empty($name) ?: 'mr-2'}}"/>
        @endisset

        {{ $name ?? '' }}
    </button>
@endcomponent
