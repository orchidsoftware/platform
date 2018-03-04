<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">
    @isset($title)
        <label for="{{$id}}">{{$title}}
            @if(isset($attributes['required']) && $attributes['required'])<span class="text-danger">*</span>@endif
        </label>
    @endisset

    {{$slot}}

    @isset($help)
        <p class="form-text text-muted">{{$help}}</p>
    @endif
</div>
@if($show ?? true)
        <div class="line line-dashed b-b line-lg"></div>
@endif



{{-- @include('dashboard::partials.fields.hr', ['show' => $hr ?? true]) --}}
