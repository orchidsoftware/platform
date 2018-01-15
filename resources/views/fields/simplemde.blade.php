<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">

    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif


    <div class="simplemde-wrapper">

	<input @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])>
	</div>

    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
@include('dashboard::partials.fields.hr', ['show' => $hr ?? true])

@push('scripts')
    <script>
$(function () {
    dashboard.fields.simplemde.init("{{$id}}","{{$placeholder or ''}}");
});
</script>
@endpush
