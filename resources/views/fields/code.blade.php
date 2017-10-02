<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="field-{{$lang}}-{{$slug}}">{{$title}}</label>
    @endif
    <div id="ace-code-block-{{$lang}}-{{$slug}}" style="width: 100%; min-height: 300px;"></div>
    <input type="hidden" class="form-control {{$class or ''}}" id="field-{{$lang}}-{{$slug}}"
           @if(isset($prefix))
           name="{{$prefix}}[{{$lang}}]{{$name}}"
           @else
           name="{{$lang}}{{$name}}"
           @endif
           value="{{$value or old($name)}}"
           placeholder="{{$placeholder or ''}}">
    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>
@push('scripts')
<script>
    $(function () {
        var editor{{$lang}}{{$slug}} = ace.edit('ace-code-block-{{$lang}}-{{$slug}}');
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
