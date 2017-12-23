<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="field-{{$slug}}">{{$title}}</label>
    @endif
    <p id="field-{{$slug}}">{{$value or ''}}</p>
    @if(isset($help))
        <p class="form-text text-muted">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>
