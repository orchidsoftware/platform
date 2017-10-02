<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="field-{{$name}}">{{$title}}</label>
    @endif
    <textarea class="form-control no-resize summernote {{$class or ''}}" id="field-{{$lang}}-{{$slug}}"
              rows={{$rows or ''}}
              @if(isset($prefix))
                      name="{{$prefix}}[{{$lang}}]{{$name}}"
              @else
              name="{{$lang}}{{$name}}"
              @endif
              placeholder="{{$placeholder or ''}}"
    >{!! $value or old($name) !!}</textarea>
    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>


<script src="/orchid/summernote/summernote.min.js"></script>
<script>
    $(document).ready(function () {

        $('.summernote').summernote({
            minHeight: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video', 'media']],
                ['view', ['fullscreen', 'codeview', 'undo', 'redo',]]
            ]
        });
    });


</script>
