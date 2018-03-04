@component('dashboard::partials.fields.group',get_defined_vars())
    <input @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])
           @isset($required) required @endisset>
@endcomponent