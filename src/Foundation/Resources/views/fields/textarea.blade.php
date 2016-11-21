<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">

    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif

    <textarea class="form-control" @if(isset($id)) id="{{$id}}" @endif
    name="{{$name}}"
              placeholder="{{$placeholder}}"
    >{!! $value or old($name) !!}</textarea>


    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>