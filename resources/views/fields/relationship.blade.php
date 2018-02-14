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
                return '{{route('dashboard.systems.widget',Base64Url\Base64Url::encode($handler))}}';
            },
            dataType: 'json'
        },
        selectOnClose: true,
        placeholder: '{{$placeholder or ''}}'
    });

    @if(!is_null($value))
        axios.post('{{route('dashboard.systems.widget',[
                    'widget' => Base64Url\Base64Url::encode($handler),
                    'key'    => $value
                ])}}').then(function (response) {

            var selected = response.data;
            selected = selected[Object.keys(selected)[0]];

            $('#{{$id}}')
                .append(new Option(selected.text, selected.id, true, true))
                .trigger('change');
        });
    @endif
});
</script>
@endpush
