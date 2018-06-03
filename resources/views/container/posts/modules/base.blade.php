<div class="wrapper-md">
    @if(!empty($type->views))
        <div class="form-group">
            <label>{{trans('platform::post/base.view')}}</label>
            <select name="options[view]" class="form-control">
                @foreach($type->views as $key => $value)
                    <option value="{{$key}}"
                            @if(!is_null($post) && $post->getOption('view') == $key) selected @endif >
                        {{$value}}</option>
                @endforeach
            </select>
        </div>
        <div class="line line-dashed b-b line-lg"></div>
    @endif

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

    @isset($author)
        <div class="line line-dashed b-b line-lg"></div>
        <p>
            {{trans('platform::post/base.author')}}: <i title="{{$author->email or ''}}">{{$author->name or ''}}</i>
        </p>
    @endisset
    @isset($post)
        <div class="line line-dashed b-b line-lg"></div>
        <p>
            {{trans('platform::post/base.changed')}}: <span
                    title="{{$post->updated_at}}">{{$post->updated_at->diffForHumans()}}</span>
        </p>
    @endisset
    @if(count($locales) > 1)
        @foreach($locales as $key => $locale)
            <div class="line line-dashed b-b line-lg"></div>
            <div class="form-group row align-items-center">
                <label class="col-6 control-label mb-0">{{$locale['native']}}</label>
                <div class="col-6">
                    @if(!is_null($post))
                        <label class="i-switch bg-info m-t-xs m-r">
                            <input type="checkbox" name="options[locale][{{$key}}]"
                                   value="true" {{$post->checkLanguage($key)  ? 'checked' : ''}}>
                            <i></i>
                        </label>
                    @else
                        <label class="i-switch bg-info m-t-xs m-r">
                            <input type="checkbox" name="options[locale][{{$key}}]"
                                   value="true" @if ($loop->first) checked @endif>
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


<script>
    document.addEventListener('turbolinks:load', () => {
        $('.select2-tags').select2({
            templateResult: function formatState(state) {
                if (!state.id || !state.count) {
                    return state.text;
                }

                const str = `<span>${state.text}</span> <span class="pull-right badge bg-info">${state.count}</span>`;

                return $(str);
            },
            createTag(tag) {
                return {
                    id: tag.term,
                    text: tag.term,
                };
            },
            escapeMarkup(m) {
                return m;
            },
            width: '100%',
            tags: true,
            cache: true,
            ajax: {
                url(params) {
                    return platform.prefix(`/systems/tags/${params.term}`);
                },
                delay: 250,
                processResults(data) {
                    return {
                        results: data
                    };
                }
            }
        });
    });
</script>
