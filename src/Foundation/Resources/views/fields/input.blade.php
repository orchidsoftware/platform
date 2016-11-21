<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">

    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif

    <input type="{{$type}}" class="form-control" @if(isset($id)) id="{{$id}}" @endif name="{{$name}}" value="{{$value or old($name)}}"
           placeholder="{{$placeholder}}">

    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>