@component($typeForm, get_defined_vars())
    <div data-controller="fields--radiobutton">
        <div class="btn-group btn-group-toggle no-padder" data-toggle="buttons">

            @foreach($options as $key => $option)
                <label class="btn btn-default @if($active($key, $value)) active @endif"
                       data-action="click->fields--radiobutton#checked"
                >
                    <input @attributes($attributes)
                           @if($active($key, $value)) checked @endif
                            value="{{ $key }}"
                    >{{ $option }}</label>
            @endforeach
        </div>
    </div>
@endcomponent
