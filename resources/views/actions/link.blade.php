@component($typeForm, get_defined_vars())
    <a
        data-turbolinks="{{ var_export($turbolinks) }}"
        @attributes($attributes)
    >
        @isset($icon)
            <x-orchid-icon :path="$icon" class="mr-2"/>
        @endisset

        {{ $name ?? '' }}
    </a>
@endcomponent
