<div class="wrapper-md">

    <div class="form-group">
        <label>ЧПУ</label>
        <input type='text' class="form-control"
                   value="{{$post->slug or ''}}"
                   placeholder="Уникальное название" name="slug">
    </div>

    <div class="line line-dashed b-b line-lg"></div>

    <div class="form-group">
        <label>Время публикации</label>
        <div class='input-group date datetimepicker'>
            <input type='text' class="form-control"
                   value="{{$post->publish_at or ''}}"
                   placeholder="Укажите время публикации" name="publish">
            <span class="input-group-addon">
                        <span class="icon-calendar"></span>
                    </span>
        </div>
    </div>

    <div class="line line-dashed b-b line-lg"></div>

    <div class="form-group">
        <label>Теги</label>
        <input type="text" class="form-control" data-role="tagsinput"
               name="tags"
               @if(!is_null($post)) value="{{ $post->getStringTags()}}" @endif
               placeholder="Введите общие теги">
    </div>

    <div class="line line-dashed b-b line-lg"></div>


    <div class="form-group">
        <label class="control-label">Показывать в категориях</label>
        <select  name="category[]"  multiple data-placeholder="Select Category" class="chosen-select form-control">
                @foreach($category as  $value)

                    <option value="{{$value->id}}"
                     @if($value->active) selected @endif >
                        {{$value->term->getContent('name')}}</option>

                @endforeach
        </select>
    </div>

    @if(!is_null($author))
    <p>
        Автор: <i title="{{$author->email or ''}}">{{$author->name or ''}}</i>
    </p>

    @endif

    @if($post->exists)
    <p>
        Измененно: <span title="{{$post->updated_at}}">{{$post->updated_at->diffForHumans()}}</span>
    </p>
    @endif

    @foreach($locales as $key => $locale)
        <div class="line line-dashed b-b line-lg"></div>
        <div class="form-group">
            <label class="col-sm-6 control-label">{{$locale['native']}}</label>
            <div class="col-sm-6">

            @if($post->exists)
                <label class="i-switch bg-info m-t-xs m-r">
                    <input type="checkbox" name="options[locale][{{$key}}]" value="true" {{$post->checkLanguage($key)  ? 'checked' : ''}}>
                    <i></i>
                </label>
            @else
                <label class="i-switch bg-info m-t-xs m-r">
                    <input type="checkbox" name="options[locale][{{$key}}]" value="true" {{isset($locale['required']) ? $locale['required'] == 1 ? 'checked' : '' : '' }}>
                    <i></i>
                </label>
            @endif


            </div>
        </div>
    @endforeach











</div>
