<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif
    <input type="{{$type}}" class="form-control {{$class or ''}}" id="{{$id}}"
           name="{{$fieldName}}"
           value="{{$value or old($name)}}"
           placeholder="{{$placeholder or ''}}"
           max="{{$max or ''}}"
           maxlength="{{$maxlength or ''}}"
           min="{{$min or ''}}"
           minlength="{{$minlength or ''}}"
           data-mask="{{$mask or ''}}"
    >
    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>
