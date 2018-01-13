<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="field-{{$slug}}">{{$title}}</label>
    @endif


    <div class="picture-container m-b-md">
        @if(isset($attributes['value']) && strlen($attributes['value']))
        <img src="{{$attributes['value']}}" class="img-responsive img-thumbnail" alt=""/>
        @endif
    </div>

    <div class="picture-actions">
            <label class="btn btn-info">
                Browse <input type="file" class="picture-input-file-{{$lang}}-{{$slug}} hidden">
            </label>
            <button type="button" class="btn btn-danger picture-action-remove">Remove</button>
    </div>
    <input class="picture-path"
           type="hidden"
           data-width="{{$width}}"
           data-height="{{$height}}"
            @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])
    >
</div>


<div id="picture-crop-modal-{{$lang}}-{{$slug}}" class="modal" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content-wrapper">
         <div class="modal-content">
            <div class="modal-header clearfix text-left">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
               <i class="fa fa-times"></i>
               </button>
               <h5>Crop image</h5>
            </div>
            <div class="modal-body">
               <div class="upload-panel"></div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-success crop">Crop</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
</div>


@push('scripts')
    <script>
$(function () {

    var $cropPanel = $('#picture-crop-modal-{{$lang}}-{{$slug}} .upload-panel');
    var $formGroup;

    $('.picture-input-file-{{$lang}}-{{$slug}}').on('change', function () {
        $formGroup = $(this).parents('.form-group');

        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#picture-crop-modal-{{$lang}}-{{$slug}}').modal();

                $cropPanel.croppie({
                    viewport: {
                        width: $formGroup.find('.picture-path').data('width'),
                        height: $formGroup.find('.picture-path').data('height')
                    },
                    boundary: {
                        width: '100%',
                        height: 500
                    },
                    enforceBoundary: true
                });

                $cropPanel.croppie('bind', {
                    url: e.target.result
                });
            };

            reader.readAsDataURL(this.files[0]);
        }
    });

    $('.picture-action-remove').click(function () {
        var $group = $(this).parents('.form-group');

        $group.find('.picture-path').val('');
        $group.find('.picture-container').html('');

        return false;
    });

    $('#picture-crop-modal-{{$lang}}-{{$slug}}').on('hidden.bs.modal', function () {
        $cropPanel.croppie('destroy');
    });

    $('#picture-crop-modal-{{$lang}}-{{$slug}} .crop').on('click', function (ev) {
        $cropPanel.croppie('result', {
            type: 'blob',
            size: 'viewport',
            format: '{{$format ?? 'png'}}'
        }).then(function (blob) {

            let data = new FormData();
            data.append('file', blob);
            data.append('storage', '{{$storage??'public'}}');

            axios.post(dashboard.prefix('/systems/files'), data)
                .then(function (response) {

                    let image = '/storage/' + response.data.path + response.data.name + '.' + response.data.extension;

                    $formGroup.find('.picture-container')
                        .html('<img src="' + image + '" class="img-responsive img-thumbnail" alt="" />');

                    $formGroup.find('.picture-path').val(image);

                    $('#picture-crop-modal-{{$lang}}-{{$slug}}').modal('hide');
                    $formGroup.find('.picture-input-file-{{$lang}}-{{$slug}}').value = '';
                })
                .catch(function (error) {
                    if ('message' in error.response.data) {
                        if ('alert' in dashboard) {
                            dashboard.alert(error.response.data.message);
                        }
                    }
                    console.log(error);
                });


        });
    });
});
</script>
@endpush
