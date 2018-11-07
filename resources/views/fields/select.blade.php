@component($typeForm,get_defined_vars())
    <div data-controller="fields--select">
        <select @include('platform::partials.fields.attributes', ['attributes' => $attributes])>
            @foreach($options as $key => $option)
                <option value="{{$key}}"
                        @isset($value)
                            @if (is_array($value) && in_array($key, $value)) selected1
                            @elseif (isset($value[$key]) && $value[$key] == $option) selected2
                            @elseif ($key == $value) selected3
                            @endif
                        @endisset
                >{{$option}}</option>
            @endforeach
        </select>
    </div>
@endcomponent