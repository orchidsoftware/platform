<div class="wrapper-md">

    <div class="form-group">
        <p>Время публикации</p>
        <div class='input-group date datetimepicker'>
            <input type='text' class="form-control"
                   value="{{$post->publish or ''}}"
                   placeholder="Укажите время публикации" name="publish">
            <span class="input-group-addon">
                        <span class="ion-ios-calendar-outline"></span>
                    </span>
        </div>
    </div>


    @if(!is_null($author))
    <p>
        Автор: <i title="{{$author->email or ''}}">{{$author->name or ''}}</i>
    </p>
    @endif

    @if(!is_null($post))
    <p>
        Измененно: <span title="{{$post->updated_at}}">{{$post->updated_at->diffForHumans()}}</span>
    </p>
    @endif


</div>
