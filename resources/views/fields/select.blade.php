@component($typeForm, get_defined_vars())
    <div data-controller="select"
        data-select-placeholder="{{$attributes['placeholder'] ?? ''}}"
        data-select-allow-empty="{{ $allowEmpty }}"
        data-select-message-notfound="{{ __('No results found') }}"
        data-select-message-add="{{ __('Add') }}"
    >
        <select {{ $attributes }}>
            @foreach($options as $key => $option)
                <option value="{{$key}}"
                        @isset($value)
                        @if (is_array($value) && in_array($key, $value, true)) selected
                        @elseif (isset($value[$key]) && $value[$key] == $option) selected
                        @elseif ($key === $value) selected
                        @endif
                        @endisset
                >{{$option}}</option>
            @endforeach
        </select>
    </div>
@endcomponent
