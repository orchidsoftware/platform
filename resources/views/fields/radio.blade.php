@component($typeForm, get_defined_vars())
    <div class="custom-control custom-radio v-center">
        <input id="{{$id}}" {{ $attributes }}>

        <label class="custom-control-label" for="{{$id}}">{{$placeholder ?? ''}}</label>
    </div>
@endcomponent
