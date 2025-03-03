@component($typeForm, get_defined_vars())
    <div data-controller="select2"
         data-select2-placeholder="{{$attributes['placeholder'] ?? ''}}"
         data-select2-allow-empty="{{ $allowEmpty }}"
         data-select2-id="{{$id}}"
         data-select2-route="{{ route('platform.systems.select2') }}"
         data-select2-display="{{ $display }}"
         data-select2-key="{{ $key }}"
         data-select2-query="{{ $query }}"
         data-select2-message-notfound="{{ __('No results found') }}"
         data-select2-message-add="{{ __('Add') }}"
         data-select2-allow-add="{{ var_export($allowAdd, true) }}"
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

            @if($query)
                    @foreach($value as $key => $option)
                        <option selected value="{{ $key }}">{{$option}}</option>
                    @endforeach
            @endif

        </select>
    </div>
@endcomponent
