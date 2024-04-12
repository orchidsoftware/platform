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
                        @if (in_array($key, array_keys((array)$value))) selected @endif
                >{{ $option }}</option>
            @endforeach
        </select>
    </div>
@endcomponent
