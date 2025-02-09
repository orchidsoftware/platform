@component($typeForm, get_defined_vars())
    <div data-controller="select2"
         data-select2-placeholder="{{$attributes['placeholder'] ?? ''}}"
         data-select2-allow-empty="{{ $allowEmpty }}"
         data-select2-id="{{$id}}"
         data-select2-model="{{ $model }}"
         data-select2-name="{{ $name }}"
         data-select2-key="{{ $key }}"
         data-select2-scope="{{ $scope }}"
         data-select2-search-columns="{{ $searchColumns }}"
         data-select2-append="{{ $append }}"
         data-select2-chunk="{{ $chunk }}"
         data-select2-route="{{ route('platform.systems.select2') }}"
         data-select2-message-notfound="{{ __('No results found') }}"
         data-select2-message-add="{{ __('Add') }}"
         data-select2-allow-add="{{ var_export($allowAdd, true) }}"
         data-select2-lazy="{{ $lazy }}"
    >
        <select id="{{$id}}" data-relation-target="select" {{ $attributes }}>
            @foreach($options as $key => $option)
                <option value="{{$key}}"
                        @isset($value)
                            @if (is_array($value) && in_array($key, $value)) selected
                            @elseif (isset($value[$key]) && $value[$key] == $option) selected
                            @elseif ($key == $value) selected
                            @endif
                        @endisset
                >{{$option}}</option>
            @endforeach
        </select>
    </div>
@endcomponent
