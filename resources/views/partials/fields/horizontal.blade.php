<div class="form-group row">
    @isset($title)
        <label for="{{$id}}" class="col-sm-2">{{$title}}

            @includeWhen(isset($popover),'platform::partials.fields.popover',[
                'content' => $popover ?? ''
            ])

            @if(isset($attributes['required']) && $attributes['required'])
                <span class="text-danger">*</span>
            @endif
        </label>
    @endisset

    <div class="col">
        {{$slot}}
    </div>


    @if($errors->has($oldName))
        <div class="col-sm-5">
            <div class="invalid-feedback d-block">
                <small>{{$errors->first($oldName)}}</small>
            </div>
        </div>
    @elseif(isset($help))
        <div class="col-sm-5">
            <small class="form-text text-muted">{!!$help!!}</small>
        </div>
    @endif
</div>
@isset($hr)
    <div class="line line-dashed b-b line-lg"></div>
@endisset

