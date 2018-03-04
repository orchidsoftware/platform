@component('dashboard::partials.fields.group',get_defined_vars())
    <textarea @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])>{!! $value or '' !!}</textarea>
@endcomponent