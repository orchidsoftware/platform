<div class="form-group">

    @if(isset($title))
        <label for="field-{{$name}}">{{$title}}</label>
    @endif

    <div class='input-group date datetimepicker'>
        <input type='text'  class="form-control {{$class or ''}}"
               value="{{$value or old($name)}}"
               placeholder="{{$placeholder or ''}}"

               @if(isset($prefix))
               name="{{$prefix}}[{{$lang}}]{{$name}}"
               @else
               name="{{$lang}}{{$name}}"
                @endif
        >
        <span class="input-group-addon">
                        <span class="ion-ios-calendar-outline"></span>
                    </span>
    </div>


        @if(isset($help))
            <p class="help-block">{{$help}}</p>
        @endif


</div>

<div class="line line-dashed b-b line-lg"></div>