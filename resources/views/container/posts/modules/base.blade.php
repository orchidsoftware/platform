<div class="wrapper-md">

    <div class="form-group">
        <label>{{trans('dashboard::post/general.semantic_url')}}</label>
        <input type='text' class="form-control"
               value="{{$post->slug or ''}}"
               placeholder="{{trans('dashboard::post/general.semantic_url_unique_name')}}" name="slug">
    </div>

    <div class="line line-dashed b-b line-lg"></div>

    <div class="form-group">
        <label>{{trans('dashboard::post/general.time_of_publication')}}</label>
        <div class='input-group date datetimepicker'>
            <input type='text' class="form-control"
                   value="{{$post->publish_at or ''}}"
                   name="publish">
            <span class="input-group-addon">
                        <span class="icon-calendar"></span>
                    </span>
        </div>
    </div>

    <div class="form-group">
        <label>{{trans('dashboard::post/general.status')}}</label>
        <select name="status" class="form-control">
            @foreach($type->status() as $key => $value)

                <option value="{{$key}}"
                        @if(!is_null($post) && $post->status == $key) selected @endif >
                    {{$value}}</option>

            @endforeach
        </select>
    </div>


    <div class="line line-dashed b-b line-lg"></div>


    <div class="form-group">
        <label>{{trans('dashboard::post/general.tags')}}</label>
        <input type="text" class="form-control" data-role="tagsinput"
               name="tags"
               @if(!is_null($post)) value="{{ $post->getStringTags()}}" @endif
               placeholder="{{trans('dashboard::post/general.generic_tags')}}">
    </div>

    <div class="line line-dashed b-b line-lg"></div>


    <div class="form-group">
        <label class="control-label">{{trans('dashboard::post/general.show_in_categories')}}</label>
        <select name="category[]" multiple data-placeholder="Select Category" class="select2 form-control">
            @foreach($category as  $value)

                <option value="{{$value->id}}"
                        @if($value->active) selected @endif >
                    {{$value->term->getContent('name')}}</option>

            @endforeach
        </select>
    </div>


    <div class="line line-dashed b-b line-lg"></div>


    @if(!is_null($author))
        <p>
            {{trans('dashboard::post/general.author')}}: <i title="{{$author->email or ''}}">{{$author->name or ''}}</i>
        </p>

        <div class="line line-dashed b-b line-lg"></div>

    @endif

    @if(!is_null($post))
        <p>
            {{trans('dashboard::post/general.changed')}}: <span
                    title="{{$post->updated_at}}">{{$post->updated_at->diffForHumans()}}</span>
        </p>

        <div class="line line-dashed b-b line-lg"></div>

    @endif

    @if(count($locales) > 1)
        @foreach($locales as $key => $locale)
            <div class="line line-dashed b-b line-lg"></div>
            <div class="form-group">
                <label class="col-sm-6 control-label">{{$locale['native']}}</label>
                <div class="col-sm-6">

                    @if(!is_null($post))
                        <label class="i-switch bg-info m-t-xs m-r">
                            <input type="checkbox" name="options[locale][{{$key}}]"
                                   value="true" {{$post->checkLanguage($key)  ? 'checked' : ''}}>
                            <i></i>
                        </label>
                    @else
                        <label class="i-switch bg-info m-t-xs m-r">
                            <input type="checkbox" name="options[locale][{{$key}}]"
                                   value="true" {{isset($locale['required']) ? $locale['required'] == 1 ? 'checked' : '' : '' }}>
                            <i></i>
                        </label>
                    @endif


                </div>
            </div>
        @endforeach
    @else
        @foreach($locales as $key => $locale)
            <input type="hidden" name="options[locale][{{$key}}]"
                   value="true">
        @endforeach
    @endif


</div>
