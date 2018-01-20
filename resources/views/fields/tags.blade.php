<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif
    <input @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])
           data-role="tagsinput">
    @if(isset($help))
        <p class="form-text text-muted">{{$help}}</p>
    @endif
</div>
@include('dashboard::partials.fields.hr', ['show' => $hr ?? true])
