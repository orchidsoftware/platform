@component($typeForm, get_defined_vars())
    <a
        data-turbolinks="{{ var_export($turbolinks) }}"
        @attributes($attributes)
    >
        @isset($icon)<i class="{{ $icon }} mr-2"></i>@endisset
        {{ $name ?? '' }}
    </a>
@endcomponent
