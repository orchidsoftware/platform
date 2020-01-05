@component($typeForm, get_defined_vars())
    <a
        data-turbolinks="{{ var_export($turbolinks) }}"
        @attributes($attributes)
    >
        <i class="{{ $icon ?? '' }} mr-2"></i>{{ $name ?? '' }}
    </a>
@endcomponent
