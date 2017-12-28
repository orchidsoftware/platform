<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif
    <div id="ace-code-block-{{$id}}" style="width: 100%; min-height: 500px;"></div>
    <input type="hidden" class="form-control {{$class or ''}}" id="{{$id}}"
           name="{{$fieldName}}"
           value="{{$value or old($name)}}"
           placeholder="{{$placeholder or ''}}">
    @if(isset($help))
        <p class="form-text text-muted">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>
@push('scripts')
    <script>
    $(function () {
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
