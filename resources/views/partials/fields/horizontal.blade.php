<div class="form-group row">
    @isset($title)
        <label for="{{$id}}" class="col-sm-2 v-center">{{$title}}

            @includeWhen(isset($popover),'platform::partials.fields.popover',[
                'content' => $popover ?? ''
            ])

            @if(isset($attributes['required']) && $attributes['required'])
                <span class="text-danger m-l-xs">*</span>
            @endif
        </label>
    @endisset

    <div class="col">
        {{$slot}}

        @if($errors->has($oldName))
            <div class="invalid-feedback d-block">
                <small>{{$errors->first($oldName)}}</small>
            </div>
        @elseif(isset($help))
            <small class="form-text text-muted">{{$help}}</small>
        @endif

    </div>
</div>
@isset($hr)
    <div class="line line-dashed b-b line-lg"></div>
@endisset

