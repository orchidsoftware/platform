@component('platform::partials.fields.group',get_defined_vars())
    <input @include('platform::partials.fields.attributes', ['attributes' => $attributes])
           @isset($required) required @endisset>
@endcomponent