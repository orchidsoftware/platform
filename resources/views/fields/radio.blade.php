@component($typeForm, get_defined_vars())
    <div class="form-check">
        <input id="{{$id}}" {{ $attributes }}>
        <label class="form-check-label" for="{{$id}}">{{$placeholder ?? ''}}</label>
    </div>
@endcomponent
