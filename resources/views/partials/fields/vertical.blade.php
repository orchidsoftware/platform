<div class="mb-3">
    @isset($title)
        <label for="{{$id}}" class="form-label">{{$title}}
            @if(isset($attributes['required']) && $attributes['required'])
                <sup class="text-danger">*</sup>
            @endif
            @includeWhen(isset($popover),'platform::partials.fields.popover',[
                'content' => $popover ?? ''
            ])
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
    <div class="line line-dashed border-bottom line-lg"></div>
@endisset
