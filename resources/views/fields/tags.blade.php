<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif
    <input type="text" class="form-control tagsinput {{$class or ''}}" data-role="tagsinput" id="field-{{$slug}}"
           name="{{$fieldName}}"
           value="{{$value or old($name)}}"
           placeholder="{{$placeholder or ''}}"
           @if(isset($required) && $required) required @endif
    >
    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>
