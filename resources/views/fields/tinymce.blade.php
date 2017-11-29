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
$(function () {
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
        image_class_list: [
            {title: 'None', value: ''},
            {title: 'Responsive', value: 'img-responsive'},
        ],
        // without images_upload_url set, Upload tab won't show up
        //images_upload_url: 'postAcceptor.php',

        setup: function (ed) {
            ed.on('change', function (e) {
                $('#field-{{$lang}}-{{$slug}}').val(ed.getContent());
            });
        },
        // we override default upload handler to simulate successful upload
        images_upload_handler: function (blobInfo, success, failure) {

            let data = new FormData();
            data.append('file', blobInfo.blob());

            axios.post('/dashboard/systems/files', data)
                .then(function (response) {
                    success('/storage/' + response.data.path + response.data.name + '.' + response.data.extension,);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },


    });
});
</script>

















