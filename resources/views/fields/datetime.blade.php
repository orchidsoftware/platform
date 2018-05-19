@component('platform::partials.fields.group',get_defined_vars())
    <input @include('platform::partials.fields.attributes', ['attributes' => $attributes])
               data-date-format="{{$format or "YYYY-MM-DD HH:mm:ss"}}">
@endcomponent