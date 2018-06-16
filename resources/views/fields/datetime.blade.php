@component('platform::partials.fields.group',get_defined_vars())
    <input @include('platform::partials.fields.attributes', ['attributes' => $attributes])
               data-components--datetime-date-format="{{$format or "Y-m-d H:i:S"}}">
@endcomponent