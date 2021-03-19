@component($typeForm, get_defined_vars())
    <div data-controller="checkbox"
         data-checkbox-indeterminate="{{$indeterminate}}">
        @isset($sendTrueOrFalse)
            <input hidden name="{{$attributes['name']}}" value="{{$attributes['novalue']}}">
            <div class="form-check">
                <input value="{{$attributes['yesvalue']}}"
                       {{ $attributes }}
                       @if(isset($attributes['value']) && $attributes['value']) checked @endif
                >
                <label class="form-check-label" for="{{$id}}">{{$placeholder ?? ''}}</label>
            </div>
        @else
            <div class="form-check">
                <input {{ $attributes }}
                       @if(isset($attributes['value']) && $attributes['value'] && (!isset($attributes['checked']) || $attributes['checked'] !== false)) checked @endif
                >
                <label class="form-check-label" for="{{$id}}">{{$placeholder ?? ''}}</label>
            </div>
        @endisset
    </div>
@endcomponent
