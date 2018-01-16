<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="field-{{$slug}}">{{$title}}</label>
    @endif
    <input type="password" class="form-control {{$class or ''}}" id="field-{{$slug}}"
           name="{{$fieldName}}"
           placeholder="{{$placeholder or ''}}"
           max="{{$max or ''}}"
           maxlength="{{$maxlength or ''}}"
           min="{{$min or ''}}"
           minlength="{{$minlength or ''}}"
           @if(isset($required) && $required) required @endif
    >
    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>
