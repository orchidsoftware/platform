@component('dashboard::partials.fields.group',get_defined_vars())
    <select id="{{$id}}" @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])></select>
@endcomponent



@push('scripts')
    <script>
        document.addEventListener('turbolinks:load', function () {
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
