@component('platform::partials.fields.group',get_defined_vars())
    <div data-controller="fields--input">
        <input @include('platform::partials.fields.attributes', ['attributes' => $attributes]) data-mask="{{$mask ?? ''}}">
    </div>
@endcomponent