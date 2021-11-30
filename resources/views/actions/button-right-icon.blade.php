@component($typeForm, get_defined_vars())
    <button
            data-controller="button"
            data-turbo="{{ var_export($turbo) }}"
            @empty(!$confirm)
                data-action="button#confirm"
                data-button-confirm="{{ $confirm }}"
            @endempty
            {{ $attributes }}>

        {{ $name ?? '' }}

        @isset($icon)
            <x-orchid-icon :path="$icon" class="{{ empty($name) ?: 'ms-2'}}"/>
        @endisset
    </button>
@endcomponent