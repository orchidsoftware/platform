@component($typeForm, get_defined_vars())
    <div class="form-check form-switch">
        <input type="hidden" name="{{$name}}" value="{{ $attributes['novalue'] }}">
        <input {{ $attributes }}
               data-turbo="{{ var_export($turbo) }}"
               @checked($value)
               id="{{$id}}"
               name="{{$name}}"
               data-controller="toggle"
               data-action="toggle#submit"
               value="{{ $attributes['yesvalue'] }}"
        >
        <label class="form-check-label" for="{{$id}}">{{$placeholder ?? ''}}</label>
    </div>
@endcomponent
