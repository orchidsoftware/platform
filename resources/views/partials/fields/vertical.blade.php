<div class="form-group">
    @isset($title)
        <label for="{{$id}}">{{$title}}


            @includeWhen(isset($popover),'platform::partials.fields.popover',[
                'content' => $popover ?? ''
            ])

            @if(isset($attributes['required']) && $attributes['required'])
                <span class="text-danger m-l-xs">*</span>
            @endif
        </label>
    @endisset

    {{$slot}}

    @if($errors->has($oldName))
        <div class="invalid-feedback d-block">
            <small>{{$errors->first($oldName)}}</small>
        </div>
    @elseif(isset($help))
        <small class="form-text text-muted">{!!$help!!}</small>
    @endif
</div>
@isset($hr)
    <div class="line line-dashed b-b line-lg"></div>
@endisset
