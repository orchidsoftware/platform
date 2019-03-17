@component($typeForm,get_defined_vars())
    <p @include('platform::partials.fields.attributes', ['attributes' => $attributes])>
        {{ $value }}
    </p>
@endcomponent