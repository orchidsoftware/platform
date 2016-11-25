<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">

    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif

    <textarea class="form-control no-resize {{$class or ''}}" @if(isset($id)) id="{{$id}}" @endif

    @if(isset($prefix))
    name="{{$prefix}}[{{$lang}}][{{$name}}]"
              @else
              name="{{$lang}}[{{$name}}]"
              @endif


              placeholder="{{$placeholder or ''}}"
    >{!! $value or old($name) !!}</textarea>


    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>