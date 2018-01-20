<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }} input-sort">
    <label>{{$title}}</label>
   <ul id="sortable-{{$slug}}" class="container-fluid dd-list">

       @if(!isset($value) || is_null($value))
           <li class="ui-state-default form-group row">
                   <span onclick="return false;" class="btn btn-link col-1 pull"><i class="fa-bars fa"></i></span>
                   <input type="text" class="form-control col-10"
                          @if(isset($prefix))
                          name="{{$prefix}}[{{$lang}}]{{$name}}[0]"
                          @else
                          name="{{$lang}}{{$name}}[0]"
                           @endif
                   >
                   <button class="btn btn-link col-1 remove"
                           onclick="removeitem{{$slug}}(this)"><i class="icon-trash"></i></button>
               </li>
       @else
           @foreach($value as $key => $val)
               <li class="ui-state-default form-group row">
                    <span onclick="return false;" class="btn btn-link col-1 pull"><i class="fa-bars fa"></i></span>
                    <input type="text" class="form-control col-10"
                           @if(isset($prefix))
                           name="{{$prefix}}[{{$lang}}]{{$name}}[0]"
                           @else
                           name="{{$lang}}{{$name}}[{{$key}}]"
                           @endif
                           value="{{$val}}">
                    <button class="btn btn-link col-1 remove"
                            onclick="removeitem{{$slug}}(this)"><i class="icon-trash"></i></button>
                </li>
           @endforeach
       @endif
    </ul>
    <div class="button-group text-center">
        <button onclick="newitem{{$slug}}()" class="btn btn-sm alert-info">new</button>
    </div>
</div>
@include('dashboard::partials.fields.hr', ['show' => $hr ?? true])
<style>
    .input-sort .form-control {
        width : 83.33333333%;
    }
</style>
@push('scripts')
    <script>
    function newitem{{$slug}}() {
        event.preventDefault();
        let item = '<li class="ui-state-default form-group row">\n' +
            '            <span onclick="return false;" class="btn btn-link col-1 pull"><i class="fa-bars fa"></i></span>\n' +
            '            <input type="text" class="form-control col-10" name="" value="">\n' +
            '            <button class="btn btn-link col-1 remove" onclick="removeitem{{$slug}}(this)"><i class="icon-trash"></i></button>\n' +
            '        </li>';
        $('#sortable-{{$slug}}').append(item);
        $("#sortable-{{$slug}} li").each(function (li) {
            $(this).find('input').attr({'name': '{{$prefix}}[{{$lang}}][{{$slug}}][' + li + ']'})
        })
    }

    function removeitem{{$slug}}(item) {
        event.preventDefault();
        $(item).parent().remove();

        $("#sortable-{{$slug}} li").each(function (li) {
            $(this).find('input').attr({'name': '{{$prefix}}[{{$lang}}][{{$slug}}][' + li + ']'})
        })
    }

    $(function () {
        $("#sortable-{{$slug}}").sortable({
            placeholder: "ui-sortable-placeholder",
            axis: "y",
            update: function (event, ui) {
                $("#sortable-{{$slug}} li").each(function (li) {
                    $(this).find('input').attr({'name': '{{$prefix}}[{{$lang}}][{{$slug}}][' + li + ']'})
                })
            }
        });
    });
</script>
@endpush
