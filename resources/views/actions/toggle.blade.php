@component($typeForm, get_defined_vars())
    <div class="form-check form-switch">
        <input value="{{ $value }}"
               {{ $attributes }}
               @checked($value)
               id="{{$id}}"
               data-controller="toggle"
               data-action="toggle#submit"
        >
        <label class="form-check-label" for="{{$id}}">{{$placeholder ?? ''}}</label>
    </div>
@endcomponent
