<div class="form-group">
    @if(isset($title))
        <label for="field-{{$slug}}">{{$title}}</label>
    @endif
    <div class='input-group date datetimepicker'>
        <input type='text' class="form-control {{$class or ''}}"
               id="field-{{$slug}}"
               value="{{$value or old($name)}}"
               placeholder="{{$placeholder or ''}}"
               @if(isset($prefix))
               name="{{$prefix}}[{{$lang}}]{{$name}}"
               @else
               name="{{$lang}}{{$name}}"
               @endif
               data-date-format="{{$format or "YYYY-MM-DD HH:mm:ss"}}"
        >
        <span class="input-group-addon">
        <span class="fa fa-calendar" aria-hidden="true"></span>
        </span>
    </div>
    @if(isset($help))
        <p class="form-text text-muted">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>
