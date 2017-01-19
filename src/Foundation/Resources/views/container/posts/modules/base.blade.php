<div class="wrapper-md">

    <div class="form-group">
        <label>ЧПУ</label>
        <input type='text' class="form-control"
                   value="{{$post->slug or ''}}"
                   placeholder="Уникальное название" name="slug">
    </div>


    <div class="form-group">
        <label>Время публикации</label>
        <div class='input-group date datetimepicker'>
            <input type='text' class="form-control"
                   value="{{$post->publish or ''}}"
                   placeholder="Укажите время публикации" name="publish">
            <span class="input-group-addon">
                        <span class="ion-ios-calendar-outline"></span>
                    </span>
        </div>
    </div>


    <div class="form-group">
        <label>Теги</label>
        <input type="text" class="form-control" data-role="tagsinput"
               name="tags"
               @if(!is_null($post)) value="{{ $post->getStringTags()}}" @endif
               placeholder="Введите общие теги">
    </div>




    <div class="form-group">
        <label class="control-label">Раздел записи</label>
        <select class="form-control" name="section_id">
            <option value="0">Без раздела</option>
            @foreach($sections as $key => $value)
                <option value="{{$value->id}}"
                        @if(!is_null($post) &&$post->section_id == $value->id) selected @endif
                >{{$value->content[$language]['name']}}</option>
            @endforeach
        </select>
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
