<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">

     @if(isset($title))
        <label for="field-{{$name}}">{{$title}}</label>
    @endif

    <div class="tinymce-{{$lang}}-{{$slug}} b wrapper" style="min-height: 500px">
      {!! $value or old($name) !!}
    </div>

             <input id="field-{{$lang}}-{{$slug}}" type="hidden"
                    @if(isset($prefix))
                    name="{{$prefix}}[{{$lang}}]{{$name}}"
                    @else
                    name="{{$lang}}{{$name}}"
                    @endif
                    placeholder="{{$placeholder or ''}}"
                    value="{{ $value or old($name) }}">

  @if(isset($help))
    <p class="help-block">{{$help}}</p>
  @endif
</div>
<div class="line line-dashed b-b line-lg"></div>


<script>
    tinymce.init({
        selector: '.tinymce-{{$lang}}-{{$slug}}',
        theme: 'inlite',
        min_height: 600,
        //language: 'ru',
        plugins: 'image media table link paste contextmenu textpattern autolink codesample',
        insert_toolbar: 'quickimage quicktable media codesample fullscreen',
        selection_toolbar: 'bold italic | quicklink h2 h3 blockquote | alignleft aligncenter alignright alignjustify | outdent indent | removeformat ',
        inline: true,
        convert_urls: false,
        image_caption: true,
        image_title: true,

        // without images_upload_url set, Upload tab won't show up
        images_upload_url: 'postAcceptor.php',

        setup:function(ed) {
            ed.on('change', function(e) {
                $('#field-{{$lang}}-{{$slug}}').val(ed.getContent());
            });
        },
        // we override default upload handler to simulate successful upload
        images_upload_handler: function (blobInfo, success, failure) {
            setTimeout(function() {
                // no matter what you upload, we will turn it into TinyMCE logo :)
                success('http://moxiecode.cachefly.net/tinymce/v9/images/logo.png');
            }, 2000);
        },


    });
</script>

















