@component('platform::partials.fields.group',get_defined_vars())
    <textarea @include('platform::partials.fields.attributes', ['attributes' => $attributes])>{!! $value or '' !!}</textarea>
@endcomponent