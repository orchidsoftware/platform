<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif
    <textarea class="form-control no-resize {{$class or ''}}" id="{{$id}}"
              rows="{{$rows or ''}}"
              name="{{$fieldName}}"
              placeholder="{{$placeholder or ''}}"
              maxlength="{{$maxlength or ''}}"
              minlength="{{$minlength or ''}}"
    >{!! $value or old($name) !!}</textarea>
    @if(isset($help))
        <p class="form-text text-muted">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>
