@component($typeForm, get_defined_vars())
    <a
        data-turbolinks="{{ var_export($turbolinks) }}"
        @attributes($attributes)
    >
        {!! \Orchid\Support\Facades\Dashboard::icon( $icon ?? '') !!} {{ $name ?? '' }}
    </a>
@endcomponent
