<div class="form-group row">
    @isset($title)
        <label for="{{$id}}" class="col-sm-2 text-wrap mt-2 form-label">
            {{$title}}

            @includeWhen(isset($popover),'platform::partials.fields.popover',[
                'content' => $popover ?? ''
            ])

            @if(isset($attributes['required']) && $attributes['required'])
                <sup class="text-danger">*</sup>
            @endif
        </label>
    @endisset

    <div class="col" style="max-width: 440px;">
        {{$slot}}

        @if($errors->has($oldName))
            <div class="invalid-feedback d-block">
                <small>{{$errors->first($oldName)}}</small>
            </div>
        @elseif(isset($help))
            <small class="form-text text-muted">{!!$help!!}</small>
        @endif
    </div>
</div>

@isset($hr)
    <div class="line line-dashed border-bottom line-lg"></div>
@endisset
