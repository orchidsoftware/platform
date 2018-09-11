@component('platform::partials.fields.group',get_defined_vars())
    <div>
        <input data-controller="fields--datetime" @include('platform::partials.fields.attributes', ['attributes' => $attributes])
                   data-fields--datetime-date-format="{{$format ?? "Y-m-d H:i:S"}}">
    </div>
@endcomponent