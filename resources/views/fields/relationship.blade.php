<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="field-{{$slug}}">{{$title}}</label>
    @endif
    <select class="form-control {{$class or ''}}"
            id="field-{{$slug}}"
            @if(isset($prefix))
            name="{{$prefix}}[{{$lang}}]{{$name}}"
            @else
            name="{{$lang}}{{$name}}"
            @endif
    >
    </select>
    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>


<script>
$(function() {
    $('#field-{{$slug}}').select2({
        ajax: {
            type: "POST",
            cache: true,
            delay: 250,
            url: function (params) {
                return '{{route('dashboard.systems.widget',urlencode($handler))}}';
            },
            dataType: 'json'
        },
        placeholder: 'Search for a repository',
        placeholder2: '{{$placeholder or ''}}'
    });
});
</script>
