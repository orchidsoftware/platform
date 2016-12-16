<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">

    @if(isset($title))
        <label for="field-{{$name}}">{{$title}}</label>
    @endif

    <div class="input-group w-full">
        <path-input field-name="{{$prefix}}[{{$lang}}][{{$name}}]" field-value='[]'></path-input>
    </div>
</div>

<div class="line line-dashed b-b line-lg"></div>