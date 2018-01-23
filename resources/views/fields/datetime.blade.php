<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif
    <div class='input-group date datetimepicker'>
        <input @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])
               data-date-format="{{$format or "YYYY-MM-DD HH:mm:ss"}}"
        >

        <span class="input-group-addon input-group-btn">
            <span class="btn btn-default"><i class="icon-calendar" aria-hidden="true"></i></span>
        </span>

    </div>
    @if(isset($help))
        <p class="form-text text-muted">{{$help}}</p>
    @endif
</div>
@include('dashboard::partials.fields.hr', ['show' => $hr ?? true])
