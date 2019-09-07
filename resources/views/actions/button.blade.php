@component($typeForm,get_defined_vars())
    <button type="submit"
            formaction="{{ $action }}"
            data-novalidate="{{ var_export($novalidate) }}"
            form="post-form"
            @include('platform::partials.fields.attributes', ['attributes' => $attributes])>
        @isset($icon)<i class="{{ $icon }} m-r-xs"></i>@endisset
        {{ $name ?? '' }}
    </button>
@endcomponent
