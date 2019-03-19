@component($typeForm,get_defined_vars())
    <div data-controller="fields--relationship"
         data-fields--relationship-id="{{$id}}"
         data-fields--relationship-placeholder="{{$attributes['placeholder'] ?? ''}}"
         data-fields--relationship-value="{{$value}}"
         data-fields--relationship-handler="{{$handler}}"
         data-fields--relationship-url="{{route('platform.systems.widget', Crypt::encryptString($handler))}}"
         data-fields--relationship-url-value="{{route('platform.systems.widget',[
                'widget' => Crypt::encryptString($handler),
                'key'    => $value
         ])}}"

    >
        <select id="{{$id}}" @include('platform::partials.fields.attributes', ['attributes' => $attributes])>
            <option></option>
        </select>
    </div>
@endcomponent