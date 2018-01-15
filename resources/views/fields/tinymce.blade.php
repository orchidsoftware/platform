<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">

     @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif

    <div class="tinymce-{{$id}} b wrapper" style="min-height: 500px">
      {!! $value !!}
    </div>

     <input type="hidden" @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])>

    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
@include('dashboard::partials.fields.hr', ['show' => $hr ?? true])

@push('scripts')
    <script>
$(function () {
    dashboard.fields.tinymce.init('{{$id}}');
});
</script>
@endpush
















