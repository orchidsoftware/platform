@component('platform::partials.fields.group',get_defined_vars())
    <div class="checkbox {{$class or ''}}">
        <label class="i-checks">
            <input @include('platform::partials.fields.attributes', ['attributes' => $attributes])
                   @if(isset($attributes['value']) && $attributes['value']) checked @endif
            >
            <i></i> {{$placeholder or ''}}
        </label>
    </div>
@endcomponent
