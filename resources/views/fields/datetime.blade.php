<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif
    <div class='input-group date datetimepicker'>
        <input @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])
               data-date-format="{{$format or "YYYY-MM-DD HH:mm:ss"}}"
        >
        <span class="input-group-addon">
        <span class="fa fa-calendar" aria-hidden="true"></span>
        </span>
    </div>
    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
@include('dashboard::partials.fields.hr', ['show' => $hr ?? true])
