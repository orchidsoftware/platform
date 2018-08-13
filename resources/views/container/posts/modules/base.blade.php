<div class="wrapper-md">
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