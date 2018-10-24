@if($locales->count() > 1)
    @foreach($locales->chunk(2) as $groups)
        @foreach($groups as $key => $locale)
            <div class="form-group align-items-center m-b-xs">
                @if(!is_null($post))
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox"
                               class="custom-control-input"
                               id="options-locale-{{$key}}"
                               name="options[locale][{{$key}}]"
                                {{$post->checkLanguage($key) ? 'checked' : ''}}
                        >
                        <label class="custom-control-label" for="options-locale-{{$key}}">
                            {{$locale['native']}}
                        </label>
                    </div>
                @else
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox"
                               class="custom-control-input"
                               id="options-locale-{{$key}}"
                               name="options[locale][{{$key}}]"
                               value="true" @if ($loop->first) checked @endif
                        >
                        <label class="custom-control-label" for="options-locale-{{$key}}">
                            {{$locale['native']}}
                        </label>
                    </div>
                @endif
            </div>
        @endforeach
    @endforeach
@else
    @foreach($locales as $key => $locale)
        <input type="hidden" name="options[locale][{{$key}}]"
               value="true">
    @endforeach
@endif