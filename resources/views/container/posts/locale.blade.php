@if($locales->count() > 1)
    @foreach($locales->chunk(2) as $groups)
        <div class="row">
            @foreach($groups as $key => $locale)
                <div class="col-md-6">
                    <div class="line line-dashed b-b line-lg"></div>
                    <div class="form-group row align-items-center m-b-xs">
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
                </div>
            @endforeach
        </div>
    @endforeach
@else
    @foreach($locales as $key => $locale)
        <input type="hidden" name="options[locale][{{$key}}]"
               value="true">
    @endforeach
@endif