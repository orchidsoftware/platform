<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="field-{{$slug}}">{{$title}}</label>
    @endif
    <div class="checkbox {{$class or ''}}">
        <label class="i-checks">
            <input type="checkbox"
                   id="field-{{$slug}}"
                   value="{{$default or old($default)}}"
                   @if(isset($value) && $value == $default) checked @endif
                   @if(isset($prefix))
                   name="{{$prefix}}[{{$lang}}]{{$name}}"
                   @else
                   name="{{$lang}}{{$name}}"
                    @endif
            ><i></i> {{$placeholder or ''}}
        </label>
    </div>
    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>
