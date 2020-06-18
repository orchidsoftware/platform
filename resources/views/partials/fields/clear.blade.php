<div class="">
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
