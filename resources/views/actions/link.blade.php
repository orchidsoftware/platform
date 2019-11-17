@component($typeForm, get_defined_vars())
    <a
        data-turbolinks="{{ var_export($turbolinks) }}"
        @attributes($attributes)
    >
        <i class="{{ $icon ?? '' }} m-r-xs"></i>{{ $name ?? '' }}
    </a>
@endcomponent
