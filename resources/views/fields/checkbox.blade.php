<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif
    <div class="checkbox {{$class or ''}}">
        <label class="i-checks">
            <input @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])>
            <i></i> {{$placeholder or ''}}
        </label>
    </div>
    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>
