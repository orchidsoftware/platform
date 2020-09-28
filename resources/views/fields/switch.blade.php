@component($typeForm, get_defined_vars())
    @isset($sendTrueOrFalse)
        <input hidden name="{{$attributes['name']}}" value="{{$attributes['novalue']}}">
        <div class="custom-control custom-switch">
            <input value="{{$attributes['yesvalue']}}"
                   {{ $attributes }}
                   @if(isset($attributes['value']) && $attributes['value']) checked @endif
                   id="{{$id}}"
            >
            <label class="custom-control-label" for="{{$id}}">{{$placeholder ?? ''}}</label>
        </div>
    @else
        <div class="custom-control custom-switch">
            <input {{ $attributes }}
                   @if(isset($attributes['value']) && $attributes['value']) checked @endif
            id="{{$id}}"
            >
            <label class="custom-control-label" for="{{$id}}">{{$placeholder ?? ''}}</label>
        </div>
    @endisset
@endcomponent
