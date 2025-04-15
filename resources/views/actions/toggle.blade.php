@component($typeForm, get_defined_vars())
    <div class="form-check form-switch">
        <input type="hidden" name="{{$name}}" value="0">
        <input {{ $attributes }}
               data-turbo="{{ var_export($turbo) }}"
               @checked($value)
               id="{{$id}}"
               name="{{$name}}"
               data-controller="toggle"
               data-action="toggle#submit"
               value="1"
        >
        <label class="form-check-label" for="{{$id}}">{{$placeholder ?? ''}}</label>
    </div>
@endcomponent
