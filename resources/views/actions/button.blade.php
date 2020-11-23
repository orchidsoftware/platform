@component($typeForm, get_defined_vars())
    <button form="post-form"
            formaction="{{ $action }}"
            data-controller="screen--button"
            data-novalidate="{{ var_export($novalidate) }}"
            data-turbolinks="{{ var_export($turbolinks) }}"
            @empty(!$confirm)
                data-action="screen--button#confirm"
                data-screen--button-confirm="{{ $confirm }}"
            @endempty
        {{ $attributes }}>

        @isset($icon)
            <x-orchid-icon :path="$icon" class="{{ empty($name) ?: 'mr-2'}}"/>
        @endisset

        {{ $name ?? '' }}
    </button>
@endcomponent
