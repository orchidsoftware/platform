@component($typeForm, get_defined_vars())
    <div data-controller="select">

		@if ($nullable)
			<input type="hidden" name="{{ isset($attributes['multiple']) ? Str::substr($attributes['name'], 0, -2) : $attributes['name'] }}" value="">
		@endif

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
