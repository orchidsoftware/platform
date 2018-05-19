@component('platform::partials.fields.group',get_defined_vars())
	<select @include('platform::partials.fields.attributes', ['attributes' => $attributes])>
	@isset($value)
		@foreach(explode(",",$value) as $tag)
			<option value="{{$tag}}" selected="selected">{{$tag}}</option>
		@endforeach
	@endisset
	</select>	   
@endcomponent

<script>
    document.addEventListener('turbolinks:load', function () {
        $('.select2-tags').select2({
            templateResult: function formatState(state) {
                if (!state.id || !state.count) {
                    return state.text;
                }

                var str = '<span>' + state.text + '</span>' + ' <span class="pull-right badge bg-info">' + state.count + '</span>';

                return $(str);
            },
            createTag: function (tag) {
                return {
                    id: tag.term,
                    text: tag.term,
                };
            },
            escapeMarkup: function (m) {
                return m;
            },
            width: '100%',
            tags: true,
            cache: true,
            ajax: {
                url: function (params) {
                    return platform.prefix('/systems/tags/' + params.term);
                },
                delay: 250,
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                }
            }
        });
    });
</script>