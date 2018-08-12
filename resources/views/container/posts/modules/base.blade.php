<div class="wrapper-md">

    <div class="form-group">
        <label>{{trans('platform::post/base.tags')}}</label>
        <select class="form-control select2-tags"
                name="tags[]"
                multiple="multiple"
                placeholder="{{trans('platform::post/base.generic_tags')}}">
            @isset($post)
                @foreach($post->tags as $tag)
                    <option value="{{$tag->name}}" selected="selected">{{$tag->name}}</option>
                @endforeach
            @endisset
        </select>
    </div>

    <div class="line line-dashed b-b line-lg"></div>
    <div class="form-group">
        <label class="control-label">{{trans('platform::post/base.show_in_categories')}}</label>
        <select name="category[]" multiple data-placeholder="{{trans('platform::post/base.select_category')}}"
                class="select2 form-control">
            @foreach($category as  $value)
                <option value="{{$value->id}}"
                        @if($value->active) selected @endif >
                    {{$value->term->getContent('name')}}</option>
            @endforeach
        </select>
    </div>
</div>


<script>

</script>
