@component($typeForm, get_defined_vars())
    <div data-controller="select"
         data-select-placeholder="{{$attributes['placeholder'] ?? ''}}"
         data-select-allow-empty="{{ $allowEmpty }}"
         data-select-message-notfound="{{ __('No results found') }}"
         data-select-allow-add="{{ var_export($allowAdd, true) }}"
         data-select-message-add="{{ __('Add') }}"
    >
        @php
            $isSelected = fn ($k, $opt) => isset($value) && (
                (is_array($value) && in_array($k, $value)) ||
                (isset($value[$k]) && $value[$k] == $opt) ||
                $k == $value
            );
        @endphp

        <select {{ $attributes }}>
            @foreach($options as $key => $option)
                @if(is_string($key) && is_array($option))
                    <optgroup label="{{ $key }}">
                        @foreach($option as $subKey => $subOption)
                            <option value="{{ $subKey }}" @selected($isSelected($subKey, $subOption))>{{ $subOption }}</option>
                        @endforeach
                    </optgroup>
                @else
                    <option value="{{ $key }}" @selected($isSelected($key, $option))>{{ $option }}</option>
                @endif
            @endforeach
        </select>
    </div>
@endcomponent
