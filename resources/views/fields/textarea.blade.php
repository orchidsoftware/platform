<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif
    <textarea class="form-control no-resize {{$class or ''}}" id="{{$id}}"
              rows="{{$rows or ''}}"
              name="{{$fieldName}}"
              placeholder="{{$placeholder or ''}}"
              maxlength="{{$maxlength or ''}}"
              minlength="{{$minlength or ''}}"
              required="{{$required or 'false'}}"
    >{!! $value or old($name) !!}</textarea>
    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>
