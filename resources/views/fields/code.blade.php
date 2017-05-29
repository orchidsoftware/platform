<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="field-{{$slug}}">{{$title}}</label>
    @endif
    <div id="ace-code-block-{{$slug}}" style="width: 100%; min-height: 300px;"></div>
    <input type="hidden" class="form-control {{$class or ''}}" id="field-{{$slug}}"
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
        var editor{{$slug}} = ace.edit('ace-code-block-{{$slug}}');
        editor{{$slug}}.getSession().setMode('ace/mode/javascript');
        editor{{$slug}}.setTheme('ace/theme/monokai');

        var input{{$slug}} = $('#field-{{$slug}}');
        editor{{$slug}}.getSession().setValue(input{{$slug}}.val());
        editor{{$slug}}.getSession().on('change', function () {
            input{{$slug}}.val(editor{{$slug}}.getSession().getValue());
        });

    });
</script>
@endpush
