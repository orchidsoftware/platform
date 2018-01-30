<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif
    <div class="checkbox {{$class or ''}}">
        <label class="i-checks">
            <input @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])
                   @if(isset($attributes['value'])) checked @endif
            >
            <i></i> {{$placeholder or ''}}
        </label>
    </div>
    @if(isset($help))
        <p class="form-text text-muted">{{$help}}</p>
    @endif
</div>
@include('dashboard::partials.fields.hr', ['show' => $hr ?? true])
