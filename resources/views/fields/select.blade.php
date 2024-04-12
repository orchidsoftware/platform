@component($typeForm, get_defined_vars())
    <div data-controller="select"
        data-select-placeholder="{{$attributes['placeholder'] ?? ''}}"
        data-select-allow-empty="{{ $allowEmpty }}"
        data-select-message-notfound="{{ __('No results found') }}"
        data-select-allow-add="{{ var_export($allowAdd, true) }}"
        data-select-message-add="{{ __('Add') }}"
    >
        <select {{ $attributes }}>
            @foreach($options as $key => $option)
                <option value="{{ $key }}"
                        @if(isset($value) && ((is_array($value) && in_array($key, $value)) || (!is_array($value) && $key == $value))) selected
                        @endif
                >{{ $option }}</option>
            @endforeach
        </select>
    </div>
@endcomponent
