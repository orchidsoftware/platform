@component($typeForm, get_defined_vars())
    <div data-controller="fields--select">
        <select {{ $attributes }}>
            @foreach($options as $key => $option)
                <option value="{{$key}}"
                        @isset($value)
                        @if (is_array($value) && in_array($key, $value, true)) selected
                        @elseif (isset($value[$key]) && (string)$value[$key] == (string)$option) selected
                        @elseif ((string)$key === (string)$value) selected
                        @endif
                        @endisset
                >{{$option}}</option>
            @endforeach
        </select>
    </div>
@endcomponent
