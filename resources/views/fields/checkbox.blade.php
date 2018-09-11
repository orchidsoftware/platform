@component('platform::partials.fields.group',get_defined_vars())
    @isset($sendTrueOrFalse)
        <input hidden name="{{$attributes['name']}}" value="{{$attributes['novalue']}}">
        <div class="checkbox {{$class ?? ''}}">
            <label class="i-checks">
                <input value="{{$attributes['yesvalue']}}" @include('platform::partials.fields.attributes', ['attributes' => $attributes])
                @if(isset($attributes['value']) && $attributes['value']) checked @endif
                >
                <i></i> {{$placeholder ?? ''}}
            </label>
        </div>
    @else
        <div class="checkbox {{$class ?? ''}}">
            <label class="i-checks">
                <input @include('platform::partials.fields.attributes', ['attributes' => $attributes])
                       @if(isset($attributes['value']) && $attributes['value']) checked @endif
                >
                <i></i> {{$placeholder ?? ''}}
            </label>
        </div>
    @endisset
@endcomponent
