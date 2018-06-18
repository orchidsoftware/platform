@component('platform::partials.fields.group',get_defined_vars())
    <div data-controller="fields--datetime">
        <input @include('platform::partials.fields.attributes', ['attributes' => $attributes])
                   data-fields--datetime-date-format="{{$format or "Y-m-d H:i:S"}}">
    </div>
@endcomponent