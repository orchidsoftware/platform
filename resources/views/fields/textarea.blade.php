@component($typeForm,get_defined_vars())
    <textarea @include('platform::partials.fields.attributes', ['attributes' => $attributes])>{!! $value ?? '' !!}</textarea>
@endcomponent