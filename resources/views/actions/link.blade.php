@component($typeForm,get_defined_vars())
    <a
        @include('platform::partials.fields.attributes', ['attributes' => $attributes])
    >
        <i class="{{ $icon ?? '' }} m-r-xs"></i>{{ $name ?? '' }}
    </a>
@endcomponent
