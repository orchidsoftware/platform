@component($typeForm, get_defined_vars())
    @if(strlen($value) > 0)
        <p {{ $attributes }}>
            {{ $value }}
        </p>
    @endif
@endcomponent
