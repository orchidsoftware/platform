<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">

    @if(isset($title))
        <label for="field-{{$name}}">{{$title}}</label>
    @endif

	<textarea class="simplemde-{{$lang}}-{{$slug}} hidden" 
		@if(isset($prefix))
			name="{{$prefix}}[{{$lang}}]{{$name}}"
		@else
			name="{{$lang}}{{$name}}"
		@endif 
		>{{ $value or old($name) }}</textarea>
	

    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>

<script>
$(function () {
	var simplemde = new SimpleMDE({
		element: $(".simplemde-{{$lang}}-{{$slug}}")[0],
		toolbar: ["bold", "italic", "heading", "|", "quote", "code", "unordered-list", "ordered-list", 
		"|", "link","image", "table","|","preview","side-by-side","fullscreen","|", "horizontal-rule","guide"],
		autosave: {
			enabled: false,
			uniqueId: "AutoSave-{{$prefix}}[{{$lang}}]{{$name}}",
			delay: 10000,
		},
		placeholder: "{{$placeholder or ''}}",
	});

});
</script>
