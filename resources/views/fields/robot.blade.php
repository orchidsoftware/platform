<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif
    <select
            name="{{$fieldName}}"
            class="form-control {{$class or ''}}" id="{{$id}}">
        <option value="index">Index</option>
        <option value="noindex">Noindex</option>
    </select>
    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>
