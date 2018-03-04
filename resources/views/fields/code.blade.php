@component('dashboard::partials.fields.group',get_defined_vars())
    <div id="ace-code-block-{{$id}}" style="width: 100%; min-height: 500px;"></div>
    <input @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])>
@endcomponent


@push('scripts')
    <script>
    document.addEventListener('turbolinks:load', function() {
        var editor{{$lang}}{{$slug}} = ace.edit('ace-code-block-{{$id}}');
        editor{{$lang}}{{$slug}}.getSession().setMode('ace/mode/javascript');
        editor{{$lang}}{{$slug}}.setTheme('ace/theme/monokai');
        editor{{$lang}}{{$slug}}.getSession().setUseWorker(false);

        var input{{$lang}}{{$slug}} = $('#field-{{$lang}}-{{$slug}}');
        editor{{$lang}}{{$slug}}.getSession().setValue(input{{$lang}}{{$slug}}.val());
        editor{{$lang}}{{$slug}}.getSession().on('change', function () {
            input{{$lang}}{{$slug}}.val(editor{{$lang}}{{$slug}}.getSession().getValue());
        });
    });
</script>
@endpush
