@component('dashboard::partials.fields.group',get_defined_vars())
    <div data-controller="fields--input">
        <input @include('dashboard::partials.fields.attributes', ['attributes' => $attributes]) data-mask="{{$mask or ''}}">
    </div>
@endcomponent