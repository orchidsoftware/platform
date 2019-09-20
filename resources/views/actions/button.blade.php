@component($typeForm,get_defined_vars())
    <button type="submit"
            formaction="{{ $action }}"
            data-novalidate="{{ var_export($novalidate) }}"
            form="post-form"
            @if(!is_null($confirm))onclick="return confirm('{{$confirm}}');"@endif
            @include('platform::partials.fields.attributes', ['attributes' => $attributes])>
        @isset($icon)<i class="{{ $icon }} m-r-xs"></i>@endisset
        {{ $name ?? '' }}
    </button>
@endcomponent
