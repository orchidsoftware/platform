@component($typeForm, get_defined_vars())
   @empty(!$value)
        <p {{ $attributes }}>
            {{ $value }}
        </p>
   @endempty
@endcomponent
