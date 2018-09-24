<div class="form-group">
    @isset($title)
        <label for="{{$id}}">{{$title}}
            @if(isset($attributes['required']) && $attributes['required'])<span class="text-danger">*</span>@endif
        </label>
    @endisset

    {{$slot}}

    @if($errors->has($oldName))
        <div class="invalid-feedback d-block">
            <small>{{$errors->first($oldName)}}</small>
        </div>
    @elseif(isset($help))
        <small class="form-text text-muted">{{$help}}</small>
    @endif
</div>
@if($hr ?? true)
    <div class="line line-dashed b-b line-lg"></div>
@endif