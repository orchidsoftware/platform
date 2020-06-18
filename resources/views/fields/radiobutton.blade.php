@component($typeForm, get_defined_vars())
    <div data-controller="fields--radiobutton">
        <div class="btn-group btn-group-toggle no-padder" data-toggle="buttons">

            @foreach($options as $key => $option)

                @php $attributes['id'] = $id . $key @endphp

                <input @attributes($attributes)
                       autocomplete="off"
                       @if($active($key, $value)) checked @endif
                        value="{{ $key }}">
                <label class="btn btn-default @if($active($key, $value)) active @endif"
                       for="{{ $id . $key }}">
                    {{ $option }}
                </label>
            @endforeach
        </div>
    </div>
@endcomponent
