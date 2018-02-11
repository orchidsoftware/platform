<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="field-{{$slug}}">{{$title}}</label>
    @endif
    <select @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])></select>
    @if(isset($help))
        <p class="form-text text-muted">{{$help}}</p>
    @endif
</div>
@include('dashboard::partials.fields.hr', ['show' => $hr ?? true])

@push('scripts')
    <script>
$(function () {
    $('#{{$id}}').select2({
        theme: "bootstrap",
        ajax: {
            type: "POST",
            cache: true,
            delay: 250,
            url: function (params) {
                return '{{route('dashboard.systems.widget',urlencode($handler))}}';
            },
            dataType: 'json'
        },
        selectOnClose: true,
        placeholder: '{{$placeholder or ''}}'
    });

    axios.post('{{route('dashboard.systems.widget',[
            'widget' => urlencode($handler),
            'key'    => $value
        ])}}').then(function (data) {

        $('#{{$id}}')
            .append(new Option(data.text, data.id, true, true))
            .append('<option value="'+selected.id+'" selected="selected">'+selected.text+'</option>')
            .trigger('change');
    });
});
</script>
@endpush
