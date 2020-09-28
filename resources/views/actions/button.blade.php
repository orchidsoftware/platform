@component($typeForm, get_defined_vars())
    <button form="post-form"
            formaction="{{ $action }}"
            data-novalidate="{{ var_export($novalidate) }}"
            data-turbolinks="{{ var_export($turbolinks) }}"
            @empty(!$confirm)onclick="return confirm('{{$confirm}}');"@endempty
        {{ $attributes }}>

        @isset($icon)
            <x-orchid-icon :path="$icon" class="mr-2"/>
        @endisset

        {{ $name ?? '' }}
    </button>
@endcomponent
