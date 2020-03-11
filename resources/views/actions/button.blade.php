@component($typeForm, get_defined_vars())
    <button form="post-form"
            formaction="{{ $action }}"
            data-novalidate="{{ var_export($novalidate) }}"
            data-turbolinks="{{ var_export($turbolinks) }}"
            @empty(!$confirm)onclick="return confirm('{{$confirm}}');"@endempty
        @attributes($attributes)>
        @isset($icon){!! \Orchid\Support\Facades\Dashboard::icon($icon) !!}@endisset
        {{ $name ?? '' }}
    </button>
@endcomponent
